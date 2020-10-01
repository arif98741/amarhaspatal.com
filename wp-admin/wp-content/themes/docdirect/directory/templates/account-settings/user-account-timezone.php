<?php
/**
 * User Profile Main
 * return html
 */

global $current_user, $wp_roles,$userdata,$post;
$user_identity  = $current_user->ID;
$timezones  = apply_filters('docdirect_time_zones', array());
$time_zone	= get_user_meta($user_identity, 'default_timezone', true);
?>
<div class="tg-bordertop tg-haslayout">

</div>