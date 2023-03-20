<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Walkies
 */

get_header();
?>

	<main id="primary" class="site-main">

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <header class="entry-header">
        <?php
          if ( function_exists( 'get_field' ) ) {
            if ( get_field( 'about_the_company_headline' )) {
              echo '<h1>' . esc_html( get_the_title() ) . '</h1>';
            }
          }
        ?>
      </header><!-- .entry-header -->

      <?php walkies_post_thumbnail(); ?>

      <div class="entry-content">
        <?php
        the_content();

        wp_link_pages(
          array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'walkies' ),
            'after'  => '</div>',
          )
        );
        ?>

        <?php
        if ( function_exists( 'get_field' ) ) {
          if ( get_field( 'descriptive_paragraphs' )) {
            // TODO Fix
            // the_field( 'descriptive_paragraphs' );
          }

          $walkers = get_field( 'human_testimonial' );
          if ( $walkers ) : ?>

            <ul>
              <?php 
              foreach ( $walkers as $walker ):
                $walker_fields = get_fields( $walker->ID );

                if( isset( $walker_fields['customer_photo'], $walker_fields['quote'] ) ):
              ?>
                <li>
                  <a href="<?php echo get_permalink( $walker->ID ); ?>">
                    <img 
                      src="<?php echo $walker_fields['customer_photo']; ?>" 
                      alt="<?php echo get_the_title( $walker->ID ); ?> profile photo"
                      style="width: 100px; height: 100px;"
                    />
                    <span>
                      <?php echo get_the_title( $walker->ID ); ?>
                    </span>
                    <p>
                      <?php echo $walker_fields['quote']; ?>
                    </span>
                  </a>
                </li>
              
              <?php 
                endif;
              endforeach;
              ?>
            </ul>


            <?php
          endif;

          if ( get_field( 'location' )) : 
            $location = get_field('location');
            get_template_part( 'template-parts/content', 'map-helper' ); ?>
            
            <div class="acf-map" data-zoom="16">
                <div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>"></div>
            </div>

          <?php endif;
          if ( get_field( 'social_media_headline' )) {
              echo '<h2>' . esc_html( get_field( 'social_media_headline' ) ) . '</h2>';
          }
          if ( get_field( 'instagram_feed' ) &&  get_field( 'instagram_feed' ) === '1') {
              echo do_shortcode('[instagram-feed feed=1]');
          }
        }
        ?>
      </div><!-- .entry-content -->

    </article>
    
    <!-- #post-<?php the_ID(); ?> -->

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
