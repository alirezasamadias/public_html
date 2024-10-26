<?php
defined('ABSPATH') || die();

$gallery = get_post_meta(get_the_ID(), 'project-gallery-image', true);

?>
<div class="post-thumbnail col-md-5">
    <?php if (empty($gallery)) { ?>
        <a href="<?php the_post_thumbnail_url('full'); ?>" data-lightbox="nader-single-thumbnail">
            <?php the_post_thumbnail('medium_large'); ?>
        </a>
    <?php } else { ?>
        <div class="project-gallery-image fancybox-gallery owl-carousel">
            <div class="gallery-item"
                 data-src="<?php the_post_thumbnail_url('full'); ?>"
                 data-fancybox="fancybox-gallery">
                <?php the_post_thumbnail('medium_large'); ?>
            </div>
            <?php
            foreach ($gallery as $image) {
                echo '<div class="gallery-item"
                data-src="' . wp_get_attachment_image_url($image, 'full') . '"
                data-fancybox="fancybox-gallery">';
                echo wp_get_attachment_image($image, 'medium_large', '', ['data-no-lazy' => '1']);
                echo '</div>';
            }
            ?>
        </div>
    <?php } ?>
</div>
