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
        .woocommerce ul.products[class*=columns-] li.product,
        .woocommerce-page ul.products[class*=columns-] li.product {
            padding: 4px 5px;

        }

    }

</style>

<div class="container">


    <div class="row">
        <div class="col-md-2 col-xs-5 pull-left prescription-block">

            <a href="<?= site_url('prescription-upload') ?>" class="btn btn-primary upload-prescription-btn">Upload Prescription</a>
            <br>


        </div>
        <div class="col-md-offset-3">

        </div>
        <div class="col-md-7 col-xs-7 col-xs-push-2 pull-right">

            <form class="example" action="/action_page.php" style="margin:auto;max-width:300px; margin-top: 18px">
                <input type="text" placeholder="Search.." name="search2" style="border-radius: 5px 0px 0px 5px;">
                <button type="submit" style="height: 40px; border-radius: 0 4px 4px 0px;"><i class="fa fa-search"></i></button>
            </form>

            <style>
                * {
                    box-sizing: border-box;
                }

                form.example input[type=text] {
                    padding: 10px;
                    font-size: 17px;
                    border: 1px solid grey;
                    float: left;
                    width: 80%;
                    background: #f1f1f1;
                }

                form.example button {
                    float: left;
                    width: 20%;
                    padding: 10px;
                    background: #2196F3;
                    color: white;
                    font-size: 17px;
                    border: 1px solid grey;
                    border-left: none;
                    cursor: pointer;
                }

                form.example button:hover {
                    background: #0b7dda;
                }

                form.example::after {
                    content: "";
                    clear: both;
                    display: table;
                }
            </style>
        </div>
    </div>
    <div class="row" style="margin: 0; padding: 0">
        <div class="col-md-4">
            <?php
    
            ?>
            <form action="<?php echo site_url(); ?>/shop" method="post">
                <?php
                $districts = getPostTermChildCategory('product_cat', 184);
                ?>
                <select name="location" required>
                    <option value="">Select District</option>
                    <?php foreach ($districts as $district) { ?>
                        <option value="<?= $district->slug; ?>" <?php if (isset($_SESSION['location']) && $district->slug == $_SESSION['location']): ?> selected <?php endif; ?>><?= $district->name ?></option>
                    <?php } ?>
                </select>
                <button class="btn btn-sm btn-primary" style="margin-top: 3px" type="submit">Select</button>
            </form>
        </div>
    </div>
    <br>
</div>
</div>

<!--popup modal for showing location selection-->

<!--popup modal for showing location selection-->

<!--owl carousel-->
<link href="<?php echo get_template_directory_uri() ?>/css/owl.carousel.min.css" rel="stylesheet">
<script src="<?php echo get_template_directory_uri() ?>/js/owl.carousel.min.js"></script>
<script>
    jQuery(document).ready(function () {

    });
</script>
<!--owl carousel-->






