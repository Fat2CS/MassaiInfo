<?php
/**
 * Adding support for WooCommerce Products Showcase Option
 */

/**
 * Add WooCommerce Product Showcase Options to customizer
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function shop_spot_woo_products_showcase( $wp_customize ) {
   $wp_customize->add_section( 'shop_spot_woo_products_showcase', array(
        'title' => esc_html__( 'WooCommerce Products Showcase', 'shop-spot' ),
        'panel' => 'shop_spot_theme_options',
    ) );

    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_woo_products_showcase_option',
            'default'           => 'disabled',
            'sanitize_callback' => 'shop_spot_sanitize_select',
            'choices'           => shop_spot_section_visibility_options(),
            'label'             => esc_html__( 'Enable on', 'shop-spot' ),
            'section'           => 'shop_spot_woo_products_showcase',
            'type'              => 'select',
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_woo_products_showcase_tagline',
            'sanitize_callback' => 'wp_kses_post',
            'label'             => esc_html__( 'Section Tagline', 'shop-spot' ),
            'active_callback'   => 'shop_spot_is_woo_products_showcase_active',
            'section'           => 'shop_spot_woo_products_showcase',
            'type'              => 'text',
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_woo_products_showcase_title',
            'sanitize_callback' => 'wp_kses_post',
            'label'             => esc_html__( 'Section Title', 'shop-spot' ),
            'active_callback'   => 'shop_spot_is_woo_products_showcase_active',
            'section'           => 'shop_spot_woo_products_showcase',
            'type'              => 'text',
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_woo_products_showcase_number',
            'default'           => 8,
            'sanitize_callback' => 'shop_spot_sanitize_number_range',
            'active_callback'   => 'shop_spot_is_woo_products_showcase_active',
            'description'       => esc_html__( 'Save and refresh the page if No. of Products is changed. Set -1 to display all', 'shop-spot' ),
            'input_attrs'       => array(
                'style' => 'width: 50px;',
                'min'   => -1,
            ),
            'label'             => esc_html__( 'No of Products', 'shop-spot' ),
            'section'           => 'shop_spot_woo_products_showcase',
            'type'              => 'number',
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'               => 'shop_spot_woo_products_showcase_columns',
            'default'            => 4,
            'sanitize_callback'  => 'shop_spot_sanitize_number_range',
            'active_callback'    => 'shop_spot_is_woo_products_showcase_active',
            'description'        => esc_html__( 'Theme supports up to 4 columns', 'shop-spot' ),
            'label'              => esc_html__( 'No of Columns', 'shop-spot' ),
            'section'            => 'shop_spot_woo_products_showcase',
            'type'               => 'number',
            'input_attrs'       => array(
                'style' => 'width: 50px;',
                'min'   => 1,
                'max'   => 4,
            ),
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'               => 'shop_spot_woo_products_showcase_paginate',
            'default'            => 'false',
            'sanitize_callback'  => 'shop_spot_sanitize_select',
            'active_callback'    => 'shop_spot_is_woo_products_showcase_active',
            'label'              => esc_html__( 'Paginate', 'shop-spot' ),
            'section'            => 'shop_spot_woo_products_showcase',
            'type'               => 'radio',
            'choices'            => array(
                'false' => esc_html__( 'No', 'shop-spot' ),
                'true' => esc_html__( 'Yes', 'shop-spot' ),
            ),
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'               => 'shop_spot_woo_products_showcase_orderby',
            'default'            => 'title',
            'sanitize_callback'  => 'shop_spot_sanitize_select',
            'active_callback'    => 'shop_spot_is_woo_products_showcase_active',
            'label'              => esc_html__( 'Order By', 'shop-spot' ),
            'section'            => 'shop_spot_woo_products_showcase',
            'type'               => 'select',
            'choices'            => array(
                'date'       => esc_html__( 'Date - The date the product was published', 'shop-spot' ),
                'id'         => esc_html__( 'ID - The post ID of the product', 'shop-spot' ),
                'menu_order' => esc_html__( 'Menu Order - The Menu Order, if set (lower numbers display first)', 'shop-spot' ),
                'popularity' => esc_html__( 'Popularity - The number of purchases', 'shop-spot' ),
                'rand'       => esc_html__( 'Random', 'shop-spot' ),
                'rating'     => esc_html__( 'Rating - The average product rating', 'shop-spot' ),
                'title'      => esc_html__( 'Title - The product title', 'shop-spot' ),
            ),
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'               => 'shop_spot_woo_products_showcase_products_filter',
            'default'            => 'none',
            'sanitize_callback'  => 'shop_spot_sanitize_select',
            'active_callback'    => 'shop_spot_is_woo_products_showcase_active',
            'label'              => esc_html__( 'Products Filter', 'shop-spot' ),
            'section'            => 'shop_spot_woo_products_showcase',
            'type'               => 'radio',
            'choices'            => array(
                'none'         => esc_html__( 'None', 'shop-spot' ),
                'on_sale'      => esc_html__( 'Retrieve on sale products', 'shop-spot' ),
                'best_selling' => esc_html__( 'Retrieve best selling products', 'shop-spot' ),
                'top_rated'    => esc_html__( 'Retrieve top rated products', 'shop-spot' ),
            ),
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_woo_products_showcase_featured',
            'sanitize_callback' => 'shop_spot_sanitize_checkbox',
            'active_callback'   => 'shop_spot_is_woo_products_showcase_active',
            'label'             => esc_html__( 'Show only Products that are marked as Featured Products', 'shop-spot' ),
            'section'           => 'shop_spot_woo_products_showcase',
            'custom_control'    => 'Shop_Spot_Toggle_Control',
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'               => 'shop_spot_woo_products_showcase_order',
            'default'            => 'ASC',
            'sanitize_callback'  => 'shop_spot_sanitize_select',
            'active_callback'    => 'shop_spot_is_woo_products_showcase_active',
            'label'              => esc_html__( 'Order', 'shop-spot' ),
            'section'            => 'shop_spot_woo_products_showcase',
            'type'               => 'radio',
            'choices'            => array(
                'ASC'  => esc_html__( 'Ascending', 'shop-spot' ),
                'DESC' => esc_html__( 'Descending', 'shop-spot' ),
            ),
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_woo_products_showcase_skus',
            'description'       => esc_html__( 'Comma separated list of product SKUs', 'shop-spot' ),
            'sanitize_callback' => 'sanitize_text_field',
            'active_callback'   => 'shop_spot_is_woo_products_showcase_active',
            'label'             => esc_html__( 'SKUs', 'shop-spot' ),
            'section'           => 'shop_spot_woo_products_showcase',
            'type'              => 'text',
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_woo_products_showcase_category',
            'description'       => esc_html__( 'Comma separated list of category slugs', 'shop-spot' ),
            'sanitize_callback' => 'sanitize_text_field',
            'active_callback'   => 'shop_spot_is_woo_products_showcase_active',
            'label'             => esc_html__( 'Category', 'shop-spot' ),
            'section'           => 'shop_spot_woo_products_showcase',
            'type'              => 'textarea',
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_woo_products_showcase_text',
            'default'           => esc_html__( 'Go to Shop Page', 'shop-spot' ),
            'sanitize_callback' => 'sanitize_text_field',
            'active_callback'   => 'shop_spot_is_woo_products_showcase_active',
            'label'             => esc_html__( 'Button Text', 'shop-spot' ),
            'section'           => 'shop_spot_woo_products_showcase',
            'type'              => 'text',
        )
    );
    $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_woo_products_showcase_link',
            'default'           =>  esc_url( $shop_page_url ),
            'sanitize_callback' => 'esc_url_raw',
            'active_callback'   => 'shop_spot_is_woo_products_showcase_active',
            'label'             => esc_html__( 'Button Link', 'shop-spot' ),
            'section'           => 'shop_spot_woo_products_showcase',
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_woo_products_showcase_target',
            'sanitize_callback' => 'shop_spot_sanitize_checkbox',
            'active_callback'   => 'shop_spot_is_woo_products_showcase_active',
            'label'             => esc_html__( 'Open Link in New Window/Tab', 'shop-spot' ),
            'section'           => 'shop_spot_woo_products_showcase',
            'custom_control'    => 'Shop_Spot_Toggle_Control',
        )
    );
}
add_action( 'customize_register', 'shop_spot_woo_products_showcase', 10 );

/** Active Callback Functions **/
if ( ! function_exists( 'shop_spot_is_woo_products_showcase_active' ) ) :
    /**
    * Return true if featured content is active
    *
    * @since 1.0.0
    */
    function shop_spot_is_woo_products_showcase_active( $control ) {
        $enable = $control->manager->get_setting( 'shop_spot_woo_products_showcase_option' )->value();

        return shop_spot_check_section( $enable );
    }
endif;
