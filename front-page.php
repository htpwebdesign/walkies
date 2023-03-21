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
			if ( function_exists( 'get_field' ) ) {

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
			}
			?>
		</section>

		<section class="featured_testimonial_section">
			<h2>Testimonials</h2>
			<?php
			if ( function_exists( 'get_field' ) ) :
				$featuredTestimonials = get_field( 'featured_testimonials' );
				if( $featuredTestimonials ) : ?>
					<ul>
						<?php
						foreach( $featuredTestimonials as $testimonial ) :
							$testimonialFields = get_fields( $testimonial->ID );
							if( isset( $testimonialFields[ 'customer_photo' ], $testimonialFields[ 'quote' ] ) ): ?>
								<article>
									<?php 
									echo wp_get_attachment_image( $testimonialFields[ 'customer_photo' ], 'thumbnail-icon' ); 
									echo get_the_title( $testimonial->ID ); 
									?>
									<p> <?php echo $testimonialFields[ 'quote' ]; ?></p>
								</article>	
								<?php
							endif;	

						endforeach;
						?>
					</ul>
					<?php
				endif;
			endif;
			?>
		</section>

		

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();