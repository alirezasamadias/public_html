<?php
defined('ABSPATH') || die();

$title = get_the_title();
$link  = get_the_permalink();

?>

<div <?php post_class(['archive-card','archive-card-simple']); ?>>
    <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_html($title); ?>" class="post-item-media thumbnail-holder">
        <?php AE_E_FUNCTIONS::thePostThumbnail(); ?>
    </a>
    <div class="post-item-info d-flex align-items-center justify-content-between">
        <span class="date"><?php echo get_the_date('Y/m/d'); ?></span>
        <?php
        $v = AE_E_FUNCTIONS::getPostViews();
        if ($v) {
        ?>
        <span class="views"><?php echo $v . ' '. __('Views', 'wp-active-widgets-elementor'); ?></span>
        <?php } ?>
    </div>
    <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_html($title); ?>" class="post-item-title">
        <h2><?php echo esc_html($title); ?></h2>
    </a>
</div>
