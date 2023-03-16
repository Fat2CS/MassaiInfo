<?php
/**
 * The template used for displaying hero content
 *
 * @package Shop_Spot
 */

$shop_spot_id = get_theme_mod( 'shop_spot_hero_content' );
$shop_spot_args['page_id'] = absint( $shop_spot_id );

// If $shop_spot_args is empty return false
if ( empty( $shop_spot_args ) ) {
	return;
}

$shop_spot_classes[] = 'hero-section';
$shop_spot_classes[] = 'section';
$shop_spot_classes[] = 'content-align-right';
$shop_spot_classes[] = 'text-align-left';

// Create a new WP_Query using the argument previously created
$hero_query = new WP_Query( $shop_spot_args );
if ( $hero_query->have_posts() ) :
	while ( $hero_query->have_posts() ) :
		$hero_query->the_post();

		$class = '';
		if( ! has_post_thumbnail() ) {
			$class = 'full-width';
		}
		?>
		<div id="hero-section" class="<?php echo esc_attr( implode( ' ', $shop_spot_classes ) ); ?>">
			<div class="wrapper">
				<div class="section-content-wrapper hero-content-wrapper">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="hentry-inner">
							<?php $post_thumbnail = shop_spot_post_thumbnail( array( 508, 508 ), 'html', false ); // shop_spot_post_thumbnail( $image_size, $shop_spot_type = 'html', $echo = true, $no_thumb = false ).

						if ( has_post_thumbnail() ) : ?>
							<?php echo $post_thumbnail; ?>
							<div class="entry-container">
						<?php else : ?>
							<div class="entry-container full-width">
						<?php endif; ?>
							<?php
							$shop_spot_tagline = get_theme_mod( 'shop_spot_hero_content_tagline' ); ?>


							<header class="entry-header">
								<?php if ( $shop_spot_tagline ) : ?>
									<div class="section-tagline">
										<?php echo wp_kses_post( $shop_spot_tagline ); ?>
									</div><!-- .section-tagline -->
								<?php endif; ?>

								<h2 class="entry-title">
									<?php the_title(); ?>
								</h2>
							</header><!-- .entry-header -->

							<div class="entry-summary">
								<?php 
								the_excerpt();  
								?>
							</div><!-- .entry-summary -->

							<?php if ( get_edit_post_link() ) : ?>
								<footer class="entry-footer">
									<div class="entry-meta">
										<?php
											edit_post_link(
												sprintf(
													/* translators: %s: Name of current post */
													esc_html__( 'Edit %s', 'shop-spot' ),
													the_title( '<span class="screen-reader-text">"', '"</span>', false )
												),
												'<span class="edit-link">',
												'</span>'
											);
										?>
									</div>	<!-- .entry-meta -->
								</footer><!-- .entry-footer -->
							<?php endif; ?>
							
							</div><!-- .entry-container -->
						</div><!-- .hentry-inner -->
					</article>
				</div><!-- .section-content-wrapper -->
			</div><!-- .wrapper -->
		</div><!-- .section -->
	<?php
	endwhile;

	wp_reset_postdata();
endif;
