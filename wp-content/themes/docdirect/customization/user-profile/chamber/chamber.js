jQuery(document).ready(function () {
    //Constants
    var empty_chamber = scripts_vars.empty_chamber;
    var complete_fields = scripts_vars.complete_fields;
    var system_error = scripts_vars.system_error;
    var custom_slots_dates = scripts_vars.custom_slots_dates;
    var calendar_locale = scripts_vars.calendar_locale;
    var loder_html = '<div class="docdirect-loader-wrap"><div class="docdirect-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';

    var loader_fullwidth_html = '<div class="docdirect-site-wrap"><div class="docdirect-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';

    /*-------------------------------------------------
     * Chamber Action
     *
     *-------------------------------------------------*/


    ///end of getting diagnostics and hospitals

    //Add chamber
    jQuery(document).on('click', '.bk-add-chamber-item', function () {
        $.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            dataType: 'JSON',
            data: {
                'action': 'get_hospital_and_chambers'
            },
            success: function (response) {
                let str = response.data.replace(/\\/g, '');
                var chamberDropdown = '<label style="color: #fff;">Chamber Name</label>' +
                    '<select class="form-control service-chamber-title chamber-listing-dropdown" name="title">' +
                    '<option value="">Select Chamber</option>';
                $.each(JSON.parse(str), function (index, element) {
                    let option = '<option value="' + element + '">' + element + '</option>';
                    chamberDropdown += option;
                });
                chamberDropdown += '</select>';
                $('.chamber-dropdown').html(chamberDropdown);
            }
        });


        var load_catgories = wp.template('append-service-chamber');
        jQuery('.bk-chamber-wrapper').append(load_catgories);
    });


    $(document).ready(function () {
        $('.chamber-listing-dropdown').change(function () {
            alert('hello');
            
        });
    });

    //Edit chamber
    jQuery(document).on('click', '.bk-edit-chamber', function () {

        jQuery(this).parents('.bk-chamber-item').find('.bk-current-chamber').slideToggle(200);
    });


    $("#chamberForm").on('submit', function (event) {
        //submitbtn

        event.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'docdirect_update_service_chamber',
                form: JSON.stringify($(this).serializeArray())
            },
            success: function (response) {
                if (response.message_type == 'success') {
                    $.notify(response.message, "success");
                    location.reload(true);
                } else {
                    $.notify(response.message, "warn");
                    location.reload(true);

                }
            }
        });

    });


    //Add,Edit categories
    jQuery(document).on('click', '.bk-mainchamber-add', function (e) {

        e.preventDefault();

        var _this = jQuery(this);
        var key = _this.data('key');
        var type = _this.data('type');

        var title = _this.parents('.bk-current-chamber').find('.service-chamber-title').val();
        var new_patient_fee = parseInt(_this.parents('.bk-current-chamber').find('.service-chamber-new-patient-fee').val());
        var old_patient_fee = parseInt(_this.parents('.bk-current-chamber').find('.service-chamber-old-patient-fee').val());


        jQuery('body').append(loader_fullwidth_html);

        if (title == '') {
            jQuery('body').find('.docdirect-site-wrap').remove();
            jQuery.sticky(empty_chamber, {classList: 'important', speed: 200, autoclose: 5000});
            return false;
        }

        var dataString = 'key=' + key + '&type=' + type + '&title=' + title
            + '&new_patient_fee=' + new_patient_fee
            + '&old_patient_fee=' + old_patient_fee
            + '&action=docdirect_update_service_chamber';


        //form submit for chambers
        // this is the id of the form


        //form submit for chambers
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.docdirect-site-wrap').remove();
                if (response.message_type == 'error') {
                    jQuery.sticky(response.message, {classList: 'important', speed: 200, autoclose: 5000});
                } else {
                    var update_chamber = wp.template('update-service-chamber');
                    var chamber_item = update_chamber(response);
                    _this.parents('.bk-chamber-item').html(chamber_item);
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});

                    //each categories
                    var categories = {};
                    jQuery(".bk-chamber-wrapper input[type=text]").each(function () {
                        var _key = jQuery(this).data('key');
                        var _val = jQuery(this).val();
                        if (_key && _val) {
                            categories[_key] = _val;
                        }
                    });

                    //refresh services categories
                    jQuery(".bk-services-wrapper select[name=service_chamber]").each(function () {
                        var _template = wp.template('append-options');
                        var _options = _template(categories);
                        jQuery(this).html(_options);
                    });

                }
            }
        });
        return false;
    });

    //Delete categories
    jQuery(document).on('click', '.bk-delete-chamber', function (e) {


        e.preventDefault();
        var _this = jQuery(this);
        var key = _this.data('key');
        var type = _this.data('type');

        //Process newly embed item
        if (type == 'new-delete') {
            jQuery(this).parents('.bk-chamber-item').remove();
            return false;
        }

        if (key == '') {
            jQuery.sticky(system_error, {classList: 'important', speed: 200, autoclose: 5000});
            return false;
        }

        var dataString = 'key=' + key + '&action=docdirect_delete_service_chamber';

        jQuery.confirm({
            'title': scripts_vars.delete_chamber,
            'message': scripts_vars.delete_chamber_message,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        //Process dadtabase item
                        jQuery('body').append(loader_fullwidth_html);
                        jQuery.ajax({
                            type: "POST",
                            url: scripts_vars.ajaxurl,
                            data: dataString,
                            dataType: "json",
                            success: function (response) {
                                jQuery('body').find('.docdirect-site-wrap').remove();
                                if (response.message_type == 'error') {
                                    jQuery.sticky(response.message, {
                                        classList: 'important',
                                        speed: 200,
                                        autoclose: 5000
                                    });
                                } else {
                                    jQuery.sticky(response.message, {
                                        classList: 'success',
                                        speed: 200,
                                        autoclose: 5000
                                    });
                                    _this.parents('.bk-chamber-item').remove();

                                    //each categories
                                    var categories = {};
                                    jQuery(".bk-chamber-wrapper input[type=text]").each(function () {
                                        var _key = jQuery(this).data('key');
                                        var _val = jQuery(this).val();
                                        if (_key && _val) {
                                            categories[_key] = _val;
                                        }
                                    });

                                    //refresh services categories
                                    jQuery(".bk-services-wrapper select[name=service_chamber]").each(function () {
                                        var _template = wp.template('append-options');
                                        var _options = _template(categories);
                                        jQuery(this).html(_options);
                                    });
                                }
                            }
                        });
                    }
                },
                'No': {
                    'class': 'gray',
                    'action': function () {
                        return false;
                    }	// Nothing to do in this case. You can as well omit the action property.
                }
            }
        });


        return false;
    });


});