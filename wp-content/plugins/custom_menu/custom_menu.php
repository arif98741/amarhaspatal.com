<?php
/**
 * Plugin Name: Custom Menu
 * Plugin URI:  #
 * Description: This is custom menu for admin panel to access report
 * Author:      Ariful Islam
 * Author URI:  https://github.com/arif98741
 * Version:     1.0.0
 * Text Domain: Location Info
 * License:     GPLv2 or later (license.txt)
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

add_action('admin_menu', 'linked_url');
function linked_url()
{
    add_menu_page('linked_url', 'Appointment Report', 'read', '../appointment-report', '', 'dashicons-chart-bar', 15);
}

add_action('admin_menu', 'linkedurl_function');
function linkedurl_function()
{
    global $menu;
    $menu[1][2] = "http://www.example.com";
}

