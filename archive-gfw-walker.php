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
					if(get_field('walker_photo')):
						?>
						<img src="<?php the_field('walker_photo'); ?>" alt="<?php the_title()?>" class="walker-photo">
						<?php
					endif;
					?>

					<h2>
						<a href="<?php the_permalink()?>"><?php the_title();?></a>
					</h2>
				
					<?php
					if(get_field('city')):
						?>
						<p><?php esc_html_e('Location: ', 'walkies').the_field('city')?></p>
						<?php
					endif;
				endif;
				?>

			</article>

	<?php 
		endwhile;
	endif;
endif; 
?>
	</main><!-- #main -->

<?php
get_footer();
