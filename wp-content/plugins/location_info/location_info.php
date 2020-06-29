<?php
/**
 * Plugin Name: Location Info
 * Plugin URI:  https://test.com
 * Description: bbPress is forum software with a twist from the creators of WordPress.
 * Author:      The bbPress Contributors
 * Author URI:  https://bbpress.org
 * Version:     2.6.4
 * Text Domain: Location Info
 * Domain Path: /languages/
 * License:     GPLv2 or later (license.txt)
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

require dirname(__FILE__) . '/LocationClass.php';

function custom_post_division()
{
    $labels = array(
        'name' => __('Location'),
        'singular_name' => __('Division'),
        'add_new_item' => __('Add New  Division'),
        'edit_item' => __('Edit  Division'),
        'new_item' => __('New  Division'),
        'view_item' => __('View  Division'),
        'search_items' => __('Search  Divisions'),
        'not_found' => __('No Division Found'),
        'not_found_in_trash' => __('No Division found in Trash'),
    );
    LocationClass::registerPostType($labels);
}

add_action('init', 'custom_post_division');
/*
    global $wpdb;
    $data = $wpdb->get_results("select * from wp_users");
    echo '<pre>';
    print_r($data);
    exit;
*/


