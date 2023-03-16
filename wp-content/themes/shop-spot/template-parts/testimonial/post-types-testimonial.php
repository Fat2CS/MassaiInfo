<?php
/**
 * The template for displaying testimonial items
 *
 * @package Shop_Spot
 */

$number = get_theme_mod( 'shop_spot_testimonial_number', 4 );

if ( ! $number ) {
	// If number is 0, then this section is disabled
	return;
}

$args = array(
	'ignore_sticky_posts' => 1 // ignore sticky posts
);

$post_list  = array();// list of valid post/page ids

$args['post_type'] = 'jetpack-testimonial';

for ( $i = 1; $i <= $number; $i++ ) {
	$shop_spot_post_id = '';

	$shop_spot_post_id =  get_theme_mod( 'shop_spot_testimonial_cpt_' . $i );

	if ( $shop_spot_post_id && '' !== $shop_spot_post_id ) {
		// Polylang Support.
		if ( class_exists( 'Polylang' ) ) {
			$shop_spot_post_id = pll_get_post( $shop_spot_post_id, pll_current_language() );
		}

		$post_list = array_merge( $post_list, array( $shop_spot_post_id ) );

	}
}

$args['post__in'] = $post_list;
$args['orderby'] = 'post__in';

$args['posts_per_page'] = $number;
$loop = new WP_Query( $args );

if ( $loop -> have_posts() ) :
	while ( $loop -> have_posts() ) :
		$loop -> the_post();

		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="hentry-inner">
				
				<div class="entry-container">
					<div class="entry-summary">
						<div class="content-wrap">
							<?php the_excerpt(); ?>
						</div>
					</div>

					<?php
					$counter  = absint( $loop->current_post ) + 1;
     				$position = get_post_meta( $post->ID, 'ect_testimonial_position', true );					 
     				?>

					 <div class="author-thumb">
					 	<?php shop_spot_post_thumbnail( array(100,100), 'html', true, true ); ?>
						<?php if ( get_theme_mod( 'shop_spot_testimonial_enable_title', 1 ) || $position ) : ?>
							<header class="entry-header">
								<?php if ( get_theme_mod( 'shop_spot_testimonial_enable_title', 1 ) ) :?>
									<h2 class="entry-title">
										<a href=<?php the_permalink(); ?>>
											<?php the_title(); ?>
										</a>
									</h2>
								<?php endif;

								if( $position ) : ?>
									<div class="position" >
										<?php echo esc_html( $position ); ?>
									</div>
								<?php endif; ?>
							</header>
						<?php endif; ?>
					</div><!-- .author-thumb -->
				</div><!-- .entry-container -->
			</div><!-- .hentry-inner -->
		</article>
	<?php
	endwhile;
	wp_reset_postdata();
endif;
