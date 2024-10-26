<?php
defined('ABSPATH') || exit;

?>
<div class="woocommerce-products-header p-4 mb-4">
    <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
        <div class="title-box d-flex align-items-center gap-2 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path fill="none" d="M0 0h24v24H0z"/>
                <path d="M21 13.242V20h1v2H2v-2h1v-6.758A4.496 4.496 0 0 1 1 9.5c0-.827.224-1.624.633-2.303L4.345 2.5a1 1 0 0 1 .866-.5H18.79a1 1 0 0 1 .866.5l2.702 4.682A4.496 4.496 0 0 1 21 13.242zm-2 .73a4.496 4.496 0 0 1-3.75-1.36A4.496 4.496 0 0 1 12 14.001a4.496 4.496 0 0 1-3.25-1.387A4.496 4.496 0 0 1 5 13.973V20h14v-6.027zM5.789 4L3.356 8.213a2.5 2.5 0 0 0 4.466 2.216c.335-.837 1.52-.837 1.856 0a2.5 2.5 0 0 0 4.644 0c.335-.837 1.52-.837 1.856 0a2.5 2.5 0 1 0 4.457-2.232L18.21 4H5.79z"/>
            </svg>
            <h2 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h2>
        </div>
    <?php endif; ?>

    <div class="shop-count-order d-flex justify-content-between">
        <div class="count-box d-flex align-items-center">
            <?php woocommerce_result_count(); ?>
        </div>
        <div class="order-box">
            <?php woocommerce_catalog_ordering(); ?>
        </div>
    </div>
</div>

