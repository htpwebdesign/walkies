<?php
function gfw_register_custom_post_types() {

    // Walkers Post Type
    // Walker Post Type
    $labels = array(
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
        'labels'             => $labels,
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

}
add_action( 'init', 'gfw_register_custom_post_types' );

?>