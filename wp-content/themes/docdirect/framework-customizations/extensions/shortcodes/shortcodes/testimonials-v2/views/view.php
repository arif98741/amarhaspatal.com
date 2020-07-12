<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
$uniq_flag = fw_unique_increment();
$autoplay = !empty($atts['auto']) ? $atts['auto'] : 'false';

?>
<div class="sc-testimonials">
    <?php if (!empty($atts['heading']) && !empty($atts['sub_heading']) && !empty($atts['description'])) { ?>
        <div class="col-lg-offset-2 col-lg-8 col-md-offset-1 col-md-10 col-sm-offset-0 col-sm-12 col-xs-12">
            <div class="doc-section-head">
                <?php if (!empty($atts['heading']) && !empty($atts['heading'])) { ?>
                    <div class="doc-section-heading">
                        <?php if (!empty($atts['heading'])) { ?>
                            <h2><?php echo esc_attr($atts['heading']); ?></h2>
                        <?php } ?>
                        <?php if (!empty($atts['sub_heading'])) { ?>
                            <span><?php echo esc_attr($atts['sub_heading']); ?></span>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if (!empty($atts['description'])) { ?>
                    <div class="doc-description">
                        <p><?php echo esc_attr($atts['description']); ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <div id="doc-testimonialsslider-<?php echo esc_attr($uniq_flag); ?>"
         class="doc-testimonialsslider doc-testimonials owl-carousel">
        <?php
        if (!empty($atts['data'])) {
            foreach ($atts['data'] as $key => $value) {
                $name = !empty($value['name']) ? $value['name'] : '';
                $designation = !empty($value['designation']) ? $value['designation'] : '';
                $description = !empty($value['description']) ? $value['description'] : '';
                $image = !empty($value['image']) ? $value['image'] : '';
                $video_url = !empty($value['video_url']) ? $value['video_url'] : '';

                if (!empty($image['attachment_id'])) {
                    $banner = docdirect_get_image_source($image['attachment_id'], 470, 305);
                } else {
                    $banner = get_template_directory_uri() . '/images/review.jpg';;
                }
                ?>
                <div class="item doc-testimonial">
                    <div class="col-xs-12 col-sm-6 doc-verticalmiddle">
                        <?php if (!empty($description)) { ?>
                            <blockquote><q><?php echo force_balance_tags($description); ?></q></blockquote>
                        <?php } ?>
                        <div class="doc-clientdetail">
                            <figure class="doc-clientimg"><img src="<?php echo esc_url($banner); ?>"
                                                               alt="<?php esc_html_e('reviewer', 'docdirect'); ?>">
                            </figure>
                            <?php if (!empty($name) || !empty($designation)) { ?>
                                <div class="doc-clientinfo">
                                    <?php if (!empty($name)) { ?><h3><?php echo esc_attr($name); ?></h3><?php } ?>
                                    <?php if (!empty($designation)) { ?>
                                        <span><?php echo esc_attr($designation); ?></span> <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php }
        } ?>
    </div>
    <style>
        blockquote q {
            font-size: 21px;
            line-height: 31px;

        }

        .doc-verticalmiddle {
            margin: 0 -1px;
            float: none !important;
            display: inline-block;
            vertical-align: middle;
            width: 100%;
        }

        .doc-testimonialsslider.owl-carousel .owl-nav div.owl-prev {
            color: #fff;
            position: absolute;
            right: 80%;
            top: 43%;
            right: 112%;
        }

        .doc-testimonialsslider.owl-carousel .owl-nav div.owl-next {
            top: 0;
            right: 0;
            left: auto;
            color: #434343;
            border-color: #434343;
            position: absolute;
            top: 52%;
            left: 112%;
        }

        @media (min-width: 481px) and (max-width: 767px) {
            .doc-testimonialsslider.owl-carousel .owl-nav div.owl-prev {
                color: #fff;
                position: absolute;
                right: 80%;
                top: 60%;
                right: 91%;

            }

            .doc-testimonialsslider.owl-carousel .owl-nav div.owl-next {
                right: 0;
                left: auto;
                color: #434343;
                border-color: #434343;
                position: absolute;
                top: 64%;
                left: 91%;
            }
        }

        @media (min-width: 320px) and (max-width: 480px) {

            .doc-testimonialsslider.owl-carousel .owl-nav div.owl-prev {
                color: #fff;
                position: absolute;
                right: 80%;
                top: 62%;
                right: 87%;

            }

            .doc-testimonialsslider.owl-carousel .owl-nav div.owl-next {
                right: 0;
                left: auto;
                color: #434343;
                border-color: #434343;
                position: absolute;
                top: 64%;
                left: 87%;
            }

        }

    </style>
    <script>
        jQuery(document).ready(function (e) {
            jQuery("#doc-testimonialsslider-<?php echo esc_attr($uniq_flag);?>").owlCarousel({
                items: 1,
                nav: true,
                rtl: <?php docdirect_owl_rtl_check();?>,
                loop: true,
                dots: false,
                autoplay: <?php echo esc_js($autoplay);?>,
                navText: ['<i class="doc-btnprev fa fa-angle-left"></i>', '<i class="doc-btnnext fa fa-angle-right"></i>'],
            });
        });
    </script>
</div>