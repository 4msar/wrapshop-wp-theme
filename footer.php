<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wrapshop
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'wrapshop_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="col-full">

			<?php
			/**
			 * Functions hooked in to wrapshop_footer action
			 *
			 * @hooked wrapshop_footer_widgets - 10
			 * @hooked wrapshop_credit         - 20
			 */
			do_action( 'wrapshop_footer' ); ?>

		</div><!-- .col-full -->
	</footer><!-- #colophon -->

	<?php do_action( 'wrapshop_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
