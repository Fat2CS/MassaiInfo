<?php
/**
 * Theme Options
 *
 * @package Shop_Spot
 */

/**
 * Add theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function shop_spot_theme_options( $wp_customize ) {
	$wp_customize->add_panel( 'shop_spot_theme_options', array(
		'title'    => esc_html__( 'Theme Options', 'shop-spot' ),
		'priority' => 130,
	) );

	// Layout Options
	$wp_customize->add_section( 'shop_spot_layout_options', array(
		'title' => esc_html__( 'Layout Options', 'shop-spot' ),
		'panel' => 'shop_spot_theme_options',
		)
	);

	/* Default Layout */
	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_default_layout',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'shop_spot_sanitize_select',
			'label'             => esc_html__( 'Default Layout', 'shop-spot' ),
			'section'           => 'shop_spot_layout_options',
			'type'              => 'select',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'shop-spot' ),
				'no-sidebar-full-width' => esc_html__( 'No Sidebar: Full Width', 'shop-spot' ),
			),
		)
	);

	/* Homepage/Archive Layout */
	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_homepage_archive_layout',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'shop_spot_sanitize_select',
			'label'             => esc_html__( 'Homepage/Archive Layout', 'shop-spot' ),
			'section'           => 'shop_spot_layout_options',
			'type'              => 'select',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'shop-spot' ),
				'no-sidebar-full-width' => esc_html__( 'No Sidebar: Full Width', 'shop-spot' ),
			),
		)
	);

	/* Single Page/Post Image */
	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_single_layout',
			'default'           => 'disabled',
			'sanitize_callback' => 'shop_spot_sanitize_select',
			'label'             => esc_html__( 'Single Page/Post Image', 'shop-spot' ),
			'section'           => 'shop_spot_layout_options',
			'type'              => 'select',
			'choices'           => array(
				'disabled'        => esc_html__( 'Disabled', 'shop-spot' ),
				'post-thumbnail'  => esc_html__( 'Post Thumbnail', 'shop-spot' ),
			),
		)
	);

	// Excerpt Options.
	$wp_customize->add_section( 'shop_spot_excerpt_options', array(
		'panel'     => 'shop_spot_theme_options',
		'title'     => esc_html__( 'Excerpt Options', 'shop-spot' ),
	) );

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_excerpt_length',
			'default'           => '25',
			'sanitize_callback' => 'absint',
			'input_attrs' => array(
				'min'   => 10,
				'max'   => 200,
				'step'  => 5,
				'style' => 'width: 80px;',
			),
			'label'    => esc_html__( 'Excerpt Length (words)', 'shop-spot' ),
			'section'  => 'shop_spot_excerpt_options',
			'type'     => 'number',
		)
	);

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_excerpt_more_text',
			'default'           => esc_html__( 'Continue reading', 'shop-spot' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Read More Text', 'shop-spot' ),
			'section'           => 'shop_spot_excerpt_options',
			'type'              => 'text',
		)
	);

	// Homepage / Frontpage Options.
	$wp_customize->add_section( 'shop_spot_homepage_options', array(
		'description' => esc_html__( 'Only posts that belong to the categories selected here will be displayed on the front page', 'shop-spot' ),
		'panel'       => 'shop_spot_theme_options',
		'title'       => esc_html__( 'Homepage / Frontpage Options', 'shop-spot' ),
	) );

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_recent_posts_tagline',
			'default'              => 'Latest Updates & Posts',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Recent Posts Tagline', 'shop-spot' ),
			'section'           => 'shop_spot_homepage_options',
			'type'              => 'text'
		)
	);

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_recent_posts_title',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'From Our Blog', 'shop-spot' ),
			'label'             => esc_html__( 'Recent Posts Title', 'shop-spot' ),
			'section'           => 'shop_spot_homepage_options',
		)
	);

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_static_page_heading',
			'sanitize_callback' => 'sanitize_text_field',
			'active_callback'	=> 'shop_spot_is_static_page_enabled',
			'default'           => esc_html__( 'Archives', 'shop-spot' ),
			'label'             => esc_html__( 'Posts Page Header Text', 'shop-spot' ),
			'section'           => 'shop_spot_homepage_options',
		)
	);

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_front_page_category',
			'sanitize_callback' => 'shop_spot_sanitize_category_list',
			'custom_control'    => 'Shop_Spot_Multi_Cat',
			'label'             => esc_html__( 'Categories', 'shop-spot' ),
			'section'           => 'shop_spot_homepage_options',
			'type'              => 'dropdown-categories',
		)
	);

	// Pagination Options.
	$pagination_type = get_theme_mod( 'shop_spot_pagination_type', 'default' );

	$nav_desc = '';

	/**
	* Check if navigation type is Jetpack Infinite Scroll and if it is enabled
	*/
	$nav_desc = sprintf(
		wp_kses(
			__( 'For infinite scrolling, use %1$sCatch Infinite Scroll Plugin%2$s with Infinite Scroll module Enabled.', 'shop-spot' ),
			array(
				'a' => array(
					'href' => array(),
					'target' => array(),
				),
				'br'=> array()
			)
		),
		'<a target="_blank" href="https://wordpress.org/plugins/catch-infinite-scroll/">',
		'</a>'
	);

	$wp_customize->add_section( 'shop_spot_pagination_options', array(
		'description'     => $nav_desc,
		'panel'           => 'shop_spot_theme_options',
		'title'           => esc_html__( 'Pagination Options', 'shop-spot' ),
		'active_callback' => 'shop_spot_scroll_plugins_inactive'
	) );

	shop_spot_register_option( $wp_customize, array(
			'name'              => 'shop_spot_pagination_type',
			'default'           => 'default',
			'sanitize_callback' => 'shop_spot_sanitize_select',
			'choices'           => shop_spot_get_pagination_types(),
			'label'             => esc_html__( 'Pagination type', 'shop-spot' ),
			'section'           => 'shop_spot_pagination_options',
			'type'              => 'select',
		)
	);

		/* Scrollup Options */
		$wp_customize->add_section( 'shop_spot_scrollup', array(
			'panel'    => 'shop_spot_theme_options',
			'title'    => esc_html__( 'Scrollup Options', 'shop-spot' ),
		) );

		$action = 'install-plugin';
		$slug   = 'to-top';

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

		// Add note to Scroll up Section
	    shop_spot_register_option( $wp_customize, array(
	            'name'              => 'shop_spot_to_top_note',
	            'sanitize_callback' => 'sanitize_text_field',
	            'custom_control'    => 'Shop_Spot_Note_Control',
	            'active_callback'   => 'shop_spot_is_to_top_inactive',
	            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
	            'label'             => sprintf( esc_html__( 'For Scroll Up, install %1$sTo Top%2$s Plugin', 'shop-spot' ),
	                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
	                '</a>'

	            ),
	           'section'            => 'shop_spot_scrollup',
	            'type'              => 'description',
	            'priority'          => 1,
	        )
	    );
}
add_action( 'customize_register', 'shop_spot_theme_options' );

/** Active Callback Functions */

if ( ! function_exists( 'shop_spot_scroll_plugins_inactive' ) ) :
	/**
	* Return true if infinite scroll functionality exists
	*
	* @since 1.0.0
	*/
	function shop_spot_scroll_plugins_inactive( $control ) {
		if ( ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) || class_exists( 'Catch_Infinite_Scroll' ) ) {
			// Support infinite scroll plugins.
			return false;
		}

		return true;
	}
endif;

if ( ! function_exists( 'shop_spot_is_static_page_enabled' ) ) :
	/**
	* Return true if A Static Page is enabled
	*
	* @since 1.0.0
	*/
	function shop_spot_is_static_page_enabled( $control ) {
		$enable = $control->manager->get_setting( 'show_on_front' )->value();
		if ( 'page' === $enable ) {
			return true;
		}
		return false;
	}
endif;

if ( ! function_exists( 'shop_spot_scroll_plugins_inactive' ) ) :
	/**
	* Return true if infinite scroll functionality exists
	*
	* @since 1.0.0
	*/
	function shop_spot_scroll_plugins_inactive( $control ) {
		if ( ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) || class_exists( 'Catch_Infinite_Scroll' ) ) {
			// Support infinite scroll plugins.
			return false;
		}

		return true;
	}
endif;

if ( ! function_exists( 'shop_spot_is_to_top_inactive' ) ) :
    /**
    * Return true if featured_content is active
    *
    * @since Simclick 0.1
    */
    function shop_spot_is_to_top_inactive( $control ) {
        return ! ( class_exists( 'To_Top' ) );
    }
endif;
