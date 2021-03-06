<?php
if (!defined('FW')) {
    die('Forbidden');
}
/**
 * @var $atts
 */
global $wpdb;
$uni_flag = fw_unique_increment();
$dir_search_page = fw_get_db_settings_option('dir_search_page');
if (isset($dir_search_page[0]) && !empty($dir_search_page[0])) {
    $search_page = get_permalink((int)$dir_search_page[0]);
} else {
    $search_page = '';
}

$args = array('posts_per_page' => '-1',
    'post_type' => 'directory_type',
    'post_status' => 'publish',
    'suppress_filters' => false
);

if (!empty($atts['categories'])) {
    $args['post__in'] = $atts['categories'];
}
$cust_query = get_posts($args);
?>

<div class="col-lg-offset-2 col-lg-8 col-md-offset-1 col-md-10 col-sm-offset-0 col-sm-12 col-xs-12">
    <div class="doc-section-head">
        <?php if (!empty($atts['heading']) && !empty($atts['sub_heading'])) { ?>
            <div class="doc-section-heading">
                <?php if (!empty($atts['heading'])) { ?>
                    <h2>Our Services</h2>
                <?php } ?>

            </div>
        <?php } ?>
        <?php if (!empty($atts['description'])) { ?>
            <div class="doc-description">
                <?php //echo do_shortcode($atts['description']); ?>
            </div>
        <?php } ?>
    </div>
</div>
<div class="doc-topcategories">
    <?php
    if (isset($cust_query) && !empty($cust_query)) {
        $counter = 0;

        foreach ($cust_query as $key => $dir) {
            $counter++;
            $title = get_the_title($dir->ID);
            $category_image = fw_get_db_post_option($dir->ID, 'category_image', true);

            if (!empty($category_image['attachment_id'])) {
                $banner = docdirect_get_image_source($category_image['attachment_id'], 470, 305);
            } else {
                $banner = get_template_directory_uri() . '/images/user470x305.jpg';;
            }

            ?>
            <div class="col-md-4 col-sm-4 col-xs-6">
                <div class="doc-category">
                    <figure class="doc-categoryimg">
                        <div class="doc-hoverbg">
                            <h3><?php echo esc_attr($title); ?></h3>
                        </div>
                        <a href="<?php echo site_url('dir-search'); ?>?directory_type=<?php echo esc_attr($dir->ID); ?>">
                            <img src="<?php echo esc_url($banner); ?>" alt="<?php echo esc_attr($title); ?>">
                        </a>
                        <figcaption class="doc-imghover">
                            <div class="doc-categoryname"><h4><a
                                            href="<?php echo esc_url($search_page); ?>?directory_type=<?php echo esc_attr($dir->ID); ?>"><?php echo esc_attr($title); ?></a>
                                </h4></div>
                            <?php /*?><span class="doc-categorycount"><a href="javascript:;"><?php echo intval( $total_users );?><i class="fa fa-clone"></i></a></span><?php */ ?>
                        </figcaption>
                    </figure>
                </div>
            </div>
        <?php }
    } else ?>
    <!--        Pharmacy Block As New -->
    <div class="col-md-4 col-sm-4 col-xs-6">
        <div class="doc-category">
            <figure class="doc-categoryimg">
                <div class="doc-hoverbg">
                    <h3>Pharmacy</h3>
                </div>
                <a href="<?= site_url('shop') ?>">
                    <img style="height: 225px"
                         src="<?= site_url('wp-content/uploads/2020/07/shutterstock_717437125-1-750x450-1.gif'); ?>"
                         alt="Pharmacy">
                </a>
                <figcaption class="doc-imghover">
                    <div class="doc-categoryname"><h4><a
                                    href="<?= site_url('shop') ?>">Pharmacy</a>
                        </h4></div>
                </figcaption>
            </figure>
        </div>
    </div>
    <?php {
        $directories['status'] = 'empty';
    }
    ?>
</div>
