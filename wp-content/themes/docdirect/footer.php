<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Doctor Directory
 */

?>
<?php do_action('docdirect_prepare_footers');?>
<?php  wp_footer(); ?>
<script src="https://cdn.jsdelivr.net/gh/cferdinandi/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
<script>
    var scroll = new SmoothScroll('a[href*="#"]', {
        speed: 300
    });
</script>
<a class="scrollToTop" href="#" style="display: inline;"><i class="fa fa-angle-up"></i></a>
</body></html>