<?php
/**
 * Header Media Options
 *
 * @package Shop_Spot
 */

/**
 * Add Header Media options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function shop_spot_header_media_options( $wp_customize ) {
	$wp_customize->get_section( 'header_image' )->description = esc_html__( 'If you add video, it will only show up on Homepage/FrontPage. Other Pages will use Header/Post/Page Image depending on your selection of option. Header Image will be used as a fallback while the video loads ', 'shop-spot' );

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_header_media_option',
			'default'           => 'homepage',
			'sanitize_callback' => 'shop_spot_sanitize_select',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'shop-spot' ),
				'entire-site'            => esc_html__( 'Entire Site', 'shop-spot' ),
				'disable'                => esc_html__( 'Disabled', 'shop-spot' ),
			),
			'label'             => esc_html__( 'Enable on', 'shop-spot' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'priority'          => 1,
		)
	);

	/*Overlay Option for Header Media*/
	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_header_media_homepage_image_opacity',
			'default'           => '0',
			'sanitize_callback' => 'shop_spot_sanitize_number_range',
			'label'             => esc_html__( 'Header Media Overlay on Homepage', 'shop-spot' ),
			'section'           => 'header_image',
			'type'              => 'number',
			'input_attrs'       => array(
				'style' => 'width: 80px;',
				'min'   => 0,
				'max'   => 100,
			),
		)
	);

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_header_media_title',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Title', 'shop-spot' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_header_media_highlighted_text',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Highlighted Text', 'shop-spot' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

    shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_header_media_text',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Site Header Text', 'shop-spot' ),
			'section'           => 'header_image',
			'type'              => 'textarea',
		)
	);

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_header_media_url',
			'sanitize_callback' => 'esc_url_raw',
			'label'             => esc_html__( 'Header Media Url', 'shop-spot' ),
			'section'           => 'header_image',
		)
	);

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_header_media_url_text',
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Header Media Url Text', 'shop-spot' ),
			'section'           => 'header_image',
		)
	);

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_header_url_target',
			'sanitize_callback' => 'shop_spot_sanitize_checkbox',
			'label'             => esc_html__( 'Open Link in New Window/Tab', 'shop-spot' ),
			'section'           => 'header_image',
			'custom_control'    => 'Shop_Spot_Toggle_Control',
		)
	);
}
add_action( 'customize_register', 'shop_spot_header_media_options' );

