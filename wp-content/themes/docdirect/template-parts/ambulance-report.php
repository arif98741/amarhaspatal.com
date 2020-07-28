<?php
/*
Template Name: Ambulance Report
*/

global $current_user, $wp_roles, $userdata, $post, $paged;
$dir_obj = new DocDirect_Scripts();
$user_identity = $current_user->ID;
$query = $wpdb->get_results("select * from wp_users");
$users = get_users(array(
    'meta_key' => 'directory_type',
    'meta_value' => '123'
));


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


                            <select name="user_id" class="form-control select2">
                                <option value="">Select Ambulance</option>
                                <?php foreach ($users as $user) {
                                    $userMeta = get_user_meta($user->ID);
                                    ?>
                                    <option value="<?= $user->ID ?>"><?= $userMeta['first_name'][0] ?>
                                    </option>

                                <?php } ?>
                            </select>


                        </div>

                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="hidden" class="" value="bookings" name="ref">
                            <input type="hidden" class="" value="<?php echo intval($user_identity); ?>"
                                   name="identity">
                            <input type="text" required class="form-control booking-search-date"
                                   value="<?php echo isset($_GET['by_date']) && !empty($_GET['by_date']) ? $_GET['by_date'] : ''; ?>"
                                   name="start_date" autocomplete="off"
                                   placeholder="<?php esc_html_e('Start date', 'docdirect'); ?>">
                            <!--                            <button type="submit"><i class="fa fa-search"></i></button>-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">

                            <input type="text" required class="form-control booking-search-date" value=""
                                   name="end_date" autocomplete="off"
                                   placeholder="<?php esc_html_e('End date', 'docdirect'); ?>">
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
    <style>
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaa;
            border-radius: 4px;
            height: 46px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #888 transparent transparent transparent;
            border-style: solid;
            border-width: 5px 4px 0 4px;
            height: 0;
            left: 50%;
            margin-left: -4px;
            margin-top: 6px !important;
            position: absolute;
            top: 50%;
            width: 0;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        jQuery(document).ready(function () {
            jQuery('.select2').select2();
        });
    </script>
<?php
get_footer();
?>