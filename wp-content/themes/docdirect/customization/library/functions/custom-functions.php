<?php
/**
 * Unserialized data
 */
function unserializeData($data)
{
    return unserialize($data);
}

/**
 * Counter user
 * @param $directoryType
 * @return int
 */
function countUser($directoryType)
{
    $query_args = array(
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'directory_type',
                'value' => $directoryType,
                'compare' => '='
            )
        )
    );
    $user_query = new WP_User_Query($query_args);
    return count($user_query->get_results());
}


/**
 * Count Number of Ambulance Booking
 * @return int
 */
function countNumberofAmbulanceBooking()
{
    global $wpdb;
    $results = $wpdb->get_results('select * from ambulance_booking');
    if (!empty($results)) {
        return count($results);
    } else {
        return 0;
    }
}

