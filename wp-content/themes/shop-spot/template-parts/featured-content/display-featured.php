<?php
/**
 * The template for displaying featured content
 *
 * @package Shop_Spot
 */

$shop_spot_enable_content = get_theme_mod( 'shop_spot_featured_content_option', 'disabled' );

if ( ! shop_spot_check_section( $shop_spot_enable_content ) ) {
	// Bail if featured content is disabled.
	return;
}

$shop_spot_title   = get_option( 'featured_content_title', esc_html__( 'Contents', 'shop-spot' ) );
$shop_spot_tagline = get_option( 'featured_content_content' );

$layout = get_theme_mod( 'shop_spot_featured_content_layout', 'layout-three' );

$shop_spot_classes[] = 'section';
$shop_spot_classes[] = 'featured-content';
$shop_spot_classes[] = 'layout-three';


if( ! $shop_spot_title && ! $shop_spot_tagline ) {
	$shop_spot_classes[] = 'no-section-heading';
}
?>

<div id="featured-content-section" class="<?php echo esc_attr( implode( ' ', $shop_spot_classes ) ); ?>">
	<div class="wrapper">
		<?php shop_spot_section_heading( $shop_spot_tagline, $shop_spot_title ); ?>

		<div class="section-content-wrapper featured-content-wrapper layout-three">
			<?php get_template_part( 'template-parts/featured-content/content-featured' ); ?>
		</div><!-- .section-content-wrap -->
	</div><!-- .wrapper -->
</div><!-- #featured-content-section -->
