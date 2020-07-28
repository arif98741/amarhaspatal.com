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
    <div class="map-top">
        <div class="row tg-divheight">
            <div class="tg-mapbox">
                <div id="map_canvas" class="tg-location-map tg-haslayout"></div>
                <?php do_action('docdirect_map_controls'); ?>
                <div id="gmap-noresult"></div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (have_posts()) { ?>
    <div class="container">
        <div class="row">
            <?php
            while (have_posts()) : the_post();
                the_content();
            endwhile;
            ?>
        </div>
    </div>
<?php } ?>
    <div class="container">
        <div id="doc-twocolumns" class="doc-twocolumns doc-listview">
            <?php if (!empty($found_title)) { ?>
                <span class="doc-searchresult"><?php echo force_balance_tags($found_title); ?></span>
            <?php } ?>
            <form class="doc-formtheme doc-formsearchwidget search-result-form">
                <div class="row">
                    <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 pull-right">
                        <div id="doc-content" class="doc-content">
                            <div class="doc-doctorlisting">
                                <div class="doc-pagehead">
                                    <div class="doc-sortby">
                     <span class="doc-select">
                      <select name="sort_by" class="sort_by" id="sort_by">
                          <option value=""><?php esc_html_e('Sort By', 'docdirect'); ?></option>
                          <option value="recent" <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] == 'recent' ? 'selected' : ''; ?>><?php esc_html_e('Most recent', 'docdirect'); ?></option>
                          <option value="featured" <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] == 'featured' ? 'selected' : ''; ?>><?php esc_html_e('Featured', 'docdirect'); ?></option>
                          <option value="title" <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] == 'title' ? 'selected' : ''; ?>><?php esc_html_e('Alphabetical', 'docdirect'); ?></option>
                          <option value="distance" <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] == 'distance' ? 'selected' : ''; ?>><?php esc_html_e('Sort By Distance', 'docdirect'); ?></option>
                          <option value="likes" <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] == 'likes' ? 'selected' : ''; ?>><?php esc_html_e('Sort By Likes', 'docdirect'); ?></option>
                      </select>
                      </span>
                                        <span class="doc-select">
                        <select class="order_by" name="order" id="order">
                          <option value="ASC" <?php echo isset($_GET['order']) && $_GET['order'] == 'ASC' ? 'selected' : ''; ?>><?php esc_html_e('ASC', 'docdirect'); ?></option>
                          <option value="DESC" <?php echo isset($_GET['order']) && $_GET['order'] == 'DESC' ? 'selected' : ''; ?>><?php esc_html_e('DESC', 'docdirect'); ?></option>
                        </select>
                      </span>

                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="row">

                                    Search for services
                                    <div class="col-sm-12">
                                        <?php
                                        $directories = array();
                                        $directories['status'] = 'none';
                                        $directories['lat'] = floatval($direction['lat']);
                                        $directories['long'] = floatval($direction['long']);

                                        if (!empty($user_query->results)) {
                                            $directories['status'] = 'found';


                                            if (isset($directory_type) && !empty($directory_type)) {
                                                $title = get_the_title($directory_type);
                                                $postdata = get_post($directory_type);
                                                $slug = $postdata->post_name;
                                            } else {
                                                $title = '';
                                                $slug = '';
                                            }

                                            foreach ($user_query->results as $user) {


                                                $latitude = get_user_meta($user->ID, 'latitude', true);
                                                $longitude = get_user_meta($user->ID, 'longitude', true);
                                                $directory_type = get_user_meta($user->ID, 'directory_type', true);
                                                $dir_map_marker = fw_get_db_post_option($directory_type, 'dir_map_marker', true);
                                                $reviews_switch = fw_get_db_post_option($directory_type, 'reviews', true);
                                                $current_date = date('Y-m-d H:i:s');
                                                $avatar = apply_filters(
                                                    'docdirect_get_user_avatar_filter',
                                                    docdirect_get_user_avatar(array('width' => 270, 'height' => 270), $user->ID),
                                                    array('width' => 270, 'height' => 270) //size width,height
                                                );

                                                $privacy = docdirect_get_privacy_settings($user->ID); //Privacy settin

                                                $directories_array['latitude'] = $latitude;
                                                $directories_array['longitude'] = $longitude;
                                                $directories_array['fax'] = $user->fax;
                                                $directories_array['description'] = $user->description;
                                                $directories_array['title'] = $user->display_name;
                                                $directories_array['name'] = $user->first_name . ' ' . $user->last_name;
                                                $directories_array['email'] = $user->user_email;
                                                $directories_array['phone_number'] = $user->phone_number;
                                                $directories_array['address'] = $user->user_address;
                                                $directories_array['group'] = $slug;
                                                $featured_string = docdirect_get_user_featured_date($user->ID);
                                                $current_string = strtotime($current_date);
                                                $review_data = docdirect_get_everage_rating($user->ID);
                                                $get_username = docdirect_get_username($user->ID);
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

                                                $infoBox = '<div class="tg-map-marker">';
                                                $infoBox .= '<figure class="tg-docimg"><a class="userlink" target="_blank" href="' . get_author_posts_url($user->ID) . '"><img src="' . esc_url($avatar) . '" alt="' . esc_attr($directories_array['name']) . '"></a>';
                                                $infoBox .= docdirect_get_wishlist_button($user->ID, false);

                                                if (isset($featured_string['featured_till']) && $featured_string['featured_till'] > $current_string) {
                                                    $infoBox .= docdirect_get_featured_tag(false);
                                                }

                                                $infoBox .= docdirect_get_verified_tag(false, $user->ID);

                                                if (isset($reviews_switch) && $reviews_switch === 'enable') {
                                                    $infoBox .= docdirect_get_rating_stars($review_data, 'return');
                                                }

                                                $infoBox .= '</figure>';

                                                $infoBox .= '<div class="tg-mapmarker-content">';
                                                $infoBox .= '<div class="tg-heading-border tg-small">';
                                                $infoBox .= '<h3><a class="userlink" target="_blank" href="' . get_author_posts_url($user->ID) . '">' . $directories_array['name'] . '</a></h3>';
                                                $infoBox .= '</div>';
                                                $infoBox .= '<ul class="tg-info">';


                                                if (!empty($directories_array['email'])
                                                    &&
                                                    !empty($privacy['email'])
                                                    &&
                                                    $privacy['email'] == 'on' && $directory_type != 123
                                                ) {
                                                    $infoBox .= '<li> <i class="fa fa-envelope"></i> <em><a href="mailto:' . $directories_array['email'] . '?Subject=' . esc_html__('hello', 'docdirect') . '"  target="_top">' . $directories_array['email'] . '</a></em> </li>';
                                                }

                                                if (!empty($directories_array['phone_number'])
                                                    &&
                                                    !empty($privacy['phone'])
                                                    &&
                                                    $privacy['phone'] == 'on' && $directory_type != 123
                                                ) {
                                                    $infoBox .= '<li> <i class="fa fa-phone"></i> <em><a href="javascript:;">' . $directories_array['phone_number'] . '</a></em> </li>';
                                                }

                                                if (!empty($directories_array['address'])) {
                                                    $infoBox .= '<li> <i class="fa fa-cart"></i> <address>' . $directories_array['address'] . '</address> </li>';
                                                }

                                                $infoBox .= '</ul>';
                                                $infoBox .= '</div>';
                                                $infoBox .= '</div>';

                                                $directories_array['html']['content'] = $infoBox;
                                                $directories['users_list'][] = $directories_array;
                                                ?>
                                                <div class="doc-featurelist"
                                                     class="user-<?php echo intval($user->ID); ?>">
                                                    <figure class="doc-featureimg">
                                                        <?php if (isset($featured_string['featured_till']) && $featured_string['featured_till'] > $current_string) { ?>
                                                            <?php docdirect_get_featured_tag(true, 'v2'); ?>
                                                        <?php } ?>
                                                        <?php docdirect_get_verified_tag(true, $user->ID, '', 'v2'); ?>
                                                        <a href="<?php echo ($directory_type != 122) ? get_author_posts_url($user->ID) : '#'; ?>"
                                                           class="list-avatar">
                                                            <img src="<?php echo esc_attr($avatar); ?>"
                                                                 alt="<?php echo esc_attr($directories_array['name']); ?>">
                                                        </a>
                                                        <?php do_action('docdirect_display_provider_category', $user->ID); ?>
                                                    </figure>
                                                    <div class="doc-featurecontent">

                                                        <div class="doc-featurehead">
                                                            <?php docdirect_get_wishlist_button($user->ID, true, 'v2'); ?>
                                                            <h2>
                                                                <a href="<?php echo ($directory_type != 122) ? get_author_posts_url($user->ID) : '#'; ?>"
                                                                   class="list-avatar"><?php echo($get_username); ?></a>
                                                            </h2>
                                                            <?php if (!empty($user->tagline)) { ?>
                                                                <span><?php echo esc_attr($user->tagline); ?></span>
                                                            <?php } ?>
                                                            <ul class="doc-matadata">

                                                                <li><?php docdirect_get_likes_button($user->ID); ?></li>
                                                                <?php
                                                                if (isset($reviews_switch) && $reviews_switch === 'enable' && $directory_type != 122) {
                                                                    docdirect_get_rating_stars_v2($review_data, 'echo');
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                        <?php if (!empty($directories_array['description'])) { ?>
                                                            <div class="doc-description">
                                                                <p><?php echo substr($directories_array['description'], 0, 147); ?></p>
                                                            </div>
                                                        <?php } ?>
                                                        <ul class="doc-addressinfo">
                                                            <?php if (!empty($directories_array['address'])) { ?>
                                                                <li><i class="fa fa-map-marker"></i>
                                                                    <address><?php echo esc_attr($directories_array['address']); ?></address>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if (!empty($directories_array['phone_number'])
                                                                &&
                                                                !empty($privacy['phone'])
                                                                &&
                                                                $privacy['phone'] == 'on' && $directory_type != 123
                                                            ) { ?>
                                                                <li>
                                                                    <i class="fa fa-phone"></i><span><?php echo esc_attr($directories_array['phone_number']); ?></span>
                                                                </li>
                                                            <?php } else { ?>
                                                                <li>
                                                                    <i class="fa fa-phone"></i><span>01XXXXXXXXX</span>
                                                                </li>
                                                            <?php } ?>



                                                            <?php if (!empty($directories_array['email'])
                                                                &&
                                                                !empty($privacy['email'])
                                                                &&
                                                                $privacy['email'] == 'on' && $directory_type != 123
                                                            ) { ?>
                                                                <li><i class="fa fa-envelope-o"></i><a
                                                                            href="mailto:<?php echo esc_attr($directories_array['email']); ?>?subject:<?php esc_html_e('Hello', 'docdirect'); ?>"><?php echo esc_attr($directories_array['email']); ?></a>
                                                                </li>
                                                            <?php } else { ?>
                                                                <li><i class="fa fa-envelope-o"></i><a
                                                                            href="#">something@example.com</a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if (!empty($directories_array['fax'])) { ?>
                                                                <li>
                                                                    <i class="fa fa-fax"></i><span><?php echo esc_attr($directories_array['fax']); ?></span>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if ($directory_type == 122) { ?>
                                                                <li>
                                                                    <i class="fa fa-fax"></i><span>Blood group: <?php echo get_user_meta($user->ID, 'blood_group')[0]; ?></span>
                                                                </li>
                                                                <li>
                                                                    <i class="fa fa-calendar"></i><span>Last donation date: <?php echo get_user_meta($user->ID, 'last_donation_date')[0]; ?></span>
                                                                </li>
                                                                <li>

                                                                </li>

                                                            <?php } ?>
                                                            <li>
                                                                <?php
                                                                $author_profile = $user;
                                                                do_action('enqueue_unyson_icon_css');
                                                                foreach ($author_profile->user_profile_specialities as $key => $value) {
                                                                    $get_speciality_term = get_term_by('slug', $key, 'specialities');
                                                                    $speciality_title = '';
                                                                    $term_id = '';
                                                                    if (!empty($get_speciality_term)) {
                                                                        $speciality_title = $get_speciality_term->name;
                                                                        $term_id = $get_speciality_term->term_id;
                                                                    }

                                                                    $speciality_meta = array();
                                                                    if (function_exists('fw_get_db_term_option')) {
                                                                        $speciality_meta = fw_get_db_term_option($term_id, 'specialities');
                                                                    }

                                                                    $speciality_icon = array();
                                                                    if (!empty($speciality_meta['icon']['icon-class'])) {
                                                                        $speciality_icon = $speciality_meta['icon']['icon-class'];
                                                                    } ?>
                                                                    <?php if (isset($speciality_meta['icon']['type']) && $speciality_meta['icon']['type'] === 'icon-font') {
                                                                        if (!empty($speciality_icon)) { ?>
                                                                            <i class="<?php echo esc_attr($speciality_icon); ?>"></i>
                                                                            <?php
                                                                        }
                                                                    } else if (isset($speciality_meta['icon']['type']) && $speciality_meta['icon']['type'] === 'custom-upload') {
                                                                        if (!empty($speciality_meta['icon']['url'])) {
                                                                            ?>
                                                                            <img src="<?php echo esc_url($speciality_meta['icon']['url']); ?>">
                                                                        <?php }
                                                                    } ?>
                                                                    </span>
                                                                    <span><?php echo esc_attr($value); ?></span>

                                                                <?php } ?>

                                                            </li>

                                                            <?php
                                                            if (!empty($user->latitude) && !empty($user->longitude)) {
                                                                $unit_type = docdirect_get_distance_scale();
                                                                $unit = !empty($unit_type) && $unit_type === 'Mi' ? 'M' : 'K';
                                                                $unit_2 = !empty($unit_type) && $unit_type === 'mi' ? 'Mi' : 'Km';

                                                                if (!empty($_GET['geo_location'])) {
                                                                    $args = array(
                                                                        'timeout' => 15,
                                                                        'headers' => array('Accept-Encoding' => ''),
                                                                        'sslverify' => false
                                                                    );

                                                                    $address = !empty($_GET['geo_location']) ? $_GET['geo_location'] : '';
                                                                    $prepAddr = str_replace(' ', '+', $address);

                                                                    $url = 'https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&key=' . $google_key;
                                                                    $response = wp_remote_get($url, $args);
                                                                    $geocode = wp_remote_retrieve_body($response);
                                                                    $output = json_decode($geocode);

                                                                    if (isset($output->results) && !empty($output->results)) {
                                                                        $Latitude = $output->results[0]->geometry->location->lat;
                                                                        $Longitude = $output->results[0]->geometry->location->lng;
                                                                        $distance = docdirectGetDistanceBetweenPoints($Latitude, $Longitude, $user->latitude, $user->longitude, $unit_2);
                                                                    }
                                                                }
                                                                ?>
                                                                <?php if (!empty($distance)) { ?>
                                                                    <li class="dynamic-locations"><i
                                                                                class='fa fa-globe'></i><span><?php esc_html_e('within', 'docdirect'); ?>&nbsp;<?php echo esc_attr($distance); ?></span>
                                                                    </li>
                                                                <?php } else { ?>
                                                                    <li class="dynamic-location-<?php echo intval($user->ID); ?>"></li>
                                                                    <?php
                                                                    wp_add_inline_script('docdirect_functions', 'if ( window.navigator.geolocation ) {
														window.navigator.geolocation.getCurrentPosition(
															function(pos) {
																jQuery.cookie("geo_location", pos.coords.latitude+"|"+pos.coords.longitude, { expires : 365 });
																var with_in	= _get_distance(pos.coords.latitude, pos.coords.longitude, ' . esc_js($user->latitude) . ',' . esc_js($user->longitude) . ',"' . $unit . '");
																jQuery(".dynamic-location-' . intval($user->ID) . '").html("<i class=\'fa fa-globe\'></i><span>"+scripts_vars.with_in+_get_round(with_in, 2)+scripts_vars.kilometer+"</i></span>");
																
															}
														);
													}
												');
                                                                }
                                                                ?>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        } else { ?>
                                            <?php DoctorDirectory_NotificationsHelper::informations(esc_html__('No Result Found.', 'docdirect')); ?>
                                        <?php } ?>
                                        <?php if (isset($search_page_map) && $search_page_map === 'enable') { ?>
                                            <script>
                                                jQuery(document).ready(function () {
                                                    /* Init Markers */
                                                    docdirect_init_map_script(<?php echo json_encode($directories);?>);
                                                });
                                            </script>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            //Pagination
                            if ($total_users > $limit) { ?>
                                <?php docdirect_prepare_pagination($total_users, $limit); ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 pull-left">
                        <aside id="doc-sidebar" class="doc-sidebar">
                            <?php do_action('docdirect_search_filters'); ?>
                            <?php if (is_active_sidebar('search-page-sidebar')) { ?>
                                <div class="tg-doctors-list tg-haslayout">
                                    <?php dynamic_sidebar('search-page-sidebar'); ?>
                                </div>
                            <?php } ?>
                        </aside>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php
get_footer();

