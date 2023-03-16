<?php
/**
 * The template for displaying service content
 *
 * @package Shop_Spot
 */

$shop_spot_enable_content = get_theme_mod( 'shop_spot_service_option', 'disabled' );

if ( ! shop_spot_check_section( $shop_spot_enable_content ) ) {
	// Bail if service content is disabled.
	return;
}

$shop_spot_tagline = get_option( 'ect_service_content' );
$shop_spot_title   = get_option( 'ect_service_title', esc_html__( 'Services', 'shop-spot' ) );

$shop_spot_classes[] = 'section';
$shop_spot_classes[] = 'service-section';


if ( ! $shop_spot_title && ! $shop_spot_tagline ) {
	$shop_spot_classes[] = 'no-section-heading';
}
?>

<div id="service-section" class="<?php echo esc_attr( implode( ' ', $shop_spot_classes ) ); ?>">
	<div class="wrapper">
		<?php shop_spot_section_heading( $shop_spot_tagline, $shop_spot_title ); ?>

		<div class="section-content-wrapper service-content-wrapper layout-three">
			<?php get_template_part( 'template-parts/service/content-service' ); ?>
		</div><!-- .section-content-wrapper -->
	</div><!-- .wrapper -->
</div><!-- #service-section -->
