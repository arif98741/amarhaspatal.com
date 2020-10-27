<?php
/**
 * User Invoices
 * return html
 */

global $current_user, $wp_roles, $userdata, $post;
$dir_obj = new DocDirect_Scripts();
$user_identity = $current_user->ID;
$url_identity = $user_identity;

if (isset($_GET['identity']) && !empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

if (function_exists('fw_get_db_settings_option')) {
    $currency_select = fw_get_db_settings_option('currency_select');
} else {
    $currency_select = 'USD';
}


$service_chambers = get_user_meta($user_identity, 'service_chambers', true);

$booking_services = get_user_meta($user_identity, 'booking_services', true);
$custom_slots = get_user_meta($user_identity, 'custom_slots', true);
$currency_symbol = get_user_meta($user_identity, 'currency_symbol', true);

$currency_symbol = !empty($currency_symbol) ? ' (' . $currency_symbol . ')' : '';
if (!empty($custom_slots)) {
    $custom_slot_list = json_decode($custom_slots, true);
} else {
    $custom_slot_list = array();
}

$custom_slot_list = docdirect_prepare_seprate_array($custom_slot_list);
//echo '<pre>';
//print_r( $booking_services); exit;

?>
<div class="doc-booking-settings dr-bookings">
    <div class="tg-haslayout">
        <div class="booking-settings-data">
            <div class="tg-dashboard tg-docappointment tg-haslayout">
                <ul class="tg-navdocappointment" role="tablist">
                    <li role="presentation" class="active"><a href="#one" aria-controls="one" role="tab"
                                                              data-toggle="tab"><?php esc_html_e('Chambers', 'docdirect'); ?></a>
                    </li>

                </ul>
                <div class="tab-content tg-appointmenttabcontent">
                    <div role="tabpanel" class="tab-pane active" id="one">
                        <div class="tg-heading-border tg-small">
                            <h3><?php esc_html_e('My Chambers', 'docdirect'); ?></h3>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-sm-12">
                                <div class="tg-doccategoties">
                                    <div class="bk-chamber-wrapper">
                                        <?php
                                        if (!empty($service_chambers)) {
                                            foreach ($service_chambers as $key => $value) {
                                                ?>
                                                <div class="bk-chamber-item">
                                                    <div class="tg-doccategory">
                                                        <span class="tg-catename"><?php echo esc_attr($value); ?></span>
                                                        <span class="tg-catelinks">
                                                    <a href="javascript:;" class="bk-edit-chamber"><i
                                                                class="fa fa-edit"></i></a>
                                                    <a href="javascript:;" data-type="db-delete"
                                                       data-key="<?php echo esc_attr($key); ?>"
                                                       class="bk-delete-chamber"><i class="fa fa-trash-o"></i></a>
                                                </span>
                                                    </div>
                                                    <div class="tg-editcategory bk-current-chamber bk-elm-hide">
                                                        <div class="form-group">
                                                            <input data-key="<?php echo esc_attr($key); ?>" type="text"
                                                                   value="<?php echo esc_attr($value); ?>"
                                                                   class="form-control service-chamber-title"
                                                                   name="chambername"
                                                                   placeholder="<?php esc_attr_e('Category Title', 'docdirect'); ?>">
                                                        </div>
                                                        <div class="form-group tg-btnarea">
                                                            <button class="tg-update bk-mainchamber-add"
                                                                    data-key="<?php echo esc_attr($key); ?>"
                                                                    data-type="update"
                                                                    type="submit"><?php esc_html_e('Update Now', 'docdirect'); ?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <a id="search_banner" class="tg-btn tg-btn-lg bk-add-chamber-item"
                                       href="javascript:;"><?php esc_html_e('Add Chamber', 'docdirect'); ?></a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!----------------------------------------------
 * Main categories Templates
 * return HTML
------------------------------------------------>
<script type="text/template" id="tmpl-append-service-chamber">
    <div class="bk-chamber-item">
        <div class="tg-doccategory">
            <span class="tg-catename"><?php esc_html_e('Chamber Name', 'docdirect'); ?></span>
            <span class="tg-catelinks">
				<a href="javascript:;" class="bk-edit-chamber"><i class="fa fa-edit"></i></a>
				<a href="javascript:;" data-type="new-delete" data-key="" class="bk-delete-chamber"><i
                            class="fa fa-trash-o"></i></a>
			</span>
        </div>
        <div class="tg-editcategory bk-current-chamber bk-elm-hide">
            <div class="form-group">
                <input type="text" class="form-control service-chamber-title" name="chambername">
                       placeholder="<?php esc_html_e('Chamber Name', 'docdirect'); ?>">
            </div>
            <div class="form-group tg-btnarea">
                <button class="tg-update bk-mainchamber-add" data-key="new" data-type="add"
                        type="submit"><?php esc_html_e('Update Now', 'docdirect'); ?></button>
            </div>
        </div>
    </div>
</script>
<script type="text/template" id="tmpl-update-service-chamber">
    <div class="tg-doccategory">
        <span class="tg-catename">{{data.title}}</span>
        <span class="tg-catelinks">
			<a href="javascript:;" class="bk-edit-chamber"><i class="fa fa-edit"></i></a>
			<a href="javascript:;" data-type="db-delete" data-key="{{data.key}}" class="bk-delete-chamber"><i
                        class="fa fa-trash-o"></i></a>
		</span>
    </div>
    <div class="tg-editcategory bk-current-chamber bk-elm-hide">
        <div class="form-group">
            <input type="text" data-key="{{data.key}}" value="{{data.title}}"
                   class="form-control service-chamber-title" name="chambername"
                   placeholder="<?php esc_html_e('Category Title', 'docdirect'); ?>">
        </div>
        <button class="tg-update bk-mainchamber-add" data-key="{{data.key}}" data-type="update"
                type="submit"><?php esc_html_e('Update Now', 'docdirect'); ?></button>

    </div>
</script>

<!----------------------------------------------
 * Services Templates
 * return HTML
------------------------------------------------>

<script type="text/template" id="tmpl-append-service">
    <div class="bk-service-item">
        <div class="tg-subdoccategory">
            <span class="tg-catename"><?php esc_html_e('Service Title', 'docdirect'); ?></span>
            <span class="tg-catelinks">
				<a href="javascript:;" class="bk-edit-service"><i class="fa fa-edit"></i></a>
				<a href="javascript:;" data-type="new-delete" data-key="" class="bk-delete-service"><i
                            class="fa fa-trash-o"></i></a>
			</span>
            <span class="tg-serviceprice">0.00</span>
        </div>
        <div class="tg-editcategory bk-current-service bk-elm-hide">
            <div class="form-group">
                <div class="tg-select">
                    <select name="service_chamber" class="service_category">
                        <option value=""><?php esc_html_e('Select category', 'docdirect'); ?></option>
                        <# _.each( data , function( element, index, attr ) { #>
                        <option value="{{index}}">{{element}}</option>
                        <# } ); #>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <input type="text" class="form-control service-title" name="service_title"
                       placeholder="<?php esc_html_e('Service Title', 'docdirect'); ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control service-price" name="service_price"
                       placeholder="<?php esc_html_e('Add Price', 'docdirect'); ?><?php echo esc_attr($currency_symbol); ?>">
            </div>
            <div class="form-group tg-btnarea">
                <button class="tg-update  bk-service-add" data-key="new" data-type="add"
                        type="submit"><?php esc_html_e('Update Now', 'docdirect'); ?></button>
            </div>
        </div>
    </div>
</script>

<script type="text/template" id="tmpl-update-service">
    <div class="tg-subdoccategory">
        <span class="tg-catename">{{data.service_title}}</span>
        <span class="tg-catelinks">
			<a href="javascript:;" class="bk-edit-service"><i class="fa fa-edit"></i></a>
			<a href="javascript:;" data-type="db-delete" data-key="{{data.key}}" class="bk-delete-service"><i
                        class="fa fa-trash-o"></i></a>
		</span>
        <span class="tg-serviceprice">{{data.service_price}}</span>
    </div>
    <div class="tg-editcategory bk-current-service bk-elm-hide">
        <div class="form-group">
            <div class="tg-select">
                <select name="service_chamber" class="service_category">
                    <option value=""><?php esc_html_e('Select', 'docdirect'); ?></option>
                    <# _.each( data.cats , function( element, index, attr ) { #>
                    <# if( index == data.service_chamber ){ #>
                    <option selected value="{{index}}">{{element}}</option>
                    <# } else { #>
                    <option value="{{index}}">{{element}}</option>
                    <# } #>
                    <# } ); #>
                </select>
            </div>
        </div>
        <div class="form-group">
            <input type="text" value="{{data.service_title}}" class="form-control service-title" name="service_title"
                   placeholder="<?php esc_html_e('Service Title', 'docdirect'); ?>">
        </div>
        <div class="form-group">
            <input type="text" value="{{data.service_price}}" class="form-control service-price" name="service_price"
                   placeholder="<?php esc_html_e('Add Price', 'docdirect'); ?> <?php echo esc_attr($currency_symbol); ?>">
        </div>
        <div class="form-group tg-btnarea">
            <button class="tg-update  bk-service-add" data-key="{{data.key}}" data-type="update"
                    type="submit"><?php esc_html_e('Update Now', 'docdirect'); ?></button>
        </div>
    </div>
</script>


<script type="text/template" id="tmpl-append-options">
    <option value=""><?php esc_html_e('Select category', 'docdirect'); ?></option>
    <# _.each( data , function( element, index, attr ) { #>
    <option value="{{index}}">{{element}}</option>
    <# } ); #>
</script>

<!----------------------------------------------
 * Default Time Slots
 * return HTML
------------------------------------------------>
<script type="text/template" id="tmpl-default-slots">
    <div class="tg-timeslotswrapper">
        <div class="form-group">
            <input type="text" name="slot_title" class="form-control" name="title"
                   placeholder="<?php esc_attr_e('Chamber Name', 'docdirect'); ?>">
        </div>
        <div class="form-group">
            <input type="text" name="slot_title" class="form-control" name="hospital_title"
                   placeholder="<?php esc_attr_e('Hospital Name', 'docdirect'); ?>">
        </div>
        <div class="form-group">
            <div class="tg-select">
                <select name="start_time" class="start_time">
                    <option value=""><?php esc_attr_e('Start Time', 'docdirect'); ?></option>
                    <option value="0000">12:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="0100">1:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="0200">2:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="0300">3:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="0400">4:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="0500">5:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="0600">6:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="0700">7:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="0800">8:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="0900">9:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="1000">10:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="1100">11:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="1200">12:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="1300">1:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="1400">2:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="1500">3:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="1600">4:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="1700">5:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="1800">6:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="1900">7:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="2000">8:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="2100">9:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="2200">10:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="2300">11:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="2400">12:00 <?php esc_attr_e('am (night)', 'docdirect'); ?></option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="tg-select">
                <select name="end_time" class="end_time">
                    <option value=""><?php esc_attr_e('End Time', 'docdirect'); ?></option>
                    <option value="0000">12:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="0100">1:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="0200">2:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="0300">3:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="0400">4:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="0500">5:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="0600">6:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="0700">7:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="0800">8:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="0900">9:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="1000">10:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="1100">11:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                    <option value="1200">12:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="1300">1:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="1400">2:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="1500">3:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="1600">4:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="1700">5:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="1800">6:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="1900">7:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="2000">8:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="2100">9:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="2200">10:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="2300">11:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                    <option value="2400">12:00 <?php esc_attr_e('am (night)', 'docdirect'); ?></option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="tg-select">
                <select name="meeting_time" class="meeting_time">
                    <option value=""><?php esc_attr_e('Meeting Time', 'docdirect'); ?></option>
                    <option value="60">1 <?php esc_attr_e('hours', 'docdirect'); ?></option>
                    <option value="90">1 <?php esc_attr_e('hour', 'docdirect'); ?>,
                        30 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                    <option value="120">2 <?php esc_attr_e('hours', 'docdirect'); ?></option>
                    <option value="45">45 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                    <option value="30">30 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                    <option value="20">20 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                    <option value="15">15 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                    <option value="10">10 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                    <option value="5">5 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="tg-select">
                <select name="padding_time" class="padding_time">
                    <option value=""><?php esc_attr_e('Padding/Break Time', 'docdirect'); ?></option>
                    <option value="90">1 <?php esc_attr_e('hour', 'docdirect'); ?>,
                        30 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                    <option value="1">1 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                    <option value="2">2 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                    <option value="5">5 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                    <option value="10">10 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                    <option value="15">15 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                    <option value="20">20 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                    <option value="30">30 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                    <option value="45">45 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                    <option value="60">1 <?php esc_attr_e('hour', 'docdirect'); ?></option>
                </select>
            </div>
        </div>
        <div class="tg-btnbox">
            <button type="submit" class="tg-btn save-time-slots"><?php esc_html_e('save', 'docdirect'); ?></button>
            <button type="submit" class="tg-btn remove-slots-form"><?php esc_html_e('Cancel', 'docdirect'); ?></button>
        </div>
    </div>
    </div>
</script>

<script type="text/template" id="tmpl-no-slots">
    <span class="tg-notimeslotmessage">
		<p><?php esc_html_e('NO TIME SLOTS', 'docdirect'); ?></p>
	</span>
</script>

<!----------------------------------------------
 * Custom Time Slots
 * return HTML
------------------------------------------------>
<script type="text/template" id="tmpl-custom-timelines">
    <div class="tg-daytimeslot">
        <div class="custom-time-periods">
            <div class="tg-dayname">
                <a class="tg-deleteslot delete-slot-date" href="javascript:;"><i class="fa fa-close"></i></a>
                <strong><?php esc_html_e('custom slot', 'docdirect'); ?></strong>
                <ul class="tg-links">
                    <li><a href="javascript:;"
                           class="add-custom-timeslots"><?php esc_html_e('Add Slots', 'docdirect'); ?></a></li>
                </ul>
            </div>
            <div class="tg-timeslots tg-fieldgroup">
                <div class="tg-timeslotswrapper">
                    <div class="form-group tg-calender">
                        <input type="hidden" class="custom_time_slots" name="custom_time_slots" value=""/>
                        <input type="hidden" class="custom_time_slot_details" name="custom_time_slot_details" value=""/>
                        <input type="text" class="form-control slots-datepickr" name="cus_start_date"
                               placeholder="<?php esc_attr_e('Start Date', 'docdirect'); ?>"/>
                    </div>
                    <div class="form-group tg-calender">
                        <input type="text" class="form-control slots-datepickr" name="cus_end_date"
                               placeholder="<?php esc_attr_e('End Date', 'docdirect'); ?>"/>
                    </div>
                    <div class="form-group">
                        <div class="tg-select">
                            <select name="disable_appointment" class="disable_appointment">
                                <option value="enable"><?php esc_attr_e('Enable Appointment', 'docdirect'); ?></option>
                                <option value="disable"><?php esc_attr_e('Disbale Appointment', 'docdirect'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="custom-timeslots-data-area"></div>
                <div class="custom-timeslots-data"></div>
            </div>
        </div>
    </div>
</script>

<script type="text/template" id="tmpl-custom-slots">
    <div class="tg-timeslotswrapper">
        <form action="#" method="post" class="time-slots-form">
            <div class="form-group">
                <input type="text" name="slot_title" class="form-control" name="title"
                       placeholder="<?php esc_attr_e('Chamber Name', 'docdirect'); ?>">
            </div>
            <div class="form-group">
                <div class="tg-select">
                    <select name="start_time" class="start_time">
                        <option><?php esc_attr_e('Start Time', 'docdirect'); ?></option>
                        <option value="0000">12:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="0100">1:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="0200">2:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="0300">3:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="0400">4:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="0500">5:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="0600">6:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="0700">7:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="0800">8:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="0900">9:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="1000">10:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="1100">11:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="1200">12:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="1300">1:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="1400">2:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="1500">3:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="1600">4:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="1700">5:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="1800">6:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="1900">7:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="2000">8:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="2100">9:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="2200">10:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="2300">11:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="2400">12:00 <?php esc_attr_e('am (night)', 'docdirect'); ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="tg-select">
                    <select name="end_time" class="end_time">
                        <option><?php esc_attr_e('End Time', 'docdirect'); ?></option>
                        <option value="0000">12:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="0100">1:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="0200">2:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="0300">3:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="0400">4:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="0500">5:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="0600">6:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="0700">7:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="0800">8:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="0900">9:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="1000">10:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="1100">11:00 <?php esc_attr_e('am', 'docdirect'); ?></option>
                        <option value="1200">12:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="1300">1:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="1400">2:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="1500">3:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="1600">4:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="1700">5:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="1800">6:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="1900">7:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="2000">8:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="2100">9:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="2200">10:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="2300">11:00 <?php esc_attr_e('pm', 'docdirect'); ?></option>
                        <option value="2400">12:00 <?php esc_attr_e('am (night)', 'docdirect'); ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="tg-select">
                    <select name="meeting_time" class="meeting_time">
                        <option><?php esc_attr_e('Meeting Time', 'docdirect'); ?></option>
                        <option value="60">1 <?php esc_attr_e('hours', 'docdirect'); ?></option>
                        <option value="90">1 <?php esc_attr_e('hour', 'docdirect'); ?>,
                            30 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                        <option value="120">2 <?php esc_attr_e('hours', 'docdirect'); ?></option>
                        <option value="45">45 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                        <option value="30">30 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                        <option value="20">20 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                        <option value="15">15 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                        <option value="10">10 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                        <option value="5">5 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="tg-select">
                    <select name="padding_time" class="padding_time">
                        <option><?php esc_attr_e('Padding/Break Time', 'docdirect'); ?></option>
                        <option value="90">1 <?php esc_attr_e('hour', 'docdirect'); ?>,
                            30 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                        <option value="1">1 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                        <option value="2">2 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                        <option value="5">5 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                        <option value="10">10 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                        <option value="15">15 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                        <option value="20">20 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                        <option value="30">30 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                        <option value="45">45 <?php esc_attr_e('minutes', 'docdirect'); ?></option>
                        <option value="60">1 <?php esc_attr_e('hour', 'docdirect'); ?></option>
                    </select>
                </div>
            </div>
            <div class="tg-btnbox">
                <button type="submit"
                        class="tg-btn save-custom-time-slots"><?php esc_html_e('save', 'docdirect'); ?></button>
                <button type="submit"
                        class="tg-btn remove-slots-form"><?php esc_html_e('Cancel', 'docdirect'); ?></button>
            </div>
    </div>
    </div>
    </div>
</script>
