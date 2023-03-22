<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Walkies
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function walkies_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 150,
			'single_image_width'    => 300,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'walkies_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function walkies_woocommerce_scripts() {
	wp_enqueue_style( 'walkies-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array(), _S_VERSION );

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

	wp_add_inline_style( 'walkies-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'walkies_woocommerce_scripts' );

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
function walkies_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'walkies_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function walkies_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'walkies_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'walkies_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function walkies_woocommerce_wrapper_before() {
		?>
			<main id="primary" class="site-main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'walkies_woocommerce_wrapper_before' );

if ( ! function_exists( 'walkies_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function walkies_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'walkies_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'walkies_woocommerce_header_cart' ) ) {
			walkies_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'walkies_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function walkies_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		walkies_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'walkies_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'walkies_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function walkies_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'walkies' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'walkies' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'walkies_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function walkies_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php walkies_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}

function shop_landing_page($page_id) {
  if( function_exists( 'get_field' ) ): 
    if( get_field( 'banner_image', $page_id ))
      echo wp_get_attachment_image( get_field( 'banner_image', $page_id ), 'full' );
 
    if( get_field( 'product_intro_summary', $page_id ))
      the_field( 'product_intro_summary', $page_id );
 
    if( get_field( 'walkies_packages_image', $page_id ))
      echo wp_get_attachment_image( get_field( 'walkies_packages_image', $page_id ) );

    if( get_field( 'walkies_headline', $page_id ))
      the_field( 'walkies_headline', $page_id );

    if( get_field( 'walkies_intro_summary', $page_id ))
      the_field( 'walkies_intro_summary', $page_id );

    if( get_field( 'book_walkies_cta', $page_id ))
      the_field( 'book_walkies_cta', $page_id );

    if( get_field( 'products_gallery_headline', $page_id ))
      the_field( 'products_gallery_headline', $page_id );
  endif;
}

function walkies_landing_page($page_id) {
  if( function_exists( 'get_field' ) ): 
    if( get_field( 'banner_image', $page_id ))
      echo wp_get_attachment_image( get_field( 'banner_image', $page_id ), 'full' );

    if( get_field( 'walkies_intro_message', $page_id ))
      the_field( 'walkies_intro_message', $page_id );

    if( get_field( 'best_sellers_heading', $page_id ))
      the_field( 'best_sellers_heading', $page_id );

    $best_sellers = get_field( 'best_seller_packages', $page_id );
    if( $best_sellers ): ?>
      <!-- Display Relationship fields -->
    <?php
    endif;

    if( get_field( 'packages_heading', $page_id ))
      the_field( 'packages_heading', $page_id );

    // if( get_field( 'package_gallery', $page_id ))
      // the_field( 'package_gallery', $page_id );

    if( get_field( 'passes_heading', $page_id ))
      the_field( 'passes_heading', $page_id );

    if( get_field( 'passes_description', $page_id ))
      the_field( 'passes_description', $page_id );

    // if( get_field( 'passes_gallery', $page_id ))
      // the_field( 'passes_gallery', $page_id );

  endif;
}

function single_walkies_landing_page() {
  $args = array(
    'post_type'			  => 'gfw-faq',
    'posts_per_page'	=> 3,
    'tax_query'       => array(
      array(
        'taxonomy'	  => 'gfw-faq-category',
        'field'		    => 'slug',
        'terms'       => 'packages-passes'
      )
    )
  );
  $query = new WP_Query( $args );

  if( $query -> have_posts() ):
    echo '<ol><h3>Top 3 FAQs</h3>';
    while( $query -> have_posts() ):
      $query -> the_post();
      ?>
        <article>
          <button>
            <?php esc_html(the_title()); ?>
          </button>
          <?php
            if( function_exists( 'get_field' )) {
              if( get_field( 'faq_answer' ) ) {
                echo '<div>';
                the_field( 'faq_answer' );
                echo '</div>';
              }
            }
          ?>
        </article>
      <?php
    endwhile;
    wp_reset_postdata();
    echo '</ol>';
  endif;
}

// Display ACF fields on walkies(archive-product) and shop(taxonomy-product-cat)
add_action( 
  'woocommerce_before_shop_loop', 
  function() {
    $page_title = single_term_title( '', false );

    if ( $page_title == 'Physical Products' )
      shop_landing_page( 12 );
    else {
      walkies_landing_page( 91 );
    }
  }
);

// Query Top3 FAQs on single walkies
add_action( 
  'woocommerce_after_main_content',
  function() {
    if ( is_product() ): ?>
      <a href="<?php echo get_permalink( 284 ); ?>">
        <?php esc_html_e('View All FAQs', 'walkies' ) ?>
      </a>
    <?php
      global $product;
      // 27 = Packages & Passes ID
      if( in_array(27, $product->get_category_ids()) )
        single_walkies_landing_page();
    endif;
  },
  10
);


// Delete default contents on walkies and shop page
remove_action(
  'woocommerce_before_shop_loop',
  'woocommerce_result_count',
  20
);

remove_action(
  'woocommerce_before_shop_loop',
  'woocommerce_catalog_ordering',
  30
);

remove_action(
  'woocommerce_before_main_content',
  'woocommerce_breadcrumb',
  20
);

remove_action(
  'woocommerce_sidebar',
  'woocommerce_get_sidebar',
  10
);
