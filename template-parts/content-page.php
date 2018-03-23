<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wrapshop
 */

?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Functions hooked in to wrapshop_page add_action
	 *
	 * @hooked wrapshop_page_header          - 10
	 * @hooked wrapshop_page_content         - 20
	 * @hooked wrapshop_init_structured_data - 30
	 */
	do_action( 'wrapshop_page' );
	?>
</div><!-- #post-## -->
