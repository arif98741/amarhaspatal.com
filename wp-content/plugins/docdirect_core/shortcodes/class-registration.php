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
                                                <select name="division_id" ` class="form-control division_id">
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
                                                <select name="district_id" class="form-control district_id">
                                                    <option value="">Select District</option>

                                                </select>
                                            </div>
                                            <div class="form-group">

                                                <select name="upazila_id" class="form-control upazila_id">
                                                    <option>Select Upazila</option>
                                                </select>
                                            </div>

                                            <div style="display: none" class="form-group" style="display: none;">
                                                <select name="union_id" class="form-control union_id">
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
            <!--            Login Modal Start-->
            <div id="login-modal-front" class="modal fade" role="dialog">

                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content ">
                        <div class="modal-title">
                            <h4 style="text-align: left; padding: 10px 30px">Login to Amarhaspatal <span
                                        style="display: block;text-align: right;margin-bottom: 0px;cursor: pointer;"
                                        type="button"
                                        data-dismiss="modal">X</span>
                            </h4>

                        </div>
                        <div class="modal-body">
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
                        </div>

                        <div class="modal-footer">
                        </div>
                    </div>

                </div>
            </div>
            <!--            Login Modal End-->

            <!--            Registration Modal Start-->
            <div id="registration-modal-front" class="modal fade" role="dialog">

                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content ">
                        <div class="modal-title">
                            <h4>Registration Form <span
                                        style="display: block;text-align: right;margin-bottom: 0px;cursor: pointer;"
                                        type="button"
                                        data-dismiss="modal">X</span></h4>
                            <p>Please fillup the form and give proper details to complete registration at
                                amarhaspatal.com </p>
                        </div>

                        <div class="modal-body">
                            <form class="tg-form-modal tg-form-signup do-registration-form">

                                <fieldset>
                                    <!--<div class="form-group">
                                                <div class="tg-radiobox user-selection active-user-type">
                                                    <input type="radio" checked="checked" name="user_type"
                                                           value="professional" id="professional">
                                                    <label for="professional"><?php //esc_html_e('Professional', 'docdirect_core');
                                    ?></label>
                                                </div>-->
                                    <!--                                                TODO:: usertype should be visitor/professional-->
                                    <!--                                                <div class="tg-radiobox user-selection active-user-type visitor-type">-->
                                    <!--                                                    <input type="radio" name="user_type" value="visitor" id="visitor">-->
                                    <!--                                                    <label for="visitor">-->
                                    <?php //esc_html_e('Visitor', 'docdirect_core');
                                    ?><!--</label>-->
                                    <!--                                                </div>-->
                                    <!--                                            </div>-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group user-types">
                                                <input type="hidden" name="user_type" value="professional"
                                                       class="user_type">
                                                <select name="directory_type" class="usertypedropdown">
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
                                                <input type="email" name="email" class="form-control"
                                                       placeholder="<?php esc_html_e('Email', 'docdirect_core'); ?>">
                                            </div>

                                            <div class="form-group">
                                                <input type="text" name="phone_number" class="form-control"
                                                       placeholder="<?php esc_html_e('Phone Number', 'docdirect_core'); ?>">
                                            </div>


                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group bmdc_registration_no" style="display: none;">
                                                <input type="text" name="bmdc_registration_no"
                                                       placeholder="<?php esc_html_e('BMDC No.', 'docdirect_core'); ?>"
                                                       class="form-control">
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
                                                <select name="division_id" class="form-control division_id select2">
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
                                                <select name="district_id" class="form-control district_id select2">
                                                    <option value="">Select District</option>

                                                </select>
                                            </div>
                                            <div class="form-group">

                                                <select name="upazila_id" class="form-control upazila_id select2">
                                                    <option>Select Upazila</option>
                                                </select>
                                            </div>

                                        </div>
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
                        </div>

                        <div class="modal-footer">
                        </div>
                        <style>
                            .select2 {
                                width: 100% !important;
                            }
                        </style>
                    </div>

                </div>
            </div>
            <!--            Registration Modal End-->

            <!--            Ambulance Booking  Popup Modal Start-->
            <div id="ambulance-booking-modal" class="modal fade" role="dialog">

                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content  ambulance-booking-popup-body">
                        <div class="modal-header">
                            <div class="modal-title">
                                <h4 style="text-align: left; padding: 10px 30px">Book Ambulance</h4>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="<?= site_url('ambulance-booking') ?>">

                                <?php
                                global $author_profile;
                                ?>
                                <input type="hidden" name="user_id"
                                       value="<?php echo $author_profile->ID
                                       ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label>Ambulance Type</label>
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
                                        <div class="form-group">
                                            <label>Full name</label>
                                            <input class="form-control" type="text"
                                                   name="full_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" type="text"
                                                   name="email" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Contact No.</label>
                                            <input class="form-control" type="text"
                                                   name="contact no" required>
                                        </div>


                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label>Trip Type</label>
                                            <select name="trip_type" class="input--style-6" id="sel1" required>
                                                <option value="" selected disabled>Select Type</option>
                                                <option value="Single Trip">Single Trip</option>
                                                <option value="Round Trip">Round Trip</option>

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Booking Date</label>
                                            <input class="from-control" type="date" name="booking_date" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Start from</label>
                                            <input class="from-control" type="text" name="start_from" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Destination</label>
                                            <input class="from-control" type="text" name="destination" required>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Reference no.</label>
                                            <input class="form-control" type="text" name="reference_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            <button class="btn btn-primary ambulance-submit-btn" type="submit">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </form>
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

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="registration-page-wrap tg-haslayout">
                            <div class="doc-section-heading"><h2><?php esc_html_e('Sign Up', 'docdirect_core'); ?></h2>
                                <span><?php esc_html_e('Sign Up as Vistor or professional.', 'docdirect_core'); ?></span>
                            </div>
                            <?php
                            if ($enable_resgistration == 'enable') {
                                if (apply_filters('docdirect_is_user_logged_in', 'check_user') === false) { ?>
                                    <form class="tg-form-modal tg-form-signup do-registration-form" autocomplete="off">
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group user-types">
                                                        <select name="directory_type" class="usertypedropdown">
                                                            <option value="0">Select User Type</option>
                                                            <option value="122">Blood Donor</option>
                                                            <option value="121">Diagnostics</option>
                                                            <option value="127">Doctor</option>
                                                            <option value="126">Hospital</option>
                                                            <option value="122">Visitor</option>

                                                        </select>
                                                        <input type="hidden" name="user_type" value="professional"
                                                               class="user_type">
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
                                                    <div class="form-group" id="bmdc_registration_number_block"
                                                         style="display: none">
                                                        <input type="text" name="bmdc_registration_number"
                                                               class="form-control"
                                                               placeholder="BMDC No">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="username" class="form-control"
                                                               placeholder="<?php esc_html_e('Username', 'docdirect_core'); ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="password" name="password" autocomplete="off"
                                                               class="form-control"
                                                               placeholder="<?php esc_html_e('Password', 'docdirect_core'); ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="password" name="confirm_password"
                                                               autocomplete="off"
                                                               class="form-control"
                                                               placeholder="<?php esc_html_e('Confirm Password', 'docdirect_core'); ?>">

                                                    </div>

                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="email" name="email" class="form-control"
                                                               placeholder="<?php esc_html_e('Email', 'docdirect_core'); ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="text" name="phone_number" class="form-control"
                                                               placeholder="<?php esc_html_e('Phone Number', 'docdirect_core'); ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <select name="division_id" class="form-control division_id">
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
                                                        <select name="district_id" class="form-control district_id">
                                                            <option value="">Select District</option>

                                                        </select>
                                                    </div>
                                                    <div class="form-group">

                                                        <select name="upazila_id" class="form-control upazila_id">
                                                            <option>Select Upazila</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group" style="display: none">
                                                        <select name="union_id" class="form-control union_id">
                                                            <option value="">Select Union</option>
                                                            <option>Dhaka</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--                                            changes from here-->


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