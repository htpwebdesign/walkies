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

/**
 * Remove related products on single product.
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

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

// Remove product page tabs
function gfw_remove_all_product_tabs( $tabs ) {
  unset( $tabs['description'] );        // Remove the description tab
  unset( $tabs['reviews'] );            // Remove the reviews tab
  unset( $tabs['additional_information'] );    // Remove the additional information tab
  return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'gfw_remove_all_product_tabs', 98 );

/**
 * Archive Page - Walkies List
 */
function walkies_list_page($page_id) {
  if( function_exists( 'get_field' ) ): 
    if( get_field( 'banner_image', $page_id ) && get_field( 'walkies_intro_message', $page_id )):
      echo '<section class="featured-product-section">';
      echo wp_get_attachment_image( get_field( 'banner_image', $page_id ), 'full' );
      ?>
        <h1><?php woocommerce_page_title(); ?></h1>
      <?php
      echo '<p>' . get_field( 'walkies_intro_message', $page_id ) . '</p>';
      echo '</section>';
    endif;

    $best_sellers = get_field( 'best_seller_packages', $page_id );
    if( get_field( 'best_sellers_heading', $page_id ) && $best_sellers ):
      echo '<section class="walkies-best-sellers">';
      echo '<h2>' . get_field( 'best_sellers_heading', $page_id ) . '</h2>';

      foreach( $best_sellers as $best_seller ) : ?>
        <article class="package-list-card banner-card bestseller-card">
          <?php
            $product = wc_get_product( $best_seller->ID );
            $terms = get_the_terms( $best_seller->ID, 'product_cat');

            echo get_the_post_thumbnail($best_seller);
            echo '<div class="card-content">';
            echo '<h3 class="title">' . get_the_title($best_seller -> ID) . '</h3>';

            foreach($terms as $term) :
              if( $term->term_id != 27): // packages-passes
                echo '<span class="tag">' . esc_html($term->name) . '</span>';
                echo '<span class="price">' . $product->get_price_html() . '</span>';

                if( $best_seller->ID == 481 ) // subscription
                  echo '<a href="' . $product->get_permalink() . '" class="cta">' . __('View Options') . '</a>';
                elseif ($term->slug == 'passes')
                  echo do_shortcode("[add_to_cart id=" . $best_seller -> ID . " show_price='false' style='' class='cta-cart']");
                else
                  echo '<a href="' . $product->get_permalink() . '" class="cta">' . __('Book Now') . '</a>';
              endif;
            endforeach;	
                        
            echo '</div>';
      
          ?>
        </article>
      <?php endforeach;	?>
      </section>
    <?php
    endif;

    $packages_gallery = get_field( 'package_gallery', $page_id );
    if( get_field( 'packages_heading', $page_id ) && get_field( 'package_gallery', $page_id )):
      echo '<section class="walkies-packages">';
      echo "<h2>" . get_field( 'packages_heading', $page_id ) . "</h2>";

      // package_gallery
      foreach( $packages_gallery as $package ) :
        ?>
        <article class="package-list-card banner-card packages-card">
          <?php
          echo get_the_post_thumbnail( $package );
          
          echo "<div class='card-content'>";
          echo "<h3 class='title'>".get_the_title( $package->ID )."</h3>";

          $product = wc_get_product( $package->ID );
          echo '<span class="price">' . $product->get_price_html() . '</span>';

          $description = $product->get_description();
          echo '<p>'.esc_html($description).'</p>';

          echo '<a href="' . $product->get_permalink() . '" class="cta">' . __('Book Now') . '</a>';
          echo "</div>";
 
          ?>
        </article>
        <?php   
      endforeach;
      echo '</section>';
    endif;

    $passes_gallery = get_field( 'passes_gallery', $page_id );
    if( get_field( 'passes_heading', $page_id ) && get_field( 'passes_description', $page_id ) && $passes_gallery): 
      echo '<section class="walkies-passes">';
      echo '<h2>' . get_field( 'passes_heading', $page_id ) . '</h2>';
      echo '<p>' . get_field( 'passes_description', $page_id ) . '</p>';
    ?>

        <?php
          foreach( $passes_gallery as $pass ) : ?>
            <article class="package-list-card passes-card">
              <?php
                $product = wc_get_product( $best_seller->ID );

                echo get_the_post_thumbnail($pass);
              ?>
              <div class="card-content">
                <h3 class="title"><?php echo get_the_title($pass -> ID) ?></h3>
                <span class="price"><?php echo $product->get_price_html() ?></span>
                <div class="card-buttons">
                  <?php echo do_shortcode("[add_to_cart id=" . $pass -> ID . " show_price='false' style='' class='cta-cart']"); ?>
                  <a href="<?php echo $product->get_permalink()?>" class="sub-cta"><?php esc_html_e('View Pass'); ?></a>
                </div>
              </div>
            </article>
        <?php endforeach;	?>
      </section>
    <?php
    endif;

  endif;
}

/**
 * Category Page - Product List
 */
function shop_list_page($page_id) {
  if( function_exists( 'get_field' ) ): 
    echo '<section class="featured-product-section">';
    if( get_field( 'banner_image', $page_id ))
      echo wp_get_attachment_image( get_field( 'banner_image', $page_id ), 'full' );
      ?>
        <h1><?php woocommerce_page_title(); ?></h1>
      <?php
    if( get_field( 'product_intro_summary', $page_id ))
      echo "<p>" . get_field( 'product_intro_summary', $page_id ) . "</p>";
 
    echo '</section>';

    echo '<section class="shop-package-bg">';
    echo '<div class="shop-package">';
    if( get_field( 'walkies_packages_image', $page_id ))
      echo wp_get_attachment_image( get_field( 'walkies_packages_image', $page_id ), 'full' );

    echo '<div class="shop-package-content">';
    if( get_field( 'walkies_headline', $page_id ))
      echo "<h2>" . get_field( 'walkies_headline', $page_id ) . "</h2>";

    if( get_field( 'walkies_intro_summary', $page_id ))
      echo "<p>" . get_field( 'walkies_intro_summary', $page_id ) . "</p>";

    $primaryCTA = get_field( 'book_walkies_cta', $page_id );
    if( $primaryCTA["title"]): ?> 
      <a class="book-walkies-cta" href="<?php echo esc_url( $primaryCTA["url"] ); ?>">
        <?php echo $primaryCTA["title"]  ?>
      </a>
    <?php 
    endif;
    echo '</div>';
    echo '</div>';
    echo '</section>';

    if( get_field( 'products_gallery_headline', $page_id )):
      echo '<section class="shop-products">';
      echo '<h2>' . get_field( 'products_gallery_headline', $page_id ) . '</h2>';

      $args = array(
        'post_type'       => 'product',
        'posts_per_page'  => 4,
        'order'           => 'DESC',
        'order_by'        => 'date',
        'tax_query'       => array(
          array(
            'taxonomy'    => 'product_cat',
            'field'       => 'slug',
            'terms'       => 'physical-products'
          )
        )
      );
      $query = new WP_Query( $args );

      if( $query -> have_posts() ):
        echo '<ul class="products">';
        while( $query -> have_posts() ):
          $query -> the_post();
          wc_get_template_part( 'content', 'product' );
        endwhile;
        wp_reset_postdata();
        echo '</ul>';
      endif;
      echo '</section>';
    endif;

  endif;
}
