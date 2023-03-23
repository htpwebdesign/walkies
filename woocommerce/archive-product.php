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
      echo '<p>' . get_field( 'walkies_intro_message', $page_id ) . '</p>';
      echo '</section>';
    endif;

    $best_sellers = get_field( 'best_seller_packages', $page_id );
    if( get_field( 'best_sellers_heading', $page_id ) && $best_sellers ):
      echo '<section class="walkies-best-sellers">';
      echo '<h2>' . get_field( 'best_sellers_heading', $page_id ) . '</h2>';
      echo '<ul class="bestseller-cards">';

      foreach( $best_sellers as $best_seller ) : ?>
        <li class="bestseller-card">
          <?php
            $product = wc_get_product( $best_seller->ID );
            $terms = get_the_terms( $best_seller->ID, 'product_cat');

            echo get_the_post_thumbnail($best_seller);
            echo '<span class="title">' . get_the_title($best_seller -> ID) . '</span>';

            foreach($terms as $term) :
              if( $term->term_id != 27): // packages-passes
                echo '<p>' . esc_html($term->name) . '</p>';

                if( $best_seller->ID == 481 ) // subscription
                  echo '<a href="' . $product->get_permalink() . '">' . __('View Options') . '</a>';
                elseif ($term->slug == 'passes')
                  echo do_shortcode("[add_to_cart id=" . $best_seller -> ID . " show_price='false' style='']");
                else
                  echo '<a href="' . $product->get_permalink() . '">' . __('Book Now') . '</a>';
              endif;
            endforeach;	
            
            echo '<span class="price">' . $product->get_price_html() . '</span>';
      
          ?>
        </li>
      <?php endforeach;	?>
      </ul>
      </section>
    <?php
    endif;

    $packages_gallery = get_field( 'package_gallery', $page_id );
    if( get_field( 'packages_heading', $page_id ) && get_field( 'package_gallery', $page_id )):
      echo '<section class="walkies_packages">';
      echo "<h2>" . get_field( 'packages_heading', $page_id ) . "</h2>";

      // package_gallery
      foreach( $packages_gallery as $package ) :
        ?>
        <article class="packages-gallery-card">
          <?php
          echo get_the_post_thumbnail( $package );
          echo get_the_title( $package->ID );

          $post_categories = wp_get_post_categories( $package->ID );
          $cats = array();

          global $post;
          $terms = get_the_terms( $package->ID, 'product_cat' );
          foreach( $terms as $term ) :
            if( $term->term_id != 27 ) :
              echo '<p>'.esc_html( $term->name ).'</p>';
            endif;
          endforeach;

          $product = wc_get_product( $package->ID );
          echo $product->get_price_html();

          $description = $product->get_description();
          echo '<p>'.esc_html($description).'</p>';

          echo '<a href="' . $product->get_permalink() . '">' . __('Book Now') . '</a>';
 
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
      <ul class="passes-gallery-cards">
        <?php
          foreach( $passes_gallery as $pass ) : ?>
            <li class="passes-gallery-card">
              <?php
                $product = wc_get_product( $best_seller->ID );

                echo get_the_post_thumbnail($pass);
                echo '<span class="title">' . get_the_title($pass -> ID) . '</span>';
                echo '<span class="price">' . $product->get_price_html() . '</span>';
                echo do_shortcode("[add_to_cart id=" . $pass -> ID . " show_price='false' style='']");
                echo '<a href="' . $product->get_permalink() . '">' . __('View Pass') . '</a>';
              ?>
            </li>
        <?php endforeach;	?>
        </ul>
      </section>
    <?php
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
