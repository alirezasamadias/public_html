<?php
defined('ABSPATH') || die();

$sec_class = 'col-xl-8 col-lg-8';
if (ACF_ENABLED && !get_field('sidebar-team', 'options')) {
    $sec_class = 'col-xl-12';
}

?>
<div class="single-content-section <?php echo $sec_class;?>">
    <div class="sc-inner post-content p-4">
        <?php
        get_template_part('parts/team/page-actions');

        the_content();
        ?>
    </div>
</div>
