<?php
/**
 * Plugin Name:     WooCommerce Custom Add To Cart Label
 * Contributors: dipakparmar443
 * Plugin URI:      https://wordpress.org/plugins/ngd-custom-add-to-cart-label/
 * Description:     WooCommerce – NGD Custom "Add To Cart" labels on single product pages (per product type) and archive / shop page (per product type). 
 * Author:          Dipak Parmar
 * Author URI:      https://profiles.wordpress.org/dipakparmar443/
 * Donate link:     https://www.paypal.me/dipakparmar443/
 * Text Domain:     ngd-custom-add-to-cart-label
 * Domain Path:     /languages
 * Tested up to: 5.5
 * Version:         1.0
 * WC requires at least: 3.0
 * WC tested up to: 4.3.3
 *
 * Copyright 2019 WooCommerce
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * @package         WC_NGD_Custom_Add_To_Cart_Label
 * @ to-do : wc_ngd_custom_add_to_cart_label
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'includes/class-' . basename( __FILE__ );

/**
 * Plugin textdomain.
 */
function wc_ngd_custom_add_to_cart_label_textdomain() {
	load_plugin_textdomain( 'ngd-custom-add-to-cart-label', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'wc_ngd_custom_add_to_cart_label_textdomain' );

/**
 * Plugin activation.
 */
function wc_ngd_custom_add_to_cart_label_activation() {
	// If check pro plugin activated or not.
	if( ! class_exists( 'WooCommerce' ) ) {
		// Activate WooCommerce plguin.
		deactivate_plugins( plugin_basename( __FILE__ ) );
		// Display error message.
		wp_die( __( 'Please activate WooCommerce', 'ngd-custom-add-to-cart-label' ), 'Plugin dependency check',
			array(
				'back_link' => true,
			)
		);
	}

}
register_activation_hook( __FILE__, 'wc_ngd_custom_add_to_cart_label_activation' );

/**
 * Plugin deactivation.
 */
function wc_ngd_custom_add_to_cart_label_deactivation() {
	// Deactivation code here.	
}
register_deactivation_hook( __FILE__, 'wc_ngd_custom_add_to_cart_label_deactivation' );

/**
 * Initialization class.
 */
function wc_ngd_custom_add_to_cart_label_init() {
	global $wc_ngd_custom_add_to_cart_label;
	$wc_ngd_custom_add_to_cart_label = new WC_NGD_Custom_Add_To_Cart_Label();
}
add_action( 'plugins_loaded', 'wc_ngd_custom_add_to_cart_label_init' );