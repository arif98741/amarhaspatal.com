<?php
/*
Template Name: Ambulence Booking
*/

global $current_user, $wp_roles, $userdata, $post, $paged;
$dir_obj = new DocDirect_Scripts();
$user_identity = $current_user->ID;
$url_identity = $user_identity;
get_header();
if (isset($_POST['ambulance_type'])) {

    $ambulance_type = esc_html($_POST['ambulance_type']);
    $booking_date = esc_html($_POST['booking_date']);
    $start_from = esc_html($_POST['start_from']);
    $destination = esc_html($_POST['destination']);
    $trip_type = esc_html($_POST['trip_type']);
    $full_name = esc_html($_POST['full_name']);
    $email = esc_html($_POST['email']);
    $reference_id = esc_html($_POST['reference_id']);
    $contact_no = esc_html($_POST['contact_no']);
    global $wpdb; //removed $name and $description there is no need to assign them to a global variable
    // $table_name = $wpdb->prefix . "liquor_type"; //try not using Uppercase letters or blank spaces when naming db tables
    $table_name = "ambulance_booking"; //try not using Uppercase letters or blank spaces when naming db tables
    $message = '';

    $status = $wpdb->insert($table_name, array(
        'ambulance_type' => $ambulance_type,
        'booking_date' => $booking_date,
        'start_from' => $start_from,
        'destination' => $destination,
        'trip_type' => $trip_type,
        'full_name' => $full_name,
        'email' => $email,
        'reference_id' => $reference_id,
        'contact_no' => $contact_no,

    ));
    if ($status) {
        $message = '<p style="font-size: 22px; color: green; text-align: center">Ambulance booking is successfully completed. We will contact
    with you soon.
</p>';
    }

}
?>
    <style>

        /* ==========================================================================
           #FONT
           ========================================================================== */
        .font-robo {
            font-family: "Roboto", "Arial", "Helvetica Neue", sans-serif;
        }

        .font-poppins {
            font-family: "Poppins", "Arial", "Helvetica Neue", sans-serif;
        }

        .font-opensans {
            font-family: "Open Sans", "Arial", "Helvetica Neue", sans-serif;
        }

        /* ==========================================================================
           #GRID
           ========================================================================== */
        .row {
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
        }

        .row .col-2:last-child .input-group-desc {
            margin-bottom: 0;
        }

        .row-space {
            -webkit-box-pack: justify;
            -webkit-justify-content: space-between;
            -moz-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
        }

        .row-refine {
            margin: 0 -15px;
        }

        .row-refine .col-3 .input-group-desc,
        .row-refine .col-9 .input-group-desc {
            margin-bottom: 0;
        }

        .col-2 {
            width: -webkit-calc((100% - 30px) / 2);
            width: -moz-calc((100% - 30px) / 2);
            width: calc((100% - 30px) / 2);
        }

        @media (max-width: 767px) {
            .col-2 {
                width: 100%;
            }
        }

        .form-row {
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -webkit-box-align: start;
            -webkit-align-items: flex-start;
            -moz-box-align: start;
            -ms-flex-align: start;
            align-items: flex-start;
            padding: 24px 55px;
            border-bottom: 1px solid #e5e5e5;
        }

        .form-row .name {
            width: 188px;
            color: #333;
            font-size: 15px;
            font-weight: 700;
            margin-top: 11px;
        }

        .form-row .value {
            width: -webkit-calc(100% - 188px);
            width: -moz-calc(100% - 188px);
            width: calc(100% - 188px);
        }

        @media (max-width: 767px) {
            .form-row {
                display: block;
                padding: 24px 30px;
            }

            .form-row .name,
            .form-row .value {
                display: block;
                width: 100%;
            }

            .form-row .name {
                margin-top: 0;
                margin-bottom: 12px;
            }
        }

        /* ==========================================================================
           #BOX-SIZING
           ========================================================================== */
        /**
         * More sensible default box-sizing:
         * css-tricks.com/inheriting-box-sizing-probably-slightly-better-best-practice
         */
        html {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        * {
            padding: 0;
            margin: 0;
        }

        *, *:before, *:after {
            -webkit-box-sizing: inherit;
            -moz-box-sizing: inherit;
            box-sizing: inherit;
        }

        /* ==========================================================================
           #RESET
           ========================================================================== */
        /**
         * A very simple reset that sits on top of Normalize.css.
         */
        body,
        h1, h2, h3, h4, h5, h6,
        blockquote, p, pre,
        dl, dd, ol, ul,
        figure,
        hr,
        fieldset, legend {
            margin: 0;
            padding: 0;
        }

        /**
         * Remove trailing margins from nested lists.
         */
        li > ol,
        li > ul {
            margin-bottom: 0;
        }

        /**
         * Remove default table spacing.
         */
        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        /**
         * 1. Reset Chrome and Firefox behaviour which sets a `min-width: min-content;`
         *    on fieldsets.
         */
        fieldset {
            min-width: 0;
            /* [1] */
            border: 0;
        }

        button {
            outline: none;
            background: none;
            border: none;
        }

        /* ==========================================================================
           #PAGE WRAPPER
           ========================================================================== */
        .page-wrapper {
            min-height: 100vh;
        }

        body {
            font-family: "Open Sans", "Arial", "Helvetica Neue", sans-serif;
            font-weight: 400;
            font-size: 14px;
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: 400;
        }

        h1 {
            font-size: 36px;
        }

        h2 {
            font-size: 30px;
        }

        h3 {
            font-size: 24px;
        }

        h4 {
            font-size: 18px;
        }

        h5 {
            font-size: 15px;
        }

        h6 {
            font-size: 13px;
        }

        /* ==========================================================================
           #BACKGROUND
           ========================================================================== */
        .bg-blue {
            background: #2c6ed5;
        }

        .bg-red {
            background: #fa4251;
        }

        .bg-dark {
            background: #1a1a1a;
        }

        .bg-gra-01 {
            background: -webkit-gradient(linear, left bottom, left top, from(#fbc2eb), to(#a18cd1));
            background: -webkit-linear-gradient(bottom, #fbc2eb 0%, #a18cd1 100%);
            background: -moz-linear-gradient(bottom, #fbc2eb 0%, #a18cd1 100%);
            background: -o-linear-gradient(bottom, #fbc2eb 0%, #a18cd1 100%);
            background: linear-gradient(to top, #fbc2eb 0%, #a18cd1 100%);
        }

        .bg-gra-02 {
            background: -webkit-gradient(linear, left bottom, right top, from(#fc2c77), to(#6c4079));
            background: -webkit-linear-gradient(bottom left, #fc2c77 0%, #6c4079 100%);
            background: -moz-linear-gradient(bottom left, #fc2c77 0%, #6c4079 100%);
            background: -o-linear-gradient(bottom left, #fc2c77 0%, #6c4079 100%);
            background: linear-gradient(to top right, #fc2c77 0%, #6c4079 100%);
        }

        .bg-gra-03 {
            background: -webkit-gradient(linear, left bottom, right top, from(#08aeea), to(#b721ff));
            background: -webkit-linear-gradient(bottom left, #08aeea 0%, #b721ff 100%);
            background: -moz-linear-gradient(bottom left, #08aeea 0%, #b721ff 100%);
            background: -o-linear-gradient(bottom left, #08aeea 0%, #b721ff 100%);
            background: linear-gradient(to top right, #08aeea 0%, #b721ff 100%);
        }

        /* ==========================================================================
           #SPACING
           ========================================================================== */
        .p-t-100 {
            padding-top: 100px;
        }

        .p-t-130 {
            padding-top: 130px;
        }

        .p-t-180 {
            padding-top: 180px;
        }

        .p-t-45 {
            padding-top: 45px;
        }

        .p-t-20 {
            padding-top: 20px;
        }

        .p-t-15 {
            padding-top: 15px;
        }

        .p-t-10 {
            padding-top: 10px;
        }

        .p-t-30 {
            padding-top: 30px;
        }

        .p-b-100 {
            padding-bottom: 100px;
        }

        .p-b-50 {
            padding-bottom: 50px;
        }

        .m-r-45 {
            margin-right: 45px;
        }

        .m-r-55 {
            margin-right: 55px;
        }

        .m-b-55 {
            margin-bottom: 55px;
        }

        .m-b-25 {
            margin-bottom: 25px;
        }

        /* ==========================================================================
           #WRAPPER
           ========================================================================== */
        .wrapper {
            margin: 0 auto;
        }

        .wrapper--w960 {
            max-width: 960px;
        }

        .wrapper--w900 {
            max-width: 900px;
        }

        .wrapper--w790 {
            max-width: 790px;
        }

        .wrapper--w780 {
            max-width: 780px;
        }

        .wrapper--w680 {
            max-width: 680px;
        }

        /* ==========================================================================
           #BUTTON
           ========================================================================== */
        .btn {
            display: inline-block;
            line-height: 50px;
            padding: 0 30px;
            -webkit-transition: all 0.4s ease;
            -o-transition: all 0.4s ease;
            -moz-transition: all 0.4s ease;
            transition: all 0.4s ease;
            cursor: pointer;
            font-size: 15px;
            text-transform: capitalize;
            font-weight: 700;
            color: #fff;
            font-family: inherit;
        }

        .btn--radius {
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }

        .btn--radius-2 {
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }

        .btn--pill {
            -webkit-border-radius: 20px;
            -moz-border-radius: 20px;
            border-radius: 20px;
        }

        .btn--green {
            background: #57b846;
        }

        .btn--green:hover {
            background: #4dae3c;
        }

        .btn--blue {
            background: #4272d7;
        }

        .btn--blue:hover {
            background: #3868cd;
        }

        .btn--blue-2 {
            background: #2c6ed5;
        }

        .btn--blue-2:hover {
            background: #185ac1;
        }

        .btn--red {
            background: #ff4b5a;
        }

        .btn--red:hover {
            background: #eb3746;
        }

        /* ==========================================================================
           #DATE PICKER
           ========================================================================== */
        td.active {
            background-color: #2c6ed5;
        }

        input[type="date" i] {
            padding: 14px;
        }

        .table-condensed td, .table-condensed th {
            font-size: 14px;
            font-family: "Roboto", "Arial", "Helvetica Neue", sans-serif;
            font-weight: 400;
        }

        .daterangepicker td {
            width: 40px;
            height: 30px;
        }

        .daterangepicker {
            border: none;
            -webkit-box-shadow: 0px 8px 20px 0px rgba(0, 0, 0, 0.15);
            -moz-box-shadow: 0px 8px 20px 0px rgba(0, 0, 0, 0.15);
            box-shadow: 0px 8px 20px 0px rgba(0, 0, 0, 0.15);
            display: none;
            border: 1px solid #e0e0e0;
            margin-top: 5px;
        }

        .daterangepicker::after, .daterangepicker::before {
            display: none;
        }

        .daterangepicker thead tr th {
            padding: 10px 0;
        }

        .daterangepicker .table-condensed th select {
            border: 1px solid #ccc;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            font-size: 14px;
            padding: 5px;
            outline: none;
        }

        /* ==========================================================================
           #FORM
           ========================================================================== */
        input,
        textarea {
            outline: none;
            margin: 0;
            border: none;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
            width: 100%;
            font-size: 14px;
            font-family: inherit;
        }

        textarea {
            resize: none;
        }

        .input-group {
            position: relative;
            margin: 0;
        }

        .input--style-6,
        .textarea--style-6 {
            background: transparent;
            line-height: 38px;
            border: 1px solid #cccccc;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            color: #666;
            font-size: 15px;
            -webkit-transition: all 0.4s ease;
            -o-transition: all 0.4s ease;
            -moz-transition: all 0.4s ease;
            transition: all 0.4s ease;
            padding: 0 20px;
        }

        .input--style-6::-webkit-input-placeholder,
        .textarea--style-6::-webkit-input-placeholder {
            /* WebKit, Blink, Edge */
            color: #999;
        }

        .input--style-6:-moz-placeholder,
        .textarea--style-6:-moz-placeholder {
            /* Mozilla Firefox 4 to 18 */
            color: #999;
            opacity: 1;
        }

        .input--style-6::-moz-placeholder,
        .textarea--style-6::-moz-placeholder {
            /* Mozilla Firefox 19+ */
            color: #999;
            opacity: 1;
        }

        .input--style-6:-ms-input-placeholder,
        .textarea--style-6:-ms-input-placeholder {
            /* Internet Explorer 10-11 */
            color: #999;
        }

        .input--style-6:-ms-input-placeholder,
        .textarea--style-6:-ms-input-placeholder {
            /* Microsoft Edge */
            color: #999;
        }

        .input--style-6:focus,
        .textarea--style-6:focus {
            -webkit-box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.15);
            -moz-box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.15);
            box-shadow: 0px 1px 5px 0px rgba(0, 0, 0, 0.15);
            -webkit-transform: translateY(-3px);
            -moz-transform: translateY(-3px);
            -ms-transform: translateY(-3px);
            -o-transform: translateY(-3px);
            transform: translateY(-3px);
        }

        .textarea--style-6 {
            line-height: 1.2;
            min-height: 120px;
            padding: 10px 20px;
        }

        .label--desc {
            font-size: 13px;
            color: #999;
            margin-top: 10px;
        }

        @media (max-width: 767px) {
            .label--desc {
                margin-top: 14px;
            }
        }

        .input-file {
            display: none;
        }

        .input-file + label {
            font-size: 15px;
            color: #fff;
            color: white;
            line-height: 40px;
            background-color: #666666;
            padding: 0 20px;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            display: inline-block;
            margin-right: 15px;
            -webkit-transition: all 0.4s ease;
            -o-transition: all 0.4s ease;
            -moz-transition: all 0.4s ease;
            transition: all 0.4s ease;
            cursor: pointer;
        }

        .input-file:focus + label,
        .input-file + label:hover {
            background: #1b1b1b;
        }

        .input-file__info {
            font-size: 15px;
            color: #666;
        }

        @media (max-width: 767px) {
            .input-file__info {
                display: block;
                margin-top: 6px;
            }
        }


        /* ==========================================================================
           #TITLE
           ========================================================================== */
        .title {
            font-size: 36px;
            font-weight: 700;
            text-align: left;
            color: #fff;
            margin-bottom: 24px;
        }

        @media (max-width: 767px) {
            .title {
                padding: 0 15px;
            }
        }

        /* ==========================================================================
           #CARD
           ========================================================================== */
        .card {
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            background: #fff;
        }

        .card-6 {
            background: transparent;
        }

        .card-6 .card-heading {
            background: transparent;
        }

        .card-6 .card-body {
            background: #fff;
            position: relative;
            border: 1px solid #e5e5e5;
            border-bottom: none;
            padding: 30px 0;
            padding-bottom: 0;
            -webkit-border-top-left-radius: 3px;
            -moz-border-radius-topleft: 3px;
            border-top-left-radius: 3px;
            -webkit-border-top-right-radius: 3px;
            -moz-border-radius-topright: 3px;
            border-top-right-radius: 3px;
        }

        .card-6 .card-body:before {
            bottom: 100%;
            left: 75px;
            border: solid transparent;
            content: "";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-color: rgba(255, 255, 255, 0);
            border-bottom-color: #fff;
            border-width: 10px;
        }

        .card-6 .card-footer {
            background: #fff;
            border: 1px solid #e5e5e5;
            border-top: none;
            -webkit-border-bottom-left-radius: 3px;
            -moz-border-radius-bottomleft: 3px;
            border-bottom-left-radius: 3px;
            -webkit-border-bottom-right-radius: 3px;
            -moz-border-radius-bottomright: 3px;
            border-bottom-right-radius: 3px;
            padding: 50px 55px;
        }

        @media (max-width: 767px) {
            .card-6 .card-footer {
                padding: 50px 30px;
            }
        }
    </style>
    <div class="container">
        <h1>Hello Ambulance Man</h1>
        <div class="page-wrapper bg-blue p-t-100 p-b-50">
            <div class="wrapper wrapper--w900">
                <div class="card card-6">
                    <div class="card-heading">
                        <h2 class="title">Book Ambulance</h2>
                    </div>
                    <div class="card-body">
                        <?php if ($message != ''): ?>
                            <?php
                            echo $message;
                            ?>
                        <?php
                        endif;
                        ?>
                        <form method="POST" action="<?= site_url('ambulance-booking') ?>">

                            <div class="form-row">
                                <div class="name">Ambulance Type</div>
                                <div class="value m-b-25">

                                    <select name="ambulance_type" class="input--style-6" required>
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
                                    <input class="input--style-6" type="text" placeholder="Enter starting location"
                                           name="start_from" required>
                                </div>


                                <div class="name">Destination</div>
                                <div class="value m-b-25">
                                    <input class="input--style-6" type="text" placeholder="Enter destination location"
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
                                    <input class="input--style-6" type="text" placeholder="Enter your full name"
                                           name="full_name" required>
                                </div>

                                <div class="name">Email</div>
                                <div class="value m-b-25">
                                    <input class="input--style-6" type="text" placeholder="Enter your email here"
                                           name="email" required>
                                </div>

                                <div class="name">Contact No</div>
                                <div class="value m-b-25">
                                    <input class="input--style-6 m-b-25" type="text" placeholder="Contact No"
                                           name="contact_no" required>
                                </div>

                                <div class="name">Reference ID</div>
                                <div class="value m-b-25">
                                    <input class="input--style-6" type="text"
                                           placeholder="Enter reference id if available"
                                           name="reference_id" required>
                                </div>
                                <div class="value m-b-25">
                                    <button class="btn btn--radius-2 btn--blue-2" id="ambulanceBookingbtn"
                                            type="submit">Submit
                                    </button>
                                </div>



                            </div>


                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Jquery JS-->
        <script src="<?= site_url('docdirect/js/vendor/docdirect_functions.js') ?>"></script>

        </body>

    </div>

<?php
get_footer();
?>