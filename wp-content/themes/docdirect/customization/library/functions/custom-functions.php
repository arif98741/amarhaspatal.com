<?php
/**
 * Unserialized data
 */
function unserializeData($data)
{
    return unserialize($data);
}

/**
 * Counter user
 * @param $directoryType
 * @return int
 */
function countUser($directoryType)
{
    $query_args = array(
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'directory_type',
                'value' => $directoryType,
                'compare' => '='
            )
        )
    );
    $user_query = new WP_User_Query($query_args);
    return count($user_query->get_results());
}


/**
 * Count Number of Ambulance Booking
 * @return int
 */
function countNumberofAmbulanceBooking()
{
    global $wpdb;
    $results = $wpdb->get_results('select * from ambulance_booking');
    if (!empty($results)) {
        return count($results);
    } else {
        return 0;
    }
}

function register_custom_pharmacy_slider() {
    $labels = array(
        'name'               => _x( 'Pharmacy Slider', 'post type general name' ),
        'singular_name'      => _x( 'Pharmacy Slider', 'post type singular name' ),
        'add_new'            => _x( 'Add New', 'agent information' ),
        'add_new_item'       => __( 'Add New' ),
        'edit_item'          => __( 'Edit Pharmacy Slider' ),
        'new_item'           => __( 'New Pharmacy Slider' ),
        'all_items'          => __( 'Pages' ),
        'view_item'          => __( 'View Slide' ),
        'search_items'       => __( 'Search Slide' ),
        'not_found'          => __( 'No Slide information found' ),
        'not_found_in_trash' => __( 'No Slide information found in Trash' ),
        'parent_item_colon'  => '',
        'menu_name'          => __( 'Pharmacy Slider' )
    );
    $args   = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-admin-post',
        'query_var'          => true,
        'rewrite'            => true,
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 4,
        'supports'           => array( 'title', 'editor', 'thumbnail' )
    );
    register_post_type( 'pharmacy-slider', $args );
}

add_action( 'init', 'register_custom_pharmacy_slider' );
