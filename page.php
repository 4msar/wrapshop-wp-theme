<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wrapshop
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post();

				do_action( 'wrapshop_page_before' );

				get_template_part( 'template-parts/content', 'page' );

				/**
				 * Functions hooked in to wrapshop_page_after action
				 *
				 * @hooked wrapshop_display_comments - 10
				 */
				do_action( 'wrapshop_page_after' );

			endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'wrapshop_sidebar' );
get_footer();
