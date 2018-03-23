<?php
/**
 * WrapShop Admin Class
 *
 * @author   WooThemes
 * @package  wrapshop
 * @since    2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WrapShop_Admin' ) ) :
	/**
	 * The WrapShop admin class
	 */
	class WrapShop_Admin {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'admin_menu', 				array( $this, 'welcome_register_menu' ) );
			add_action( 'admin_enqueue_scripts', 	array( $this, 'welcome_style' ) );
		}

		/**
		 * Load welcome screen css
		 *
		 * @param string $hook_suffix the current page hook suffix.
		 * @return void
		 * @since  1.4.4
		 */
		public function welcome_style( $hook_suffix ) {
			global $wrapshop_version;

			if ( 'appearance_page_wrapshop-welcome' === $hook_suffix ) {
				wp_enqueue_style( 'wrapshop-welcome-screen', get_template_directory_uri() . '/assets/sass/admin/welcome-screen/welcome.css', $wrapshop_version );
				wp_style_add_data( 'wrapshop-welcome-screen', 'rtl', 'replace' );
			}
		}

		/**
		 * Creates the dashboard page
		 *
		 * @see  add_theme_page()
		 * @since 1.0.0
		 */
		public function welcome_register_menu() {
			add_theme_page( 'WrapShop', 'WrapShop', 'activate_plugins', 'wrapshop-welcome', array( $this, 'wrapshop_welcome_screen' ) );
		}

		/**
		 * The welcome screen
		 *
		 * @since 1.0.0
		 */
		public function wrapshop_welcome_screen() {
			require_once( ABSPATH . 'wp-load.php' );
			require_once( ABSPATH . 'wp-admin/admin.php' );
			require_once( ABSPATH . 'wp-admin/admin-header.php' );

			global $wrapshop_version;
			?>

			<div class="wrapshop-wrap">
				<section class="wrapshop-welcome-nav">
					<span class="wrapshop-welcome-nav__version">WrapShop <?php echo esc_attr( $wrapshop_version ); ?></span>
					<ul>
						<li><a href="//4msar.github.io" target="_blank"><?php esc_attr_e( 'Connect With Me', 'wrapshop' ); ?></a></li>
						
					</ul>
				</section>

				<div class="wrapshop-logo">
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/admin/wc.svg" alt="WrapShop" />
				</div>

				<div class="wrapshop-intro">
					<?php
					/**
					 * Display a different message when the user visits this page when returning from the guided tour
					 */
					$referrer = wp_get_referer();
					if ( strpos( $referrer, 'sf_guided_tour' ) !== false ) {
						echo '<h1>' . sprintf( esc_attr__( 'Setup complete %1$s Your WrapShop adventure begins now %2$s ', 'wrapshop' ), '<span>', '</span>' ) . '</h1>';
						echo '<p>' . esc_attr__( 'One more thing... You might be interested in the following WrapShop extensions and designs.', 'wrapshop' ) . '</p>';
					} else {
						echo '<p>' . esc_attr__( 'Hello! You might be interested in the following WrapShop extensions and designs.', 'wrapshop' ) . '</p>';
					}
					?>
				</div>

				<div class="wrapshop-enhance">
					<div class="wrapshop-enhance__column wrapshop-free-plugins">
						<h3><?php esc_attr_e( 'Naccessary Plugin Install', 'wrapshop' ); ?></h3>
						<ul class="wrapshop-free-plugins__wrap">


							<li class="wrapshop-plugin">
								<h4><?php esc_attr_e( 'WooCommerce', 'wrapshop' ); ?></h4>

								<p>
									<?php esc_attr_e( 'An e-commerce toolkit that helps you sell anything. Beautifully.(Must Active for WooCommerce functionality)', 'wrapshop' ); ?>
								</p>

								<p>
									<?php
										WrapShop_Plugin_Install::install_plugin_button( 'woocommerce', 'woocommerce.php', 'WooCommerce ','', 1 );
									?>
								</p>
							</li>
							
							<li class="wrapshop-plugin">
								<h4><?php esc_attr_e( 'Wishlist', 'wrapshop' ); ?></h4>

								<p>
									<?php esc_attr_e( 'YITH WooCommerce Wishlist allows you to add Wishlist functionality to your e-commerce...', 'wrapshop' ); ?>
								</p>

								<p>
									<?php
										WrapShop_Plugin_Install::install_plugin_button( 'yith-woocommerce-wishlist', 'init.php', 'WooCommerce Wishlist','', 1 );
									?>
								</p>
							</li>

							<li class="wrapshop-plugin">
								<h4><?php esc_attr_e( 'Master Slider', 'wrapshop' ); ?></h4>
								<p>
									<?php esc_attr_e( 'For more productivity and more feature we say to install this plugin..', 'wrapshop' ); ?>
								</p>

								<p>
									<?php
										WrapShop_Plugin_Install::install_plugin_button( 'master-slider', 'master-slider.php', 'Master Slider' );
									?>
								</p>
							</li>


							<li class="wrapshop-plugin">
								<h4><?php esc_attr_e( 'Product Sharing', 'wrapshop' ); ?></h4>
								<p>
									<?php esc_attr_e( 'Enable your visitors to market your products on your behalf! Add social icons to your product pages allowing guests to share your products on their favorite social networks.', 'wrapshop' ); ?>
								</p>

								<p>
									<?php
										WrapShop_Plugin_Install::install_plugin_button( 'wrapshop-product-sharing', 'wrapshop-product-sharing.php', 'WrapShop Product Sharing' );
									?>
								</p>
							</li>

						</ul>
					</div>
					<div class="wrapshop-enhance__column wrapshop-bundle">
						<h3><?php esc_attr_e( 'WrapShop Help', 'wrapshop' ); ?></h3>
                        <br>
                        <p>
							<?php esc_attr_e( 'Everything of your Design and Customization, you need to open Customizer.', 'wrapshop' ); ?>
						</p>

                        <p>
							<?php esc_attr_e( 'What to do after activating this theme: ', 'wrapshop' ); ?>
						</p>
                        <p>
							<?php esc_attr_e( 'The first thing you have to do, Install & active Necessary Plugin, then open Customizer and Customize your settings as you want.', 'wrapshop' ); ?>
						</p>
                        <p>
							<?php esc_attr_e( 'If you like this theme Please give us a review and Like us our', 'wrapshop'); echo '<a href="//fb.me/4msar" target="_blank"> Facebook Page </a>'; esc_attr_e(' for latest update', 'wrapshop' ); ?>
						</p>
                        <p>
							<?php
                            $link = '<a href="https://wrapcoder.wordpress.com/contact/" target="_blank">This Link</a>';
                             esc_attr_e('If you have any kind of question & suggestion to us please go to ', 'wrapshop'); echo $link; esc_attr_e('  and submit your question or suggestion ', 'wrapshop' ); ?>
						</p>
                        <p>
							<?php esc_attr_e( 'Thank you for Use Our Theme', 'wrapshop' ); ?>
						</p>
                        <center>
                            <p>
    							<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="wrapshop-button" ><?php esc_attr_e( 'Open Customizer', 'wrapshop' ); ?></a>
    						</p>
                        </center>
					</div>
				</div>

				<div class="automattic">
					<p>
					<?php printf( esc_html__( 'An %s project', 'wrapshop' ), '<a href="https://wrapcoder.wordpress.com/"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/admin/wc.png" alt="WC" /></a>' ); ?>
					</p>
				</div>
			</div>
			<?php
		}

		/**
		 * Welcome screen intro
		 *
		 * @since 1.0.0
		 */
		public function welcome_intro() {
			require_once( get_template_directory() . '/inc/admin/welcome-screen/component-intro.php' );
		}

		/**
		 * Output a button that will install or activate a plugin if it doesn't exist, or display a disabled button if the
		 * plugin is already activated.
		 *
		 * @param string $plugin_slug The plugin slug.
		 * @param string $plugin_file The plugin file.
		 */
		public function install_plugin_button( $plugin_slug, $plugin_file ) {
			if ( current_user_can( 'install_plugins' ) && current_user_can( 'activate_plugins' ) ) {
				if ( is_plugin_active( $plugin_slug . '/' . $plugin_file ) ) {
					/**
					 * The plugin is already active
					 */
					$button = array(
						'message' => esc_attr__( 'Activated', 'wrapshop' ),
						'url'     => '#',
						'classes' => 'disabled',
					);
				} elseif ( $url = $this->_is_plugin_installed( $plugin_slug ) ) {
					/**
					 * The plugin exists but isn't activated yet.
					 */
					$button = array(
						'message' => esc_attr__( 'Activate', 'wrapshop' ),
						'url'     => $url,
						'classes' => 'activate-now',
					);
				} else {
					/**
					 * The plugin doesn't exist.
					 */
					$url = wp_nonce_url( add_query_arg( array(
						'action' => 'install-plugin',
						'plugin' => $plugin_slug,
					), self_admin_url( 'update.php' ) ), 'install-plugin_' . $plugin_slug );
					$button = array(
						'message' => esc_attr__( 'Install now', 'wrapshop' ),
						'url'     => $url,
						'classes' => ' install-now install-' . $plugin_slug,
					);
				}
				?>
				<a href="<?php echo esc_url( $button['url'] ); ?>" class="wrapshop-button <?php echo esc_attr( $button['classes'] ); ?>" data-originaltext="<?php echo esc_attr( $button['message'] ); ?>" data-slug="<?php echo esc_attr( $plugin_slug ); ?>" aria-label="<?php echo esc_attr( $button['message'] ); ?>"><?php echo esc_attr( $button['message'] ); ?></a>
				<a href="https://wordpress.org/plugins/<?php echo esc_attr( $plugin_slug ); ?>" target="_blank"><?php esc_attr_e( 'Learn more', 'wrapshop' ); ?></a>
				<?php
			}
		}

		/**
		 * Check if a plugin is installed and return the url to activate it if so.
		 *
		 * @param string $plugin_slug The plugin slug.
		 */
		public function _is_plugin_installed( $plugin_slug ) {
			if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin_slug ) ) {
				$plugins = get_plugins( '/' . $plugin_slug );
				if ( ! empty( $plugins ) ) {
					$keys        = array_keys( $plugins );
					$plugin_file = $plugin_slug . '/' . $keys[0];
					$url         = wp_nonce_url( add_query_arg( array(
						'action' => 'activate',
						'plugin' => $plugin_file,
					), admin_url( 'plugins.php' ) ), 'activate-plugin_' . $plugin_file );
					return $url;
				}
			}
			return false;
		}
		/**
		 * Welcome screen enhance section
		 *
		 * @since 1.5.2
		 */
		public function welcome_enhance() {
			require_once( get_template_directory() . '/inc/admin/welcome-screen/component-enhance.php' );
		}

		/**
		 * Welcome screen contribute section
		 *
		 * @since 1.5.2
		 */
		public function welcome_contribute() {
			require_once( get_template_directory() . '/inc/admin/welcome-screen/component-contribute.php' );
		}

		/**
		 * Get product data from json
		 *
		 * @param  string $url       URL to the json file.
		 * @param  string $transient Name the transient.
		 * @return [type]            [description]
		 */
		public function get_wrapshop_product_data( $url, $transient ) {
			$raw_products = wp_safe_remote_get( $url );
			$products     = json_decode( wp_remote_retrieve_body( $raw_products ) );

			if ( ! empty( $products ) ) {
				set_transient( $transient, $products, DAY_IN_SECONDS );
			}

			return $products;
		}
	}

endif;

return new WrapShop_Admin();
