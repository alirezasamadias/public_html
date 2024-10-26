<?php
defined('ABSPATH') || die();

$title    = get_the_title();
$link     = get_the_permalink();
$category = AE_E_FUNCTIONS::getPostFirstCategory();

?>

    <div <?php post_class(['archive-card', 'archive-card-3']); ?>>

        <div class="post-item-media">
            <a href="<?php echo esc_url($link); ?>" title="<?php esc_html_e($title); ?>" class="thumbnail-holder">
                <?php AE_E_FUNCTIONS::thePostThumbnail(); ?>
            </a>

            <?php if (!empty($category)) { ?>
                <a href="<?php echo get_term_link($category->term_id); ?>" title="<?php echo $category->name; ?>" class="post-category">
                    <?php echo $category->name; ?>
                </a>
            <?php } ?>

        </div>

        <a href="<?php echo esc_url($link); ?>" title="<?php esc_html_e($title); ?>" class="post-item-title">
            <h2><?php esc_html_e($title); ?></h2>
        </a>

        <div class="post-item-details dfx ae-gap-15">
            <span class="date dfx dir-v aic jcc ae-gap-5">
                <strong class="day dfx aic jcc"><?php echo get_the_date('d'); ?></strong>
                <?php echo get_the_date('M'); ?>
            </span>
            <p class="excerpt"><?php echo get_the_excerpt(); ?></p>
        </div>

    </div>

<?php
