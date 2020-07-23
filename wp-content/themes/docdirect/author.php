<?php
/**
 * The template for displaying user detail
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Doctor Directory
 */
global $wp_query, $current_user;
$author_profile = $wp_query->get_queried_object();
do_action('docdirect_update_profile_hits', $author_profile->ID); //Update Profile Hits
docdirect_set_user_views($author_profile->ID); //Update profile views
get_header();//Include Headers

$directory_type = $author_profile->directory_type;
$schedule_time_format = isset($author_profile->time_format) ? $author_profile->time_format : '12hour';
$privacy = docdirect_get_privacy_settings($author_profile->ID); //Privacy settings
$db_timezone = get_user_meta($author_profile->ID, 'default_timezone', true);
$time_zone = get_user_meta($author_profile->ID, 'default_timezone', true);
$slots = get_user_meta($author_profile->ID, 'default_slots')[0];


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
            <?php get_template_part('directory/provider-page/template-author', 'header'); ?>
            <div class="container">
                dfd
                <div class="row">

                    <div class="tg-userdetail <?php echo sanitize_html_class($apointmentClass); ?>">
                        <?php get_template_part('directory/provider-page/template-author', 'sidebar'); ?>
                        <?php if ($directory_type == 127) { ?>
                            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">

                                <div class="col-md-12">
                                    <nav style="width: 100%;">
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">

                                            <a class="nav-item nav-link selected" id="nav-about-me-tab"
                                               data-toggle="tab"
                                               href="#nav-about-me" role="tab" aria-controls="nav-about-me"
                                               aria-selected="false">About</a>

                                            <a class="nav-item nav-link" id="nav-specilities-honors-tab"
                                               data-toggle="tab"
                                               href="#nav-specilities-honors" role="tab"
                                               aria-controls="nav-specilities-honors"
                                               aria-selected="false">Specialities</a>
                                            <a class="nav-item nav-link" id="nav-schednav-schedule-tabule-tab"
                                               data-toggle="tab"
                                               href="#nav-schedule" role="tab" aria-controls="nav-schedule"
                                               aria-selected="false">Schedule</a>
                                            <!--
                                           <a class="nav-item nav-link" id="nav-experience-tab" data-toggle="tab"
                                              href="#nav-experience" role="tab" aria-controls="nav-experience"
                                              aria-selected="false">Experience</a>-->
                                        </div>
                                    </nav>
                                    <br>
                                    <div class="tab-content">
                                        <div id="2020" class="tab-pane fade in active">
                                            <div class="program-content-block">
                                                <div class="panel-group" id="accordionMenu2020" role="tablist"
                                                     aria-multiselectable="true">
                                                    <div class="panel panel-default">


                                                        <div class="panel-heading  green " role="tab"
                                                             id="headingUndergraduate2020">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse"
                                                                   data-parent="#accordionMenu2020"
                                                                   href="#Undergraduate2020" aria-expanded="false"
                                                                   aria-controls="Undergraduate2020" class="collapsed">
                                                                    About Me
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="Undergraduate2020" class="panel-collapse collapse"
                                                             role="tabpanel" aria-labelledby="headingUndergraduate2020"
                                                             aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">
                                                                <?php get_template_part('directory/provider-page/template-author-about'); ?>
                                                            </div>
                                                        </div>

                                                        <div class="panel-heading  lightGreen " role="tab"
                                                             id="headingGraduate2020">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse"
                                                                   data-parent="#accordionMenu2020" href="#Graduate2020"
                                                                   aria-expanded="false" aria-controls="Graduate2020"
                                                                   class="collapsed">
                                                                    Education
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="Graduate2020" class="panel-collapse collapse "
                                                             role="tabpanel" aria-labelledby="headingGraduate2020"
                                                             aria-expanded="false">
                                                            <div class="panel-body">
                                                                <?php get_template_part('directory/provider-page/template-author-education'); ?>
                                                            </div>
                                                        </div>

                                                        <div class="panel-heading  lighterGreen " role="tab"
                                                             id="headingPharmacy2020">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse"
                                                                   data-parent="#accordionMenu2020" href="#Pharmacy2020"
                                                                   aria-expanded="false" aria-controls="Pharmacy2020"
                                                                   class="collapsed">
                                                                    Experience
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="Pharmacy2020" class="panel-collapse collapse "
                                                             role="tabpanel" aria-labelledby="headingPharmacy2020"
                                                             aria-expanded="false">
                                                            <div class="panel-body">
                                                                <?php get_template_part('directory/provider-page/template-author-experience'); ?>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="2019" class="tab-pane fade in ">
                                            <div class="program-content-block">
                                                <div class="panel-group" id="accordionMenu2019" role="tablist"
                                                     aria-multiselectable="true">
                                                    <div class="panel panel-default">


                                                        <div class="panel-heading  green " role="tab"
                                                             id="headingUndergraduate2019">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse"
                                                                   data-parent="#accordionMenu2019"
                                                                   href="#Undergraduate2019" aria-expanded="false"
                                                                   aria-controls="Undergraduate2019">
                                                                    Undergraduate
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="Undergraduate2019" class="panel-collapse collapse "
                                                             role="tabpanel" aria-labelledby="headingUndergraduate2019">
                                                            <div class="panel-body">
                                                                <ul class="nav-customcs">
                                                                    <li><a href="/academic-calendar-details/2">Spring-2019</a>
                                                                    </li>
                                                                    <li><a href="/academic-calendar-details/3">Summer-2019
                                                                            Exam Schedule</a></li>
                                                                    <li><a href="/academic-calendar-details/4">Summer-2019</a>
                                                                    </li>
                                                                    <li><a href="/academic-calendar-details/10">Fall-2019</a>
                                                                    </li>
                                                                    <li><a href="/academic-calendar-details/11">Fall
                                                                            2019 - Exam Schedule</a></li>
                                                                    <li><a href="/academic-calendar-details/1">Spring-2019
                                                                            Exam Schedule</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <div class="panel-heading  lightGreen " role="tab"
                                                             id="headingGraduate2019">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse"
                                                                   data-parent="#accordionMenu2019" href="#Graduate2019"
                                                                   aria-expanded="false" aria-controls="Graduate2019">
                                                                    Graduate
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="Graduate2019" class="panel-collapse collapse "
                                                             role="tabpanel" aria-labelledby="headingGraduate2019">
                                                            <div class="panel-body">
                                                                <ul class="nav-customcs">
                                                                    <li><a href="/academic-calendar-details/9">Fall
                                                                            2019</a></li>
                                                                    <li><a href="/academic-calendar-details/6">Summer-2019</a>
                                                                    </li>
                                                                    <li><a href="/academic-calendar-details/5">Spring-2019</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <div class="panel-heading  lighterGreen " role="tab"
                                                             id="headingPharmacy2019">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse"
                                                                   data-parent="#accordionMenu2019" href="#Pharmacy2019"
                                                                   aria-expanded="false" aria-controls="Pharmacy2019">
                                                                    Pharmacy
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="Pharmacy2019" class="panel-collapse collapse "
                                                             role="tabpanel" aria-labelledby="headingPharmacy2019">
                                                            <div class="panel-body">
                                                                <ul class="nav-customcs">
                                                                    <li><a href="/academic-calendar-details/13">M.
                                                                            Pharm: Fall-2019</a></li>
                                                                    <li><a href="/academic-calendar-details/8">B. Pharm:
                                                                            Spring-2019</a></li>
                                                                    <li><a href="/academic-calendar-details/7">M. Pharm:
                                                                            Spring-2019</a></li>
                                                                    <li><a href="/academic-calendar-details/12">B.
                                                                            Pharm: Fall-2019</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tg-haslayout provider-sections">
                                    <?php
                                    /*echo '<pre>';
                                    print_r($display_settings); exit;
                                    foreach ($display_settings as $key => $value) {
                                        if ($directory_type == 127 && ($key == 'map' || $key == 'reviews' || $key == 'specialities'
                                                || $key == 'experience' || $key == 'awards' || $key == 'education')) {
                                            continue;
                                        }
                                        get_template_part('directory/provider-page/template-author', $key);

                                    }
                                    */

                                    //get_template_part('directory/provider-page/template-author-about');
                                    get_template_part('directory/provider-page/template-author-ads-area');
                                    get_template_part('directory/provider-page/template-author-ads-languages');
                                    get_template_part('directory/provider-page/template-author-ads-prices');
                                    get_template_part('directory/provider-page/template-author-ads-video');
                                    get_template_part('directory/provider-page/template-author-ads-gallery');
                                    get_template_part('directory/provider-page/template-author-map');
                                    get_template_part('directory/provider-page/template-author-more-info-tabs');
                                    //get_template_part('directory/provider-page/template-author-reviews');

                                    ?>

                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">

                                <div class="tg-haslayout provider-sections">
                                    <?php

                                    /*foreach ($display_settings as $key => $value) {

                                        if ($key == 'map' || $key == 'reviews') {
                                            continue;
                                        }
                                        get_template_part('directory/provider-page/template-author', $key);

                                    }*/
                                    get_template_part('directory/provider-page/template-author-about');
                                    get_template_part('directory/provider-page/template-author-ads-area');
                                    get_template_part('directory/provider-page/template-author-ads-languages');
                                    get_template_part('directory/provider-page/template-author-ads-prices');
                                    get_template_part('directory/provider-page/template-author-ads-video');
                                    get_template_part('directory/provider-page/template-author-ads-gallery');
                                    get_template_part('directory/provider-page/template-author-map');
                                    get_template_part('directory/provider-page/template-author-more-info-tabs');
                                    // get_template_part('directory/provider-page/template-author-reviews');

                                    ?>
                                </div>
                                <?php
                                //  get_template_part('directory/provider-page/template-author-map');
                                //  get_template_part('directory/provider-page/template-author-reviews');
                                ?>
                            </div>

                        <?php } ?>
                    </div>

                </div>
            </div>
        <?php } else { ?>
            <div class="container">
                <?php DoctorDirectory_NotificationsHelper::informations(esc_html__('You are not allowed to view this page. This users has expired or didn\'t subscribed to any package', 'docdirect')); ?>
            </div>
        <?php } ?>

    <?php } else { ?>
        <div class="container">
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
                                        <a href="javascript:;"
                                           class="bk-step-1"><?php esc_html_e('1. choose service', 'docdirect'); ?>
                                        </a>

                                    </li>

                                    <li><a href="javascript:;"
                                           class="bk-step-2"><?php esc_html_e('2. available schedule', 'docdirect'); ?></a>
                                    </li>
                                    <li><a href="javascript:;"
                                           class="bk-step-3"><?php esc_html_e('3. your contact detail', 'docdirect'); ?></a>
                                    </li>
                                    <li><a href="javascript:;"
                                           class="bk-step-4"><?php esc_html_e('4. Payment Mode', 'docdirect'); ?></a>
                                    </li>
                                    <li><a href="javascript:;"
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
                                        <button type="button" style="color: #fff !important;"
                                                class="tg-btn bk-step-prev"><?php esc_html_e('Previous', 'docdirect'); ?></button>
                                        <button type="button" style="color: #fff !important;"
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

    .training-program-tap-wrap {
        padding: 0 40px;
        width: 100%;
        margin: 0 auto;
        height: 50px;
        background-color: #d8d8d8;
    }

    .convocation .tab-content {
        border: 1px solid #d3d3d3;
    }

    .tab-content > .active {
        display: block;
    }

    .convocation .program-content-block {
        padding: 30px;
    }

    .panel-group {
        margin-bottom: 20px;
    }

    .panel-default > .panel-heading {
        color: #fff;
        background-color: #0078A4;
        border-color: #e4e5e7;
        padding: 15px 13px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-bottom: 1px solid #ddd;
        border-radius: 0;
    }

    .nav-customcs a {
        color: #000 !important;
    }

    .crt-program .tab-content {
        margin-top: 30px;
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
</style>
<script>
    $(document).ready(function () {

        $('#nav-tab a').click(function () {

            var siblings = $(this).siblings();
            siblings.each(function (index, element) {
                $(this).removeClass('selected');
            });
            $(this).addClass('selected');
        });
    });
</script>
