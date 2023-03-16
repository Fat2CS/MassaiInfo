<?php
/**
 * Adding support for WooCommerce Plugin
 */

if ( ! class_exists( 'WooCommerce' ) ) {
    // Bail if WooCommerce is not installed
    return;
}

if ( ! function_exists( 'shop_spot_woocommerce_setup' ) ) :
    /**
     * Sets up support for various WooCommerce features.
     */
    function shop_spot_woocommerce_setup() {
        add_theme_support( 'woocommerce', array(
            'thumbnail_image_width'         => 480,
            'single_image_width'            => 580,
            'gallery_thumbnail_image_width' => 120,
        ) );

        if ( get_theme_mod( 'shop_spot_product_gallery_zoom', 1 ) ) {
            add_theme_support('wc-showcasegallery-zoom');
        }

        if ( get_theme_mod( 'shop_spot_product_gallery_lightbox', 1 ) ) {
            add_theme_support('wc-product-gallery-lightbox');
        }

        if ( get_theme_mod( 'shop_spot_product_gallery_slider', 1 ) ) {
            add_theme_support('wc-product-gallery-slider');
        }
    }
endif; //shop_spot_woocommerce_setup
add_action( 'after_setup_theme', 'shop_spot_woocommerce_setup' );

/**
 * Add WooCommerce Options to customizer
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function shop_spot_woocommerce_options( $wp_customize ) {
    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_shop_subtitle',
            'sanitize_callback' => 'wp_kses_post',
            'label'             => esc_html__( 'Shop Page Subtitle', 'shop-spot' ),
            'default'           => esc_html__( 'This is where you can add new products to your store.', 'shop-spot' ),
            'section'           => 'shop_spot_woocommerce_options',
            'type'              => 'textarea',
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_woocommerce_layout',
            'default'           => 'right-sidebar',
            'sanitize_callback' => 'shop_spot_sanitize_select',
            'description'       => esc_html__( 'Layout for WooCommerce Pages', 'shop-spot' ),
            'label'             => esc_html__( 'WooCommerce Layout', 'shop-spot' ),
            'section'           => 'shop_spot_layout_options',
            'type'              => 'radio',
            'choices'           => array(
                'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'shop-spot' ),
                'no-sidebar-full-width' => esc_html__( 'No Sidebar: Full Width', 'shop-spot' ),
            ),
        )
    );

    // WooCommerce Options
    $wp_customize->add_section( 'shop_spot_woocommerce_options', array(
        'title'       => esc_html__( 'WooCommerce Options', 'shop-spot' ),
        'panel'       => 'shop_spot_theme_options',
        'description' => esc_html__( 'Since these options are added via theme support, you will need to save and refresh the customizer to view the full effect.', 'shop-spot' ),
    ) );

    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_product_gallery_zoom',
            'default'           => 1,
            'sanitize_callback' => 'shop_spot_sanitize_checkbox',
            'label'             => esc_html__( 'Product Gallery Zoom', 'shop-spot' ),
            'section'           => 'shop_spot_woocommerce_options',
            'custom_control'    => 'Shop_Spot_Toggle_Control',
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_product_gallery_lightbox',
            'default'           => 1,
            'sanitize_callback' => 'shop_spot_sanitize_checkbox',
            'label'             => esc_html__( 'Product Gallery Lightbox', 'shop-spot' ),
            'section'           => 'shop_spot_woocommerce_options',
            'custom_control'    => 'Shop_Spot_Toggle_Control',
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'              => 'shop_spot_product_gallery_slider',
            'default'           => 1,
            'sanitize_callback' => 'shop_spot_sanitize_checkbox',
            'label'             => esc_html__( 'Product Gallery Slider', 'shop-spot' ),
            'section'           => 'shop_spot_woocommerce_options',
            'custom_control'    => 'Shop_Spot_Toggle_Control',
        )
    );

    shop_spot_register_option( $wp_customize, array(
            'name'               => 'shop_spot_shop_page_header_image',
            'sanitize_callback'  => 'shop_spot_sanitize_checkbox',
            'label'              => esc_html__( 'Header Image on Single Product page', 'shop-spot' ),
            'section'            => 'header_image',
            'custom_control'    => 'Shop_Spot_Toggle_Control',
        )
    );
}
add_action( 'customize_register', 'shop_spot_woocommerce_options' );

if ( ! function_exists( 'shop_spot_header_primary_cart' ) ) {
    /**
     * Display Header Cart
     *
     * @since 1.0
     * @uses  shop_spot_is_woocommerce_activated() check if WooCommerce is activated
     * @return void
     */
    function shop_spot_header_primary_cart() {
        if ( is_cart() ) {
            $class = 'current-menu-item';
        } else {
            $class = '';
        }
        ?>
        <div id="site-header-cart-wrapper" class="menu-wrapper">
            <ul id="site-header-cart" class="site-header-cart menu">
                <li class="<?php echo esc_attr( $class ); ?>">
                    <?php shop_spot_primary_cart_link(); ?>
                </li>
                <li>
                    <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
                </li>
            </ul>
        </div>
        <?php
    }
}

if ( ! function_exists( 'shop_spot_primary_cart_link' ) ) {
    /**
     * Cart Link
     * Displayed a link to the cart including the number of items present and the cart total
     *
     * @return void
     * @since 1.0
     */
    function shop_spot_primary_cart_link() {
        ?>
        <a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'shop-spot' ); ?>"> 
            <span class="cart-icon">
                <span class="count">(<?php echo absint( WC()->cart->get_cart_contents_count() ); ?>)</span>
                <?php echo shop_spot_get_svg( array( 'icon' => 'shopping-bag' ) ); ?>
            </span>
            
            <?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?>
        </a>
        <?php
    }
}

/**
 * Change number of related products output
 */ 
function woo_related_products_limit() {
  global $product;
    
    $args['posts_per_page'] = 6;
    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );
  function jk_related_products_args( $args ) {
    $args['posts_per_page'] = 3; // 3 related products
    $args['columns'] = 3; // arranged in 3 columns
    return $args;
}

/**
 * uses remove_action to remove the WooCommerce Wrapper and add_action to add Main Wrapper
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'shop_spot_woocommerce_start' ) ) :
    function shop_spot_woocommerce_start() {
    	echo '<div id="primary" class="content-area"><main role="main" class="site-main woocommerce" id="main"><div class="woocommerce-posts-wrapper">';
    }
endif; //shop_spot_woocommerce_start
add_action( 'woocommerce_before_main_content', 'shop_spot_woocommerce_start', 15 );

if ( ! function_exists( 'shop_spot_woocommerce_end' ) ) :
    function shop_spot_woocommerce_end() {
    	echo '</div><!-- .woocommerce-posts-wrapper --></main><!-- #main --></div><!-- #primary -->';
    }
endif; //shop_spot_woocommerce_end
add_action( 'woocommerce_after_main_content', 'shop_spot_woocommerce_end', 15 );

function shop_spot_woocommerce_shorting_start() {
	echo '<div class="woocommerce-shorting-wrapper">';
}
add_action( 'woocommerce_before_shop_loop', 'shop_spot_woocommerce_shorting_start', 10 );

function shop_spot_woocommerce_shorting_end() {
	echo '</div><!-- .woocommerce-shorting-wrapper -->';
}
add_action( 'woocommerce_before_shop_loop', 'shop_spot_woocommerce_shorting_end', 40 );

function shop_spot_woocommerce_product_container_start() {
	echo '<div class="product-container">';
}
add_action( 'woocommerce_before_shop_loop_item_title', 'shop_spot_woocommerce_product_container_start', 20 );

function shop_spot_woocommerce_product_container_end() {
	echo '</div><!-- .product-container -->';
}
add_action( 'woocommerce_after_shop_loop_item', 'shop_spot_woocommerce_product_container_end', 20 );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function shop_spot_woocommerce_active_body_class( $classes ) {
    $classes[] = 'woocommerce-active';

    return $classes;
}
add_filter( 'body_class', 'shop_spot_woocommerce_active_body_class' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function shop_spot_woocommerce_scripts() {
    $font_path   = WC()->plugin_url() . '/assets/fonts/';
    $inline_font = '@font-face {
            font-family: "star";
            src: url("' . $font_path . 'star.eot");
            src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
                url("' . $font_path . 'star.woff") format("woff"),
                url("' . $font_path . 'star.ttf") format("truetype"),
                url("' . $font_path . 'star.svg#star") format("svg");
            font-weight: normal;
            font-style: normal;
        }';

    wp_add_inline_style( 'shop-spot-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'shop_spot_woocommerce_scripts' );

if ( ! function_exists( 'shop_spot_woocommerce_product_columns_wrapper' ) ) {
    /**
     * Product columns wrapper.
     *
     * @return  void
     */
    function shop_spot_woocommerce_product_columns_wrapper() {
        // Get option from Customizer=> WooCommerce=> Product Catlog=> Products per row.
        echo '<div class="wocommerce-section-content-wrapper columns-' . absint( get_option( 'woocommerce_catalog_columns', 4 ) ) . '">';
    }
}
add_action( 'woocommerce_before_shop_loop', 'shop_spot_woocommerce_product_columns_wrapper', 40 );

if ( ! function_exists( 'shop_spot_woocommerce_product_columns_wrapper_close' ) ) {
    /**
     * Product columns wrapper close.
     *
     * @return  void
     */
    function shop_spot_woocommerce_product_columns_wrapper_close() {
        echo '</div>';
    }
}
add_action( 'woocommerce_after_shop_loop', 'shop_spot_woocommerce_product_columns_wrapper_close', 40 );

/**
 * Make Shop Page Title dynamic
 */
function shop_spot_woocommerce_shop_subtitle( $args ) {
    if ( is_shop() ) {
        return wp_kses_post( get_theme_mod( 'shop_spot_shop_subtitle', esc_html__( 'This is where you can add new products to your store.', 'shop-spot' ) ) );
    }

    return $args;
}
add_filter( 'get_the_archive_description', 'shop_spot_woocommerce_shop_subtitle', 20 );

/**
* woo_hide_page_title
*
* Removes the "shop" title on the main shop page
*
* @access      public
* @since 1.0.0
* @return      void
*/
 
function shop_spot_woocommerce_hide_page_title() { 
    if ( is_shop() && shop_spot_has_header_media_text() ) {
        return false;
    }

    return true;  
}
add_filter( 'woocommerce_show_page_title', 'shop_spot_woocommerce_hide_page_title' ); 

if ( ! function_exists( 'shop_spot_remove_default_woo_store_notice' ) ) {
    /**
     * Remove default Store Notice from footer, added in header.php
     *
     * @return  void
     */
    function shop_spot_remove_default_woo_store_notice() {
        remove_action( 'wp_footer', 'woocommerce_demo_store' );
    }
}
add_action( 'after_setup_theme', 'shop_spot_remove_default_woo_store_notice', 40 );


/**
 * WooCommerce Products Showcase Section
 */
require get_parent_theme_file_path( 'inc/customizer/woo-products-showcase.php' );

/**
 * Collection Section
 */
require get_parent_theme_file_path( 'inc/customizer/collection.php' );
