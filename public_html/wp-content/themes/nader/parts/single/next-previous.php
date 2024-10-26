<?php
defined('ABSPATH') || die();

$next_post = get_next_post();
$prev_post = get_previous_post();

$container_class = 'justify-content-between';
if (empty($next_post)) {
    $container_class = 'justify-content-end';
}
?>
<div class="sc-inner post-next-previous align-items-center <?php echo esc_attr($container_class); ?> mt-4 p-4">
    <?php if (!empty($next_post)) { ?>
        <a href="<?php echo get_the_permalink($next_post); ?>" title="<?php echo get_the_title($next_post); ?>"
           class="next-post d-flex align-items-center gap-3">
            <?php echo get_the_post_thumbnail($next_post, 'thumbnail'); ?>
            <h3><?php echo get_the_title($next_post); ?> :<?php _e('Next', 'nader'); ?></h3>
        </a>
    <?php } ?>

    <?php if (!empty($prev_post)) { ?>
    <a href="<?php echo get_the_permalink($prev_post); ?>" title="<?php echo get_the_title($prev_post); ?>"
       class="previous-post d-flex align-items-center justify-content-end gap-3">
        <h3><?php _e('Previous', 'nader'); ?>: <?php echo get_the_title($prev_post); ?></h3>
        <?php echo get_the_post_thumbnail($prev_post, 'thumbnail'); ?>
    </a>
    <?php } ?>
</div>
