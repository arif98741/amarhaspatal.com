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
        width: 73% !important;
        margin-left: auto;
        min-height: 500px;
        border: 4px solid #000 !important;
        background: #fff;
        opacity: 0.3;
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
                    <div class="col-sm-12 col-xs-offset-0 col-xs-12">
                        <form class="doc-formtheme doc-formadvancesearch" action="<?php echo esc_url($search_page); ?>"
                              method="get">
                            <div id="doc-homecatagoryslider-<?php echo esc_attr($flagslider); ?>"
                                 class="doc-homecatagoryslider owl-carousel">
                                <?php
                                $directories = array();
                                $first_category = '';
                                $json = array();
                                $flag = false;
                                if (isset($cust_query) && !empty($cust_query)) {
                                    $counter = 0;
                                    foreach ($cust_query as $key => $dir) {
                                        $counter++;
                                        $title = get_the_title($dir->ID);
                                        $checked = '';
                                        $active = '';
                                        if ($counter === 1) {
                                            $current_directory = get_the_title($dir->ID);
                                            $active = 'active';
                                            $first_category = $dir->ID;
                                            $checked = 'checked';
                                        }
                                        //Prepare categories
                                        if (isset($dir->ID)) {
                                            $attached_specialities = get_post_meta($dir->ID, 'attached_specialities', true);
                                            $subarray = array();
                                            if (isset($attached_specialities) && !empty($attached_specialities)) {
                                                foreach ($attached_specialities as $key => $speciality) {
                                                    if (!empty($speciality)) {
                                                        $term_data = get_term_by('id', $speciality, 'specialities');
                                                        if (!empty($term_data)) {
                                                            $subarray[$term_data->slug] = $term_data->name;
                                                        }
                                                    }
                                                }
                                            }
                                            $json[$dir->ID] = $subarray;
                                        }
                                        $parent_categories['categories'] = $json;
                                        ?>

                                    <?php }
                                } else {
                                    $directories['status'] = 'empty';
                                } ?>
                            </div>


                            <div class="doc-bannersearcharea">

                                <div class="form-group">
                                    <label>Name</label>
                                </div>

                            </div>
                        </form>
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

