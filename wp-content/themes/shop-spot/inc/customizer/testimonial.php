<?php
/**
 * Add Testimonial Settings in Customizer
 *
 * @package Shop_Spot
*/

/**
 * Add testimonial options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function shop_spot_testimonial_options( $wp_customize ) {
    // Add note to Jetpack Testimonial Section
    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_jetpack_testimonial_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Shop_Spot_Note_Control',
            'label'             => sprintf( esc_html__( 'For Testimonial Options for Shop Spot Theme, go %1$shere%2$s', 'shop-spot' ),
                '<a href="javascript:wp.customize.section( \'shop_spot_testimonials\' ).focus();">',
                 '</a>'
            ),
           'section'            => 'jetpack_testimonials',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    $wp_customize->add_section( 'shop_spot_testimonials', array(
            'panel'    => 'shop_spot_theme_options',
            'title'    => esc_html__( 'Testimonials', 'shop-spot' ),
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
            'name'              => 'shop_spot_testimonial_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Shop_Spot_Note_Control',
            'active_callback'   => 'shop_spot_is_ect_testimonial_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Testimonial, install %1$sEssential Content Types%2$s Plugin with testimonial Type Enabled', 'shop-spot' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'shop_spot_testimonials',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_testimonial_option',
            'default'           => 'disabled',
            'active_callback'   => 'shop_spot_is_ect_testimonial_active',
            'sanitize_callback' => 'shop_spot_sanitize_select',
            'choices'           => shop_spot_section_visibility_options(),
            'label'             => esc_html__( 'Enable on', 'shop-spot' ),
            'section'           => 'shop_spot_testimonials',
            'type'              => 'select',
            'priority'          => 1,
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_testimonial_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Shop_Spot_Note_Control',
            'active_callback'   => 'shop_spot_is_testimonial_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'shop-spot' ),
                '<a href="javascript:wp.customize.section( \'jetpack_testimonials\' ).focus();">',
                '</a>'
            ),
            'section'           => 'shop_spot_testimonials',
            'type'              => 'description',
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_testimonial_number',
            'default'           => '4',
            'sanitize_callback' => 'shop_spot_sanitize_number_range',
            'active_callback'   => 'shop_spot_is_testimonial_active',
            'label'             => esc_html__( 'Number of items', 'shop-spot' ),
            'section'           => 'shop_spot_testimonials',
            'type'              => 'number',
            'input_attrs'       => array(
                'style'             => 'width: 100px;',
                'min'               => 0,
            ),
        )
    );

    $number = get_theme_mod( 'shop_spot_testimonial_number', 4 );

    for ( $i = 1; $i <= $number ; $i++ ) {

        //for CPT
        shop_spot_register_option( $wp_customize, array(
                'name'              => 'shop_spot_testimonial_cpt_' . $i,
                'sanitize_callback' => 'shop_spot_sanitize_post',
                'active_callback'   => 'shop_spot_is_testimonial_active',
                'label'             => esc_html__( 'Testimonial', 'shop-spot' ) . ' ' . $i ,
                'section'           => 'shop_spot_testimonials',
                'type'              => 'select',
                'choices'           => shop_spot_generate_post_array( 'jetpack-testimonial' ),
            )
        );

    } // End for().
}
add_action( 'customize_register', 'shop_spot_testimonial_options' );

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'shop_spot_is_testimonial_active' ) ) :
    /**
    * Return true if testimonial is active
    *
    * @since Shop Spot 1.0
    */
    function shop_spot_is_testimonial_active( $control ) {
        $enable = $control->manager->get_setting( 'shop_spot_testimonial_option' )->value();

        //return true only if previwed page on customizer matches the type of content option selected
        return ( shop_spot_is_ect_testimonial_active( $control ) && shop_spot_check_section( $enable ) );
    }
endif;

if ( ! function_exists( 'shop_spot_is_ect_testimonial_inactive' ) ) :
    /**
    *
    * @since Shop Spot 1.0
    */
    function shop_spot_is_ect_testimonial_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_testimonial' ) || class_exists( 'Essential_Content_Pro_Jetpack_testimonial' ) );
    }
endif;

if ( ! function_exists( 'shop_spot_is_ect_testimonial_active' ) ) :
    /**
    *
    * @since Shop Spot 1.0
    */
    function shop_spot_is_ect_testimonial_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_testimonial' ) || class_exists( 'Essential_Content_Pro_Jetpack_testimonial' ) );
    }
endif;