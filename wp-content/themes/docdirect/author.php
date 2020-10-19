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

$userMeta = get_user_meta($author_profile->ID);
$name = $userMeta['first_name'][0] . ' ' . $userMeta['last_name'][0];
$address = $userMeta['user_address'][0];
$tagline = $userMeta['tagline'][0];
$phone = $userMeta['phone_number'][0];
$address = $userMeta['user_address'][0];
$experiences = unserializeData($userMeta['experience'][0]);
$specialities = unserializeData($userMeta['user_profile_specialities'][0]);
$schedules = unserializeData($userMeta['schedules'][0]);
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

if ($directory_type== 123)
{

    get_template_part('author-ambulance');

}


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




     
