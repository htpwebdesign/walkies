<?php
function gfw_register_custom_post_types() {

    // FAQ Post Type
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

}
add_action( 'init', 'gfw_register_custom_post_types' );


function gfw_register_taxonomies() {

    // FAQ Post Type
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
}
add_action( 'init', 'gfw_register_taxonomies');

function gfw_rewrite_flush() {
    gfw_register_custom_post_types();
    gfw_register_taxonomies();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'gfw_rewrite_flush' );

?>