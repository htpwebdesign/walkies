<?php
/**
 * The template for displaying Walkers Archive page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Walkies
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<div class="walkers-wrapper">
				<?php
				$args = array(
					'post_type'			=> 'gfw-walker',
					'posts_per_page'	=> -1,
				);			

				$query = new WP_QUERY($args);
				if($query -> have_posts()):
				while($query->have_posts()) :
					$query->the_post();
				?>

				<article class="walker-card">
					<?php
					if (function_exists('get_field')):
						?> <a href="<?php the_permalink()?>"><?php
						if(get_field('walker_photo')):
							echo wp_get_attachment_image( get_field('walker_photo'), 'medium' );
						endif;
						?>

						<h2>
							<?php the_title();?>
						</h2>
					
						<?php
						if(get_field('city')):
							?>
							<p><span><?php esc_html_e('Location: ', 'walkies'); ?></span><?php the_field('city')?></p>
							<?php
						endif;
						?> </a> <?php
					endif;
					?>
				</article>
		<?php 
			endwhile;
		endif;
	endif; 
	?>
	</div>
	</main><!-- #main -->

<?php
get_footer();
