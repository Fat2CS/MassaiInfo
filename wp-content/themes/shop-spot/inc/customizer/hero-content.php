<?php
/**
 * Hero Content Options
 *
 * @package Shop_Spot
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function shop_spot_hero_content_options( $wp_customize ) {
	$wp_customize->add_section( 'shop_spot_hero_content_options', array(
			'title' => esc_html__( 'Hero Content', 'shop-spot' ),
			'panel' => 'shop_spot_theme_options',
		)
	);

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_hero_content_visibility',
			'default'           => 'disabled',
			'sanitize_callback' => 'shop_spot_sanitize_select',
			'choices'           => shop_spot_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'shop-spot' ),
			'section'           => 'shop_spot_hero_content_options',
			'type'              => 'select',
		)
	);

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_hero_content_tagline',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'shop_spot_is_hero_content_active',
			'label'             => esc_html__( 'Section Tagline', 'shop-spot' ),
			'section'           => 'shop_spot_hero_content_options',
			'type'              => 'text',
		)
	);

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_hero_content',
			'default'           => '0',
			'sanitize_callback' => 'shop_spot_sanitize_post',
			'active_callback'   => 'shop_spot_is_hero_content_active',
			'label'             => esc_html__( 'Page', 'shop-spot' ),
			'section'           => 'shop_spot_hero_content_options',
			'type'              => 'dropdown-pages',
		)
	);
}
add_action( 'customize_register', 'shop_spot_hero_content_options' );

/** Active Callback Functions **/
if ( ! function_exists( 'shop_spot_is_hero_content_active' ) ) :
	/**
	* Return true if hero content is active
	*
	* @since 1.0.0
	*/
	function shop_spot_is_hero_content_active( $control ) {
		$enable = $control->manager->get_setting( 'shop_spot_hero_content_visibility' )->value();

		return shop_spot_check_section( $enable );
	}
endif;