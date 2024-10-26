<?php
defined('ABSPATH') || die();

$product           = wc_get_product();
$gallery_image_ids = $product->get_gallery_image_ids();

?>
<?php if (empty($gallery_image_ids)) { ?>
    <div class="post-thumbnail col-md-5">
        <a href="<?php the_post_thumbnail_url('full'); ?>">
            <?php echo woocommerce_get_product_thumbnail('medium_large'); ?>
        </a>
    </div>
<?php } else { ?>
    <div class="product-gallery-wrapper col-md-5">
        <div class="product-gallery-image fancybox-gallery owl-carousel">
            <div data-src="<?php the_post_thumbnail_url('full'); ?>"
               data-fancybox="fancybox-gallery">
                <?php echo woocommerce_get_product_thumbnail('medium_large'); ?>
            </div>
            <?php
            foreach ($gallery_image_ids as $img_id) {
                echo '<div class="gallery-item"
                data-src="' . wp_get_attachment_image_url($img_id, 'full') . '"
                data-fancybox="fancybox-gallery">';
                echo wp_get_attachment_image($img_id, 'medium_large', '', ['data-no-lazy' => '1']);
                echo '</div>';
            }
            ?>
        </div>
    </div>
<?php } ?>

