<?php
/**
 * wrapshop Customizer Class
 *
 * 
 * @package  wrapshop
 * @author   WooThemes
 * @author   wrapshop
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'wrapshop_Customizer' ) ) :

	/**
	 * The wrapshop Customizer class
	 */
	class wrapshop_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'customize_register',              array( $this, 'customize_register' ), 10 );
			add_filter( 'body_class',                      array( $this, 'layout_class' ), 40 );
			add_action( 'wp_enqueue_scripts',              array( $this, 'add_customizer_css' ), 130 );
			add_action( 'after_setup_theme',               array( $this, 'custom_header_setup' ) );
			add_action( 'customize_controls_print_styles', array( $this, 'customizer_custom_control_css' ) );
			add_action('customize_controls_print_scripts', array( $this, 'customizer_custom_control_js' ) );
			add_action( 'customize_register',              array( $this, 'edit_default_customizer_settings' ), 99 );
			add_action( 'init',                            array( $this, 'default_theme_mod_values' ), 10 );

			add_action( 'after_switch_theme',              array( $this, 'set_wrapshop_style_theme_mods' ) );
			add_action( 'customize_save_after',            array( $this, 'set_wrapshop_style_theme_mods' ) );


			/* Render Components. */
			if ( ! is_admin() ) {

				add_action( 'get_header', array( $this, 'maybe_apply_render_homepage_component' ) );

				$layout = get_theme_mod( 'wrapshop_layout' );
				if ( $layout === 'none' ) {
					add_action( '', array( $this, 'remove_sidebars' ) );
					
				}
			}
		}

		/**
		 * Returns an array of the desired default wrapshop Options
		 *
		 * @since 1.0.0
		 * @return array
		 */
		public static function get_wrapshop_default_setting_values() {
			return apply_filters( 'wrapshop_setting_default_values', $args = array(
				
				'wrapshop_heading_color'                      => '#484c51',
				'wrapshop_text_color'                         => '#43454b',
				'wrapshop_accent_color'                       => '#00b9eb',
				'wrapshop_header_background_color'            => '#ffffff',
				'wrapshop_header_text_color'                  => '#9aa0a7',
				'wrapshop_header_link_color'                  => '#666666',
				'wrapshop_header_link_hover_color'            => '#00b9eb',
				'wrapshop_footer_background_color'            => '#333333',
				'wrapshop_widget_footer_background_color'     => '#666666',
				'wrapshop_footer_heading_color'               => '#ffffff',
				'wrapshop_footer_text_color'                  => '#cccccc',
				'wrapshop_button_background_color'            => '#00b9eb',
				'wrapshop_button_text_color'                  => '#ffffff',
				'wrapshop_button_alt_background_color'        => '#2c2d33',
				'wrapshop_button_alt_text_color'              => '#ffffff',
				'wrapshop_layout'                             => 'left',
				'background_color'                           => '#ffffff',
			) );
		}

		/**
		 * Adds a value to each wrapshop setting if one isn't already present.
		 * 
		 * @since 1.0.0
		 * @uses get_wrapshop_default_setting_values()
		 */
		public function default_theme_mod_values() {
			foreach ( self::get_wrapshop_default_setting_values() as $mod => $val ) {
				add_filter( 'theme_mod_' . $mod, array( $this, 'get_theme_mod_value' ), 10 );
			}
		}

		/**
		 * Get theme mod value.
		 *
		 * @since 1.0.0
		 * @param string $value
		 * @return string
		 */
		public function get_theme_mod_value( $value ) {
			$key = substr( current_filter(), 10 );

			$set_theme_mods = get_theme_mods();

			if ( isset( $set_theme_mods[ $key ] ) ) {
				return $value;
			}

			$values = $this->get_wrapshop_default_setting_values();

			return isset( $values[ $key ] ) ? $values[ $key ] : $value;
		}

		/**
		 * Set Customizer setting defaults.
		 * These defaults need to be applied separately as child themes can filter wrapshop_setting_default_values
		 *
		 * @since 1.0.0
		 * @param  array $wp_customize the Customizer object.
		 * @uses   get_wrapshop_default_setting_values()
		 */
		public function edit_default_customizer_settings( $wp_customize ) {
			foreach ( self::get_wrapshop_default_setting_values() as $mod => $val ) {
				$wp_customize->get_setting( $mod )->default = $val;
			}
		}

		/**
		 * Setup the WordPress core custom header feature.
		 *
		 * @uses wrapshop_header_style()
		 * @uses wrapshop_admin_header_style()
		 * @uses wrapshop_admin_header_image()
		 */
		public function custom_header_setup() {
			add_theme_support( 'custom-header', apply_filters( 'wrapshop_custom_header_args', array(
				'default-image' => '',
				'header-text'   => false,
				'width'         => 1950,
				'height'        => 500,
				'flex-width'    => true,
				'flex-height'   => true,
			) ) );
		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since  1.0.0
		 */
		public function customize_register( $wp_customize ) {

			// Move background color setting alongside background image.
			$wp_customize->get_control( 'background_color' )->section   = 'background_image';
			$wp_customize->get_control( 'background_color' )->priority  = 20;

			// Change background image section title & priority.
			$wp_customize->get_section( 'background_image' )->title     = __( 'Background', 'wrapshop' );
			$wp_customize->get_section( 'background_image' )->priority  = 30;

			// Change header image section title & priority.
			$wp_customize->get_section( 'header_image' )->title         = __( 'Header', 'wrapshop' );
			$wp_customize->get_section( 'header_image' )->priority      = 25;

			// Selective refresh.
			if ( function_exists( 'add_partial' ) ) {
				$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
				$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

				$wp_customize->selective_refresh->add_partial( 'custom_logo', array(
					'selector'        => '.site-branding',
					'render_callback' => array( $this, 'get_site_logo' ),
				) );

				$wp_customize->selective_refresh->add_partial( 'blogname', array(
					'selector'        => '.site-title.beta a',
					'render_callback' => array( $this, 'get_site_name' ),
				) );

				$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
					'selector'        => '.site-description',
					'render_callback' => array( $this, 'get_site_description' ),
				) );
			}

			/**
			 * Custom controls
			 */
			require_once dirname( __FILE__ ) . '/class-wrap-shop-control-multicheck.php';
			require_once dirname( __FILE__ ) . '/class-wrap-shop-customizer-control-radio-image.php';
			require_once dirname( __FILE__ ) . '/class-wrap-shop-customizer-control-arbitrary.php';

			if ( apply_filters( 'wrapshop_customizer_more', true ) ) {
				require_once dirname( __FILE__ ) . '/class-wrap-shop-customizer-control-more.php';
			}

			/**
			 * Add the typography section
			 */
			$wp_customize->add_section( 'wrapshop_typography' , array(
				'title'      			=> __( 'Color', 'wrapshop' ),
				'priority'   			=> 45,
			) );

			/**
			 * Heading color
			 */
			$wp_customize->add_setting( 'wrapshop_heading_color', array(
				'default'           	=> apply_filters( 'wrapshop_default_heading_color', '#484c51' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wrapshop_heading_color', array(
				'label'	   				=> __( 'Heading color', 'wrapshop' ),
				'section'  				=> 'wrapshop_typography',
				'settings' 				=> 'wrapshop_heading_color',
				'priority' 				=> 20,
			) ) );

			/**
			 * Text Color
			 */
			$wp_customize->add_setting( 'wrapshop_text_color', array(
				'default'           	=> apply_filters( 'wrapshop_default_text_color', '#43454b' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wrapshop_text_color', array(
				'label'					=> __( 'Text color', 'wrapshop' ),
				'section'				=> 'wrapshop_typography',
				'settings'				=> 'wrapshop_text_color',
				'priority'				=> 30,
			) ) );

			/**
			 * Accent Color
			 */
			$wp_customize->add_setting( 'wrapshop_accent_color', array(
				'default'           	=> apply_filters( 'wrapshop_default_accent_color', '#00b9eb' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wrapshop_accent_color', array(
				'label'	   				=> __( 'Link / accent color', 'wrapshop' ),
				'section'  				=> 'wrapshop_typography',
				'settings' 				=> 'wrapshop_accent_color',
				'priority' 				=> 40,
			) ) );

			$wp_customize->add_control( new Arbitrary_wrapshop_Control( $wp_customize, 'wrapshop_header_image_heading', array(
				'section'  				=> 'header_image',
				'type' 					=> 'heading',
				'label'					=> __( 'Header background image', 'wrapshop' ),
				'priority' 				=> 6,
			) ) );

			/**
			 * Header Background
			 */
			$wp_customize->add_setting( 'wrapshop_header_background_color', array(
				'default'           	=> apply_filters( 'wrapshop_default_header_background_color', '#ffffff' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wrapshop_header_background_color', array(
				'label'	   				=> __( 'Background color', 'wrapshop' ),
				'section'  				=> 'header_image',
				'settings' 				=> 'wrapshop_header_background_color',
				'priority' 				=> 15,
			) ) );

			/**
			 * Header text color
			 */
			$wp_customize->add_setting( 'wrapshop_header_text_color', array(
				'default'           	=> apply_filters( 'wrapshop_default_header_text_color', '#9aa0a7' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );
			
			
			/*
			*Fixed Header
			*/
			
			$wp_customize->add_setting( 'my_check', array(
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'wrapshop_sanitize_checkbox',
			) );

			$wp_customize->add_control( 'my_check', array(
				'type' => 'checkbox',
				'transport' => 'refresh',
				'section' => 'header_image', // Add a default or your own section
				'label' => __( 'Sticky Header / Fixed Primary Menu ', 'wrapshop' ),
				'description' => __( 'If chacked, then primary menu will fixed.', 'wrapshop' ),
			) );


			
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wrapshop_header_text_color', array(
				'label'	   				=> __( 'Text color', 'wrapshop' ),
				'section'  				=> 'header_image',
				'settings' 				=> 'wrapshop_header_text_color',
				'priority' 				=> 20,
			) ) );

			/**
			 * Header link color
			 */
			$wp_customize->add_setting( 'wrapshop_header_link_color', array(
				'default'           	=> apply_filters( 'wrapshop_default_header_link_color', '#666666' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wrapshop_header_link_color', array(
				'label'	   				=> __( 'Link color', 'wrapshop' ),
				'section'  				=> 'header_image',
				'settings' 				=> 'wrapshop_header_link_color',
				'priority' 				=> 30,
			) ) );

				/**
			 * Header link Hover color
			 */
			$wp_customize->add_setting( 'wrapshop_header_link_hover_color', array(
				'default'           	=> apply_filters( 'wrapshop_default_header_link_hover_color', '#00b9eb' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wrapshop_header_link_hover_color', array(
				'label'	   				=> __( 'Link Hover color', 'wrapshop' ),
				'section'  				=> 'header_image',
				'settings' 				=> 'wrapshop_header_link_hover_color',
				'priority' 				=> 40,
			) ) );


			/*
			* Wrap Shop - Shop page template Section
			*/
            if(wrapshop_is_woocommerce_activated()){
                $wp_customize->add_section('wrapshop_shop_template', array(
                    'title'         => __('ShopPage Template', 'wrapshop'),
                    'priority'      => 28,
                ));

                $wp_customize->add_setting('product_category', array(
                    'capability' => 'edit_theme_options',
                    'sanitize_callback' => 'wrapshop_sanitize_checkbox'
                ));

                $wp_customize->add_control( 'product_category', array(
					'type' => 'checkbox',
					'transport' => 'refresh',
					'section' => 'wrapshop_shop_template', // Add your own section
					'label' => __( 'Enable Shop Categories ', 'wrapshop' ),
                    'input_attrs' => array( 'class' => 'shop-page-checkbox-cat' ),
				) );
                /*
				* Category per Shop Page
				*/

				$wp_customize->add_setting( 'shop_categories_in_shoppage', array(
					'capability' => 'edit_theme_options',
					'default' => '4',
                    'sanitize_callback' => 'ws_sanitize_number_absint',
				) );

				$wp_customize->add_control( 'shop_categories_in_shoppage', array(
					'label'	   				=> __( 'Show Categories Number', 'wrapshop' ),
					'section'  				=> 'wrapshop_shop_template',
					'priority' 				=> 40,
					'type'					=> 'number',
					'description'			=> __('Enter Category Number you want to show in shop page.....', 'wrapshop'),
                    'input_attrs' => array( 'class' => 'shop-page-input-cat' ),
				) );
            }
			/*
			* Wrap Shop - Shop Section
			*/
			
			//=====================================================
			if ( wrapshop_is_woocommerce_activated() ) {
				$wp_customize->add_section( 'wrapshop_shop' , array(
					'title'      			=> __( 'Shop', 'wrapshop' ),
					'priority'   			=> 27,
				) );

				/*
				* QuickView
				*/
				
				$wp_customize->add_setting( 'quick_view', array(
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'wrapshop_sanitize_checkbox',
				) );

				$wp_customize->add_control( 'quick_view', array(
					'type' => 'checkbox',
					'transport' => 'refresh',
					'section' => 'wrapshop_shop', // Add a default or your own section
					'label' => __( 'QuickView ', 'wrapshop' ),
					'description' => __( 'If chacked, then Show a quick view button in product .', 'wrapshop' ),
				) );


				/*
				* Shop Page Column
				*/
				
				$wp_customize->add_setting( 'shop_loop_column', array(
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'wrapshop_sanitize_select',
					'default' => '3',
				) );

				$wp_customize->add_control( 'shop_loop_column', array(
					'type' => 'select',
					'section' => 'wrapshop_shop', // Add a default or your own section
					'label' => __( 'Shop Page Column', 'wrapshop' ),
					'description' => __( 'Show column in shop page.', 'wrapshop' ),
					'choices' => array(
						'2' => __( '2 Item', 'wrapshop' ),
						'3' => __( '3 Item', 'wrapshop' ),
						'4' => __( '4 Item', 'wrapshop' ),
						'5' => __( '5 Item', 'wrapshop' ),
						'6' => __( '6 Item', 'wrapshop' ),
					),

				) );
				

				
				/*
				* Product per Shop Page 
				*/
				
				$wp_customize->add_setting( 'shop_products_per_page', array(
					'capability' => 'edit_theme_options',
					'default' => '10',
                    'sanitize_callback' => 'ws_sanitize_number_absint',
				) );

				$wp_customize->add_control( 'shop_products_per_page', array(
					'label'	   				=> __( 'Shop Page Products Show', 'wrapshop' ),
					'section'  				=> 'wrapshop_shop',
					'priority' 				=> 40,
					'type'					=> 'number',
					'description'			=> __('Enter Product Number you want to show in shop page.....', 'wrapshop'),
				) );



				

			}
			/**
			 * Homepage Section
			 */
			if ( wrapshop_is_woocommerce_activated() ) {
				$wp_customize->add_section( 'wrapshop_homepage_banner' , array(
					'title'      			=> __( 'Home Page', 'wrapshop' ),
					'priority'   			=> 27,
				) );

				$wp_customize->add_setting(
			        'wrapshop_homepage_control',
			        array(
			            'default'           => wrapshop_homepage_control_format_defaults(),
			            'sanitize_callback' => 'wrapshop_homepage_contro_sanitize'
			        )
			    );

			    $wp_customize->add_control(
			        new wrapshop_Customize_Control_Checkbox_Multiple(
			            $wp_customize,
			            'wrapshop_homepage_control',
			            array(
			                'section' => 'wrapshop_homepage_banner',
			                'label'   => __( 'Homepage Components', 'wrapshop' ),
			                'priority'	=> 80,
			                'choices' => wrapshop_homepage_control_get_hooks()
			            )
			        )
			    );
			}
			/**
			 * Footer section
			 */
			$wp_customize->add_section( 'wrapshop_footer' , array(
				'title'      			=> __( 'Footer', 'wrapshop' ),
				'priority'   			=> 28,
				'description' 			=> __( 'Customise the look & feel of your web site footer.', 'wrapshop' ),
			) );

			/**
			 * Footer Background
			 */
			$wp_customize->add_setting( 'wrapshop_footer_background_color', array(
				'default'           	=> apply_filters( 'wrapshop_default_footer_background_color', '#333333' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wrapshop_footer_background_color', array(
				'label'	   				=> __( 'Background color', 'wrapshop' ),
				'section'  				=> 'wrapshop_footer',
				'settings' 				=> 'wrapshop_footer_background_color',
				'priority'				=> 10,
			) ) );


			/**
			 * Widget Footer Background
			 */
			$wp_customize->add_setting( 'wrapshop_widget_footer_background_color', array(
				'default'           	=> apply_filters( 'wrapshop_default_widget_footer_background_color', '#666666' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wrapshop_widget_footer_background_color', array(
				'label'	   				=> __( 'Widget Background color', 'wrapshop' ),
				'section'  				=> 'wrapshop_footer',
				'settings' 				=> 'wrapshop_widget_footer_background_color',
				'priority'				=> 10,
			) ) );


			/**
			 * Footer heading color
			 */
			$wp_customize->add_setting( 'wrapshop_footer_heading_color', array(
				'default'           	=> apply_filters( 'wrapshop_default_footer_heading_color', '#ffffff' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wrapshop_footer_heading_color', array(
				'label'	   				=> __( 'Heading color', 'wrapshop' ),
				'section'  				=> 'wrapshop_footer',
				'settings' 				=> 'wrapshop_footer_heading_color',
				'priority'				=> 20,
			) ) );

			/**
			 * Footer text color
			 */
			$wp_customize->add_setting( 'wrapshop_footer_text_color', array(
				'default'           	=> apply_filters( 'wrapshop_default_footer_text_color', '#cccccc' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wrapshop_footer_text_color', array(
				'label'	   				=> __( 'Text color', 'wrapshop' ),
				'section'  				=> 'wrapshop_footer',
				'settings' 				=> 'wrapshop_footer_text_color',
				'priority'				=> 30,
			) ) );

			/**
			 * Buttons section
			 */
			$wp_customize->add_section( 'wrapshop_buttons' , array(
				'title'      			=> __( 'Buttons', 'wrapshop' ),
				'priority'   			=> 45,
				'description' 			=> __( 'Customise the look & feel of your web site buttons.', 'wrapshop' ),
			) );

			/**
			 * Button background color
			 */
			$wp_customize->add_setting( 'wrapshop_button_background_color', array(
				'default'           	=> apply_filters( 'wrapshop_default_button_background_color', '#00b9eb' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wrapshop_button_background_color', array(
				'label'	   				=> __( 'Background color', 'wrapshop' ),
				'section'  				=> 'wrapshop_buttons',
				'settings' 				=> 'wrapshop_button_background_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Button text color
			 */
			$wp_customize->add_setting( 'wrapshop_button_text_color', array(
				'default'           	=> apply_filters( 'wrapshop_default_button_text_color', '#ffffff' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wrapshop_button_text_color', array(
				'label'	   				=> __( 'Text color', 'wrapshop' ),
				'section'  				=> 'wrapshop_buttons',
				'settings' 				=> 'wrapshop_button_text_color',
				'priority' 				=> 20,
			) ) );

			/**
			 * Button alt background color
			 */
			$wp_customize->add_setting( 'wrapshop_button_alt_background_color', array(
				'default'           	=> apply_filters( 'wrapshop_default_button_alt_background_color', '#2c2d33' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wrapshop_button_alt_background_color', array(
				'label'	   				=> __( 'Alternate button background color', 'wrapshop' ),
				'section'  				=> 'wrapshop_buttons',
				'settings' 				=> 'wrapshop_button_alt_background_color',
				'priority' 				=> 30,
			) ) );

			/**
			 * Button alt text color
			 */
			$wp_customize->add_setting( 'wrapshop_button_alt_text_color', array(
				'default'           	=> apply_filters( 'wrapshop_default_button_alt_text_color', '#ffffff' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wrapshop_button_alt_text_color', array(
				'label'	   				=> __( 'Alternate button text color', 'wrapshop' ),
				'section'  				=> 'wrapshop_buttons',
				'settings' 				=> 'wrapshop_button_alt_text_color',
				'priority' 				=> 40,
			) ) );

			/**
			 * Layout
			 */
			$wp_customize->add_section( 'wrapshop_layout' , array(
				'title'      			=> __( 'Layout', 'wrapshop' ),
				'priority'   			=> 50,
			) );

			$wp_customize->add_setting( 'wrapshop_layout', array(
				'default'    			=> apply_filters( 'wrapshop_default_layout', $layout = is_rtl() ? 'left' : 'right' ),
				'sanitize_callback' 	=> 'wrapshop_sanitize_choices',
			) );

			$wp_customize->add_control( new wrapshop_Custom_Radio_Image_Control( $wp_customize, 'wrapshop_layout', array(
				'settings'				=> 'wrapshop_layout',
				'section'				=> 'wrapshop_layout',
				'label'					=> __( 'General Layout', 'wrapshop' ),
				'priority'				=> 1,
				'choices'				=> array(											
											'left'  => get_template_directory_uri() . '/assets/images/customizer/controls/col-2cr.png',
											'none'  => get_template_directory_uri() . '/assets/images/customizer/controls/col-1cl.png',
											'boxed' => get_template_directory_uri() . '/assets/images/customizer/controls/boxed.png',
											'right' => get_template_directory_uri() . '/assets/images/customizer/controls/col-2cl.png',
				),
			) ) );
			
			// Boxed Layout Width
			$wp_customize->add_setting( 'boxed_layout_width', array(
				'default'           	=> '1100',
				'transport' => 'refresh',
                'sanitize_callback' => 'ws_sanitize_number_absint',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'boxed_layout_width', array(
				'label'	   				=> __( 'Max Boxed Layout Width', 'wrapshop' ),
				'section'  				=> 'wrapshop_layout',
				'settings' 				=> 'boxed_layout_width',
				'priority' 				=> 40,
				'type'					=> 'number',
				'description'			=> 'When you select box-layout or No-sidebar then this width is work. Default Box width is 1100px'
			) ) );
			
			
			

			/**
			 * More
			 */
			if ( apply_filters( 'wrapshop_customizer_more', true ) ) {
				$wp_customize->add_section( 'wrapshop_more' , array(
					'title'      		=> __( 'More', 'wrapshop' ),
					'priority'   		=> 999,
				) );

				$wp_customize->add_setting( 'wrapshop_more', array(
					'default'    		=> null,
					'sanitize_callback' => 'sanitize_text_field',
				) );

				$wp_customize->add_control( new More_wrapshop_Control( $wp_customize, 'wrapshop_more', array(
					'label'    			=> __( 'Looking for more options?', 'wrapshop' ),
					'section'  			=> 'wrapshop_more',
					'settings' 			=> 'wrapshop_more',
					'priority' 			=> 1,
				) ) );
			}

			// Remove control hooks
			$this->_remove_controls( $wp_customize );
		}

		/**
		 * Hook to remove some controls
		 * 
		 * @param  WP_Customize
		 * @return void
		 */
		private function _remove_controls( $wp_customize ) {

			$controls = apply_filters('wrapshop_remove_customize_control', array() );

			foreach ($controls as $control ) {

				$wp_customize->remove_control($control);

			}
		}

		/**
		 * Get all of the wrapshop theme mods.
		 * 
		 *@since 1.0.0
		 * @return array $wrapshop_theme_mods The wrapshop Theme Mods.
		 */
		public function get_wrapshop_theme_mods() {
			$wrapshop_theme_mods = array(
				'background_color'               => wrapshop_get_content_background_color(),
				'accent_color'                   => get_theme_mod( 'wrapshop_accent_color' ),
				'header_background_color'        => get_theme_mod( 'wrapshop_header_background_color' ),
				'header_link_color'              => get_theme_mod( 'wrapshop_header_link_color' ),
				'header_link_hover_color'        => get_theme_mod( 'wrapshop_header_link_hover_color' ),
				'header_text_color'              => get_theme_mod( 'wrapshop_header_text_color' ),
				'footer_background_color'        => get_theme_mod( 'wrapshop_footer_background_color' ),
				'widget_footer_background_color' => get_theme_mod( 'wrapshop_widget_footer_background_color' ),
				'footer_heading_color'           => get_theme_mod( 'wrapshop_footer_heading_color' ),
				'footer_text_color'              => get_theme_mod( 'wrapshop_footer_text_color' ),
				'text_color'                     => get_theme_mod( 'wrapshop_text_color' ),
				'heading_color'                  => get_theme_mod( 'wrapshop_heading_color' ),
				'button_background_color'        => get_theme_mod( 'wrapshop_button_background_color' ),
				'button_text_color'              => get_theme_mod( 'wrapshop_button_text_color' ),
				'button_alt_background_color'    => get_theme_mod( 'wrapshop_button_alt_background_color' ),
				'button_alt_text_color'          => get_theme_mod( 'wrapshop_button_alt_text_color' ),
			);

			return apply_filters( 'wrapshop_theme_mods', $wrapshop_theme_mods );
		}

		/**
		 * Get Customizer css.
		 *
		 * @see get_wrapshop_theme_mods()
		 * @since 1.0.0
		 * @return array $styles the css
		 */
		public function get_css() {
			$wrapshop_theme_mods = $this->get_wrapshop_theme_mods();
			$brighten_factor       = apply_filters( 'wrapshop_brighten_factor', 25 );
			$darken_factor         = apply_filters( 'wrapshop_darken_factor', -25 );

			$styles                = '
			.main-navigation ul li a,
			.site-title a,
			.site-branding h1 a,
			.site-footer .wrapshop-handheld-footer-bar a:not(.button) {
				color: ' . $wrapshop_theme_mods['header_link_color'] . ';
			}

			.main-navigation ul li a:hover,
			.main-navigation ul li:hover > a,
			.site-title a:hover,
			a.cart-contents:hover,
			.header-myacc-link a:hover,
			.site-header-cart .widget_shopping_cart a:hover,
			.site-header-cart:hover > li > a,
			.site-header ul.menu li.current-menu-item > a,
			.site-header ul.menu li.current-menu-parent > a {
				color: ' . $wrapshop_theme_mods['header_link_hover_color'] . ';
			}

			table th {
				background-color: ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['background_color'], -7 ) . ';
			}

			table tbody td {
				background-color: ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['background_color'], -2 ) . ';
			}

			table tbody tr:nth-child(2n) td {
				background-color: ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['background_color'], -4 ) . ';
			}

			.site-header,			
			.main-navigation ul.menu > li.menu-item-has-children:after,			
			.wrapshop-handheld-footer-bar,
			.wrapshop-handheld-footer-bar ul li > a,
			.wrapshop-handheld-footer-bar ul li.search .site-search {
				background-color: ' . $wrapshop_theme_mods['header_background_color'] . ';
			}

			p.site-description,
			.site-header,
			.wrapshop-handheld-footer-bar {
				color: ' . $wrapshop_theme_mods['header_text_color'] . ';
			}

			.wrapshop-handheld-footer-bar ul li.cart .count {
				background-color: ' . $wrapshop_theme_mods['header_link_color'] . ';
			}

			.wrapshop-handheld-footer-bar ul li.cart .count {
				color: ' . $wrapshop_theme_mods['header_background_color'] . ';
			}

			.wrapshop-handheld-footer-bar ul li.cart .count {
				border-color: ' . $wrapshop_theme_mods['header_background_color'] . ';
			}

			h1, h2, h3, h4, h5, h6 {
				color: ' . $wrapshop_theme_mods['heading_color'] . ';
			}
			.widget .widget-title, .widget .widgettitle, .wrapshop-latest-from-blog .recent-post-title, .entry-title a {
				color: ' . $wrapshop_theme_mods['heading_color'] . ';
			}

			.widget h1 {
				border-bottom-color: ' . $wrapshop_theme_mods['heading_color'] . ';
			}

			body,			
			.page-numbers li .page-numbers:not(.current),
			.page-numbers li .page-numbers:not(.current) {
				color: ' . $wrapshop_theme_mods['text_color'] . ';
			}

			.widget-area .widget a,
			.hentry .entry-header .posted-on a,
			.hentry .entry-header .byline a {
				color: ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['text_color'], 50 ) . ';
			}
			.site-main nav.navigation .nav-previous a, .widget_nav_menu ul.menu li.current-menu-item > a, .widget ul li.current-cat-ancestor > a, .widget_nav_menu ul.menu li.current-menu-ancestor > a, .site-main nav.navigation .nav-next a, .widget ul li.current-cat > a, .widget ul li.current-cat-parent > a, a  {
				color: ' . $wrapshop_theme_mods['accent_color'] . ';
			}			
			button, input[type="button"], input[type="reset"], input[type="submit"], .button, .widget a.button, .site-header-cart .widget_shopping_cart a.button, .back-to-top, .page-numbers li .page-numbers:hover {
				background-color: ' . $wrapshop_theme_mods['button_background_color'] . ';
				border-color: ' . $wrapshop_theme_mods['button_background_color'] . ';
				color: ' . $wrapshop_theme_mods['button_text_color'] . ';
			}



			.button.alt:hover, button.alt:hover, widget a.button.checkout:hover, button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, .button:hover, .widget a.button:hover, .site-header-cart .widget_shopping_cart a.button:hover, .back-to-top:hover, input[type="submit"]:disabled:hover {
				background-color: ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['button_background_color'], $darken_factor ) . ';
				border-color: ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['button_background_color'], $darken_factor ) . ';
				color: ' . $wrapshop_theme_mods['button_text_color'] . ';
			}

			button.alt, input[type="button"].alt, input[type="reset"].alt, input[type="submit"].alt, .button.alt, .added_to_cart.alt, .widget-area .widget a.button.alt, .added_to_cart, .pagination .page-numbers li .page-numbers.current, .woocommerce-pagination .page-numbers li .page-numbers.current, .widget a.button.checkout {
				background-color: ' . $wrapshop_theme_mods['button_background_color'] . ';
				border-color: ' . $wrapshop_theme_mods['button_background_color'] . ';
				color: ' . $wrapshop_theme_mods['button_alt_text_color'] . ';
			}

			 input[type="button"].alt:hover, input[type="reset"].alt:hover, input[type="submit"].alt:hover,  .added_to_cart.alt:hover, .widget-area .widget a.button.alt:hover {
				background-color: ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['button_alt_background_color'], $darken_factor ) . ';
				border-color: ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['button_alt_background_color'], $darken_factor ) . ';
				color: ' . $wrapshop_theme_mods['button_alt_text_color'] . ';
			}

			.site-footer {
				background-color: ' . $wrapshop_theme_mods['footer_background_color'] . ';
				color: ' . $wrapshop_theme_mods['footer_text_color'] . ';
			}

			.footer-widgets {
				background-color: ' . $wrapshop_theme_mods['widget_footer_background_color'] . ';
			}
			
			.footer-widgets .widget-title {
				color: ' . $wrapshop_theme_mods['footer_heading_color'] . ';
			}

			.site-footer h1, .site-footer h2, .site-footer h3, .site-footer h4, .site-footer h5, .site-footer h6 {
				color: ' . $wrapshop_theme_mods['footer_heading_color'] . ';
			}


			.site-info,
			.footer-widgets .product_list_widget a:hover,
			.site-footer a:not(.button) {
				color: ' . $wrapshop_theme_mods['footer_text_color'] . ';
			}

			#order_review,
			#payment .payment_methods > li .payment_box {
				background-color: ' . $wrapshop_theme_mods['background_color'] . ';
			}

			#payment .payment_methods > li {
				background-color: ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['background_color'], -5 ) . ';
			}

			#payment .payment_methods > li:hover {
				background-color: ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['background_color'], -10 ) . ';
			}

			.hentry .entry-content .more-link {
				border-color: ' . $wrapshop_theme_mods['button_background_color'] . ';
				color: ' . $wrapshop_theme_mods['button_background_color'] . ';
			}
			.hentry .entry-content .more-link:hover {
				background-color: ' . $wrapshop_theme_mods['button_background_color'] . ';
			}

			@media screen and ( min-width: 768px ) {
				/*
				.secondary-navigation ul.menu a:hover {
					color: ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['header_text_color'], $brighten_factor ) . ';
				}

				.secondary-navigation ul.menu a {
					color: ' . $wrapshop_theme_mods['header_text_color'] . ';
				}*/

				.site-header-cart .widget_shopping_cart,
				.main-navigation ul.menu ul.sub-menu,
				.main-navigation ul.nav-menu ul.children {
					background-color: ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['header_background_color'], -8 ) . ';
				}
			
			}';

			return apply_filters( 'wrapshop_customizer_css', $styles );
		}

		/**
		 * Get Customizer css associated with WooCommerce.
		 *
		 * @see get_wrapshop_theme_mods()
		 * @return array $woocommerce_styles the WooCommerce css
		 */
		public function get_woocommerce_css() {
			$wrapshop_theme_mods = $this->get_wrapshop_theme_mods();
			$brighten_factor       = apply_filters( 'wrapshop_brighten_factor', 25 );
			$darken_factor         = apply_filters( 'wrapshop_darken_factor', -25 );

			$woocommerce_styles    = '
			a.cart-contents,
			.header-myacc-link a,
			.site-header-cart .widget_shopping_cart a {
				color: ' . $wrapshop_theme_mods['header_link_color'] . ';
			}

			.woocommerce .product_quick_view_button {
				color: ' . $wrapshop_theme_mods['button_text_color'] . ';
				background: ' . $wrapshop_theme_mods['button_background_color'] . ' !important;
			}

			table.cart td.product-remove,
			table.cart td.actions {
				border-top-color: ' . $wrapshop_theme_mods['background_color'] . ';
			}

			.woocommerce-tabs ul.tabs li.active a,
			ul.products li.product .price,
			.widget_search form:before,
			.widget_product_search form:before {
				color: ' . $wrapshop_theme_mods['text_color'] . ';
			}

			.woocommerce-breadcrumb a,
			a.woocommerce-review-link,
			.product_meta a {
				color: ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['text_color'], 50 ) . ';
			}			

			.star-rating span:before,
			.quantity .plus, .quantity .minus,
			p.stars a:hover:after,
			p.stars a:after,
			.star-rating span:before,
			#payment .payment_methods li input[type=radio]:first-child:checked+label:before {
				color: ' . $wrapshop_theme_mods['button_background_color'] . ';
			}

			.widget_price_filter .ui-slider .ui-slider-range,
			.widget_price_filter .ui-slider .ui-slider-handle {
				background-color: ' . $wrapshop_theme_mods['accent_color'] . ';
			}

			.woocommerce-breadcrumb,
			#reviews .commentlist li .comment_container {
				background-color: ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['background_color'], -7 ) . ';
			}

			.order_details {
				background-color: ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['background_color'], -7 ) . ';
			}

			.order_details > li {
				border-bottom: 1px dotted ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['background_color'], -28 ) . ';
			}

			.order_details:before,
			.order_details:after {
				background: -webkit-linear-gradient(transparent 0,transparent 0),-webkit-linear-gradient(135deg,' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['background_color'], -7 ) . ' 33.33%,transparent 33.33%),-webkit-linear-gradient(45deg,' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['background_color'], -7 ) . ' 33.33%,transparent 33.33%)
			}

			p.stars a:before,
			p.stars a:hover~a:before,
			p.stars.selected a.active~a:before {
				color: ' . $wrapshop_theme_mods['text_color'] . ';
			}

			p.stars.selected a.active:before,
			p.stars:hover a:before,
			p.stars.selected a:not(.active):before,
			p.stars.selected a.active:before {
				color: ' . $wrapshop_theme_mods['accent_color'] . ';
			}

			.single-product div.product .woocommerce-product-gallery .woocommerce-product-gallery__trigger {
				background-color: ' . $wrapshop_theme_mods['button_background_color'] . ';
				color: ' . $wrapshop_theme_mods['button_text_color'] . ';
			}

			.single-product div.product .woocommerce-product-gallery .woocommerce-product-gallery__trigger:hover {
				background-color: ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['button_background_color'], $darken_factor ) . ';
				border-color: ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['button_background_color'], $darken_factor ) . ';
				color: ' . $wrapshop_theme_mods['button_text_color'] . ';
			}


			.site-main ul.products li.product:hover .woocommerce-loop-category__title,
			.site-header-cart .cart-contents .count,
			.added_to_cart, .onsale {
				background-color: ' . $wrapshop_theme_mods['button_background_color'] . ';
				color: ' . $wrapshop_theme_mods['button_text_color'] . ';
			}
			.added_to_cart:hover {
					background-color: ' . wrapshop_adjust_color_brightness( $wrapshop_theme_mods['button_background_color'], $darken_factor ) . ';
			}
			.widget_price_filter .ui-slider .ui-slider-range, .widget_price_filter .ui-slider .ui-slider-handle,
			.widget .tagcloud a:hover, .widget_price_filter .ui-slider .ui-slider-range, .widget_price_filter .ui-slider .ui-slider-handle, .hentry.type-post .entry-header:after {
				background-color: ' . $wrapshop_theme_mods['button_background_color'] . ';
			}
			.widget .tagcloud a:hover {
				border-color:  ' . $wrapshop_theme_mods['button_background_color'] . ';
			}

			.widget_product_categories > ul li.current-cat-parent > a, .widget_product_categories > ul li.current-cat > a {
				color: ' . $wrapshop_theme_mods['accent_color'] . ';
			}

			@media screen and ( min-width: 768px ) {
				.site-header-cart .widget_shopping_cart,
				.site-header .product_list_widget li .quantity {
					color: ' . $wrapshop_theme_mods['header_text_color'] . ';
				}
			}';

			return apply_filters( 'wrapshop_customizer_woocommerce_css', $woocommerce_styles );
		}

		/**
		 * Assign wrapshop styles to individual theme mods.
		 *
		 * @return void
		 */
		public function set_wrapshop_style_theme_mods() {
			set_theme_mod( 'wrapshop_styles', $this->get_css() );
			set_theme_mod( 'wrapshop_woocommerce_styles', $this->get_woocommerce_css() );
		}

		/**
		 * Add CSS in <head> for styles handled by the theme customizer
		 * If the Customizer is active pull in the raw css. Otherwise pull in the prepared theme_mods if they exist.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function add_customizer_css() {
			$wrapshop_styles             = get_theme_mod( 'wrapshop_styles' );
			$wrapshop_woocommerce_styles = get_theme_mod( 'wrapshop_woocommerce_styles' );

			if ( is_customize_preview() || ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) || ( false === $wrapshop_styles && false === $wrapshop_woocommerce_styles ) ) {
				wp_add_inline_style( 'wrapshop-style', $this->get_css() );
				wp_add_inline_style( 'wrapshop-woocommerce-style', $this->get_woocommerce_css() );
			} else {
				wp_add_inline_style( 'wrapshop-style', get_theme_mod( 'wrapshop_styles' ) );
				wp_add_inline_style( 'wrapshop-woocommerce-style', get_theme_mod( 'wrapshop_woocommerce_styles' ) );
			}
		}

		/**
		 * Layout classes
		 * Adds 'right-sidebar' and 'left-sidebar' classes to the body tag
		 *
		 * @param  array $classes current body classes.
		 * @return string[]          modified body classes
		 * @since  1.0.0
		 */
		public function layout_class( $classes ) {
			
			$left_or_right = get_theme_mod( 'wrapshop_layout' );

			$classes[] = $left_or_right . '-sidebar';

			return $classes;
		}

		/**
		 * Add CSS for custom controls
		 *
		 * This function incorporates CSS from the Kirki Customizer Framework
		 *
		 * The Kirki Customizer Framework, Copyright Aristeides Stathopoulos (@aristath),
		 * is licensed under the terms of the GNU GPL, Version 2 (or later)
		 *
		 * @link https://github.com/reduxframework/kirki/
		 * @since  1.0.0
		 */
		public function customizer_custom_control_css() {
			?>
			<style>
			.customize-control-radio-image .image.ui-buttonset input[type=radio] {
				height: auto;
			}

			.customize-control-radio-image .image.ui-buttonset label {
				display: inline-block;
				width: auto;
				padding: 1%;
				box-sizing: border-box;
			}

			.customize-control-radio-image .image.ui-buttonset label.ui-state-active {
				background: none;
			}

			.customize-control-radio-image .customize-control-radio-buttonset label {
				background: #f7f7f7;
				line-height: 35px;
			}

			.customize-control-radio-image label img {
				opacity: 0.5;
			}

			#customize-controls .customize-control-radio-image label img {
				height: auto;
			}

			.customize-control-radio-image label.ui-state-active img {
				background: #dedede;
				opacity: 1;
			}

			.customize-control-radio-image label.ui-state-hover img {
				opacity: 1;
				box-shadow: 0 0 0 3px #f6f6f6;
			}
			</style>
			<?php
		}

		/**
		 * 
		 */
		public function customizer_custom_control_js() {

			
		}
		/**
		 * Get site logo.
		 *
		 * @since 1.0.0
		 * @return string
		 */
		public function get_site_logo() {
			return wrapshop_site_title_or_logo( false );
		}

		/**
		 * Get site name.
		 *
		 * @since 1.0.0
		 * @return string
		 */
		public function get_site_name() {
			return get_bloginfo( 'name', 'display' );
		}

		/**
		 * Get site description.
		 *
		 * @since 1.0.0
		 * @return string
		 */
		public function get_site_description() {
			return get_bloginfo( 'description', 'display' );
		}

		/**
		 * Remove Sidebar for one column layout
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function remove_sidebars() {
			// Shop Sidebar
			remove_action( 'wrapshop_shop_sidebar', 'wrapshop_shop_sidebar', 10 );

			// General Sidebar
			add_action( 'wrapshop_sidebar',        'wrapshop_get_sidebar',   10 );
		}

		/**
		 * Render homepage components
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function maybe_apply_render_homepage_component() {

			// Skip if woocommerce doesn't activate
			if ( ! wrapshop_is_woocommerce_activated() ) {

				return false;
			}

			$options = get_theme_mod( 'wrapshop_homepage_control' );


			// Use pro options if it is available 
			if ( function_exists ('wrapshop_pro_get_homepage_hooks') ) {

				$options = wrapshop_pro_get_homepage_hooks();
			}

			$components = array();

			if ( isset( $options ) && '' != $options ) {
			
				$components = $options ;

				// Remove all existing actions on wrapshop_homepage.
				remove_all_actions( 'wrapshop_homepage' );

				foreach ($components as $k => $v) {

					if ( function_exists( $v ) ) {
							add_action( 'wrapshop_homepage', esc_attr( $v ), $k );
					}
				}

			}

		}

	}

endif;

return new wrapshop_Customizer();
