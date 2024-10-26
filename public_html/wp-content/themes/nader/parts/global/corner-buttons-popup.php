<?php

defined('ABSPATH') || die();

if (empty(get_field('custom-corner-buttons', 'options'))) {
    return;
}

?>

<div class="corner-buttons-popup popup-box">

    <div class="popup-box-header d-flex align-items-center justify-content-between">
        <b class="title"><?php echo get_field('popup-corner-btns-title', 'options') ?></b>
        <span class="popup-box-closer d-flex align-items-center justify-content-center cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path fill="none" d="M0 0h24v24H0z"/>
                <path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"/>
            </svg>
        </span>
    </div>
    <!--/.search-header-->

    <div class="popup-box-inner-wrapper">
        <?php

        do_action('nader/popup/custom_corner_buttons/before_buttons');

        echo '<div class="custom-corner-popup-buttons-list d-flex align-items-center justify-content-center">';
        while (have_rows('custom-corner-buttons', 'options')) {
            the_row();
            $class = '';
            $title = '';

            if (!empty(get_sub_field('class'))) {
                $class = ' ' . esc_attr(get_sub_field('class'));
            }
            if (!empty(get_sub_field('title'))) {
                $title = 'title="' . esc_html(get_sub_field('title')) . '"';
            }
            ?>
            <a href="<?php echo get_sub_field('link'); ?>" target="_blank" <?php echo $title; ?>
               class="dfx aic jcc<?php echo $class; ?>">
                <?php echo get_sub_field('icon'); ?>
            </a>
            <?php
        }
        echo '</div>';

        do_action('nader/popup/custom_corner_buttons/after_buttons');

        ?>
    </div>
</div>
