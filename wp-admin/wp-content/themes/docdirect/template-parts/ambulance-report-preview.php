<?php
/*
Template Name: Ambulance Report Preview
*/
global $current_user, $wp_roles, $userdata, $post, $paged;
date_default_timezone_set('Asia/Dhaka');
$dir_obj = new DocDirect_Scripts();
$user_identity = $current_user->ID;
$url_identity = $user_identity;
$start = esc_html($_GET['start_date']);
$end = esc_html($_GET['end_date']);
$user_id = '';
$sql = "SELECT * FROM ambulance_booking where created_at >= '$start' and created_at <='$end'";
if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $user_id = esc_html($_GET['user_id']);
    $sql = "SELECT * FROM ambulance_booking where user_id='$user_id'";
}

$start = $start . ' 00:00:00';
$end = $end . ' 23:59:59';

global $wpdb;

$bookings = $wpdb->get_results($sql);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>::: Ambulance Report :::</title>
    <link rel="stylesheet " href="<?= site_url('wp-admin') ?>">
    <style>

        @font-face {
            font-family: 'SolaimanLipiNormal';
            src: url('fonts/solaiman-lipi.eot');
            src: url('fonts/solaiman-lipi.eot') format('embedded-opentype'), url('fonts/solaiman-lipi.woff') format('woff'), url('fonts/solaiman-lipi.ttf') format('truetype'), url('fonts/solaiman-lipi.svg#SolaimanLipiNormal') format('svg');
            font-weight: normal;
            font-style: normal;
        }

        body {
            color: #333;
            font-size: 14px;
            font-family: SolaimanLipiNormal !important;
            background: #f5f5f5;
        }

        a:link {
            text-decoration: none;
        }

        a:visited {
            text-decoration: none;
        }

        a:hover {
            text-decoration: none;
        }

        a:active {
            text-decoration: none;
        }

        .container {
            margin: 0 auto;
            width: 70%;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 2px 2px 0px #E0E0E0;
        }

        .header {
            color: #683091;
            text-align: center;
            background: #fff;
            line-height: 25px !important;
            padding: 10px;
        }

        .wraper {
            margin: 0 auto;
            width: 75%;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 2px 0px #E0E0E0;
        }

        .wraper-2 {
            margin: 0 auto;
            background-color: #ffffff;
            padding: 15px;
            border: 3px solid #673AB7;
        }

        h1 {
            margin: 0;
            font-size: 28px;
            color: #3F51B5;
        }

        h2 {
            margin: 0;
            font-size: 20px;
            color: #263238
        }

        h3 {
            margin: 0;
            font-size: 18px;
            color: #263238
        }

        h4 {
            margin: 0;
            font-size: 16px;
            color: #F44336
        }

        .logo {
            padding: 10px;
        }

        .text-vertical {
            transform: rotate(90deg);
        }

        .links {
            border: 1px dotted #eee;
            line-height: 25px;
            column-count: 4;
            column-gap: 10px;
            column-rule: 1px dotted #eee;
            padding: 0px;
            text-align: center;
            margin-right: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table td {
            padding: 4px;
            border: #EEEEEE 1px solid;
        }

        .table tr {
            background: #000;
        }

        .table th {
            background: #E8EAF6;
            border: #C5CAE9 1px solid;
            padding: 5px;
        }

        .table tr:nth-child(odd) {
            background: #ffffff;
        }

        .table tr:nth-child(even) {
            background: #ffffff;
        }

        .bt-div {
            text-align: center;
            background: #2196F3;
            padding: 8px;
            top: 20px;
            position: fixed;
            left: 0;
            margin-bottom: 10px;
            box-shadow: 0 0 1px #9E9E9E;
            border-bottom-right-radius: 5px;
            border-top-right-radius: 5px;
            color: #fff;
        }

        .box {
            clear: both;
            overflow: hidden;
            line-height: 25px;
            font-size: 16px;
            font-weight: 500;
        }

        .box-div-inside {
            width: 325px;
            height: 270px;
            float: left;
            margin: 20px 20px;
            overflow: hidden;
            padding: 8px;
            border: 3px double #333;
            background: #fff;
        }

        .button {
            display: inline-block;
            background-color: #f5f5f5;
            background-image: -webkit-linear-gradient(top, #f5f5f5, #f1f1f1);
            background-image: -moz-linear-gradient(top, #f5f5f5, #f1f1f1);
            background-image: -ms-linear-gradient(top, #f5f5f5, #f1f1f1);
            background-image: -o-linear-gradient(top, #f5f5f5, #f1f1f1);
            background-image: linear-gradient(top, #f5f5f5, #f1f1f1);
            color: #fff !important;
            border: 1px solid #dcdcdc;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            cursor: default;
            font-size: 16px;
            text-align: center;
            font-family: SolaimanLipiNormal;
            line-height: 27px;
            min-width: 54px;
            padding: 0 8px;
            text-decoration: none;
        }

        .button:hover {
            background-color: #F8F8F8;
            background-image: -webkit-linear-gradient(top, #f8f8f8, #f1f1f1);
            background-image: -moz-linear-gradient(top, #f8f8f8, #f1f1f1);
            background-image: -ms-linear-gradient(top, #f8f8f8, #f1f1f1);
            background-image: -o-linear-gradient(top, #f8f8f8, #f1f1f1);
            background-image: linear-gradient(top, #f8f8f8, #f1f1f1);
            border: 1px solid #C6C6C6;
            color: #333;
            -webkit-box-shadow: 0px 1px 1px rgba(0, 0, 0, .1);
            -moz-box-shadow: 0px 1px 1px rgba(0, 0, 0, .1);
            box-shadow: 0px 1px 1px rgba(0, 0, 0, .1);
            cursor: pointer;
        }

        /* blue */
        .button.blue {
            background-color: #4D90FE;
            background-image: -webkit-linear-gradient(top, #4d90fe, #4787ed);
            background-image: -moz-linear-gradient(top, #4d90fe, #4787ed);
            background-image: -ms-linear-gradient(top, #4d90fe, #4787ed);
            background-image: -o-linear-gradient(top, #4d90fe, #4787ed);
            background-image: linear-gradient(top, #4d90fe, #4787ed);
            border: 1px solid #3079ED;
            color: white;
        }

        .button.blue:hover {
            border: 1px solid #2F5BB7;
            background-color: #357AE8;
            background-image: -webkit-linear-gradient(top, #4d90fe, #357ae8);
            background-image: -moz-linear-gradient(top, #4d90fe, #357ae8);
            background-image: -ms-linear-gradient(top, #4d90fe, #357ae8);
            background-image: -o-linear-gradient(top, #4d90fe, #357ae8);
            background-image: linear-gradient(top, #4d90fe, #357ae8);
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .1);
            -moz-box-shadow: 0 1px 1px rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px rgba(0, 0, 0, .1);
        }

        /*
        /* defaults */
        .button.default:active {
            -webkit-box-shadow: inset 0px 1px 2px rgba(0, 0, 0, .1);
            -moz-box-shadow: inset 0px 1px 2px rgba(0, 0, 0, .1);
            box-shadow: inset 0px 1px 2px rgba(0, 0, 0, .1);
            color: black;
        }

        .button.blue:active, .button.red:active, .button.green:active, .button.pinkish:active, .button.maroonish:active, .button.golden:active, .button.brownish:active, .button.grayish:active, .button.skinish:active, .button.yellowish:active, .button.goldenish:active, .button.pink:active, .button.violet:active, .button.orange:active, .button.seagreen:active {
            -webkit-box-shadow: inset 0px 1px 2px rgba(0, 0, 0, .3);
            -moz-box-shadow: inset 0px 1px 2px rgba(0, 0, 0, .3);
            box-shadow: inset 0px 1px 2px rgba(0, 0, 0, .3);
        }

        .footer-text {
            font-size: 12px;
        }

        @media print {
            body {
                background: #fff;
                font-size: 14px;
                color: #000;
            }

            h4 {
                margin: 0;
                font-size: 16px;
                color: #000;
            }

            .container {
                width: 100%;
                padding: 0px;
                background-color: #ffffff;
                box-shadow: none;
            }

            .header {
                padding: 5px;
                color: #683091;
                margin-bottom: 20px;
                border: 1px solid #fff;
            }

            .wraper {
                margin: 0 auto;
                width: 100%;
                padding: 0px;
                background-color: #ffffff;
                box-shadow: none;
            }

            .table {
                width: 100%;
                border-collapse: collapse;
                font-size: 14px;
            }

            .table td {
                padding: 2px;
                border: #333 1px solid;
            }

            .table tr {
                background: #000;
            }

            .table th {
                background: #E8EAF6;
                color: #3F51B5;
                border: #333 1px solid;
                padding: 2px;
            }

            .table tr:nth-child(odd) {
                background: #ffffff;
            }

            .table tr:nth-child(even) {
                background: #ffffff;
            }

            .bt-div {
                display: none;
            }

            .bt-footer {
                display: none;
            }

    </style>
    <style type="text/css" media="print">
        @page {
            size: landscape;
        }
    </style>
</head>
<body>
<div class="bt-div">
    <INPUT TYPE="button" class="button blue" title="Print" onClick="window.print()" value="Print">
    <button class="button blue" onclick="window.location='<?= site_url("ambulance-report") ?>'">Back</button>
    <hr>
    Page size: A4
</div>
<div class="wraper">
    <table width="100%">
        <tr>
            <td width="10%" height="82" align="left" valign="top"><a href="#"></td>
            <td width="81%" align="left" valign="top">
                <h1>Ambulance Report</h1>
                <h3>
                    <?php
                    if (isset($_GET['user_id']) && !empty($_GET['user_id'])): ?>
                        <?php
                        echo get_user_meta($user_id)['first_name'][0];
                        ?>
                    <?php endif; ?>

                </h3>

                <h3>From
                    date: <?= date('d-m-Y', strtotime($start)) ?>
                    <br>To Date: <?= date('d-m-Y', strtotime($end)) ?></h3>


            </td>
            <td width="9%" align="right" valign="top" nowrap="nowrap">
            </td>
        </tr>
    </table>
    <br>
    <table width="100%" class="table">
        <thead class="thead-inverse">
        <tr>
            <th><?php esc_html_e('SL'); ?></th>
            <th><?php esc_html_e('Ambulance Type'); ?></th>
            <th><?php esc_html_e('Booking Date'); ?></th>
            <?php if (isset($_GET['user_id']) && empty($_GET['user_id'])): ?>
                <th>Ambulance</th>
            <?php endif; ?>
            <th><?php esc_html_e('Start From'); ?></th>
            <th><?php esc_html_e('Destination'); ?></th>
            <th><?php esc_html_e('Trip Type'); ?></th>
            <th><?php esc_html_e('Full Name'); ?></th>
            <th><?php esc_html_e('Email'); ?></th>
            <th><?php esc_html_e('Contact'); ?></th>
            <th><?php esc_html_e('Created'); ?></th>
        </tr>
        </thead>


        <tbody>
        <?php

        $date_format = get_option('date_format');
        $time_format = get_option('time_format');

        $counter = 0;
        if (count($bookings) > 0) {
            foreach ($bookings as $book) {
                $counter++;
                ?>
                <tr class="">
                    <td data-name="id"><?= $counter ?></td>
                    <td><?php echo esc_attr($book->ambulance_type); ?></td>
                    <td><?php echo esc_attr(date('d-m-Y', strtotime($book->booking_date))); ?></td>
                    <?php if (isset($_GET['user_id']) && empty($_GET['user_id'])): ?>
                        <td><?php echo get_user_meta($book->user_id)['first_name'][0]; ?></td>
                    <?php endif; ?>
                    <td><?php echo esc_attr($book->start_from); ?></td>
                    <td><?php echo esc_attr($book->destination); ?></td>
                    <td><?php echo esc_attr($book->trip_type); ?></td>
                    <td><?php echo esc_attr($book->full_name); ?></td>
                    <td><?php echo esc_attr($book->email); ?></td>
                    <td><?php echo esc_attr($book->contact_no); ?></td>
                    <td><?php echo esc_attr(date('d-m-Y', strtotime($book->created_at))); ?></td>

                </tr>

                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="10">
                    <?php DoctorDirectory_NotificationsHelper::informations(esc_html__('No data found.', 'docdirect')); ?>
                </td>
            </tr>
        <?php }; ?>
        </tbody>


    </table>
    <br>

</div>

<div class="footer-text">
    <center>Technical Assistance: SoftBD Ltd | Generated on <?= date('d-m-Y h:i:sA') ?>
        <center>
</div>
<script>
    function goBack() {
        window.history.back();
    }
</script>
