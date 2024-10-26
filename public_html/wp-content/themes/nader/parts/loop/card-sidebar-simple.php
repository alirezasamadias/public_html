<?php
defined('ABSPATH') || die();

$view = $args['view'];
$date = $args['date'];

?>
<li <?php post_class(); ?>>
    <?php NaderUtils::postThumbnail('thumbnail'); ?>
    <div class="details">
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
            <h2><?php the_title(); ?></h2>
        </a>
        <?php if ($date) { ?>
            <span class="date mt-1"><?php echo __('Date', 'nader') . ': ' . get_the_date('Y/M/d'); ?></span>
        <?php }
        if ($view && RealPressHelper::isActiveViews()) { ?>
            <span class="view mt-1"><?php echo __('View', 'nader') . ': ' . RealPressHelper::getPostViews(); ?></span>
        <?php } ?>
    </div>
</li>
