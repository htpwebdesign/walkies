<?php
/**
 * Template part for displaying Social Media Links
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Walkies
 */

?>

<?php 
if(function_exists('get_field')){
	if(have_rows('social_media', 'option')){
		?><nav class="social-icons"><?php
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
}
	?></nav><?php
	