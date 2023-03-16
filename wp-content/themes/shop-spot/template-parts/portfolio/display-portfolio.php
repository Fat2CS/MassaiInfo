<?php
/**
 * The template for displaying portfolio items
 *
 * @package Shop_Spot
 */

$enable = get_theme_mod( 'shop_spot_portfolio_option', 'disabled' );

if ( ! shop_spot_check_section( $enable ) ) {
	// Bail if portfolio section is disabled.
	return;
}

$shop_spot_tagline = get_option( 'jetpack_portfolio_content' );
$shop_spot_title   = get_option( 'jetpack_portfolio_title', esc_html__( 'Projects', 'shop-spot' ) );

$layout = get_theme_mod( 'shop_spot_portfolio_layout', 'layout-three' );

$classes[] = 'section';
$classes[] = 'jetpack-portfolio';
$classes[] = 'layout-three';

?>

<div id="portfolio-content-section" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wrapper">
		<?php shop_spot_section_heading( $shop_spot_tagline, $shop_spot_title ); ?>

		<div class="section-content-wrapper portfolio-content-wrapper layout-three">
			<div class="grid">
				<?php get_template_part( 'template-parts/portfolio/post-types', 'portfolio' ); ?>
			</div>
		</div><!-- .section-content-wrap -->
	</div><!-- .wrapper -->
</div><!-- #portfolio-section -->
