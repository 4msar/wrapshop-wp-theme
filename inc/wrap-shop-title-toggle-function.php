<?php
/**
 * Copied from this plugin
 * Plugin Name:			Title Toggle for Storefront Theme (Now it work for WrapShop)
 * Plugin URI:			https://wordpress.org/plugins/wrapshop-title-toggle/
 * Author:				Wooassist
 * Author URI:			http://wooassist.com/
 *
 
 
 * @package WrapShop_Title_Toggle
 * @category Core
 * @author WooAssist
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Returns the main instance of WrapShop_Title_Toggle to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object WrapShop_Title_Toggle
 */
function WrapShop_Title_Toggle() {
	return WrapShop_Title_Toggle::instance();
} // End WrapShop_Title_Toggle()

WrapShop_Title_Toggle();

/**
 * Main WrapShop_Title_Toggle Class
 *
 * @class WrapShop_Title_Toggle
 * @version	1.0.0
 * @since 1.0.0
 * @package	WrapShop_Title_Toggle
 */
final class WrapShop_Title_Toggle {
	/**
	 * WrapShop_Title_Toggle The single instance of WrapShop_Title_Toggle.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	// Admin - Start
	/**
	 * The admin object.
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $admin;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct() {
		register_activation_hook( __FILE__, array( $this, 'install' ) );

		add_action( 'init', array( $this, 'wrapshop_setup' ) );

	}

	/**
	 * Main WrapShop_Title_Toggle Instance
	 *
	 * Ensures only one instance of WrapShop_Title_Toggle is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see WrapShop_Title_Toggle()
	 * @return Main WrapShop_Title_Toggle instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	} // End instance()

	/**
	 * Installation.
	 * Runs on activation. Logs the version number and assigns a notice message to a WordPress option.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install() {


		// get theme customizer url
		$url = admin_url() . 'customize.php?';
		$url .= 'url=' . urlencode( site_url() . '?wrapshop-customizer=true' ) ;
		$url .= '&wrapshop-customizer=true';

	}


	/**
	 * Setup all the things.
	 * Only executes if WrapShop or a child theme using WrapShop as a parent is active and the extension specific filter returns true.
	 * Child themes can disable this extension using the wrapshop_title_toggle_enabled filter
	 * @return void
	 */
	public function wrapshop_setup() {

		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' )         );
		add_action( 'save_post',      array( $this, 'metabox_save'     ),  1, 2  );
		add_action( 'wp', array( $this, 'title_toggle' ) );

	}

	/**
	 * Register Metabox
	 * Function to register the metabox on WordPress
	 * @since 1.0.0
	 * @return void
	 */
	public function add_meta_box() {

		// Allow devs to control what post types this is allowed on
		$post_types = apply_filters( 'wrapshop_title_toggle_post_types', array( 'page', 'post', 'product' ) );

		// Add metabox for each post type found
		foreach ( $post_types as $post_type ) {
			add_meta_box( 'woa-sf-title-toggle', __('Header Title ', 'wrapshop'), array( $this, 'metabox_render' ), $post_type, 'normal', 'high' );
		}
	}

	/**
	 * Render Metabox
	 * Function to render the metabox on supported post types
	 * @since 1.0.0
	 * @return void
	 */
	function metabox_render( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'wrapshop_title_toggle', 'wrapshop_title_toggle_nonce' );

		$title = self::get_meta( $post->ID, 'wrapshop_title_toggle' );
		$meta  = self::get_meta( $post->ID, 'wrapshop_meta_toggle' );

		// start html content ?>
			<p>
				<input type="checkbox" id="wrapshop_title_toggle" name="wrapshop" value="true" <?php checked( 'true', $title ); ?>>
				<label for="wrapshop_title_toggle"><strong><?php echo __( 'Hide Title', 'wrapshop' ); ?></strong></label>
				<em style="color:#aaa;"><?php echo __('This checkbox will hide the title from view.', 'wrapshop'); ?></em>
			</p>
			<?php if ( 'post' == $post->post_type ) : ?>
				<p>
					<input type="checkbox" id="wrapshop_meta_toggle" name="wrapshop_meta_toggle" value="true" <?php checked( 'true', $meta ); ?>>
					<label for="wrapshop_meta_toggle"><strong><?php echo __( 'Hide Post Meta', 'wrapshop' ); ?></strong></label>
					<em style="color:#aaa;"><?php echo __('This checkbox will hide the post meta (categories and tags) from view.', 'wrapshop'); ?></em>
				</p>
			<?php endif; ?>

		<?php // end html content
	}

	/**
	 * Save Metabox
	 * Function to handle saving of the options modified on the metabox
	 * @since 1.0.0
	 * @return void
	 */
	function metabox_save( $post_id ) {

		// Security check
		if ( ! isset( $_POST['wrapshop_title_toggle_nonce'] ) || ! wp_verify_nonce( $_POST['wrapshop_title_toggle_nonce'], 'wrapshop_title_toggle' ) ) {
			return;
		}

		// Bail out if running an autosave, ajax, cron.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}
		if ( defined( 'DOING_CRON' ) && DOING_CRON ) {
			return;
		}

		// Bail out if the user doesn't have the correct permissions to update the post.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$var = array();

		$var['wrapshop_title_toggle'] = array_key_exists( 'wrapshop_title_toggle', $_POST ) ? $_POST['wrapshop_title_toggle'] : '';
		$var['wrapshop_meta_toggle'] 	= array_key_exists( 'wrapshop_meta_toggle', $_POST ) ? $_POST['wrapshop_meta_toggle'] : '';

		foreach( $var as $key => $v ) {
			if ( $v == 'true' ) {
				update_post_meta( $post_id, $key, $v );
			} else {
				delete_post_meta( $post_id, $key, $v );
			}
		}
	}

	/**
	 * Main plugin logic
	 * Implements code if it should show/hide title and/or meta.
	 * @since 1.0.0
	 * @return void
	 */
	function title_toggle() {

		global $post;

		if ( ! is_object( $post ) )
			return;

		$title = self::get_meta( $post->ID, 'wrapshop_title_toggle' );
		$meta  = self::get_meta( $post->ID, 'wrapshop_meta_toggle' );

		if ( $title == 'true' ) {
			remove_action( 'wrapshop_single_post', 'wrapshop_post_header' );
			remove_action( 'wrapshop_page', 'wrapshop_page_header' );

			if ( is_front_page() ) {
				remove_action( 'wrapshop_homepage', 'wrapshop_homepage_header', 10 );
			}
			if ( is_page() ) {
				add_action( 'wrapshop_page', 'wrapshop_stt_page_header' );
			}


		}

		if ( function_exists( 'is_woocommerce' ) ) {

			if ( is_shop() ) {
				$shop_title = get_post_meta( get_option( 'woocommerce_shop_page_id' ) , 'wrapshop_title_toggle', true );

				if( $shop_title == 'true' )
					add_filter( 'woocommerce_show_page_title', '__return_false' );

			} else if ( is_product() && ( $title == 'true' ) ) {

				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
				add_action( 'woocommerce_single_product_summary', array( $this, 'product_title_margin_fix' ), 5 );
			}
		}

		if( $meta == 'true' ) {
			remove_action( 'wrapshop_single_post', 'wrapshop_post_meta', 20);
		}
	}

	/**
	 * Product title margin fix
	 * This is a temporary fix for the margin error when hiding the title for a Product
	 * @since 1.2.1
	 * @return void
	 */
	function product_title_margin_fix() {
		?>
			<div class="margin-fix" style="height:0.618em"></div>
		<?php
	}

	/**
	 * Helper function to get the meta data.
	 * added filter to set the default value of the checkbox
	 *
	 * @since 1.2.3
	 * @return string	'true'/'false'
	 */
	function get_meta( $id, $key ) {

		if ( ! $id || ! $key )
			return;

		// dynamic filter to set the default value of the meta
		$value = apply_filters( $key . '_default', 'false', $id );

		if ( $fetch = get_post_meta( $id, $key, true ) )
			$value = $fetch;

		return $value;
	}

} // End Class

/**
 * Replaces the default page header to still display the featured photo on Pages.
 * @since 1.2.2
 * @return void
 */
function wrapshop_stt_page_header() {

	if ( ! has_post_thumbnail() )
		return;

	?>
		<figure class="entry-thumbnail">
			<?php wrapshop_post_thumbnail( 'full' ); ?>
		</figure>
	<?php
}
