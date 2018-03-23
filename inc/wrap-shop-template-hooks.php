<?php
/**
 * wrapshop hooks
 *
 * @package wrapshop
 */
/**
 * General
 *
 * @see  wrapshop_header_widget_region()
 * @see  wrapshop_get_sidebar()
 */
add_action( 'wrapshop_before_content', 'wrapshop_header_widget_region', 10 );
add_action( 'wrapshop_sidebar',        'wrapshop_get_sidebar',          10 );

/**
 * Header
 *
 * @see  wrapshop_skip_links()
 * @see  wrapshop_secondary_navigation()
 * @see  wrapshop_site_branding()
 * @see  wrapshop_primary_navigation()
 * 
 */

add_action( 'wrapshop_header', 'wrapshop_skip_links',                       	 0 );
add_action( 'wrapshop_header', 'wrapshop_secondary_navigation_wrapper',        2 );
add_action( 'wrapshop_header', 'wrapshop_top_header_leftbox',             	 5 );
add_action( 'wrapshop_header', 'wrapshop_top_header_rightbox',             	10 );
add_action( 'wrapshop_header', 'wrapshop_secondary_navigation_wrapper_close', 28 );

add_action( 'wrapshop_header', 'wrapshop_site_branding_wrapper',              29 );
add_action( 'wrapshop_header', 'wrapshop_site_branding',                    	32 );
add_action( 'wrapshop_header', 'wrapshop_site_branding_wrapper_close',        60 );

add_action( 'wrapshop_header', 'wrapshop_primary_navigation_wrapper',       	65 );
add_action( 'wrapshop_header', 'wrapshop_primary_navigation',               	70 );
add_action( 'wrapshop_header', 'wrapshop_primary_navigation_wrapper_close', 	80 );

add_action( 'wrapshop_top_header_left', 'wrapshop_secondary_navigation',   			10 );

add_action(	'wrapshop_top_header_right', 'wrapshop_social_navigation',		10 );

/**
 * Footer
 *
 * @see  wrapshop_footer_widgets()
 * @see  wrapshop_credit()
 * @see  wrapshop_backtotop()
 */
add_action( 'wrapshop_before_footer', 		'wrapshop_before_footer_payment', 	10 );
add_action( 'wrapshop_footer', 			'wrapshop_footer_widgets', 	10 );
add_action( 'wrapshop_footer', 			'wrapshop_credit',         	20 );
add_action( 'wrapshop_after_footer',		'wrapshop_backtotop',		10 );

/**
 * Homepage
 *
 * @see  wrapshop_homepage_content()
 * @see  wrapshop_product_categories()
 * @see  wrapshop_recent_products()
 * @see  wrapshop_featured_products()
 * @see  wrapshop_popular_products()
 * @see  wrapshop_on_sale_products()
 * @see  wrapshop_best_selling_products()
 */

add_action( 'wrapshop_homepage', 'wrapshop_homepage_header',      10 );
add_action( 'wrapshop_homepage', 'wrapshop_homepage_content',      20 );
add_action( 'wrapshop_homepage', 'wrapshop_recent_products',       30 );
add_action( 'wrapshop_homepage', 'wrapshop_best_selling_products', 40 );
add_action( 'wrapshop_homepage', 'wrapshop_featured_products',     50 );
add_action( 'wrapshop_homepage', 'wrapshop_popular_products',      60 );
add_action( 'wrapshop_homepage', 'wrapshop_on_sale_products',      70 );
add_action( 'wrapshop_homepage', 'wrapshop_product_categories',    80 );
add_action( 'wrapshop_homepage', 'wrapshop_latest_from_blog', 	 90 );



/**
 * Posts
 *
 * @see  wrapshop_post_header()
 * @see  wrapshop_post_meta()
 * @see  wrapshop_post_content()
 * @see  wrapshop_init_structured_data()
 * @see  wrapshop_paging_nav()
 * @see  wrapshop_single_post_header()
 * @see  wrapshop_post_nav()
 * @see  wrapshop_display_comments()
 * @see  wrapshop_post_thumbnail()
 */
add_action( 'wrapshop_loop_post',           'wrapshop_post_header',          10 );
add_action( 'wrapshop_loop_post',           'wrapshop_post_meta',            20 );
add_action( 'wrapshop_loop_post',           'wrapshop_post_content',         30 );
add_action( 'wrapshop_loop_post',           'wrapshop_init_structured_data', 40 );
add_action( 'wrapshop_loop_post',  		   'wrapshop_footer_meta',  		   50 );


add_action( 'wrapshop_loop_after',          'wrapshop_paging_nav',           10 );
add_action( 'wrapshop_single_post',         'wrapshop_post_header',          10 );
add_action( 'wrapshop_single_post',         'wrapshop_post_meta',            20 );
add_action( 'wrapshop_single_post',         'wrapshop_post_content',         30 );
add_action( 'wrapshop_single_post',  	   'wrapshop_footer_meta',  		   40 );
add_action( 'wrapshop_single_post',         'wrapshop_init_structured_data', 50 );
add_action( 'wrapshop_single_post_bottom',  'wrapshop_post_nav',             10 );
add_action( 'wrapshop_single_post_bottom',  'wrapshop_display_comments',     20 );
add_action( 'wrapshop_post_content_before', 'wrapshop_post_thumbnail',       10 );



/**
 * Pages
 *
 * @see  wrapshop_page_header()
 * @see  wrapshop_page_content()
 * @see  wrapshop_init_structured_data()
 * @see  wrapshop_display_comments()
 */
add_action( 'wrapshop_page',       'wrapshop_page_header',          10 );
add_action( 'wrapshop_page',       'wrapshop_page_content',         20 );
add_action( 'wrapshop_page',       'wrapshop_init_structured_data', 30 );
add_action( 'wrapshop_page_after', 'wrapshop_display_comments',     10 );


add_action( 'wrapshop_content_homepage',       'wrapshop_page_content',         20 );
add_action( 'wrapshop_content_homepage',       'wrapshop_init_structured_data', 30 );


/**
 * Extras
 *
 * @see  wrapshop_ajaxurl()
 * @see  shop_loop_columns()
 * @see  ws_menu_item_additional_fields()
 * @see  icon_picker_scripts()
 * @see  ws_boxed_layout()
 * @see  ws_sticky_header_menu()
 * @see  wrapshop_quickview()
 */
 

add_action('wp_head','wrapshop_ajaxurl'); //ajax url variavle
add_filter( 'loop_shop_per_page', 'ws_loop_shop_per_page', 999 ); // product per page
add_filter('loop_shop_columns', 'shop_loop_columns', 999); // shop-page column loop
add_filter( 'ws_nav_menu_item_additional_fields', 'ws_menu_item_additional_fields' ); //menu item custom field
add_action( 'admin_enqueue_scripts', 'custom_admin_scripts' ); // icon scripts
add_action( 'init', 'ws_add_editor_styles' );//Editor Style

if((get_theme_mod('boxed_layout_width')!==null) && (get_theme_mod('wrapshop_layout')=='boxed')==true){
	add_action( 'wp_head', 'ws_boxed_layout' ); //FOR STICKY HEADER 
}

if(get_theme_mod('my_check')==true){
	add_action( 'wp_footer', 'ws_sticky_header_menu' ); //FOR STICKY HEADER 
}

if(get_theme_mod('quick_view')==true){
	add_action( 'wp_footer', 'wrapshop_quickview' ); //FOR Quick View
}
