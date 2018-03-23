<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wrapshop
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	do_action( 'wrapshop_single_post_top' );

	/**
	 * Functions hooked into wrapshop_single_post add_action
	 *
	 * @hooked wrapshop_post_header          - 10
	 * @hooked wrapshop_post_meta            - 20
	 * @hooked wrapshop_post_content         - 30
	 * @hooked wrapshop_footer_meta          - 40
	 * @hooked wrapshop_init_structured_data - 50
	 */
	do_action( 'wrapshop_single_post' );

	/**
	 * Functions hooked in to wrapshop_single_post_bottom action
	 *
	 * @hooked wrapshop_post_nav         - 10
	 * @hooked wrapshop_display_comments - 20
	 */
	do_action( 'wrapshop_single_post_bottom' );
	?>

</article><!-- #post-## -->