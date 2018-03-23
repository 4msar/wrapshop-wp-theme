<?php
/**
 * wrapshop template functions.
 *
 * @package wrapshop
 */
if ( ! function_exists( 'wrapshop_display_comments' ) ) {
	/**
	 * wrapshop display comments
	 *
	 * @since  1.0.0
	 */
	function wrapshop_display_comments() {
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || '0' != get_comments_number() ) :
			comments_template();
		endif;
	}
}

if ( ! function_exists( 'wrapshop_comment' ) ) {
	/**
	 * wrapshop comment template
	 *
	 * @param array $comment the comment array.
	 * @param array $args the comment args.
	 * @param int   $depth the comment depth.
	 * @since 1.0.0
	 */
	function wrapshop_comment( $comment, $args, $depth ) {
		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo esc_attr( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<div class="comment-body">
		<div class="comment-meta commentmetadata">
			<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 70 ); ?>
			
			</div>


		
		</div>
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-content">
		<?php endif; ?>

		<?php printf( wp_kses_post( '<cite class="fn">%s</cite>', 'wrapshop' ), get_comment_author_link() ); ?>

		<?php if ( '0' == $comment->comment_approved ) : ?>
			<em class="comment-awaiting-moderation"><?php esc_attr_e( 'Your comment is awaiting moderation.', 'wrapshop' ); ?></em>
			<br />
		<?php endif; ?>


		<div class="comment-text">
		<?php comment_text(); ?>
		</div>
		<div class="commentmetadata clear">
			<a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>" class="comment-date">
			<?php echo '<time datetime="' . get_comment_date( 'c' ) . '">' . get_comment_date() . '</time>'; ?>
			</a>
			<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			<?php edit_comment_link( __( 'Edit', 'wrapshop' ), '  ', '' ); ?>
			</div>

		</div><!-- #comment-meta -->
		
		</div>
		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
	<?php
	}
}

if ( ! function_exists( 'wrapshop_site_branding' ) ) {
	/**
	 * Site branding wrapper and display
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function wrapshop_site_branding() {
		?>
		<div class="site-branding">
			<?php wrapshop_site_title_or_logo(); ?>
		</div>
		<?php
	}
}


if ( ! function_exists( 'wrapshop_site_branding_wrapper' ) ) {

	function wrapshop_site_branding_wrapper() {
		echo '<div class="header-middle clear">';
	}

}

if ( ! function_exists( 'wrapshop_site_branding_wrapper_close' ) ) {

	function wrapshop_site_branding_wrapper_close() {
		echo '</div>';
	}
	
}

if ( ! function_exists( 'wrapshop_primary_navigation' ) ) {
	/**
	 * Display Primary Navigation
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function wrapshop_primary_navigation() {
		?>
		<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'wrapshop' ); ?>">			

			<?php

			if ( has_nav_menu( 'primary' ) ) :

				?>

				<button class="menu-toggle"><i class="fa fa-bars"></i></button>

				<?php

				wp_nav_menu(
					array(
						'theme_location'	=> 'primary',
						'container_class'	=> 'primary-navigation',
						'walker' => new WS_Walker_Nav_Menu()
						)
				);

			endif;

			?>
		</nav><!-- #site-navigation -->
		<?php
	}
}

if ( ! function_exists( 'wrapshop_secondary_navigation_wrapper' ) ) {
	/**
	 * The second navigation wrapper
	 */
	function wrapshop_secondary_navigation_wrapper() {
		echo '<div class="wrapshop-secondary-navigation">';
	}
}

if ( ! function_exists( 'wrapshop_secondary_navigation_wrapper_close' ) ) {
	/**
	 * The second navigation wrapper close
	 */
	function wrapshop_secondary_navigation_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'wrapshop_top_secondary_social_wrapper' ) ) {
	/**
	 * The second navigation wrapper
	 */
	function wrapshop_top_secondary_social_wrapper() {
		echo '<div class="wrapshop-secondary-social-navigation">';
	}
}

if ( ! function_exists( 'wrapshop_top_secondary_social_wrapper_close' ) ) {
	/**
	 * The second navigation wrapper close
	 */
	function wrapshop_top_secondary_social_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'wrapshop_top_header_leftbox' ) ) {
	/**
	 * The special info on the top left
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function wrapshop_top_header_leftbox() {
		echo '<div class="topbox-left">';
		do_action('wrapshop_top_header_left');
		echo '</div>';
	}
}

if ( ! function_exists( 'wrapshop_top_header_rightbox' ) ) {
	/**
	 * The special info on the top left
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function wrapshop_top_header_rightbox() {
		echo '<div class="topbox-right">';
		do_action('wrapshop_top_header_right');
		echo '</div>';
	}
}

if ( ! function_exists( 'wrapshop_secondary_navigation' ) ) {
	/**
	 * Display Secondary Navigation
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function wrapshop_secondary_navigation() {
	    if ( has_nav_menu( 'secondary' ) ) {
		    ?>
		    <nav class="secondary-navigation" role="navigation" aria-label="<?php esc_html_e( 'Secondary Navigation', 'wrapshop' ); ?>">
			    <?php
				    wp_nav_menu(
					    array(
						    'theme_location'	=> 'secondary',
						    'fallback_cb'		=> '',
							'walker' => new WS_Walker_Nav_Menu(),
							
					    )
				    );
			    ?>
		    </nav><!-- #site-navigation -->
		    <?php
		}
	}
}

if ( ! function_exists( 'wrapshop_social_navigation' ) ) {
	/**
	 * Display social menu
	 */
	function wrapshop_social_navigation() {
		if ( has_nav_menu( 'social' ) ) {
		    ?>
		    <nav class="social-navigation" role="navigation" aria-label="<?php esc_html_e( 'Social Navigation', 'wrapshop' ); ?>">
			    <?php
				    wp_nav_menu(
					    array(
						    'theme_location'	=> 'social',
						    'fallback_cb'		=> '',
							'walker' => new WS_Walker_Nav_Menu()
					    )
				    );
			    ?>
		    </nav><!-- #site-navigation -->
		    <?php
		}
	}
}
if ( ! function_exists( 'wrapshop_skip_links' ) ) {
	/**
	 * Skip links
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function wrapshop_skip_links() {
		?>
		<a class="skip-link screen-reader-text" href="#site-navigation"><?php esc_attr_e( 'Skip to navigation', 'wrapshop' ); ?></a>
		<a class="skip-link screen-reader-text" href="#content"><?php esc_attr_e( 'Skip to content', 'wrapshop' ); ?></a>
		<?php
	}
}
if ( ! function_exists( 'wrapshop_site_title_or_logo' ) ) {
	/**
	 * Display the site title or logo
	 *
	 * @since 1.0.0
	 * @param bool $echo Echo the string or return it.
	 * @return string
	 */
	function wrapshop_site_title_or_logo( $echo = true ) {
		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			$logo = get_custom_logo();
			$html = is_home() ? '<h1 class="logo">' . $logo . '</h1>' : $logo;
		} elseif ( function_exists( 'jetpack_has_site_logo' ) && jetpack_has_site_logo() ) {
			// Copied from jetpack_the_site_logo() function.
			$logo    = site_logo()->logo;
			$logo_id = get_theme_mod( 'custom_logo' ); // Check for WP 4.5 Site Logo
			$logo_id = $logo_id ? $logo_id : $logo['id']; // Use WP Core logo if present, otherwise use Jetpack's.
			$size    = site_logo()->theme_size();
			$html    = sprintf( '<a href="%1$s" class="site-logo-link" rel="home" itemprop="url">%2$s</a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image(
					$logo_id,
					$size,
					false,
					array(
						'class'     => 'site-logo attachment-' . $size,
						'data-size' => $size,
						'itemprop'  => 'logo'
					)
				)
			);

			$html = apply_filters( 'jetpack_the_site_logo', $html, $logo, $size );
		} else {
			$tag = is_home() ? 'h1' : 'div';

			$html = '<' . esc_attr( $tag ) . ' class="beta site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a></' . esc_attr( $tag ) .'>';

			if ( '' !== get_bloginfo( 'description' ) ) {
				$html .= '<p class="site-description">' . esc_html( get_bloginfo( 'description', 'display' ) ) . '</p>';
			}
		}

		if ( ! $echo ) {
			return $html;
		}

		echo $html;
	}
}

if ( ! function_exists( 'wrapshop_page_header' ) ) {
	/**
	 * Display the post header with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function wrapshop_page_header() {
		?>
		<header class="entry-header">
			<?php
			wrapshop_post_thumbnail( 'full' );
			the_title( '<h1 class="entry-title">', '</h1>' );
			?>
		</header><!-- .entry-header -->
		<?php
	}
}

if ( ! function_exists( 'wrapshop_page_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function wrapshop_page_content() {
		?>
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'wrapshop' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
		<?php
	}
}

if ( ! function_exists( 'wrapshop_post_header' ) ) {
	/**
	 * Display the post header with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function wrapshop_post_header() {
		?>
		<header class="entry-header">
		<?php
		if ( is_single() ) {
		
			the_title( '<h1 class="entry-title">', '</h1>' );

		} else {		

			the_title( sprintf( '<h2 class="alpha entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

		}
		?>
		</header><!-- .entry-header -->
		<?php
	}
}

if ( ! function_exists( 'wrapshop_before_footer_payment' ) ) {
	/**
	 * Display the post header with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function wrapshop_before_footer_payment() {
		?>
		<div class="payment-method">
		<?php
		if ( is_active_sidebar( 'before-footer-payment' ) ) {
			$widget_columns = apply_filters( 'wrapshop_before_footer_widget', 1 );
		}
		
		if ( isset($widget_columns) > 0 ) : ?>

			<div class="before-footer-widgets fix">

				<div class="block before-footer-widget">
					<?php dynamic_sidebar( 'before-footer-payment' ); ?>
				</div>

			</div><!-- /.footer-widgets  -->

		<?php endif;
		?>
		</div><!-- .entry-header -->
		<?php
	}
}
if ( ! function_exists( 'wrapshop_footer_widgets' ) ) {
	/**
	 * Display the footer widget regions
	 *
	 * @since  1.0.0
	 * @return  void
	 */
	function wrapshop_footer_widgets() {
		if ( is_active_sidebar( 'footer-4' ) ) {
			$widget_columns = apply_filters( 'wrapshop_footer_widget_regions', 4 );
		} elseif ( is_active_sidebar( 'footer-3' ) ) {
			$widget_columns = apply_filters( 'wrapshop_footer_widget_regions', 3 );
		} elseif ( is_active_sidebar( 'footer-2' ) ) {
			$widget_columns = apply_filters( 'wrapshop_footer_widget_regions', 2 );
		} elseif ( is_active_sidebar( 'footer-1' ) ) {
			$widget_columns = apply_filters( 'wrapshop_footer_widget_regions', 1 );
		} else {
			$widget_columns = apply_filters( 'wrapshop_footer_widget_regions', 0 );
		}

		if ( $widget_columns > 0 ) : ?>

			<div class="footer-widgets col-<?php echo intval( $widget_columns ); ?> fix">

				<?php
				$i = 0;
				while ( $i < $widget_columns ) : $i++;
					if ( is_active_sidebar( 'footer-' . $i ) ) : ?>

						<div class="block footer-widget-<?php echo intval( $i ); ?>">
							<?php dynamic_sidebar( 'footer-' . intval( $i ) ); ?>
						</div>

					<?php endif;
				endwhile; ?>

			</div><!-- /.footer-widgets  -->

		<?php endif;
	}
}

if ( ! function_exists( 'wrapshop_credit' ) ) {
	/**
	 * Display the theme credit
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function wrapshop_credit() {
		?>
		<div class="site-info">
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<div class="footer-menu">
				<?php
					wp_nav_menu( array(
						'theme_location'	=> 'footer',
						'container_class'	=> 'footer-navigation',
						'walker' => new WS_Walker_Nav_Menu()
					));
				?>
			</div>
			<?php endif; ?>
			<?php echo esc_html( apply_filters( 'wrapshop_copyright_text', $content = '' . get_bloginfo( 'name' ) . ' &copy;' . date( 'Y' ) ) ); ?>.
			<?php if ( apply_filters( 'wrapshop_credit_link', true ) ) { ?>
				<?php printf( esc_attr__( ' %1$s Designed by %2$s.', 'wrapshop' ), 'Wrap Shop', '<a href="https://wrapcoder.wordpress.com" title="Wrap Coder - The Best Free WooCommerce for WordPress" rel="author">Wrap Coder</a>' ); ?>
			<?php } ?>

			
		</div><!-- .site-info -->
		<?php
	}
}

if ( ! function_exists( 'wrapshop_backtotop ') ) {
	/**
	 * Display Footer Back To Top
	 *
	 * @since  1.0.0
	 */

	function wrapshop_backtotop() {
		?>

		<span class="back-to-top"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>

		<?php
	}
}


if ( ! function_exists( 'wrapshop_header_widget_region' ) ) {
	/**
	 * Display header widget region
	 *
	 * @since  1.0.0
	 */
	function wrapshop_header_widget_region() {
		if ( is_active_sidebar( 'header-1' ) ) {
		?>
		<div class="header-widget-region" role="complementary">
			<div class="col-full">
				<?php dynamic_sidebar( 'header-1' ); ?>
			</div>
		</div>
		<?php
		}
	}
}

if ( ! function_exists( 'wrapshop_post_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function wrapshop_post_content() {
		?>
		<div class="entry-content">
		<?php

		$size = apply_filters('wrapshop_thunmbnail_size', 'large');
		$wrapshop_display_excerpt = apply_filters('wrapshop_display_excerpt', true);

		/**
		 * Functions hooked in to wrapshop_post_content_before action.
		 *
		 * @hooked wrapshop_post_thumbnail - 10
		 */
		do_action( 'wrapshop_post_content_before' );



		if ( ($wrapshop_display_excerpt) && ( is_search() || is_archive() || is_front_page() || is_home() )  ) {

			the_excerpt();


		} else {

			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue Reading %s <span class="meta-nav">&rarr;</span>', 'wrapshop' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )

			) );
		}

		do_action( 'wrapshop_post_content_after' );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'wrapshop' ),
			'after'  => '</div>',
		) );
		?>
		</div><!-- .entry-content -->
		<?php
	}
}

if ( ! function_exists( 'wrapshop_footer_meta' ) ) {
	/**
	 * Display the Footer meta
	 *
	 * @since 1.0.0
	 */
	function wrapshop_footer_meta() {
		?>
		<div class="entry-footer">

		<?php

			if ( is_single() ) {

				wrapshop_posted_on();
			} else {

				if ( 'post' == get_post_type() ) {
					wrapshop_posted_on();
				}
			}

			?>

			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
								
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'wrapshop' ), __( '1 Comment', 'wrapshop' ), __( '% Comments', 'wrapshop' ) ); ?></span>
				
			<?php endif; ?>


		</div>

	<?php
	}
}

if ( ! function_exists( 'wrapshop_post_content_after' ) ) {
	/**
	 * Display the Continue Reading
	 *
	 * @since 1.0.0
	 */
	function wrapshop_post_content_after() {
		?>
		<a href="<?php echo esc_url( get_permalink() ) ?>"  title="<?php the_title() ?>" class="more-link"><?php esc_html_e( '[Continue Reading ...]', 'wrapshop' ); ?></a>


		<?php
	}
}


if ( ! function_exists( 'wrapshop_post_meta' ) ) {
	/**
	 * Display the post meta
	 *
	 * @since 1.0.0
	 */
	function wrapshop_post_meta() {
		?>
		<aside class="entry-meta">
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search.

			?>
			<div class="author">
				<?php
					//echo get_avatar( get_the_author_meta( 'ID' ), 128 );
					echo '<div class="label">' . esc_attr( __( 'By', 'wrapshop' ) ) . '</div>';
					the_author_posts_link();
				?>
			</div>
			<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'wrapshop' ) );

			if ( $categories_list ) : ?>
				<div class="cat-links">
					<?php
					echo '<div class="label">' . esc_attr( __( 'Posted in', 'wrapshop' ) ) . '</div>';
					echo wp_kses_post( $categories_list );
					?>
				</div>
			<?php endif; // End if categories. ?>

			<?php
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', __( ', ', 'wrapshop' ) );

			if ( $tags_list ) : ?>
				<div class="tags-links">
					<?php
					echo '<div class="label">' . esc_attr( __( 'Tagged', 'wrapshop' ) ) . '</div>';
					echo wp_kses_post( $tags_list );
					?>
				</div>
			<?php endif; // End if $tags_list. ?>

		<?php endif; // End if 'post' == get_post_type(). ?>


		</aside>
		<?php
	}
}

if ( ! function_exists( 'wrapshop_paging_nav' ) ) {
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function wrapshop_paging_nav() {
		global $wp_query;

		$args = array(
			'type' 	    => 'list',
			'next_text' => _x( 'Next', 'Next post', 'wrapshop' ),
			'prev_text' => _x( 'Previous', 'Previous post', 'wrapshop' ),
			);

		the_posts_pagination( $args );
	}
}

if ( ! function_exists( 'wrapshop_post_nav' ) ) {
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function wrapshop_post_nav() {
		$args = array(
			'next_text' => '%title',
			'prev_text' => '%title',
			);
		the_post_navigation( $args );
	}
}

if ( ! function_exists( 'wrapshop_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function wrapshop_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time> <time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			_x( 'Posted on %s', 'post date', 'wrapshop' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo wp_kses( apply_filters( 'wrapshop_single_post_posted_on_html', '<span class="posted-on">' . $posted_on . '</span>', $posted_on ), array(
			'span' => array(
				'class'  => array(),
			),
			'a'    => array(
				'href'  => array(),
				'title' => array(),
				'rel'   => array(),
			),
			'time' => array(
				'datetime' => array(),
				'class'    => array(),
			),
		) );
	}
}

if ( ! function_exists( 'wrapshop_get_sidebar' ) ) {
	/**
	 * Display wrapshop sidebar
	 *
	 * @uses get_sidebar()
	 * @since 1.0.0
	 */
	function wrapshop_get_sidebar() {

		$enable_sidebar = apply_filters( 'wrapshop_enable_sidebar', true);

		if ( $enable_sidebar ) {

			get_sidebar();
		}
	}
}

if ( ! function_exists( 'wrapshop_post_thumbnail' ) ) {
	/**
	 * Display post thumbnail
	 *
	 * @var $size thumbnail size. thumbnail|medium|large|full|$custom
	 * @uses has_post_thumbnail()
	 * @uses the_post_thumbnail
	 * @param string $size the post thumbnail size.
	 * @since 1.0.0
	 */
	function wrapshop_post_thumbnail( $size = 'full' ) {
		if ( has_post_thumbnail() ) {
			?>
			<div class="thumbnail-blog">

				<a href="<?php the_permalink() ?>" rel="bookmark" class="featured-thumbnail">

					<?php the_post_thumbnail( $size ); ?>
				</a>

			</div>

			<?php

		}
	}
}

if ( ! function_exists( 'wrapshop_primary_navigation_wrapper' ) ) {
	/**
	 * The primary navigation wrapper
	 */
	function wrapshop_primary_navigation_wrapper() {
		echo '<div class="wrapshop-primary-navigation clear">';
	}
}


if ( ! function_exists( 'wrapshop_primary_navigation_wrapper_close' ) ) {
	/**
	 * The primary navigation wrapper close
	 */
	function wrapshop_primary_navigation_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'wrapshop_init_structured_data' ) ) {
	/**
	 * Generates structured data.
	 *
	 * Hooked into the following action hooks:
	 *
	 * - `wrapshop_loop_post`
	 * - `wrapshop_single_post`
	 * - `wrapshop_page`
	 *
	 * Applies `wrapshop_structured_data` filter hook for structured data customization :)
	 */
	function wrapshop_init_structured_data() {

		// Post's structured data.
		if ( is_home() || is_category() || is_date() || is_search() || is_single() && ( wrapshop_is_woocommerce_activated() && ! is_woocommerce() ) ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'normal' );
			$logo  = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );

			$json['@type']            = 'BlogPosting';

			$json['mainEntityOfPage'] = array(
				'@type'                 => 'webpage',
				'@id'                   => get_the_permalink(),
			);

			$json['publisher']        = array(
				'@type'                 => 'organization',
				'name'                  => get_bloginfo( 'name' ),
				'logo'                  => array(
					'@type'               => 'ImageObject',
					'url'                 => $logo[0],
					'width'               => $logo[1],
					'height'              => $logo[2],
				),
			);

			$json['author']           = array(
				'@type'                 => 'person',
				'name'                  => get_the_author(),
			);

			if ( $image ) {
				$json['image']            = array(
					'@type'                 => 'ImageObject',
					'url'                   => $image[0],
					'width'                 => $image[1],
					'height'                => $image[2],
				);
			}

			$json['datePublished']    = get_post_time( 'c' );
			$json['dateModified']     = get_the_modified_date( 'c' );
			$json['name']             = get_the_title();
			$json['headline']         = $json['name'];
			$json['description']      = get_the_excerpt();

		// Page's structured data.
		} elseif ( is_page() ) {
			$json['@type']            = 'WebPage';
			$json['url']              = get_the_permalink();
			$json['name']             = get_the_title();
			$json['description']      = get_the_excerpt();
		}

		if ( isset( $json ) ) {
			wrapshop::set_structured_data( apply_filters( 'wrapshop_structured_data', $json ) );
		}
	}
}
if ( ! function_exists( 'wrapshop_homepage_content' ) ) {
	/**
	 * Display homepage content
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @return  void
	 */
	function wrapshop_homepage_content() {
		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content', 'homepage' );

		} // end of the loop.
	}
}

if ( ! function_exists( 'wrapshop_homepage_header' ) ) {
	/**
	 * Display the page header without the featured image
	 *
	 * @since 1.0.0
	 */
	function wrapshop_homepage_header() {
		edit_post_link( __( 'Edit this section', 'wrapshop' ), '', '', '', 'button wrapshop-hero__button-edit' );
		?>
		<header class="entry-header">
			<?php
			the_title( '<h1 class="entry-title">', '</h1>' );
			?>
		</header><!-- .entry-header -->
		<?php
	}
}

if ( ! function_exists( 'wrapshop_product_categories' ) ) {
	/**
	 * Display Product Categories
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function wrapshop_product_categories( $args ) {

		if ( wrapshop_is_woocommerce_activated() ) {

			$args = apply_filters( 'wrapshop_product_categories_args', array(
				'limit' 			=> 4,
				'columns' 			=> 4,
				'child_categories' 	=> 0,
				'orderby' 			=> 'name',
				'title'				=> __( 'Shop by Category', 'wrapshop' ),
			) );

			echo '<section class="wrapshop-product-section wrapshop-product-categories" aria-label="Product Categories">';

			do_action( 'wrapshop_homepage_before_product_categories' );

			echo '<h2 class="section-title"><span>' . wp_kses_post( $args['title'] ) . '</span></h2>';

			do_action( 'wrapshop_homepage_after_product_categories_title' );

			echo wrapshop_do_shortcode( 'product_categories', array(
				'number'  => intval( $args['limit'] ),
				'columns' => intval( $args['columns'] ),
				'orderby' => esc_attr( $args['orderby'] ),
				'parent'  => esc_attr( $args['child_categories'] ),
			) );

			do_action( 'wrapshop_homepage_after_product_categories' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'wrapshop_recent_products' ) ) {
	/**
	 * Display Recent Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function wrapshop_recent_products( $args ) {

		if ( wrapshop_is_woocommerce_activated() ) {

			$args = apply_filters( 'wrapshop_recent_products_args', array(
				'limit' 			=> 8,
				'columns' 			=> 4,
				'title'				=> __( 'Recent Products', 'wrapshop' ),
			) );

			echo '<section class="wrapshop-product-section wrapshop-recent-products" aria-label="Recent Products">';

			do_action( 'wrapshop_homepage_before_recent_products' );

			echo '<h2 class="section-title"><span>' . wp_kses_post( $args['title'] ) . '</span></h2>';

			do_action( 'wrapshop_homepage_after_recent_products_title' );

			echo wrapshop_do_shortcode( 'recent_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );

			do_action( 'wrapshop_homepage_after_recent_products' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'wrapshop_featured_products' ) ) {
	/**
	 * Display Featured Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function wrapshop_featured_products( $args ) {

		if ( wrapshop_is_woocommerce_activated() ) {

			$args = apply_filters( 'wrapshop_featured_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'orderby' => 'date',
				'order'   => 'desc',
				'title'   => __( 'We Recommend', 'wrapshop' ),
			) );

			echo '<section class="wrapshop-product-section wrapshop-featured-products" aria-label="Featured Products">';

			do_action( 'wrapshop_homepage_before_featured_products' );

			echo '<h2 class="section-title"><span>' . wp_kses_post( $args['title'] ) . '</span></h2>';

			do_action( 'wrapshop_homepage_after_featured_products_title' );

			echo wrapshop_do_shortcode( 'featured_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
				'orderby'  => esc_attr( $args['orderby'] ),
				'order'    => esc_attr( $args['order'] ),
			) );

			do_action( 'wrapshop_homepage_after_featured_products' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'wrapshop_popular_products' ) ) {
	/**
	 * Display Popular Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function wrapshop_popular_products( $args ) {

		if ( wrapshop_is_woocommerce_activated() ) {

			$args = apply_filters( 'wrapshop_popular_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'title'   => __( 'Fan Favorites', 'wrapshop' ),
			) );

			echo '<section class="wrapshop-product-section wrapshop-popular-products" aria-label="Popular Products">';

			do_action( 'wrapshop_homepage_before_popular_products' );

			echo '<h2 class="section-title"><span>' . wp_kses_post( $args['title'] ) . '</span></h2>';

			do_action( 'wrapshop_homepage_after_popular_products_title' );

			echo wrapshop_do_shortcode( 'top_rated_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );

			do_action( 'wrapshop_homepage_after_popular_products' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'wrapshop_on_sale_products' ) ) {
	/**
	 * Display On Sale Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @param array $args the product section args.
	 * @since  1.0.0
	 * @return void
	 */
	function wrapshop_on_sale_products( $args ) {

		if ( wrapshop_is_woocommerce_activated() ) {

			$args = apply_filters( 'wrapshop_on_sale_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'title'   => __( 'On Sale', 'wrapshop' ),
			) );

			echo '<section class="wrapshop-product-section wrapshop-on-sale-products" aria-label="On Sale Products">';

			do_action( 'wrapshop_homepage_before_on_sale_products' );

			echo '<h2 class="section-title"><span>' . wp_kses_post( $args['title'] ) . '</span></h2>';

			do_action( 'wrapshop_homepage_after_on_sale_products_title' );

			echo wrapshop_do_shortcode( 'sale_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );

			do_action( 'wrapshop_homepage_after_on_sale_products' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'wrapshop_best_selling_products' ) ) {
	/**
	 * Display Best Selling Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since 2.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function wrapshop_best_selling_products( $args ) {
		if ( wrapshop_is_woocommerce_activated() ) {
			$args = apply_filters( 'wrapshop_best_selling_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'title'	  => esc_attr__( 'Best Sellers', 'wrapshop' ),
			) );
			echo '<section class="wrapshop-product-section wrapshop-best-selling-products" aria-label="Best Selling Products">';
			do_action( 'wrapshop_homepage_before_best_selling_products' );
			echo '<h2 class="section-title"><span>' . wp_kses_post( $args['title'] ) . '</span></h2>';
			do_action( 'wrapshop_homepage_after_best_selling_products_title' );
			echo wrapshop_do_shortcode( 'best_selling_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );
			do_action( 'wrapshop_homepage_after_best_selling_products' );
			echo '</section>';
		}
	}
}

if ( ! function_exists( 'wrapshop_latest_from_blog' ) ) {
	/**
	 * Get the latest posts from blog
	 * 
	 * @return [type] [description]
	 */
	function wrapshop_latest_from_blog() {

		$args = apply_filters( 'wrapshop_latest_from_blog_args', array(
				'limit'   => 4,
				'columns' => 4,
				'title'   => __( 'The latest news', 'wrapshop' ),
			) );

			echo '<section class="wrapshop-product-section wrapshop-latest-from-blog">';

			do_action( 'wrapshop_homepage_before_latest_from_blog_title' );

			echo '<h2 class="section-title"><span>' . wp_kses_post( $args['title'] ) . '</span></h2>';

			do_action( 'wrapshop_homepage_after_latest_from_blog_title' );

			wrapshop_the_recent_posts( array(
				'numberposts' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );

			do_action( 'wrapshop_homepage_after_latest_from_blog' );

			echo '</section>';
	}

}

if ( ! function_exists( 'wrapshop_the_recent_posts' )) {

	function wrapshop_the_recent_posts( $args ) {

		global $post;

		$default = array(
				'numberposts'			=> 4,
				'columns'				=> 4,
			);

		$args = wp_parse_args ($args, $default);

		$recent_posts = wp_get_recent_posts( $args, OBJECT);
		

		if ( $recent_posts ) {

			echo '<div class="columns-'. $args['columns'] .'"><ul class="wrapshop-recent-posts products">';

				foreach($recent_posts as $post) :

					setup_postdata( $post );

					?>
						<li <?php post_class(); ?>>
							<a href="<?php the_permalink(); ?>" class="link-recent-post">
								<div class="post-thumbnail">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail('medium') ?>
								<?php else : ?>
									<img src="<?php echo get_template_directory_uri().'/assets/images/placeholder.png'; ?>" alt="<?php the_title() ?>">
								<?php endif; ?>
								</div>
								<h4 class="recent-post-title"><?php the_title() ?></h4>
								
							</a>
							<div class="rec-post-excerpt">
								<?php the_excerpt() ?>
							</div>

							
							<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
												
								<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'wrapshop' ), __( '1 Comment', 'wrapshop' ), __( '% Comments', 'wrapshop' ) ); ?></span>
								
							<?php endif; ?>

						</li>
					<?php 
				endforeach;

				wp_reset_postdata();

			echo '</ul></div>';

		}
	}
}


/************************* START EXTRA  FUNCTION ******************************/

if ( ! function_exists( 'ws_boxed_layout' )) {
	/**
	 * Display Content in a Boxed Layout
	 * Hooked into the `header` action 
	 *
	 * @since 1.0
	 * @return style
	 */
	function ws_boxed_layout(){
		?>
		<style type="text/css">
		 body.boxed-sidebar{
			max-width: <?php echo get_theme_mod('boxed_layout_width'); ?>px !important;
			float: none;
			margin: 0 auto;
			box-shadow: 0 0 20px 1px rgba(51, 51, 51, 0.45);
			
		}
		 .boxed-sidebar header#masthead {
			max-width:  <?php echo get_theme_mod('boxed_layout_width'); ?>px;
		 }
		@media screen and ( min-width: 768px ) {
			.boxed-sidebar .wrapshop-secondary-navigation {
				width: 100%;
				background: transparent;
				padding: 0px;
				display: block;
				margin: 0 auto;
				border-bottom: 1px solid #555;
			}
			
			.boxed-sidebar .wrapshop-primary-navigation{
				border-top: 1px solid <?php get_theme_mod( 'wrapshop_header_text_color', '#999' ) ?>
			}
		}

		.boxed-sidebar .wrapshop-primary-navigation.clear {
			width: 100%;
			float: none;
			margin: 0;
			padding: 0;
			background: transparent !important;
		}

		</style>
		<?php 
	}
}



if ( ! function_exists( 'ws_sticky_header_menu' )) {
	/**
	 * Display Header Primary Menu as Sticky / Fixed
	 * Hooked into the `header` action 
	 *
	 * @since 1.0
	 * @return style
	 */
	function ws_sticky_header_menu() {
		?>
			 <style type="text/css">
				.header-widget-region .widget {
					padding: 0 !important;
				}
				.boxed-sidebar header#masthead.boxed-true {
					max-width:  <?php echo get_theme_mod('boxed_layout_width'); ?>px;
				 }
				@media screen and ( min-width: 768px ) {
					header#masthead {
					transition: 0.6s ease;
					position: fixed;
					z-index: 999;
					width: 100%;
					box-shadow: 0 0 12px 2px rgba(0, 0, 0, 0.45);
					}
					#masthead .wrapshop-primary-navigation.clear {
						background-color: #212121;
					}
				}
			 </style>
			 <script>
				
				jQuery(function ($) {
	 
				 /* You can safely use $ in this code block to reference jQuery */
				 
				 $(document).ready(function() {
					 var header_height = $('#masthead').height();
					 var top_nav = $('.wrapshop-secondary-navigation').height();
					 var mid_nav = $('.header-middle').height();
					 var bot_nav = $('.wrapshop-primary-navigation').height();
					
					if($(window).width() > 767){
						$('#fixed-header-fix').css('margin-top',header_height+'px');
					}
					$('#order_review').hasClass('.payment-fixed', function(){
						$(this).css('margin-top',header_height+'px');
					});
					
					
					 $(window).scroll(function() {
						 
						if ($(window).scrollTop() > mid_nav && $(window).width() > 667) {
							$('#masthead .wrapshop-secondary-navigation').css({
								'opacity':'0',
								'visibility': 'hidden',
								'transition': '0.6s ease'
							});
							$('.header-middle').css({
								'transition': '0.6s ease',
								'margin-top':-top_nav,
								'margin-bottom':-bot_nav
							});
							$('#masthead .site-description').hide(200);
							$('.wrapshop-primary-navigation').css({
								'opacity':'0',
								'visibility': 'hidden',
								'transition': '0.6s ease'
							});
						}else{
								$('#masthead .wrapshop-secondary-navigation').css({
									'transition': '0.6s ease',
									'opacity':'1',
									'visibility': 'visible'
								});
								$('#masthead .site-description').show(200);
								$('.wrapshop-primary-navigation').css({
									'transition': '0.6s ease',
									'opacity':'1',
									'visibility': 'visible'
								});
								$('.header-middle').css({
									'height': 'auto',
									'margin-top':'0',
									'margin-bottom':'0',
									'padding': '10px 0px'
								});
							}
						 
						 });
					 var iScrollPos = $(window).scrollTop();//0;
					$(window).scroll(function () {
						var iCurScrollPos = $(this).scrollTop();
						if (iCurScrollPos > iScrollPos) {
							//Scrolling Down
							//$('.site-description').text('down');
							$('#masthead .wrapshop-primary-navigation').css({
								'opacity':'0',
								'visibility': 'hidden'
							});
							$('.header-middle').css({
								'margin-bottom':-bot_nav,
								'padding': '8px 0px'
							});
							
						} else {
						   //Scrolling Up
						   //$('.site-description').text('up');
							$('#masthead .wrapshop-primary-navigation').css({
								'opacity':'1',
								'visibility': 'visible'								
							});
							$('.header-middle').css({
								'margin-bottom':'0',
								'padding': '8px 0px'
							});
						}
						iScrollPos = iCurScrollPos;
					});
					
					 });//end of document
				});//end of jquery
			 </script>
		<?php
	}
}

if ( ! function_exists( 'wrapshop_ajaxurl' )) {
	/**
	 * Wrap Shop Ajax url for Javascript
	 * Hooked into the `header`
	 *
	 * @since 1.0
	 * @return style
	 */
	function wrapshop_ajaxurl() {
	?>
		<script type="text/javascript">
			var wrapshop_ajaxurl = '<?php echo admin_url('admin-ajax.php', 'relative'); ?>';
		</script>
	<?php
	} 
}

if ( ! function_exists( 'wrapshop_quickview' )) {
	/**
	 * Display a Quick View Button in every Products
	 * Hooked into the `shop` products item
	 *
	 * @since 1.0
	 * @return style, html with data
	 */
	function wrapshop_quickview() {
		?>
	<div class="cd-quick-view woocommerce">
	</div> <!-- cd-quick-view -->
		<?php
	}
}

if ( ! function_exists( 'shop_loop_columns' )) {
	/**
	 * Display Culomn in shop page 
	 * Hooked into the `shop` page
	 *
	 * @since 1.0
	 * @return number
	 */
	function shop_loop_columns() {
		return get_theme_mod('shop_loop_column', 3); // 3 products per row
	}
}


if ( ! function_exists( 'ws_loop_shop_per_page' )) {
	/**
	 * Display Product Per in shop page 
	 * Hooked into the `shop` page
	 *
	 * @since 1.0
	 * @return number
	 */
	function ws_loop_shop_per_page( $cols ) {
	  // $cols contains the current number of products per page based on the value stored on Options -> Reading
	  // Return the number of products you wanna show per page.
	  $cols = get_theme_mod('shop_products_per_page', 10);
	  return $cols;
	}
}

if ( ! function_exists( 'custom_admin_scripts' )) {
	/**
	 * Display Icon picker in Each MENU Item
	 * Hooked into the `Extra` 
	 *
	 * @since 1.0
	 * @return style css js
	 */
	function custom_admin_scripts() {
		$css = get_template_directory_uri(). '/assets/css/icon-picker.css';
		wp_enqueue_style( 'dashicons-picker', $css, array( 'dashicons' ), '1.0' );

		
	   $font2 = get_template_directory_uri() . '/assets/css/font-awesome.css';
	   wp_enqueue_style( 'font-awesome-css', $font2,'','');

		$js = get_template_directory_uri() . '/assets/js/icon-picker.js';
		wp_enqueue_script( 'dashicons-picker', $js, array( 'jquery' ), '1.0' );

        
	}
}



if ( ! function_exists( 'ws_menu_item_additional_fields' )) {
	/**
	 *  Register Menu Item Meta Field
	 * Hooked into the `menu` item
	 *
	 * @since 1.0
	 * @used Used wrap-shop-nav-walker-class.php & wrap-shop-nav-walker.php
	 * @return array
	 */
	
	
	function ws_menu_item_additional_fields( $fields ) {
		$fields['icon'] = array(
			'name' => 'icon',
			'label' => __('Select Icon or Type icon class', 'wrapshop'),
			'container_class' => 'icon-picker-container',
			'input_type' => 'text',
		);

		return $fields;
	}
}
