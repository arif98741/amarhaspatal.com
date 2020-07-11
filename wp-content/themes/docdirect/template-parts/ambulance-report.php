<?php
/*
Template Name: Ambulance Report
*/

global $current_user, $wp_roles, $userdata, $post, $paged;
$dir_obj = new DocDirect_Scripts();
$user_identity = $current_user->ID;
$query = $wpdb->get_results("select * from wp_users");


foreach ($query as $user) {
    $userMeta = get_user_meta($user_id->ID, [
        'user_type'
    ]);
}


get_header();
?>
    <div class="container">
        <div class="tg-dashboard tg-docappointmentlisting tg-haslayout">
            <h4 class="text-center"><?php esc_html_e('Select start and end date to generate report ', 'docdirect'); ?>
                :</h4>
            <hr>
            <form class="tg-formappointmentsearch"
                  action="<?= site_url('ambulance-report-preview'); ?>"
                  method="get">
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="hidden" class="" value="bookings" name="ref">
                            <input type="hidden" class="" value="<?php echo intval($user_identity); ?>"
                                   name="identity">
                            <input type="text" required class="form-control booking-search-date"
                                   value="<?php echo isset($_GET['by_date']) && !empty($_GET['by_date']) ? $_GET['by_date'] : ''; ?>"
                                   name="start_date" placeholder="<?php esc_html_e('Start date', 'docdirect'); ?>">
                            <!--                            <button type="submit"><i class="fa fa-search"></i></button>-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">

                            <input type="text" required class="form-control booking-search-date" value=""
                                   name="end_date" placeholder="<?php esc_html_e('End date', 'docdirect'); ?>">
                        </div>

                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

<?php
get_footer();
?>