<?php
/**
 * The template used for displaying slider
 *
 * @package Shop_Spot
 */

$shop_spot_enable_slider = get_theme_mod( 'shop_spot_slider_option', 'disabled' );
 
if ( ! shop_spot_check_section( $shop_spot_enable_slider ) ) {
	return;
}
?>

<div id="feature-slider-section" class="section feature-slider-section content-align-left text-align-left text-below-image">
	<div class="wrapper section-content-wrapper feature-slider-wrapper">
		<div class="main-slider owl-carousel">
			<?php get_template_part( 'template-parts/slider/post-type-slider' ); ?>
		</div><!-- .main-slider -->

		<div class="scroll-down">
			<a class="scroll-inner" href="#">
				<?php echo shop_spot_get_svg( array( 'icon' => 'angle-down' ) ); ?>
				<span><?php esc_html_e( 'Scroll Down', 'shop-spot' ); ?></span>
			</a>
		</div><!-- .scroll-down -->
	</div><!-- .wrapper -->
</div><!-- #feature-slider -->
