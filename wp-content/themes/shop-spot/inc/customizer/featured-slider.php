<?php
/**
 * Featured Slider Options
 *
 * @package Shop_Spot
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function shop_spot_slider_options( $wp_customize ) {
	$wp_customize->add_section( 'shop_spot_featured_slider', array(
			'panel' => 'shop_spot_theme_options',
			'title' => esc_html__( 'Featured Slider', 'shop-spot' ),
		)
	);

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_slider_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'shop_spot_sanitize_select',
			'choices'           => shop_spot_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'shop-spot' ),
			'section'           => 'shop_spot_featured_slider',
			'type'              => 'select',
		)
	);

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_slider_number',
			'default'           => '4',
			'sanitize_callback' => 'shop_spot_sanitize_number_range',

			'active_callback'   => 'shop_spot_is_slider_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'shop-spot' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
				'max'   => 20,
				'step'  => 1,
			),
			'label'             => esc_html__( 'No of Slides', 'shop-spot' ),
			'section'           => 'shop_spot_featured_slider',
			'type'              => 'number',
		)
	);

	$slider_number = get_theme_mod( 'shop_spot_slider_number', 4 );

	for ( $i = 1; $i <= $slider_number ; $i++ ) {
		// Page Sliders
		shop_spot_register_option( $wp_customize, array(
				'name'              => 'shop_spot_slider_page_' . $i,
				'sanitize_callback' => 'shop_spot_sanitize_post',
				'active_callback'   => 'shop_spot_is_slider_active',
				'label'             => esc_html__( 'Page', 'shop-spot' ) . ' # ' . $i,
				'section'           => 'shop_spot_featured_slider',
				'type'              => 'dropdown-pages',
			)
		);

		shop_spot_register_option( $wp_customize, array(
				'name'              => 'shop_spot_slider_highlight_text_' . $i,
				'sanitize_callback' => 'wp_kses_post',
				'active_callback'   => 'shop_spot_is_slider_active',
				'label'             => esc_html__( 'Highlight Text #', 'shop-spot' ) . $i,
				'section'           => 'shop_spot_featured_slider',
				'type'              => 'text',
			)
		);

	} // End for().
}
add_action( 'customize_register', 'shop_spot_slider_options' );

/** Active Callback Functions */

if ( ! function_exists( 'shop_spot_is_slider_active' ) ) :
	/**
	* Return true if slider is active
	*
	* @since 1.0.0
	*/
	function shop_spot_is_slider_active( $control ) {
		$enable = $control->manager->get_setting( 'shop_spot_slider_option' )->value();

		//return true only if previwed page on customizer matches the type option selected
		return shop_spot_check_section( $enable );
	}
endif;
