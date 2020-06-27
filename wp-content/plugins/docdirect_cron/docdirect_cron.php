<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://themeforest.net/user/themographics/portfolio
 * @since             1.0
 * @package           Docdirect Cron
 *
 * @wordpress-plugin
 * Plugin Name:       Docdirect Cron
 * Plugin URI:        https://themeforest.net/user/themographics/portfolio
 * Description:       This plugin is used for creating cron jobs for Docdirect WordPress Theme
 * Version:           1.0
 * Author:            Themographics
 * Author URI:        https://themeforest.net/user/themographics
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       docdirect_cron
 * Domain Path:       /languages
 */

/**
 * Active plugin
 *
 * @throws error
 * @author Themographics <info@themographics.com>
 * @return 
 */
if( !function_exists('docdirect_cron_activation') ) {
	function docdirect_cron_activation() {	
		if ( ! wp_next_scheduled( 'docdirect_update_featured_expiry_listing' ) ) {
		  wp_schedule_event( time(), 'hourly', 'docdirect_update_featured_expiry_listing' );
		}
	}
	register_activation_hook (__FILE__, 'docdirect_cron_activation');
}

/**
 * Update expiry
 *
 * @throws error
 * @author Amentotech <info@themographics.com>
 * @return 
 */
if( !function_exists('docdirect_update_featured_expiry_listing') ) {
	function docdirect_update_featured_expiry_listing() {
		global $wpdb;
		$current_date 	= current_time('mysql');

		$table_user = $wpdb->prefix . 'users';
		$table_meta = $wpdb->prefix . 'usermeta';

		$user_data 		= $wpdb->get_results("SELECT $table_user.ID
							FROM $table_user INNER JOIN $table_meta
							ON $table_user.ID = $table_meta.user_id 
							WHERE $table_meta.meta_key = 'wp_capabilities' AND ( $table_meta.meta_value LIKE '%professional%' )
						  ");

		if( !empty( $user_data ) ){
			foreach( $user_data as $key => $user ){
				$subscription = docdirect_get_featured_date($user->ID);
				
				if( !empty( $subscription ) && $subscription > strtotime( $current_date ) ){
					update_user_meta($user->ID, 'user_featured', 1);
				} else{
					update_user_meta($user->ID, 'user_featured', 0);
				}
			}
		}
	}
	add_action( 'docdirect_update_featured_expiry_listing', 'docdirect_update_featured_expiry_listing' );
}

/**
 * Get Featured Date Expiry
 *
 * @throws error
 * @author Amentotech <info@themographics.com>
 * @return 
 */
if( !function_exists('docdirect_get_featured_date') ) {
	function docdirect_get_featured_date($user_id) {
		global $wpdb;
		if( apply_filters('docdirect_get_packages_setting','default') === 'custom' ){
			$date	= docdirect_get_subscription_meta('subscription_featured_expiry',$user_id);
			if(empty($date)){
				$date  = get_user_meta($user_id, 'user_featured_expiry', true);
				if(empty($date)){
					$date  = get_user_meta($user_id, 'user_featured', true);
				}
			}
		} else{
			$date  = get_user_meta($user_id, 'user_featured_expiry', true);
			if(empty($date)){
				$date  = get_user_meta($user_id, 'user_featured', true);
			}
		}
		
		return $date;
	}
}

/**
 * Deactive plugin
 *
 * @throws error
 * @author Amentotech <info@themographics.com>
 * @return 
 */
if( !function_exists('docdirect_cron_deactivate') ) {
	function docdirect_cron_deactivate() {	
		$timestamp = wp_next_scheduled ('docdirect_update_featured_expiry_listing');
		wp_unschedule_event ($timestamp, 'docdirect_update_featured_expiry_listing');
	} 
	register_deactivation_hook (__FILE__, 'docdirect_cron_deactivate');
}



/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
add_action( 'init', 'docdirect_cron_load_textdomain' );
function docdirect_cron_load_textdomain() {
  load_plugin_textdomain( 'docdirect_cron', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}