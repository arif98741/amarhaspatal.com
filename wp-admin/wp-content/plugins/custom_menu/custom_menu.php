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
    add_menu_page('linked_url', 'Appointment Report', 'read', '../appointment-report', '', 'dashicons-yes', 15);
    add_menu_page('linked_url', 'Ambulance Report', 'read', '../ambulance-report', '', 'dashicons-yes', 16);
    add_menu_page('linked_url', 'Prescription Report', 'read', '../prescription-report', '', 'dashicons-yes', 17);
    //add_menu_page('linked_url', 'Ambulance Booking', 'read', '../ambulence-booking', '', 'dashicons-share-alt2', 17);
    add_menu_page('linked_url', 'Add Other User', 'read', '../add-user', '', 'dashicons-pressthis', 10);

}

function linkedurl_function()
{
    global $menu;
    //$menu[1][2] = "http://www.example.com";
}

add_action('admin_menu', 'linkedurl_function');

