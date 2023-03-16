<?php
/**
 * The template used for displaying slider
 *
 * @package Shop_Spot
 */

$shop_spot_quantity     = get_theme_mod( 'shop_spot_slider_number', 4 );
$shop_spot_no_of_post   = 0; // for number of posts
$shop_spot_post_list    = array(); // list of valid post/page ids

$shop_spot_args = array(
	'ignore_sticky_posts' => 1, // ignore sticky posts
);

//Get valid number of posts
$shop_spot_args['post_type'] =  'page';

for ( $i = 1; $i <= $shop_spot_quantity; $i++ ) {
	$shop_spot_id = '';

	$shop_spot_id = get_theme_mod( 'shop_spot_slider_page_' . $i );

	if ( $shop_spot_id && '' !== $shop_spot_id ) {
		$shop_spot_post_list = array_merge( $shop_spot_post_list, array( $shop_spot_id ) );

		$shop_spot_no_of_post++;
	}
}

$shop_spot_args['post__in'] = $shop_spot_post_list;
$shop_spot_args['orderby'] = 'post__in';

if ( ! $shop_spot_no_of_post ) {
	return;
}

$shop_spot_args['posts_per_page'] = $shop_spot_no_of_post;
$shop_spot_loop = new WP_Query( $shop_spot_args );

while ( $shop_spot_loop->have_posts() ) :
	$shop_spot_loop->the_post();

	$shop_spot_classes = 'post post-' . get_the_ID() . ' hentry slides';
	$highlight_text   = get_theme_mod( 'shop_spot_slider_highlight_text_' . ( absint( $shop_spot_loop ->current_post ) + 1 ) );

	?>
	<article class="<?php echo esc_attr( $shop_spot_classes ); ?>">
		<div class="hentry-inner">
			<?php shop_spot_post_thumbnail( 'shop-spot-slider', 'html', true, true ); ?>

			<div class="entry-container">
				<div class="content-container">
					<header class="entry-header">
						<h2 class="entry-title">
							<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h2>

						<?php if( $highlight_text ) : ?>
							<div class="highlight-text">
								<?php echo esc_html( $highlight_text ); ?>
							</div>
						<?php endif; ?>
					</header>

					<?php
						echo '<div class="entry-summary"><p>' . wp_kses_post( get_the_excerpt() ) . '</p></div><!-- .entry-summary -->';
					?>
				</div> <!--  .content-container  -->
			</div><!-- .entry-container -->
		</div><!-- .hentry-inner -->
	</article><!-- .slides -->
<?php
endwhile;

wp_reset_postdata();
