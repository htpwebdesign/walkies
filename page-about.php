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
        <?php echo '<h1>' . esc_html( get_the_title() ) . '</h1>'; ?>
      </header><!-- .entry-header -->

      <?php walkies_post_thumbnail(); ?>

      <div class="entry-content">
        <?php the_content(); ?>

        <?php 
        if( function_exists( 'get_field' ) ): 
          if( have_rows( 'descriptive_paragraphs' ) ):
            while( have_rows( 'descriptive_paragraphs' ) ): the_row();
              $sub_value = get_sub_field( 'who_we_are' );
            
              if( get_row_layout() == 'who_we_are' ):
                echo '<section class="who_section"><h2>Who We Are</h2>';
                echo wp_get_attachment_image( get_sub_field( 'banner_image' ), 'full' );
                echo '<p>' . get_sub_field( 'content' ) . '</p>';
                echo '</section>';

              elseif( get_row_layout() == 'what_we_do' ):
                echo '<section class="what_section"><h2>What We Do</h2>';
                echo '<p>' . get_sub_field( 'content' ) . '</p>';
                echo '</section>';

              elseif( get_row_layout() == 'why_choose_us' ):
                if( have_rows( 'reasons' ) ):
                  echo '<section class="why_section"><h2>Why Choose Us</h2>';
                  while( have_rows( 'reasons' )): the_row();
                    echo '<article>';
                    echo wp_get_attachment_image( get_sub_field( 'icon' ), 'thumbnail-icon' );
                    echo "<h3>".get_sub_field('title')."</h3>";
                    echo "<p>".get_sub_field('description')."</p>";
                    echo '</article>';
                  endwhile;
                  echo '</section>';
                endif;

              endif;
            endwhile;
          endif; 
        ?>

          <?php
          $walkers = get_field( 'human_testimonial' );
          if ( $walkers ) : ?>
            <section class="human_section">
              <h2>
                <?php
                esc_html_e('Customer Testimonials', 'walkies');
                ?>
              </h2>
                <?php 
                foreach ( $walkers as $walker ):
                  $walker_fields = get_fields( $walker->ID );

                  if( isset( $walker_fields['customer_photo'], $walker_fields['quote'] ) ):
                ?>
                  <article>

                      <?php echo wp_get_attachment_image( $walker_fields['customer_photo'], 'thumbnail-icon' ); ?>
                      <h3>
                        <?php echo get_the_title( $walker->ID ); ?>
                      </h3>
                      <p>
                        <?php echo $walker_fields['quote']; ?>
                      </p>
                   
                  </article>
                
                <?php 
                  endif;
                endforeach;
                ?>
              
            </section>

          <?php endif; ?>

          <section class="location_section">
            <h2><?php esc_html_e('Walkies Service Areas', 'walkies');?></h2>
            <iframe src="https://snazzymaps.com/embed/474769" width="100%" height="400px" style="border:none;"></iframe>
          </section>

        <?php 
          if ( get_field( 'social_media_headline' )):
            echo '<section class="social_section">';
            echo '<h2>' . esc_html( get_field( 'social_media_headline' ) ) . '</h2>';
            get_template_part( 'template-parts/content', 'contact-socials');
            echo '</section>';
          endif;

          if ( get_field( 'instagram_feed' ) &&  get_field( 'instagram_feed' ) == '1'):
            echo '<section class="instagram_section"><h2>Instagram</h2>';
            echo do_shortcode('[instagram-feed feed=1]');
            echo '</section>';
          endif;
        endif;
        ?>
      </div><!-- .entry-content -->

    </article>
    
    <!-- #post-<?php the_ID(); ?> -->

	</main><!-- #main -->

<?php
get_footer();
