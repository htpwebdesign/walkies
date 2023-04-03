<?php
/**
 * The template for displaying the FAQ Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Walkies
 */

get_header();
?>

	<main id="primary" class="site-main">
	<h1><?php esc_html(the_title());?></h1>

		<?php
		the_content();
		// Anchor nav based on terms
		$terms = get_terms(array(
			'taxonomy' 		=> 'gfw-faq-category',
			'hide_empty'	=> true,
			'orderby'		=> 'title',
			'order'			=> 'ASC',
		));

		if($terms && !is_wp_error($terms)){
			?><nav class="faq-nav"> <?php 
			foreach($terms as $oneTerm) {
				echo "<a href='#".esc_attr($oneTerm->slug)."'>".esc_attr($oneTerm->name)."</a>";
			}
			?></nav><?php
			
			foreach($terms as $oneTerm){
				echo "<section class='faq-cat'>";
				echo "<h2 id='".($oneTerm->slug)."'>".esc_attr($oneTerm->name)."</h2>";

				$args = array(
					'post-type'			=> 'gfw-faq',
					'posts_per_page'	=> -1,
					'orderby'			=> 'title',
					'order'				=> 'ASC',
					'tax_query'			=> array(
						array(
							'taxonomy'	=> 'gfw-faq-category',
							'field'		=> 'slug',
							'terms'		=> $oneTerm->slug,
						),
					)
					);

					$query = new WP_QUERY($args);

					while($query->have_posts()){
						$query->the_post(); ?>
					
						<article>
              <button class="accordion">
                <?php esc_html(the_title()); ?>
              </button>
              <?php
                if( function_exists( 'get_field' )) {
                  if( get_field( 'faq_answer' ) ) {
                    echo '<div class="panel">';
                    the_field( 'faq_answer' );
                    echo '</div>';
                  }
                }
              ?>
            </article>
					<?php
					}
			}		
			wp_reset_postdata();
		}

	?></main><!-- #main -->

<?php
get_footer();
