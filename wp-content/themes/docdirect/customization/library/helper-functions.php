<?php

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
