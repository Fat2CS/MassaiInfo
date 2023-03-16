<div id="social-search-wrapper" class="social-search-wrapper">
	<?php if ( has_nav_menu( 'social-menu' ) ) : ?>
		<div id="social-menu-wrapper" class="menu-wrapper">
			<?php get_template_part( 'template-parts/navigation/navigation', 'social' ); ?>
		</div><!-- .menu-wrapper -->
	<?php endif; ?>

	<div id="primary-search-wrapper" class="menu-wrapper">
		<div class="menu-toggle-wrapper">
			<button id="social-search-toggle" class="menu-toggle search-toggle">
				<?php echo shop_spot_get_svg( array( 'icon' => 'search' ) ); echo shop_spot_get_svg( array( 'icon' => 'close' ) ); ?>
				<span class="menu-label screen-reader-text"><?php echo esc_html_e( 'Search', 'shop-spot' ); ?></span>
			</button>
		</div><!-- .menu-toggle-wrapper -->

		<div class="menu-inside-wrapper">
			<div class="search-container">
				<?php 
				if ( class_exists( 'WooCommerce' ) ) {
				    get_product_search_form(); 
				} else {
					get_search_form(); 
				}
				?>
			</div>
		</div><!-- .menu-inside-wrapper -->
	</div><!-- #social-search-wrapper.menu-wrapper -->
	<?php 

	if( class_exists( 'WooCommerce') ) {
		shop_spot_header_primary_cart(); 
	}
	?>

</div><!-- .social-search-wrapper -->
