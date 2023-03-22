<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>

<header class="woocommerce-products-header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>
</header>

<?php

if ( is_shop() )
  walkies_landing_page( 91 );
else if ( is_product_category('physical-products') )
  shop_landing_page( 12 );

get_footer( 'shop' );


function walkies_landing_page($page_id) {
  if( function_exists( 'get_field' ) ): 
    if( get_field( 'banner_image', $page_id ) && get_field( 'walkies_intro_message', $page_id )):
      echo '<section class="walkies_intro">';
      echo wp_get_attachment_image( get_field( 'banner_image', $page_id ), 'full' );
      echo "<p>" . get_field( 'walkies_intro_message', $page_id ) . "</p>";
      echo '</section>';
    endif;

    $best_sellers = get_field( 'best_seller_packages', $page_id );
    if( get_field( 'best_sellers_heading', $page_id ) && $best_sellers ):
      echo '<section class="walkies_best_sellers">';
      echo "<h2>" . get_field( 'best_sellers_heading', $page_id ) . "</h2>";
      // best_sellers
      echo '</section>';
    endif;

    if( get_field( 'packages_heading', $page_id ) && get_field( 'package_gallery', $page_id )):
      echo '<section class="walkies_packages">';
      echo "<h2>" . get_field( 'packages_heading', $page_id ) . "</h2>";
      // package_gallery
      echo '</section>';
    endif;

    $passes_gallery = get_field( 'passes_gallery', $page_id );
    if( get_field( 'passes_heading', $page_id ) && get_field( 'passes_description', $page_id ) && $passes_gallery):
      echo '<section class="walkies_passes">';
      echo "<h2>" . get_field( 'passes_heading', $page_id ) . "</h2>";
      echo "<p>" . get_field( 'passes_description', $page_id ) . "</p>";
      // $passes_gallery
      echo '</section>';
    endif;

  endif;
}


function shop_landing_page($page_id) {
  if( function_exists( 'get_field' ) ): 
    echo '<section class="shop_banner">';
    if( get_field( 'banner_image', $page_id ))
      echo wp_get_attachment_image( get_field( 'banner_image', $page_id ), 'full' );
 
    if( get_field( 'product_intro_summary', $page_id ))
      echo "<p>" . get_field( 'product_intro_summary', $page_id ) . "</p>";
 
    echo '</section>';

    echo '<section class="shop_package">';
    if( get_field( 'walkies_packages_image', $page_id ))
      echo wp_get_attachment_image( get_field( 'walkies_packages_image', $page_id ) );

    if( get_field( 'walkies_headline', $page_id ))
      echo "<h2>" . get_field( 'walkies_headline', $page_id ) . "</h2>";

    if( get_field( 'walkies_intro_summary', $page_id ))
      echo "<p>" . get_field( 'walkies_intro_summary', $page_id ) . "</p>";

    $primaryCTA = get_field( 'book_walkies_cta', $page_id );
    if( $primaryCTA["title"]): ?> 
      <a class="book-walkies-cta" href="<?php echo esc_url( $primaryCTA["url"] ); ?>" target="_blank">
        <?php echo $primaryCTA["title"]  ?>
      </a>
    <?php 
    endif;
    echo '</section>';

    if( get_field( 'products_gallery_headline', $page_id )):
      echo '<section class="shop_products">';
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
        echo '<ol>';
        while( $query -> have_posts() ):
          $query -> the_post();
          wc_get_template_part( 'content', 'product' );
        endwhile;
        wp_reset_postdata();
        echo '</ol>';
      endif;
      echo '</section>';
    endif;

  endif;
}
