<div class="pull-left">

    <form action="<?php echo site_url() . '/dir-search/?directory_type=' . $directory_type; ?>" method="get">

        <?php do_action('docdirect_search_filters'); ?>
        <?php if (is_active_sidebar('search-page-sidebar')) { ?>
            <div class="tg-doctors-list tg-haslayout">
                <?php dynamic_sidebar('search-page-sidebar'); ?>
            </div>
        <?php } ?>
    </form>
</div>