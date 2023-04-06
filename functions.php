<?php
/**
 * Walkies functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Walkies
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function walkies_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Walkies, use a find and replace
		* to change 'walkies' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'walkies', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'walkies' ),
			'header-left' => esc_html__( 'CTA Header', 'walkies' ),
			'header-right' => esc_html__( 'Icons Menu', 'walkies' ),
			'footer-menu' => esc_html__( 'Footer Menu', 'walkies' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'walkies_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

  // Custom Image Crops
  add_image_size( 'thumbnail-icon', 100, 100, true );
}
add_action( 'after_setup_theme', 'walkies_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function walkies_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'walkies_content_width', 640 );
}
add_action( 'after_setup_theme', 'walkies_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function walkies_scripts() {
	// Custom fonts
	wp_enqueue_style(
		'walkies-googlefonts',
		'https://fonts.googleapis.com/css2?family=Kavoon&family=Prompt:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap',
		array(),
		null);
	wp_enqueue_style( 'walkies-style', get_stylesheet_uri(), array(), _S_VERSION );

	wp_style_add_data( 'walkies-style', 'rtl', 'replace' );

	wp_enqueue_style('dashicons');
	
	wp_enqueue_script( 'walkies-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	// Enqueue accordion script for click event listener
	wp_enqueue_script( 'walkies-accordion', get_template_directory_uri() . '/js/accordion.js', array(), _S_VERSION, true );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	
	if('gfw-walker' === get_post_type()){
		
		// Load script from ACF Map Documentation
		wp_enqueue_script( 'google_js', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyDdcgV7xSlibF71okf0mzwkhfuH756GBOw&callback=Function.prototype', '', '' );

		// Map Helper Set up
		wp_enqueue_script( 'map-helper', get_template_directory_uri() . '/js/map.js', array('jquery'), _S_VERSION, true );
		
	}
	
}
add_action( 'wp_enqueue_scripts', 'walkies_scripts' );

/**
 * Register Google Maps API.
 *
 * @link https://www.advancedcustomfields.com/resources/google-map/#requirements
 */
function my_acf_init() {
    acf_update_setting('google_api_key', 'AIzaSyDdcgV7xSlibF71okf0mzwkhfuH756GBOw');
}
add_action('acf/init', 'my_acf_init');

/**
 * Dashboard Widgets
 */
function gfw_dashboard_widget() {
  esc_html_e( "Hello World, this is my first Dashboard Widget!", "textdomain" );
  echo '<iframe width="100%" height="315" src="https://www.youtube.com/embed/C2SaWYOOG3w"></iframe>';
}

function gftw_remove_dashboard_widget() {
  // Globalize the metaboxes array, this holds all the widgets for wp-admin.
  global $wp_meta_boxes;
  wp_add_dashboard_widget('dashboard_widget', 'Tutorial Video', 'gfw_dashboard_widget');

	remove_meta_box( 'wc_admin_dashboard_setup', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
	remove_meta_box( 'rg_forms_dashboard', 'dashboard', 'normal' );
	remove_meta_box( 'cn_dashboard_stats', 'dashboard', 'normal' );
	remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal' );

	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
} 

add_action( 'wp_dashboard_setup', 'gftw_remove_dashboard_widget' );

 /**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
* Custom Post Types & Taxonomies
*/
require get_template_directory() . '/inc/cpt-taxonomy.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

// Source https://github.com/AdvancedCustomFields/acf/issues/112
add_action('admin_init', function () {
    if (array_key_exists('post', $_GET) || array_key_exists('post_ID', $_GET)) {
        $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
        if (!isset($post_id)) {
            return;
        }
        $title = get_the_title($post_id);
        
        if ($title == 'Home' || $title == 'About the Company' || $title == 'Book Walkies') {
            remove_post_type_support('page', 'editor');
        }
    }
}, 10);

// Create an ACF Option Page for Contact
function gfw_contact_page_acf() {
	if( function_exists('acf_add_options_page') ) {
		$option_page = acf_add_options_page(array(
			'page_title' 	=> __('Contact Form Settings'),
			'menu_title' 	=> __('Contact Settings'),
			'menu_slug'		=> 'contact-form-settings',
			'icon_url'		=> 'dashicons-email',
			'position'		=> '7'
		));    
	}
}
add_action('acf/init', 'gfw_contact_page_acf');

// Search Bar
function custom_search_form( $form ) {
  $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
    <div class="custom-form"><label class="screen-reader-text" for="s">' . __( 'Search:' ) . '</label>
      <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'. esc_attr__( 'Search' ) .'"  />
      <button class="dashicons dashicons-search" type="submit"></button>
    </div>
  </form>';

  return $form;
}
add_filter( 'get_search_form', 'custom_search_form', 40 );

// Hide Archive Prefix
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

//Prevents WP from grabbing the thumbnail size on single product page 
function gfw_change_shop_img_size() {
	return 'full';
}
add_filter( 'woocommerce_gallery_image_size', 'gfw_change_shop_img_size' );
add_filter( 'woocommerce_gallery_full_size', 'gfw_change_shop_img_size' );

// Custom WP Login
function gfw_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/wp-login.css' );
}
add_action( 'login_enqueue_scripts', 'gfw_login_stylesheet' );

function gfw_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'gfw_login_logo_url' );

function gfw_login_logo_url_title() {
    return 'Go for Walkies';
}
add_filter( 'login_headertext', 'gfw_login_logo_url_title' );
