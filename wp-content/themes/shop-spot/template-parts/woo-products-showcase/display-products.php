<?php
/**
 * The template for displaying Woo Products Showcase
 *
 * @package Shop_Spot
 */

if ( ! class_exists( 'WooCommerce' ) ) {
    // Bail if WooCommerce is not installed
    return;
}

$enable_content = get_theme_mod( 'shop_spot_woo_products_showcase_option', 'disabled' );

if ( ! shop_spot_check_section( $enable_content ) ) {
	// Bail if featured content is disabled.
	return;
}

$number            = get_theme_mod( 'shop_spot_woo_products_showcase_number', 6 );
$columns           = get_theme_mod( 'shop_spot_woo_products_showcase_columns', 4 );
$paginate          = get_theme_mod( 'shop_spot_woo_products_showcase_paginate' );
$shop_spot_orderby = isset( $_GET['orderby'] ) ? $_GET['orderby'] : get_theme_mod( 'shop_spot_woo_products_showcase_orderby' );
$product_filter    = get_theme_mod( 'shop_spot_woo_products_showcase_products_filter' );
$featured          = get_theme_mod( 'shop_spot_woo_products_showcase_featured' );
$shop_spot_order   = get_theme_mod( 'shop_spot_woo_products_showcase_order' );
$skus              = get_theme_mod( 'shop_spot_woo_products_showcase_skus' );
$category          = get_theme_mod( 'shop_spot_woo_products_showcase_category' );

$shortcode = '[products';

if ( $number ) {
	$shortcode .= ' limit="' . esc_attr( $number ) . '"';
}

if ( $columns ) {
	$shortcode .= ' columns="' . absint( $columns ) . '"';
}

if ( $paginate ) {
	$shortcode .= ' paginate="' . esc_attr( $paginate ) . '"';
}

if ( $shop_spot_orderby ) {
	$shortcode .= ' orderby="' . esc_attr( $shop_spot_orderby ) . '"';
}

if ( $shop_spot_order ) {
	$shortcode .= ' order="' . esc_attr( $shop_spot_order ) . '"';
}

if ( $product_filter && 'none' !== $product_filter ) {
	$shortcode .= ' ' . esc_attr( $product_filter ) . '="true"';
}

if ( $skus ) {
	$shortcode .= ' skus="' . esc_attr( $skus ) . '"';
}

if ( $category ) {
	$shortcode .= ' category="' . esc_attr( $category ) . '"';
}

if ( $featured ) {
	$shortcode .= ' visibility="featured"';
}

$shortcode .= ']';  

$subtitle 		= get_theme_mod( 'shop_spot_woo_products_showcase_tagline' );
$shop_spot_title = get_theme_mod( 'shop_spot_woo_products_showcase_title' );
$description    = get_theme_mod( 'shop_spot_woo_products_showcase_description');

$classes[] = 'section product-content-section';

if ( ! $shop_spot_title && ! $description && ! $subtitle ) {
	$classes[] = 'no-section-heading';
}

$background = get_theme_mod( 'shop_spot_woo_products_showcase_bg_image' );

if ( $background ) {
	$classes[] = 'has-background-image';
}
?>

<div id="product-content-section" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wrapper">
		<?php if ( $shop_spot_title || $description || $subtitle ) : ?>
			<div class="section-heading-wrapper">
				<?php if ( $subtitle ) : ?>
					<div class="section-subtitle">
						<?php echo esc_html( $subtitle); ?>
					</div>
				<?php endif; ?>

				<?php if ( $shop_spot_title ) : ?>
					<div class="section-title-wrapper">
						<h2 class="section-title"><?php echo wp_kses_post( $shop_spot_title ); ?></h2>
					</div><!-- .section-title-wrapper -->
				<?php endif; ?>

				<?php if ( $description ) : ?>
					<div class="section-description">
						<p>
							<?php
								echo wp_kses_post( $description );
							?>
						</p>	
					</div><!-- .section-description-wrapper -->
				<?php endif; ?>
			</div><!-- .section-heading-wrap -->
		<?php endif; ?>

		<div class="section-content-wrapper product-content-wrapper">
	     	<?php echo do_shortcode( $shortcode ); ?>
		</div><!-- .section-content-wrapper -->

		<?php
			$target = get_theme_mod( 'shop_spot_woo_products_showcase_target' ) ? '_blank': '_self';
			$shop_spot_link   = get_theme_mod( 'shop_spot_woo_products_showcase_link', get_permalink( wc_get_page_id( 'shop' ) ) );
			$text   = get_theme_mod( 'shop_spot_woo_products_showcase_text', esc_html__( 'Go to Shop Page', 'shop-spot' ) );

			if ( $text ) :
		?>
			<p class="view-more">
				<a class="button" target="<?php echo $target; ?>" href="<?php echo esc_url( $shop_spot_link ); ?>"><?php echo esc_html( $text ); ?></a>
			</p>
		<?php endif; ?>
	</div><!-- .wrapper -->
</div><!-- .sectionr -->
