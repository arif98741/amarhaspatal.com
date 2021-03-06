<?php
/**
 * User Profile Main
 * return html
 */

global $current_user, $wp_roles, $userdata, $post;
$user_identity = $current_user->ID;
$db_directory_type = get_user_meta($user_identity, 'directory_type', true);
$userMeta = get_user_meta($current_user->ID);

$user_url = '';
if (isset($db_directory_type) && !empty($db_directory_type)) {
    $current_userdata = get_userdata($user_identity);
    $user_url = $current_userdata->data->user_url;
}

//echo '<pre>';
//print_r(get_user_meta($current_user->ID)); exit;
?>
<div class="tg-bordertop tg-haslayout">
    <div class="tg-formsection">
        <div class="tg-heading-border tg-small">
            <h3><?php esc_attr_e('Basic Information', 'docdirect'); ?></h3>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <input class="form-control" name="basics[nickname]"
                           value="<?php echo get_user_meta($user_identity, 'nickname', true); ?>" type="text"
                           placeholder="<?php esc_attr_e('Nick Name', 'docdirect'); ?>">
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <input class="form-control" name="basics[first_name]"
                           value="<?php echo get_user_meta($user_identity, 'first_name', true); ?>" type="text"
                           placeholder="<?php esc_attr_e('First Name', 'docdirect'); ?>">
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <input class="form-control" name="basics[last_name]"
                           value="<?php echo get_user_meta($user_identity, 'last_name', true); ?>" type="text"
                           placeholder="<?php esc_attr_e('Last Name', 'docdirect'); ?>">
                </div>
            </div>
            <?php if ($db_directory_type == 127 ): ?>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="bmdc_registration_no"
                               value="<?php echo get_user_meta($user_identity, 'bmdc_registration_no', true); ?>"
                               type="text"
                               placeholder="<?php esc_attr_e('BMDC Regration No', 'docdirect'); ?>">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="new_patient_charge"
                               value="<?php echo get_user_meta($user_identity, 'new_patient_charge', true); ?>"
                               type="number"
                               placeholder="<?php esc_attr_e('New Patient Fee', 'docdirect'); ?>">
                    </div>
                </div>
                 <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="old_patient_charge"
                               value="<?php echo get_user_meta($user_identity, 'old_patient_charge', true); ?>"
                               type="number"
                               placeholder="<?php esc_attr_e('Old Patient Fee', 'docdirect'); ?>">
                    </div>
                </div>



            <?php endif; ?>
            <?php if ($db_directory_type == 123): ?>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="car_no" required
                               value="<?php echo get_user_meta($user_identity, 'car_no', true); ?>" type="text"
                               placeholder="<?php esc_attr_e('Car no', 'docdirect'); ?>">
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <input class="form-control" name="basics[phone_number]"
                           value="<?php echo get_user_meta($user_identity, 'phone_number', true); ?>" type="text"
                           placeholder="<?php esc_attr_e('Phone', 'docdirect'); ?>">
                </div>
            </div>
            <?php if ($db_directory_type == 122): ?>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="blood_group"
                               value="<?php echo get_user_meta($user_identity, 'blood_group', true); ?>" type="text"
                               placeholder="<?php esc_attr_e('Blood Group', 'docdirect'); ?>">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="last_donation_date"
                               value="<?php echo get_user_meta($user_identity, 'last_donation_date', true); ?>"
                               type="text"
                               placeholder="<?php esc_attr_e('Last donation date', 'docdirect'); ?>">
                    </div>
                </div>

            <?php endif; ?>


            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <input class="form-control" name="basics[fax]"
                           value="<?php echo get_user_meta($user_identity, 'fax', true); ?>" type="text"
                           placeholder="<?php esc_attr_e('Fax', 'docdirect'); ?>">
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                    <input class="form-control" name="basics[user_url]" value="<?php echo esc_attr($user_url); ?>"
                           type="url" placeholder="<?php esc_attr_e('URL', 'docdirect'); ?>">
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <input class="form-control" name="basics[tagline]"
                           value="<?php echo get_user_meta($user_identity, 'tagline', true); ?>" type="text"
                           placeholder="<?php esc_attr_e('Tagline', 'docdirect'); ?>">
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <input class="form-control" name="basics[zip]"
                           value="<?php echo get_user_meta($user_identity, 'zip', true); ?>" type="text"
                           placeholder="<?php esc_attr_e('Zip/Postal Code', 'docdirect'); ?>">
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">

                    <input class="form-control" name="basics[user_address]"
                           value="<?php echo get_user_meta($user_identity, 'user_address', true); ?>" type="text"
                           placeholder="<?php esc_attr_e('Address', 'docdirect'); ?>">
                </div>
            </div>
            <?php if (!empty($current_user->roles) && (is_array($current_user->roles) && in_array('professional', $current_user->roles)) || $current_user->roles === 'professional') { ?>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="basics[secondary_email]"
                               value="<?php echo get_user_meta($user_identity, 'secondary_email', true); ?>" type="text"
                               placeholder="<?php esc_attr_e('Secondary Email', 'docdirect'); ?>">
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <textarea class="form-control" name="basics[description]"
                              placeholder="<?php esc_attr_e('Short description', 'docdirect'); ?>"><?php echo get_user_meta($user_identity, 'description', true); ?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>