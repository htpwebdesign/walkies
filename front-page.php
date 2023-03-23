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

		<section class="featured-product-section">
			<?php
			if ( function_exists( 'get_field' ) ) :

				if ( get_field( 'banner_image' ) ) {
					echo wp_get_attachment_image( get_field( 'banner_image' ), 'full' );
				}
				if ( get_field( 'featured_product_headline' ) ) {
					echo '<h1>' . ( get_field( 'featured_product_headline') ). '</h1>';
				}
				if ( get_field( 'featured_product_description' ) ) {
					echo '<p>'.get_field( 'featured_product_description' ).'</p>';
				}

				$primaryCTA = get_field( 'book_now_cta' );
				if( $primaryCTA ):
					?> 
				 	<a id ="book-now-cta" class="book-now-cta" href="<?php echo esc_url( $primaryCTA ); ?>"><?php esc_html_e('Book Now', 'walkies') ?></a>
					<?php 
				endif; 	 

				$secondaryCTA = get_field( 'view_all_packages_cta' );
				if( $secondaryCTA ):
					?> 
				 	<a id ="view-all-packages-cta" class="view-all-packages-cta" href="<?php echo esc_url( $secondaryCTA ); ?>"><?php esc_html_e('View All Packages', 'walkies') ?></a>
					<?php 
				endif; 	 	
			endif;
			?>
		</section>

		<section class="featured_testimonial_section">		
			<h2><?php esc_html_e('Testimonials', 'walkies') ?></h2>

			<?php
			if ( function_exists( 'get_field' ) ) :
				$featuredTestimonials = get_field( 'featured_testimonials' );
				if( $featuredTestimonials ) : 		
						foreach( $featuredTestimonials as $testimonial ) :
							$testimonialFields = get_fields( $testimonial->ID );
							if( isset( $testimonialFields[ 'customer_photo' ], $testimonialFields[ 'quote' ] ) ): ?>
								<article class="testimonial-card">
									<?php 
									echo wp_get_attachment_image( $testimonialFields[ 'customer_photo' ], 'thumbnail-icon' ); 
									echo get_the_title( $testimonial->ID ); 
									?>
									<p><?php echo $testimonialFields[ 'quote' ]; ?></p>
								</article>	
								<?php
							endif;	
						endforeach;
						?>
					<?php
				endif;
			endif;
			?>
		</section>

		<section class="featured-faq-section">
			<h2><?php echo get_the_title(284); ?></h2>

			<?php
			if ( function_exists( 'get_field' ) ) :

				$featuredFAQ = get_field( 'featured_faqs' );
			
				if( $featuredFAQ ) : 
					foreach( $featuredFAQ as $singleFAQ ) : ?> 
						<article> 
							<button>
								<?php echo get_the_title( $singleFAQ->ID ); ?>
							</button>	
							<?php
							$faqFields = get_fields( $singleFAQ->ID );

							if( isset( $faqFields[ 'faq_answer' ] ) ): 
								?> <div><?php
								echo $faqFields[ 'faq_answer' ];	
								?></div><?php
							endif; ?>
						</article>
						<?php
					endforeach; 	
				endif; ?> 	

				<a href="<?php echo get_permalink( 284 ); ?>"> <?php esc_html_e('View All FAQs', 'walkies' ) ?></a><?php 	 

			endif; ?>	
		</section>
		
		<section class="featured-dog-testimonial">
			<h2><?php esc_html_e("Hear Our Pup's Paw-sitive Reviews!", 'walkies') ?></h2>
			
			<?php
			if ( function_exists( 'get_field' ) ) :	
				$featuredDogReviews = get_field( 'featured_dog_testimonials' );
				if( $featuredDogReviews) : ?>
					<?php
					foreach( $featuredDogReviews as $dogReview ) :
						$testimonialFields = get_fields( $dogReview->ID );
						if( isset( $testimonialFields[ 'customer_photo' ], $testimonialFields[ 'quote' ], $testimonialFields[ 'dog_audio' ] ) ): 
							?>
							<article>
								<?php 
								echo wp_get_attachment_image( $testimonialFields[ 'customer_photo' ]);
								echo get_the_title( $dogReview->ID);
								echo $testimonialFields[ 'quote' ];
								echo wp_get_attachment_url( $testimonialFields[ 'dog_audio' ] ); 
								?>
								<audio controls> 
									<source src="<?php echo $testimonialFields[ 'dog_audio' ] ?>" type="audio/mp3">
								</audio>
							</article>	
							<?php
						endif;	
					endforeach; ?>
					<?php
				endif;
			endif;
			?>
		</section>

		<section class="instagram-feed">
			<h2><?php esc_html_e("Check out our Instagram!", 'walkies') ?></h2>

			<!-- shortcode documentation: http://localhost:8888/goforwalkies/wp-admin/plugins.php?s=smash&plugin_status=all -->
			
			<?php echo do_shortcode( '[instagram-feed feed=1]' ); ?>	
		</section>

	</main><!-- #main -->

<?php
get_footer();
