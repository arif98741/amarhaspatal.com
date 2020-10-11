<?php
/**
 * Template Name: Ambulance inner Page
 */
?>
<?php
get_header();
?>

<!-- mostafiz start -->


<div style="border: 0px solid red;" class="main-content container-fluid mslc">
                <!-- <h1>Mostafizur</h1> -->

                <main id="main" class="site-main" role="main">
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
                <div class="container">


                    <div class="row">
                        <div class="page-header">
                            <h1 style="text-align: center;">Related Hospitals</h1>

                        </div>
                        <div class="col-sm-12">
                            <div id="customers-testimonials" class="owl-carousel mostafiz">
                                <!--TESTIMONIAL 1 -->
                                <?php
                                //user loop
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
                                            <p>Professor of&nbsp;Gastroenterology Department ARMED FORCES MEDICAL
                                                COLLEGE Specialist in Gastroenterology Department (Int...</p>
                                            <div style="display: flex;">
                                                <div style="border: 2px solid #ddd; margin: 10px 15px 10px 0; flex: 1; height: fit-content;">
<!--                                                    <img src="https://hasbd.com/wp-content/themes/hasbd/images/doctor.jpg"-->
<!--                                                         style="width: 100%; padding: 2px;"/>-->


                                                    <?php if (empty($avatar)): ?>

                                                            <img src="<?php echo site_url(); ?>/wp-content/uploads/doctor/doctor_default.jpg"
                                                                 alt="<?= $directories_array['title'] . ' - ' . site_url(); ?>"/>
                                                    <?php else: ?>

                                                            <img src="<?= $avatar ?>"
                                                                 alt="<?= $directories_array['name'] . ' - ' . site_url(); ?>"/>
                                                    <?php endif; ?>
                                                </div>
                                                <div style="flex: 2;">
                                                    <a href="https://hasbd.com/doctors/prof-dr-brig-gen-md-moklesur-rahman/"
                                                       style="text-decoration: none;">
                                                        <h5><?php echo ucfirst($directories_array['name']); ?></h5></a>
                                                    <p style="font-size: 12px; color: #253e7f; font-weight: bold;">
                                                        MBBS(DHAKA), FCPS(MEDICINE)</p>
                                                </div>
                                            </div>
                                            <p>POPULAR DIAGNOSTIC CENTRE LTD. | MIRPUR BRANCH</p>
                                            <p>
                                <?php if(!empty($directories_array['address'])): ?>

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
                </div>
            </section>
            <!-- END OF TESTIMONIALS -->
                </main>
</div>



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
    // padding: 20 px;
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

    .mostafiz > .owl-nav .owl-prev {
        background-color: #253e7f42;
        margin-left: -70px;
    }

    .mostafiz > .owl-nav .owl-next {
        background-color: #253e7f42;
        margin-right: -70px;
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
    }

    .mslc {
        padding: 2px 48px;
    }
</style>

<!-- mostafiz end -->
<?php
get_footer();
?>
