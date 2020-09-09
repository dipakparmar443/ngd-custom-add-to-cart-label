<?php
/**
 * Class for Custom Text Field support.
 *
 * @package WordPress
 */

// If check class exists.
if ( ! class_exists( 'WC_NGD_Custom_Add_To_Cart_Label' ) ) {

	/**
	 * Declare class.
	 */
	class WC_NGD_Custom_Add_To_Cart_Label {

		/**
		 * Calling construct.
		 */
		public function __construct() {
			
			/**
			 * Check if WooCommerce is active
			 **/

			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				//add_action( 'admin_init', array( $this, 'wc_ngd_custom_add_to_cart_label_admin_init_fields') );
				//add_action( 'admin_menu', array( $this, 'wc_ngd_custom_add_to_cart_label_register_sub_menu') );
				add_filter( 'woocommerce_get_sections_products', array( $this, 'wc_ngd_custom_add_to_cart_label_section' ) );

				add_filter( 'woocommerce_product_add_to_cart_text', array( $this, 'wc_ngd_custom_add_to_cart_label_text' ) );
				add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this, 'wc_ngd_custom_add_to_cart_label_text' ) );
				add_filter( 'woocommerce_booking_single_add_to_cart_text', array( $this, 'wc_ngd_custom_add_to_cart_label_text' ) );

				add_filter( 'woocommerce_get_settings_products', array( $this, 'wc_ngd_settings' ), 10, 2 );

			}

		}

		public function wc_ngd_settings( $settings, $current_section ) {
			/**
		     * Check the current section is what we want
		     **/

	    	if ( 'wc_ngd_custom_section' === $current_section ) {

		        $wc_ngd_custom_section[] = array( 'title' => __( 'Change the "Add to cart" button label on single product pages (per product type)', 'woocommerce' ), 'type' => 'title', 'id' => 'wc_ngd_change' );

		        $wc_ngd_custom_section[] = array(
		                'title'    => __( 'Simple products', 'woocommerce' ),
		                'desc' => 'This will change the "add to cart" label shown on single product page of simple product type',
		                'id'       => 'ngd_simple_button_text_single',
		                'type'     => 'text',
		                'placeholder' => 'Add to cart',
		                'css'      => 'min-width:350px;',
		            );

		        $wc_ngd_custom_section[] = array(
		                'title'    => __( 'Grouped products', 'woocommerce' ),
		                'desc' => 'This will change the "add to cart" label shown on single product page of grouped product type',
		                'id'       => 'ngd_grouped_button_text_single',
		                'type'     => 'text',
		                'placeholder' => 'Add to cart',
		                'css'      => 'min-width:350px;',
		            );

		        $wc_ngd_custom_section[] = array(
		                'title'    => __( 'External products', 'woocommerce' ),
		                'desc' => 'This will change the "add to cart" label shown on single product page of external product type',
		                'id'       => 'ngd_external_button_text_single',
		                'type'     => 'text',
		                'placeholder' => 'Add to cart',
		                'css'      => 'min-width:350px;',
		            );

		        $wc_ngd_custom_section[] = array(
		                'title'    => __( 'Variable products', 'woocommerce' ),
		                'desc' => 'This will change the "add to cart" label shown on single product page of variable product type',
		                'id'       => 'ngd_variable_button_text_single',
		                'type'     => 'text',
		                'placeholder' => 'Add to cart',
		                'css'      => 'min-width:350px;',
		            );

		        $wc_ngd_custom_section[] = array(
		                'title'    => __( 'Bookable products', 'woocommerce' ),
		                'desc' => 'This will change the "add to cart" label shown on single product page of bookable product type',
		                'id'       => 'ngd_booking_button_text_single',
		                'type'     => 'text',
		                'placeholder' => 'Add to cart',
		                'css'      => 'min-width:350px;',
		            );

		        $wc_ngd_custom_section[] = array(
		                'title'    => __( 'Subscription products', 'woocommerce-subscriptions' ),
		                'desc' => 'This will change the "add to cart" label shown on single product page of subscription product type',
		                'id'       => 'ngd_subs_button_text_single',
		                'type'     => 'text',
		                'placeholder' => 'Sign up now',
		                'css'      => 'min-width:350px;',
		            );

		        $wc_ngd_custom_section[] = array(
		                'title'    => __( 'Variable subscription products', 'woocommerce-subscriptions' ),
		                'desc' => 'This will change the "add to cart" label shown on the single product page of variable subscription product type',
		                'id'       => 'ngd_subs_var_button_text_single',
		                'type'     => 'text',
		                'placeholder' => 'Sign up now',
		                'css'      => 'min-width:350px;',
		            );

		        $wc_ngd_custom_section[] = array( 'type' => 'sectionend', 'id' => 'wc_ngd_change' );

		        $wc_ngd_custom_section[] = array( 'title' => __( 'Change the "Add to cart" button label on archive / shop page (per product type)', 'woocommerce' ), 'type' => 'title', 'id' => 'wc_ngd_change' );

		        $wc_ngd_custom_section[] = array(
		                'title'    => __( 'Simple products (archive)', 'woocommerce' ),
		                'desc' => 'This will change the "add to cart" label on simple products that are shown on the archive page',
		                'id'       => 'ngd_simple_button_text',
		                'type'     => 'text',
		                'placeholder' => 'Add to cart',
		                'css'      => 'min-width:350px;',
		            );

		        $wc_ngd_custom_section[] = array(
		                'title'    => __( 'Grouped products (archive)', 'woocommerce' ),
		                'desc' => 'This will change the "add to cart" label on grouped products that are shown on the archive page',
		                'id'       => 'ngd_grouped_button_text',
		                'type'     => 'text',
		                'placeholder' => 'Add to cart',
		                'css'      => 'min-width:350px;',
		            );

		        $wc_ngd_custom_section[] = array(
		                'title'    => __( 'External products (archive)', 'woocommerce' ),
		                'desc' => 'This will change the "add to cart" label on external products that are shown on the archive page',
		                'id'       => 'ngd_external_button_text',
		                'type'     => 'text',
		                'placeholder' => 'Add to cart',
		                'css'      => 'min-width:350px;',
		            );

		        $wc_ngd_custom_section[] = array(
		                'title'    => __( 'Variable products (archive)', 'woocommerce' ),
		                'desc' => 'This will change the "add to cart" label on variable products that are shown on the archive page',
		                'id'       => 'ngd_variable_button_text',
		                'type'     => 'text',
		                'placeholder' => 'Add to cart',
		                'css'      => 'min-width:350px;',
		            );

		        $wc_ngd_custom_section[] = array(
		                'title'    => __( 'Bookable products (archive)', 'woocommerce' ),
		                'desc' => 'This will change the "add to cart" label on bookable products that are shown on the archive page',
		                'id'       => 'ngd_booking_button_text',
		                'type'     => 'text',
		                'placeholder' => 'Add to cart',
		                'css'      => 'min-width:350px;',
		            );

		        $wc_ngd_custom_section[] = array(
		                'title'    => __( 'Subscription products (archive)', 'woocommerce-subscriptions' ),
		                'desc' => 'This will change the "add to cart" label on subscription products that are shown on the archive page',
		                'id'       => 'ngd_subs_button_text',
		                'type'     => 'text',
		                'placeholder' => 'Sign up now',
		                'css'      => 'min-width:350px;',
		            );

		        $wc_ngd_custom_section[] = array(
		                'title'    => __( 'Variable subscription products (Archive)', 'woocommerce-subscriptions' ),
		                'desc' => 'This will change the "add to cart" label on variable subscription products that are shown on the archive page',
		                'id'       => 'ngd_subs_var_button_text',
		                'type'     => 'text',
		                'placeholder' => 'Sign up now',
		                'css'      => 'min-width:350px;',
		            );

		        $wc_ngd_custom_section[] = array( 'type' => 'sectionend', 'id' => 'wc_ngd_change' );
		        return $wc_ngd_custom_section;
			} else {
				return $settings;
			}
		}	
		/**
		 * Add Label settings
		 */
		public function wc_ngd_custom_add_to_cart_label_section( $sections ) {
		    $sections['wc_ngd_custom_section'] = __( 'Custom Add to cart button labels', 'woocommerce' );
		    return $sections;
		}

		public function wc_ngd_custom_add_to_cart_label_text( $text ) {
		    global $product;

		    if (!isset ($product) || !is_object ($product))
		        return $text;

		    $product_type = $product->get_type();

		    if (is_product()) {

			    switch ( $product_type ) {
			        case 'simple':
			            return __( $options = $this->ngd_wc_get_settings( 'ngd_simple_button_text_single'), 'woocommerce' );
			        break;
			        case 'grouped':
			            return __( $options = $this->ngd_wc_get_settings( 'ngd_grouped_button_text_single'), 'woocommerce' );
			        break;
			        case 'external':
			            return __( $options = $this->ngd_wc_get_settings( 'ngd_external_button_text_single'), 'woocommerce' );
			        break;
			        case 'variable':
			            return __( $options = $this->ngd_wc_get_settings( 'ngd_variable_button_text_single'), 'woocommerce' );
			        break;
			        case 'booking':
			            return __( $options = $this->ngd_wc_get_settings( 'ngd_booking_button_text_single'), 'woocommerce-bookings' );
			        break;
			        case 'subscription':
			            return __( $options = $this->ngd_wc_get_settings( 'ngd_subs_button_text_single'), 'woocommerce-subscriptions' );
			        break;
			        case 'variable-subscription':
			            return __( $options = $this->ngd_wc_get_settings( 'ngd_subs_var_button_text_single'), 'woocommerce-subscriptions' );
			        break;
			        default:
			            return __( 'Read more', 'woocommerce' );
			     } 
		    } else {

			    switch ( $product_type ) {
			        case 'simple':
			            return __( $options = $this->ngd_wc_get_settings( 'ngd_simple_button_text'), 'woocommerce' );
			        break;
			        case 'grouped':
			            return __( $options = $this->ngd_wc_get_settings( 'ngd_grouped_button_text'), 'woocommerce' );
			        break;
			        case 'external':
			            return __( $options = $this->ngd_wc_get_settings( 'ngd_external_button_text'), 'woocommerce' );
			        break;
			        case 'variable':
			            return __( $options = $this->ngd_wc_get_settings( 'ngd_variable_button_text'), 'woocommerce' );
			        break;
			        case 'booking':
			            return __( $options = $this->ngd_wc_get_settings( 'ngd_booking_button_text'), 'woocommerce-bookings' );
			        break;
			        case 'subscription':
			            return __( $options = $this->ngd_wc_get_settings( 'ngd_subs_button_text'), 'woocommerce-subscriptions' );
			        break;
			        case 'variable-subscription':
			            return __( $options = $this->ngd_wc_get_settings( 'ngd_subs_var_button_text'), 'woocommerce-subscriptions' );
			        break;

			        default:
			            return __( 'Read more', 'woocommerce' );
			    }
		     } 
		}

		public function ngd_wc_get_settings( $key ) {
		    $saved = get_option( $key );
		    if( $saved && '' != $saved ) {
		        return $saved;
		    }
		    return __( 'Add to cart', 'woocommerce' );
		}

	}
}
