<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if ($related_products) : ?>

    <section class="related products mt-5">

        <?php
        $heading = apply_filters('woocommerce_product_related_products_heading', __('Related products', 'woocommerce'));

        if ($heading) :
            ?>
            <div class="single-product-more-product-title-box d-flex align-items-center mb-3 gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path opacity=".4" d="M11 7.5v9c0 .55-.45 1-1 1H7.5c-1.52 0-2.89-.62-3.89-1.61A5.547 5.547 0 0 1 2 12.22C1.88 9.08 4.62 6.5 7.77 6.5H10c.55 0 1 .45 1 1ZM22.002 11.78c.13 3.15-2.61 5.72-5.76 5.72h-2.23c-.55 0-1-.45-1-1v-9c0-.55.45-1 1-1h2.5c1.52 0 2.89.62 3.89 1.61.93.95 1.54 2.24 1.6 3.67Z"></path><path d="M16 12.75H8c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h8c.41 0 .75.34.75.75s-.34.75-.75.75Z"></path></svg>
                <h2><?php echo esc_html($heading); ?></h2>
            </div>
        <?php endif; ?>

        <?php woocommerce_product_loop_start(); ?>

        <?php foreach ($related_products as $related_product) : ?>

            <?php
            $post_object = get_post($related_product->get_id());

            setup_postdata($GLOBALS['post'] =& $post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

            get_template_part('parts/product/card/simple');
            ?>

        <?php endforeach; ?>

        <?php woocommerce_product_loop_end(); ?>

    </section>
<?php
endif;

wp_reset_postdata();
