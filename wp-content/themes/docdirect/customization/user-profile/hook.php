<?php
add_action('wp_enqueue_scripts', 'add_custom_chamber_js');

function add_custom_chamber_js()
{
    wp_register_script(
        'chamber-js', // name your script so that you can attach other scripts and de-register, etc.
        get_template_directory_uri() . '/customization/user-profile/chamber/chamber.js', // this is the location of your script file
        [],
    );
    wp_enqueue_script( 'chamber-js' );

}



/**
 * @Add Services Chambers
 * @return {}
 */
if ( ! function_exists( 'docdirect_update_service_chamber' ) ) {
    function docdirect_update_service_chamber(){
        global $current_user, $wp_roles,$userdata,$post;
        $user_identity	= $current_user->ID;
        $services = get_user_meta($user_identity , 'service_chambers' , true);


        $cat_title	 = esc_attr($_POST['title']);

        if( empty( $cat_title ) ){
            $json['type']	= 'error';
            $json['message']	= esc_html__('Please add title.','docdirect');
            echo json_encode($json);
            die;
        }

        $service_chambers	= array();
        $key	 = !empty( $_POST['key'] ) ? esc_attr( $_POST['key'] ) : 'new';
        $type	 = !empty( $_POST['type'] ) ? esc_attr( $_POST['type'] ) : 'add';

        if( $key === 'new' ) {
            $service_chambers = get_user_meta($user_identity , 'service_chambers' , true);
            $service_chambers	= empty( $service_chambers ) ? array() : $service_chambers;
            $title	  = $cat_title;
            $key	  = sanitize_title($title);

            if ( !empty( $service_chambers )
                && array_key_exists($key, $service_chambers)

            ) {
                $key	  = sanitize_title($title).docdirect_unique_increment(3);
            }

            $key = strtolower($key);
            $new_cat[$key]	=  $title;
            $service_chambers	= array_merge($service_chambers,$new_cat);
            $message	= esc_html__('Chamber added successfully.','docdirect');
        } else{
            $service_chambers = get_user_meta($user_identity , 'service_chambers' , true);
            $service_chambers	= empty( $service_chambers ) ? array() : $service_chambers;
            $title	= esc_attr ( $_POST['title'] );
            $service_chambers[$key]	= $title;
            $message	= esc_html__('Chamber updated successfully.','docdirect');
        }

        update_user_meta( $user_identity, 'service_chambers', $service_chambers );

        $json['title']	  = $title;
        $json['key']	  = $key;
        $json['type']	  = 'update';
        $json['message_type']	 = 'success';
        $json['message']  = $message;
        echo json_encode($json);
        die;

    }
    add_action('wp_ajax_docdirect_update_service_chamber','docdirect_update_service_chamber');
    add_action( 'wp_ajax_nopriv_docdirect_update_service_chamber', 'docdirect_update_service_chamber' );
}

/**
 * @Delete Service Chambers
 * @return {}
 */
if ( ! function_exists( 'docdirect_delete_service_chamber' ) ) {
    function docdirect_delete_service_chamber(){
        global $current_user, $wp_roles,$userdata,$post;
        $user_identity	= $current_user->ID;

        $posted_key	 = !empty( $_POST['key'] ) ? esc_attr( $_POST['key'] ) :'';
        if( empty( $posted_key ) ){
            $json['type']	= 'error';
            $json['message']	= esc_html__('Some error occur, please try again later.','docdirect');
            echo json_encode($json);
            die;
        }

        $service_chambers	= array();
        $service_chambers = get_user_meta($user_identity , 'service_chambers' , true);
        unset( $service_chambers[$posted_key] );
        update_user_meta( $user_identity, 'service_chambers', $service_chambers );

        $json['message_type']	 = 'success';
        $json['message']  = esc_html__('Chamber deleted successfully.','docdirect');
        echo json_encode($json);
        die;

    }
    add_action('wp_ajax_docdirect_delete_service_chamber','docdirect_delete_service_chamber');
    add_action( 'wp_ajax_nopriv_docdirect_delete_service_chamber', 'docdirect_delete_service_chamber' );
}