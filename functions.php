<?php
/**
 * wrapshop functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wrapshop
 */

 /**
 * Assign the wrapshop version to a var
 */
$wrapshop_theme              = wp_get_theme();
$wrapshop_version = $wrapshop_theme['Version'];



/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	
	$content_width = 980; /* pixels */
}

$wrapshop = (object) array(
	'version' => $wrapshop_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require_once 'inc/class-wrap-shop.php',
	'customizer' => require_once 'inc/customizer/class-wrap-shop-customizer.php',
);

//All Core Function 
require_once 'inc/wrap-shop-functions.php';
// Hooks
require_once 'inc/wrap-shop-template-hooks.php';
//Template Function
require_once 'inc/wrap-shop-template-functions.php';

//Title Toggle
require_once 'inc/wrap-shop-title-toggle-function.php';
// Custom Nav Walkar
require_once 'inc/wrap-shop-nav-walker-class.php';
require_once 'inc/wrap-shop-nav-walker.php';
//Quick View
include_once('inc/woocommerce/wrap-shop-quick_view.php');
        
if ( is_admin() ) {
	
	$wrapshop->admin = require 'inc/admin/class-wrap-shop-admin.php';

	require 'inc/admin/class-wrap-shop-plugin-install.php';

}

/**
 * Enqueue script for custom customize control.
 */
function custom_customize_enqueue() {
	wp_enqueue_script( 'wrap-shop-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('jquery'), $wrapshop_version, true );
}
add_action( 'customize_controls_enqueue_scripts', 'custom_customize_enqueue' );

/**
 * All for WooCommerce functions
 */
if ( wrapshop_is_woocommerce_activated() ) {
	
	$wrapshop->woocommerce = require_once 'inc/woocommerce/class-wrap-shop-woocommerce.php';

	require_once 'inc/woocommerce/wrap-shop-wc-template-hooks.php';
	require_once 'inc/woocommerce/wrap-shop-wc-template-functions.php';

}

