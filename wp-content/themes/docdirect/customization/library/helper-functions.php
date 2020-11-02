<?php
global $current_user, $wp_roles, $userdata, $post;
/**
 * Search Pagination
 * @param $meta_query
 * @param int $users_per_page
 * @param string $orderBy
 * @return array
 */
function searchPagination($meta_query, $users_per_page = 2, $orderBy = 'display_name')
{
    $args = array(
        'orderby' => $orderBy,
        'meta_query' => $meta_query
    );

    $query = new WP_User_Query($args);
    $user_count = $query->get_results();
    $total_users = $user_count ? count($user_count) : 1;
    $total_pages = 1;
    $uri = $_SERVER['REQUEST_URI'];
    $explode = explode('/', $uri);
    $page = $explode[count($explode) - 2];
    if (!is_numeric($page)) {
        $page = 1;
    }
    $offset = $users_per_page * ($page - 1);
    $total_pages = ceil($total_users / $users_per_page);
    return [
        'per_page' => $users_per_page,
        'total_pages' => $total_pages,
        'page' => $page,
        'offset' => $offset,
        'total_users' => $total_users
    ];
}

/**
 * Remove Unwanted Checkout Fields
 * @param $fields
 * @return mixed
 */
if (!function_exists('custom_override_checkout_fields')) {
    function custom_override_checkout_fields($fields)
    {
        unset(
            $fields['billing']['billing_country'],
            $fields['billing']['billing_company'],
            $fields['billing']['billing_postcode'],
            $fields['shipping']['shipping_country'],
            $fields['shipping']['shipping_company'],
            $fields['shipping']['shipping_postcode'],
        );
        return $fields;
    }

    add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
}

/**
 * Get Category
 * @param $taxonomy
 * @param string $order
 * @return array
 */
if (!function_exists('getPostTermCategory')) {

    function getPostTermCategory($taxonomy, $order = 'asc')
    {
        $term_query = new WP_Term_Query([
            'taxonomy' => $taxonomy,
            'order' => $order,
            'hide_empty' => false,
            'parent' => 0
        ]);
        $categories = [];
        foreach ($term_query->terms as $term) {
            $categories[] = $term;
        }
        return $categories;
    }
}

/**
 * Get Child Categories of Parent
 * @param $taxonomy
 * @param $parentId
 * @param string $order
 * @return array
 */
if (!function_exists('getPostTermChildCategory')) {

    function getPostTermChildCategory($taxonomy, $parentId, $order = 'asc')
    {
        $term_query = new WP_Term_Query([
            'taxonomy' => $taxonomy,
            'order' => $order,
            'hide_empty' => false,
            'parent' => $parentId
        ]);
        $categories = [];
        foreach ($term_query->terms as $term) {
            $categories[] = $term;
        }
        return $categories;
    }
}

if (!function_exists('session_store_custom')) {
    function session_store_custom()
    {
        global $wp_session;
        $wp_session = WP_Session_Tokens::get_instance();

    }
}

//shop page customization
add_filter('woocommerce_product_subcategories_hide_empty', '__return_false');

/**
 * Get Doctor Chambers As Array
 * @param string $id
 * @return mixed
 */
function getDoctorChambers($id = '')
{
    global $wp_query, $current_user;
    $author_profile = $wp_query->get_queried_object();
    if (!empty($id)) {
        $data = get_user_meta($id, 'service_chambers', true);

    } else {
        $data = get_user_meta($author_profile->ID, 'service_chambers', true);

    }

}


/**
 * Get Specialized Doctors
 * @param $author
 * @return array
 */
function getSpecilizedDoctors($author)
{
    $first_name = get_user_meta($author, 'first_name', true);
    $meta_query = array(
        'relation' => 'and',
        array(
            'key' => 'default_slots',
            'value' => $first_name,
            'compare' => 'LIKE'
        ),
    );

    $query_args = array(
        'order' => 'asc',
        'orderby' => 'id',
        'meta_query' => $meta_query,
        'posts_per_page' => 3
    );

    $user_query = new WP_User_Query($query_args);
    return $user_query->get_results();

}

