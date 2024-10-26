<?php
defined('ABSPATH') || die();

$sec_class = 'col-xl-8 col-lg-8';
if (ACF_ENABLED && !get_field('sidebar-posts', 'options')) {
    $sec_class = 'col-xl-12';
}

?>
<div class="single-content-section <?php echo $sec_class;?>">
    <div class="sc-inner post-content p-4">
        <?php
        get_template_part('parts/single/page-actions');

        the_content();

        if (has_tag()) {
            get_template_part('parts/single/tags');
        }
        ?>
    </div>

    <?php if (comments_open()) { ?>
        <div class="sc-inner post-comments mt-4 p-4">
            <?php comments_template(); ?>
        </div>
    <?php } ?>
</div>
