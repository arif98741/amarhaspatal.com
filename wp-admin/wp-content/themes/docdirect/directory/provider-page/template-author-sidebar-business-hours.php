<?php
/**
 *
 * Author Education Template.
 *
 * @package   Docdirect
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
/**
 * Get User Queried Object Data
 */
global $current_user;
$author_profile = $wp_query->get_queried_object();
$directory_type = $author_profile->directory_type;
$schedule_time_format = isset($author_profile->time_format) ? $author_profile->time_format : '12hour';
$privacy = docdirect_get_privacy_settings($author_profile->ID); //Privacy settings
$db_timezone = get_user_meta($author_profile->ID, 'default_timezone', true);
$time_zone = get_user_meta($author_profile->ID, 'default_timezone', true);
$slots = get_user_meta($author_profile->ID, 'default_slots')[0];


if (!empty($slots)) {


    $modified_slots = [];
    $week_array = docdirect_get_week_array();


    if (!empty($privacy['opening_hours'])
        &&
        $privacy['opening_hours'] == 'on'
    ) { ?>
        <div class="tg-userschedule">

            <ul>
                <?php
                $week_array = docdirect_get_week_array();

                $db_schedules = array();
                if (isset($author_profile->schedules) && !empty($author_profile->schedules)) {
                    $db_schedules = $author_profile->schedules;
                }

                if (isset($schedule_time_format) && $schedule_time_format === '24hour') {
                    $time_format = 'H:i';
                } else {
                    $time_format = get_option('time_format');
                    $time_format = !empty($time_format) ? $time_format : 'g:i A';
                }

                $date_prefix = date('D');


                if (isset($week_array) && !empty($week_array)) {
                    $array_keys = array_keys($week_array);
                    if (!empty($db_timezone)) {
                        $date = new DateTime("now", new DateTimeZone($db_timezone));
                        $current_time_date = $date->format('Y-m-d H:i:s');
                    } else {
                        $current_time_date = current_time('mysql');
                    }

                    //Current Day
                    $today_day = date('D', strtotime($current_time_date));
                    $today_day = strtolower($today_day);


                    foreach ($slots as $slot_key => $slot) {


                        if (!in_array($slot_key, $array_keys)) {
                            $active = '';
                            if ($today_day == $key) {
                                $active = 'current';
                            }

                            $day = str_replace('-details', '', $slot_key);


                            $opened_slots = $slots[$slot_key];
                            foreach ($opened_slots as $opened_slot_key => $opened_slot) {
//                               echo '<pre>';
//                               print_r($opened_slot_key); exit;
                                ?>



                            <?php }

                        } else {

                            $day = str_replace('-details', '', $slot_key);


                        }


                        ?>

                    <?php }
                } ?>
            </ul>
        </div>
    <?php }
} ?>