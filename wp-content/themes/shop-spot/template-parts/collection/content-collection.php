<?php
/**
 * The template used for displaying projects on index view
 *
 * @package Shop_Spot
 */

$shop_spot_text = get_theme_mod( 'shop_spot_collection_button_text' );

if ( has_post_thumbnail() ) {
	$thumb_url = get_the_post_thumbnail_url( get_the_ID(), array( 1920,1920 ) );
} else {
	$thumb_url = trailingslashit( esc_url( get_template_directory_uri() ) ) . 'assets/images/no-thumb-1920x1920.jpg';
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'hentry' ); ?>>
	<div class="hentry-inner">
		<div class="post-thumbnail" style="background-image: url( '<?php echo esc_url( $thumb_url ); ?>' )">
			<a class="cover-link" href="<?php the_permalink(); ?>"></a>
		</div>

		<?php $shop_spot_title = 'woocommerce-loop-product__title'; ?>
		
		<div class="entry-container product-container">
			<header class="entry-header">
				<?php shop_spot_single_product_category(); ?>

				<?php the_title( '<h2 class="' . esc_attr( $shop_spot_title ) . '"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h2>' ); ?>
			</header>

			<?php if ($shop_spot_text) : ?>
				<p class="view-more">
					<a class="button" href="<?php the_permalink(); ?>"><?php echo esc_html($shop_spot_text); ?></a>
				</p>
			<?php endif; ?>
		</div><!-- .entry-container -->
	</div><!-- .hentry-inner -->
</article>
