<?php
if (!defined('ABSPATH')) {
    exit;
}
global $product;
$p_id  = $product->get_id();
$link  = $product->get_permalink();
$title = $product->get_title();
?>
<li <?php wc_product_class(['product-card', 'product-card-simple'], $product); ?>>
    <a href="<?php echo $link; ?>" title="<?php echo $title; ?>" class="thumbnail-holder">
        <?php echo woocommerce_get_product_thumbnail('medium'); ?>
    </a>
    <?php woocommerce_template_loop_price(); ?>
    <a href="<?php echo $link; ?>" title="<?php echo $title; ?>">
        <?php woocommerce_template_loop_product_title(); ?>
    </a>
</li>
