<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Shop_Spot
 */

if ( ! function_exists( 'shop_spot_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function shop_spot_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

		echo '<span class="posted-on">' . shop_spot_get_svg( array( 'icon' => 'calendar-new' ) ) . '<span class="screen-reader-text">' .  esc_html__( ' Posted on ', 'shop-spot' ) . '</span>' .  $posted_on . '</span>';
	}
endif;

if ( ! function_exists( 'shop_spot_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function shop_spot_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			$categories_list = get_the_category_list( ' ' ); // Separate list by space.

			if ( $categories_list  ) {
				echo '<span class="cat-links">' . '<span>' . __( 'Categories', 'shop-spot' ) . ':' .  '</span>' . $categories_list . '</span>';
			}

			$tags_list = get_the_tag_list( '', ' ' ); // Separate list by space.

			if ( $tags_list  ) {
				echo '<span class="tags-links">' . '<span>' . __( 'Tags', 'shop-spot' ) . ':' . '</span>' . $tags_list . '</span>';
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'shop-spot' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'shop-spot' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'shop_spot_author_bio' ) ) :
	/**
	 * Prints HTML with meta information for the author bio.
	 */
	function shop_spot_author_bio() {
		if ( '' !== get_the_author_meta( 'description' ) ) {
			get_template_part( 'template-parts/biography' );
		}
	}
endif;

if ( ! function_exists( 'shop_spot_by_line' ) ) :
	/**
	 * Prints HTML with meta information for the author bio.
	 */
	function shop_spot_by_line() {
		$post_id = get_queried_object_id();
		$post_author_id = get_post_field( 'post_author', $post_id );

		$byline = '<span class="author vcard">';

		$byline .= '<a class="url fn n" href="' . esc_url( get_author_posts_url( $post_author_id ) ) . '">' . esc_html( get_the_author_meta( 'nickname', $post_author_id ) ) . '</a></span>';

		echo '<span class="byline">' . shop_spot_get_svg( array( 'icon' => 'user' ) ) . '' . $byline . '</span>';
	}
endif;

if ( ! function_exists( 'shop_spot_cat_list' ) ) :
	/**
	 * Prints HTML with meta information for the categories
	 */
	function shop_spot_cat_list() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the / */
			$categories_list = get_the_category_list( esc_html__( ', ', 'shop-spot' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . shop_spot_get_svg( array( 'icon' => 'folder-light' ) ) . '<span class="screen-reader-text">%1$s </span>%2$s</span>', esc_html__(  'Cat Links', 'shop-spot' ), $categories_list ); // WPCS: XSS OK.
			}
		} elseif ( 'jetpack-portfolio' == get_post_type() ) {
			/* translators: used between list items, there is a space after the / */
			$categories_list = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '', esc_html__( ' / ', 'shop-spot' ) );

			if ( ! is_wp_error( $categories_list ) ) {
				printf( '<span class="cat-links">' . shop_spot_get_svg( array( 'icon' => 'folder-light' ) ) . '<span class="screen-reader-text">%1$s </span>%2$s</span>', esc_html__(  'Cat Links', 'shop-spot' ), $categories_list ); // WPCS: XSS OK.
			}
		}
	}
endif;

if ( ! function_exists( 'shop_spot_comments_link' ) ) :
	/**
	 * Prints HTML with meta information for the comments
	 */
	function shop_spot_comments_link() {
		if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'shop-spot' ), esc_html__( '1 Comment', 'shop-spot' ), esc_html__( '% Comments', 'shop-spot' ) );
			echo '</span>';
		}
	}
endif;

/**
 * Footer Text
 *
 * @get footer text from theme options and display them accordingly
 * @display footer_text
 * @action shop_spot_footer
 *
 * @since 1.0.0
 */
function shop_spot_footer_content() {
	$theme_data = wp_get_theme();

	$footer_content = sprintf( _x( 'Copyright &copy; %1$s %2$s %3$s', '1: Year, 2: Site Title with home URL, 3: Privacy Policy Link', 'shop-spot' ), esc_attr( date_i18n( __( 'Y', 'shop-spot' ) ) ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>', function_exists( 'get_the_privacy_policy_link' ) ? get_the_privacy_policy_link('| ') : '' ) . '<span class="sep"> | </span>' . esc_html( $theme_data->get( 'Name' ) ) . '&nbsp;' . esc_html__( 'by', 'shop-spot' ) . '&nbsp;<a target="_blank" href="' . esc_url( $theme_data->get( 'AuthorURI' ) ) . '">' . esc_html( $theme_data->get( 'Author' ) ) . '</a>'; 

	if ( ! $footer_content ) {
		// Bail early if footer content is empty
		return;
	}

	echo '<div class="site-info">' . $footer_content . '</div><!-- .site-info -->';
}
add_action( 'shop_spot_credits', 'shop_spot_footer_content', 10 );

if ( ! function_exists( 'shop_spot_single_image' ) ) :
	/**
	 * Display Single Page/Post Image
	 */
	function shop_spot_single_image() {
		$featured_image = get_theme_mod( 'shop_spot_single_layout', 'disabled' );

		?>
		<figure class="entry-image">
            <?php the_post_thumbnail( $featured_image ); ?>
        </figure>
   	<?php

	}
endif; // shop_spot_single_image.

if ( ! function_exists( 'shop_spot_archive_image' ) ) :
	/**
	 * Display Post Archive Image
	 */
	function shop_spot_archive_image() {
		if ( ! has_post_thumbnail() ) {
			// Bail if there is no featured image.
			return;
		}

		$archive_layout = get_theme_mod( 'shop_spot_homepage_archive_layout', 'right-sidebar' );

		if ( 'full-content' === $archive_layout ) {
			// Bail if full content is selected.
			return;
		}

		$thumbnail = 'shop-spot-slider';
		?>

		<div class="post-thumbnail">
			<a class="cover-link" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<img src="<?php the_post_thumbnail_url( $thumbnail ); ?>"> 
				<?php echo shop_spot_get_svg( array( 'icon' => 'info' ) ); ?>
			</a>
		</div>
		<?php
	}
endif; // shop_spot_archive_image.

if ( ! function_exists( 'shop_spot_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 */
	function shop_spot_comment( $comment, $args, $depth ) {
		if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-body">
				<?php esc_html_e( 'Pingback:', 'shop-spot' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'shop-spot' ), '<span class="edit-link">', '</span>' ); ?>
			</div>

		<?php else : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

				<div class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
				</div><!-- .comment-author -->

				<div class="comment-container">
					<header class="comment-meta">
						<?php printf( __( '%s <span class="says screen-reader-text">says:</span>', 'shop-spot' ), sprintf( '<cite class="fn author-name">%s</cite>', get_comment_author_link() ) ); ?>

						<a class="comment-permalink entry-meta" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>"><?php printf( esc_html__( '%s ago', 'shop-spot' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></time></a>
					<?php edit_comment_link( esc_html__( 'Edit', 'shop-spot' ), '<span class="edit-link">', '</span>' ); ?>
					</header><!-- .comment-meta -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'shop-spot' ); ?></p>
					<?php endif; ?>

					<div class="comment-content">
						<?php comment_text(); ?>
					</div><!-- .comment-content -->

					<?php
						comment_reply_link( array_merge( $args, array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<span class="reply">',
							'after'     => '</span>',
						) ) );
					?>
				</div><!-- .comment-content -->

			</article><!-- .comment-body -->
		<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>

		<?php
		endif;
	}
endif; // ends check for shop_spot_comment()

if ( ! function_exists( 'shop_spot_archives_cat_count_span' ) ) :
	/**
	 * Used to wrap post count in Categories widget with a span tag
	 *
	 * @since 1.0.0
	 */
	function shop_spot_archives_cat_count_span($links) {
		$links = str_replace('</a> (', '</a> <span>(', $links);
		$links = str_replace(')', ')</span>', $links);
		return $links;
	}
	add_filter( 'wp_list_categories', 'shop_spot_archives_cat_count_span' );
endif;

if ( ! function_exists( 'shop_spot_archives_count_span' ) ) :
	/**
	 * Used to wrap post count in Archives widget with a span tag
	 *
	 * @since 1.0.0
	 */
	function shop_spot_archives_count_span($links) {
		$links = str_replace('</a>&nbsp;(', '</a> <span>(', $links);
		$links = str_replace(')', ')</span>', $links);
		return $links;
	}
	add_filter( 'get_archives_link', 'shop_spot_archives_count_span' );
endif;

if ( ! function_exists( 'shop_spot_section_heading' ) ) :
	/**
	 * Display/get tagline title and subtitle
	 *
	 * @since 1.0.0
	 */
	function shop_spot_section_heading( $tagline, $title, $description = '', $echo = true ) {
		$output = '';
		if ( $title || $tagline || $description ) {
			$output .= '<div class="section-heading-wrapper">';

			if ( $tagline ){
				$output .= '<div class="section-tagline">' . wp_kses_post( $tagline) . '</div><!-- .section-description-wrapper -->';
			}

			if ( $title ){
				$output .= '<div class="section-title-wrapper"><h2 class="section-title">' . wp_kses_post( $title ) . '</h2></div>';
			}

			if ( $description ){
				$output .= '<div class="section-description"><p>' . wp_kses_post( $description ) . '</p></div><!-- .section-description-wrapper -->';
			}

			$output .= '</div><!-- .section-heading-wrapper -->';
		}

		if ( ! $echo ) {
			return $output;
		} 

		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'shop_spot_single_product_category' ) ) :
	/**
	 * Display Single Product Category
	 */
	function shop_spot_single_product_category() {
		global $product; ?>

		<div class="entry-meta">
			<?php echo wc_get_product_category_list( $product->get_id(), ', ' ); ?>
		</div>
		
	<?php
	}
endif; // shop_spot_single_image.

if ( ! function_exists( 'shop_spot_entry_category' ) ) :
	/**
	 * Prints HTML with meta information for the category.
	 */
	function shop_spot_entry_category( $echo = true ) {
		$output          = '';
		$categories_list = get_the_category_list( ' ' );

		if ( $categories_list && ! is_wp_error( $categories_list ) ) {
			/* translators: 1: list of categories. */
			$output = sprintf( '<span class="cat-links">%1$s%2$s</span>',
				sprintf( _x( '<span class="cat-text screen-reader-text">Categories</span>', 'Used before category names.', 'shop-spot' ) ),
				$categories_list
			); // WPCS: XSS OK.
		}

		if ( $echo ) {
			echo $output;
		} else {
			return $output;
		}
	}
endif;
