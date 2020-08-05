<?php
if (!defined('FW')) {
    die('Forbidden');
}
/**
 * @var $atts
 */
$uni_flag = fw_unique_increment();

$args = array('posts_per_page' => '-1',
    'post_type' => 'directory_type',
    'post_status' => 'publish',
    'suppress_filters' => false
);


$cust_query = get_posts($args);
docdirect_init_dir_map();//init Map
docdirect_enque_map_library();//init Map
$dir_search_page = fw_get_db_settings_option('dir_search_page');


if (isset($dir_search_page[0]) && !empty($dir_search_page[0])) {
    $search_page = get_permalink((int)$dir_search_page[0]);
} else {
    $search_page = '';
}

if (function_exists('fw_get_db_settings_option')) {
    $dir_keywords = fw_get_db_settings_option('dir_keywords');
    $zip_code_search = fw_get_db_settings_option('zip_code_search');
    $dir_location = fw_get_db_settings_option('dir_location');
    $dir_radius = fw_get_db_settings_option('dir_radius');
    $dir_geo = fw_get_db_settings_option('dir_geo');
    $language_search = fw_get_db_settings_option('language_search');
    $dir_search_cities = fw_get_db_settings_option('dir_search_cities');
    $dir_search_insurance = fw_get_db_settings_option('dir_search_insurance');
    $dir_phote = fw_get_db_settings_option('dir_phote');

    $dir_latitude = fw_get_db_settings_option('dir_latitude');
    $dir_latitude = fw_get_db_settings_option('dir_latitude');
    $dir_longitude = !empty($dir_longitude) ? $dir_longitude : '-0.1262362';
    $dir_latitude = !empty($dir_latitude) ? $dir_latitude : '51.5001524';
} else {
    $dir_keywords = '';
    $zip_code_search = '';
    $dir_location = '';
    $dir_radius = '';
    $language_search = '';
    $dir_search_cities = '';
    $dir_geo = '';

    $dir_longitude = '-0.1262362';
    $dir_latitude = '51.5001524';
}
$flagslider = rand(1, 9999);

$languages_array = docdirect_prepare_languages();//Get Language Array

$banner_class = 'doc-bannercontent';
if (empty($atts['bg']['url'])) {
    $banner_class = 'doc-bannercontent-without';
}

$isadvance_filter = 'advance-filter-disabled';
if (!empty($atts['advance_filters']) && $atts['advance_filters'] === 'enable') {
    $isadvance_filter = 'advance-filter-enabled';
}
?>
<div id="doc-homebannerslider-<?php echo esc_attr($uni_flag); ?>"
     class="doc-homebannerslider doc-haslayout <?php echo esc_attr($isadvance_filter); ?>">
    <figure class="doc-bannerimg">
        <?php if (!empty($atts['bg']['url'])) { ?>

            <img src="<?php echo esc_url($atts['bg']['url']); ?>"
                 alt="<?php esc_html_e('Search Filters', 'docdirect'); ?>">
        <?php } ?>
        <figcaption class="<?php echo esc_attr($banner_class); ?>">
            <div class="container">
                <div class="row" id="search-div-carousal">
                    <div class="col-sm-12 col-xs-offset-0 col-xs-12">
                        <div class="search_box" style="height: 400px;margin-bottom: 50px;">
                            <form ng-controller="searchCtrl" action="<?php echo site_url('dir-search') ?>"
                                  class="avd_search ng-scope ng-pristine ng-valid ng-valid-required" method="GET">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="country">
                                                DIVISION</label>
                                            <select name="division_id" class="division_id "
                                                    class="form-control ">
                                                <option value="">SELECT DIVISION</option>
                                                <?php
                                                global $wpdb;
                                                $divisionSql = "select id, title,title_en from loc_divisions where status='1'";
                                                $divisions = $wpdb->get_results($divisionSql);

                                                ?>
                                                <?php foreach ($divisions as $division) { ?>

                                                    <option value="<?= $division->id; ?>"><?= $division->title_en ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group" ng-init="city = '0'">
                                            <label for="city">DISTRICT</label>
                                            <select name="district_id" class="district_id "
                                                    class="form-control select2">
                                                <option value="">SELECT DISTRICT</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group" ng-init="city = '0'">
                                            <label for="city">UPAZILA</label>
                                            <select name="upazila_id" class="upazila_id "
                                                    class="form-control  select2">
                                                <option value="">SELECT UPAZILA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group" ng-init="city = '0'">
                                            <label for="city">SERVICE</label>
                                            <select name="directory_type" class=" directory_type_dropdown"
                                                    style="text-transform: uppercase !important;">

                                                <option value="" selected>SELECT SERVICE</option>
                                                <option value="123">AMBULANCE</option>
                                                <option value="122">BLOOD DONOR</option>
                                                <option value="121">DIAGONOSTICS</option>
                                                <option value="127">DOCTOR</option>
                                                <option value="126">HOSPITAL</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="service" class="speciality_label">SPECIALITY</label>
                                            <select name="speciality" class="speciality_dropdown"
                                                    class="form-control select2">
                                                <option value="">SELECT SPECIALITY</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-offset-5">
                                    <button type="submit"
                                            class="btn btn-default search-btn-front">Search
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </figcaption>
    </figure>
    <?php if (!empty($atts['background_color'])) { ?>
        <style>#doc-homebannerslider-<?php echo esc_attr( $uni_flag );?> .doc-bannerimg:after {
                background: <?php echo esc_attr($atts['background_color']);?>;
            }</style>
    <?php } ?>
    <style>
        .division_id, .district_id, .upazila_id {
            text-transform: uppercase;
        }

        .division_id option,
        .district_id option,
        .upazila_id option,
        .district_id option,
        .directory_type_dropdown option,
        .speciality_dropdown option {
            font-weight: bold;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaa;
            border-radius: 4px;
            height: 40px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #888 transparent transparent transparent;
            border-style: solid;
            border-width: 5px 4px 0 4px;
            height: 0;
            left: 50%;
            margin-left: -4px;
            margin-top: 6px !important;
            position: absolute;
            top: 50%;
            width: 0;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 22px;
        }

    </style>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        jQuery(document).ready(function () {
            jQuery('.select2').select2();
        });
    </script>
</div>

