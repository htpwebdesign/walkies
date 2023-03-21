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
					echo '<h2>' . esc_html( the_field( 'featured_product_headline') ). '</h2>';
				}
				if ( get_field( 'featured_product_description' ) ) {
					echo '<p>'.get_field( 'featured_product_description' ).'</p>';
				}

				$primaryCTA = get_field( 'book_now_cta' );
				if( $primaryCTA ):
					?> 
				 	<a id ="book-now-cta" class="book-now-cta" href="<?php echo esc_url( $primaryCTA ); ?>">Book Now</a>
					<?php 
				endif; 	 

				$secondaryCTA = get_field( 'view_all_packages_cta' );
				if( $secondaryCTA ):
					?> 
				 	<a id ="view-all-packages-cta" class="view-all-packages-cta" href="<?php echo esc_url( $secondaryCTA ); ?>">View All Packages</a>
					<?php 
				endif; 	 	
			endif;
			?>
		</section>

		<section class="featured-faq-section">
			<h2>Frequently Asked Questions</h2>

			<?php
			if ( function_exists( 'get_field' ) ) :

				$featuredFAQ = get_field( 'featured_faqs' );
				if( $featuredFAQ ) : ?>
					<ul>
					<?php
					foreach( $featuredFAQ as $singleFAQ ) :
						$faqFields = get_fields( $singleFAQ->ID );
						if( isset( $faqFields[ 'faq_answer' ] ) ): ?>
							<li>
								<?php 
								echo wp_get_attachment_image( $faqFields[ 'faq_answer' ] ); 
								echo get_the_title( $singleFAQ->ID ); 
								?>
								<p> <?php echo $faqFields[ 'faq_answer' ]; ?></p>
							</li>	
							<?php
						endif;	
					endforeach;
					?>	
					</ul>
					<?php
				endif;

				$faqCTA = get_field( 'read_more_faq_cta' );
				if( $faqCTA ):
					?> 
				 	<a id ="read-more-faq-cta" class="read-more-faq-cta" href="<?php echo esc_url( $faqCTA ); ?>">Read More FAQs</a>
					<?php 
				endif; 	 

			endif; ?>	
		</section>
		
		<section class="featured_dog_testimonial">
			<h2>Hear Our Pup's Paw-sitive Reviews!</h2>
			
			<?php
			if ( function_exists( 'get_field' ) ) :
				
				$featuredDogReviews = get_field( 'featured_dog_testimonials' );
				if( $featuredDogReviews) : ?>
					<?php
					foreach( $featuredDogReviews as $dogReview ) :
						$testimonialFields = get_fields( $dogReview->ID );
						if( isset( $testimonialFields[ 'customer_photo' ], $testimonialFields[ 'dog_audio' ] ) ): ?>
							<article>
								<?php 
								echo wp_get_attachment_url( $testimonialFields[ 'dog_audio' ] ); 
								?>
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
	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
