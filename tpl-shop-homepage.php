<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `wrapshop_homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Shop Homepage
 *
 * @package wrapshop
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			/**
			 * Functions hooked in to homepage action
			 *
			 * @hooked wrapshop_homepage_content      - 10
			 * @hooked wrapshop_recent_products       - 20
			 * @hooked wrapshop_best_selling_products - 30
			 * @hooked wrapshop_featured_products     - 40
			 * @hooked wrapshop_popular_products      - 50
			 * @hooked wrapshop_on_sale_products      - 60
			 * @hooked wrapshop_product_categories    - 70
			 */
			do_action( 'shop_homepage' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();