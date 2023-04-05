<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Walkies
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found">
			<img src="https://img.icons8.com/external-vitaliy-gorbachev-flat-vitaly-gorbachev/256/external-dog-space-vitaliy-gorbachev-flat-vitaly-gorbachev.png" alt="Dog graphic by Vitaliy Gorbachev from icons8.com">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'walkies' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links above or a search?', 'walkies' ); ?></p>

					<?php
					get_search_form();
					?>

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
