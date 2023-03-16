<?php
/**
 * The template used for displaying projects on index view
 *
 * @package Shop_Spot
 */

global $post;

$classes = 'grid-item';
?>

<article id="portfolio-post-<?php the_ID(); ?>" <?php post_class( esc_attr( $classes ) ); ?>>
	<div class="hentry-inner">
		<?php shop_spot_post_thumbnail( array( 666, 666 ) ); ?>
		
		<div class="entry-container">
			<div class="inner-wrap">
				<header class="entry-header">
					<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
	
					<div class="entry-meta">
						<?php shop_spot_posted_on(); ?>
					</div>
				</header>
			</div>
		</div><!-- .entry-container -->
		
	</div><!-- .hentry-inner -->
</article>
