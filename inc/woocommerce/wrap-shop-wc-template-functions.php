<?php
/**
 * WooCommerce Template Functions.
 *
 * @package wrapshop
 */

if ( ! function_exists( 'wrapshop_before_content' ) ) {
	/**
	 * Before Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function wrapshop_before_content() {
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
		<?php
	}
}

if ( ! function_exists ( 'wrapshop_remove_shop_title' ) ) {
	/**
	 * Remove shop title from shop page
	 */
	function wrapshop_remove_shop_title() {

		return false;

	}
	
	add_filter('woocommerce_show_page_title', 'wrapshop_remove_shop_title');
}

if ( ! function_exists( 'wrapshop_after_content' ) ) {
	/**
	 * After Content
	 * Closes the wrapping divs
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function wrapshop_after_content() {
		?>
			</main><!-- #main -->
		</div><!-- #primary -->

		<?php 
		/**
		 * @hooked wrapshop_shop_sidebar - 10
		 */
		do_action( 'wrapshop_shop_sidebar' );
	}
}

if ( ! function_exists( 'wrapshop_shop_sidebar' ) ) {

	function wrapshop_shop_sidebar() {


		$enable_sidebar = apply_filters('wrapshop_enable_shop_sidebar', true);

		if ( $enable_sidebar ) {

			get_sidebar('shop');
			
		}

	}
}

if ( ! function_exists( 'wrapshop_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments
	 * Ensure cart contents update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 * @return array            Fragments to refresh via AJAX
	 */
	function wrapshop_cart_link_fragment( $fragments ) {
		global $woocommerce;

		ob_start();
		wrapshop_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		ob_start();
		wrapshop_handheld_footer_bar_cart_link();
		$fragments['a.footer-cart-contents'] = ob_get_clean();

		return $fragments;
	}
}

if ( ! function_exists( 'wrapshop_cart_link' ) ) {
	/**
	 * Cart Link
	 * Displayed a link to the cart including the number of items present and the cart total
	 *
	 * @return void
	 * @since  1.0.0
	 */
	function wrapshop_cart_link( $isCart = true ) {
		?>
			<a class="cart-contents" href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'wrapshop' ); ?>">
				<?php if ($isCart) : ?>
				<span class="label-cart"><?php _e('Cart', 'wrapshop') ?> / </span> 
				<?php endif ?>
				<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> 
				<?php if ( WC()->cart->get_cart_contents_count() > 0) : ?>
					<span class="count"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() );?></span>
				<?php endif; ?>
			</a>
		<?php
	}
}

if ( ! function_exists( 'wrapshop_product_search' ) ) {
	/**
	 * Display Product Search
	 *
	 * @since  1.0.0
	 * @uses  wrapshop_is_woocommerce_activated() check if WooCommerce is activated
	 * @return void
	 */
	function wrapshop_product_search() {
		if ( wrapshop_is_woocommerce_activated() ) { ?>
			<div class="site-search">
				<?php the_widget( 'WC_Widget_Product_Search', 'title=' ); ?>
			</div>
		<?php
		}
	}
}

if ( ! function_exists( 'wrapshop_custom_product_search' ) ) {
	/**
	 * Custom Product Search
	 *
	 * @since  1.0.0
	 * @uses  wrapshop_is_woocommerce_activated() check if WooCommerce is activated
	 * @return void
	 */

	function wrapshop_custom_product_search() {

		if ( wrapshop_is_woocommerce_activated() ) { 

			?>
			<div class="custom-product-search">
				<form role="search" method="get" class="wrapshop-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<div class="nav-left">
						<div class="nav-search-facade" data-value="search-alias=aps"><span class="nav-search-label"><?php _e( 'All', 'wrapshop' ); ?></span> <i class="fa fa-angle-down"></i></div>			
						<?php
							echo wrapshop_product_cat_select('indent_sub');
						?>
					</div>
					<div class="nav-right">
						<button type="submit"><i class="fa fa-search"></i></button>
					</div>
					<div class="nav-fill">
						<input type="hidden" name="post_type" value="product" />
						<input name="s" type="text" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_attr_e( 'Search for products', 'wrapshop' ); ?>"/>
					</div>
				</form>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'wrapshop_product_cat_select' ) ) {

	function wrapshop_product_cat_select( $indent_sub = '', $select_id = 'product_cat_list' ) {

		$cats = wrapshop_get_product_categories();
		
		$select = '';

		if ( count( $cats ) > 0 ) {

			$select = '<select class="wrapshop-cat-list" id="' . $select_id .'" name="product_cat">';
			$select .= apply_filters('wrapshop_cat_all_option', '<option value="">'. esc_html__( 'All', 'wrapshop' ) .'</option>' );

			foreach( $cats as $cat ) {

				if ($indent_sub === 'indent_sub' ) {

					if ( $cat->parent === 0 ) {

						$select .= sprintf( '<option value="%s" %s>%s</option>', esc_attr( $cat->category_nicename ), wrapshop_cat_selected( $cat->category_nicename ), esc_html( $cat->name ) );

						/**
						 * Start child
						 */
						$children = wrapshop_get_product_categories(array('parent' => $cat->term_id ));

						if ( count($children) ) {

							foreach( $children as $ct ) {
								$select .= sprintf( '<option value="%s" %s>&nbsp&nbsp%s</option>', esc_attr( $ct->category_nicename ), wrapshop_cat_selected($ct->category_nicename), esc_html( $ct->name ) );
							}
						}
					}


				} else {

					$select .= sprintf( '<option value="%s" %s>%s</option>', esc_attr( $cat->category_nicename ), wrapshop_cat_selected($cat->category_nicename), esc_html( $cat->name ) );

				}

			}

			$select .= '</select>';

		}

		return $select;
		

	}

}

if ( ! function_exists( 'wrapshop_get_product_categories' ) ) {

	function wrapshop_get_product_categories( $args = array() ) {

		$args = wp_parse_args( $args, array(
			         'taxonomy'     => 'product_cat',
			         'orderby'      => 'name',
			         'show_count'   => 0,
			         'pad_counts'   => 0,
			 ) );

		return get_categories( $args );

	}
}

if ( ! function_exists( 'wrapshop_cat_selected' ) ) {

	/**
	 * Select category option
	 *
	 * @return string
	 * @since 1.0.0
	 */

	function wrapshop_cat_selected( $cat_nicename ) {

		$q_var = get_query_var( 'product_cat' );

		if ( $q_var === $cat_nicename ) {

			return 'selected="selected"';
		}

		return false;
	}

}

if ( !function_exists( 'wrapshop_header_myacount' ) ) {

	function wrapshop_header_myacount() {

		echo '<div class="header-myacc-link">';
		if ( is_user_logged_in() ) {

		?>

			<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','wrapshop'); ?>"><i class="fa fa-user"></i></a>
			<?php

		} else {

			?>
			<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login / Register','wrapshop'); ?>"><i class="fa fa-lock"></i></a>
			<?php 
		}

		echo '</div>';
	}
}

if ( ! function_exists( 'wrapshop_header_cart' ) ) {
	/**
	 * Display Header Cart
	 *
	 * @since  1.0.0
	 * @uses  wrapshop_is_woocommerce_activated() check if WooCommerce is activated
	 * @return void
	 */
	function wrapshop_header_cart() {
		if ( wrapshop_is_woocommerce_activated() ) {
			if ( is_cart() ) {
				$class = 'current-menu-item';
			} else {
				$class = '';
			}
		?>
		<ul id="site-header-cart" class="site-header-cart menu">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php wrapshop_cart_link(); ?>
			</li>
			<li>
				<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
			</li>
		</ul>
		<?php
		}
	}
}

if ( ! function_exists ( 'wrapshop_header_myacount_cart_wrapper' ) ) {

	function wrapshop_header_myacount_cart_wrapper() {

		echo '<div class="wrapshop-myacc-cart"><button class="cart-toggle"><i class="fa fa-shopping-cart"></i></button>';
	}

}

if ( ! function_exists ( 'wrapshop_header_myacount_cart_wrapper_close' ) ) {

	function wrapshop_header_myacount_cart_wrapper_close() {

		echo '</div>';
	}

}

if ( ! function_exists( 'wrapshop_upsell_display' ) ) {
	/**
	 * Upsells
	 * Replace the default upsell function with our own which displays the correct number product columns
	 *
	 * @since   1.0.0
	 * @return  void
	 * @uses    woocommerce_upsell_display()
	 */
	function wrapshop_upsell_display() {
		woocommerce_upsell_display( -1, 3 );
	}
}

if ( ! function_exists( 'wrapshop_sorting_wrapper' ) ) {
	/**
	 * Sorting wrapper
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function wrapshop_sorting_wrapper() {

		$product_nav_pos = esc_attr(apply_filters('wrapshop_product_nav_pos', 'wrapshop-nav-pos-right'));

		echo '<div class="wrapshop-sorting '. $product_nav_pos .'">';
	}
}

if ( ! function_exists( 'wrapshop_footer_sorting_wrapper' ) ) {
	/**
	 * Sorting wrapper
	 *
	 * @since   1.2.3
	 * @return  void
	 */
	function wrapshop_footer_sorting_wrapper() {
		
		$product_nav_pos = esc_attr(apply_filters('wrapshop_footer_product_nav_pos', 'wrapshop-nav-pos-right'));

		echo '<div class="wrapshop-sorting '. $product_nav_pos .'">';
	}
}
if ( ! function_exists( 'wrapshop_sorting_wrapper_close' ) ) {
	/**
	 * Sorting wrapper close
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function wrapshop_sorting_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'wrapshop_product_wrapper' )) {

	function wrapshop_product_wrapper () {

		$items = apply_filters( 'loop_shop_columns', 3);
		$display_style = apply_filters( 'wrapshop_display_style', 'product-grid');

		printf('<div class="columns-%d %s">', $items, $display_style);
	}
}

if ( ! function_exists( 'wrapshop_product_wrapper_close' )) {

	function wrapshop_product_wrapper_close () {
		
		echo '</div>';
	}
}

if ( ! function_exists( 'wrapshop_product_gallery_wrapper' ) ) {

	function wrapshop_product_gallery_wrapper() {
		
		$display_style = apply_filters( 'wrapshop_display_gallery_layout_style', 'product-normal');

		printf('<div class="%s">', $display_style );


	}
}

if ( ! function_exists( 'wrapshop_product_gallery_wrapper_close' )) {

	function wrapshop_product_gallery_wrapper_close () {
		
		echo '</div>';
	}
}


if ( !function_exists( 'wrapshop_single_product_summary_custom_wrapper' )) {

	function wrapshop_single_product_summary_custom_wrapper() {

		$display_style = apply_filters( 'wrapshop_display_align_summary_text', 'text-left');

		printf('<div class="%s">', $display_style );


	}
}

if ( ! function_exists( 'wrapshop_single_product_summary_custom_wrapper_close' )) {

	function wrapshop_single_product_summary_custom_wrapper_close() {
		
		echo '</div>';
	}
}


if ( !function_exists( 'wrapshop_single_product_diplay_tabs_wrapper' )) {

	function wrapshop_single_product_diplay_tabs_wrapper() {

		$display_style = apply_filters( 'wrapshop_display_display_tabs_style', 'vertical-tab');

		$tab_align = apply_filters( 'wrapshop_display_display_tabs_align', 'nav-right');

		printf('<div class="%s %s">', $tab_align, $display_style);

	}
}

if ( ! function_exists( 'wrapshop_template_single_meta' ) ) {

	function wrapshop_template_single_meta() {

		$enable_cat = apply_filters( 'wrapshop_product_page_diplay_cateory', '1' );

		if ( $enable_cat ) {
			woocommerce_template_single_meta();
		}
	}
}

if ( ! function_exists( 'wrapshop_cart_sidebar_content' )) {

	function wrapshop_cart_sidebar_content() {

		$content = apply_filters( 'wrapshop_cart_sidebar_content', '');

		if ( $content ) {

			printf( '<div class="cart-sidebar-content">'.  $content . "</div>");

		}

	}
}

if ( ! function_exists( 'wrapshop_cart_after_sidebar_content ')) {

	function wrapshop_cart_after_sidebar_content() {

		$content = apply_filters('wrapshop_cart_after_sidebar_content', '');

		if ( $content ) {

			printf( '<div class="after-cart-content">'.  $content . "</div>");

		}

	}
}


if ( ! function_exists( 'wrapshop_checkout_sidebar_content' ) ) {

	function wrapshop_checkout_sidebar_content() { 

		$content = apply_filters('wrapshop_checkout_sidebar_content', '');

		if ( $content ) {

			printf( '<div class="checkout-sidebar-content">'.  $content . "</div>");

		}
	}


}

if ( ! function_exists( 'wrapshop_shop_messages' ) ) {
	/**
	 * wrapshop shop messages
	 *
	 * @since   1.0.0
	 * @uses    wrapshop_do_shortcode
	 */
	function wrapshop_shop_messages() {
		if ( ! is_checkout() ) {
			echo wp_kses_post( wrapshop_do_shortcode( 'woocommerce_messages' ) );
		}
	}
}

if ( ! function_exists( 'wrapshop_woocommerce_pagination' ) ) {
	/**
	 * wrapshop WooCommerce Pagination
	 * WooCommerce disables the product pagination inside the woocommerce_product_subcategories() function
	 * but since wrapshop adds pagination before that function is excuted we need a separate function to
	 * determine whether or not to display the pagination.
	 *
	 * @since 1.0.0
	 */
	function wrapshop_woocommerce_pagination() {
		if ( woocommerce_products_will_display() ) {
			woocommerce_pagination();
		}
	}
}

if ( ! function_exists( 'wrapshop_promoted_products' ) ) {
	/**
	 * Featured and On-Sale Products
	 * Check for featured products then on-sale products and use the appropiate shortcode.
	 * If neither exist, it can fallback to show recently added products.
	 *
	 * @since  1.0.0
	 * @param integer $per_page total products to display.
	 * @param integer $columns columns to arrange products in to.
	 * @param boolean $recent_fallback Should the function display recent products as a fallback when there are no featured or on-sale products?.
	 * @uses  wrapshop_is_woocommerce_activated()
	 * @uses  wc_get_featured_product_ids()
	 * @uses  wc_get_product_ids_on_sale()
	 * @uses  wrapshop_do_shortcode()
	 * @return void
	 */
	function wrapshop_promoted_products( $per_page = '2', $columns = '2', $recent_fallback = true ) {
		if ( wrapshop_is_woocommerce_activated() ) {

			if ( wc_get_featured_product_ids() ) {

				echo '<h2>' . esc_html__( 'Featured Products', 'wrapshop' ) . '</h2>';

				echo wrapshop_do_shortcode( 'featured_products', array(
											'per_page' => $per_page,
											'columns'  => $columns,
				) );
			} elseif ( wc_get_product_ids_on_sale() ) {

				echo '<h2>' . esc_html__( 'On Sale Now', 'wrapshop' ) . '</h2>';

				echo wrapshop_do_shortcode( 'sale_products', array(
											'per_page' => $per_page,
											'columns'  => $columns,
				) );
			} elseif ( $recent_fallback ) {

				echo '<h2>' . esc_html__( 'New In Store', 'wrapshop' ) . '</h2>';

				echo wrapshop_do_shortcode( 'recent_products', array(
											'per_page' => $per_page,
											'columns'  => $columns,
				) );
			}
		}
	}
}

if ( ! function_exists( 'wrapshop_handheld_footer_bar' ) ) {
	/**
	 * Display a menu intended for use on handheld devices
	 *
	 * @since 1.0.0
	 */
	function wrapshop_handheld_footer_bar() {
		$links = array(
			'my-account' => array(
				'priority' => 10,
				'callback' => 'wrapshop_handheld_footer_bar_account_link',
			),
			'search'     => array(
				'priority' => 20,
				'callback' => 'wrapshop_handheld_footer_bar_search',
			),
			'cart'       => array(
				'priority' => 30,
				'callback' => 'wrapshop_handheld_footer_bar_cart_link',
			),
		);

		if ( wc_get_page_id( 'myaccount' ) === -1 ) {
			unset( $links['my-account'] );
		}

		if ( wc_get_page_id( 'cart' ) === -1 ) {
			unset( $links['cart'] );
		}

		$links = apply_filters( 'wrapshop_handheld_footer_bar_links', $links );
		?>
		<div class="wrapshop-handheld-footer-bar">
			<ul class="columns-<?php echo count( $links ); ?>">
				<?php foreach ( $links as $key => $link ) : ?>
					<li class="<?php echo esc_attr( $key ); ?>">
						<?php
						if ( $link['callback'] ) {
							call_user_func( $link['callback'], $key, $link );
						}
						?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}
}

if ( ! function_exists( 'wrapshop_handheld_footer_bar_search' ) ) {
	/**
	 * The search callback function for the handheld footer bar
	 *
	 * @since 1.0.0
	 */
	function wrapshop_handheld_footer_bar_search() {
		echo '<a href="">' . esc_attr__( 'Search', 'wrapshop' ) . '</a>';
		wrapshop_product_search();
	}
}

if ( ! function_exists( 'wrapshop_handheld_footer_bar_cart_link' ) ) {
	/**
	 * The cart callback function for the handheld footer bar
	 *
	 * @since 1.0.0
	 */
	function wrapshop_handheld_footer_bar_cart_link() {
		?>
			<a class="footer-cart-contents" href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'wrapshop' ); ?>">
				<span class="count"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() );?></span>
			</a>
		<?php
	}
}

if ( ! function_exists( 'wrapshop_handheld_footer_bar_account_link' ) ) {
	/**
	 * The account callback function for the handheld footer bar
	 *
	 * @since 1.0.0
	 */
	function wrapshop_handheld_footer_bar_account_link() {
		echo '<a href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '">' . esc_attr__( 'My Account', 'wrapshop' ) . '</a>';
	}
}

if ( ! function_exists( 'wrapshop_woocommerce_init_structured_data' ) ) {
	/**
	 * WARNING: This function will be deprecated in wrapshop v2.2.
	 *
	 * Generates product category structured data.
	 *
	 * Hooked into `woocommerce_before_shop_loop_item` action hook.
	 */
	function wrapshop_woocommerce_init_structured_data() {
		if ( ! is_product_category() ) {
			return;
		}

		global $product;

		$json['@type']             = 'Product';
		$json['@id']               = 'product-' . get_the_ID();
		$json['name']              = get_the_title();
		$json['image']             = wp_get_attachment_url( $product->get_image_id() );
		$json['description']       = get_the_excerpt();
		$json['url']               = get_the_permalink();
		$json['sku']               = $product->get_sku();

		if ( $product->get_rating_count() ) {
			$json['aggregateRating'] = array(
				'@type'                => 'AggregateRating',
				'ratingValue'          => $product->get_average_rating(),
				'ratingCount'          => $product->get_rating_count(),
				'reviewCount'          => $product->get_review_count(),
			);
		}

		$json['offers'] = array(
			'@type'                  => 'Offer',
			'priceCurrency'          => get_woocommerce_currency(),
			'price'                  => $product->get_price(),
			'itemCondition'          => 'http://schema.org/NewCondition',
			'availability'           => 'http://schema.org/' . $stock = ( $product->is_in_stock() ? 'InStock' : 'OutOfStock' ),
			'seller'                 => array(
				'@type'                => 'Organization',
				'name'                 => get_bloginfo( 'name' ),
			),
		);

		if ( ! isset( $json ) ) {
			return;
		}

		wrapshop::set_structured_data( apply_filters( 'wrapshop_woocommerce_structured_data', $json ) );
	}
}

if ( ! function_exists( 'wrapshop_loop_add_to_cart_wrapper' ) ) {

	function wrapshop_loop_add_to_cart_wrapper() {
		echo '<div class="loop-addtocart-btn-wrapper">';
		
	}
}

if ( ! function_exists( 'wrapshop_loop_add_to_cart_wrapper_close' ) ) {
	
	function wrapshop_loop_add_to_cart_wrapper_close() {
		
		echo '</div>';
		
	}
}

if ( !function_exists ('wrapshop_wishlist_products') ) {

	function wrapshop_wishlist_products() {
		if ( function_exists( 'YITH_WCWL' ) ) {
			global $product;
			$url			 = add_query_arg( 'add_to_wishlist', $product->get_id() );
			$id				 = $product->get_id();
			$wishlist_url	 = YITH_WCWL()->get_wishlist_url();
			?>  
			<div class="add-to-wishlist-custom add-to-wishlist-<?php echo esc_attr( $id ); ?>">

				<div class="yith-wcwl-add-button show" style="display:block"> 
				
					<a href="<?php echo esc_url( $url ); ?>" rel="nofollow" data-product-id="<?php echo esc_attr( $id ); ?>" data-product-type="simple" class="add_to_wishlist"><?php _e( 'Add to Wishlist', 'wrapshop' ); ?></a>

					<img src="<?php echo get_template_directory_uri() . '/assets/images/loading.gif'; ?>" class="ajax-loading" alt="loading" width="16" height="16">
				</div>

				<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"> 
					<span class="feedback"><?php esc_html_e( 'Added!', 'wrapshop' ); ?></span> 
					<a href="<?php echo esc_url( $wishlist_url ); ?>"><?php esc_html_e( 'View Wishlist', 'wrapshop' ); ?></a>

				</div>

				<div class="yith-wcwl-wishlistexistsbrowse hide" style="display:none">
					<span class="feedback"><?php esc_html_e( 'The product is already in the wishlist!', 'wrapshop' ); ?></span>
					<a href="<?php echo esc_url( $wishlist_url ); ?>"><?php esc_html_e( 'Browse Wishlist', 'wrapshop' ); ?></a>
				</div>

				<div class="clear"></div>
				<div class="yith-wcwl-wishlistaddresponse"></div>

			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'wrapshop_template_loop_category_title' ) ) {

	/**
	 * Show the subcategory title in the product loop.
	 */
	function wrapshop_template_loop_category_title( $category ) {
		
		$count_html = ' <span class="count">' . sprintf( _n( '%s Product', '%s Products', $category->count, 'wrapshop' ), $category->count )  . '</span>';

		?>
		<h2 class="woocommerce-loop-category__title">
			<?php
				echo '<span class="cat-txt-title">' . $category->name . '</span>';

				if ( $category->count > 0 )
					echo apply_filters( 'woocommerce_subcategory_count_html', $count_html, $category );
			?>
		</h2>
		<?php

	}
}