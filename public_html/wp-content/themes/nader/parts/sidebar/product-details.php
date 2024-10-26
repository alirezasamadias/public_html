<?php
defined('ABSPATH') || die();
global $product;

$sidebar_header = [
    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="m19.37 4.891-5.86-2.61c-.86-.38-2.16-.38-3.02 0l-5.86 2.61c-1.48.66-1.7 1.56-1.7 2.04s.22 1.38 1.7 2.04l5.86 2.61c.43.19.97.29 1.51.29s1.08-.1 1.51-.29l5.86-2.61c1.48-.66 1.7-1.56 1.7-2.04s-.21-1.38-1.7-2.04Z"></path><path opacity=".4" d="M12 17.04c-.38 0-.76-.08-1.11-.23l-6.74-3c-1.03-.46-1.83-1.69-1.83-2.82 0-.41.33-.74.74-.74s.74.33.74.74c0 .54.45 1.24.95 1.46l6.74 3c.32.14.69.14 1.01 0l6.74-3c.5-.22.95-.91.95-1.46 0-.41.33-.74.74-.74s.74.33.74.74c0 1.12-.8 2.36-1.83 2.82l-6.74 3c-.34.15-.72.23-1.1.23Z"></path><path opacity=".4" d="M12 22c-.38 0-.76-.08-1.11-.23l-6.74-3a3.085 3.085 0 0 1-1.83-2.82c0-.41.33-.74.74-.74s.74.33.74.74c0 .63.37 1.2.95 1.46l6.74 3c.32.14.69.14 1.01 0l6.74-3c.57-.25.95-.83.95-1.46 0-.41.33-.74.74-.74s.74.33.74.74c0 1.22-.72 2.32-1.83 2.82l-6.74 3c-.34.15-.72.23-1.1.23Z"></path></svg>',
    'title' => __('Product Details', 'nader')
];

?>
<div class="si-product-details sidebar-item d-flex flex-column gap-3 p-4 mb-4">

    <?php get_template_part('parts/sidebar/sidebar-item', 'header', $sidebar_header) ?>

    <?php if ($product->get_date_modified()) { ?>
        <div class="product-detail-item product-modified d-flex align-items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M16.75 3.56V2c0-.41-.34-.75-.75-.75s-.75.34-.75.75v1.5h-6.5V2c0-.41-.34-.75-.75-.75s-.75.34-.75.75v1.56c-2.7.25-4.01 1.86-4.21 4.25-.02.29.22.53.5.53h16.92c.29 0 .53-.25.5-.53-.2-2.39-1.51-4-4.21-4.25Z"></path>
                <path opacity=".4"
                      d="M20 9.84c.55 0 1 .45 1 1V17c0 3-1.5 5-5 5H8c-3.5 0-5-2-5-5v-6.16c0-.55.45-1 1-1h16Z"></path>
                <path d="M8.5 14.999c-.13 0-.26-.03-.38-.08s-.23-.12-.33-.21c-.09-.1-.16-.21-.21-.33a.995.995 0 0 1-.08-.38c0-.13.03-.26.08-.38s.12-.23.21-.33c.1-.09.21-.16.33-.21a1 1 0 0 1 .76 0c.12.05.23.12.33.21.09.1.16.21.21.33.05.12.08.25.08.38s-.03.26-.08.38-.12.23-.21.33c-.1.09-.21.16-.33.21-.12.05-.25.08-.38.08ZM12 14.999c-.13 0-.26-.03-.38-.08s-.23-.12-.33-.21c-.18-.19-.29-.45-.29-.71 0-.26.11-.52.29-.71.1-.09.21-.16.33-.21.24-.11.52-.11.76 0 .12.05.23.12.33.21.18.19.29.45.29.71 0 .26-.11.52-.29.71-.1.09-.21.16-.33.21-.12.05-.25.08-.38.08ZM8.5 18.499c-.13 0-.26-.03-.38-.08s-.23-.12-.33-.21c-.18-.19-.29-.45-.29-.71 0-.26.11-.52.29-.71.1-.09.21-.16.33-.21a1 1 0 0 1 .76 0c.12.05.23.12.33.21.18.19.29.45.29.71 0 .26-.11.52-.29.71-.1.09-.21.16-.33.21-.12.05-.25.08-.38.08Z"></path>
            </svg>
            <?php _e('Last Update', 'nader'); ?>:
            <?php echo get_the_date('Y/m/d', $product->get_date_modified()); ?>
        </div>
    <?php } ?>

    <?php if (RealPressHelper::isActiveViews()) { ?>
        <div class="product-detail-item product-views d-flex align-items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path opacity=".4"
                      d="M16.192 2h-8.37c-3.64 0-5.81 2.17-5.81 5.81v8.37c0 3.64 2.17 5.81 5.81 5.81h8.37c3.64 0 5.81-2.17 5.81-5.81V7.81c0-3.64-2.17-5.81-5.81-5.81Z"></path>
                <path d="M10.11 11.152H7.46c-.63 0-1.14.51-1.14 1.14v5.12h3.79v-6.26Z"></path>
                <path opacity=".4"
                      d="M12.762 6.602h-1.52c-.63 0-1.14.51-1.14 1.14v9.66h3.79v-9.66c0-.63-.5-1.14-1.13-1.14Z"></path>
                <path d="M16.548 12.852h-2.65v4.55h3.79v-3.41c-.01-.63-.52-1.14-1.14-1.14Z"></path>
            </svg>
            <?php _e('Views', 'nader'); ?>:
            <?php echo RealPressHelper::getPostViews(); ?>
        </div>
    <?php } ?>

    <?php if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) { ?>
        <div class="product-detail-item product-sku d-flex align-items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path opacity=".4"
                      d="M16.19 2H7.81C4.17 2 2 4.17 2 7.81v8.37C2 19.83 4.17 22 7.81 22h8.37c3.64 0 5.81-2.17 5.81-5.81V7.81C22 4.17 19.83 2 16.19 2Z"></path>
                <path d="M6.89 15.749c-.28 0-.54-.15-.67-.41a.745.745 0 0 1 .34-1.01c.87-.43 1.61-1.09 2.14-1.89.18-.27.18-.61 0-.88-.54-.8-1.28-1.46-2.14-1.89a.74.74 0 0 1-.34-1.01c.18-.37.63-.52 1-.33 1.1.55 2.04 1.38 2.72 2.4a2.3 2.3 0 0 1 0 2.54 7.077 7.077 0 0 1-2.72 2.4c-.1.05-.22.08-.33.08ZM17 15.75h-4c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h4c.41 0 .75.34.75.75s-.34.75-.75.75Z"></path>
            </svg>
            <?php _e('Product SKU', 'nader'); ?>:
            <?php echo ($sku = $product->get_sku()) ? $sku : esc_html__('N/A', 'woocommerce'); ?>
        </div>
    <?php } ?>

    <div class="product-detail-item product-categories d-flex align-items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M7.24 2h-1.9C3.15 2 2 3.15 2 5.33v1.9c0 2.18 1.15 3.33 3.33 3.33h1.9c2.18 0 3.33-1.15 3.33-3.33v-1.9C10.57 3.15 9.42 2 7.24 2Z"></path>
            <path opacity=".4"
                  d="M18.67 2h-1.9c-2.18 0-3.33 1.15-3.33 3.33v1.9c0 2.18 1.15 3.33 3.33 3.33h1.9c2.18 0 3.33-1.15 3.33-3.33v-1.9C22 3.15 20.85 2 18.67 2Z"></path>
            <path d="M18.67 13.43h-1.9c-2.18 0-3.33 1.15-3.33 3.33v1.9c0 2.18 1.15 3.33 3.33 3.33h1.9c2.18 0 3.33-1.15 3.33-3.33v-1.9c0-2.18-1.15-3.33-3.33-3.33Z"></path>
            <path opacity=".4"
                  d="M7.24 13.43h-1.9C3.15 13.43 2 14.58 2 16.76v1.9C2 20.85 3.15 22 5.33 22h1.9c2.18 0 3.33-1.15 3.33-3.33v-1.9c.01-2.19-1.14-3.34-3.32-3.34Z"></path>
        </svg>
        <?php echo _n('Category:', 'Categories:', count($product->get_category_ids()), 'woocommerce'); ?>
        <?php echo wc_get_product_category_list($product->get_id(), '</li><li>', '<ul class="d-flex flex-wrap gap-1"><li>', '</li></ul>'); ?>
    </div>

    <?php if (has_term('', 'product_tag')) { ?>
        <div class="product-detail-item product-tags d-flex align-items-center gap-3">
            <?php echo wc_get_product_tag_list($product->get_id(), '</li><li>', '<ul class="d-flex flex-wrap gap-1"><li>', '</li></ul>'); ?>
        </div>
    <?php } ?>

</div>
