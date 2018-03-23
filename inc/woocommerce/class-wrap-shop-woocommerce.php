<?php
/**
 * wrapshop WooCommerce Class
 *
 * @package  wrapshop
 * @author   WooThemes
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'wrapshop_WooCommerce' ) ) :

	/**
	 * The wrapshop WooCommerce Integration class
	 */
	class wrapshop_WooCommerce {

		/**
		 * Setup class.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_filter( 'loop_shop_columns', 						array( $this, 'loop_columns' ) );
			add_filter( 'body_class', 								array( $this, 'woocommerce_body_class' ) );
			add_action( 'wp_enqueue_scripts', 						array( $this, 'woocommerce_scripts' ),	20 );
			add_filter( 'woocommerce_enqueue_styles', 				'__return_empty_array' );
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );
			add_filter( 'woocommerce_product_thumbnails_columns', 	array( $this, 'thumbnail_columns' ) );
			add_filter( 'loop_shop_per_page', 						array( $this, 'products_per_page' ) );
			

			if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.5', '<' ) ) {
				add_action( 'wp_footer', 							array( $this, 'star_rating_script' ) );
			}

			// Integrations.
			
			add_action( 'wp_enqueue_scripts',                       array( $this, 'add_customizer_css' ), 140 );

			
		}

		/**
		 * Add CSS in <head> for styles handled by the theme customizer
		 * If the Customizer is active pull in the raw css. Otherwise pull in the prepared theme_mods if they exist.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function add_customizer_css() {

			$wrapshop_woocommerce_extension_styles = get_theme_mod( 'wrapshop_woocommerce_extension_styles' );


			wp_add_inline_style( 'wrapshop-woocommerce-style', $wrapshop_woocommerce_extension_styles );
			
		}

		/**
		 * Default loop columns on product archives
		 *
		 * @return integer products per row
		 * @since  1.0.0
		 */
		public function loop_columns() {

			$layout = get_theme_mod( 'wrapshop_layout' );

			if ( $layout == 'none' ) {

				$item = 4;

			} else {

				$item = 3;

			}
			return apply_filters( 'wrapshop_loop_columns', $item ); // 3 products per row
		}

		/**
		 * Add 'woocommerce-active' class to the body tag
		 *
		 * @param  array $classes css classes applied to the body tag.
		 * @return array $classes modified to include 'woocommerce-active' class
		 */
		public function woocommerce_body_class( $classes ) {
			if ( wrapshop_is_woocommerce_activated() ) {
				$classes[] = 'woocommerce-active';
			}

			return $classes;
		}

		/**
		 * WooCommerce specific scripts & stylesheets
		 *
		 * @since 1.0.0
		 */
		public function woocommerce_scripts() {
			global $wrapshop_version;

			wp_enqueue_style( 'wrapshop-woocommerce-style', get_template_directory_uri() . '/assets/sass/woocommerce/woocommerce.css', $wrapshop_version );
			//wp_style_add_data( 'wrapshop-woocommerce-style', 'rtl', 'replace' );

			wp_register_script( 'wrapshop-header-cart', get_template_directory_uri() . '/assets/js/woocommerce/header-cart.min.js', array(), $wrapshop_version, true );
			wp_enqueue_script( 'wrapshop-header-cart' );

			wp_register_script( 'wrapshop-sticky-payment', get_template_directory_uri() . '/assets/js/woocommerce/checkout.min.js', 'jquery', $wrapshop_version, true );

			if ( is_checkout() && apply_filters( 'wrapshop_sticky_order_review', true ) ) {
				wp_enqueue_script( 'wrapshop-sticky-payment' );
			}
		}

		/**
		 * Star rating backwards compatibility script (WooCommerce <2.5).
		 *
		 * @since 1.0.0
		 */
		public function star_rating_script() {
			if ( wp_script_is( 'jquery', 'done' ) && is_product() ) {
		?>
			<script type="text/javascript">
				jQuery( function( $ ) {
					$( 'body' ).on( 'click', '#respond p.stars a', function() {
						var $container = $( this ).closest( '.stars' );
						$container.addClass( 'selected' );
					});
				});
			</script>
		<?php
			}
		}

		/**
		 * Related Products Args
		 *
		 * @param  array $args related products args.
		 * @since 1.0.0
		 * @return  array $args related products args
		 */
		public function related_products_args( $args ) {
			$args = apply_filters( 'wrapshop_related_products_args', array(
				'posts_per_page' => 3,
				'columns'        => 3,
			) );

			return $args;
		}

		/**
		 * Product gallery thumnail columns
		 *
		 * @return integer number of columns
		 * @since  1.0.0
		 */
		public function thumbnail_columns() {
			return intval( apply_filters( 'wrapshop_product_thumbnail_columns', 4 ) );
		}

		/**
		 * Products per page
		 *
		 * @return integer number of products
		 * @since  1.0.0
		 */
		public function products_per_page() {
			return intval( apply_filters( 'wrapshop_products_per_page', 12 ) );
		}

		/**
		 * Query WooCommerce Extension Activation.
		 *
		 * @param string $extension Extension class name.
		 * @return boolean
		 */
		public function is_woocommerce_extension_activated( $extension = 'WC_Bookings' ) {
			return class_exists( $extension ) ? true : false;
		}

		public function wrapshop_subcategory_count_html( $str, $category ) {

			$html = ' <span class="count">' . sprintf( _n( '%s Product', '%s Products', $category->count, 'wrapshop' ), $category->count )  . '</span>';

			return $html;
		}
	}

endif;

return new wrapshop_WooCommerce();
