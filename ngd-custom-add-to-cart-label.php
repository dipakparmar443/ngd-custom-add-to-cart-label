<?php
/**
 * Plugin Name:     	 NGD Custom Add to Cart Label for WooCommerce
 * Contributors:    	 dipakparmar443
 * Plugin URI:      	 https://wordpress.org/plugins/ngd-custom-add-to-cart-label/
 * Description:     	 Change and customize the "Add to Cart" button label on your WooCommerce store. Single product pages (per product type) and archive / shop page (per product type).
 * Author:          	 Dipakkumar Parmar
 * Author URI:      	 https://profiles.wordpress.org/dipakparmar443/
 * Donate link:     	 https://www.paypal.me/dipakparmar443/
 * Text Domain:     	 ngd-custom-add-to-cart-label
 * Domain Path:     	 /languages
 * License:         	 GPL v2 or later
 * License URI:     	 https://www.gnu.org/licenses/gpl-2.0.html 
 * Tested up to:    	 6.8.2
 * Version:         	 1.1
 * WC requires at least: 10.1.2
 * WC tested up to: 	 10.1.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin constants
 */
if ( ! defined( 'NGD_CATL_FOR_WOO_VERSION' ) ) {
    define( 'NGD_CATL_FOR_WOO_VERSION', '1.1' );
}

if ( ! defined( 'NGD_CATL_FOR_WOO_PATH' ) ) {
    define( 'NGD_CATL_FOR_WOO_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'NGD_CATL_FOR_WOO_URL' ) ) {
    define( 'NGD_CATL_FOR_WOO_URL', plugin_dir_url( __FILE__ ) );
}

// Declare HPOS compatibility (WooCommerce 7.1+)
add_action( 'before_woocommerce_init', function() {
    if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility(
            'custom_order_tables', 
            __FILE__, 
            true // set to false if NOT compatible
        );
    }
});

require_once NGD_CATL_FOR_WOO_PATH . 'includes/class-ngd-custom-add-to-cart-label.php';

/**
 * Plugin activation.
 */
function ngd_custom_add_to_cart_label_for_woocommerce_activation() {
	// If check pro plugin activated or not.
	if ( ! class_exists( 'WooCommerce' ) ) {
		// Deactivate plugin if WooCommerce is not active.
		deactivate_plugins( plugin_basename( __FILE__ ) );

		// Display error message.
		wp_die(
			esc_html__( 'NGD Custom Add to Cart Label for WooCommerce requires WooCommerce to be installed and active.', 'ngd-custom-add-to-cart-label' ),
			esc_html__( 'Plugin dependency check', 'ngd-custom-add-to-cart-label' ),
			array( 'back_link' => true )
		);
	}
}

register_activation_hook( __FILE__, 'ngd_custom_add_to_cart_label_for_woocommerce_activation' );

// Add Settings link on Plugins page
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), function( $links ) {
    $settings_url = admin_url( 'admin.php?page=wc-settings&tab=ngd_catcl_for_woo_custom_tab' );
    $settings_link = '<a href="' . esc_url( $settings_url ) . '">' . __( 'Settings', 'ngd-custom-add-to-cart-label' ) . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
});

/**
 * Plugin deactivation.
 */
function ngd_custom_add_to_cart_label_for_woocommerce_deactivation() {
	// Deactivation code here.	
}
register_deactivation_hook( __FILE__, 'ngd_custom_add_to_cart_label_for_woocommerce_deactivation' );

/**
 * Initialization class.
 */
function ngd_custom_add_to_cart_label_for_woocommerce_init() {
	global $ngd_catcl_for_woo;
	$ngd_catcl_for_woo = new NGD_Custom_Add_To_Cart_For_Woocommerce_Label();
}
add_action( 'plugins_loaded', 'ngd_custom_add_to_cart_label_for_woocommerce_init' );