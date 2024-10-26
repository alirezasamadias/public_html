<?php
defined('ABSPATH') || die();

$title = get_the_title();
$link  = get_the_permalink();

?>

<div <?php post_class('nader-card nader-card-team'); ?>>
    <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_html($title); ?>" class="thumbnail-holder">
        <?php NaderUtils::postThumbnail(); ?>
    </a>
    <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_html($title); ?>" class="post-title text-center">
        <h2><?php echo esc_html($title); ?></h2>
    </a>
</div>

