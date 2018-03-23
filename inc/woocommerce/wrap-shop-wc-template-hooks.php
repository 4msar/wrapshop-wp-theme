<?php
/**
 * All wrapshop WooCommerce hooks
 *
 * @package wrapshop
 */

/**
 * Styles
 *
 * @see  wrapshop_woocommerce_scripts()
 */

/**
 * Layout
 *
 * @see  wrapshop_before_content()
 * @see  wrapshop_after_content()
 * @see  woocommerce_breadcrumb()
 * @see  wrapshop_shop_messages()
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb',                 20, 0 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper',     10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar',             'woocommerce_get_sidebar',                10 );
remove_action( 'woocommerce_after_shop_loop',     'woocommerce_pagination',                 10 );
remove_action( 'woocommerce_before_shop_loop',    'woocommerce_result_count',               20 );
remove_action( 'woocommerce_before_shop_loop',    'woocommerce_catalog_ordering',           30 );
remove_action( 'woocommerce_single_product_summary',    'woocommerce_template_single_meta', 40 );

add_action( 'woocommerce_before_main_content',    'wrapshop_before_content',              	10 );
add_action( 'woocommerce_after_main_content',     'wrapshop_after_content',               	10 );
add_action( 'wrapshop_shop_sidebar',     		  'wrapshop_shop_sidebar',                	10 );
add_action( 'wrapshop_content_top',             	  'wrapshop_shop_messages',               	15 );
add_action( 'wrapshop_content_top',             	  'woocommerce_breadcrumb',              	10 );

add_action( 'woocommerce_after_shop_loop',        'wrapshop_footer_sorting_wrapper',          9 );
add_action( 'woocommerce_after_shop_loop',        'woocommerce_catalog_ordering',           10 );
add_action( 'woocommerce_after_shop_loop',        'woocommerce_result_count',               20 );
add_action( 'woocommerce_after_shop_loop',        'woocommerce_pagination',                 30 );
add_action( 'woocommerce_after_shop_loop',        'wrapshop_sorting_wrapper_close',       	31 );

add_action( 'woocommerce_before_shop_loop',       'wrapshop_sorting_wrapper',              	 9 );
add_action( 'woocommerce_before_shop_loop',       'woocommerce_catalog_ordering',        	10 );
add_action( 'woocommerce_before_shop_loop',       'woocommerce_result_count',            	20 );
add_action( 'woocommerce_before_shop_loop',       'wrapshop_woocommerce_pagination',      	30 );
add_action( 'woocommerce_before_shop_loop',       'wrapshop_sorting_wrapper_close',       	31 );
add_action( 'woocommerce_before_shop_loop',  	  'wrapshop_product_wrapper',  			 	40 );
add_action( 'woocommerce_after_shop_loop',  	  'wrapshop_product_wrapper_close',  	  	 5 );


add_action( 'wrapshop_footer',                  	  'wrapshop_handheld_footer_bar',         	999 );


add_action( 'woocommerce_before_single_product',  	  'wrapshop_product_gallery_wrapper',  	              10 );
add_action( 'woocommerce_after_single_product',  	  'wrapshop_product_gallery_wrapper_close',             5 );

add_action( 'woocommerce_single_product_summary', 	'wrapshop_single_product_summary_custom_wrapper',		0 );
add_action( 'woocommerce_single_product_summary', 	'wrapshop_single_product_summary_custom_wrapper_close', 90 );

// Tabs

add_action ( 'woocommerce_after_single_product_summary', 'wrapshop_single_product_diplay_tabs_wrapper', 		 0 );
add_action( 'woocommerce_after_single_product_summary',  'wrapshop_product_gallery_wrapper_close', 			90 );

// Enable Category
add_action( 'woocommerce_single_product_summary',    'wrapshop_template_single_meta', 						40 );

// Cart & Checkout 

add_action( 'woocommerce_after_cart_totals', 		'wrapshop_cart_sidebar_content', 						10 );
add_action( 'woocommerce_after_cart', 				'wrapshop_cart_after_sidebar_content', 					10 );
add_action( 'woocommerce_checkout_order_review', 	'wrapshop_checkout_sidebar_content', 					90 );




/**
 * Products
 *
 * @see  wrapshop_upsell_display()
 * @see  wrapshop_wishlist_products()
 */
remove_action( 'woocommerce_after_single_product_summary', 	'woocommerce_upsell_display',               15 );
add_action( 'woocommerce_after_single_product_summary',    	'wrapshop_upsell_display',                	15 );
remove_action( 'woocommerce_before_shop_loop_item_title',  	'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_after_shop_loop_item_title',      	'woocommerce_show_product_loop_sale_flash',  6 );
add_action( 'woocommerce_before_shop_loop_item', 			'wrapshop_wishlist_products', 				 9 );
add_action( 'woocommerce_after_shop_loop_item', 			'wrapshop_loop_add_to_cart_wrapper', 		 9 );
add_action( 'woocommerce_after_shop_loop_item', 			'wrapshop_loop_add_to_cart_wrapper_close', 	11 );

//woocommerce_template_loop_category_title - 10
remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );

add_action( 'woocommerce_shop_loop_subcategory_title', 			'wrapshop_template_loop_category_title', 				 10 );

/**
 * Header
 *
 * @see  wrapshop_product_search()
 * @see  wrapshop_header_myacount()
 * @see  wrapshop_header_cart()
 */


add_action( 'wrapshop_header', 	'wrapshop_custom_product_search',				35 );

add_action( 'wrapshop_header', 	'wrapshop_header_myacount_cart_wrapper',			38 );
add_action( 'wrapshop_header', 	'wrapshop_header_myacount',						40 );
add_action( 'wrapshop_header', 	'wrapshop_header_cart',    						50 );
add_action( 'wrapshop_header', 	'wrapshop_header_myacount_cart_wrapper_close',	55 );

//add_action(	'wrapshop_top_header_left', 'wrapshop_custom_product_search',		10 );

/**
 * Structured Data
 *
 * @see wrapshop_woocommerce_init_structured_data()
 */
if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.7', '<' ) ) {
	add_action( 'woocommerce_before_shop_loop_item', 'wrapshop_woocommerce_init_structured_data' );
}

if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
	add_filter( 'woocommerce_add_to_cart_fragments', 'wrapshop_cart_link_fragment' );
} else {
	add_filter( 'add_to_cart_fragments', 'wrapshop_cart_link_fragment' );
}
