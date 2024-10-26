<?php
defined('ABSPATH') || exit;

?>
<div class="product-sidebar-section single-sidebar-section <?php echo is_singular() ? 'col-xl-4' : 'col-xl-3'; ?> col-lg-4">
    <?php
    if (ACF_ENABLED) {
        if (is_singular()) {
            get_template_part('parts/sidebar/product', 'details');
            if (is_active_sidebar('shop_product')) {
                echo '<div class="sidebar-item p-4 mb-4">';
                dynamic_sidebar('shop_product');
                echo '</div>';
            }
        } elseif (!is_singular() && is_active_sidebar('shop_sidebar')) {
            echo '<div class="sidebar-item p-4 mb-4">';
            dynamic_sidebar('shop_sidebar');
            echo '</div>';
        }
    }
    ?>
</div>
