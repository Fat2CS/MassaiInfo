<?php
/**
 * Customizer functionality
 *
 * @package Shop_Spot
 */

/**
 * Sets up the WordPress core Featured custom background features.
 *
 * @since 1.0
 *
 * @see shop_spot_header_style()
 */
function shop_spot_custom_header_and_bg() {
	$default_text_color = trim( '333333', '#' );

	/**
	 * Filter the arguments used when adding 'custom-background' support in Shop_Spot.
	 *
	 * @since 1.0
	 *
	 * @param array $args {
	 *     An array of custom-background support arguments.
	 *
	 *     @type string $default-color Default color of the background.
	 * }
	 */
	
	// Adds a class of (full-width|box) to blogs.
	add_theme_support( 'custom-background', apply_filters( 'shop_spot_custom_bg_args', array(
		'default-color' => '#ffffff',
	) ) );

	/**
	 * Filter the arguments used when adding 'custom-header' support in Shop_Spot.
	 *
	 * @since 1.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type string $default-text-color Default color of the header text.
	 *     @type int      $width            Width in pixels of the custom header image. Default 1200.
	 *     @type int      $height           Height in pixels of the custom header image. Default 280.
	 *     @type bool     $flex-height      Whether to allow flexible-height header images. Default true.
	 *     @type callable $wp-head-callback Callback function used to style the header image and text
	 *                                      displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'shop_spot_custom_header_args', array(
		'default-image'      => get_parent_theme_file_uri( '/assets/images/header-image.jpg' ),
		'default-text-color' => $default_text_color,
		'width'              => 1920,
		'height'             => 1080,
		'flex-height'        => true,
		'flex-height'        => true,
		'wp-head-callback'   => 'shop_spot_header_style',
		'video'              => true,
	) ) );

	register_default_headers( array(
		'default-image' => array(
			'url'           => '%s/assets/images/header-image.jpg',
			'thumbnail_url' => '%s/assets/images/header-image-275x155.jpg',
			'description'   => esc_html__( 'Default Header Image', 'shop-spot' ),
		)
	) );
}
add_action( 'after_setup_theme', 'shop_spot_custom_header_and_bg' );

/**
 * Binds the JS listener to make Customizer color_scheme control.
 *
 * Passes color scheme data as colorScheme global.
 *
 * @since 1.0
 */
function shop_spot_customize_control_js() {
	wp_enqueue_style( 'shop-spot-custom-controls-css', trailingslashit( esc_url( get_template_directory_uri() ) ) . 'assets/css/customizer.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'shop_spot_customize_control_js' );

/**
 * Enqueues front-end CSS for the Contact and Newsletter background color
 *
 * @since 1.0
 *
 * @see wp_add_inline_style()
 */

/**
 * Converts a HEX value to RGB.
 *
 * @since 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function shop_spot_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}
