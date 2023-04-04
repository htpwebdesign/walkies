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
				$secondaryCTA = get_field( 'view_all_packages_cta' );

				if($primaryCTA || $secondaryCTA): ?>
					<div class="banner-cta"><?php
				if( $primaryCTA ):
					?> 
				 	<a id ="book-now-cta" class="book-now-cta" href="<?php echo esc_url( $primaryCTA ); ?>"><?php esc_html_e('Book Now', 'walkies') ?></a>
					<?php 
				endif; 	 

				if( $secondaryCTA ):
					?> 
				 	<a id ="view-all-packages-cta" class="view-all-packages-cta" href="<?php echo esc_url( $secondaryCTA ); ?>"><?php esc_html_e('View All Packages', 'walkies') ?></a>
					<?php 
				endif; 	 	
			endif;
			?></div><?php
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
									echo "<h3>".get_the_title( $testimonial->ID )."</h3>"; 
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
		
		<?php $featuredPackages = get_field('featured_walkies_packages');

			if($featuredPackages) : ?>
			<section class="featured-packages"> 
				<h2 class="invis"><?php esc_html_e('Featured Walkies', 'walkies') ?></h2><?php
				foreach($featuredPackages as $onePackage) { 	
					$post = get_post($onePackage->ID);
					$content = $post->post_content; 
					$price = wc_get_product($onePackage->ID)->get_price_html(); ?>
					<article class="featured-package-single"> 
					<svg class="dog-icon" viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><path d="M298.06,224,448,277.55V496a16,16,0,0,1-16,16H368a16,16,0,0,1-16-16V384H192V496a16,16,0,0,1-16,16H112a16,16,0,0,1-16-16V282.09C58.84,268.84,32,233.66,32,192a32,32,0,0,1,64,0,32.06,32.06,0,0,0,32,32ZM544,112v32a64,64,0,0,1-64,64H448v35.58L320,197.87V48c0-14.25,17.22-21.39,27.31-11.31L374.59,64h53.63c10.91,0,23.75,7.92,28.62,17.69L464,96h64A16,16,0,0,1,544,112Zm-112,0a16,16,0,1,0-16,16A16,16,0,0,0,432,112Z"/><title>Dog Icon from https://www.iconfinder.com/</title></svg>
						<h3> <?php echo get_the_title($onePackage->ID); ?></h3>	
						<p class="price"><?php echo $price;?></p>
						<p class="description"><?php echo $content;?></p>	
						<a id ="book-now-cta" class="book-now-cta" href="<?php echo get_the_permalink($onePackage->ID); ?>"><?php esc_html_e('Book Now', 'walkies') ?></a>
					</article>
				<?php };
				wp_reset_postdata(); ?> 
				</section> 
				<?php endif; ?>
			
		
		<section class="featured-faq-section">
			<h2><?php echo get_the_title(284); ?></h2>

			<?php
			if ( function_exists( 'get_field' ) ) :

				$featuredFAQ = get_field( 'featured_faqs' );			
				if( $featuredFAQ ) : 
					foreach( $featuredFAQ as $singleFAQ ) : ?> 
						<article> 
							<button class="accordion">
								<?php echo get_the_title( $singleFAQ->ID ); ?>
							</button>	
							<?php
							$faqFields = get_fields( $singleFAQ->ID );

							if( isset( $faqFields[ 'faq_answer' ] ) ): 
								?> <div class="panel"><?php
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
								echo "<h3>".get_the_title( $dogReview->ID)."</h3>";
								echo "<p>".$testimonialFields[ 'quote' ]."</p>";
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
