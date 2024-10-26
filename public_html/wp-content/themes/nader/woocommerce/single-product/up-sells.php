<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if ($upsells) : ?>

    <section class="up-sells upsells products mt-5">
        <?php
        $heading = apply_filters('woocommerce_product_upsells_products_heading', __('You may also like&hellip;', 'woocommerce'));

        if ($heading) :
            ?>
            <div class="single-product-more-product-title-box d-flex align-items-center mb-3 gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="none" d="M0 0h24v24H0z"/>
                    <path d="M3 12h2v9H3v-9zm16-4h2v13h-2V8zm-8-6h2v19h-2V2z"/>
                </svg>
                <h2><?php echo esc_html($heading); ?></h2>
            </div>
        <?php endif; ?>

        <?php woocommerce_product_loop_start(); ?>

        <?php foreach ($upsells as $upsell) : ?>

            <?php
            $post_object = get_post($upsell->get_id());

            setup_postdata($GLOBALS['post'] =& $post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

            get_template_part('parts/product/card/simple');
            ?>

        <?php endforeach; ?>

        <?php woocommerce_product_loop_end(); ?>

    </section>

<?php
endif;

wp_reset_postdata();
