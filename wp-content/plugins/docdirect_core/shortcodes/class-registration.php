<?php
/**
 * @File Type: Registration & Login
 * @return {}
 */
//TODO:: file should be changed
if (!class_exists('SC_Authentication')) {


    class SC_Authentication
    {

        public function __construct()
        {
            add_shortcode('user_authentication', array(&$this, 'shortCodeCallBack'));
            add_shortcode('user_authentication_page', array(&$this, 'user_authentication_page'));
        }

        /**
         * @User Authentication
         * @return void {HTML}
         */
        public function shortCodeCallBack()
        {
            $enable_resgistration = '';
            $enable_login = '';
            $captcha_settings = '';
            $terms_link = '';

            if (function_exists('fw_get_db_settings_option')) {
                $enable_resgistration = fw_get_db_settings_option('registration', $default_value = null);
                $enable_login = fw_get_db_settings_option('enable_login', $default_value = null);
                $captcha_settings = fw_get_db_settings_option('captcha_settings', $default_value = null);
                $terms_link = fw_get_db_settings_option('terms_link', $default_value = null);
            }
            ?>
            <div class="modal fade tg-user-modal" tabindex="-1" role="dialog">
                <div class="tg-modal-content">
                    <ul class="tg-modaltabs-nav" role="tablist">
                        <li role="presentation" class="active"><a href="#tg-signin-formarea"
                                                                  aria-controls="tg-signin-formarea" role="tab"
                                                                  data-toggle="tab"><?php esc_html_e('Sign In', 'docdirect_core'); ?></a>
                        </li>
                        <li role="presentation"><a href="#tg-signup-formarea" class="trigger-signup-formarea"
                                                   aria-controls="tg-signup-formarea" role="tab"
                                                   data-toggle="tab"><?php esc_html_e('Sign Up', 'docdirect_core'); ?></a>
                        </li>
                    </ul>
                    <div class="tab-content tg-haslayout">
                        <div role="tabpanel" class="tab-pane tg-haslayout active" id="tg-signin-formarea">
                            <?php if ($enable_login == 'enable') {
                                if (apply_filters('docdirect_is_user_logged_in', 'check_user') === false) {

                                    //Demo Ready
                                    $demo_username = '';
                                    $demo_pass = '';
                                    if (isset($_SERVER["SERVER_NAME"]) && $_SERVER["SERVER_NAME"] === 'themographics.com') {
                                        $demo_username = 'demo';
                                        $demo_pass = 'demo';
                                    }

                                    if (function_exists('fw_get_db_settings_option')) {
                                        $site_key = fw_get_db_settings_option('site_key');
                                    } else {
                                        $site_key = '';
                                    }

                                    ?>
                                    <form class="tg-form-modal tg-form-signin do-login-form">
                                        <fieldset>
                                            <div class="form-group">
                                                <input type="text" name="username"
                                                       value="<?php echo esc_attr($demo_username); ?>"
                                                       placeholder="<?php esc_html_e('Username/Email Address', 'docdirect_core'); ?>"
                                                       class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password"
                                                       value="<?php echo esc_attr($demo_pass); ?>" class="form-control"
                                                       placeholder="<?php esc_html_e('Password', 'docdirect_core'); ?>">
                                            </div>
                                            <div class="form-group tg-checkbox">
                                                <label>
                                                    <input type="checkbox" class="form-control">
                                                    <?php esc_html_e('sRemember Me', 'docdirect_core'); ?>
                                                </label>
                                                <a class="tg-forgot-password" href="javascript:;">
                                                    <i><?php esc_html_e('Forgot Password', 'docdirect_core'); ?></i>
                                                    <i class="fa fa-question-circle"></i>
                                                </a>
                                            </div>
                                            <?php
                                            if (isset($captcha_settings)
                                                && $captcha_settings === 'enable'
                                            ) {
                                                ?>
                                                <div class="domain-captcha">
                                                    <div id="recaptcha_signin"></div>
                                                </div>
                                            <?php } ?>
                                            <button class="tg-btn tg-btn-lg do-login-button"><?php esc_html_e('LOGIN now', 'docdirect_core'); ?></button>
                                        </fieldset>
                                    </form>
                                <?php }
                            } else { ?>
                                <div class="tg-form-modal">
                                    <p class="alert alert-info theme-notification"><?php esc_html_e('Sign In is disabled by administrator', 'docdirect_core'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div role="tabpanel" class="tab-pane tg-haslayout" id="tg-signup-formarea">
                            <?php
                            if ($enable_resgistration == 'enable') {
                                if (apply_filters('docdirect_is_user_logged_in', 'check_user') === false) { ?>
                                    <form class="tg-form-modal tg-form-signup do-registration-form">
                                        <fieldset>
                                            <!--<div class="form-group">
                                                <div class="tg-radiobox user-selection active-user-type">
                                                    <input type="radio" checked="checked" name="user_type"
                                                           value="professional" id="professional">
                                                    <label for="professional"><?php //esc_html_e('Professional', 'docdirect_core'); ?></label>
                                                </div>-->
                                            <!--                                                TODO:: usertype should be visitor/professional-->
                                            <!--                                                <div class="tg-radiobox user-selection active-user-type visitor-type">-->
                                            <!--                                                    <input type="radio" name="user_type" value="visitor" id="visitor">-->
                                            <!--                                                    <label for="visitor">-->
                                            <?php //esc_html_e('Visitor', 'docdirect_core'); ?><!--</label>-->
                                            <!--                                                </div>-->
                                            <!--                                            </div>-->
                                            <div class="form-group user-types">
                                                <input type="hidden" name="user_type" value="professional"
                                                       id="user_type">
                                                <select name="directory_type" id="usertypedropdown">
                                                    <option value="0">Select User Type</option>
                                                    <option value="122">Blood Donor</option>
                                                    <option value="121">Diagnostics</option>
                                                    <option value="127">Doctor</option>
                                                    <option value="126">Hospital</option>
                                                    <option value="122">Visitor</option>

                                                </select>

                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="username" class="form-control"
                                                       placeholder="<?php esc_html_e('Username', 'docdirect_core'); ?>">
                                            </div>

                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control"
                                                       placeholder="<?php esc_html_e('Email', 'docdirect_core'); ?>">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="first_name"
                                                       placeholder="<?php esc_html_e('First Name', 'docdirect_core'); ?>"
                                                       class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="last_name"
                                                       placeholder="<?php esc_html_e('Last Name', 'docdirect_core'); ?>"
                                                       class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="phone_number" class="form-control"
                                                       placeholder="<?php esc_html_e('Phone Number', 'docdirect_core'); ?>">
                                            </div>


                                            <div class="form-group">
                                                <input type="password" name="password" autocomplete="off"
                                                       class="form-control"
                                                       placeholder="<?php esc_html_e('Password', 'docdirect_core'); ?>">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="confirm_password" autocomplete="off"
                                                       class="form-control"
                                                       placeholder="<?php esc_html_e('Confirm Password', 'docdirect_core'); ?>">

                                            </div>
                                            <div class="form-group">
                                                <select name="division_id" id="division_id" class="form-control">
                                                    <option>Selects Division</option>
                                                    <?php
                                                    global $wpdb;
                                                    $divisionSql = "select id, title,title_en from loc_divisions where status='1'";
                                                    $divisions = $wpdb->get_results($divisionSql);

                                                    ?>
                                                    <?php foreach ($divisions as $division) { ?>

                                                        <option value="<?= $division->id; ?>"><?= $division->title_en ?></option>
                                                    <?php } ?>
                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <select name="district_id" id="district_id" class="form-control">
                                                    <option value="">Select District</option>

                                                </select>
                                            </div>
                                            <div class="form-group">

                                                <select name="upazila_id" id="upazila_id" class="form-control">
                                                    <option>Select Upazila</option>
                                                </select>
                                            </div>

                                            <div style="display: none" class="form-group" style="display: none;">
                                                <select name="union_id" id="union_id" class="form-control">
                                                    <option value="">Select Union</option>
                                                    <option>Dhaka</option>
                                                </select>
                                            </div>
                                            <div class="form-group tg-checkbox">
                                                <input name="terms" type="hidden" value="0"/>
                                                <label>
                                                    <input name="terms" class="form-control" type="checkbox">
                                                    <?php if (!empty($terms_link)) { ?>
                                                        <a target="_blank" href="<?php echo esc_url($terms_link); ?>"
                                                           title="<?php esc_attr_e('Terms', 'docdirect_core'); ?>">
                                                            <?php esc_html_e(' I agree with the terms and conditions', 'docdirect_core'); ?></a>
                                                    <?php } else { ?>
                                                        <?php esc_html_e(' I agree with the terms and conditions', 'docdirect_core'); ?>
                                                    <?php } ?>
                                                </label>
                                            </div>
                                            <?php
                                            if (isset($captcha_settings)
                                                && $captcha_settings === 'enable'
                                            ) {
                                                ?>
                                                <div class="domain-captcha">
                                                    <div id="recaptcha_signup"></div>
                                                </div>
                                            <?php } ?>

                                            <button class="tg-btn tg-btn-lg  do-register-button"
                                                    type="button"><?php esc_html_e('Create an Account', 'docdirect_core'); ?></button>
                                        </fieldset>
                                    </form>
                                <?php }
                            } else { ?>
                                <div class="tg-form-modal">
                                    <p class="alert alert-info theme-notification"><?php esc_html_e('Registration is disabled by administrator', 'docdirect_core'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="ambulance-booking-modal" class="modal fade" role="dialog">
                <style>
                    .ambulance-booking-popup-body {
                        background: #007AA5;
                        color: #fff;
                    }

                    h1.ambulance-booking-popup-body {
                        color: #fff !important;
                    }
                </style>
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content  ambulance-booking-popup-body">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title ambulance-booking-popup-heading">Ambulance Booking</h4>
                        </div>
                        <div class="modal-body">
                            <div class="card card-6">

                                <div class="card-body">
                                    <?php if (isset($message)): ?>
                                        <?php
                                        echo $message;
                                        //global $wp_query, $current_user;
                                        //$author_profile = $wp_query->get_queried_object();
                                        ?>
                                    <?php
                                    endif;
                                    ?>
                                    <form method="POST" action="<?= site_url('ambulance-booking') ?>">

                                        <div class="form-row">
                                            <div class="name">Ambulance Type</div>
                                            <?php
                                            global $author_profile;

                                            ?>
                                            <div class="value m-b-25">
                                                <input type="hidden" name="user_id"
                                                       value="<?php echo $author_profile->ID
                                                       ?>">

                                                <select name="ambulance_type"
                                                        style="text-transform: uppercase; font-weight: 700"
                                                        class="input--style-6" required>
                                                    <option value="" selected disabled>Select Ambulance Type</option>
                                                    <option value="Ac">Ac Ambulance</option>
                                                    <option value="Non-Ac"> Non-Ac Ambulance</option>
                                                    <option value="ICU"> ICU Ambulance</option>
                                                    <option value="NICU"> NICU Ambulance</option>
                                                    <option value="Freezer Van"> Freezer Van Ambulance</option>
                                                    <option value="Air"> Air Ambulance</option>
                                                </select>
                                            </div>

                                            <div class="name">Departing Date</div>
                                            <div class="value m-b-25">
                                                <input class="input--style-6" type="date" name="booking_date" required>
                                            </div>

                                            <div class="name">Start from</div>
                                            <div class="value m-b-25">
                                                <input class="input--style-6" type="text"
                                                       placeholder="Enter starting location"
                                                       name="start_from" required>
                                            </div>


                                            <div class="name">Destination</div>
                                            <div class="value m-b-25">
                                                <input class="input--style-6" type="text"
                                                       placeholder="Enter destination location"
                                                       name="destination" required>
                                            </div>

                                            <div class="name">Select Trip Type</div>
                                            <div class="value m-b-25">

                                                <select name="trip_type" class="input--style-6" id="sel1" required>
                                                    <option value="" selected disabled>Select Type</option>
                                                    <option value="Single Trip">Single Trip</option>
                                                    <option value="Round Trip">Round Trip</option>

                                                </select>
                                            </div>

                                            <div class="name">Name</div>
                                            <div class="value m-b-25">
                                                <input class="input--style-6" type="text"
                                                       placeholder="Enter your full name"
                                                       name="full_name" required>
                                            </div>

                                            <div class="name">Email</div>
                                            <div class="value m-b-25">
                                                <input class="input--style-6" type="text"
                                                       placeholder="Enter your email here"
                                                       name="email" required>
                                            </div>

                                            <div class="name">Contact No</div>
                                            <div class="value m-b-25">
                                                <input class="input--style-6 m-b-25" type="text"
                                                       placeholder="Contact No"
                                                       name="contact_no" required>
                                            </div>

                                            <div class="name">Reference ID</div>
                                            <div class="value m-b-25">
                                                <input class="input--style-6" type="text"
                                                       placeholder="Enter reference id if available"
                                                       name="reference_id" required>
                                            </div>
                                            <br>
                                            <div class="value m-b-25">
                                                <button class="btn btn--radius-2 btn--blue-2 btn btn-primary"
                                                        id="ambulanceBookingbtn"
                                                        type="submit">Submit
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <style>
                            .name {
                                font-weight: 700;
                            }

                        </style>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
            <!-----Ambulance Booking Popup End---->
            <?php
        }

        /**
         * @User Authentication page
         * @return {HTML}
         **/
        public function user_authentication_page()
        {
            $enable_resgistration = '';
            $enable_login = '';
            $captcha_settings = '';
            $terms_link = '';
            $dir_profile_page = '';

            if (function_exists('fw_get_db_settings_option')) {
                $enable_resgistration = fw_get_db_settings_option('registration', $default_value = null);
                $enable_login = fw_get_db_settings_option('enable_login', $default_value = null);
                $captcha_settings = fw_get_db_settings_option('captcha_settings', $default_value = null);
                $terms_link = fw_get_db_settings_option('terms_link', $default_value = null);
                $dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
            }

            $profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
            ?>
            <div class="authentication-page-template">
                <?php
                if (is_user_logged_in()) {
                    global $current_user;

                    $username = $current_user->first_name . ' ' . $current_user->last_name;
                    ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="doc-myaccount-content">
                            <p><?php esc_html_e('Hello', 'docdirect_core'); ?>
                                <strong><?php echo esc_attr($username); ?></strong>
                                (<?php esc_html_e('not', 'docdirect_core'); ?> <?php echo esc_attr($username); ?>? <a
                                        href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>"><?php esc_html_e('Sign out', 'docdirect_core'); ?></a>)
                            </p>

                            <p><?php esc_html_e('You can view your dashboard here', 'docdirect_core'); ?>&nbsp;<a
                                        href="<?php DocDirect_Scripts::docdirect_profile_menu_link($profile_page, 'dashboard', $current_user->ID); ?>"><?php esc_html_e('View', 'docdirect_core'); ?></a>
                            </p>

                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                        <div class="Login-page-wrap tg-haslayout">
                            <div class="doc-section-heading"><h2><?php esc_html_e('Sign In', 'docdirect_core'); ?></h2>
                                <span><?php esc_html_e('Sign In with your username and password', 'docdirect_core'); ?></span>
                            </div>
                            <?php if ($enable_login == 'enable') {
                                if (apply_filters('docdirect_is_user_logged_in', 'check_user') === false) {

                                    //Demo Ready
                                    $demo_username = '';
                                    $demo_pass = '';
                                    if (isset($_SERVER["SERVER_NAME"])
                                        && $_SERVER["SERVER_NAME"] === 'themographics.com') {
                                        $demo_username = 'demo';
                                        $demo_pass = 'demo';
                                    }

                                    if (function_exists('fw_get_db_settings_option')) {
                                        $site_key = fw_get_db_settings_option('site_key');
                                    } else {
                                        $site_key = '';
                                    }

                                    $forgot_passwrod = wp_lostpassword_url('/');

                                    ?>
                                    <form class="tg-form-modal tg-form-signin do-login-form">
                                        <fieldset>
                                            <div class="form-group">
                                                <input type="text" name="username"
                                                       value="<?php echo esc_attr($demo_username); ?>"
                                                       placeholder="<?php esc_html_e('User Name', 'docdirect_core'); ?>"
                                                       class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <input type="password" name="password"
                                                       value="<?php echo esc_attr($demo_pass); ?>" class="form-control"
                                                       placeholder="<?php esc_html_e('Password', 'docdirect_core'); ?>">
                                            </div>
                                            <div class="form-group tg-checkbox">
                                                <label>
                                                    <input type="checkbox" class="form-control">
                                                    <?php esc_html_e('Remember Me', 'docdirect_core'); ?>
                                                </label>
                                                <a class="tg-forgot-password" href="javascript:;">
                                                    <i><?php esc_html_e('Forgot Password', 'docdirect_core'); ?></i>
                                                    <i class="fa fa-question-circle"></i>
                                                </a>
                                            </div>
                                            <?php
                                            if (isset($captcha_settings)
                                                && $captcha_settings === 'enable'
                                            ) {
                                                ?>
                                                <div class="domain-captcha">
                                                    <div id="recaptcha_signin"></div>
                                                </div>
                                            <?php } ?>
                                            <button class="tg-btn tg-btn-lg do-login-button"><?php esc_html_e('LOGIN now', 'docdirect_core'); ?></button>
                                        </fieldset>
                                    </form>
                                <?php }
                            } else { ?>
                                <div class="tg-form-modal">
                                    <p class="alert alert-info theme-notification"><?php esc_html_e('Sign In is disabled by administrator', 'docdirect_core'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="registration-page-wrap tg-haslayout">
                            <div class="doc-section-heading"><h2><?php esc_html_e('Sign Up', 'docdirect_core'); ?></h2>
                                <span><?php esc_html_e('Sign Up as Vistor or professional.', 'docdirect_core'); ?></span>
                            </div>
                            <?php
                            if ($enable_resgistration == 'enable') {
                                if (apply_filters('docdirect_is_user_logged_in', 'check_user') === false) { ?>
                                    <form class="tg-form-modal tg-form-signup do-registration-form">
                                        <fieldset>
                                            <div class="form-group">
                                                <div class="tg-radiobox user-selection active-user-type">
                                                    <input type="radio" checked="checked" name="user_type"
                                                           value="professional" id="professional">
                                                    <label for="professional"><?php esc_html_e('Professional', 'docdirect_core'); ?></label>
                                                </div>
                                                <div class="tg-radiobox user-selection active-user-type visitor-type">
                                                    <input type="radio" name="user_type" value="visitor" id="visitor">
                                                    <label for="visitor"><?php esc_html_e('Visitor', 'docdirect_core'); ?></label>
                                                </div>
                                            </div>
                                            <div class="form-group user-types">
                                                <select id="user_type" onchange="myFunction()" name="directory_type">

                                                    <option value="0">Select User Type</option>
                                                    <option value="127">Doctor</option>
                                                    <option value="126">Hospital</option>
                                                    <option value="122">Blood Donor</option>

                                                </select>
                                            </div>
                                            <div class="form-group" id="bmdc_registration_number_block"
                                                 style="display: none">
                                                <input type="text" name="bmdc_registration_number" class="form-control"
                                                       placeholder="Bmdc Registration number">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="username" class="form-control"
                                                       placeholder="<?php esc_html_e('Username', 'docdirect_core'); ?>">
                                            </div>
                                            <!--                                            changes from here-->
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control"
                                                       placeholder="<?php esc_html_e('Email', 'docdirect_core'); ?>">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="first_name"
                                                       placeholder="<?php esc_html_e('First Name', 'docdirect_core'); ?>"
                                                       class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="last_name"
                                                       placeholder="<?php esc_html_e('Last Name', 'docdirect_core'); ?>"
                                                       class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="phone_number" class="form-control"
                                                       placeholder="<?php esc_html_e('Phone Number', 'docdirect_core'); ?>">
                                            </div>

                                            <div class="form-group">
                                                <input type="password" name="password" autocomplete="off"
                                                       class="form-control"
                                                       placeholder="<?php esc_html_e('Password', 'docdirect_core'); ?>">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="confirm_password" autocomplete="off"
                                                       class="form-control"
                                                       placeholder="<?php esc_html_e('Confirm Password', 'docdirect_core'); ?>">

                                            </div>
                                            <div class="form-group">
                                                <select name="division_id" id="division_id" class="form-control">
                                                    <option>Select Division</option>
                                                    <?php
                                                    global $wpdb;
                                                    $divisionSql = "select id, title,title_en from loc_divisions where status='1'";
                                                    $divisions = $wpdb->get_results($divisionSql);

                                                    ?>
                                                    <?php foreach ($divisions as $division) { ?>

                                                        <option value="<?= $division->id; ?>"><?= $division->title_en ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <select name="district_id" id="district_id" class="form-control">
                                                    <option value="">Select District</option>

                                                </select>
                                            </div>
                                            <div class="form-group">

                                                <select name="upazila_id" id="upazila_id" class="form-control">
                                                    <option>Select Upazila</option>
                                                </select>
                                            </div>

                                            <div class="form-group" style="display: none">
                                                <select name="union_id" id="union_id" class="form-control">
                                                    <option value="">Select Union</option>
                                                    <option>Dhaka</option>
                                                </select>
                                            </div>


                                            <div class="form-group tg-checkbox">
                                                <input name="terms" type="hidden" value="0"/>
                                                <label>
                                                    <input name="terms" class="form-control" type="checkbox">
                                                    <?php if (!empty($terms_link)) { ?><a target="_blank"
                                                                                          href="<?php echo esc_url($terms_link); ?>"
                                                                                          title="<?php esc_attr_e('Terms', 'docdirect_core'); ?>">
                                                        <?php esc_html_e(' I agree with the terms and conditions', 'docdirect_core'); ?></a>
                                                    <?php } else { ?>
                                                        <?php esc_html_e(' I agree with the terms and conditions', 'docdirect_core'); ?>
                                                    <?php } ?>
                                                </label>
                                            </div>

                                            <?php
                                            if (isset($captcha_settings)
                                                && $captcha_settings === 'enable'
                                            ) {
                                                ?>
                                                <div class="domain-captcha">
                                                    <div id="recaptcha_signup"></div>
                                                </div>
                                            <?php } ?>

                                            <button class="tg-btn tg-btn-lg  do-register-button"
                                                    type="button"><?php esc_html_e('Create an Account', 'docdirect_core'); ?></button>
                                        </fieldset>
                                    </form>
                                <?php }
                            } else { ?>
                                <div class="tg-form-modal">
                                    <p class="alert alert-info theme-notification"><?php esc_html_e('Registration is disabled by administrator', 'docdirect_core'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php
        }
    }

    new SC_Authentication();
}
?>