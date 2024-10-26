<?php
defined('ABSPATH') || die();

$title = get_the_title();

?>

<div <?php post_class(['archive-card', 'archive-card-2']); ?>>

    <div class="post-item-media thumbnail-holder dfx jcc aic">
        <?php AE_E_FUNCTIONS::thePostThumbnail(); ?>
    </div>

    <div class="post-item-inner">
        <div class="post-item-body">
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_html($title); ?>" class="post-item-title">
                <h2><?php echo esc_html($title); ?></h2>
            </a>
        </div>
    </div>

</div>