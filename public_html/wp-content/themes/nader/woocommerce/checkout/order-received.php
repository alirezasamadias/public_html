<?php
/**
 * "Order received" message.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/order-received.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.8.0
 *
 * @var WC_Order|false $order
 */

defined('ABSPATH') || exit;
?>

<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received w100 dfx dir-v jcc aic mb-5">

    <span class="icon dfx aic jcc mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path opacity=".4"
                  d="M10.75 2.45c.69-.59 1.82-.59 2.52 0l1.58 1.36c.3.26.86.47 1.26.47h1.7c1.06 0 1.93.87 1.93 1.93v1.7c0 .39.21.96.47 1.26l1.36 1.58c.59.69.59 1.82 0 2.52l-1.36 1.58c-.26.3-.47.86-.47 1.26v1.7c0 1.06-.87 1.93-1.93 1.93h-1.7c-.39 0-.96.21-1.26.47l-1.58 1.36c-.69.59-1.82.59-2.52 0l-1.58-1.36c-.3-.26-.86-.47-1.26-.47H6.18c-1.06 0-1.93-.87-1.93-1.93V16.1c0-.39-.21-.95-.46-1.25l-1.35-1.59c-.58-.69-.58-1.81 0-2.5l1.35-1.59c.25-.3.46-.86.46-1.25V6.21c0-1.06.87-1.93 1.93-1.93h1.73c.39 0 .96-.21 1.26-.47l1.58-1.36Z">
            </path>
            <path d="M16.58 11.069c-.19-.27-.51-.42-.89-.42h-1.95c-.13 0-.25-.05-.33-.15a.478.478 0 0 1-.1-.37l.24-1.56c.1-.46-.21-.99-.67-1.14-.43-.16-.94.06-1.14.36l-1.94 2.88v-.36c0-.7-.3-.99-1.04-.99h-.49c-.74 0-1.04.29-1.04.99v4.78c0 .7.3.99 1.04.99h.49c.7 0 1-.27 1.03-.91l1.47 1.13c.2.2.65.31.97.31h1.85c.64 0 1.28-.48 1.42-1.07l1.17-3.56c.13-.32.1-.65-.09-.91Z">
            </path>
        </svg>
    </span>

    <?php
    /**
     * Filter the message shown after a checkout is complete.
     *
     * @param string $message The message.
     * @param WC_Order|false $order The order created during checkout, or false if order data is not available.
     * @since 2.2.0
     *
     */
    $message = apply_filters('woocommerce_thankyou_order_received_text', esc_html(__('Thank you. Your order has been received.', 'woocommerce')), $order);

    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo $message;
    ?>
</p>