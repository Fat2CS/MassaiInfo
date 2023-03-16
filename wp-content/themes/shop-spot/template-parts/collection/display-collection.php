<?php
/**
 * The template for displaying featured content
 *
 * @package Shop_Spot
 */

$enable_content = get_theme_mod( 'shop_spot_collection_option', 'disabled' );
$classes = array();

if ( ! shop_spot_check_section( $enable_content ) ) {
	// Bail if featured content is disabled.
	return;
}

$shop_spot_type 	      = get_theme_mod( 'shop_spot_collection_type', 'category' );
$shop_spot_text 		  = get_theme_mod( 'shop_spot_collection_head_button_text' );
$shop_spot_link 	      = get_theme_mod( 'shop_spot_collection_head_button_link' );
$image 	    			  = get_theme_mod( 'shop_spot_collection_head_image' );
$head_title 			  = get_theme_mod( 'shop_spot_collection_head_title' );

$classes[] = 'woocommerce';
$classes[] = 'section';

if( ! $image && ! $head_title && ! $shop_spot_text  ) {
	$classes[] = 'no-head-image';
}

?>

<div id="collection-section" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wrapper">
		<div class="section-content-wrapper collection-wrapper">

			<?php get_template_part( 'template-parts/collection/post-types-collection' ); 
			
			if( $image || $head_title || $shop_spot_text ): ?>
			<div class="collection-head">
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'hentry' ); ?>>
					<div class="hentry-inner">
						<?php if( $image ) : ?>
						<div class="post-thumbnail" style="background-image: url( '<?php echo esc_url( $image ); ?>' )">
						<?php endif; ?>

							<div class="head-content">
								<div class="head-title">
									<?php echo esc_html( $head_title ); ?>
								</div>
								<div class="head-button">
									<?php if ($shop_spot_text) : ?>
										<p class="view-more">
											<a class="button" href="<?php echo esc_url( $shop_spot_link ); ?>"><?php echo esc_html($shop_spot_text); ?></a>
										</p>
									<?php endif; ?>
								</div>
							<?php if( $image ) : ?>
							</div>
							<?php endif; ?>
						</div>
					</div><!-- .hentry-inner -->
				</article>
			</div>
		<?php endif; ?>

		</div><!-- .collection-wrapper -->
	</div><!-- .wrapper -->
</div><!-- #collection-section -->
