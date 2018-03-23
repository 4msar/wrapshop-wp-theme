<?php
/**
 * The template used for displaying page content in tpl-page-homepage.php
 *
 * @package wrapshop
 */

$featured_image = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="<?php wrapshop_homepage_content_styles(); ?>" data-featured-image="<?php echo $featured_image; ?>">
	<div class="col-full">
		<?php
		/**
		 * Functions hooked in to wrapshop_page add_action
		 *
		 * @hooked wrapshop_homepage_header      - 10
		 * @hooked wrapshop_page_content         - 20
		 * @hooked wrapshop_init_structured_data - 30
		 */
		do_action( 'wrapshop_content_homepage' );
		?>
	</div>
</div><!-- #post-## -->
