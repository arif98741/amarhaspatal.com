<?php
/**
 * User Profile Main
 * return html
 */

global $current_user, $wp_roles,$userdata,$post;
$user_identity  = $current_user->ID;
$languages_array	= docdirect_prepare_languages();//Get Language Array
$db_languages   	= get_user_meta( $user_identity, 'languages', true);

if( apply_filters('docdirect_do_check_user_type',$user_identity ) === true ){?>
<div class="tg-bordertop tg-haslayout">

</div>
<?php }?>