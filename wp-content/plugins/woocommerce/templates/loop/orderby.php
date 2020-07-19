<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.6.0
 */

if (!defined('ABSPATH')) {
    exit;
}

?>


<div class="container">
    <div class="row">


        <div class="col-md-7">
            <div class="form-group pull-left">
                <form class="" method="get">
                    <input class="form-control" name="search_key" placeholder="Enter search keyword here">
                    <input type="hidden" name="paged" value="1"/>
                    <?php wc_query_string_form_fields(null, array('orderby', 'submit', 'paged', 'product-page')); ?>
                    <input class="btn btn-sm btn-primary" id="search-text-input" value="search">
                    <div id='button-holder'>
                        <img src='magnifying_glass.png'/>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group pull-right">
                <a href="<?= site_url('prescription-upload') ?>" class="btn btn-primary pull-right"> Upload
                    Prescription </a>
            </div>

        </div>

    </div>
    <br>
</div>



