<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Shop_Spot
 */

if ( ! function_exists( 'shop_spot_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see shop_spot_custom_header_setup().
	 */
	function shop_spot_header_style() {
		$header_image = shop_spot_featured_overall_image();

	    $header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( '000000' === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
		?>
			.site-title a,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
			// If the user has set a custom color for the text use that.
			else :
		?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;

if ( ! function_exists( 'shop_spot_featured_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own shop_spot_featured_image(), and that function will be used instead.
	 *
	 * @since 1.0.0
	 */
	function shop_spot_featured_image() {
		if ( is_header_video_active() && has_header_video() ) {
			return get_header_image();
		}

		$thumbnail = 'shop-spot-slider';

		if ( is_post_type_archive( 'jetpack-testimonial' ) ) {
			$jetpack_options = get_theme_mod( 'jetpack_testimonials' );

			if ( isset( $jetpack_options['featured-image'] ) && '' !== $jetpack_options['featured-image'] ) {
				$image = wp_get_attachment_image_src( (int) $jetpack_options['featured-image'], $thumbnail );
				return $image['0'];
			} else {
				return false;
			}
		} elseif ( is_post_type_archive( 'jetpack-portfolio' ) || is_post_type_archive( 'featured-content' ) || is_post_type_archive( 'ect-service' ) ) {
			$option = '';

			if ( is_post_type_archive( 'jetpack-portfolio' ) ) {
				$option = 'jetpack_portfolio_featured_image';
			} elseif ( is_post_type_archive( 'featured-content' ) ) {
				$option = 'featured_content_featured_image';
			} elseif ( is_post_type_archive( 'ect-service' ) ) {
				$option = 'ect_service_featured_image';
			}

			$featured_image = get_option( $option );

			if ( '' !== $featured_image ) {
				$image = wp_get_attachment_image_src( (int) $featured_image, $thumbnail );
				return isset( $image[0] ) ? $image[0] : false;
			} else {
				return get_header_image();
			}
		} elseif ( is_header_video_active() && has_header_video() ) {
			return true;
		} else {
			return get_header_image();
		}
	} // shop_spot_featured_image
endif;

if ( ! function_exists( 'shop_spot_featured_page_post_image' ) ) :
	/**
	 * Template for Featured Header Image from Post and Page
	 *
	 * To override this in a child theme
	 * simply create your own shop_spot_featured_imaage_pagepost(), and that function will be used instead.
	 *
	 * @since 1.0.0
	 */
	function shop_spot_featured_page_post_image() {
		$thumbnail = 'shop-spot-slider';

		if ( class_exists( 'WooCommerce' ) && is_shop() ) {
			if ( ! has_post_thumbnail( absint( get_option( 'woocommerce_shop_page_id' ) ) ) ) {
				return shop_spot_featured_image();
			}
		} elseif ( is_home() && $blog_id = get_option('page_for_posts') ) {
			if ( has_post_thumbnail( $blog_id  ) ) {
		    	return get_the_post_thumbnail_url( $blog_id, $thumbnail );
			} else {
				return  shop_spot_featured_image();
			}
		} elseif ( ! has_post_thumbnail() && is_front_page() ) {
			return  shop_spot_featured_image();
		} elseif ( is_home() && is_front_page() ) {
			return  shop_spot_featured_image();
		}

		$shop_header = get_theme_mod( 'shop_spot_shop_page_header_image' );
		if ( class_exists( 'WooCommerce' ) && is_shop() ) {
			return get_the_post_thumbnail_url( absint( get_option( 'woocommerce_shop_page_id' ) ), $thumbnail );
		}elseif ( class_exists( 'WooCommerce' ) && is_product () ) {
			if (  $shop_header ){
			return get_the_post_thumbnail_url( get_the_id(), $thumbnail );
			}
		} elseif( ! has_post_thumbnail() ) {
			return get_header_image();
		} else {
			return get_the_post_thumbnail_url( get_the_id(), $thumbnail );
		}
	} // shop_spot_featured_page_post_image
endif;

if ( ! function_exists( 'shop_spot_featured_overall_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own shop_spot_featured_pagepost_image(), and that function will be used instead.
	 *
	 * @since 1.0.0
	 */
	function shop_spot_featured_overall_image() {
		global $post;
		$enable = get_theme_mod( 'shop_spot_header_media_option', 'homepage' );

		// Check Enable/Disable header image in Page/Post Meta box
		if ( is_singular() || ( class_exists( 'WooCommerce' ) && is_page( wc_get_page_id( 'shop' ) ) ) ) {
			$shop_spot_id = $post->ID;

			if ( class_exists( 'WooCommerce' ) && is_shop() ) {
				$shop_spot_id = absint( get_option( 'woocommerce_shop_page_id' ) );
			}

			//Individual Page/Post Image Setting
			$individual_featured_image = get_post_meta( $shop_spot_id, 'shop-spot-header-image', true );

			if ( 'disable' === $individual_featured_image || ( 'default' === $individual_featured_image && 'disable' === $enable ) ) {
				return 'disable' ;
			} elseif ( 'enable' == $individual_featured_image ) {
				return shop_spot_featured_page_post_image();
			}
		}

		// Check Homepage
		if ( 'homepage' === $enable ) {
			if ( is_front_page() ) {
				return shop_spot_featured_image();
			}
		} elseif ( 'exclude-home' === $enable ) {
			// Check Excluding Homepage
			if ( ! is_front_page() ) {
				return shop_spot_featured_image();
			}
		} elseif ( 'exclude-home-page-post' === $enable ) {
			if ( is_front_page() ) {
				return 'disable';
			} elseif ( is_singular() || ( class_exists( 'WooCommerce' ) && is_shop() ) ) {
				return shop_spot_featured_page_post_image();
			} else {
				return shop_spot_featured_image();
			}
		} elseif ( 'entire-site' === $enable ) {
			// Check Entire Site
			return shop_spot_featured_image();
		} elseif ( 'entire-site-page-post' === $enable ) {
			// Check Entire Site (Post/Page)
			if ( is_singular() || ( class_exists( 'WooCommerce' ) && is_shop() ) || ( is_home() && ! is_front_page() ) ) { 
				return shop_spot_featured_page_post_image();
			} else {
				return shop_spot_featured_image();
			}
		} elseif ( 'pages-posts' === $enable ) {
			// Check Page/Post
			if ( is_singular() || ( class_exists( 'WooCommerce' ) && is_shop() ) ) {
				return shop_spot_featured_page_post_image();
			}
		}

		return 'disable';
	} // shop_spot_featured_overall_image
endif;

if ( ! function_exists( 'shop_spot_header_media_text' ) ):
	/**
	 * Display Header Media Text
	 *
	 * @since 1.0.0
	 */
	function shop_spot_header_media_text() {
		if ( ! shop_spot_has_header_media_text() ) {
			// Bail early if header media text is disabled on front page
			return false;
		}

		$before_subtitle = get_theme_mod( 'shop_spot_header_media_before_subtitle' );
		?>
		<div class="custom-header-content sections header-media-section content-align-left text-align-left">
			<div class="custom-header-content-wrapper">

				<?php
				$before = '<div class="section-title-wrapper"><h2 class="entry-title';

				if ( is_singular() ) {
					$before = '<div class="section-title-wrapper"><h1 class="entry-title';
				}

				$before .= '">';

				if ( is_singular() ) {
					shop_spot_header_title( $before, '</h1></div>' );
				} else {
					shop_spot_header_title( $before, '</h2></div>' );
				}

				$highlighted_text = get_theme_mod( 'shop_spot_header_media_highlighted_text' );

				if( is_front_page() && $highlighted_text ) : ?>
				<div class="highlight-text">
					<?php echo esc_html( $highlighted_text ); ?>
				</div>
				<?php endif; 
				
				shop_spot_header_description( '<div class="site-header-text">', '</div>' ); ?>

				<?php if ( is_front_page() ) :
					$header_media_url_text            = get_theme_mod( 'shop_spot_header_media_url_text' );
				?>

					<?php if ( $header_media_url_text ) :
						?>
						<p>
							<?php if ( $header_media_url_text ) :
								$header_media_url = get_theme_mod( 'shop_spot_header_media_url', '#' );
								?>
								<span class="more-button"><a href="<?php echo esc_url( $header_media_url ); ?>" target="<?php echo esc_attr( get_theme_mod( 'shop_spot_header_url_target' ) ? '_blank' : '_self' ); ?>" class="more-link"><?php echo esc_html( $header_media_url_text ); ?><span class="screen-reader-text"><?php echo wp_kses_post( $header_media_url_text ); ?></span></a></span>
							<?php endif; ?>
						</p>
					<?php endif; ?>
				<?php endif; ?>
			</div><!-- .custom-header-content-wrapper -->
		</div><!-- .custom-header-content -->
		<?php
	} // shop_spot_header_media_text.
endif;

if ( ! function_exists( 'shop_spot_has_header_media_text' ) ):
	/**
	 * Return Header Media Text fro front page
	 *
	 * @since 1.0.0
	 */
	function shop_spot_has_header_media_text() {
		$header_image = shop_spot_featured_overall_image();

		if ( is_front_page() ) {
			$header_media_title    = get_theme_mod( 'shop_spot_header_media_title' );
			$header_media_text     = get_theme_mod( 'shop_spot_header_media_text' );
			$header_media_url      = get_theme_mod( 'shop_spot_header_media_url');
			$header_media_url_text = get_theme_mod( 'shop_spot_header_media_url_text');

			if ( ! $header_media_title && ! $header_media_text && ! $header_media_url && ! $header_media_url_text ) {
				// Bail early if header media text is disabled
				return false;
			}
		} elseif ( 'disable' === $header_image ) {
			return false;
		}

		return true;
	} // shop_spot_has_header_media_text.
endif;

if ( ! function_exists( 'shop_spot_header_title' ) ) :
	/**
	 * Display header media text
	 */
	function shop_spot_header_title( $before = '', $after = '' ) {
		if ( is_front_page() ) {
			$header_media_title = get_theme_mod( 'shop_spot_header_media_title' );
			if ( $header_media_title ) {
				echo $before . wp_kses_post( $header_media_title ) . $after;
			}
		} else if ( is_home() ) {
			$header_media_title = get_theme_mod( 'shop_spot_static_page_heading','Archives' );
			if ( $header_media_title ) {
				echo $before . wp_kses_post( $header_media_title ) . $after;
			}
		} elseif ( is_singular() ) {
			if ( is_page() ) {
				the_title( $before, $after );
			} else {
				the_title( $before, $after );
			}
		} elseif ( is_404() ) {
			echo $before . esc_html__( 'Nothing Found', 'shop-spot' ) . $after;
		} elseif ( is_search() ) {
			/* translators: %s: search query. */
			echo $before . sprintf( esc_html__( 'Search Results for: %s', 'shop-spot' ), '<span>' . get_search_query() . '</span>' ) . $after;
		} elseif( class_exists( 'WooCommerce' ) && is_woocommerce() ) {
			echo $before . esc_html( woocommerce_page_title( false ) ) . $after;
		}
		else {
			the_archive_title( $before, $after );
		}
	}
endif;

if ( ! function_exists( 'shop_spot_header_description' ) ) :
	/**
	 * Display header media description
	 */
	function shop_spot_header_description( $before = '', $after = '' ) {
		if ( is_front_page() && get_theme_mod( 'shop_spot_header_media_text' ) ) {
			echo $before . '<p>' . wp_kses_post( get_theme_mod( 'shop_spot_header_media_text' ) ) . '</p>' . $after;
		} elseif ( is_singular() && ! is_page() ) {
			echo $before . '<div class="entry-header"><div class="entry-meta">';
				shop_spot_posted_on();
			echo '</div><!-- .entry-meta --></div>' . $after;
		} elseif ( is_404() ) {
			echo $before . '<p>' . esc_html__( 'Oops! That page can&rsquo;t be found', 'shop-spot' ) . '</p>' . $after;
		} else {
			the_archive_description( $before, $after );
		}
	}
endif;
