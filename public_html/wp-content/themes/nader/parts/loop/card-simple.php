<?php
defined('ABSPATH') || die();

$title = get_the_title();
$link  = get_the_permalink();

?>

<div <?php post_class('nader-card nader-card-simple'); ?>>
    <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_html($title); ?>" class="thumbnail-holder">
        <?php NaderUtils::postThumbnail(); ?>
    </a>
    <div class="post-info d-flex align-items-center justify-content-between">
        <span class="date"><?php echo get_the_date('Y/m/d'); ?></span>
        <span class="views"><?php echo RealPressHelper::getPostViews() . ' '. __('Views', 'nader'); ?></span>
    </div>
    <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_html($title); ?>" class="post-title">
        <h2><?php echo esc_html($title); ?></h2>
    </a>
</div>
