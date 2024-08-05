<?php

use Thimoo\PostfinanceCheckoutFlex\CheckoutFlexGateway;

/*
 * Plugin Name: PostFinance Checkout Flex Gateway GiveWP
 * Plugin URI: https://github.com/compassionCH/wp-plugins/postfinance-gateway-givewp
 * Description: GiveWP gateway add-on compatible with PostFinance Checkout Flex platform.
 * Version: 1.0.0
 * Requires at least: 6.5.2
 * Requires PHP: 7.4
 * Author: Thimoo Sàrl <web@thimoo.ch>
 * Author URI: https://thimoo.ch
 * License: Apache License 2.0
 * License URI: https://opensource.org/licenses/Apache-2.0
 * Text Domain: postfinance-gateway-givewp
 * Domain Path: /languages
 * Requires Plugins: give/give.php
 */

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

require_once __DIR__.'/php-sdk/autoload.php';
require_once __DIR__.'/src/CheckoutFlexGateway.php';

// Register the gateway
add_action('givewp_register_payment_gateway', static function ($paymentGatewayRegister) {
    $paymentGatewayRegister->registerGateway(Thimoo\PostfinanceCheckoutFlex\CheckoutFlexGateway::class);
});

add_action('givewp_odoo_sync', 'givewp_sync_donations_with_odoo');
function givewp_sync_donations_with_odoo()
{
    error_log('postfinance-gateway-givewp: odoo sync launched');
    $gateway = new CheckoutFlexGateway();
    $gateway->sendNonSyncedDonationsToOdoo();
}

if (! wp_next_scheduled('givewp_odoo_sync')) {
    wp_schedule_event(time(), 'hourly', 'givewp_odoo_sync');
}
