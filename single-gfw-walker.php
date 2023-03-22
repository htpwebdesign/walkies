<?php
/**
 * The template for displaying single walker page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Walkies
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post(); ?>

			<section class="walker-info">

			<h1><?php the_title();?></h1>

			<?php
			if(function_exists('get_field')):

				if(get_field('walker_photo')):
					echo wp_get_attachment_image( get_field('walker_photo'), 'medium' );
				endif;

				if(get_field('city')):
					?>
					<p><span><?php esc_html_e('Location: ', 'walkies'); ?></span><?php the_field('city')?></p>
					<?php
				endif;

				if(get_field('walker_bio')):
					?>
					<?php the_field('walker_bio')?>
					<?php
				endif;
				?></section><?php

				if(get_field('walker_testimonial') || get_field('dog_testimonial')){
					?> <section class="testimonial"> <?php
					
					$walkerTesti = get_field('walker_testimonial');

					if($walkerTesti){
						foreach($walkerTesti as $oneTesti){
							$id = get_fields($oneTesti->ID);

							if( isset( $id['customer_photo'], $id['quote'] ) ):
							?>
								<article class="walker-testi">
									<?php echo wp_get_attachment_image($id['customer_photo'], 'medium'); ?>
									<h3><?php echo get_the_title($oneTesti->ID) ?></h3>
									<p><?php echo $id['quote'] ; ?></p>
								</article>	

							<?php 
							endif;
						};
					};
					
					$dogTesti = get_field('dog_testimonial');

					if($dogTesti){
						foreach($dogTesti as $oneTesti){
							$id = get_fields($oneTesti->ID);

							if( isset( $id['customer_photo'], $id['quote'] ) ):
							?>
								<article class="dog-testi">
									<?php echo wp_get_attachment_image($id['customer_photo'], 'medium', $id['dog_audio']); 
									?>
									<audio controls>
										<source src="<?php echo $id['dog_audio'] ?>" type="audio/mp3">
										Your browser does not support the audio element.
									</audio>
									<h3><?php echo get_the_title($oneTesti->ID) ?></h3>
									<p><?php echo $id['quote'] ; ?></p>
								</article>	

							<?php 
							endif;
						};
					};
					?> </section> <?php
				};
				
				?>
				<section class="walker-map">
					<div>
					<h2><?php esc_html_e("Walker Service Area", 'walkies') ?></h2>
					</div>
				<?php
				// DOM Set up to get latitude and longitude values
				$location = get_field('location');

				$latVal = $location['lat'];
				$lngVal = $location['lng'];
		
				if( $location ): 
          echo "<div id='circle-map'></div>";
          echo "<span class='mapMark' id='map-lat'>" . $latVal . "</span>";
          echo "<span class='mapMark' id='map-lng'>" . $lngVal . "</span>";
				endif;
				?></section><?php
				$link = get_field('single_walker_cta'); 
				if($link){
					$link_url = $link['url'];
					$link_title = $link['title'];
					$link_target = $link['target'] ? $link['target'] : '_self';
					?>
					<a class="button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a><?php
				} else {
					?>
					<a class="button" href="<?php the_permalink(91) ; ?>" ><?php echo esc_html_e('Book Walkies', 'walkies'  ); ?></a><?php
				}

			endif;
			
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous Walker:', 'walkies' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next Walker:', 'walkies' ) . '</span> <span class="nav-title">%title</span>',
				)
			);

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
