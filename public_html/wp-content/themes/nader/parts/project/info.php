<?php
/**
 * Project Info
 */
defined('ABSPATH') || die();
$post_id = get_the_ID();

if (!ACF_ENABLED || !have_rows('custom-project-details', 'options')) {
    return;
}

$output = false;
while (have_rows('custom-project-details', 'options')) {
    the_row();
    $key   = get_sub_field('key');
    $value = get_field($key, $post_id);
    if (!empty($value)) {
        $output = true;
        reset_rows();
        break;
    }
}

if ($output) {
    echo '<div class="project-info post-infos row">';
}

while (have_rows('custom-project-details', 'options')) {
    the_row();

    $icon  = get_sub_field('icon');
    $title = get_sub_field('title');
    $key   = get_sub_field('key');

    $value = get_field($key, $post_id);
    if (empty($value)) {
        continue;
    }

    ?>
    <div class="pib col-12 col-lg-6 d-flex align-items-center gap-3">
        <span class="icon d-flex align-items-center justify-content-center"><?php echo $icon; ?></span>
        <span class="pibt">
            <span class="bt"><?php echo esc_html($title); ?></span>
            <span class="ba"><?php echo esc_html($value); ?></span>
        </span>
    </div>
    <?php
}

if ($output) {
    echo '</div>';
}

