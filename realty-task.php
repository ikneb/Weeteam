<?php
/*
Plugin Name: Realty Task Plugin
Plugin URI: http://test.ua
Description: Task plugin.
Version: 1.0
Author: Eduard
*/


add_action('init', 'property_index');
add_action('init', 'district_tag_for_property');

/*
 * Create taxonomy for type post property
 */
function district_tag_for_property()
{

        $labels = array(
            'name'              => _x( 'Districts', 'districts general name', 'districts' ),
            'singular_name'     => _x( 'District', 'districts singular name', 'districts' ),
            'search_items'      => __( 'Search District', 'districts' ),
            'all_items'         => __( 'All District', 'districts' ),
            'parent_item'       => __( 'Parent District', 'districts' ),
            'parent_item_colon' => __( 'Parent District:', 'districts' ),
            'edit_item'         => __( 'Edit District', 'districts' ),
            'update_item'       => __( 'Update District', 'districts' ),
            'add_new_item'      => __( 'Add New District', 'districts' ),
            'new_item_name'     => __( 'New District Name', 'districts' ),
            'menu_name'         => __( 'District', 'districts' ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'district' ),
        );
        register_taxonomy('district', 'property', $args);

}


/*
 * Create new type post property
 */
function property_index()
{
    register_post_type('property', array(
        'public' => true,
        'supports' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-admin-home',
        'labels' => array(
            'name' => 'Property',
            'all_items' => 'All property',
            'add_new' => 'New property',
            'add_new_item' => 'Add property',

        )
    ));
}


add_filter( 'page_template', 'property_page_template' );
function property_page_template( $page_template )
{
    if ( is_page( 'Home' ) ) {
        $page_template = dirname( __FILE__ ) . '/page-property.php';
    }
    return $page_template;
}

