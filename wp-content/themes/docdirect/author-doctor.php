<?php /** @noinspection MultiAssignmentUsageInspection */
/**
 * The template for displaying user detail
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Doctor Directory
 */
global $wp_query, $current_user;
$author_profile = $wp_query->get_queried_object();

$userMeta = get_user_meta($author_profile->ID);

$name = $userMeta['first_name'][0] . ' ' . $userMeta['last_name'][0];
$address = $userMeta['user_address'][0];
$tagline = $userMeta['tagline'][0];
$phone = $userMeta['phone_number'][0];
$address = $userMeta['user_address'][0];
$old_patient_charge = $userMeta['old_patient_charge'][0];
$new_patient_charge = $userMeta['new_patient_charge'][0];

$bmdc_registration_no = (isset($userMeta['bmdc_registration_no'][0])) ? $userMeta['bmdc_registration_no'][0] : '';

$specialities = (isset($userMeta['user_profile_specialities'][0])) ? unserializeData($userMeta['user_profile_specialities'][0]) : '';
$schedules = (isset($userMeta['schedules'][0])) ? unserialize($userMeta['schedules'][0]) : '';
$avatar = apply_filters(
    'docdirect_get_user_avatar_filter',
    docdirect_get_user_avatar(array('width' => 270, 'height' => 270), $author_profile->ID),
    array('width' => 270, 'height' => 270) //size width,height
);

do_action('docdirect_update_profile_hits', $author_profile->ID); //Update Profile Hits
docdirect_set_user_views($author_profile->ID); //Update profile views
get_header();//Include Headers

$directory_type = $author_profile->directory_type;
$schedule_time_format = isset($author_profile->time_format) ? $author_profile->time_format : '12hour';
$privacy = docdirect_get_privacy_settings($author_profile->ID); //Privacy settings
$db_timezone = get_user_meta($author_profile->ID, 'default_timezone', true);
$time_zone = get_user_meta($author_profile->ID, 'default_timezone', true);

$slots = get_user_meta($author_profile->ID, 'default_slots')[0];

$days = [
    'sat', 'sun', 'mon',
    'tue', 'wed', 'thu',
    'fri'
];


$newArray = [];
foreach ($slots as $key => $slot) {
    if (in_array($key, $days, true)) {
        unset($slots[$key]);
    } else {
        $newArray = $slot;
    }

}
//
//echo '<pre>';
//print_r($slots);
//echo '</pre>';
//exit;

if (apply_filters('docdirect_get_user_type', $author_profile->ID) === true && function_exists('fw_get_db_settings_option')) {
    if (apply_filters('docdirect_is_visitor', $author_profile->ID) === false) {
        $directory_type = $author_profile->directory_type;


        $uni_flag = rand(1, 9999);
        $privacy = docdirect_get_privacy_settings($author_profile->ID); //Privacy settings

        if (function_exists('fw_get_db_post_option')) {
            $show_free_users = fw_get_db_settings_option('show_free_users');
        }

        docdirect_enque_map_library();//init Map
        docdirect_enque_rating_library();//rating


        $apointmentClass = 'appointment-disabled';
        if (!empty($privacy['appointments'])
            &&
            $privacy['appointments'] == 'on'
        ) {
            $apointmentClass = 'appointment-enabled';
            if (function_exists('docdirect_init_stripe_script')) {
                //Strip Init
                docdirect_init_stripe_script();
            }

            if (isset($current_user->ID)
                &&
                $current_user->ID != $author_profile->ID
            ) {
                $apointmentClass = 'appointment-enabled';
            } else {
                $apointmentClass = 'appointment-disabled';
            }
        }

        docdirect_init_dir_map();//init Map
        docdirect_enque_map_library();//init Map


        $is_profile_visible = 'yes';
        if (apply_filters('docdirect_get_packages_setting', 'default') === 'custom') {
            if (isset($show_free_users) && $show_free_users === 'show') {
                $is_profile_visible = 'yes';
            } else {
                $package_expiry = get_user_meta($author_profile->ID, 'user_current_package_expiry', true);
                $current_package = get_user_meta($author_profile->ID, 'user_current_package', true);
                $current_date = date('Y-m-d H:i:s');
                if (!empty($package_expiry) && $package_expiry > strtotime($current_date)) {
                    $is_profile_visible = 'yes';
                } else {
                    $is_profile_visible = 'no';
                }
            }
        }

        $display_settings = docdirect_profile_display_settings();
        $display_settings = apply_filters('docdirect_filter_profile_display_settings', $display_settings);

        if (isset($is_profile_visible) && $is_profile_visible === 'yes') { ?>


            <!-- Mostafiz -->
            <div style="border: 0px solid red;" class="main-content container-fluid mslc">
                <!-- <h1>Mostafizur</h1> -->

                <main id="main" class="site-main" role="main">
                    <div class="fusion-builder-row fusion-row row"
                         style="border-bottom: 1px solid #f3f3f3; margin-bottom: 25px;">
                        <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_3 fusion-one-third fusion-column-first 1_3 col-sm-6"
                             style="margin-top: 5px; margin-bottom: 0px; width: 30.6666%; margin-right: 4%;">
                            <div
                                    class="fusion-column-wrapper"
                                    style="background-position: left top; background-repeat: no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"
                                    data-bg-url=""
                            >
                                <div class="imageframe-align-center" style="overflow: hidden; height: 236px;">
                    <span
                            style="border: 0px solid rgb(246, 246, 246); border-radius: 50%; box-shadow: rgba(0, 0, 0, 0.298039) 0px 0px 3px; visibility: visible; animation-duration: 0.9s;"
                            class="fusion-imageframe imageframe-glow imageframe-1 hover-type-zoomin fusion-animated fusion-no-small-visibility"
                            data-animationtype="slideInLeft"
                            data-animationduration="0.9"
                            data-animationoffset="100%"
                    >


                         <?php if (empty($avatar)): ?>

                             <img class="img-responsive"
                                  src="<?php echo site_url(); ?>/wp-content/uploads/doctor/doctor_default.jpg"
                                  alt="<?= $name . ' - ' . site_url(); ?>"
                                  style="height: 300px; border-radius: 100%; width: 320px; margin: 0 auto; border: 2px solid #eee !important; padding: 5px"
                                  title="<?php echo $name ?> - <?php echo site_url(); ?>"/>
                         <?php else: ?>

                             <img class="img-responsive" src="<?= $avatar ?>"
                                  alt="<?= $name . ' - ' . site_url(); ?>"
                                  style="height: 300px; border-radius: 100%; width: 320px; margin: 0 auto; border: 2px solid #eee !important; padding: 5px"
                                  title="<?php echo $name ?> - <?php echo site_url(); ?>"/>
                         <?php endif; ?>
                    </span>
                                </div>
                                <div class="fusion-clearfix"></div>
                            </div>
                        </div>
                        <div class="fusion-layout-column fusion_builder_column fusion_builder_column_2_3 fusion-two-third fusion-column-last 2_3 col-sm-6"
                             style="margin-top: 5px; margin-bottom: 0px; width: 65.3333%; padding-right: 30px;">
                            <div
                                    class="fusion-column-wrapper"
                                    style="background-position: left top; background-repeat: no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"
                                    data-bg-url="">
                                <div style="padding-top: 3%; float: right;">
                                    <h3 style="font-weight: bold; font-family: Georgia; text-transform: uppercase; font-size: 32px; text-align: right; margin: 0;"
                                        data-fontsize="26" data-lineheight="39">
                                        <span style="color: #076b9c; text-shadow: -1px -1px 2px;"><strong><?php echo $name; ?></strong></span>
                                    </h3>
                                    <div style="text-align: right; margin: 0; border: 0px solid red;" data-fontsize="18"
                                         data-lineheight="30">
                                        <span style="color: #5e5357; font-size: 18px;"><?php echo $tagline; ?></span><br/>
                                        <strong><span style="color: #253e7f;1">Nephrologist</span></strong><br/>
                                        <span style="color: #5e5357;">
                            Assistant Professor of Nephrology Department <br/>
                            NATIONAL INSTITUTE OF KIDNEY DISEASE, DHAKA
                        </span>
                                        <br/>
                                        <p>BMDC Registration No:
                                            <span><strong><?php echo $bmdc_registration_no; ?></strong></span></p>
                                        <button class="tg-btn-lg make-appointment-btn"
                                                <?php if (!is_user_logged_in()): ?>data-toggle="modal"
                                                data-target="#login-modal-front" <?php endif; ?> type="button"
                                                data-toggle="modal" data-target=".tg-appointmentpopup"
                                                title="<?php if (is_user_logged_in() == false): ?> Please login first to make appointment <?php endif; ?>">
                                            Make an Appointment!
                                        </button>
                                    </div>
                                </div>
                                <div class="fusion-clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <style>
                        #second-row {
                            display: flex;
                        }

                        .form {
                            flex: 1;
                            background: white;
                            color: black;
                            border: 1px solid #f2dedf;
                            padding: 0px;
                            border-radius: 5px;
                        }

                        .info {
                            flex: 1.8;
                        }

                        .chamber {
                            flex: 1.2;
                        }

                    </style>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info"
                                 style="background: white; color: black; border: 1px solid #f2dedf; padding: 0px; margin: 0px 15px; border-radius: 5px;">
                                <div class="page-header bg-primary"
                                     style="background: #253e7f; text-align: center; margin-top: 0px; padding: 0px;">
                                    <h3 style="color: white; margin-top: 0px; padding-top: 10px; text-transform: uppercase; font-size: 16px;">
                                        Info</h3>
                                </div>
                                <div class="">
                                    <?php

                                    if (array_key_exists('experience', $userMeta)) {
                                        $experiences = unserializeData($userMeta['experience'][0]);

                                        ?>
                                        <?php foreach ($experiences as $experience) { ?>

                                            <p style="text-align: center;">
                                                <?php echo $experience['title']; ?><br/>
                                                <?php echo strtoupper($experience['company']); ?>
                                            </p>


                                            <hr/>
                                        <?php } ?>
                                    <?php }; ?>


                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="chamber"
                                 style="background: #f0f1f3; color: black; border: 1px solid #f2dedf; padding: 0px; border-radius: 5px;">
                                <div class="page-header bg-primary"
                                     style="background: #253e7f; text-align: center; margin-top: 0px; padding: 0px; margin-bottom: 0px;">
                                    <h3 style="color: white; margin-top: 0px; padding-top: 10px; text-transform: uppercase; font-size: 16px;">
                                        Chamber and Schedule</h3>
                                </div>
                                <style>
                                    .collapse hr {
                                        margin: 0px;
                                        border-top: 1px solid #ccc;
                                    }

                                    a.hospital-title-button {
                                        background: #6b6b6b;
                                        font-family: Agency FB, serif;
                                        font-size: 20px;
                                        font-weight: bold;
                                        color: white !important;
                                        border: 0px;
                                        width: 100%;
                                        padding: 10px 0px;
                                        border-bottom: 1px solid #e5e5e5;
                                        line-height: inherit;
                                        border-radius: 0 !important;
                                    }

                                    a.hospital-title-button:hover,
                                    a.hospital-title-button:visited,
                                    a.hospital-title-button:active,
                                    a.hospital-title-button:focus {
                                        color: white !important;
                                    }

                                    .blink {
                                        animation: blinker 3000ms linear infinite;
                                    }

                                    @keyframes blinker {
                                        10% {
                                            color: #6b6b6b;
                                        }
                                        70% {
                                            color: white;
                                        }
                                    }
                                </style>

                                <?php
                                global $current_user, $wp_roles, $userdata, $post;
                                $user_identity = $author_profile->ID;
                                $week_days = docdirect_get_week_array();
                                $default_slots = get_user_meta($author_profile->ID, 'default_slots', true);
                                foreach ($default_slots as $weekKey => $default_slot) {
                                    if (array_key_exists($weekKey, $week_days)) {
                                        continue;
                                    } else {
                                        $newArray = [
                                            'day' => $weekKey,
                                            'slots' => $default_slot
                                        ];
                                        $data[] = $newArray;
                                    }
                                }

                                $collapseInc = 0;
                                foreach ($data as $key => $array) {
                                $random = rand(111111,999999);
                                ?>

                                <button class="btn btn-block hospital-title-button collapsed"
                                        style="background: #153F7F; color: #fff;" data-toggle="collapse"
                                        data-target="#chamber<?php echo $random; ?>" style=""
                                        aria-expanded="false">
                                    <span style="text-transform: uppercase"> <?php echo $week_days[str_replace('-details', '', $array['day'])]; ?></span>
                                </button>
                                <div id="chamber<?php echo $random; ?>" class="collapse <?php if($collapseInc == 0): ?>in <?php endif; ?>"
                                     style="padding: 0px 5px;"
                                     aria-expanded="false">

                                    <?php $i = 0;
                                    foreach ($array['slots'] as $slotKey => $slotValue) {

                                        $slotExplodes = explode('-', $slotKey);
                                        $chamberTitleExplode = explode('|', $slotValue['slot_title_chamber']);
                                        $chamberTitle = $chamberTitleExplode[0];
                                        $newPatient = $chamberTitleExplode[2];
                                        $oldPatient = $chamberTitleExplode[3];
                                        $chamberTitle = $chamberTitleExplode[0];

                                        ?>
                                        <p>
                                                <?php echo ($i == 0) ? 'Chamber: <strong>' . ucwords($chamberTitle) : '</strong>'; ?>
                                            <br>
                                                New Patient: <?php echo ' <strong>' . $newPatient.'</strong>'; ?>TK
                                            <br>
                                            <?php echo 'Old Patient:    <strong>' . $oldPatient.'</strong>'; ?>TK
                                            <br>
                                            Time: <?php
                                            foreach ($slotExplodes as $slotExplode) {

                                                $readableTime = date('g:i:A', strtotime($slotExplode)) . ' - ';
                                                echo '<strong>' . $readableTime . '</strong>';
                                            }
                                            ?>
                                        </p>

                                        <?php $i++;
                                    }
                                    echo ' </div>';
                                    $collapseInc++;
                                    }

                                    ?>

                                </div>
                            </div>
                        </div>

                        <hr/>
                    </div>

                    <!-- TESTIMONIALS -->
                    <?php


                    $meta_query = array(
                        'relation' => 'AND',
                        array(
                            'key' => 'directory_type',
                            'value' => '127',
                            'compare' => '='
                        )
                    );
                    $query_args = array(
                        'order' => 'asc',
                        'orderby' => 'id',
                        'meta_query' => $meta_query,
                        'posts_per_page' => 3,

                    );

                    $user_query = new WP_User_Query($query_args);
                    $users = $user_query->get_results();
                    ?>
                    <section style="margin-bottom: 30px;">
                        <div class="container-fluid mslc">

                            <div class="row">
                                <div class="col-md-6">
                                    <div id="shareThisStory"
                                         style="background: #f4f4f4; height: 62px; display: block; position: relative; overflow: hidden; width: 100%; margin-top: 30px; margin-bottom: 20px; padding: 16px 8px;">
                                        <h3 style="margin: 0; float: left;">Share This Story, Choose Your Platform!</h3>

                                        <div class="a2a_kit a2a_kit_size_32 a2a_default_style"
                                             style="float: right; line-height: 32px;">
                                            <a class="a2a_dd"
                                               href="https://www.addtoany.com/share#url=https%3A%2F%2Fhasbd.com%2Fdoctors%2Fassist-prof-dr-md-rashed-anwar%2F&amp;title=ASSIST.%20PROF.%20DR.%20MD.%20RASHED%20ANWAR%20-%20HASBD">
                <span class="a2a_svg a2a_s__default a2a_s_a2a" style="background-color:#253e7f;">
                    <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                        <g fill="#FFF">
                            <path d="M14 7h4v18h-4z"></path>
                            <path d="M7 14h18v4H7z"></path>
                        </g>
                    </svg>
                </span>
                                                <span class="a2a_label a2a_localize"
                                                      data-a2a-localize="inner,Share">Share</span>
                                            </a>
                                            <a class="a2a_button_facebook" target="_blank" href="/#facebook"
                                               rel="nofollow noopener">
                <span class="a2a_svg a2a_s__default a2a_s_facebook" style="background-color: #253e7f">
                    <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                        <path fill="#FFF"
                              d="M17.78 27.5V17.008h3.522l.527-4.09h-4.05v-2.61c0-1.182.33-1.99 2.023-1.99h2.166V4.66c-.375-.05-1.66-.16-3.155-.16-3.123 0-5.26 1.905-5.26 5.405v3.016h-3.53v4.09h3.53V27.5h4.223z"></path>
                    </svg>
                </span>
                                                <span class="a2a_label">Facebook</span>
                                            </a>
                                            <a class="a2a_button_twitter" target="_blank" href="/#twitter"
                                               rel="nofollow noopener">
                <span class="a2a_svg a2a_s__default a2a_s_twitter" style="background-color: #253e7f">
                    <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                        <path
                                fill="#FFF"
                                d="M28 8.557a9.913 9.913 0 0 1-2.828.775 4.93 4.93 0 0 0 2.166-2.725 9.738 9.738 0 0 1-3.13 1.194 4.92 4.92 0 0 0-3.593-1.55 4.924 4.924 0 0 0-4.794 6.049c-4.09-.21-7.72-2.17-10.15-5.15a4.942 4.942 0 0 0-.665 2.477c0 1.71.87 3.214 2.19 4.1a4.968 4.968 0 0 1-2.23-.616v.06c0 2.39 1.7 4.38 3.952 4.83-.414.115-.85.174-1.297.174-.318 0-.626-.03-.928-.086a4.935 4.935 0 0 0 4.6 3.42 9.893 9.893 0 0 1-6.114 2.107c-.398 0-.79-.023-1.175-.068a13.953 13.953 0 0 0 7.55 2.213c9.056 0 14.01-7.507 14.01-14.013 0-.213-.005-.426-.015-.637.96-.695 1.795-1.56 2.455-2.55z"
                        ></path>
                    </svg>
                </span>
                                                <span class="a2a_label">Twitter</span>
                                            </a>
                                            <a class="a2a_button_google_plus"></a>
                                            <div style="clear: both;"></div>
                                        </div>
                                        <script async="" src="https://static.addtoany.com/menu/page.js"></script>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h3 style="margin: 0; float: left;">Reviews and Comment</h3>

                                    <?php
                                    get_template_part('directory/provider-page/template-author-reviews');
                                    ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="page-header">
                                    <h1 style="text-align: center;">Related Specialized Doctors</h1>

                                </div>
                                <div class="col-sm-12">
                                    <div id="customers-testimonials" class="owl-carousel mostafizd">
                                        <!--TESTIMONIAL 1 -->
                                        <?php
                                        $specialities = get_user_meta($author_profile->ID, 'user_profile_specialities', true);
                                        $ambulanceSpecialities = [];
                                        foreach ($specialities as $key => $speciality) {

                                            $ambulanceSpecialities[] = array(
                                                'key' => 'user_profile_specialities',
                                                'value' => $key,
                                                'compare' => "LIKE",
                                            );
                                        }
                                        $args = array(
                                            'meta_query' =>
                                                array(
                                                    array(
                                                        'relation' => 'AND',
                                                        array(
                                                            'key' => 'directory_type',
                                                            'value' => 127,
                                                            'compare' => '='
                                                        )
                                                    ),
                                                    array(
                                                        'relation' => 'and',
                                                        $ambulanceSpecialities
                                                    )
                                                )
                                        );

                                        $query_args = array(
                                            'order' => 'asc',
                                            'orderby' => 'id',
                                            'meta_query' => $args,
                                            'posts_per_page' => 4,
                                        );
                                        $user_query = new WP_User_Query($query_args);
                                        $users = $user_query->get_results();
                                        foreach ($users as $key => $user) {


                                            $directories_array['fax'] = $user->fax;
                                            $directories_array['description'] = $user->description;
                                            $directories_array['title'] = $user->display_name;
                                            $directories_array['name'] = $user->first_name . ' ' . $user->last_name;
                                            $directories_array['user_nicename'] = $user->data->user_nicename;
                                            $directories_array['email'] = $user->user_email;
                                            $directories_array['phone_number'] = $user->phone_number;
                                            $directories_array['address'] = $user->user_address;
                                            $directories_array['car_no'] = $user->car_no;
                                            $avatar = apply_filters(
                                                'docdirect_get_user_avatar_filter',
                                                docdirect_get_user_avatar(array('width' => 270, 'height' => 270), $user->ID),
                                                array('width' => 270, 'height' => 270)
                                            );


                                            ?>
                                            <div class="item">
                                                <div>
                                                    <p>Professor of&nbsp;Gastroenterology Department ARMED FORCES
                                                        MEDICAL
                                                        COLLEGE Specialist in Gastroenterology Department (Int...</p>
                                                    <div style="display: flex;">
                                                        <div style="border: 2px solid #ddd; margin: 10px 15px 10px 0; flex: 1; height: fit-content;">

                                                            <?php if (empty($avatar)): ?>

                                                                <img src="<?php echo site_url(); ?>/wp-content/uploads/doctor/doctor_default.jpg"
                                                                     alt="<?= $directories_array['title'] . ' - ' . site_url(); ?>"/>
                                                            <?php else: ?>

                                                                <img src="<?= $avatar ?>"
                                                                     alt="<?= $directories_array['name'] . ' - ' . site_url(); ?>"/>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div style="flex: 2;">
                                                            <a href="<?php echo site_url(); ?>/doctor/<?php echo $directories_array['user_nicename']; ?>"
                                                               style="text-decoration: none;">
                                                                <h5><?php echo ucfirst($directories_array['name']); ?></h5>
                                                            </a>
                                                            <p style="font-size: 12px; color: #253e7f; font-weight: bold;">
                                                                MBBS(DHAKA)`, FCPS(MEDICINE)</p>
                                                        </div>
                                                    </div>
                                                    <p>POPULAR DIAGNOSTIC CENTRE LTD. | MIRPUR BRANCH</p>
                                                    <p>
                                                        <?php if (!empty($directories_array['address'])): ?>

                                                            <span style="background: #253e7f;
    display: inline-block;
    padding: 6px 4px;
    margin-top: 3px;">
                                    <span style="color: white; border: 1px solid white; padding: 2px;"><?php echo $directories_array['address']; ?></span>
                                </span>
                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <?php wp_reset_query();
                                        } ?>

                                        <!--END OF TESTIMONIAL 1 -->

                                    </div>
                                </div>
                            </div>

                            <!--                    paste here-->
                            <div id="third-row row" style="width: 100%;">
                                <div class="page-header">
                                    <h2 style="text-align: center;">FIND DOCTOR'S CHAMBER ON GOOGLE MAP</h2>
                                </div>
                                <div id="map" style="height: 300px; width: 100%; position: relative; overflow: hidden;">
                                    <div style="height: 100%; width: 100%; position: absolute; top: 0px; left: 0px; background-color: rgb(229, 227, 223);">
                                        <div class="gm-style"
                                             style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px;">
                                            <div
                                                    tabindex="0"
                                                    style="
                            position: absolute;
                            z-index: 0;
                            left: 0px;
                            top: 0px;
                            height: 100%;
                            width: 100%;
                            padding: 0px;
                            border-width: 0px;
                            margin: 0px;
                            cursor: url('https://maps.gstatic.com/mapfiles/openhand_8_8.cur'), default;
                            touch-action: pan-x pan-y;
                        "

                                            <div class="gm-style-pbc"
                                                 style="z-index: 2; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; opacity: 0;">
                                                <p class="gm-style-pbt"></p></div>
                                            <div style="z-index: 3; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; touch-action: pan-x pan-y;">
                                                <div style="z-index: 4; position: absolute; left: 50%; top: 50%; width: 100%; transform: translate(0px, 0px);">
                                                    <div style="position: absolute; left: 0px; top: 0px; z-index: 104; width: 100%;"></div>
                                                    <div style="position: absolute; left: 0px; top: 0px; z-index: 105; width: 100%;"></div>
                                                    <div style="position: absolute; left: 0px; top: 0px; z-index: 106; width: 100%;">
                                                        <div style="width: 27px; height: 43px; overflow: hidden; position: absolute; opacity: 0; left: -14px; top: -40px; z-index: 3;">
                                                            <img alt=""
                                                                 src="https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi2_hdpi.png"
                                                                 draggable="false"
                                                                 usemap="#gmimap0"
                                                                 style="position: absolute; left: 0px; top: 0px; width: 27px; height: 43px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none; opacity: 1;"
                                                            />
                                                            <map name="gmimap0" id="gmimap0">
                                                                <area log="miw"
                                                                      coords="13.5,0,4,3.75,0,13.5,13.5,43,27,13.5,23,3.75"
                                                                      shape="poly" title=""
                                                                      style="cursor: pointer; touch-action: none;"/>
                                                            </map>
                                                        </div>
                                                        <div style="width: 27px; height: 43px; overflow: hidden; position: absolute; opacity: 0; left: -14px; top: -17px; z-index: 26;">
                                                            <img
                                                                    alt=""
                                                                    src="https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi2_hdpi.png"
                                                                    draggable="false"
                                                                    usemap="#gmimap1"
                                                                    style="position: absolute; left: 0px; top: 0px; width: 27px; height: 43px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none; opacity: 1;"
                                                            />
                                                            <map name="gmimap1" id="gmimap1">
                                                                <area log="miw"
                                                                      coords="13.5,0,4,3.75,0,13.5,13.5,43,27,13.5,23,3.75"
                                                                      shape="poly" title=""
                                                                      style="cursor: pointer; touch-action: none;"/>
                                                            </map>
                                                        </div>
                                                        <div style="width: 27px; height: 43px; overflow: hidden; position: absolute; opacity: 0; left: -15px; top: -16px; z-index: 27;">
                                                            <img alt=""
                                                                 src="https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi2_hdpi.png"
                                                                 draggable="false"
                                                                 usemap="#gmimap2"
                                                                 style="position: absolute; left: 0px; top: 0px; width: 27px; height: 43px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none; opacity: 1;"
                                                            />
                                                            <map name="gmimap2" id="gmimap2">
                                                                <area log="miw"
                                                                      coords="13.5,0,4,3.75,0,13.5,13.5,43,27,13.5,23,3.75"
                                                                      shape="poly" title=""
                                                                      style="cursor: pointer; touch-action: none;"/>
                                                            </map>
                                                        </div>
                                                    </div>
                                                    <div style="position: absolute; left: 0px; top: 0px; z-index: 107; width: 100%;">
                                                        <div style="cursor: default; position: absolute; top: 0px; left: 0px; z-index: -90;">
                                                            <div class="gm-style-iw-a"
                                                                 style="position: absolute; left: 0px; top: 3px;">
                                                                <div class="gm-style-iw-t"
                                                                     style="right: 0px; bottom: 54px;">
                                                                    <div class="gm-style-iw gm-style-iw-c"
                                                                         style="padding-right: 0px; padding-bottom: 0px; max-width: 648px; max-height: 126px; min-width: 0px;">
                                                                        <div class="gm-style-iw-d"
                                                                             style="overflow: scroll; max-height: 108px;">
                                                                            <div>POPULAR DIAGNOSTIC CENTRE LTD | UTTARA
                                                                                BRANCH-02
                                                                            </div>
                                                                        </div>
                                                                        <button
                                                                                draggable="false"
                                                                                title="Close"
                                                                                aria-label="Close"
                                                                                type="button"
                                                                                class="gm-ui-hover-effect"
                                                                                style="
                                                            background: none;
                                                            display: block;
                                                            border: 0px;
                                                            margin: 0px;
                                                            padding: 0px;
                                                            position: absolute;
                                                            cursor: pointer;
                                                            user-select: none;
                                                            top: -6px;
                                                            right: -6px;
                                                            width: 30px;
                                                            height: 30px;
                                                        "
                                                                        >
                                                                            <img
                                                                                    src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224px%22%20height%3D%2224px%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22%23000000%22%3E%0A%20%20%20%20%3Cpath%20d%3D%22M19%206.41L17.59%205%2012%2010.59%206.41%205%205%206.41%2010.59%2012%205%2017.59%206.41%2019%2012%2013.41%2017.59%2019%2019%2017.59%2013.41%2012z%22%2F%3E%0A%20%20%20%20%3Cpath%20d%3D%22M0%200h24v24H0z%22%20fill%3D%22none%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                                                    style="pointer-events: none; display: block; width: 14px; height: 14px; margin: 8px;"
                                                                            />
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div style="cursor: default; position: absolute; top: 0px; left: 0px; z-index: -52;">
                                                            <div class="gm-style-iw-a"
                                                                 style="position: absolute; left: 0px; top: 26px;">
                                                                <div class="gm-style-iw-t"
                                                                     style="right: 0px; bottom: 54px;">
                                                                    <div class="gm-style-iw gm-style-iw-c"
                                                                         style="padding-right: 0px; padding-bottom: 0px; max-width: 648px; max-height: 126px; min-width: 0px;">
                                                                        <div class="gm-style-iw-d"
                                                                             style="overflow: scroll; max-height: 108px;"></div>
                                                                        <button
                                                                                draggable="false"
                                                                                title="Close"
                                                                                aria-label="Close"
                                                                                type="button"
                                                                                class="gm-ui-hover-effect"
                                                                                style="
                                                            background: none;
                                                            display: block;
                                                            border: 0px;
                                                            margin: 0px;
                                                            padding: 0px;
                                                            position: absolute;
                                                            cursor: pointer;
                                                            user-select: none;
                                                            top: -6px;
                                                            right: -6px;
                                                            width: 30px;
                                                            height: 30px;
                                                        "
                                                                        >
                                                                            <img
                                                                                    src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224px%22%20height%3D%2224px%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22%23000000%22%3E%0A%20%20%20%20%3Cpath%20d%3D%22M19%206.41L17.59%205%2012%2010.59%206.41%205%205%206.41%2010.59%2012%205%2017.59%206.41%2019%2012%2013.41%2017.59%2019%2019%2017.59%2013.41%2012z%22%2F%3E%0A%20%20%20%20%3Cpath%20d%3D%22M0%200h24v24H0z%22%20fill%3D%22none%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                                                    style="pointer-events: none; display: block; width: 14px; height: 14px; margin: 8px;"
                                                                            />
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div style="cursor: default; position: absolute; top: 0px; left: 0px; z-index: -51;">
                                                            <div class="gm-style-iw-a"
                                                                 style="position: absolute; left: -1px; top: 27px;">
                                                                <div class="gm-style-iw-t"
                                                                     style="right: 0px; bottom: 54px;">
                                                                    <div class="gm-style-iw gm-style-iw-c"
                                                                         style="padding-right: 0px; padding-bottom: 0px; max-width: 648px; max-height: 126px; min-width: 0px;">
                                                                        <div class="gm-style-iw-d"
                                                                             style="overflow: scroll; max-height: 108px;"></div>
                                                                        <button
                                                                                draggable="false"
                                                                                title="Close"
                                                                                aria-label="Close"
                                                                                type="button"
                                                                                class="gm-ui-hover-effect"
                                                                                style="
                                                            background: none;
                                                            display: block;
                                                            border: 0px;
                                                            margin: 0px;
                                                            padding: 0px;
                                                            position: absolute;
                                                            cursor: pointer;
                                                            user-select: none;
                                                            top: -6px;
                                                            right: -6px;
                                                            width: 30px;
                                                            height: 30px;
                                                        "
                                                                        >
                                                                            <img
                                                                                    src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224px%22%20height%3D%2224px%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22%23000000%22%3E%0A%20%20%20%20%3Cpath%20d%3D%22M19%206.41L17.59%205%2012%2010.59%206.41%205%205%206.41%2010.59%2012%205%2017.59%206.41%2019%2012%2013.41%2017.59%2019%2019%2017.59%2013.41%2012z%22%2F%3E%0A%20%20%20%20%3Cpath%20d%3D%22M0%200h24v24H0z%22%20fill%3D%22none%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                                                    style="pointer-events: none; display: block; width: 14px; height: 14px; margin: 8px;"
                                                                            />
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <iframe aria-hidden="true" frameborder="0" tabindex="-1"
                                                style="z-index: -1; position: absolute; width: 100%; height: 100%; top: 0px; left: 0px; border: none;"></iframe>
                                        <div style="margin-left: 5px; margin-right: 5px; z-index: 1000000; position: absolute; left: 0px; bottom: 0px;">
                                            <a
                                                    target="_blank"
                                                    rel="noopener"
                                                    href="https://maps.google.com/maps?ll=23.87606,90.398448&amp;z=8&amp;t=m&amp;hl=en-US&amp;gl=US&amp;mapclient=apiv3"
                                                    title="Open this area in Google Maps (opens a new window)"
                                                    style="position: static; overflow: visible; float: none; display: inline;"
                                            >
                                                <div style="width: 66px; height: 26px; cursor: pointer;">
                                                    <img
                                                            alt=""
                                                            src="https://maps.gstatic.com/mapfiles/api-3/images/google4_hdpi.png"
                                                            draggable="false"
                                                            style="position: absolute; left: 0px; top: 0px; width: 66px; height: 26px; user-select: none; border: 0px; padding: 0px; margin: 0px;"
                                                    />
                                                </div>
                                            </a>
                                        </div>
                                        <div
                                                style="
                            background-color: white;
                            padding: 15px 21px;
                            border: 1px solid rgb(171, 171, 171);
                            font-family: Roboto, Arial, sans-serif;
                            color: rgb(34, 34, 34);
                            box-sizing: border-box;
                            box-shadow: rgba(0, 0, 0, 0.2) 0px 4px 16px;
                            z-index: 10000002;
                            display: none;
                            width: 300px;
                            height: 180px;
                            position: absolute;
                            left: 562px;
                            top: 60px;
                        "
                                        >
                                            <div style="padding: 0px 0px 10px; font-size: 16px; box-sizing: border-box;">
                                                Map
                                                Data
                                            </div>
                                            <div style="font-size: 13px;">Map data ©2020</div>
                                            <button
                                                    draggable="false"
                                                    title="Close"
                                                    aria-label="Close"
                                                    type="button"
                                                    class="gm-ui-hover-effect"
                                                    style="background: none; display: block; border: 0px; margin: 0px; padding: 0px; position: absolute; cursor: pointer; user-select: none; top: 0px; right: 0px; width: 37px; height: 37px;"
                                            >
                                                <img
                                                        src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224px%22%20height%3D%2224px%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22%23000000%22%3E%0A%20%20%20%20%3Cpath%20d%3D%22M19%206.41L17.59%205%2012%2010.59%206.41%205%205%206.41%2010.59%2012%205%2017.59%206.41%2019%2012%2013.41%2017.59%2019%2019%2017.59%2013.41%2012z%22%2F%3E%0A%20%20%20%20%3Cpath%20d%3D%22M0%200h24v24H0z%22%20fill%3D%22none%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                        style="pointer-events: none; display: block; width: 13px; height: 13px; margin: 12px;"
                                                />
                                            </button>
                                        </div>
                                        <div class="gmnoprint"
                                             style="z-index: 1000001; position: absolute; right: 166px; bottom: 0px; width: 86px;">
                                            <div draggable="false" class="gm-style-cc"
                                                 style="user-select: none; height: 14px; line-height: 14px;">
                                                <div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;">
                                                    <div style="width: 1px;"></div>
                                                    <div style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div>
                                                </div>
                                                <div
                                                        style="
                                    position: relative;
                                    padding-right: 6px;
                                    padding-left: 6px;
                                    box-sizing: border-box;
                                    font-family: Roboto, Arial, sans-serif;
                                    font-size: 10px;
                                    color: rgb(68, 68, 68);
                                    white-space: nowrap;
                                    direction: ltr;
                                    text-align: right;
                                    vertical-align: middle;
                                    display: inline-block;
                                "
                                                >
                                                    <a style="text-decoration: none; cursor: pointer; display: none;">Map
                                                        Data</a><span>Map data ©2020</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="gmnoscreen" style="position: absolute; right: 0px; bottom: 0px;">
                                            <div style="font-family: Roboto, Arial, sans-serif; font-size: 11px; color: rgb(68, 68, 68); direction: ltr; text-align: right; background-color: rgb(245, 245, 245);">
                                                Map data ©2020
                                            </div>
                                        </div>
                                        <div class="gmnoprint gm-style-cc" draggable="false"
                                             style="z-index: 1000001; user-select: none; height: 14px; line-height: 14px; position: absolute; right: 95px; bottom: 0px;">
                                            <div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;">
                                                <div style="width: 1px;"></div>
                                                <div style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div>
                                            </div>
                                            <div
                                                    style="
                                position: relative;
                                padding-right: 6px;
                                padding-left: 6px;
                                box-sizing: border-box;
                                font-family: Roboto, Arial, sans-serif;
                                font-size: 10px;
                                color: rgb(68, 68, 68);
                                white-space: nowrap;
                                direction: ltr;
                                text-align: right;
                                vertical-align: middle;
                                display: inline-block;
                            "
                                            >
                                                <a href="https://www.google.com/intl/en-US_US/help/terms_maps.html"
                                                   target="_blank" rel="noopener"
                                                   style="text-decoration: none; cursor: pointer; color: rgb(68, 68, 68);">Terms
                                                    of Use</a>
                                            </div>
                                        </div>
                                        <button
                                                draggable="false"
                                                title="Toggle fullscreen view"
                                                aria-label="Toggle fullscreen view"
                                                type="button"
                                                class="gm-control-active gm-fullscreen-control"
                                                style="
                            background: none rgb(255, 255, 255);
                            border: 0px;
                            margin: 10px;
                            padding: 0px;
                            position: absolute;
                            cursor: pointer;
                            user-select: none;
                            border-radius: 2px;
                            height: 40px;
                            width: 40px;
                            box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px;
                            overflow: hidden;
                            top: 0px;
                            right: 0px;
                        "
                                        >
                                            <img
                                                    src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%20018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23666%22%20d%3D%22M0%2C0v2v4h2V2h4V0H2H0z%20M16%2C0h-4v2h4v4h2V2V0H16z%20M16%2C16h-4v2h4h2v-2v-4h-2V16z%20M2%2C12H0v4v2h2h4v-2H2V12z%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                    style="height: 18px; width: 18px;"
                                            />
                                            <img
                                                    src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23333%22%20d%3D%22M0%2C0v2v4h2V2h4V0H2H0z%20M16%2C0h-4v2h4v4h2V2V0H16z%20M16%2C16h-4v2h4h2v-2v-4h-2V16z%20M2%2C12H0v4v2h2h4v-2H2V12z%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                    style="height: 18px; width: 18px;"
                                            />
                                            <img
                                                    src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23111%22%20d%3D%22M0%2C0v2v4h2V2h4V0H2H0z%20M16%2C0h-4v2h4v4h2V2V0H16z%20M16%2C16h-4v2h4h2v-2v-4h-2V16z%20M2%2C12H0v4v2h2h4v-2H2V12z%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                    style="height: 18px; width: 18px;"
                                            />
                                        </button>
                                        <div draggable="false" class="gm-style-cc"
                                             style="user-select: none; height: 14px; line-height: 14px; position: absolute; right: 0px; bottom: 0px;">
                                            <div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;">
                                                <div style="width: 1px;"></div>
                                                <div style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div>
                                            </div>
                                            <div
                                                    style="
                                position: relative;
                                padding-right: 6px;
                                padding-left: 6px;
                                box-sizing: border-box;
                                font-family: Roboto, Arial, sans-serif;
                                font-size: 10px;
                                color: rgb(68, 68, 68);
                                white-space: nowrap;
                                direction: ltr;
                                text-align: right;
                                vertical-align: middle;
                                display: inline-block;
                            "
                                            >
                                                <a
                                                        target="_blank"
                                                        rel="noopener"
                                                        title="Report errors in the road map or imagery to Google"
                                                        href="https://www.google.com/maps/@23.8760598,90.3984478,8z/data=!10m1!1e1!12b1?source=apiv3&amp;rapsrc=apiv3"
                                                        style="font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); text-decoration: none; position: relative;"
                                                >
                                                    Report a map error
                                                </a>
                                            </div>
                                        </div>
                                        <div class="gmnoprint gm-bundled-control gm-bundled-control-on-bottom"
                                             draggable="false" controlwidth="40" controlheight="81"
                                             style="margin: 10px; user-select: none; position: absolute; bottom: 95px; right: 40px;">
                                            <div class="gmnoprint" controlwidth="40" controlheight="81"
                                                 style="position: absolute; left: 0px; top: 0px;">
                                                <div draggable="false"
                                                     style="user-select: none; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius: 2px; cursor: pointer; background-color: rgb(255, 255, 255); width: 40px; height: 81px;">
                                                    <button
                                                            draggable="false"
                                                            title="Zoom in"
                                                            aria-label="Zoom in"
                                                            type="button"
                                                            class="gm-control-active"
                                                            style="background: none; display: block; border: 0px; margin: 0px; padding: 0px; position: relative; cursor: pointer; user-select: none; overflow: hidden; width: 40px; height: 40px; top: 0px; left: 0px;"
                                                    >
                                                        <img
                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpolygon%20fill%3D%22%23666%22%20points%3D%2218%2C7%2011%2C7%2011%2C0%207%2C0%207%2C7%200%2C7%200%2C11%207%2C11%207%2C18%2011%2C18%2011%2C11%2018%2C11%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                                style="height: 18px; width: 18px;"
                                                        />
                                                        <img
                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpolygon%20fill%3D%22%23333%22%20points%3D%2218%2C7%2011%2C7%2011%2C0%207%2C0%207%2C7%200%2C7%200%2C11%207%2C11%207%2C18%2011%2C18%2011%2C11%2018%2C11%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                                style="height: 18px; width: 18px;"
                                                        />
                                                        <img
                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpolygon%20fill%3D%22%23111%22%20points%3D%2218%2C7%2011%2C7%2011%2C0%207%2C0%207%2C7%200%2C7%200%2C11%207%2C11%207%2C18%2011%2C18%2011%2C11%2018%2C11%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                                style="height: 18px; width: 18px;"
                                                        />
                                                    </button>
                                                    <div style="position: relative; overflow: hidden; width: 30px; height: 1px; margin: 0px 5px; background-color: rgb(230, 230, 230); top: 0px;"></div>
                                                    <button
                                                            draggable="false"
                                                            title="Zoom out"
                                                            aria-label="Zoom out"
                                                            type="button"
                                                            class="gm-control-active"
                                                            style="background: none; display: block; border: 0px; margin: 0px; padding: 0px; position: relative; cursor: pointer; user-select: none; overflow: hidden; width: 40px; height: 40px; top: 0px; left: 0px;"
                                                    >
                                                        <img
                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23666%22%20d%3D%22M0%2C7h18v4H0V7z%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                                style="height: 18px; width: 18px;"
                                                        />
                                                        <img
                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23333%22%20d%3D%22M0%2C7h18v4H0V7z%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                                style="height: 18px; width: 18px;"
                                                        />
                                                        <img
                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23111%22%20d%3D%22M0%2C7h18v4H0V7z%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                                style="height: 18px; width: 18px;"
                                                        />
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="gmnoprint" controlwidth="40" controlheight="40"
                                                 style="display: none; position: absolute;">
                                                <div style="width: 40px; height: 40px;">
                                                    <button
                                                            draggable="false"
                                                            title="Rotate map 90 degrees"
                                                            aria-label="Rotate map 90 degrees"
                                                            type="button"
                                                            class="gm-control-active"
                                                            style="
                                        background: none rgb(255, 255, 255);
                                        display: none;
                                        border: 0px;
                                        margin: 0px 0px 32px;
                                        padding: 0px;
                                        position: relative;
                                        cursor: pointer;
                                        user-select: none;
                                        width: 40px;
                                        height: 40px;
                                        top: 0px;
                                        left: 0px;
                                        overflow: hidden;
                                        box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px;
                                        border-radius: 2px;
                                    "
                                                    >
                                                        <img
                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2222%22%20viewBox%3D%220%200%2024%2022%22%3E%0A%20%20%3Cpath%20fill%3D%22%23666%22%20fill-rule%3D%22evenodd%22%20d%3D%22M20%2010c0-5.52-4.48-10-10-10s-10%204.48-10%2010v5h5v-5c0-2.76%202.24-5%205-5s5%202.24%205%205v5h-4l6.5%207%206.5-7h-4v-5z%22%20clip-rule%3D%22evenodd%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                                style="height: 18px; width: 18px;"
                                                        />
                                                        <img
                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2222%22%20viewBox%3D%220%200%2024%2022%22%3E%0A%20%20%3Cpath%20fill%3D%22%23333%22%20fill-rule%3D%22evenodd%22%20d%3D%22M20%2010c0-5.52-4.48-10-10-10s-10%204.48-10%2010v5h5v-5c0-2.76%202.24-5%205-5s5%202.24%205%205v5h-4l6.5%207%206.5-7h-4v-5z%22%20clip-rule%3D%22evenodd%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                                style="height: 18px; width: 18px;"
                                                        />
                                                        <img
                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2222%22%20viewBox%3D%220%200%2024%2022%22%3E%0A%20%20%3Cpath%20fill%3D%22%23111%22%20fill-rule%3D%22evenodd%22%20d%3D%22M20%2010c0-5.52-4.48-10-10-10s-10%204.48-10%2010v5h5v-5c0-2.76%202.24-5%205-5s5%202.24%205%205v5h-4l6.5%207%206.5-7h-4v-5z%22%20clip-rule%3D%22evenodd%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                                style="height: 18px; width: 18px;"
                                                        />
                                                    </button>
                                                    <button
                                                            draggable="false"
                                                            title="Tilt map"
                                                            aria-label="Tilt map"
                                                            type="button"
                                                            class="gm-tilt gm-control-active"
                                                            style="
                                        background: none rgb(255, 255, 255);
                                        display: block;
                                        border: 0px;
                                        margin: 0px;
                                        padding: 0px;
                                        position: relative;
                                        cursor: pointer;
                                        user-select: none;
                                        width: 40px;
                                        height: 40px;
                                        top: 0px;
                                        left: 0px;
                                        overflow: hidden;
                                        box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px;
                                        border-radius: 2px;
                                    "
                                                    >
                                                        <img
                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218px%22%20height%3D%2216px%22%20viewBox%3D%220%200%2018%2016%22%3E%0A%20%20%3Cpath%20fill%3D%22%23666%22%20d%3D%22M0%2C16h8V9H0V16z%20M10%2C16h8V9h-8V16z%20M0%2C7h8V0H0V7z%20M10%2C0v7h8V0H10z%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                                style="width: 18px;"
                                                        />
                                                        <img
                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218px%22%20height%3D%2216px%22%20viewBox%3D%220%200%2018%2016%22%3E%0A%20%20%3Cpath%20fill%3D%22%23333%22%20d%3D%22M0%2C16h8V9H0V16z%20M10%2C16h8V9h-8V16z%20M0%2C7h8V0H0V7z%20M10%2C0v7h8V0H10z%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                                style="width: 18px;"
                                                        />
                                                        <img
                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218px%22%20height%3D%2216px%22%20viewBox%3D%220%200%2018%2016%22%3E%0A%20%20%3Cpath%20fill%3D%22%23111%22%20d%3D%22M0%2C16h8V9H0V16z%20M10%2C16h8V9h-8V16z%20M0%2C7h8V0H0V7z%20M10%2C0v7h8V0H10z%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                                                style="width: 18px;"
                                                        />
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <script>
                                function initMap() {
                                    var locations = [
                                        {
                                            info: "POPULAR DIAGNOSTIC CENTRE LTD | UTTARA BRANCH-02",
                                            lat: 23.8609897,
                                            long: 90.3984478,
                                        },

                                        {
                                            info: "",
                                            lat: 23.746523,
                                            long: 90.402577,
                                        },

                                        {
                                            info: "",
                                            lat: 23.738469,
                                            long: 90.395251,
                                        },
                                    ];

                                    var map = new google.maps.Map(document.getElementById("map"), {
                                        zoom: 8,
                                        center: new google.maps.LatLng(locations[0].lat, locations[0].long),
                                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                                    });

                                    locations.forEach((location) => {
                                        var infoWindow = new google.maps.InfoWindow({});
                                        var marker = new google.maps.Marker({
                                            position: new google.maps.LatLng(location.lat, location.long),
                                            map: map,
                                        });
                                        infoWindow.setContent(location.info);
                                        infoWindow.open(map, marker);
                                        google.maps.event.addListener(marker, "click", (e) => {
                                            infoWindow.setContent(trim(location.info));
                                            infoWindow.open(map, marker);
                                        });
                                    });
                                }
                            </script>
                            <script async="" defer=""
                                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0PT_dg83oIexTOYRwnDziZlbqQlZmYVo&amp;callback=initMap"></script>


                            <!--                    paste here-->
                        </div>
                    </section>
                    <!-- END OF TESTIMONIALS -->


                </main>


            </div>

        <?php } else { ?>
            <div class="container-fluid mslc">
                <?php DoctorDirectory_NotificationsHelper::informations(esc_html__('You are not allowed to view this page. This users has expired or didn\'t subscribed to any package', 'docdirect')); ?>
            </div>
        <?php } ?>

    <?php } else { ?>
        <div class="container-fluid mslc">
            <?php DoctorDirectory_NotificationsHelper::informations(esc_html__('Oops! you are not allowed to access this page.', 'docdirect')); ?>
        </div>
    <?php } ?>
    <?php get_footer(); ?>
    <?php
    if (apply_filters('docdirect_is_setting_enabled', $author_profile->ID, 'appointments') === true) {
        if (isset($current_user->ID)
            &&
            $current_user->ID != $author_profile->ID
            &&
            is_user_logged_in()
        ) {

            if (!empty($privacy['appointments'])
                &&
                $privacy['appointments'] == 'on'
            ) {

                ?>
                <div class="modal fade tg-appointmentpopup" tabindex="-1" role="dialog"
                     aria-labelledby="myLargeModalLabel">
                    <div class="modal-dialog modal-lg tg-modalcontent" role="document">
                        <form action="#" method="post" class="appointment-form">
                            <fieldset class="booking-model-contents">
                                <ul class="tg-navdocappointment" role="tablist">
                                    <li class="active">
                                        <a href="javascript:"
                                           class="bk-step-1"><?php esc_html_e('1. choose service', 'docdirect'); ?>
                                        </a>

                                    </li>

                                    <li><a href="javascript:"
                                           class="bk-step-2"><?php esc_html_e('2. available schedule', 'docdirect'); ?></a>
                                    </li>
                                    <li><a href="javascript:"
                                           class="bk-step-3"><?php esc_html_e('3. your contact detail', 'docdirect'); ?></a>
                                    </li>
                                    <li><a href="javascript:"
                                           class="bk-step-4"><?php esc_html_e('4. Payment Mode', 'docdirect'); ?></a>
                                    </li>
                                    <li><a href="javascript:"
                                           class="bk-step-5"><?php esc_html_e('5. Finish', 'docdirect'); ?></a></li>
                                </ul>
                                <div class="tab-content tg-appointmenttabcontent"
                                     data-id="<?php echo esc_attr($author_profile->ID); ?>">
                                    <div class="tab-pane active step-one-contents" id="one">
                                        <?php docdirect_get_booking_step_one($author_profile->ID, 'echo'); ?>
                                        <p id="step1-message" class="text-left"
                                           style="color: red; font-size: 16px;"></p>
                                    </div>
                                    <div class="tab-pane step-two-contents" id="two">
                                        <?php docdirect_get_booking_step_two_calender($author_profile->ID, 'echo'); ?>
                                    </div>
                                    <div class="tab-pane step-three-contents" id="three"></div>
                                    <div class="tab-pane step-four-contents" id="four"></div>
                                    <div class="tab-pane step-five-contents" id="five"></div>
                                    <div class="tg-btnbox booking-step-button">
                                        <button type="button"
                                                class="tg-btn bk-step-prev"><?php esc_html_e('Previous', 'docdirect'); ?></button>
                                        <button type="button"
                                                class="tg-btn bk-step-next"><?php esc_html_e('next', 'docdirect'); ?></button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            <?php }
        }
    }
} else {
    get_template_part('content', 'author');
    get_footer();
}
do_action('am_chat_modal', $author_profile->ID);

?>
<style>
    .testimonials {
        background-color: #f33f02;
        position: relative;
        padding-top: 80px;

    &
    :after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 30%;
        background-color: #ddd;
    }

    }
    #customers-testimonials {

    .item-details {
        background-color: #333333;
        color: #fff;
        padding: 20px 10px;
        text-align: left;

    h5 {
        margin: 0 0 15px;
        font-size: 18px;
        line-height: 18px;

    span {
        color: red;
        float: right;
        padding-right: 20px;
    }

    }
    p {
        font-size: 14px;
    }

    }
    .item {
        text-align: center;
    / / padding: 20 px;
        margin-bottom: 80px;
    }

    }
    .owl-carousel .owl-nav [class*='owl-'] {
        -webkit-transition: all .3s ease;
        transition: all .3s ease;
    }

    .owl-carousel .owl-nav [class*='owl-'].disabled:hover {
        background-color: #D6D6D6;
    }

    .owl-carousel {
        position: relative;
    }

    .owl-carousel .owl-next,
    .owl-carousel .owl-prev {
        width: 50px;
        height: 50px;
        line-height: 50px;
        border-radius: 50%;
        position: absolute;
        top: 30%;
        font-size: 20px;
        color: #fff;
        border: 1px solid #ddd;
        text-align: center;
    }

    .owl-carousel .owl-prev {
        left: -70px;
    }

    .owl-carousel .owl-next {
        right: -70px;
    }


    .nav-tab {

    }

    div#nav-tab a {
        padding: 11px 12px;
        font-size: 18px;
        border: 2px solid #000;
        margin-bottom: 20px !important;
        background: #807293;
        color: #fff;

    }

    div#nav-tab a:hover {
        padding: 12px 11px;
        font-size: 18px;
        border: 2px solid #000;
        margin-bottom: 20px !important;
        background: #3c2d2d;
        color: #fff;
    }

    .selected {
        padding: 12px 11px;
        font-size: 18px;
        border: 2px solid #000;
        margin-bottom: 20px !important;
        background: #3c2d2d !important;
        color: #fff;
    }


    .project-tab #tabs {
        background: #007b5e;
        color: #eee;
    }

    .project-tab #tabs h6.section-title {
        color: #eee;
    }

    .project-tab #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        color: #0062cc;
        background-color: transparent;
        border-color: transparent transparent #f3f3f3;
        border-bottom: 3px solid !important;
        font-size: 16px;
        font-weight: bold;
    }

    .project-tab .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
        color: #0062cc;
        font-size: 16px;
        font-weight: 600;
    }

    .project-tab .nav-link:hover {
        border: none;
    }

    .project-tab thead {
        background: #f3f3f3;
        color: #333;
    }

    .project-tab a {
        text-decoration: none;
        color: #333;
        font-weight: 600;
    }

    .nav-tabs {
        border-bottom: 1px solid #ddd;
        margin-bottom: 17px;
    }

    div#nav-tab a {
        padding: 11px;
        font-size: 18px;
        border: 2px solid #000;
        margin-bottom: 20px !important;
    }

    @media (min-width: 481px) and (max-width: 767px) {

        .nav-tab {
            display: none;
        }

        div#nav-tab a {
            padding: 8px 14px;
            font-size: 17px;
            border: 2px solid #000;
            margin-bottom: 20px !important;
            display: inline-block;

        }

        div#nav-tab a:hover {
            padding: 12px 11px;
            font-size: 18px;
            border: 2px solid #000;
            margin-bottom: 20px !important;
            background: #3c2d2d;
            color: #fff;
        }

        .selected {
            padding: 12px 11px;
            font-size: 18px;
            border: 2px solid #000;
            margin-bottom: 20px !important;
            background: #3c2d2d !important;
            color: #fff;
        }


        .project-tab #tabs {
            background: #007b5e;
            color: #eee;
        }

        .project-tab #tabs h6.section-title {
            color: #eee;
        }

        .project-tab #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            color: #0062cc;
            background-color: transparent;
            border-color: transparent transparent #f3f3f3;
            border-bottom: 3px solid !important;
            font-size: 16px;
            font-weight: bold;
        }

        .project-tab .nav-link {
            border: 1px solid transparent;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
            color: #0062cc;
            font-size: 16px;
            font-weight: 600;
        }

        .project-tab .nav-link:hover {
            border: none;
        }

        .project-tab thead {
            background: #f3f3f3;
            color: #333;
        }

        .project-tab a {
            text-decoration: none;
            color: #333;
            font-weight: 600;
        }

        .nav-tabs {
            border-bottom: 1px solid #ddd;
            margin-bottom: 17px;
        }

        div#nav-tab a {
            padding: 11px;
            font-size: 18px;
            border: 2px solid #000;
            margin-bottom: 20px !important;
        }

    }

    .owl-carousel .owl-stage-outer {
        overflow: visible !important;
    }

    .mostafizd > .owl-nav .owl-prev {
        background-color: #253e7f42;
        margin-left: 70px;
    }

    .mostafizd > .owl-nav .owl-next {
        background-color: #253e7f42;
        margin-right: 70px;
    }

    .mostafiz > .owl-stage-outer > .owl-stage .owl-item {
        /*width: 300px !important;*/
        border: 0px solid red !important;
    }
</style>
<script>
    jQuery(document).ready(function () {

        jQuery('#nav-tab a').click(function () {

            var siblings = $(this).siblings();
            siblings.each(function (index, element) {
                $(this).removeClass('selected');
            });
            $(this).addClass('selected');
        });
    });
    jQuery(document).ready(function ($) {
        "use strict";
        $('#customers-testimonials').owlCarousel({
            loop: true,
            center: true,
            items: 3,
            margin: 30,
            autoplay: true,
            dots: true,
            nav: true,
            autoplayTimeout: 8500,
            smartSpeed: 450,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1170: {
                    items: 3
                }
            }
        });
    });
</script>


<style>
    @media only screen and (min-width: 321px) and (max-width: 768px) {
        .mslc {
            padding: 2px 0px !important;
        }

        .user-profile-dir-list img {
            width: 100% !important;
            height: auto !important;
            border: 1px solid #eee;
            padding: 5px;
        }

        .info {
            width: 95%;
            margin: 10px !important;
        }

        .chamber {
            width: 95%;
            margin: 10px;
        }

        div#customers-testimonials {
            margin: 10px;
        }

    }

    .mslc {
        padding: 2px 48px;
    }

    @media screen and (max-width: 480px) {
        #hospitalsCalculator table {
            width: 100%;
            display: block;
            overflow: scroll;
        }

        #registerContainer,
        #loginContainer {
            width: 90% !important;
        }

        #home-consultation-form {
            height: 600px !important;
        }
    }

    @media screen and (max-width: 900px) {
        .menu-menu-container,
        .showhide,
        #homeSlider {
            display: none !important;
        }

        #mobileSearch {
            display: block !important;
            position: relative !important;
            width: 100%;
        }

        .widget .menu-menu-container {
            display: block !important;
        }

        .fusion-layout-column {
            width: 100% !important;
        }

        div#second-row {
            display: block !important;
        }

        div#shareThisStory {
            height: auto !important;
        }

        #main {
            padding: 0 !important;
        }

        #ambulance {
            height: 200px !important;
            background-size: 100% 200px !important;
        }

        .modal-body,
        .modal-body > .search-box {
            height: auto !important;
        }

        .latestPostDate,
        .latestPostTitle {
            margin-left: 0 !important;
        }

        .postsRow > .col-md-3 {
            width: 90% !important;
            margin-bottom: 15px;
        }

        .postInfo {
            margin-top: 33px !important;
        }

        #home-consultation-form {
            height: 600px !important;
        }

        #proflie-info {
            width: 100% !important;
            height: auto !important;
            margin-left: -15px !important;
        }
    }


</style>





