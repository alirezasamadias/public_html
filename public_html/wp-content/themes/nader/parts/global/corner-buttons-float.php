<?php

defined('ABSPATH') || die();

if (!ACF_ENABLED || empty(get_field('custom-corner-buttons', 'options'))) {
    return;
}

while (have_rows('custom-corner-buttons', 'options')) {
    the_row();
    $class = '';
    $title = '';

    if (!empty(get_sub_field('class'))) {
        $class = esc_attr(get_sub_field('class'));
    }
    if (!empty(get_sub_field('title'))) {
        $title = 'title="' . esc_html(get_sub_field('title')) . '"';
    }
    ?>
    <a href="<?php echo get_sub_field('link'); ?>" target="_blank" <?php echo $title; ?>
       class="corner-button <?php echo $class; ?> dfx aic jcc">
        <?php echo get_sub_field('icon'); ?>
    </a>
    <?php
}

