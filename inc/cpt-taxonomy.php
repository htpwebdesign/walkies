<?php
function gfw_register_custom_post_types() {

    // Walker Post Type
    $labels_walker = array(
        'name'               => _x( 'Walker', 'post type general name'  ),
        'singular_name'      => _x( 'Walker', 'post type singular name'  ),
        'menu_name'          => _x( 'Walker', 'admin menu'  ),
        'name_admin_bar'     => _x( 'Walker', 'add new on admin bar' ),
        'add_new'            => _x( 'Add New', 'walker' ),
        'add_new_item'       => __( 'Add New Walker' ),
        'new_item'           => __( 'New Walker' ),
        'edit_item'          => __( 'Edit Walker' ),
        'view_item'          => __( 'View Walker'  ),
        'all_items'          => __( 'All Walker' ),
        'search_items'       => __( 'Search Walker' ),
        'parent_item_colon'  => __( 'Parent Walker:' ),
        'not_found'          => __( 'No walker found.' ),
        'not_found_in_trash' => __( 'No walker found in Trash.' ),
    );
    
    $args_walker = array(
        'labels'             => $labels_walker,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'walker' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 10,
        'menu_icon'          => 'dashicons-universal-access-alt',
        'supports'           => array( 'title' ),
    );
    register_post_type( 'gfw-walker', $args_walker );

    // FAQ Post Type
    $labels_faq = array(
        'name'               => _x( 'FAQ', 'post type general name'  ),
        'singular_name'      => _x( 'FAQ', 'post type singular name'  ),
        'menu_name'          => _x( 'FAQ', 'admin menu'  ),
        'name_admin_bar'     => _x( 'FAQ', 'add new on admin bar' ),
        'add_new'            => _x( 'Add New', 'FAQ' ),
        'add_new_item'       => __( 'Add New FAQ' ),
        'new_item'           => __( 'New FAQ' ),
        'edit_item'          => __( 'Edit FAQ' ),
        'view_item'          => __( 'View FAQ'  ),
        'all_items'          => __( 'All FAQ' ),
        'search_items'       => __( 'Search FAQ' ),
        'parent_item_colon'  => __( 'Parent FAQ:' ),
        'not_found'          => __( 'No FAQ found.' ),
        'not_found_in_trash' => __( 'No FAQ found in Trash.' ),
    );
    
    $args_faq = array(
        'labels'             => $labels_faq,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'faq' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 10,
        'menu_icon'          => 'dashicons-format-chat',
        'supports'           => array( 'title' ),
    );
    register_post_type( 'gfw-faq', $args_faq );

    // Testimonial Post Type
    $labels_testimonial = array(
        'name'               => _x( 'Testimonials', 'post type general name'  ),
        'singular_name'      => _x( 'Testimonial', 'post type singular name'  ),
        'menu_name'          => _x( 'Testimonials', 'admin menu'  ),
        'name_admin_bar'     => _x( 'Testimonial', 'add new on admin bar' ),
        'add_new'            => _x( 'Add New', 'testimonial' ),
        'add_new_item'       => __( 'Add New Testimonial' ),
        'new_item'           => __( 'New Testimonial' ),
        'edit_item'          => __( 'Edit Testimonial' ),
        'view_item'          => __( 'View Testimonial'  ),
        'all_items'          => __( 'All Testimonials' ),
        'search_items'       => __( 'Search Testimonials' ),
        'parent_item_colon'  => __( 'Parent Testimonials:' ),
        'not_found'          => __( 'No testimonials found.' ),
        'not_found_in_trash' => __( 'No testimonials found in Trash.' ),
    );
    
    $args_testimonial = array(
        'labels'             => $labels_testimonial,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'label' => 'testimonial' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 7,
        'menu_icon'          => 'dashicons-heart',
        'supports'           => array( 'title' ),
    );
    register_post_type( 'gfw-testimonial', $args_testimonial ); 

}
add_action( 'init', 'gfw_register_custom_post_types' );


function gfw_register_taxonomies() {

    // FAQ Taxonomy
    $labels_faq = array(
        'name'              => _x( 'FAQ Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'FAQ Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search FAQ Categories' ),
        'all_items'         => __( 'All FAQ Category' ),
        'parent_item'       => __( 'Parent FAQ Category' ),
        'parent_item_colon' => __( 'Parent FAQ Category:' ),
        'edit_item'         => __( 'Edit FAQ Category' ),
        'view_item'         => __( 'View FAQ Category' ),
        'update_item'       => __( 'Update FAQ Category' ),
        'add_new_item'      => __( 'Add New FAQ Category' ),
        'new_item_name'     => __( 'New FAQ Category Name' ),
        'menu_name'         => __( 'FAQ Category' ),
    );
    $args_faq_category = array(
        'hierarchical'      => true,
        'labels'            => $labels_faq,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_nav_menu'  => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'faq-category' ),
    );
    register_taxonomy( 'gfw-faq-category', array( 'gfw-faq' ), $args_faq_category );

    // Testimonial Taxonomy
    $labels_testimonial_source = array(
        'name'              => _x( 'Testimonial Source', 'taxonomy general name' ),
        'singular_name'     => _x( 'Testimonial Source', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Testimonial Source' ),
        'all_items'         => __( 'All Testimonial Sources' ),
        'parent_item'       => __( 'Parent Testimonial Source' ),
        'parent_item_colon' => __( 'Parent Testimonial Source:' ),
        'edit_item'         => __( 'Edit Testimonial Source' ),
        'update_item'       => __( 'Update Testimonial Source' ),
        'add_new_item'      => __( 'Add New Testimonial Source' ),
        'new_item_name'     => __( 'New Testimonial Source Name' ),
        'menu_name'         => __( 'Testimonial Source' ),
    );

    $args_testimonial_source = array(
        'hierarchical'      => true,
        'labels'            => $labels_testimonial_source,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'testimonial-source' ),
    );
    register_taxonomy( 'gfw-featured', array( 'gfw-work' ), $args_testimonial_source );


}
add_action( 'init', 'gfw_register_taxonomies');

function gfw_rewrite_flush() {
    gfw_register_custom_post_types();
    gfw_register_taxonomies();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'gfw_rewrite_flush' );

?>