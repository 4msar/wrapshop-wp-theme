<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wrapshop
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site ">
	
	<?php
	do_action( 'wrapshop_before_header' ); ?>

	<header id="masthead" class="site-header <?php if((get_theme_mod('wrapshop_layout')=='boxed')==true){ echo 'boxed-true'; } ?>" role="banner" style="<?php wrapshop_header_styles(); ?>">
		<div class="col-full">
			<?php
			/**
			 * Functions hooked into wrapshop_header action
			 *
			 * @hooked wrapshop_skip_links                       - 0
			 * @hooked wrapshop_social_icons                     - 10
			 * @hooked wrapshop_site_branding                    - 20
			 * @hooked wrapshop_secondary_navigation             - 30
			 * @hooked wrapshop_product_search                   - 40
			 * @hooked wrapshop_primary_navigation_wrapper       - 42
			 * @hooked wrapshop_primary_navigation               - 50
			 * @hooked wrapshop_header_cart                      - 60
			 * @hooked wrapshop_primary_navigation_wrapper_close - 68
			 */
			do_action( 'wrapshop_header' ); ?>
			
		</div>
	</header><!-- #masthead -->
	<div id='fixed-header-fix'></div>
	<?php
	/**
	 * Functions hooked in to wrapshop_before_content
	 *
	 * @hooked wrapshop_header_widget_region - 10
	 */
	do_action( 'wrapshop_before_content' ); ?>

	<div id="content" class="site-content">
		<div class="col-full">

		<?php
		/**
		 * Functions hooked in to wrapshop_content_top
		 *
		 * @hooked woocommerce_breadcrumb - 10
		 */
		do_action( 'wrapshop_content_top' );
