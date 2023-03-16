<?php
/**
 * The template used for displaying hero content
 *
 * @package Shop_Spot
 */

$shop_spot_enable_section = get_theme_mod( 'shop_spot_hero_content_visibility', 'disabled' );

if ( ! shop_spot_check_section( $shop_spot_enable_section ) ) {
	// Bail if hero content is not enabled
	return;
}

get_template_part( 'template-parts/hero-content/post-type-hero' );

