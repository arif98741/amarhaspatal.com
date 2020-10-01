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

/*$query_args = array(
    'role' => 'professional',
    'count_total' => true,
    'order' => 'ASC',
    'number' => $show_users,
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'loc_division_id',
            'value' => '5',
            'compare' => '='
        ),
        array(
            'key' => 'loc_district_id',
            'value' => 58,
            'compare' => '='
        )
    )
);*/
$directory_type = esc_html($_GET['directory_type']);
$search_key = esc_html($_GET['search_key']);
$division_id = esc_html($_GET['division_id']);
$district_id = esc_html($_GET['district_id']);
$upazila_id = esc_html($_GET['upazila_id']);

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
            array(
                'key' => 'username',
                'value' => $search_key,
                'compare' => 'LIKE'
            )
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

$order = 'ASC';
if (isset($_GET)) {
    $order = esc_html($_GET['order']);
}

$query_args = array(
    'number' => 15,
    'order' => $order,
    'orderby' => 'display_name',
    'meta_query' => $meta_query

);


//query
$user_query = new WP_User_Query($query_args);


$total_users = !empty($user_query->total_users) ? $user_query->total_users : 0;
$found_title = docdirect_get_found_title($total_users, $directory_type);

if (isset($search_page_map) && $search_page_map === 'enable') {
    ?>

    
<?php } ?>
   

 



    <!-- mostafiz -->
    <div class="main-content container">
        <div style="border: 1px solid #eee; padding: 8px;">
         <div style="background-image: url(https://amarhaspatal.com/wp-content/uploads/directory-list-banner/doctor.png);
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
                <button type="text" class="btn btn-default btn-flat bt-new" data-toggle="modal" data-target="#myModal">Search Doctor</button>
            </div>
            <div class="container-fluid" style="padding-top: 30px; padding-bottom: 30px;">
                <div class="col-md-3">
                    <a href="https://hasbd.com/doctors/dr-merana-sultana/"> <img src="https://hasbd.com/wp-content/themes/hasbd/images/doctor-female.jpg" alt="" /></a>
                </div>
                <div class="col-md-9 iiiii">
                    <a href="https://hasbd.com/doctors/dr-merana-sultana/"><h3>Dr. Merana Sultana</h3></a>
                    <p>
                        <i class="fa fa-graduation-cap fa-lg" style="margin-right: 12px; display: inline-block;"></i> <span style="color: #16518c;"><strong style="display: inline-flex;">MBBS (DU), DMU (Dhaka)</strong></span>
                    </p>
                    <p><i class="fa fa-certificate fa-lg" style="margin-right: 20px;"></i>Family Medicine</p>
                    <p><i class="fa fa-hospital-o fa-lg" style="margin-right: 20px;"></i><span style="display: inline-flex;">Health AID Service</span></p>
                    <p><i class="fa fa-map-marker fa-lg" style="margin-right: 25px;"></i>730/C, NG- 11, Shahid Baki Sarak, Khilgoan, Opposite of Sonali Bank</p>
                    <p><i class="fa fa-money fa-lg" style="margin-right: 16px;"></i>New patient 500 BDT &amp; Old&nbsp;patient 300 BDT</p>

                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="https://hasbd.com/doctors/dr-merana-sultana/" data-a2a-title="Dr. Merana Sultana" style="line-height: 32px;">
                        <a class="a2a_dd" href="https://www.addtoany.com/share#url=https%3A%2F%2Fhasbd.com%2Fdoctors%2Fdr-merana-sultana%2F&amp;title=Dr.%20Merana%20Sultana">
                            <span class="a2a_svg a2a_s__default a2a_s_a2a" style="background-color: rgb(1, 102, 255);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <g fill="#FFF">
                                        <path d="M14 7h4v18h-4z"></path>
                                        <path d="M7 14h18v4H7z"></path>
                                    </g>
                                </svg>
                            </span>
                            <span class="a2a_label a2a_localize" data-a2a-localize="inner,Share">Share</span>
                        </a>
                        <a class="a2a_button_facebook" target="_blank" href="/#facebook" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_facebook" style="background-color: rgb(24, 119, 242);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <path
                                        fill="#FFF"
                                        d="M17.78 27.5V17.008h3.522l.527-4.09h-4.05v-2.61c0-1.182.33-1.99 2.023-1.99h2.166V4.66c-.375-.05-1.66-.16-3.155-.16-3.123 0-5.26 1.905-5.26 5.405v3.016h-3.53v4.09h3.53V27.5h4.223z"
                                    ></path>
                                </svg>
                            </span>
                            <span class="a2a_label">Facebook</span>
                        </a>
                        <a class="a2a_button_twitter" target="_blank" href="/#twitter" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_twitter" style="background-color: rgb(85, 172, 238);">
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

                    <br />
                    <a href="https://hasbd.com/doctors/dr-merana-sultana/" class="btn btn-default btn-flat bt-new">View Profile</a>
                </div>
            </div>
            <div class="container-fluid" style="padding-top: 30px; padding-bottom: 30px;">
                <div class="col-md-3">
                    <a href="https://hasbd.com/doctors/assist-prof-dr-md-rashed-anwar/"> <img src="https://hasbd.com/wp-content/themes/hasbd/images/doctor.jpg" alt="" /></a>
                </div>
                <div class="col-md-9 iiiii">
                    <a href="https://hasbd.com/doctors/assist-prof-dr-md-rashed-anwar/"><h3>ASSIST. PROF. DR. MD. RASHED ANWAR</h3></a>
                    <p>
                        <i class="fa fa-graduation-cap fa-lg" style="margin-right: 12px; display: inline-block;"></i> <span style="color: #16518c;"><strong style="display: inline-flex;">MBBS, MD (Nephrology)</strong></span>
                    </p>
                    <p><i class="fa fa-certificate fa-lg" style="margin-right: 20px;"></i>Nephrologist</p>
                    <p><i class="fa fa-hospital-o fa-lg" style="margin-right: 20px;"></i><span style="display: inline-flex;">POPULAR DIAGNOSTIC CENTRE LTD | UTTARA BRANCH-02</span></p>
                    <p><i class="fa fa-map-marker fa-lg" style="margin-right: 25px;"></i>House # 25, Road # 7, Sector # 4, Jashim Uddin Moar, Uttara, Dhaka.</p>
                    <p><i class="fa fa-money fa-lg" style="margin-right: 16px;"></i>Will Be Published Soon</p>

                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="https://hasbd.com/doctors/assist-prof-dr-md-rashed-anwar/" data-a2a-title="ASSIST. PROF. DR. MD. RASHED ANWAR" style="line-height: 32px;">
                        <a class="a2a_dd" href="https://www.addtoany.com/share#url=https%3A%2F%2Fhasbd.com%2Fdoctors%2Fassist-prof-dr-md-rashed-anwar%2F&amp;title=ASSIST.%20PROF.%20DR.%20MD.%20RASHED%20ANWAR">
                            <span class="a2a_svg a2a_s__default a2a_s_a2a" style="background-color: rgb(1, 102, 255);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <g fill="#FFF">
                                        <path d="M14 7h4v18h-4z"></path>
                                        <path d="M7 14h18v4H7z"></path>
                                    </g>
                                </svg>
                            </span>
                            <span class="a2a_label a2a_localize" data-a2a-localize="inner,Share">Share</span>
                        </a>
                        <a class="a2a_button_facebook" target="_blank" href="/#facebook" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_facebook" style="background-color: rgb(24, 119, 242);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <path
                                        fill="#FFF"
                                        d="M17.78 27.5V17.008h3.522l.527-4.09h-4.05v-2.61c0-1.182.33-1.99 2.023-1.99h2.166V4.66c-.375-.05-1.66-.16-3.155-.16-3.123 0-5.26 1.905-5.26 5.405v3.016h-3.53v4.09h3.53V27.5h4.223z"
                                    ></path>
                                </svg>
                            </span>
                            <span class="a2a_label">Facebook</span>
                        </a>
                        <a class="a2a_button_twitter" target="_blank" href="/#twitter" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_twitter" style="background-color: rgb(85, 172, 238);">
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

                    <br />
                    <a href="https://hasbd.com/doctors/assist-prof-dr-md-rashed-anwar/" class="btn btn-default btn-flat bt-new">View Profile</a>
                </div>
            </div>
            <div class="container-fluid" style="padding-top: 30px; padding-bottom: 30px;">
                <div class="col-md-3">
                    <a href="https://hasbd.com/doctors/prof-dr-brig-md-habibur-rahman-retd/"> <img src="https://hasbd.com/wp-content/themes/hasbd/images/doctor.jpg" alt="" /></a>
                </div>
                <div class="col-md-9 iiiii">
                    <a href="https://hasbd.com/doctors/prof-dr-brig-md-habibur-rahman-retd/"><h3>PROF. DR. BRIG. MD. HABIBUR RAHMAN (RETD)</h3></a>
                    <p>
                        <i class="fa fa-graduation-cap fa-lg" style="margin-right: 12px; display: inline-block;"></i> <span style="color: #16518c;"><strong style="display: inline-flex;">MBBS, FCPS (Psychiatry)</strong></span>
                    </p>
                    <p><i class="fa fa-certificate fa-lg" style="margin-right: 20px;"></i>Psychiatrist</p>
                    <p><i class="fa fa-hospital-o fa-lg" style="margin-right: 20px;"></i><span style="display: inline-flex;">POPULAR DIAGNOSTIC CENTRE LTD | UTTARA BRANCH-02</span></p>
                    <p><i class="fa fa-map-marker fa-lg" style="margin-right: 25px;"></i>House # 25, Road # 7, Sector # 4, Jashim Uddin Moar, Uttara, Dhaka.</p>
                    <p><i class="fa fa-money fa-lg" style="margin-right: 16px;"></i>Will Be Published Soon</p>

                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="https://hasbd.com/doctors/prof-dr-brig-md-habibur-rahman-retd/" data-a2a-title="PROF. DR. BRIG. MD. HABIBUR RAHMAN (RETD)" style="line-height: 32px;">
                        <a class="a2a_dd" href="https://www.addtoany.com/share#url=https%3A%2F%2Fhasbd.com%2Fdoctors%2Fprof-dr-brig-md-habibur-rahman-retd%2F&amp;title=PROF.%20DR.%20BRIG.%20MD.%20HABIBUR%20RAHMAN%20(RETD)">
                            <span class="a2a_svg a2a_s__default a2a_s_a2a" style="background-color: rgb(1, 102, 255);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <g fill="#FFF">
                                        <path d="M14 7h4v18h-4z"></path>
                                        <path d="M7 14h18v4H7z"></path>
                                    </g>
                                </svg>
                            </span>
                            <span class="a2a_label a2a_localize" data-a2a-localize="inner,Share">Share</span>
                        </a>
                        <a class="a2a_button_facebook" target="_blank" href="/#facebook" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_facebook" style="background-color: rgb(24, 119, 242);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <path
                                        fill="#FFF"
                                        d="M17.78 27.5V17.008h3.522l.527-4.09h-4.05v-2.61c0-1.182.33-1.99 2.023-1.99h2.166V4.66c-.375-.05-1.66-.16-3.155-.16-3.123 0-5.26 1.905-5.26 5.405v3.016h-3.53v4.09h3.53V27.5h4.223z"
                                    ></path>
                                </svg>
                            </span>
                            <span class="a2a_label">Facebook</span>
                        </a>
                        <a class="a2a_button_twitter" target="_blank" href="/#twitter" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_twitter" style="background-color: rgb(85, 172, 238);">
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

                    <br />
                    <a href="https://hasbd.com/doctors/prof-dr-brig-md-habibur-rahman-retd/" class="btn btn-default btn-flat bt-new">View Profile</a>
                </div>
            </div>
            <div class="container-fluid" style="padding-top: 30px; padding-bottom: 30px;">
                <div class="col-md-3">
                    <a href="https://hasbd.com/doctors/prof-dr-debashis-biswas/"> <img src="https://hasbd.com/wp-content/themes/hasbd/images/doctor.jpg" alt="" /></a>
                </div>
                <div class="col-md-9 iiiii">
                    <a href="https://hasbd.com/doctors/prof-dr-debashis-biswas/"><h3>PROF. DR. DEBASHIS BISWAS</h3></a>
                    <p>
                        <i class="fa fa-graduation-cap fa-lg" style="margin-right: 12px; display: inline-block;"></i> <span style="color: #16518c;"><strong style="display: inline-flex;">MBBS. MCPS (Surgery), MS (Ortho)</strong></span>
                    </p>
                    <p><i class="fa fa-certificate fa-lg" style="margin-right: 20px;"></i>Orthopedics Specialist</p>
                    <p><i class="fa fa-hospital-o fa-lg" style="margin-right: 20px;"></i><span style="display: inline-flex;">POPULAR DIAGNOSTIC CENTRE LTD | UTTARA BRANCH-02</span></p>
                    <p><i class="fa fa-map-marker fa-lg" style="margin-right: 25px;"></i>House # 25, Road # 7, Sector # 4, Jashim Uddin Moar, Uttara, Dhaka.</p>
                    <p><i class="fa fa-money fa-lg" style="margin-right: 16px;"></i>Will Be Published Soon</p>

                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="https://hasbd.com/doctors/prof-dr-debashis-biswas/" data-a2a-title="PROF. DR. DEBASHIS BISWAS" style="line-height: 32px;">
                        <a class="a2a_dd" href="https://www.addtoany.com/share#url=https%3A%2F%2Fhasbd.com%2Fdoctors%2Fprof-dr-debashis-biswas%2F&amp;title=PROF.%20DR.%20DEBASHIS%20BISWAS">
                            <span class="a2a_svg a2a_s__default a2a_s_a2a" style="background-color: rgb(1, 102, 255);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <g fill="#FFF">
                                        <path d="M14 7h4v18h-4z"></path>
                                        <path d="M7 14h18v4H7z"></path>
                                    </g>
                                </svg>
                            </span>
                            <span class="a2a_label a2a_localize" data-a2a-localize="inner,Share">Share</span>
                        </a>
                        <a class="a2a_button_facebook" target="_blank" href="/#facebook" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_facebook" style="background-color: rgb(24, 119, 242);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <path
                                        fill="#FFF"
                                        d="M17.78 27.5V17.008h3.522l.527-4.09h-4.05v-2.61c0-1.182.33-1.99 2.023-1.99h2.166V4.66c-.375-.05-1.66-.16-3.155-.16-3.123 0-5.26 1.905-5.26 5.405v3.016h-3.53v4.09h3.53V27.5h4.223z"
                                    ></path>
                                </svg>
                            </span>
                            <span class="a2a_label">Facebook</span>
                        </a>
                        <a class="a2a_button_twitter" target="_blank" href="/#twitter" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_twitter" style="background-color: rgb(85, 172, 238);">
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

                    <br />
                    <a href="https://hasbd.com/doctors/prof-dr-debashis-biswas/" class="btn btn-default btn-flat bt-new">View Profile</a>
                </div>
            </div>
            <div class="container-fluid" style="padding-top: 30px; padding-bottom: 30px;">
                <div class="col-md-3">
                    <a href="https://hasbd.com/doctors/brigadier-general-dr-md-saydur-rahman-retd/"> <img src="https://hasbd.com/wp-content/themes/hasbd/images/doctor.jpg" alt="" /></a>
                </div>
                <div class="col-md-9 iiiii">
                    <a href="https://hasbd.com/doctors/brigadier-general-dr-md-saydur-rahman-retd/"><h3>BRIGADIER GENERAL DR. MD. SAYDUR RAHMAN (RETD)</h3></a>
                    <p>
                        <i class="fa fa-graduation-cap fa-lg" style="margin-right: 12px; display: inline-block;"></i>
                        <span style="color: #16518c;"><strong style="display: inline-flex;">MBBS (DU), FCPS (Medicine), OJT (Gstro), FACP (USA), FRCP (Glasgow)</strong></span>
                    </p>
                    <p><i class="fa fa-certificate fa-lg" style="margin-right: 20px;"></i>Gastroenterologist</p>
                    <p><i class="fa fa-hospital-o fa-lg" style="margin-right: 20px;"></i><span style="display: inline-flex;">POPULAR DIAGNOSTIC CENTRE LTD | UTTARA BRANCH-02</span></p>
                    <p><i class="fa fa-map-marker fa-lg" style="margin-right: 25px;"></i>House # 25, Road # 7, Sector # 4, Jashim Uddin Moar, Uttara, Dhaka.</p>
                    <p><i class="fa fa-money fa-lg" style="margin-right: 16px;"></i>Will Be Published Soon</p>

                    <div
                        class="a2a_kit a2a_kit_size_32 a2a_default_style"
                        data-a2a-url="https://hasbd.com/doctors/brigadier-general-dr-md-saydur-rahman-retd/"
                        data-a2a-title="BRIGADIER GENERAL DR. MD. SAYDUR RAHMAN (RETD)"
                        style="line-height: 32px;"
                    >
                        <a class="a2a_dd" href="https://www.addtoany.com/share#url=https%3A%2F%2Fhasbd.com%2Fdoctors%2Fbrigadier-general-dr-md-saydur-rahman-retd%2F&amp;title=BRIGADIER%20GENERAL%20DR.%20MD.%20SAYDUR%20RAHMAN%20(RETD)">
                            <span class="a2a_svg a2a_s__default a2a_s_a2a" style="background-color: rgb(1, 102, 255);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <g fill="#FFF">
                                        <path d="M14 7h4v18h-4z"></path>
                                        <path d="M7 14h18v4H7z"></path>
                                    </g>
                                </svg>
                            </span>
                            <span class="a2a_label a2a_localize" data-a2a-localize="inner,Share">Share</span>
                        </a>
                        <a class="a2a_button_facebook" target="_blank" href="/#facebook" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_facebook" style="background-color: rgb(24, 119, 242);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <path
                                        fill="#FFF"
                                        d="M17.78 27.5V17.008h3.522l.527-4.09h-4.05v-2.61c0-1.182.33-1.99 2.023-1.99h2.166V4.66c-.375-.05-1.66-.16-3.155-.16-3.123 0-5.26 1.905-5.26 5.405v3.016h-3.53v4.09h3.53V27.5h4.223z"
                                    ></path>
                                </svg>
                            </span>
                            <span class="a2a_label">Facebook</span>
                        </a>
                        <a class="a2a_button_twitter" target="_blank" href="/#twitter" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_twitter" style="background-color: rgb(85, 172, 238);">
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

                    <br />
                    <a href="https://hasbd.com/doctors/brigadier-general-dr-md-saydur-rahman-retd/" class="btn btn-default btn-flat bt-new">View Profile</a>
                </div>
            </div>
            <div class="container-fluid" style="padding-top: 30px; padding-bottom: 30px;">
                <div class="col-md-3">
                    <a href="https://hasbd.com/doctors/professor-dr-faruque-ahmed/"> <img src="https://hasbd.com/wp-content/themes/hasbd/images/doctor.jpg" alt="" /></a>
                </div>
                <div class="col-md-9 iiiii">
                    <a href="https://hasbd.com/doctors/professor-dr-faruque-ahmed/"><h3>PROFESSOR (DR.) FARUQUE AHMED</h3></a>
                    <p>
                        <i class="fa fa-graduation-cap fa-lg" style="margin-right: 12px; display: inline-block;"></i>
                        <span style="color: #16518c;"><strong style="display: inline-flex;">MBBS, FCPS (Medi), FRCP (UK), MD (Gastro)</strong></span>
                    </p>
                    <p><i class="fa fa-certificate fa-lg" style="margin-right: 20px;"></i>Gastroenterologist</p>
                    <p><i class="fa fa-hospital-o fa-lg" style="margin-right: 20px;"></i><span style="display: inline-flex;">POPULAR DIAGNOSTIC CENTRE LTD | UTTARA BRANCH-02</span></p>
                    <p><i class="fa fa-map-marker fa-lg" style="margin-right: 25px;"></i>House # 25, Road # 7, Sector # 4, Jashim Uddin Moar, Uttara, Dhaka.</p>
                    <p><i class="fa fa-money fa-lg" style="margin-right: 16px;"></i>Will Be Published Soon</p>

                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="https://hasbd.com/doctors/professor-dr-faruque-ahmed/" data-a2a-title="PROFESSOR (DR.) FARUQUE AHMED" style="line-height: 32px;">
                        <a class="a2a_dd" href="https://www.addtoany.com/share#url=https%3A%2F%2Fhasbd.com%2Fdoctors%2Fprofessor-dr-faruque-ahmed%2F&amp;title=PROFESSOR%20(DR.)%20FARUQUE%20AHMED">
                            <span class="a2a_svg a2a_s__default a2a_s_a2a" style="background-color: rgb(1, 102, 255);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <g fill="#FFF">
                                        <path d="M14 7h4v18h-4z"></path>
                                        <path d="M7 14h18v4H7z"></path>
                                    </g>
                                </svg>
                            </span>
                            <span class="a2a_label a2a_localize" data-a2a-localize="inner,Share">Share</span>
                        </a>
                        <a class="a2a_button_facebook" target="_blank" href="/#facebook" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_facebook" style="background-color: rgb(24, 119, 242);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <path
                                        fill="#FFF"
                                        d="M17.78 27.5V17.008h3.522l.527-4.09h-4.05v-2.61c0-1.182.33-1.99 2.023-1.99h2.166V4.66c-.375-.05-1.66-.16-3.155-.16-3.123 0-5.26 1.905-5.26 5.405v3.016h-3.53v4.09h3.53V27.5h4.223z"
                                    ></path>
                                </svg>
                            </span>
                            <span class="a2a_label">Facebook</span>
                        </a>
                        <a class="a2a_button_twitter" target="_blank" href="/#twitter" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_twitter" style="background-color: rgb(85, 172, 238);">
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

                    <br />
                    <a href="https://hasbd.com/doctors/professor-dr-faruque-ahmed/" class="btn btn-default btn-flat bt-new">View Profile</a>
                </div>
            </div>
            <div class="container-fluid" style="padding-top: 30px; padding-bottom: 30px;">
                <div class="col-md-3">
                    <a href="https://hasbd.com/doctors/dr-lt-col-mohammad-delwar-hossain/"> <img src="https://hasbd.com/wp-content/themes/hasbd/images/doctor.jpg" alt="" /></a>
                </div>
                <div class="col-md-9 iiiii">
                    <a href="https://hasbd.com/doctors/dr-lt-col-mohammad-delwar-hossain/"><h3>DR. LT. COL. MOHAMMAD DELWAR HOSSAIN</h3></a>
                    <p>
                        <i class="fa fa-graduation-cap fa-lg" style="margin-right: 12px; display: inline-block;"></i> <span style="color: #16518c;"><strong style="display: inline-flex;">MBBS, FCPS (ENT), DLO, MCPS (ENT)</strong></span>
                    </p>
                    <p><i class="fa fa-certificate fa-lg" style="margin-right: 20px;"></i>Otolaryngologist [ENT]</p>
                    <p><i class="fa fa-hospital-o fa-lg" style="margin-right: 20px;"></i><span style="display: inline-flex;">POPULAR DIAGNOSTIC CENTRE LTD | UTTARA BRANCH-02</span></p>
                    <p><i class="fa fa-map-marker fa-lg" style="margin-right: 25px;"></i>House # 25, Road # 7, Sector # 4, Jashim Uddin Moar, Uttara, Dhaka.</p>
                    <p><i class="fa fa-money fa-lg" style="margin-right: 16px;"></i>Will Be Published Soon</p>

                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="https://hasbd.com/doctors/dr-lt-col-mohammad-delwar-hossain/" data-a2a-title="DR. LT. COL. MOHAMMAD DELWAR HOSSAIN" style="line-height: 32px;">
                        <a class="a2a_dd" href="https://www.addtoany.com/share#url=https%3A%2F%2Fhasbd.com%2Fdoctors%2Fdr-lt-col-mohammad-delwar-hossain%2F&amp;title=DR.%20LT.%20COL.%20MOHAMMAD%20DELWAR%20HOSSAIN">
                            <span class="a2a_svg a2a_s__default a2a_s_a2a" style="background-color: rgb(1, 102, 255);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <g fill="#FFF">
                                        <path d="M14 7h4v18h-4z"></path>
                                        <path d="M7 14h18v4H7z"></path>
                                    </g>
                                </svg>
                            </span>
                            <span class="a2a_label a2a_localize" data-a2a-localize="inner,Share">Share</span>
                        </a>
                        <a class="a2a_button_facebook" target="_blank" href="/#facebook" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_facebook" style="background-color: rgb(24, 119, 242);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <path
                                        fill="#FFF"
                                        d="M17.78 27.5V17.008h3.522l.527-4.09h-4.05v-2.61c0-1.182.33-1.99 2.023-1.99h2.166V4.66c-.375-.05-1.66-.16-3.155-.16-3.123 0-5.26 1.905-5.26 5.405v3.016h-3.53v4.09h3.53V27.5h4.223z"
                                    ></path>
                                </svg>
                            </span>
                            <span class="a2a_label">Facebook</span>
                        </a>
                        <a class="a2a_button_twitter" target="_blank" href="/#twitter" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_twitter" style="background-color: rgb(85, 172, 238);">
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

                    <br />
                    <a href="https://hasbd.com/doctors/dr-lt-col-mohammad-delwar-hossain/" class="btn btn-default btn-flat bt-new">View Profile</a>
                </div>
            </div>
            <div class="container-fluid" style="padding-top: 30px; padding-bottom: 30px;">
                <div class="col-md-3">
                    <a href="https://hasbd.com/doctors/prof-dr-ahmed-minhaz-shumon/"> <img src="https://hasbd.com/wp-content/themes/hasbd/images/doctor.jpg" alt="" /></a>
                </div>
                <div class="col-md-9 iiiii">
                    <a href="https://hasbd.com/doctors/prof-dr-ahmed-minhaz-shumon/"><h3>PROF. DR. AHMED MINHAZ SHUMON</h3></a>
                    <p>
                        <i class="fa fa-graduation-cap fa-lg" style="margin-right: 12px; display: inline-block;"></i> <span style="color: #16518c;"><strong style="display: inline-flex;">MBBS, DLO, MCPS, FCPS (ENT)</strong></span>
                    </p>
                    <p><i class="fa fa-certificate fa-lg" style="margin-right: 20px;"></i>Otolaryngologist [ENT]</p>
                    <p><i class="fa fa-hospital-o fa-lg" style="margin-right: 20px;"></i><span style="display: inline-flex;">POPULAR DIAGNOSTIC CENTRE LTD | UTTARA BRANCH-02</span></p>
                    <p><i class="fa fa-map-marker fa-lg" style="margin-right: 25px;"></i>House # 25, Road # 7, Sector # 4, Jashim Uddin Moar, Uttara, Dhaka.</p>
                    <p><i class="fa fa-money fa-lg" style="margin-right: 16px;"></i>Will Be Published Soon</p>

                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="https://hasbd.com/doctors/prof-dr-ahmed-minhaz-shumon/" data-a2a-title="PROF. DR. AHMED MINHAZ SHUMON" style="line-height: 32px;">
                        <a class="a2a_dd" href="https://www.addtoany.com/share#url=https%3A%2F%2Fhasbd.com%2Fdoctors%2Fprof-dr-ahmed-minhaz-shumon%2F&amp;title=PROF.%20DR.%20AHMED%20MINHAZ%20SHUMON">
                            <span class="a2a_svg a2a_s__default a2a_s_a2a" style="background-color: rgb(1, 102, 255);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <g fill="#FFF">
                                        <path d="M14 7h4v18h-4z"></path>
                                        <path d="M7 14h18v4H7z"></path>
                                    </g>
                                </svg>
                            </span>
                            <span class="a2a_label a2a_localize" data-a2a-localize="inner,Share">Share</span>
                        </a>
                        <a class="a2a_button_facebook" target="_blank" href="/#facebook" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_facebook" style="background-color: rgb(24, 119, 242);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <path
                                        fill="#FFF"
                                        d="M17.78 27.5V17.008h3.522l.527-4.09h-4.05v-2.61c0-1.182.33-1.99 2.023-1.99h2.166V4.66c-.375-.05-1.66-.16-3.155-.16-3.123 0-5.26 1.905-5.26 5.405v3.016h-3.53v4.09h3.53V27.5h4.223z"
                                    ></path>
                                </svg>
                            </span>
                            <span class="a2a_label">Facebook</span>
                        </a>
                        <a class="a2a_button_twitter" target="_blank" href="/#twitter" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_twitter" style="background-color: rgb(85, 172, 238);">
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

                    <br />
                    <a href="https://hasbd.com/doctors/prof-dr-ahmed-minhaz-shumon/" class="btn btn-default btn-flat bt-new">View Profile</a>
                </div>
            </div>
            <div class="container-fluid" style="padding-top: 30px; padding-bottom: 30px;">
                <div class="col-md-3">
                    <a href="https://hasbd.com/doctors/prof-dr-naseem-yasmeen/"> <img src="https://hasbd.com/wp-content/themes/hasbd/images/doctor-female.jpg" alt="" /></a>
                </div>
                <div class="col-md-9 iiiii">
                    <a href="https://hasbd.com/doctors/prof-dr-naseem-yasmeen/"><h3>PROF. DR. NASEEM YASMEEN</h3></a>
                    <p>
                        <i class="fa fa-graduation-cap fa-lg" style="margin-right: 12px; display: inline-block;"></i> <span style="color: #16518c;"><strong style="display: inline-flex;">MBBS, DLO, FCPS (ENT)</strong></span>
                    </p>
                    <p><i class="fa fa-certificate fa-lg" style="margin-right: 20px;"></i>Otolaryngologist [ENT]</p>
                    <p><i class="fa fa-hospital-o fa-lg" style="margin-right: 20px;"></i><span style="display: inline-flex;">POPULAR DIAGNOSTIC CENTRE LTD | UTTARA BRANCH-02</span></p>
                    <p><i class="fa fa-map-marker fa-lg" style="margin-right: 25px;"></i>House # 25, Road # 7, Sector # 4, Jashim Uddin Moar, Uttara, Dhaka.</p>
                    <p><i class="fa fa-money fa-lg" style="margin-right: 16px;"></i>Will Be Published Soon</p>

                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="https://hasbd.com/doctors/prof-dr-naseem-yasmeen/" data-a2a-title="PROF. DR. NASEEM YASMEEN" style="line-height: 32px;">
                        <a class="a2a_dd" href="https://www.addtoany.com/share#url=https%3A%2F%2Fhasbd.com%2Fdoctors%2Fprof-dr-naseem-yasmeen%2F&amp;title=PROF.%20DR.%20NASEEM%20YASMEEN">
                            <span class="a2a_svg a2a_s__default a2a_s_a2a" style="background-color: rgb(1, 102, 255);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <g fill="#FFF">
                                        <path d="M14 7h4v18h-4z"></path>
                                        <path d="M7 14h18v4H7z"></path>
                                    </g>
                                </svg>
                            </span>
                            <span class="a2a_label a2a_localize" data-a2a-localize="inner,Share">Share</span>
                        </a>
                        <a class="a2a_button_facebook" target="_blank" href="/#facebook" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_facebook" style="background-color: rgb(24, 119, 242);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <path
                                        fill="#FFF"
                                        d="M17.78 27.5V17.008h3.522l.527-4.09h-4.05v-2.61c0-1.182.33-1.99 2.023-1.99h2.166V4.66c-.375-.05-1.66-.16-3.155-.16-3.123 0-5.26 1.905-5.26 5.405v3.016h-3.53v4.09h3.53V27.5h4.223z"
                                    ></path>
                                </svg>
                            </span>
                            <span class="a2a_label">Facebook</span>
                        </a>
                        <a class="a2a_button_twitter" target="_blank" href="/#twitter" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_twitter" style="background-color: rgb(85, 172, 238);">
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

                    <br />
                    <a href="https://hasbd.com/doctors/prof-dr-naseem-yasmeen/" class="btn btn-default btn-flat bt-new">View Profile</a>
                </div>
            </div>
            <div class="container-fluid" style="padding-top: 30px; padding-bottom: 30px;">
                <div class="col-md-3">
                    <a href="https://hasbd.com/doctors/assoc-prof-dr-maruf-bin-habib/"> <img src="https://hasbd.com/wp-content/themes/hasbd/images/doctor.jpg" alt="" /></a>
                </div>
                <div class="col-md-9 iiiii">
                    <a href="https://hasbd.com/doctors/assoc-prof-dr-maruf-bin-habib/"><h3>ASSOC. PROF. DR. MARUF BIN HABIB</h3></a>
                    <p>
                        <i class="fa fa-graduation-cap fa-lg" style="margin-right: 12px; display: inline-block;"></i> <span style="color: #16518c;"><strong style="display: inline-flex;">MBBS, CCD (Diabetes), FCPS (Medicine)</strong></span>
                    </p>
                    <p><i class="fa fa-certificate fa-lg" style="margin-right: 20px;"></i>Diabetologist</p>
                    <p><i class="fa fa-hospital-o fa-lg" style="margin-right: 20px;"></i><span style="display: inline-flex;">POPULAR DIAGNOSTIC CENTRE LTD | UTTARA BRANCH-02</span></p>
                    <p><i class="fa fa-map-marker fa-lg" style="margin-right: 25px;"></i>House # 25, Road # 7, Sector # 4, Jashim Uddin Moar, Uttara, Dhaka.</p>
                    <p><i class="fa fa-money fa-lg" style="margin-right: 16px;"></i>Will Be Published Soon</p>

                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="https://hasbd.com/doctors/assoc-prof-dr-maruf-bin-habib/" data-a2a-title="ASSOC. PROF. DR. MARUF BIN HABIB" style="line-height: 32px;">
                        <a class="a2a_dd" href="https://www.addtoany.com/share#url=https%3A%2F%2Fhasbd.com%2Fdoctors%2Fassoc-prof-dr-maruf-bin-habib%2F&amp;title=ASSOC.%20PROF.%20DR.%20MARUF%20BIN%20HABIB">
                            <span class="a2a_svg a2a_s__default a2a_s_a2a" style="background-color: rgb(1, 102, 255);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <g fill="#FFF">
                                        <path d="M14 7h4v18h-4z"></path>
                                        <path d="M7 14h18v4H7z"></path>
                                    </g>
                                </svg>
                            </span>
                            <span class="a2a_label a2a_localize" data-a2a-localize="inner,Share">Share</span>
                        </a>
                        <a class="a2a_button_facebook" target="_blank" href="/#facebook" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_facebook" style="background-color: rgb(24, 119, 242);">
                                <svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                    <path
                                        fill="#FFF"
                                        d="M17.78 27.5V17.008h3.522l.527-4.09h-4.05v-2.61c0-1.182.33-1.99 2.023-1.99h2.166V4.66c-.375-.05-1.66-.16-3.155-.16-3.123 0-5.26 1.905-5.26 5.405v3.016h-3.53v4.09h3.53V27.5h4.223z"
                                    ></path>
                                </svg>
                            </span>
                            <span class="a2a_label">Facebook</span>
                        </a>
                        <a class="a2a_button_twitter" target="_blank" href="/#twitter" rel="nofollow noopener">
                            <span class="a2a_svg a2a_s__default a2a_s_twitter" style="background-color: rgb(85, 172, 238);">
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

                    <br />
                    <a href="https://hasbd.com/doctors/assoc-prof-dr-maruf-bin-habib/" class="btn btn-default btn-flat bt-new">View Profile</a>
                </div>
            </div>
            <nav>
                <ul class="pagination theme-colored">
                    <li class="active"><a href="https://hasbd.com/doctors/">1</a></li>
                    <li><a href="https://hasbd.com/doctors/page/2/">2</a></li>
                    <li><a href="https://hasbd.com/doctors/page/3/">3</a></li>
                    <li><a href="#">...</a></li>
                    <li><a href="https://hasbd.com/doctors/page/356/">356</a></li>
                    <li>
                        <a href="https://hasbd.com/doctors/page/2/"> <span aria-hidden="true">»</span> </a>
                    </li>
                </ul>
            </nav>
        </section>
    </main>

    <div class="modal fade ng-scope" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" ng-controller="searchCtrl">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search Doctor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="search_box" style="position: relative; width: 100%; margin-bottom: 0; height: auto;">
                        <form action="https://hasbd.com/doctors" class="avd_search ng-pristine ng-valid ng-valid-required" method="GET">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group" ng-init="country = 'Bangladesh'">
                                        <label for="country">Country</label>
                                        <select ng-model="country" name="country" class="form-control ng-pristine ng-valid ng-valid-required" required="">
                                            <!-- ngRepeat: (countryName, countryObj) in countries -->
                                            <option ng-repeat="(countryName, countryObj) in countries" value="Bangladesh" selected="" class="ng-binding ng-scope">Bangladesh</option>
                                            <!-- end ngRepeat: (countryName, countryObj) in countries -->
                                            <option ng-repeat="(countryName, countryObj) in countries" value="India" selected="" class="ng-binding ng-scope">India</option>
                                            <!-- end ngRepeat: (countryName, countryObj) in countries -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group" ng-init="city = '0'">
                                        <label for="city">City</label>
                                        <select name="city" ng-model="city" class="form-control ng-pristine ng-valid ng-valid-required" required="">
                                            <option value="0">Select City</option>
                                            <!-- ngRepeat: (cityName, cityObj) in countries[country].cities -->
                                            <option ng-repeat="(cityName, cityObj) in countries[country].cities" value="Chittagong" class="ng-binding ng-scope">Chittagong</option>
                                            <!-- end ngRepeat: (cityName, cityObj) in countries[country].cities -->
                                            <option ng-repeat="(cityName, cityObj) in countries[country].cities" value="Dhaka" class="ng-binding ng-scope">Dhaka</option>
                                            <!-- end ngRepeat: (cityName, cityObj) in countries[country].cities -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group" ng-init="area = '0'">
                                        <label for="area">Area</label>
                                        <select ng-model="area" name="area" class="form-control ng-pristine ng-valid">
                                            <option value="0">Select Area</option>
                                            <!-- ngRepeat: areaName in countries[country].cities[city].areas -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6" ng-init="service = 'doctors'">
                                    <div class="form-group" ng-init="speciality = '0'">
                                        <label for="speciality">Speciality</label>
                                        <select ng-model="speciality" name="speciality" class="form-control ng-pristine ng-valid ng-valid-required" required="">
                                            <option value="0">Select Speciality</option>
                                            <!-- ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Anesthesia Department" class="ng-binding ng-scope">Anesthesia Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Arthritis Department" class="ng-binding ng-scope">Arthritis Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Burn, Plastic, Cosmetic Department" class="ng-binding ng-scope">Burn, Plastic, Cosmetic Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Cancer Department" class="ng-binding ng-scope">Cancer Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Cardiology Department" class="ng-binding ng-scope">Cardiology Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Chest Department" class="ng-binding ng-scope">Chest Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Child Department" class="ng-binding ng-scope">Child Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Colorectal Surgeon" class="ng-binding ng-scope">Colorectal Surgeon</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Dental Department" class="ng-binding ng-scope">Dental Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Diabetes Department" class="ng-binding ng-scope">Diabetes Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Digestive System Department" class="ng-binding ng-scope">Digestive System Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="ENT Department" class="ng-binding ng-scope">ENT Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Endocrinology Department" class="ng-binding ng-scope">Endocrinology Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Eye Department" class="ng-binding ng-scope">Eye Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Gastroentrology Department" class="ng-binding ng-scope">Gastroentrology Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="General-Laparoscopy Department" class="ng-binding ng-scope">General-Laparoscopy Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Gynaecology-Obstetrics Department" class="ng-binding ng-scope">Gynaecology-Obstetrics Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Heart Disease Department" class="ng-binding ng-scope">Heart Disease Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Hematology Department" class="ng-binding ng-scope">Hematology Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Hepatology Department" class="ng-binding ng-scope">Hepatology Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Immunology Department" class="ng-binding ng-scope">Immunology Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Internal Medicine Department" class="ng-binding ng-scope">Internal Medicine Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Medicine Department" class="ng-binding ng-scope">Medicine Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Neonatology Department" class="ng-binding ng-scope">Neonatology Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Nephrology Department" class="ng-binding ng-scope">Nephrology Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Neurology Department" class="ng-binding ng-scope">Neurology Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Neuromedicine Department" class="ng-binding ng-scope">Neuromedicine Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Neurosurgery Department" class="ng-binding ng-scope">Neurosurgery Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Nutrition Department" class="ng-binding ng-scope">Nutrition Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Oncology Department" class="ng-binding ng-scope">Oncology Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Orthopedics Department" class="ng-binding ng-scope">Orthopedics Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Pathology, Imaging Department" class="ng-binding ng-scope">Pathology, Imaging Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Pediatric Surgery Department" class="ng-binding ng-scope">Pediatric Surgery Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Pediatrics Department" class="ng-binding ng-scope">Pediatrics Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Physiotherapy Department" class="ng-binding ng-scope">Physiotherapy Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Plastic Surgery Department" class="ng-binding ng-scope">Plastic Surgery Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Psychiatry Department" class="ng-binding ng-scope">Psychiatry Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Pulmonary Department" class="ng-binding ng-scope">Pulmonary Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Radiology Department" class="ng-binding ng-scope">Radiology Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Respiratory Medicine Department" class="ng-binding ng-scope">Respiratory Medicine Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Rheumatology Department" class="ng-binding ng-scope">Rheumatology Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Skin, Sex Department" class="ng-binding ng-scope">Skin, Sex Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Sonology Department" class="ng-binding ng-scope">Sonology Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Surgery Department" class="ng-binding ng-scope">Surgery Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Thoracic Surgery Department" class="ng-binding ng-scope">Thoracic Surgery Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Urology Department" class="ng-binding ng-scope">Urology Department</option>
                                            <!-- end ngRepeat: specialityName in services[service].specialities -->
                                            <option ng-repeat="specialityName in services[service].specialities" value="Vascular Surgery" class="ng-binding ng-scope">Vascular Surgery</option>
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
                    <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="loadResult(country, city, area, speciality,'doctors');">Search</button>
                </div>
            </div>
        </div>
    </div>
    <div
        id="searchLoader"
        style="position: fixed; left: 0; top: 0; width: 100%; height: 100%; background: url(https://hasbd.com/wp-content/themes/hasbd/images/loading.gif) no-repeat center center; background-color: rgba(0, 0, 0, 0.56); display: none;"
    ></div>
    <div class="text-center"></div>
</div>

    <!-- mostafiz -->

<?php
get_footer();

