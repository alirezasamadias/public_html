<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_mini_cart'); ?>

<?php if (!WC()->cart->is_empty()) : ?>

    <ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr($args['list_class']); ?>">
        <?php
        do_action('woocommerce_before_mini_cart_contents');

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
                /**
                 * This filter is documented in woocommerce/templates/cart/cart.php.
                 *
                 * @since 2.1.0
                 */
                $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                ?>
                <li class="woocommerce-mini-cart-item <?php echo esc_attr(apply_filters('woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key)); ?>">
                    <?php
                    echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove remove_from_cart_button dfx aic jcc" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                <path opacity=".4" d="M16.19 2H7.81C4.17 2 2 4.17 2 7.81v8.37C2 19.83 4.17 22 7.81 22h8.37c3.64 0 5.81-2.17 5.81-5.81V7.81C22 4.17 19.83 2 16.19 2Z" ></path><path d="m13.06 12 2.3-2.3c.29-.29.29-.77 0-1.06a.754.754 0 0 0-1.06 0l-2.3 2.3-2.3-2.3a.754.754 0 0 0-1.06 0c-.29.29-.29.77 0 1.06l2.3 2.3-2.3 2.3c-.29.29-.29.77 0 1.06.15.15.34.22.53.22s.38-.07.53-.22l2.3-2.3 2.3 2.3c.15.15.34.22.53.22s.38-.07.53-.22c.29-.29.29-.77 0-1.06l-2.3-2.3Z" ></path></svg>
                    </a>', esc_url(wc_get_cart_remove_url($cart_item_key)), /* translators: %s is the product name */ esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))), esc_attr($product_id), esc_attr($cart_item_key), esc_attr($_product->get_sku())), $cart_item_key);
                    ?>
                    <?php if (empty($product_permalink)) : ?>
                        <div class="item-body-content">
                            <?php echo $thumbnail; ?>
                            <strong class="title-text ellipsis-2">
                                <?php echo wp_kses_post($product_name); ?>
                            </strong>
                        </div>
                    <?php else : ?>
                        <a href="<?php echo esc_url($product_permalink); ?>"
                           class="product-thumbnail">
                            <?php echo $thumbnail; ?>
                            <strong class="title-text ellipsis-2">
                                <?php echo wp_kses_post($product_name); ?>
                            </strong>
                        </a>
                    <?php endif; ?>

                    <?php echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <?php echo apply_filters('woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf('%s &times; %s', $cart_item['quantity'], $product_price) . '</span>', $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </li>
                <?php
            }
        }

        do_action('woocommerce_mini_cart_contents');
        ?>
    </ul>

    <p class="woocommerce-mini-cart__total total">
        <?php
        /**
         * Hook: woocommerce_widget_shopping_cart_total.
         *
         * @hooked woocommerce_widget_shopping_cart_subtotal - 10
         */
        do_action('woocommerce_widget_shopping_cart_total');
        ?>
    </p>

    <?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>

    <p class="woocommerce-mini-cart__buttons buttons"><?php do_action('woocommerce_widget_shopping_cart_buttons'); ?></p>

    <?php do_action('woocommerce_widget_shopping_cart_after_buttons'); ?>

<?php else : ?>

    <div class="nader-cart-is-empty">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M16.25 22.5a1.75 1.75 0 1 0 0-3.5 1.75 1.75 0 0 0 0 3.5ZM8.25 22.5a1.75 1.75 0 1 0 0-3.5 1.75 1.75 0 0 0 0 3.5Z"></path>
            <path opacity=".4"
                  d="m4.84 3.94-.2 2.45c-.04.47.33.86.8.86h15.31c.42 0 .77-.32.8-.74.13-1.77-1.22-3.21-2.99-3.21H6.29c-.1-.44-.3-.86-.61-1.21a2.62 2.62 0 0 0-1.91-.84H2c-.41 0-.75.34-.75.75s.34.75.75.75h1.74c.31 0 .6.13.81.35.21.23.31.53.29.84Z"></path>
            <path d="M20.51 8.75H5.17c-.42 0-.76.32-.8.73l-.36 4.35C3.87 15.53 5.21 17 6.92 17h11.12c1.5 0 2.82-1.23 2.93-2.73l.33-4.67a.782.782 0 0 0-.79-.85Z"></path>
        </svg>
        <p><?php esc_html_e('Your cart is empty!', 'nader'); ?></p>
    </div>

<?php endif; ?>

<?php do_action('woocommerce_after_mini_cart'); ?>
