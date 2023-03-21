<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Walkies
 */

?>

	<footer id="colophon" class="site-footer">
		<section="footer-cta">
			<div class="footer-cta-details">
			<?php
			if(function_exists('get_field')){
				if(get_field('contact_subtitle', 'option')): ?>
					<p id="subtitle"><?php the_field('contact_subtitle', 'option'); ?></p>
				<?php endif;
				if(get_field('contact_heading', 'option')): ?>
					<h2><?php the_field('contact_heading', 'option'); ?></h2>
				<?php endif; ?>
				<section class="contact-info">
				<?php if(have_rows('contact_details', 'option')): the_row();
				
					$group = get_field('contact_details', 'option');
					?> <h3><?php the_sub_field('heading'); ?></h3><?php

					// print_r($group['social_media']);

					$socials = $group['social_media'];
					if(have_rows('social_media', 'option')){
						while(have_rows('social_media', 'option')): the_row(); 
						$link = get_sub_field('social_media_link');

						$link_url = $link['url'];
						$link_title = $link['title'];
						$link_target = $link['target'] ? $link['target'] : '_self';
						?>
						
						<a href="<?php echo $link_url; ?>" target="<?php echo $link_target; ?>">
						<figure>
							<img src="<?php the_sub_field('social_media_icon'); ?>" alt="<?php echo $link_title;?>" class="social-icons">
							<figcaption><?php echo $link_title;?></caption>
						</figure>
						</a>
						<?php endwhile;
					}
					endif; ?>
					</div>
					<div class="footer-cta-form">
						<?php echo do_shortcode('[gravityform id="1" title="false"]') ?>
					</div>
				</section>
<?php
			}
			?>
		</section>
		<section class="footer-section">
			<div class="site-info">
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'walkies' ) ); ?>">
					<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'walkies' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
			<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'walkies' ), 'walkies', '<a href="http://underscores.me/">FWD 32</a>' );
				?>
		</div><!-- .site-info -->
		</section>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
