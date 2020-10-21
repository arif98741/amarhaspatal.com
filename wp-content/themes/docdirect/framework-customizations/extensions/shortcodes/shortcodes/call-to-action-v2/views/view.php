<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
$color = isset($atts['color']) && $atts['color'] != '' ? $atts['color'] : '#5d5955';
//echo '<pre>';
//print_r( $atts); exit;
?>

<div class="doc-registercontent">
    <div class="doc-leftarea">
        <?php if (!empty($atts['cta_title'])) { ?><h3><?php echo do_shortcode($atts['cta_title']); ?></h3><?php } ?>
        <span>For getting service of <?= site_url(); ?> please be a part of it</span>
    </div>
    <?php if (!empty($atts['cta_button_text'])) { ?>
        <div class="doc-rightarea">
            <a class="doc-btn" href="#" data-toggle="modal" data-target="#registration-modal-front">Sign up now</a>
        </div>
    <?php } ?>
</div>