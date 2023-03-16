<?php
/**
 * The template for displaying featured posts on the front page
 *
 * @package Shop_Spot
 */
$shop_spot_number        = get_theme_mod( 'shop_spot_featured_content_number', 3 );
$shop_spot_post_list     = array();
$shop_spot_no_of_post    = 0;

$shop_spot_args = array(
	'post_type'           => 'post',
	'ignore_sticky_posts' => 1, // ignore sticky posts.
);

// Get valid number of posts.
$shop_spot_args['post_type'] = 'featured-content';

for ( $i = 1; $i <= $shop_spot_number; $i++ ) {
	$shop_spot_post_id = '';

	$shop_spot_post_id = get_theme_mod( 'shop_spot_featured_content_cpt_' . $i );

	if ( $shop_spot_post_id && '' !== $shop_spot_post_id ) {
		$shop_spot_post_list = array_merge( $shop_spot_post_list, array( $shop_spot_post_id ) );

		$shop_spot_no_of_post++;
	}
}

$shop_spot_args['post__in'] = $shop_spot_post_list;
$shop_spot_args['orderby']  = 'post__in';

if ( ! $shop_spot_no_of_post ) {
	return;
}

$shop_spot_args['posts_per_page'] = $shop_spot_no_of_post;

$shop_spot_loop = new WP_Query( $shop_spot_args );

while ( $shop_spot_loop->have_posts() ) :
	
	$shop_spot_loop->the_post();

	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="hentry-inner">
			<?php shop_spot_post_thumbnail( array( 508, 338 ), 'html', true, true ); ?>

			<div class="entry-container">
				<header class="entry-header">
					<div class="entry-meta">
						<?php shop_spot_entry_category(); ?>
					</div>

					<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h2>' ); ?>
				</header>
				<?php
					$excerpt = get_the_excerpt();

					echo '<div class="entry-summary"><p>' . $excerpt . '</p></div><!-- .entry-summary -->';
				?>

				<div class="entry-meta">
					<?php shop_spot_posted_on(); ?>
				</div><!-- .entry-meta -->

			</div><!-- .entry-container -->
		</div><!-- .hentry-inner -->
	</article>
<?php
endwhile;

wp_reset_postdata();
