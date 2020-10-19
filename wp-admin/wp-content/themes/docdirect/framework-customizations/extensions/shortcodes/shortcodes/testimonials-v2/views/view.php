<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
$uniq_flag = fw_unique_increment();
$autoplay = !empty($atts['auto']) ? $atts['auto'] : 'false';

$query_args = array(
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'directory_type',
            'value' => 127,
            'compare' => '='
        )
    )
);
$user_query = new WP_User_Query($query_args);


?>



<!-- mostafiz -->
<section
    class="divider parallax layer-overlay overlay-theme-colored-9"
    data-bg-img="#"
    data-parallax-ratio="0.7"
     background-position: 50% 21px;"
>
    <div class="container pt-60 pb-60">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 mb-md-50">
                <div class="funfact text-center">
                    <i class="fa fa-smile-o" aria-hidden="true" style="color: #253e7f;"></i>
                    <h2 data-animation-duration="2000" data-value="12977" class="animate-number text-white font-42 font-weight-500 appeared">8585</h2>
                    <h5 class="text-white text-uppercase font-weight-600">Satisfied Client</h5>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 mb-md-50">
                <div class="funfact text-center">
                    <i class="fa fa-ambulance" aria-hidden="true" style="color: #253e7f;"></i>
                    <h2 data-animation-duration="2000" data-value="2984" class="animate-number text-white font-42 font-weight-500 appeared">2,984</h2>
                    <h5 class="text-white text-uppercase font-weight-600">served to people</h5>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 mb-md-50">
                <div class="funfact text-center">
                    <i class="fa fa-hospital-o" aria-hidden="true" style="color: #253e7f;"></i>
                    <h2 data-animation-duration="2000" data-value="130" class="animate-number text-white font-42 font-weight-500 appeared">130</h2>
                    <h5 class="text-white text-uppercase font-weight-600">hospital sign up</h5>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 mb-md-50">
                <div class="funfact text-center">
                    <i class="fa fa-user-md" aria-hidden="true" style="color: #253e7f;"></i>
                    <h2 data-animation-duration="2000" data-value="3696" class="animate-number text-white font-42 font-weight-500 appeared">3,696</h2>
                    <h5 class="text-white text-uppercase font-weight-600">doctors register</h5>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- mostafiz -->
