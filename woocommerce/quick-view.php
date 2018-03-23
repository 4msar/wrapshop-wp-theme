<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

while ( have_posts() ) : the_post();

	global $post, $product;

    add_action( 'woocommerce_before_single_product_summary_sale_flash', 'woocommerce_show_product_sale_flash', 10 );
    add_action( 'woocommerce_before_single_product_summary_product_images', 'woocommerce_show_product_images', 20 );

    add_action( 'woocommerce_single_product_summary_single_title', 'woocommerce_template_single_title', 5 );
    add_action( 'woocommerce_single_product_summary_single_rating', 'woocommerce_template_single_rating', 10 );
    add_action( 'woocommerce_single_product_summary_single_price', 'woocommerce_template_single_price', 10 );
    add_action( 'woocommerce_single_product_summary_single_excerpt', 'woocommerce_template_single_excerpt', 20 );
    add_action( 'woocommerce_single_product_summary_single_add_to_cart', 'woocommerce_template_single_add_to_cart', 30 );
    add_action( 'woocommerce_single_product_summary_single_meta', 'woocommerce_template_single_meta', 40 );
    add_action( 'woocommerce_single_product_summary_single_sharing', 'woocommerce_template_single_sharing', 50 );

    add_action( 'woocommerce_product_summary_thumbnails', 'woocommerce_show_product_thumbnails', 20 );

    function add_product_class($classes) {
	    $classes[] = "product";
	    return $classes;
	}
	add_filter('post_class', 'add_product_class');

	?>
	
	<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

		<a role="button" class="cd-close">
			<i style="position: fixed; margin: 5px -5px;" class="fa fa-times" aria-hidden="true"></i>
		</a>
        <div class="cd-slider-wrapper">   
        	<?php  
            $image_title 				= esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_src 					= wp_get_attachment_image_src( get_post_thumbnail_id(), 'shop_thumbnail' );
			$image_data_src				= wp_get_attachment_image_src( get_post_thumbnail_id(), 'shop_single' );
			$image_data_src_original 	= wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
			$image_link  				= wp_get_attachment_url( get_post_thumbnail_id() );
			$image       				= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
			$image_original				= get_the_post_thumbnail( $post->ID, 'full' );
			$attachment_count   		= count( $product->get_gallery_image_ids() );
			$catalog_image 				= get_the_post_thumbnail( $post->ID, 'shop_catalog');
			?>

			<div class="cover-image" id='cov_img' data-p_id = "<?php the_ID(); ?>">
				<?php echo $image_original; ?>
            </div>
			<?php  //do_action('wc_qv_after_product_image'); ?>
			<div class="product_gal">
				<?php
				$attachment_ids = $product->get_gallery_image_ids();
				if ( $attachment_ids ) {
				    echo $image_original;
					foreach ( $attachment_ids as $attachment_id ) {
						$image_link = wp_get_attachment_url( $attachment_id );
						if (!$image_link) continue;
						$image_title       			= esc_attr( get_the_title( $attachment_id ) );
						$image_src         			= wp_get_attachment_image_src( $attachment_id, 'shop_single_small_thumbnail' );
						$image_data_src    			= wp_get_attachment_image_src( $attachment_id, 'shop_single' );
						$image_data_src_original 	= wp_get_attachment_image_src( $attachment_id, 'full' );
						$image_link        			= wp_get_attachment_url( $attachment_id );
						$image		      			= wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );?>
						<img class="img-zoom" src="<?php echo esc_url($image_data_src[0]); ?>">
						<?php
						}
					}
				?>
			</div>
        </div><!-- cd-slider-wrapper -->

        <div class="cd-item-info">
            <div class="product_infos">

                <?php do_action( 'woocommerce_single_product_summary_single_rating' );?>
                <a href="<?php the_permalink(); ?>"><?php do_action( 'woocommerce_single_product_summary_single_title' );?></a>

				<div class="product_price">
                    <?php do_action( 'woocommerce_single_product_summary_single_price' ); ?>
                </div>

                <div class="product_excerpt">
                	<?php do_action( 'woocommerce_single_product_summary_single_excerpt' ); ?>
          		</div>   

        		<?php do_action( 'woocommerce_single_product_summary_single_add_to_cart' ); ?>
                <a class="button fa qv-pd-btn" href="<?php echo get_permalink() ?>"><span>Full Details</span></a>
            </div><!-- product_infos -->
        </div><!-- cd-item-info -->

	</div><!-- #product-<?php the_ID(); ?> 
	 data-product_id="<?php  ?>" -->
	<?php 
	wp_enqueue_script( 'jquery zoom', home_url() . '/wp-content/plugins/woocommerce/assets/js/zoom/jquery.zoom.min.js', array ( 'jquery' ), 1.1, true);
	
 ?>
 
<script type="text/javascript">
jQuery(document).ready(function($){
    $(document).ready(function(){          
        $('#cov_img').zoom();
    });
});
</script>
	<div class="nxt-prev-product">
		<i id="ajax_load" class=" fa fa-spinner fa-pulse fa-fw"></i>
		<button data-previd ="<?php echo  $_GET['prev']; ?>" data-product_id="<?php the_ID(); ?>" id='woo-qv-p'class="prev"></button>
		<button data-nxtid ="<?php echo  $_GET['next']; ?>" data-product_id="<?php the_ID(); ?>" id='woo-qv-n' class="nxt"></button>
	</div>


<?php endwhile; // end of the loop.