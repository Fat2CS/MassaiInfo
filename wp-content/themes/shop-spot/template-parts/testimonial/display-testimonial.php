<?php
/**
 * The template for displaying testimonial items
 *
 * @package Shop_Spot
 */

$enable = get_theme_mod( 'shop_spot_testimonial_option', 'disabled' );

if ( ! shop_spot_check_section( $enable ) ) {
	// Bail if featured content is disabled
	return;
}

// Get Jetpack options for testimonial.
$shop_spot_subtitle = get_option('jetpack_testimonial_content');
$shop_spot_title    = get_option('jetpack_testimonial_title', esc_html__('Testimonials', 'shop-spot'));


$classes[] = 'section testimonial-content-section';

if ( ! $shop_spot_title && ! $shop_spot_subtitle ) {
	$classes[] = 'no-section-heading';
}
?>

<div id="testimonial-content-section" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wrapper">
			<?php shop_spot_section_heading( $shop_spot_subtitle, $shop_spot_title ); ?>

			<div class="section-content-wrapper testimonial-content-wrapper testimonial-slider owl-carousel">
				<?php get_template_part( 'template-parts/testimonial/post-types-testimonial' ); ?>
			</div><!-- .section-content-wrapper -->
	</div><!-- .wrapper -->
</div><!-- .testimonial-content-section -->
