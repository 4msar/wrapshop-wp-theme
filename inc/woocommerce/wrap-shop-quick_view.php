<?php

/******************************************************************************/
/* WooCommerce Product Quick View *********************************************/
/******************************************************************************/

	

// Enqueue wc-add-to-cart-variation
if ( ! function_exists( 'product_quick_view_scripts' ) ) {
	function product_quick_view_scripts() {	
		wp_enqueue_script('wc-add-to-cart-variation');
	}
	add_action( 'wp_enqueue_scripts', 'product_quick_view_scripts' );
}

	
	
	
	// Load The Product
if ( ! function_exists( 'product_quick_view_fn' ) ) {
	function product_quick_view_fn() {
		if (!isset( $_REQUEST['product_id'])) {
			die();
		}
		$product_id = intval($_REQUEST['product_id']);
		$i_next 	= (int) $_GET['next'];
		$i_prev 	= (int) $_GET['prev'];
		// wp_query for the product
		wp('p='.$product_id.'&post_type=product');
		ob_start();
		get_template_part( 'woocommerce/quick-view' );
		echo ob_get_clean();
		die();
	}	
	add_action( 'wp_ajax_product_quick_view', 'product_quick_view_fn');
	add_action( 'wp_ajax_nopriv_product_quick_view', 'product_quick_view_fn');
}
	
	// Show Quick View Button
if ( ! function_exists( 'product_quick_view_button' ) ) {
	function product_quick_view_button() {
		global $product;
		$quick_view = get_theme_mod('quick_view');
		if (isset($quick_view) && ($quick_view == 1) ){
			echo '<a href="#" id="product_id_' . $product->get_id() . '" class="product_quick_view_button" data-product_id="' . $product->get_id() . '">' . __( 'Quick View', 'wrapshop') . '<i class="ws-qvb" id=qv_icon_id_' . $product->get_id() . '"></i></a>';
		}
	}
	//woocommerce_after_shop_loop_item_title
	add_action( 'woocommerce_after_shop_loop_item_title', 'product_quick_view_button', 5 );
}
