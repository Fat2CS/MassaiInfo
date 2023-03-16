<?php
/**
 * The template for displaying collection items
 *
 * @package Shop_Spot
 */

$args = array(
	'ignore_sticky_posts' => 1 // ignore sticky posts
);

$post_list  = array();// list of valid post/page ids

$no_of_post = 0; // for number of posts

$args['post_type'] = 'product';

for ( $i = 1; $i <= 2; $i++ ) {
	$shop_spot_post_id = '';

	$shop_spot_post_id =  get_theme_mod( 'shop_spot_collection_product_' . $i );

	if ( $shop_spot_post_id && '' !== $shop_spot_post_id ) {
		// Polylang Support.
		if ( class_exists( 'Polylang' ) ) {
			$shop_spot_post_id = pll_get_post( $shop_spot_post_id, pll_current_language() );
		}

		$post_list = array_merge( $post_list, array( $shop_spot_post_id ) );

		$no_of_post++;
	}
}

$args['post__in'] = $post_list;
$args['orderby'] = 'post__in';

if ( 0 === $no_of_post ) {
	return;
}

$args['posts_per_page'] = $no_of_post;
$loop     = new WP_Query( $args ); ?>

<div class="collection-main">

	<?php if ( $loop -> have_posts() ) :
		while ( $loop -> have_posts() ) :
			$loop -> the_post();

			get_template_part( 'template-parts/collection/content', 'collection' );

		endwhile;
		wp_reset_postdata();
	endif; ?>

</div>
