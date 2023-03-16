<?php
/**
 * Services options
 *
 * @package Shop_Spot
 */

/**
 * Add service content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function shop_spot_service_options( $wp_customize ) {
	// Add note to Jetpack Testimonial Section
    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_service_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Shop_Spot_Note_Control',
            'label'             => sprintf( esc_html__( 'For all Services Options, go %1$shere%2$s', 'shop-spot' ),
                '<a href="javascript:wp.customize.section( \'shop_spot_service\' ).focus();">',
                 '</a>'
            ),
           'section'            => 'service',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    $wp_customize->add_section( 'shop_spot_service', array(
			'title' => esc_html__( 'Services', 'shop-spot' ),
			'panel' => 'shop_spot_theme_options',
		)
	);

	$action = 'install-plugin';
    $slug   = 'essential-content-types';

    $install_url = wp_nonce_url(
        add_query_arg(
            array(
                'action' => $action,
                'plugin' => $slug
            ),
            admin_url( 'update.php' )
        ),
        $action . '_' . $slug
    );

    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_service_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Shop_Spot_Note_Control',
            'active_callback'   => 'shop_spot_is_ect_services_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Services, install %1$sEssential Content Types%2$s Plugin with Service Type Enabled', 'shop-spot' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'shop_spot_service',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	// Add color scheme setting and control.
	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_service_option',
			'default'           => 'disabled',
			'active_callback'   => 'shop_spot_is_ect_services_active',
			'sanitize_callback' => 'shop_spot_sanitize_select',
			'choices'           => shop_spot_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'shop-spot' ),
			'section'           => 'shop_spot_service',
			'type'              => 'select',
		)
	);

	shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_service_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Shop_Spot_Note_Control',
            'active_callback'   => 'shop_spot_is_service_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'shop-spot' ),
                 '<a href="javascript:wp.customize.control( \'ect_service_title\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'shop_spot_service',
            'type'              => 'description',
        )
    );

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_service_number',
			'default'           => 3,
			'sanitize_callback' => 'shop_spot_sanitize_number_range',
			'active_callback'   => 'shop_spot_is_service_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Services is changed (Max no of Services is 20)', 'shop-spot' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
			),
			'label'             => esc_html__( 'No of items', 'shop-spot' ),
			'section'           => 'shop_spot_service',
			'type'              => 'number',
			'transport'         => 'postMessage',
		)
	);

	$number = get_theme_mod( 'shop_spot_service_number', 3 );

	//loop for service post content
	for ( $i = 1; $i <= $number ; $i++ ) {

		//ECT Service
		shop_spot_register_option( $wp_customize, array(
				'name'              => 'shop_spot_service_cpt_' . $i,
				'sanitize_callback' => 'shop_spot_sanitize_post',
				'active_callback'   => 'shop_spot_is_service_active',
				'label'             => esc_html__( 'Services', 'shop-spot' ) . ' ' . $i ,
				'section'           => 'shop_spot_service',
				'type'              => 'select',
                'choices'           => shop_spot_generate_post_array( 'ect-service' ),
			)
		);

	} // End for().
}
add_action( 'customize_register', 'shop_spot_service_options', 10 );

/** Active Callback Functions **/
if ( ! function_exists( 'shop_spot_is_service_active' ) ) :
	/**
	* Return true if service content is active
	*
	* @since Shop Spot 1.0
	*/
	function shop_spot_is_service_active( $control ) {
		$enable = $control->manager->get_setting( 'shop_spot_service_option' )->value();

		//return true only if previewed page on customizer matches the type of content option selected
		return ( shop_spot_is_ect_services_active( $control ) && shop_spot_check_section( $enable ) );
	}
endif;

if ( ! function_exists( 'shop_spot_is_ect_services_inactive' ) ) :
    /**
    * Return true if service is active
    *
    * @since Shop Spot 1.0
    */
    function shop_spot_is_ect_services_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;

if ( ! function_exists( 'shop_spot_is_ect_services_active' ) ) :
    /**
    * Return true if service is active
    *
    * @since Shop Spot 1.0
    */
    function shop_spot_is_ect_services_active( $control ) {
        return ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;

