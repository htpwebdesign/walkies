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

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <header class="entry-header">
        <?php echo '<h1>' . esc_html( get_the_title() ) . '</h1>'; ?>
      </header><!-- .entry-header -->

      <div class="entry-content">
        
      </div><!-- .entry-content -->

    </article>
    
    <!-- #post-<?php the_ID(); ?> -->

	</main><!-- #main -->

<?php
get_footer();
