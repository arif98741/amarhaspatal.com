<?php
/**
 * @Class footers
 *
 */
if (!class_exists('docdirect_footers')) {

    class docdirect_footers
    {

        function __construct()
        {
            add_action('docdirect_prepare_footers', array(&$this, 'docdirect_prepare_footer'));
        }

        /**
         * @Prepare Top Strip
         * @return {}
         */
        public function docdirect_prepare_footer()
        {
            $footer_copyright = '&copy;' . date('Y') . esc_html__(' | All Rights Reserved ', 'docdirect') . get_bloginfo();
            $enable_widget_area = '';
            $enable_registration = '';
            $enable_login = '';

            if (function_exists('fw_get_db_settings_option')) {
                $footer_type = fw_get_db_settings_option('footer_type', $default_value = null);
                $enable_widget_area = fw_get_db_settings_option('enable_widget_area', $default_value = null);
                $footer_copyright = fw_get_db_settings_option('footer_copyright', $default_value = null);
                $enable_registration = fw_get_db_settings_option('registration', $default_value = null);
                $enable_login = fw_get_db_settings_option('enable_login', $default_value = null);
            }
            ?>
            </main>
            <?php
            if (isset($footer_type['gadget']) && $footer_type['gadget'] === 'footer_v2') {
                $this->docdirect_prepare_footer_v2();

                //Forgot password
                if (!is_user_logged_in()) {
                    do_shortcode('[user_lostpassword]');
                }

                //Check if Auth Key is not empty then call the hook
                if (!empty($_GET['activation_key'])) {
                    $verify_key = $_GET['activation_key'];
                    do_action('docdirect_welcome_page', $verify_key);
                }

                //Reset Model
                if (!empty($_GET['key'])
                    &&
                    (isset($_GET['action']) && $_GET['action'] == "reset_pwd")
                    &&
                    (!empty($_GET['login']))
                ) {
                    do_action('docdirect_reset_password_form');
                }

            } else { ?>
                <footer id="footer" class="tg-haslayout footer-v1">
                    <?php if (isset($enable_widget_area) && $enable_widget_area === 'on') { ?>
                        <div class="tg-threecolumn">
                            <div class="container">
                                <div class="row">
                                    <?php if (is_active_sidebar('footer-column-1')) { ?>
                                        <div class="col-sm-4">
                                            <div class="tg-footercol"><?php dynamic_sidebar('footer-column-1'); ?></div>
                                        </div>
                                    <?php } ?>
                                    <?php if (is_active_sidebar('footer-column-2')) { ?>
                                        <div class="col-sm-4">
                                            <div class="tg-footercol"><?php dynamic_sidebar('footer-column-2'); ?></div>
                                        </div>
                                    <?php } ?>
                                    <?php if (is_active_sidebar('footer-column-3')) { ?>
                                        <div class="col-sm-4">
                                            <div class="tg-footercol"><?php dynamic_sidebar('footer-column-3'); ?></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($footer_copyright) && $footer_copyright != '') { ?>
                        <div class="tg-footerbar tg-haslayout">
                            <div class="tg-copyrights">
                                <p><?php echo force_balance_tags($footer_copyright); ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </footer>
                <?php
                //Account Verifications Model
                if (!empty($_GET['key']) && !empty($_GET['verifyemail'])) {
                    do_action('docdirect_verify_user_account');
                }

                //Registration modal
                if ((isset($enable_login) && $enable_login === 'enable')
                    || (isset($enable_registration) && $enable_registration === 'enable')
                ) {
                    do_shortcode('[user_authentication]'); //Code Moved To due to plugin territory
                }

                //Forgot password
                if (!is_user_logged_in()) {
                    do_shortcode('[user_lostpassword]');
                }

                //Check if Auth Key is not empty then call the hook
                if (!empty($_GET['activation_key'])) {
                    $verify_key = $_GET['activation_key'];
                    do_action('docdirect_welcome_page', $verify_key);
                }

                //Reset Model
                if (!empty($_GET['key'])
                    &&
                    (isset($_GET['action']) && $_GET['action'] == "reset_pwd")
                    &&
                    (!empty($_GET['login']))
                ) {
                    do_action('docdirect_reset_password_form');
                }
            } ?>
            </div>
            <?php
        }

        /**
         * @Prepare Top Strip
         * @return {}
         */
        public function docdirect_prepare_footer_v2()
        {
            $footer_copyright = '&copy;' . date('Y') . esc_html__(' | All Rights Reserved ', 'docdirect') . get_bloginfo();
            $enable_widget_area = '';
            $enable_registration = '';
            $enable_login = '';
            $footer_type = '';

            if (function_exists('fw_get_db_settings_option')) {
                $footer_type = fw_get_db_settings_option('footer_type', $default_value = null);
                $enable_widget_area = fw_get_db_settings_option('enable_widget_area', $default_value = null);
                $footer_copyright = fw_get_db_settings_option('footer_copyright', $default_value = null);
                $enable_registration = fw_get_db_settings_option('registration', $default_value = null);
                $enable_login = fw_get_db_settings_option('enable_login', $default_value = null);
            }

            ?>
            <footer id="doc-footer"
                    class="doc-footer doc-haslayout footer-v2">
                <?php if (!empty($footer_type['footer_v2']['newsletter']) && $footer_type['footer_v2']['newsletter'] === 'enable') { ?>
                    <div class="doc-newsletter" style="display: none">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-offset-1 col-sm-10">
                                    <?php if (!empty($footer_type['footer_v2']['newsletter_title']) || $footer_type['footer_v2']['newsletter_desc']) { ?>
                                        <div class="col-sm-5">
                                            <div class="doc-newslettercontent">
                                                <?php if (!empty($footer_type['footer_v2']['newsletter_title'])) { ?>
                                                    <h2><?php echo esc_attr($footer_type['footer_v2']['newsletter_title']); ?></h2> <?php } ?>
                                                <?php if ($footer_type['footer_v2']['newsletter_desc']) { ?>
                                                    <div class="doc-description">
                                                        <p><?php echo esc_attr($footer_type['footer_v2']['newsletter_desc']); ?></p>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="col-sm-7">
                                        <form class="doc-formtheme doc-formnewsletter">
                                            <fieldset>
                                                <div class="form-group">
                                                    <input type="email" name="email" class="form-control"
                                                           placeholder="<?php esc_attr_e('Enter Email Here', 'docdirect'); ?>">
                                                </div>
                                                <a class="doc-btnsubscribe subscribe_me" href="javascript:;"><i
                                                            class="fa fa-paper-plane"></i></a>
                                            </fieldset>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (isset($enable_widget_area) && $enable_widget_area === 'on') { ?>
                    <div class="doc-footermiddlebar">
                        <div class="container">
                            <div class="row">
                                <div class="doc-fcols">
                                    <?php if (is_active_sidebar('footer-column-1')) { ?>
                                        <div class="col-sm-4 col-xs-12">
                                            <div class="doc-fcol"><?php dynamic_sidebar('footer-column-1'); ?></div>
                                        </div>
                                    <?php } ?>
                                    <?php if (is_active_sidebar('footer-column-2')) { ?>
                                        <div class="col-sm-4 col-xs-12">
                                            <div class="doc-fcol">
                                                <div id="doc_widgetdoctorlisting-2"
                                                     class="doc-widget doc-widgetdoctorlisting tg-widget">
                                                    <div class="tg-heading-border tg-small"><h4>Latest Listings</h4>
                                                    </div>
                                                    <div class="doc-widgetcontent">
                                                        <ul>

                                                            <?php
                                                            $args = array(
                                                                'orderby' => 'registered', // registered date
                                                                'order' => 'DESC', // last registered goes first
                                                                'number' => 6, // limit to the last one, not required,
                                                                'offset' => 2
                                                            );

                                                            $users = get_users($args);
                                                            foreach ($users as $user) {
                                                                $userMeta = get_user_meta($user->ID);
//                                                                echo '<pre>';
//                                                                print_r($userMeta);
//                                                                echo '</pre>';

                                                                $userType = get_user_meta($user->id, 'directory_type', true);
                                                                $firstName = get_user_meta($user->id, 'first_name', true);
                                                                $lastName = get_user_meta($user->id, 'last_name', true);
                                                                $userNicename = get_user_meta($user->id, 'user_nicename', true);
                                                                $avatar = apply_filters(
                                                                    'docdirect_get_user_avatar_filter',
                                                                    docdirect_get_user_avatar(array('width' => 270, 'height' => 270), $user->ID),
                                                                    array('width' => 270, 'height' => 270) //size width,height
                                                                );
                                                                if (empty($userType))
                                                                    continue;

                                                                ?>

                                                                <li>
                                                                    <figure>

                                                                        <?php if ($userType == 127 && empty($avatar)): ?>
                                                                            <a href="<?php echo site_url(); ?>/hospital/<?php echo $userNicename; ?>">
                                                                                <img src="<?php echo site_url(); ?>/wp-content/uploads/directory-list-banner/ambulance_default.png"
                                                                                     alt="<?= $firstName . ' - ' . site_url(); ?>"/></a>
                                                                        <?php else: ?>
                                                                            <a href="<?php echo site_url(); ?>/hospital/<?php echo $userNicename; ?>">
                                                                                <img src="<?= $avatar ?>"
                                                                                     alt="<?= $firstName. ' - ' . site_url(); ?>"/></a>
                                                                        <?php endif; ?>

                                                                    </figure>
                                                                    <div class="doc-doctorname">

                                                                        <h3>
                                                                            <?php
                                                                            if ($userType == 126) { ?>

                                                                                <a href="<?php echo site_url(); ?>/hospital/<?php echo $userNicename; ?>"><?php echo $firstName . ' ' . $lastName; ?></a>
                                                                            <?php } ?>
                                                                            <?php
                                                                            if ($userType == 127) { ?>

                                                                                <a href="<?php echo site_url(); ?>/doctor/<?php echo $userNicename; ?>"><?php echo $firstName . ' ' . $lastName; ?></a>
                                                                            <?php } ?>
                                                                            <?php
                                                                            if ($userType == 123) { ?>

                                                                                <a href="<?php echo site_url(); ?>/ambulance/<?php echo $userNicename; ?>"><?php echo $firstName . ' ' . $lastName; ?></a>
                                                                            <?php } ?>
                                                                            <?php
                                                                            if ($userType == 121) { ?>

                                                                                <a href="<?php echo site_url(); ?>/dianostics/<?php echo $userNicename; ?>"><?php echo $firstName . ' ' . $lastName; ?></a>
                                                                            <?php } ?>
                                                                            <?php
                                                                            if ($userType == 122) { ?>

                                                                                <a href="<?php echo site_url(); ?>/blood-donor/<?php echo $userNicename; ?>"><?php echo $firstName . ' ' . $lastName; ?></a>
                                                                            <?php } ?>


                                                                        </h3>
                                                                    </div>
                                                                </li>
                                                            <?php } ?>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if (is_active_sidebar('footer-column-3')) { ?>
                                        <div class="col-sm-4 col-xs-12">
                                            <div class="doc-fcol">
                                                <div id="nav_menu-2" class="widget_nav_menu tg-widget">
                                                    <div class="tg-heading-border tg-small">
                                                        <h4>USEFUL LINKS</h4>
                                                    </div>
                                                    <div class="menu-userfull-links-container">
                                                        <ul id="menu-userfull-links" class="menu">
                                                            <li id="menu-item-143"
                                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-143">
                                                                <a href="<?php echo site_url(); ?>/contact-us">Contact
                                                                    Us</a></li>
                                                            <li id="menu-item-3921"
                                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3921">
                                                                <a href="<?php echo site_url(); ?>/about-us/">About
                                                                    Us</a></li>
                                                            <li id="menu-item-4222"
                                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4222">
                                                                <a href="<?php echo site_url(); ?>/faq/">Faq</a></li>
                                                            <li id="menu-item-4222"
                                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4222">
                                                                <a href="<?php echo site_url(); ?>/apps">Apps</a></li>

                                                            <li id="menu-item-3063"
                                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3063">
                                                                <a href="<?php echo site_url(); ?>/privacy-policy">Privacy
                                                                    Policy</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="doc-footerbottombar" style="margin-top: 10px;">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-4">

                                <p class="copyright-text">Copyright ©<?= date('Y') ?> AMARHASPATAL.COM. All Rights
                                    Reserved</p>
                            </div>
                            <div class="col-md-4 footer-social-icon-div">

                                <ul class="tg-socialicon">
                                    <?php
                                    if (function_exists('fw_get_db_settings_option')) {
                                        $header_type = fw_get_db_settings_option('header_type');

                                    }
                                    $social_icons = $header_type['header_v2']['social_icons'];
                                    if (isset($social_icons) && !empty($social_icons)) {
                                        foreach ($social_icons as $social) {
                                            ?>
                                            <li>
                                                <?php
                                                $url = '';
                                                if (isset($social['social_url']) && !empty($social['social_url'])) {
                                                    $url = 'href="' . esc_url($social['social_url']) . '"';
                                                } else {
                                                    $url = 'href="#"';
                                                }
                                                ?>
                                                <a target="_blank" <?php echo($url); ?>>
                                                    <?php if (isset($social['social_icons_list']) && !empty($social['social_icons_list'])) { ?>
                                                        <i class="<?php echo esc_attr($social['social_icons_list']); ?>"></i>
                                                    <?php } ?>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <p style="color: #fff !important; text-align: right" class="copyright-text">Designed and
                                    Developed by <a
                                            style="color: #fff"
                                            href="https://softbdltd.com/"
                                            target="_blank"><img
                                                src="<?php echo site_url(); ?>/wp-content/uploads/softbdltd.png" alt=""></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- sidebar menu start -->
                <style>
                    .sidenav {
                        display: none;
                        height: 100%;
                        width: 325px;
                        position: fixed;
                        z-index: 9999999;
                        top: 0;
                        right: 0;
                        background-color: #f3f3f3;
                        overflow-x: hidden;
                        padding-top: 60px;
                        padding: 20px;
                    }

                    .sidenav a {
                        padding: 8px 8px 8px 32px;
                        text-decoration: none;
                        font-size: 18px;
                        color: #818181;
                        display: block;
                    }

                    .sidenav a:hover {
                        color: #818181;
                    }

                    .sidenav .closebtn {
                        position: absolute;
                        top: 0;
                        right: 25px;
                        font-size: 36px;
                        margin-left: 50px;
                    }

                    #contact-section ul {
                        margin-top: 10px;
                    }

                    #contact-section ul li {
                        list-style: none;
                        padding: 2px 8px;
                        color: #6b5e5e;
                    }

                    li.custom-sidebar-menu-icon.menu-item a:before {
                        color: #000 !important;
                    }

                    @media only screen and (max-width: 600px) {
                        i.fa.fa-bars.menu-item-4406 {
                            float: right;
                            margin: 30px 0px 0px 0px;
                            font-size: 30px;
                        }

                    }

                    @media (min-width: 768px) {
                        .hidden-md-up {
                            display: none !important;
                        }

                        nav.animated.bounceInDown ul {
                            display: block;
                        }
                    }

                    @media (max-width: 767px) {
                        .nav.animated.bounceInDown, .sub-menu {

                            display: block !important;
                        }
                    }

                    nav.animated.bounceInDown ul li a {
                        font-size: 14px;
                        padding: 5px 10px;
                    }


                    nav.animated.bounceInDown ul li {
                        line-height: 15px;
                        list-style: none;
                    }

                    nav#sidebarNav {
                        position: relative;
                        margin: 50px;
                        width: 360px;
                    }

                    nav#sidebarNav ul {
                        list-style: none;
                        margin: 0;
                        padding: 0;
                    }

                    nav#sidebarNav ul li a {
                        display: block;
                        background: #ebebeb;
                        padding: 10px 15px;
                        color: #333;
                        text-decoration: none;
                        -webkit-transition: 0.2s linear;
                        -moz-transition: 0.2s linear;
                        -ms-transition: 0.2s linear;
                        -o-transition: 0.2s linear;
                        transition: 0.2s linear;
                    }

                    nav#sidebarNav ul li a:hover {
                        background: #f8f8f8;
                        color: #515151;
                    }

                    nav#sidebarNav ul li a .fa {
                        width: 16px;
                        text-align: center;
                        margin-right: 5px;
                        float: right;
                    }

                    nav#sidebarNav ul ul {
                        background-color: #ebebeb;
                    }

                    nav#sidebarNav ul li ul li a {
                        background: #f8f8f8;
                        border-left: 4px solid transparent;
                        padding: 10px 20px;
                    }

                    nav#sidebarNav ul li ul li a:hover {
                        background: #ebebeb;
                        border-left: 4px solid #3498db;
                    }
                </style>
                <div id="mySidenav" class="sidenav">
                    <br>
                    <br>
                    <br>
                    <br>
                    <img src="<?php echo site_url(); ?>/wp-content/uploads/2020/08/hsp-150x30-1.png" alt="">
                    <br>
                    <br>

                    <nav class='animated bounceInDown'>
                        <ul>
                            <li><a href="<?php echo site_url(); ?>">Home</a></li>
                            <li><a href="<?php echo site_url(); ?>/about-us">About Us</a></li>
                            <li class='sub-menu'><a href='#settings'>Services
                                    <div class='fa fa-caret-down right'></div>
                                </a>
                                <ul>
                                    <li><a href="<?php echo site_url(); ?>/shop">Pharmacy</a></li>
                                    <li><a href="<?php echo site_url(); ?>/dir-search/?directory_type=127">Doctors</a>
                                    </li>
                                    <li><a href="<?php echo site_url(); ?>/dir-search/?directory_type=123">Ambulance</a>
                                    </li>
                                    <li><a href="<?php echo site_url(); ?>/dir-search/?directory_type=122">Blood
                                            Donor</a></li>
                                    <li>
                                        <a href="<?php echo site_url(); ?>/dir-search/?directory_type=121">Diagnostics</a>
                                    </li>
                                    <li><a href="<?php echo site_url(); ?>/dir-search/?directory_type=126">Hospitals</a>
                                    </li>

                                </ul>
                            </li>
                            <li class='sub-menu'><a href="#message">Blog
                                    <div class='fa fa-caret-down right'></div>
                                </a>
                                <ul>
                                    <li><a href="<?php echo site_url(); ?>/category/male-health/">Male Health</a></li>
                                    <li><a href="<?php echo site_url(); ?>/category/female-health/">Female Health</a>
                                    </li>
                                    <li><a href="<?php echo site_url(); ?>/category/baby-health/">Baby Health</a></li>

                                </ul>
                            </li>

                        </ul>
                    </nav>

                    <a href="javascript:void(0)" class="closebtn" id="closeSidebarbtn"">&times;</a>

                    <div id="contact-section">
                        <ul>
                            <li>Support: Ambulance: <i class="fa fa-phone text-theme-colored"></i>&nbsp;01734-500971
                            </li>
                            <li>Doctor: <i class="fa fa-phone text-theme-colored"></i>&nbsp;01711-226820</li>
                            <li><i class="fa fa-clock-o text-theme-colored"></i>&nbsp;24h x 365 Days</li>
                            <li><i class="fa fa-envelope-o text-theme-colored"></i>&nbsp;support@amarhaspatal.com</li>
                        </ul>

                    </div>
                    <p class="copyright-text" style="margin-top: 40px;">&copy;Copyright: amarhaspatal.com - 2020</p>

                </div>
                </div>

                <!-- sidebar menu end -->

            </footer>
            <?php
            //Account Verifications Model
            if (!empty($_GET['key']) && !empty($_GET['verifyemail'])) {
                do_action('docdirect_verify_user_account');
            }

            //Registration modal
            if ((isset($enable_login) && $enable_login === 'enable')
                || (isset($enable_registration) && $enable_registration === 'enable')
            ) {
                do_shortcode('[user_authentication]'); //Code Moved To due to plugin territory
            }
        }

    }

    new docdirect_footers();
}