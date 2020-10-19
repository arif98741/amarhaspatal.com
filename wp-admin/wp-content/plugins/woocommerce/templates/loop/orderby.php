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
<style>


    @media only screen and (max-width: 768px) {
        .woocommerce ul.products[class*=columns-] li.product, .woocommerce-page ul.products[class*=columns-] li.product {
            padding: 4px 5px;

        }

    }

</style>

<div class="container" style="width: 100% !important;">


    <div class="row" >
        <div class="col-md-2 col-xs-5">

            <a href="<?= site_url('prescription-upload') ?>" class="btn btn-primary text-left upload-prescription-btn">Upload Prescription</a>

        </div>
        <div class="col-md-8 col-xs-7">

            <form action="<?= site_url('shop'); ?>" class="search-form" method="get">
                <input class="search-input" value="Search"
                       type="submit" />
                <div >
                    <input name="search_key" placeholder="Enter search keyword here" class="input-submit" type="text"/>
                </div>

                <input type="hidden" name="paged" value="1"/>

            </form>

        </div>


    </div>
    <br>
</div>





