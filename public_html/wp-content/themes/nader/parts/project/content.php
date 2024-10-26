<?php
defined('ABSPATH') || die();

$form_id = '';
$sec_class = 'col-xl-8 col-lg-8';

if (ACF_ENABLED) {
    $form_id = get_field('nader-single-project_order-form', 'options');

    if (!get_field('sidebar-projects', 'options')) {
        $sec_class = 'col-xl-12';
    }
}


?>
<div class="project-content-section single-content-section <?php echo $sec_class; ?>">

    <?php get_template_part('parts/project/tabs-switcher'); ?>

    <div class="sc-inner project-content fz_changer_target p-4">
        <?php
        get_template_part('parts/single/page-actions');

        the_content();

        if (has_tag()) {
            get_template_part('parts/single/tags');
        }
        ?>
    </div>

    <?php get_template_part('parts/single/next-previous') ?>

    <?php if (!empty($form_id)) { ?>
        <div class="sc-inner project-form p-4">
            <?php echo RealPressHelper::loadElementorContent($form_id) ?>
        </div>
    <?php } ?>

    <?php if (comments_open()) { ?>
        <div class="sc-inner project-comments p-4">
            <?php comments_template(); ?>
        </div>
    <?php } ?>
</div>
