<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>
<main class='site-main'>
  <?php while ( have_posts() ) : ?>
    <?php the_post(); ?>

    <?php wc_get_template_part( 'content', 'single-product' ); ?>

  <?php endwhile; // end of the loop. ?>

  <h2>Details</h2>
  <p class="product-description">
    <?php echo $product->get_description() ?>
  </p>

  <?php
    global $post;
    
    // 27: packages-passes, 31: physical-products	
    if( in_array( 27, $product->get_category_ids() ) )
      single_walkies_landing_page();
    else if( in_array( 31, $product->get_category_ids() ) )
      echo '<a href="' . get_permalink( 284 ) . '#refunds-cancellations">' . __('Refunds and Cancellations FAQ') . '</a>';
    

    function single_walkies_landing_page() {
      // Query packages-passes FAQs on single walkies
      $args = array(
        'post_type'       => 'gfw-faq',
        'posts_per_page'  => 3,
        'tax_query'       => array(
          array(
            'taxonomy'    => 'gfw-faq-category',
            'field'       => 'slug',
            'terms'       => 'packages-passes'
          )
        )
      );
      $query = new WP_Query( $args );

      if( $query -> have_posts() ): ?>
        <section class="featured-faq-section">
          <h2><?php esc_html_e('Top 3 FAQs', 'walkies' ); ?></h2>
          <?php
          while( $query -> have_posts() ):
            $query -> the_post(); ?>
            <article>
              <button class="accordion">
                <?php esc_html(the_title()); ?>
              </button>
              <?php if( function_exists( 'get_field' ) &&  get_field( 'faq_answer' ) ) : ?>
                <div class="panel"><?php echo get_field( 'faq_answer' ) ?></div>
              <?php endif; ?>
            </article>
            <?php
          endwhile;
          wp_reset_postdata(); ?>
          <a href="<?php get_permalink( 284 ) ?>">
            <?php esc_html_e('View All FAQs', 'walkies' ); ?>
          </a>
        </section>
      <?php
      endif;
    }
  ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

<?php

get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
