<?php
/*
Plugin Name: Interswitch Payment Gateway
Plugin URI: https://yourwebsite.com/interswitch-gateway
Description: WooCommerce payment gateway integration for Interswitch East Africa
Version: 1.0.0
Author: Henry Nkuke
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Ensure WooCommerce is active
add_action('plugins_loaded', 'init_interswitch_gateway', 11);

function init_interswitch_gateway() {
    if (!class_exists('WC_Payment_Gateway')) {
        return; // Exit if WooCommerce is not active
    }

    // Add the gateway to WooCommerce
    add_filter('woocommerce_payment_gateways', 'add_interswitch_gateway');
    function add_interswitch_gateway($gateways) {
        $gateways[] = 'WC_Interswitch_Gateway';
        error_log('Interswitch Gateway added to WooCommerce');
        return $gateways;
    }

    // Include the gateway class
    require_once plugin_dir_path(__FILE__) . 'includes/class-wc-interswitch-gateway.php';

    // Ensure the assets directory exists
    if (!file_exists(plugin_dir_path(__FILE__) . 'assets/images/')) {
        mkdir(plugin_dir_path(__FILE__) . 'assets/images/', 0755, true);
    }
} 