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
<style>
    #search-div-carousal {
        width: 46% !important;
        margin-left: auto;
        min-height: 358px;
        border: 4px solid #3a76a324 !important;
        background: #fff;
        padding: 10px;
        height: 420px;
    }

    @media (min-width: 481px) and (max-width: 767px) {

        #search-div-carousal {
            width: 100% !important;
            margin: 0 auto;
            min-height: 398px;
            border: 4px solid #3a76a324 !important;
            background: #fff;
            padding: 10px;
            height: 490px;
        }
    }

    @media (min-width: 320px) and (max-width: 480px) {

        #search-div-carousal {
            width: 100% !important;
            margin: 0 auto;
            min-height: 398px;
            border: 4px solid #3a76a324 !important;
            background: #fff;
            padding: 10px;
            height: 490px;
        }
    }


</style>
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
                    <div class="col-sm-12 col-xs-offset-0 col-xs-12" style="padding: 25px;">
                        <div class="search_box" style="height: 400px;margin-bottom: 50px;">
                            <form ng-controller="searchCtrl" action="<?php echo site_url('dir-search') ?>"
                                  class="avd_search ng-scope ng-pristine ng-valid ng-valid-required" method="GET">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group" ng-init="country = 'Bangladesh'">
                                            <label for="country">Division</label>
                                            <select name="division_id" id="division_id_temp" class="form-control">
                                                <option>Selects Division</option>
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
                                            <label for="city">District</label>
                                            <select name="district_id" id="district_id_temp" class="form-control">
                                                <option value="">Select District</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group" ng-init="city = '0'">
                                            <label for="city">Upazila</label>
                                            <select name="upazila_id" id="upazila_id_temp" class="form-control">
                                                <option>Select Upazila</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group" ng-init="city = '0'">
                                            <label for="city">Service</label>
                                            <select name="directory_type" id="directory_type_dropdown">

                                                <option value="0" selected>Select Service</option>
                                                <option value="123">Ambulance</option>
                                                <option value="122">Blood Donor</option>
                                                <option value="121">Diagnostics</option>
                                                <option value="127">Doctor</option>
                                                <option value="126">Hospital</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="service">Speciality</label>
                                            <input class="form-control" name="search_key">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-offset-5">
                                    <button type="submit"
                                            class="btn btn-default">Search
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
</div>

