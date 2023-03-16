<?php
/**
 * Collection options
 *
 * @package Shop_Spot
 */

/**
 * Add collection options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function shop_spot_collection_options( $wp_customize ) {
	$wp_customize->add_section( 'shop_spot_collection', array(
			'title' => esc_html__( 'Collection', 'shop-spot' ),
			'panel' => 'shop_spot_theme_options',
		)
	);

	// Add color scheme setting and control.
	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_collection_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'shop_spot_sanitize_select',
			'choices'           => shop_spot_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'shop-spot' ),
			'section'           => 'shop_spot_collection',
			'type'              => 'select',
		)
	);

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_collection_head_image',
			'sanitize_callback' => 'shop_spot_sanitize_image',
			'custom_control'    => 'WP_Customize_Image_Control',
			'active_callback'   => 'shop_spot_is_collection_active',
			'label'             => esc_html__( 'Head Image', 'shop-spot' ),
			'section'           => 'shop_spot_collection',
		)
	);

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_collection_head_title',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'shop_spot_is_collection_active',
			'label'             => esc_html__( 'Head Title', 'shop-spot' ),
			'section'           => 'shop_spot_collection',
			'type'              => 'text',
		)
	);

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_collection_head_button_text',
			'sanitize_callback' => 'sanitize_text_field',
			'active_callback'   => 'shop_spot_is_collection_active',
			'label'             => esc_html__('Button Text', 'shop-spot'),
			'section'           => 'shop_spot_collection',
			'type'              => 'text',
		)
	);

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_collection_head_button_link',
			'sanitize_callback' => 'esc_url_raw',
			'active_callback'   => 'shop_spot_is_collection_active',
			'label'             => esc_html__( 'Link', 'shop-spot' ),
			'section'           => 'shop_spot_collection',
		)
	);

	for ( $i = 1; $i <= 2 ; $i++ ) {

		if ( shop_spot_is_woocommerce_activated() ) {
			shop_spot_register_option( $wp_customize, array(
					'name'              => 'shop_spot_collection_product_' . $i,
					'sanitize_callback' => 'shop_spot_sanitize_post',
					'active_callback'   => 'shop_spot_is_collection_active',
					'label'             => esc_html__( 'Product', 'shop-spot' ) . ' ' . $i ,
					'section'           => 'shop_spot_collection',
					'type'              => 'select',
					'choices'           => shop_spot_generate_products_array(),
				)
			);
		}
		
	} // End for().

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_collection_button_text',
			'sanitize_callback' => 'sanitize_text_field',
			'active_callback'   => 'shop_spot_is_collection_active',
			'label'             => esc_html__('Button Text', 'shop-spot'),
			'section'           => 'shop_spot_collection',
			'type'              => 'text',
		)
	);
}
add_action( 'customize_register', 'shop_spot_collection_options', 10 );

/** Active Callback Functions **/
if( ! function_exists( 'shop_spot_is_collection_active' ) ) :
	/**
	* Return true if collection is active
	*
	* @since 1.0
	*/
	function shop_spot_is_collection_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'shop_spot_collection_option' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( 'entire-site' == $enable || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable )
	);
	}
endif;