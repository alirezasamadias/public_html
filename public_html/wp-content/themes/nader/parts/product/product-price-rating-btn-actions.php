<?php
defined('ABSPATH') || die();
global $product_id;
?>
<div class="product-summary-row product-summary-one d-flex align-items-center justify-content-between flex-wrap">
    <div class="price-box d-flex align-items-center">
        <?php
        woocommerce_template_single_price();
        woocommerce_template_single_rating();
        ?>
    </div>
    <div class="actions-box d-flex align-items-center justify-content-end gap-2">
        <?php
        if (function_exists('woosc_init')) {
            echo do_shortcode("[woosc id=" . $product_id . "]");
        }

        ae_wishlist_btn(get_the_ID());

        ?>
    </div>
</div>