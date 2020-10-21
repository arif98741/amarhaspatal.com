<?php
/**
 * Map Search Postion Top
 * return html
 */

global $current_user, $wp_roles, $userdata, $post;
get_header();

if (function_exists('fw_get_db_settings_option')) {
    $search_page_map = fw_get_db_settings_option('search_page_map');
    $dir_map_marker_default = fw_get_db_settings_option('dir_map_marker');
    $google_key = fw_get_db_settings_option('google_key');
} else {
    $google_key = '';
    $dir_map_marker_default = '';
    $google_key = '';
}

docdirect_init_dir_map();//init Map
docdirect_enque_map_library();//init Map

//Search center point
$direction = docdirect_get_location_lat_long();
$show_users = !empty($atts['show_users']) ? $atts['show_users'] : 10;

$directory_type = esc_html($_GET['directory_type']);

$division_id = isset($_GET['division_id']) ? esc_html($_GET['division_id']) : '';
$district_id = isset($_GET['district_id']) ? esc_html($_GET['district_id']) : '';
$upazila_id = isset($_GET['upazila_id']) ? esc_html($_GET['upazila_id']) : '';

if (!empty($directory_type)) {

    if (!empty($division_id) && !empty($district_id) && !empty($upazila_id)) {
        $meta_query = array(
            'relation' => 'AND',
            array(
                'key' => 'directory_type',
                'value' => $directory_type,
                'compare' => '='
            ),
            array(
                'key' => 'division_id',
                'value' => $division_id,
                'compare' => '='
            ),
            array(
                'key' => 'district_id',
                'value' => $district_id,
                'compare' => '='
            ),
            array(
                'key' => 'upazila_id',
                'value' => $upazila_id,
                'compare' => '='
            ),
        );
    } elseif (!empty($division_id) && !empty($district_id)) {

        $meta_query = array(
            'relation' => 'AND',
            array(
                'key' => 'directory_type',
                'value' => $directory_type,
                'compare' => '='
            ),
            array(
                'key' => 'division_id',
                'value' => $division_id,
                'compare' => '='
            ),
            array(
                'key' => 'district_id',
                'value' => $district_id,
                'compare' => '='
            )
        );
    } else {

        $meta_query = array(
            'relation' => 'AND',
            array(
                'key' => 'directory_type',
                'value' => $directory_type,
                'compare' => '='
            ),
        );
    }


} else {

    $meta_query = array(
        'relation' => 'OR',
        array(
            'key' => 'user_profile_specialities',
            'value' => $search_key,
            'compare' => 'LIKE'
        ),
        array(
            'key' => 'division_id',
            'value' => $division_id,
            'compare' => 'LIKE'
        ),
        array(
            'key' => 'district_id',
            'value' => $district_id,
            'compare' => 'LIKE'
        ),
        array(
            'key' => 'upazila_id',
            'value' => $upazila_id,
            'compare' => 'LIKE'
        ),
        array(
            'key' => 'display_name',
            'value' => $search_key,
            'compare' => 'LIKE'
        )
    );
}

$paginationData = searchPagination($meta_query, 10);


$query_args = array(
    'order' => $order,
    'orderby' => 'display_name',
    'meta_query' => $meta_query,
    'number' => $paginationData['per_page'],
    'offset' => $paginationData['offset'],
);


$user_query = new WP_User_Query($query_args);

$total_users = !empty($user_query->total_users) ? $user_query->total_users : 0;
$found_title = docdirect_get_found_title($total_users, $directory_type);
global $Type;
if (isset($search_page_map) && $search_page_map === 'enable') {
    ?>

<?php } ?>


<!-- mostafiz -->

<div class="main-content container-fluid mslc">
    <div style="border: 1px solid #eee; padding: 8px;">
        <div style="background-image: url(<?php echo site_url(); ?>/wp-content/uploads/directory-list-banner/doctor.png);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center !important;
    height: 150px;
">
        </div>
    </div>
    <div class="text-center"></div>
    <main id="main" class="site-main" role="main">
        <section class="divider">

            <div class="row text-center row-c">
                <button type="text" class="btn btn-default btn-flat bt-new" data-toggle="modal"
                        data-target="#myModal">Search <?= $Type ?>
                </button>
            </div>
            <?php
            if ($paginationData['total_pages'] > 0) {

                foreach ($user_query->results as $key => $user) {


                    $directory_type = get_user_meta($user->ID, 'directory_type', true);
                    $dir_map_marker = fw_get_db_post_option($directory_type, 'dir_map_marker', true);
                    $reviews_switch = fw_get_db_post_option($directory_type, 'reviews', true);
                    $current_date = date('Y-m-d H:i:s');
                    $avatar = apply_filters(
                        'docdirect_get_user_avatar_filter',
                        docdirect_get_user_avatar(array('width' => 270, 'height' => 270), $user->ID),
                        array('width' => 270, 'height' => 270) //size width,height
                    );


                    $privacy = docdirect_get_privacy_settings($user->ID); //Privacy setting

                    $directories_array['fax'] = $user->fax;
                    $directories_array['description'] = $user->description;
                    $directories_array['title'] = $user->display_name;
                    $directories_array['name'] = $user->first_name . ' ' . $user->last_name;
                    $directories_array['user_nicename'] = $user->data->user_nicename;
                    $directories_array['email'] = $user->user_email;
                    $directories_array['phone_number'] = $user->phone_number;
                    $directories_array['address'] = $user->user_address;
                    $directories_array['car_no'] = $user->car_no;
                    $featured_string = docdirect_get_user_featured_date($user->ID);
                    $current_string = strtotime($current_date);
                    $review_data = docdirect_get_everage_rating($user->ID);
                    $get_username = docdirect_get_username($user->ID);


                    if (isset($dir_map_marker['url']) && !empty($dir_map_marker['url'])) {
                        $directories_array['icon'] = $dir_map_marker['url'];
                    } else {
                        if (!empty($dir_map_marker_default['url'])) {
                            $directories_array['icon'] = $dir_map_marker_default['url'];
                        } else {
                            $directories_array['icon'] = get_template_directory_uri() . '/images/map-marker.png';
                        }
                    }
                    ?>

                    <div class="container-fluid" style="padding-top: 30px; padding-bottom: 30px;">

                        <div class="col-md-3 user-profile-dir-list">

                            <?php if (empty($avatar)): ?>
                                <a href="<?php echo site_url(); ?>/doctor/<?php echo $directories_array['user_nicename']; ?>">
                                    <img src="<?php echo site_url(); ?>/wp-content/uploads/doctor/doctor_default.jpg"
                                         alt="<?= $directories_array['title'] . ' - ' . site_url(); ?>"/></a>
                            <?php else: ?>
                                <a href="<?php echo site_url(); ?>/doctor/<?php echo $directories_array['user_nicename']; ?>">
                                    <img src="<?= $avatar ?>"
                                         alt="<?= $directories_array['name'] . ' - ' . site_url(); ?>"/></a>
                            <?php endif; ?>

                        </div>
                        <div class="col-md-9 iiiii">

                            <a href="<?php echo site_url(); ?>/doctor/<?php echo $directories_array['user_nicename']; ?>">
                                <h3><?= ucfirst($directories_array['name']); ?></h3>
                            </a>
                            <p>
                                <i class="fa fa-graduation-cap fa-lg"
                                   style="margin-right: 12px; display: inline-block;"></i> <span
                                        style="color: #16518c;"><strong
                                            style="display: inline-flex;">

                                        MBBS (DU), DMU (Dhaka)</strong></span>
                            </p>
                            <p><i class="fa fa-certificate fa-lg" style="margin-right: 20px;"></i>Family Medicine</p>
                            <p><i class="fa fa-hospital-o fa-lg" style="margin-right: 20px;"></i><span
                                        style="display: inline-flex;">Health AID Service</span></p>
                            <p><i class="fa fa-money fa-lg" style="margin-right: 16px;"></i>New patient 500 BDT &amp;
                                Old&nbsp;patient
                                300 BDT</p>
                            <p><i class="fa fa-map-marker fa-lg" style="margin-right: 25px;"></i>
                                <?= (!empty($directories_array['address'])) ? ucfirst($directories_array['address']) : 'N/A'; ?>
                            </p>

                            <div class="a2a_kit a2a_kit_size_32 a2a_default_style"
                                 data-a2a-url="<?php echo site_url(); ?>/doctor/<?php echo $directories_array['user_nicename']; ?>"
                                 data-a2a-title="<?= ucfirst($directories_array['name']); ?>"
                                 style="line-height: 32px;">
                                <a class="a2a_dd"
                                   href="https://www.addtoany.com/share#url=<?php echo site_url(); ?>/doctor/<?php echo $directories_array['user_nicename']; ?>">
                            <span class="a2a_svg a2a_s__default a2a_s_a2a" style="background-color: #253e7f">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 32 32">
                                    <g fill="#FFF">
                                        <path d="M14 7h4v18h-4z"></path>
                                        <path d="M7 14h18v4H7z"></path>
                                    </g>
                                </svg>
                            </span>
                                    <span class="a2a_label a2a_localize" data-a2a-localize="inner,Share">Share</span>
                                </a>
                                <a class="a2a_button_facebook" target="_blank" href="/#facebook"
                                   rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_facebook"
                                  style="background-color: #253e7f">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 32 32">
                                    <path
                                            fill="#FFF"
                                            d="M17.78 27.5V17.008h3.522l.527-4.09h-4.05v-2.61c0-1.182.33-1.99 2.023-1.99h2.166V4.66c-.375-.05-1.66-.16-3.155-.16-3.123 0-5.26 1.905-5.26 5.405v3.016h-3.53v4.09h3.53V27.5h4.223z"
                                    ></path>
                                </svg>
                            </span>
                                    <span class="a2a_label">Facebook</span>
                                </a>
                                <a class="a2a_button_twitter" target="_blank" href="/#twitter" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_twitter"
                                  style="background-color: #253e7f">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 32 32">
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

                            <br/>
                            <a href="<?php echo site_url(); ?>/doctor/<?php echo $directories_array['user_nicename']; ?>"
                               class="btn btn-default btn-flat bt-new">View Profile</a>
                        </div>
                    </div>


                <?php } ?>
                <nav>
                    <ul class="pagination theme-colored">
                        <?php if ($paginationData['page'] > 1): ?>
                            <li>
                                <a href="<?= site_url(); ?>/dir-search/<?= ($paginationData['page'] - 1); ?>/?directory_type=<?= $directory_type ?>">
                                    <span aria-hidden="true">«</span> </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $paginationData['total_pages']; $i++) { ?>

                            <li class="<?php ($paginationData['page'] == $i) ? active : '' ?>">
                                <a href="<?= site_url(); ?>/dir-search/<?= $i; ?>/?directory_type=<?= $directory_type ?>"><?php echo $i; ?></a>
                            </li>
                        <?php } ?>

                        <?php if ($paginationData['total_pages'] != $paginationData['page']): ?>
                            <li>
                                <a href="<?= site_url(); ?>/dir-search/<?= ($paginationData['page'] + 1); ?>/?directory_type=<?= $directory_type ?>">
                                    <span aria-hidden="true">»</span> </a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </nav>
            <?php } else {

                $noFoundMessage = 'No ' . $Type . ' Found';
                echo '<h4 class="text-center alert alert-warning">' . $noFoundMessage . '</h4>';
                ?>

            <?php } ?>

        </section>
    </main>


    <!--        modal for search start-->

    <div class="modal fade ng-scope search-modal" id="myModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true" ng-controller="searchCtrl">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search Doctor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="search_box"
                         style="position: relative; width: 100%; margin-bottom: 0; height: auto;">
                        <form action="<?php echo site_url(); ?>/doctors"
                              class="avd_search ng-pristine ng-valid ng-valid-required" method="GET">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group" ng-init="country = 'Bangladesh'">
                                        <label for="country">Country</label>
                                        <select ng-model="country" name="country"
                                                class="form-control ng-pristine ng-valid ng-valid-required"
                                                required="">
                                            <option ng-repeat="(countryName, countryObj) in countries"
                                                    value="Bangladesh" selected="" class="ng-binding ng-scope">
                                                Bangladesh
                                            </option>
                                            <!-- end ngRepeat: (countryName, countryObj) in countries -->
                                            <option ng-repeat="(countryName, countryObj) in countries" value="India"
                                                    selected="" class="ng-binding ng-scope">India
                                            </option>
                                            <!-- end ngRepeat: (countryName, countryObj) in countries -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group" ng-init="city = '0'">
                                        <label for="city">City</label>
                                        <select name="city" ng-model="city"
                                                class="form-control ng-pristine ng-valid ng-valid-required"
                                                required="">
                                            <option value="0">Select City</option>
                                            <!-- ngRepeat: (cityName, cityObj) in countries[country].cities -->
                                            <option ng-repeat="(cityName, cityObj) in countries[country].cities"
                                                    value="Chittagong" class="ng-binding ng-scope">Chittagong
                                            </option>
                                            <!-- end ngRepeat: (cityName, cityObj) in countries[country].cities -->
                                            <option ng-repeat="(cityName, cityObj) in countries[country].cities"
                                                    value="Dhaka" class="ng-binding ng-scope">Dhaka
                                            </option>
                                            <!-- end ngRepeat: (cityName, cityObj) in countries[country].cities -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group" ng-init="area = '0'">
                                        <label for="area">Area</label>
                                        <select ng-model="area" name="area"
                                                class="form-control ng-pristine ng-valid">
                                            <option value="0">Select Area</option>
                                            <!-- ngRepeat: areaName in countries[country].cities[city].areas -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6" ng-init="service = 'doctors'">
                                    <div class="form-group" ng-init="speciality = '0'">
                                        <label for="speciality">Speciality</label>
                                        <select ng-model="speciality" name="speciality"
                                                class="form-control ng-pristine ng-valid ng-valid-required"
                                                required="">
                                            <option value="0">Select Speciality</option>
                                            <!-- ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Anesthesia Department" class="ng-binding ng-scope">
                                                Anesthesia Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Arthritis Department" class="ng-binding ng-scope">
                                                Arthritis Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Burn, Plastic, Cosmetic Department"
                                                    class="ng-binding ng-scope">Burn, Plastic, Cosmetic Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Cancer Department" class="ng-binding ng-scope">Cancer
                                                Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Cardiology Department" class="ng-binding ng-scope">
                                                Cardiology Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Chest Department" class="ng-binding ng-scope">Chest
                                                Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Child Department" class="ng-binding ng-scope">Child
                                                Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Colorectal Surgeon" class="ng-binding ng-scope">
                                                Colorectal Surgeon
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Dental Department" class="ng-binding ng-scope">Dental
                                                Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Diabetes Department" class="ng-binding ng-scope">Diabetes
                                                Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Digestive System Department" class="ng-binding ng-scope">
                                                Digestive System Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="ENT Department" class="ng-binding ng-scope">ENT
                                                Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Endocrinology Department" class="ng-binding ng-scope">
                                                Endocrinology Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Eye Department" class="ng-binding ng-scope">Eye
                                                Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Gastroentrology Department" class="ng-binding ng-scope">
                                                Gastroentrology Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="General-Laparoscopy Department"
                                                    class="ng-binding ng-scope">General-Laparoscopy Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Gynaecology-Obstetrics Department"
                                                    class="ng-binding ng-scope">Gynaecology-Obstetrics Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Heart Disease Department" class="ng-binding ng-scope">
                                                Heart Disease Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Hematology Department" class="ng-binding ng-scope">
                                                Hematology Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Hepatology Department" class="ng-binding ng-scope">
                                                Hepatology Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Immunology Department" class="ng-binding ng-scope">
                                                Immunology Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Internal Medicine Department"
                                                    class="ng-binding ng-scope">Internal Medicine Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Medicine Department" class="ng-binding ng-scope">Medicine
                                                Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Neonatology Department" class="ng-binding ng-scope">
                                                Neonatology Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Nephrology Department" class="ng-binding ng-scope">
                                                Nephrology Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Neurology Department" class="ng-binding ng-scope">
                                                Neurology Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Neuromedicine Department" class="ng-binding ng-scope">
                                                Neuromedicine Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Neurosurgery Department" class="ng-binding ng-scope">
                                                Neurosurgery Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Nutrition Department" class="ng-binding ng-scope">
                                                Nutrition Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Oncology Department" class="ng-binding ng-scope">Oncology
                                                Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Orthopedics Department" class="ng-binding ng-scope">
                                                Orthopedics Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Pathology, Imaging Department"
                                                    class="ng-binding ng-scope">Pathology, Imaging Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Pediatric Surgery Department"
                                                    class="ng-binding ng-scope">Pediatric Surgery Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Pediatrics Department" class="ng-binding ng-scope">
                                                Pediatrics Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Physiotherapy Department" class="ng-binding ng-scope">
                                                Physiotherapy Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Plastic Surgery Department" class="ng-binding ng-scope">
                                                Plastic Surgery Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Psychiatry Department" class="ng-binding ng-scope">
                                                Psychiatry Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Pulmonary Department" class="ng-binding ng-scope">
                                                Pulmonary Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Radiology Department" class="ng-binding ng-scope">
                                                Radiology Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Respiratory Medicine Department"
                                                    class="ng-binding ng-scope">Respiratory Medicine Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Rheumatology Department" class="ng-binding ng-scope">
                                                Rheumatology Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Skin, Sex Department" class="ng-binding ng-scope">Skin,
                                                Sex Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Sonology Department" class="ng-binding ng-scope">Sonology
                                                Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Surgery Department" class="ng-binding ng-scope">Surgery
                                                Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Thoracic Surgery Department" class="ng-binding ng-scope">
                                                Thoracic Surgery Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Urology Department" class="ng-binding ng-scope">Urology
                                                Department
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities"
                                                    value="Vascular Surgery" class="ng-binding ng-scope">Vascular
                                                Surgery
                                            </option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal"
                            ng-click="loadResult(country, city, area, speciality,'doctors');">Search
                    </button>
                </div>
            </div>
        </div>
    </div><!--        modal for search end-->

    <div id="searchLoader"
         style="position: fixed; left: 0; top: 0; width: 100%; height: 100%; background: url(<?php echo site_url(); ?>/wp-content/themes/hasbd/images/loading.gif) no-repeat center center; background-color: rgba(0, 0, 0, 0.56); display: none;"
    ></div>
    <div class="text-center"></div>
</div>




<!-- mostafiz -->
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
<?php
get_footer(); ?>
