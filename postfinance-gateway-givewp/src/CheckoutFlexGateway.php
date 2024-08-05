<?php

namespace Thimoo\PostfinanceCheckoutFlex;

use Give\Donations\Models\Donation;
use Give\Donations\ValueObjects\DonationStatus;
use Give\Framework\Http\Response\Types\RedirectResponse;
use Give\Framework\PaymentGateways\Commands\PaymentRefunded;
use Give\Framework\PaymentGateways\Commands\RedirectOffsite;
use Give\Framework\PaymentGateways\PaymentGateway;
use PostFinanceCheckout\Sdk\ApiClient;
use PostFinanceCheckout\Sdk\Model\AddressCreate;
use PostFinanceCheckout\Sdk\Model\LineItemCreate;
use PostFinanceCheckout\Sdk\Model\LineItemType;
use PostFinanceCheckout\Sdk\Model\TransactionCreate;

// NOTE: https://github.com/impress-org/givewp-example-gateway/blob/master/class-offsite-example-gateway.php

class CheckoutFlexGateway extends PaymentGateway
{
    private int $spaceId;

    private int $clientId;

    private string $secret;

    public $secureRouteMethods = [
        'handleCreatePaymentRedirect',
    ];

    public function __construct()
    {
        $this->spaceId = GIVEWP_POSTFINANCE_SPACE_ID;
        $this->userId = GIVEWP_POSTFINANCE_USER_ID;
        $this->secret = GIVEWP_POSTFINANCE_SECRET;
        if (isset($_GET['utm_source'])) {
            setcookie('pfgg_utm_source', $_GET['utm_source']);
        }
        if (isset($_GET['utm_medium'])) {
            setcookie('pfgg_utm_medium', $_GET['utm_medium']);
        }
        if (isset($_GET['utm_campaign'])) {
            setcookie('pfgg_utm_campaign', $_GET['utm_campaign']);
        }
    }

    public static function id(): string
    {
        return 'postfinance-checkout-flex';
    }

    public function getId(): string
    {
        return self::id();
    }

    public function getName(): string
    {
        return 'PostFinance Checkout Flex';
    }

    public function getPaymentMethodLabel(): string
    {
        return 'PostFinance Checkout Flex';
    }

    public function getLegacyFormFieldMarkup(int $formId, array $args): string
    {
        $lang = apply_filters('wpml_current_language', null);
        if (! in_array($lang, ['fr', 'de', 'it', 'en'])) {
            $lang = 'fr';
        }
        $paymentText = [
            'fr' => 'Paiement',
            'de' => 'Zahlung',
            'it' => 'Pagamento',
            'en' => 'Payment',
        ];

        $redirectText = [
            'fr' => 'Vous allez être redirigé sur la passerelle de paiement de PostFinance pour compléter votre donation en toute sécurité.',
            'de' => 'Sie werden nun zum Zahlungsgateway von PostFinance weitergeleitet, um Ihre Spende sicher zu vervollständigen.',
            'it' => 'Sarete reindirizzati al gateway di pagamento PostFinance per completare la vostra donazione in tutta sicurezza.',
            'en' => 'You will be redirected to the PostFinance payment gateway to complete your donation securely.',
        ];

        return "<div class='comp-give-payment'>
            <div class='give-section-break'>{$paymentText[$lang]}</div>
                <div class='comp-give-payment-images'>
                    <img src='/wp-content/plugins/postfinance-gateway-givewp/assets/Mastercard-logo-s.png' style='height:20px;'>
                    <img src='/wp-content/plugins/postfinance-gateway-givewp/assets/Visa_logo-s.png' style='height:20px;'>
                    <img src='/wp-content/plugins/postfinance-gateway-givewp/assets/twint-logo-s.png' style='height:20px;'>
                    <img src='/wp-content/plugins/postfinance-gateway-givewp/assets/postfinance-logo-s.png' style='height:20px;'>
                </div>
            </div>
            <p>
                {$redirectText[$lang]}
            </p>";
    }

    public function getParameters(Donation $donation): TransactionCreate
    {
        $billingAddress = new AddressCreate();
        $billingAddress->setEmailAddress($donation->email);
        $billingAddress->setGivenName(sprintf('%s %s', $this->clean_input($donation->firstName), $this->clean_input($donation->lastName)));

        $meta = get_post_meta($donation->id);
        $billingAddress->setStreet($meta['street_address'][0]);
        $billingAddress->setPostCode($meta['postal_code'][0]);
        $billingAddress->setCity($meta['address_level2'][0]);
        $billingAddress->setCountry($meta['country'][0]);

        $lineItem = new LineItemCreate();
        $lineItem->setName(sprintf('Compassion, donation via GiveWP, ID %s', $donation->id));
        $lineItem->setUniqueId($donation->id);
        $lineItem->setQuantity(1);
        $lineItem->setAmountIncludingTax(floatval($donation->amountInBaseCurrency()->formatToDecimal()));
        $lineItem->setType(LineItemType::PRODUCT);

        $transactionPayload = new TransactionCreate();
        $transactionPayload->setLanguage(apply_filters('wpml_current_language', null));
        $transactionPayload->setCurrency($meta['_give_payment_currency'][0]);
        $transactionPayload->setLineItems([$lineItem]);
        $transactionPayload->setAutoConfirmationEnabled(true);
        $transactionPayload->setBillingAddress($billingAddress);
        $transactionPayload->setShippingAddress($billingAddress);

        $transactionPayload->setSuccessUrl($this->generateSecureGatewayRouteUrl(
            'handleCreatePaymentRedirect',
            $donation->id,
            [
                'givewp-donation-id' => $donation->id,
                'givewp-success-url' => urlencode(give_get_success_page_uri()),
            ]
        ));

        $transactionPayload->setFailedUrl(give_get_failed_transaction_uri());

        if (isset($_COOKIE['pfgg_utm_source'])) {
            update_post_meta($donation->id, '_utm_source', $_COOKIE['pfgg_utm_source']);
            unset($_COOKIE['pfgg_utm_source']);
            setcookie('pfgg_utm_source', '', -1);
        }
        if (isset($_COOKIE['pfgg_utm_medium'])) {
            update_post_meta($donation->id, '_utm_medium', $_COOKIE['pfgg_utm_medium']);
            unset($_COOKIE['pfgg_utm_medium']);
            setcookie('pfgg_utm_medium', '', -1);
        }
        if (isset($_COOKIE['pfgg_utm_campaign'])) {
            update_post_meta($donation->id, '_utm_campaign', $_COOKIE['pfgg_utm_campaign']);
            unset($_COOKIE['pfgg_utm_campaign']);
            setcookie('pfgg_utm_campaign', '', -1);
        }

        return $transactionPayload;
    }

    public function createPayment(Donation $donation, $gatewayData): RedirectOffsite
    {
        $client = new ApiClient($this->userId, $this->secret);
        $transaction = $client->getTransactionService()->create($this->spaceId, $this->getParameters($donation));
        update_post_meta($donation->id, 'postfinance_transaction_id', $transaction->getId());
        $redirectUrl = $client->getTransactionPaymentPageService()->paymentPageUrl($this->spaceId, $transaction->getId());

        return new RedirectOffsite($redirectUrl);
    }

    /**
     * Callback used by PostFinance Checkout Flex platform after SUCCESSFUL payment.
     */
    protected function handleCreatePaymentRedirect(array $queryParams): RedirectResponse
    {
        $donationId = $queryParams['givewp-donation-id'];
        $successUrl = $queryParams['givewp-success-url'];

        $donation = Donation::find($donationId);

        // Complete donation with gateway data
        $donation->status = DonationStatus::COMPLETE();
        $donation->save();

        // error_log('handleCreatePaymentRedirect(queryParams): '.var_export($queryParams, true));
        // error_log('handleCreatePaymentRedirect(GID:'.$donationId.'): '.$successUrl);

        $this->sendDonationToOdoo($donation);

        return new RedirectResponse($successUrl);
    }

    public function refundDonation(Donation $donation): PaymentRefunded
    {
        return new PaymentRefunded();
    }

    public function sendDonationToOdoo(Donation $donation)
    {
        //
        // gather data
        //
        $meta = get_post_meta($donation->id);
        $form_url = $meta['_give_current_url'][0];
        $street = $this->clean_input($meta['street_address'][0]);
        $zip = $this->clean_input($meta['postal_code'][0]);
        $city = $this->clean_input($meta['address_level2'][0]);
        $country = $this->clean_input($meta['country'][0]);
        $utm_source = isset($meta['_utm_source']) ? $this->clean_input($meta['_utm_source'][0]) : '';
        $utm_medium = isset($meta['_utm_medium']) ? $this->clean_input($meta['_utm_medium'][0]) : '';
        $utm_campaign = isset($meta['_utm_campaign']) ? $this->clean_input($meta['_utm_campaign'][0]) : '';

        $postfinanceTransactionId = $meta['postfinance_transaction_id'][0];
        $pfClient = new ApiClient($this->userId, $this->secret);
        $paymentMethod = $pfClient->getTransactionService()->read($this->spaceId, $postfinanceTransactionId)->getPaymentConnectorConfiguration()->getPaymentMethodConfiguration()->getResolvedTitle()['fr-FR'];

        // error_log('sendDonationToOdoo(paymentMethod): '.var_export($paymentMethod, true));

        global $wpdb;
        $fund = $wpdb->get_results("select funds.title, funds.id, funds.description from {$wpdb->prefix}give_funds funds join {$wpdb->prefix}give_fund_form_relationship ffr on (funds.id = ffr.fund_id) join {$wpdb->prefix}posts p on (ffr.form_id = p.id) where ffr.form_id = {$donation->formId}");

        $fundId = $fund[0]->id;
        $fundTitle = $fund[0]->title;
        $fundDescription = trim($fund[0]->description);

        $wpml_lang = apply_filters('wpml_current_language', null);
        if ($wpml_lang == 'fr') {
            $lang = 'fr_CH';
        } elseif ($wpml_lang == 'it') {
            $lang = 'it_IT';
        } else {
            $lang = 'de_DE';
        }

        $odoo_invoice_id = [];

        try {
            $odoo_invoice_id = $this->callOdoo(
                'account.move',
                ['process_wp_confirmed_donation',
                    [
                        'name' => "{$this->clean_input($donation->firstName)} {$this->clean_input($donation->lastName)}",
                        'street' => $street,
                        'zipcode' => $zip,
                        'city' => $city,
                        'email' => $this->clean_input($donation->email),
                        'country' => $country,
                        'language' => $lang,
                        'partner_ref' => '',
                        'child_id' => '',
                        'orderid' => $form_url,
                        'amount' => floatval($donation->amountInBaseCurrency()->formatToDecimal()),
                        'time' => $donation->updatedAt->format('Y-m-d H:i:s'),
                        'fund' => $fundDescription,
                        'pf_payid' => $postfinanceTransactionId,
                        'pf_brand' => $paymentMethod,
                        'pf_pm' => $paymentMethod,
                        'utm_source' => $utm_source,
                        'utm_medium' => $utm_medium,
                        'utm_campaign' => $utm_campaign,
                    ],
                ]
            );
        } catch (\Exception $ex) {
            error_log('postfinance-gateway-givewp(sendDonationToOdoo): error while calling process_wp_confirmed_donation'.$ex->getMessage());
        }

        if (! isset($odoo_invoice_id->result)) {
            return false;
        }

        //
        // set donation meta
        //
        update_post_meta($donation->id, 'odoo_invoice_id', $odoo_invoice_id->result);
        // error_log("sendDonationToOdoo: set odoo_invoice_id meta ({$odoo_invoice_id->result}) for donation {$donation->id}");

        return true;
    }

    private function callOdoo($model, $args)
    {
        $ch = curl_init(GIVEWP_ODOO_JSONRPC_URL);
        $payload = json_encode([
            'jsonrpc' => '2.0',
            'method' => 'call',
            'params' => [
                'service' => 'object',
                'method' => 'execute',
                'args' => [GIVEWP_ODOO_DB, GIVEWP_ODOO_USER_ID, GIVEWP_ODOO_PASSWORD, $model, ...$args],
            ],
            'id' => rand(0, 1000000000),
        ]);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        // error_log("callOdoo(result): {$result}");

        $res = json_decode($result);
        if (! isset($res->id)) {
            throw new \Exception('Odoo call did not succeed');
        }

        return $res;
    }

    public function sendNonSyncedDonationsToOdoo()
    {
        // get all donations from the last 2 weeks without meta odoo_invoice_id
        global $wpdb;

        $donations_not_synced = $wpdb->get_results("SELECT cp.ID FROM {$wpdb->prefix}posts cp LEFT JOIN {$wpdb->prefix}give_donationmeta donmeta ON cp.ID = donmeta.donation_id AND donmeta.meta_key = 'odoo_invoice_id' AND donmeta.meta_value IS NOT NULL WHERE cp.post_type = 'give_payment' AND cp.post_status = 'publish' AND cp.post_modified BETWEEN (NOW() - INTERVAL 14 DAY) AND (NOW() - INTERVAL 15 MINUTE) AND donmeta.donation_id IS NULL");

        error_log('postfinance-gateway-givewp(sendNonSyncedDonationsToOdoo): '.count($donations_not_synced).' donations to sync.');
        // for each send donation to odoo
        foreach ($donations_not_synced as $donation) {
            // error_log('sendNonSyncedDonationsToOdoo(ids): '.$donation->ID);
            $give_donation = Donation::find($donation->ID);
            $this->sendDonationToOdoo($give_donation);
        }

        return true;
    }

    private function clean_input($value)
    {
        return trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
    }
}
