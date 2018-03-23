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
	/**
	 * Functions hooked in to wrapshop_loop_post action.
	 *
	 * @hooked wrapshop_post_header          - 10
	 * @hooked wrapshop_post_meta            - 20
	 * @hooked wrapshop_post_content         - 30	 
	 * @hooked wrapshop_init_structured_data - 40
	 * @hooked wrapshop_footer_meta			- 50
	 */
	do_action( 'wrapshop_loop_post' );
	?>

</article><!-- #post-## -->