<?php
add_action('wp_enqueue_scripts', 'add_custom_chamber_js');

function add_custom_chamber_js()
{
    wp_register_script(
        'chamber-js', // name your script so that you can attach other scripts and de-register, etc.
        get_template_directory_uri() . '/customization/user-profile/chamber/chamber.js', // this is the location of your script file
        [],
    );
    wp_enqueue_script('chamber-js');
}

add_action('wp_enqueue_scripts', 'add_custom_notify_js');

function add_custom_notify_js()
{
    wp_register_script(
        'notify-js', // name your script so that you can attach other scripts and de-register, etc.
        get_template_directory_uri() . '/customization/user-profile/chamber/notify.js', // this is the location of your script file
        [],
    );
    wp_enqueue_script('notify-js');
}


/**
 * @Add Services Chambers
 * @return {}
 */
if (!function_exists('get_hospital_and_chambers')) {
    function get_hospital_and_chambers()
    {
        $meta_query = array(
            'relation' => 'or',
            array(
                'key' => 'directory_type',
                'value' => 126,
                'compare' => '='
            ),
            array(
                'key' => 'directory_type',
                'value' => 121,
                'compare' => '='
            )
        );

        $query_args = array(
            'order' => 'asc',
            'orderby' => 'id',
            'meta_query' => $meta_query,
        );

        $user_query = new WP_User_Query($query_args);
        $users = $user_query->get_results();
        foreach ($users as $user) {
            $first_name = get_user_meta($user->ID, 'first_name', true);
            $directories_array[] = $first_name;
        }
        array_push($directories_array, 'Others');
        $response['data'] = json_encode($directories_array);
        $response['type'] = 'update';
        $response['message_type'] = 'success';
        $response['message'] = 'Inserted Successfully';
        echo json_encode($response);
        die;
    }

    add_action('wp_ajax_get_hospital_and_chambers', 'get_hospital_and_chambers');
    add_action('wp_ajax_nopriv_get_hospital_and_chambers', 'get_hospital_and_chambers');
}


/**
 * @Add Services Chambers
 * @return {}
 */
if (!function_exists('docdirect_update_service_chamber')) {
    function docdirect_update_service_chamber()
    {
        global $current_user, $wp_roles, $userdata, $post;
        $user_identity = $current_user->ID;
        $services = get_user_meta($user_identity, 'service_chambers', true);
        $json = str_replace('\\', '', $_POST['form']);
        $formData = json_decode($json, true);

        /* echo '<pre>';
         print_r(unserialize($services));
         echo '</pre>';
         exit;*/

        $title = [];
        $new_patient_fee = [];
        $old_patient_fee = [];
        foreach ($formData as $form) {

            if ($form['name'] == 'title') {
                array_push($title, $form['value']);
            }
            if ($form['name'] == 'new_patient_fee') {
                array_push($new_patient_fee, $form['value']);
            }
            if ($form['name'] == 'old_patient_fee') {
                array_push($old_patient_fee, $form['value']);
            }
        }

        if (empty($title)) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Please add title.', 'docdirect');
            echo json_encode($json);
            die;
        }

        if (empty($new_patient_fee)) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Please Add New Patient Fee.', 'docdirect');
            echo json_encode($json);
            die;
        }

        if (empty($old_patient_fee)) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Please Add Old Patient Fee', 'docdirect');
            echo json_encode($json);
            die;
        }

        $finalChambers = [];


        for ($i = 0, $iMax = count($title); $i < $iMax; $i++) {

            $finalChambers[$i]['title'] = $title[$i];
            $finalChambers[$i]['new_patient_fee'] = $new_patient_fee[$i];
            $finalChambers[$i]['old_patient_fee'] = $old_patient_fee[$i];
        }

        $lastInsertData = $finalChambers[count($finalChambers) - 1];
        $flag = 0;
        foreach (unserialize($services) as $key => $value) {
            if ($value['title'] == $lastInsertData['title']) {
                $flag = 1;
                break;
            }
        }

        if ($flag === 1) {

            $response['message_type'] = 'error';
            $response['message'] = 'Already Exist';
            echo json_encode($response);
            die;

        } else {
            $service_chambers = serialize($finalChambers);
            delete_user_meta($user_identity, 'service_chambers');
            add_user_meta($user_identity, 'service_chambers', $service_chambers);

            $response['message_type'] = 'success';
            $response['message'] = 'Inserted Successfully';
            echo json_encode($response);
            die;
        }

    }

    add_action('wp_ajax_docdirect_update_service_chamber', 'docdirect_update_service_chamber');
    add_action('wp_ajax_nopriv_docdirect_update_service_chamber', 'docdirect_update_service_chamber');
}

/**
 * @Delete Service Chambers
 * @return {}
 */
if (!function_exists('docdirect_delete_service_chamber')) {
    function docdirect_delete_service_chamber()
    {
        global $current_user, $wp_roles, $userdata, $post;
        $user_identity = $current_user->ID;


        $posted_key = !empty($_POST['key']) ? esc_attr($_POST['key']) : '';
        if (empty($posted_key)) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Some error occur, please try again later.', 'docdirect');
            echo json_encode($json);
            die;
        }


        $service_chambers = get_user_meta($user_identity, 'service_chambers', true);
        $array = unserialize($service_chambers);
        unset($array[$posted_key]);
        $serializeArray = serialize($array);

        update_user_meta($user_identity, 'service_chambers', $serializeArray);
        $json['message_type'] = 'success';
        $json['message'] = esc_html__('Chamber deleted successfully.', 'docdirect');
        echo json_encode($json);
        die;
    }

    add_action('wp_ajax_docdirect_delete_service_chamber', 'docdirect_delete_service_chamber');
    add_action('wp_ajax_nopriv_docdirect_delete_service_chamber', 'docdirect_delete_service_chamber');
}