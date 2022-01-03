<?php

declare(strict_types=1);

// header('Content-Type: image/svg+xml');
use Sprain\SwissQrBill as QrBill;

require __DIR__ . '/../vendor/autoload.php';

$qrData_default = [
    'debtor' => [
        'name' => ' ',
        'street' => ' ',
        'no' => ' ',
        'zip' => ' ',
        'city' => ' ',
        'country' => 'CH',
    ],
    'amount' => 1,
    'additional_informations' => ' ',
    'language' => 'en',
];


$qrData_input = json_decode(file_get_contents('php://input'), true);

if ($qrData_input==null) {
    $qrData_input = $qrData_default;
}


$qrData = array_replace_recursive($qrData_default, $qrData_input);


$qrData_fix = [
    'iban' => 'CH24 3080 8007 6814 3434 7',
    'creditor' => [
        'name' => 'Compassion Suisse',
        'street' => 'Rue Galilée',
        'no' => '3',
        'zip' => '1400',
        'city' => 'Yverdon-les-Bains',
        'country' => 'CH',
    ],
    'currency' => 'CHF',
    'reference' => '00 00000 00151 08940 00006 00243',
];

$qrData = array_replace_recursive($qrData, $qrData_fix);

$qrBill = QrBill\QrBill::create();

$qrBill->setCreditorInformation(
    QrBill\DataGroup\Element\CreditorInformation::create(
        $qrData['iban']
    )
);

$qrBill->setCreditor(
    QrBill\DataGroup\Element\StructuredAddress::createWithStreet(
        $qrData['creditor']['name'],
        $qrData['creditor']['street'],
        $qrData['creditor']['no'],
        $qrData['creditor']['zip'],
        $qrData['creditor']['city'],
        $qrData['creditor']['country']
    )
);

$qrBill->setUltimateDebtor(
    QrBill\DataGroup\Element\StructuredAddress::createWithStreet(
        $qrData["debtor"]["name"],
        $qrData["debtor"]["street"],
        $qrData["debtor"]["no"],
        $qrData["debtor"]["zip"],
        $qrData["debtor"]["city"],
        $qrData["debtor"]["country"]
    )
);

$qrBill->setPaymentAmountInformation(
    QrBill\DataGroup\Element\PaymentAmountInformation::create(
        $qrData["currency"],
        $qrData["amount"]
    )
);


$qrBill->setPaymentReference(
    QrBill\DataGroup\Element\PaymentReference::create(
        QrBill\DataGroup\Element\PaymentReference::TYPE_QR,
        $qrData["reference"]
    )
);

$qrBill->setAdditionalInformation(
    QrBill\DataGroup\Element\AdditionalInformation::create(
        $qrData["additional_informations"]
    )
);

$path = tempnam("/tmp", "qr_").".svg";

try {
    $qrBill->getQrCode()->writeFile($path);
    $qr_code = file_get_contents($path);
    unlink($path);

    $qrData['img'] = 'data:image/svg+xml;base64,'.base64_encode($qr_code);
    $qrData['amount'] = number_format($qrData['amount'], 2);

    $qrLang = include "bill_i18n.php";
    include "bill.php";
} catch (Exception $e) {
    echo "error: ".$e;
}
