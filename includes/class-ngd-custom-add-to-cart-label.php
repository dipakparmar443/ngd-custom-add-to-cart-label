<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NGD_Custom_Add_To_Cart_For_Woocommerce_Label' ) ) {

	class NGD_Custom_Add_To_Cart_For_Woocommerce_Label {

		public function __construct() {
			// Only run when WooCommerce is active
			if ( class_exists( 'WooCommerce' ) ) {
				// Settings tab
				add_filter( 'woocommerce_settings_tabs_array', array( $this, 'ngd_catcl_for_woo_add_custom_tab' ), 50 );
				add_action( 'woocommerce_settings_tabs_ngd_catcl_for_woo_custom_tab', array( $this, 'ngd_catcl_for_woo_tab_content' ) );
				add_action( 'woocommerce_update_options_ngd_catcl_for_woo_custom_tab', array( $this, 'ngd_catcl_for_woo_save_settings' ) );

				// Text filters (allow 2 args where available)
				add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this, 'ngd_catcl_for_woo_change_add_to_cart_text' ), 10, 2 );
				add_filter( 'woocommerce_product_add_to_cart_text', array( $this, 'ngd_catcl_for_woo_change_add_to_cart_text' ), 10, 2 );

				// Loop (archive / shop / shortcodes)
				add_filter( 'woocommerce_loop_add_to_cart_link', array( $this, 'ngd_catcl_for_woo_change_loop_add_to_cart_link' ), 10, 3 );

				// WooCommerce Blocks (Gutenberg)
				add_filter( 'woocommerce_blocks_product_grid_item_html', array( $this, 'ngd_catcl_for_woo_change_block_button_text' ), 10, 3 );

				// Backwards compatibility / bookings, etc (some plugins use custom filters)
				add_filter( 'woocommerce_booking_single_add_to_cart_text', array( $this, 'ngd_catcl_for_woo_change_add_to_cart_text' ) );
			}
		}

		public function ngd_catcl_for_woo_add_custom_tab( $tabs ) {
			$tabs['ngd_catcl_for_woo_custom_tab'] = __( 'NGD Custom Add to Cart Label for WooCommerce', 'ngd-custom-add-to-cart-label' );
			return $tabs;
		}

		public function ngd_catcl_for_woo_tab_content() {
			woocommerce_admin_fields( $this->get_settings() );
		}

		public function ngd_catcl_for_woo_save_settings() {
			woocommerce_update_options( $this->get_settings() );
		}

		public function get_settings() {
			$settings = array(
				'section_title' => array(
					'title' => __( 'NGD Custom Add to Cart Label for WooCommerce', 'ngd-custom-add-to-cart-label' ),
					'type'  => 'title',
					'desc'  => __( 'Change the "Add to cart" button labels for different product types.', 'ngd-custom-add-to-cart-label' ),
					'id'    => 'ngd_catcl_for_woo_labels_section'
				),

				// Single product page labels
				'ngd_catcl_for_woo_simple_button_text_single' => array(
					'title'       => __( 'Simple product (single)', 'ngd-custom-add-to-cart-label' ),
					'type'        => 'text',
					'placeholder' => 'Add to cart',
					'id'          => 'ngd_catcl_for_woo_simple_button_text_single',
				),
				'ngd_catcl_for_woo_grouped_button_text_single' => array(
					'title'       => __( 'Grouped product (single)', 'ngd-custom-add-to-cart-label' ),
					'type'        => 'text',
					'placeholder' => 'Add to cart',
					'id'          => 'ngd_catcl_for_woo_grouped_button_text_single',
				),
				'ngd_catcl_for_woo_external_button_text_single' => array(
					'title'       => __( 'External product (single)', 'ngd-custom-add-to-cart-label' ),
					'type'        => 'text',
					'placeholder' => 'Buy product',
					'id'          => 'ngd_catcl_for_woo_external_button_text_single',
				),
				'ngd_catcl_for_woo_variable_button_text_single' => array(
					'title'       => __( 'Variable product (single)', 'ngd-custom-add-to-cart-label' ),
					'type'        => 'text',
					'placeholder' => 'Select options',
					'id'          => 'ngd_catcl_for_woo_variable_button_text_single',
				),
				'ngd_catcl_for_woo_booking_button_text_single' => array(
					'title'       => __( 'Bookable product (single)', 'ngd-custom-add-to-cart-label' ),
					'type'        => 'text',
					'placeholder' => 'Book now',
					'id'          => 'ngd_catcl_for_woo_booking_button_text_single',
				),
				'ngd_catcl_for_woo_subs_button_text_single' => array(
					'title'       => __( 'Subscription product (single)', 'ngd-custom-add-to-cart-label' ),
					'type'        => 'text',
					'placeholder' => 'Sign up now',
					'id'          => 'ngd_catcl_for_woo_subs_button_text_single',
				),
				'ngd_catcl_for_woo_subs_var_button_text_single' => array(
					'title'       => __( 'Variable subscription (single)', 'ngd-custom-add-to-cart-label' ),
					'type'        => 'text',
					'placeholder' => 'Choose plan',
					'id'          => 'ngd_catcl_for_woo_subs_var_button_text_single',
				),

				// Archive page labels
				'ngd_catcl_for_woo_simple_button_text' => array(
					'title'       => __( 'Simple product (archive)', 'ngd-custom-add-to-cart-label' ),
					'type'        => 'text',
					'placeholder' => 'Add to cart',
					'id'          => 'ngd_catcl_for_woo_simple_button_text',
				),
				'ngd_catcl_for_woo_grouped_button_text' => array(
					'title'       => __( 'Grouped product (archive)', 'ngd-custom-add-to-cart-label' ),
					'type'        => 'text',
					'placeholder' => 'View products',
					'id'          => 'ngd_catcl_for_woo_grouped_button_text',
				),
				'ngd_catcl_for_woo_external_button_text' => array(
					'title'       => __( 'External product (archive)', 'ngd-custom-add-to-cart-label' ),
					'type'        => 'text',
					'placeholder' => 'Buy product',
					'id'          => 'ngd_catcl_for_woo_external_button_text',
				),
				'ngd_catcl_for_woo_variable_button_text' => array(
					'title'       => __( 'Variable product (archive)', 'ngd-custom-add-to-cart-label' ),
					'type'        => 'text',
					'placeholder' => 'Select options',
					'id'          => 'ngd_catcl_for_woo_variable_button_text',
				),
				'ngd_catcl_for_woo_booking_button_text' => array(
					'title'       => __( 'Bookable product (archive)', 'ngd-custom-add-to-cart-label' ),
					'type'        => 'text',
					'placeholder' => 'Book now',
					'id'          => 'ngd_catcl_for_woo_booking_button_text',
				),
				'ngd_catcl_for_woo_subs_button_text' => array(
					'title'       => __( 'Subscription product (archive)', 'ngd-custom-add-to-cart-label' ),
					'type'        => 'text',
					'placeholder' => 'Subscribe',
					'id'          => 'ngd_catcl_for_woo_subs_button_text',
				),
				'ngd_catcl_for_woo_subs_var_button_text' => array(
					'title'       => __( 'Variable subscription (archive)', 'ngd-custom-add-to-cart-label' ),
					'type'        => 'text',
					'placeholder' => 'Choose plan',
					'id'          => 'ngd_catcl_for_woo_subs_var_button_text',
				),

				'section_end' => array(
					'type' => 'sectionend',
					'id'   => 'ngd_catcl_for_woo_custom_cart_labels_section'
				),
			);

			return $settings;
		}

		/**
		 * Change the plain add to cart text. Called by filters that pass ($text, $product).
		 * Accepts two args for compatibility.
		 *
		 * @param string      $text
		 * @param WC_Product|null $product
		 * @return string
		 */
		public function ngd_catcl_for_woo_change_add_to_cart_text( $text, $product = null ) {
			// try to get global product when not passed
			if ( ! $product instanceof WC_Product ) {
				global $product;
				if ( ! $product instanceof WC_Product ) {
					return $text;
				}
			}

			// single vs archive suffix
			$suffix = is_product() ? '_single' : '';

			$map = array(
				'simple'                => "ngd_catcl_for_woo_simple_button_text{$suffix}",
				'grouped'               => "ngd_catcl_for_woo_grouped_button_text{$suffix}",
				'external'              => "ngd_catcl_for_woo_external_button_text{$suffix}",
				'variable'              => "ngd_catcl_for_woo_variable_button_text{$suffix}",
				'booking'               => "ngd_catcl_for_woo_booking_button_text{$suffix}",
				'subscription'          => "ngd_catcl_for_woo_subs_button_text{$suffix}",
				'variable-subscription' => "ngd_catcl_for_woo_subs_var_button_text{$suffix}",
			);

			$type = $product->get_type();

			if ( isset( $map[ $type ] ) ) {
				$custom = get_option( $map[ $type ], '' );
				if ( is_string( $custom ) && '' !== trim( $custom ) ) {
					return esc_html( $custom );
				}
			}

			// fallback: return original text
			return $text;
		}

		/**
		 * Replace the label inside the loop add to cart link HTML.
		 *
		 * @param string   $link
		 * @param WC_Product $product
		 * @param array    $args
		 * @return string
		 */
		public function ngd_catcl_for_woo_change_loop_add_to_cart_link( $link, $product = null, $args = array() ) {
			if ( ! $product instanceof WC_Product ) {
				return $link;
			}

			$original_text = method_exists( $product, 'add_to_cart_text' ) ? $product->add_to_cart_text() : __( 'Add to cart', 'ngd-custom-add-to-cart-label' );

			$new_text = $this->ngd_catcl_for_woo_change_add_to_cart_text( $original_text, $product );

			if ( $new_text === $original_text ) {
				return $link;
			}

			// Replace the visible text inside the first <a> or <button> tag (keeps inner HTML markup)
			$link = preg_replace_callback( '#(<a\b[^>]*>|<button\b[^>]*>)(.*?)(</a>|</button>)#si', function( $m ) use ( $original_text, $new_text ) {
				$inner = $m[2];

				if ( false !== strpos( wp_strip_all_tags( $inner ), $original_text ) ) {
					$replaced = str_replace( $original_text, $new_text, $inner );
					return $m[1] . $replaced . $m[3];
				}

				return $m[0];
			}, $link, 1 );

			return $link;
		}

		/**
		 * Replace text inside WooCommerce Blocks product grid HTML (Gutenberg).
		 *
		 * @param string $html
		 * @param array  $data
		 * @param WC_Product|null $product
		 * @return string
		 */
		public function ngd_catcl_for_woo_change_block_button_text( $html, $data = array(), $product = null ) {
			if ( ! $product instanceof WC_Product ) {
				return $html;
			}

			$original_text = method_exists( $product, 'add_to_cart_text' ) ? $product->add_to_cart_text() : __( 'Add to cart', 'ngd-custom-add-to-cart-label' );
			$new_text      = $this->ngd_catcl_for_woo_change_add_to_cart_text( $original_text, $product );

			if ( $new_text === $original_text ) {
				return $html;
			}

			// Similar safe replacement as loop link
			$html = preg_replace_callback( '#(<a\b[^>]*>|<button\b[^>]*>)(.*?)(</a>|</button>)#si', function( $m ) use ( $original_text, $new_text ) {
				$inner = $m[2];
				if ( false !== strpos( wp_strip_all_tags( $inner ), $original_text ) ) {
					$replaced = str_replace( $original_text, $new_text, $inner );
					return $m[1] . $replaced . $m[3];
				}
				return $m[0];
			}, $html, 1 );

			return $html;
		}

	} // end class

	// initialize
	new NGD_Custom_Add_To_Cart_For_Woocommerce_Label();
}
