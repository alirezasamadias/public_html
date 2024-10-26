<?php

defined('ABSPATH') || die();
?>

<div class="nader-mini-cart-box">
    <div class="nader-mini-cart-header dfx aic jcsb">
        <span class="nader-mini-cart-header-title">
            <?php esc_html_e('Cart', 'nader'); ?>
        </span>
        <span class="mini-cart-closer cursor-pointer dfx aic jcc">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                <path opacity=".4" d="M16.19 2H7.81C4.17 2 2 4.17 2 7.81v8.37C2 19.83 4.17 22 7.81 22h8.37c3.64 0 5.81-2.17 5.81-5.81V7.81C22 4.17 19.83 2 16.19 2Z"></path>
                <path d="m13.06 12 2.3-2.3c.29-.29.29-.77 0-1.06a.754.754 0 0 0-1.06 0l-2.3 2.3-2.3-2.3a.754.754 0 0 0-1.06 0c-.29.29-.29.77 0 1.06l2.3 2.3-2.3 2.3c-.29.29-.29.77 0 1.06.15.15.34.22.53.22s.38-.07.53-.22l2.3-2.3 2.3 2.3c.15.15.34.22.53.22s.38-.07.53-.22c.29-.29.29-.77 0-1.06l-2.3-2.3Z"></path>
            </svg>
        </span>
    </div>

    <div class="widget_shopping_cart_content">
        <?php
        if (WC()->cart->is_empty()) {
            ?>

            <div class="nader-cart-is-empty">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24">
                    <path d="M16.25 22.5a1.75 1.75 0 1 0 0-3.5 1.75 1.75 0 0 0 0 3.5ZM8.25 22.5a1.75 1.75 0 1 0 0-3.5 1.75 1.75 0 0 0 0 3.5Z"></path>
                    <path opacity=".4"
                          d="m4.84 3.94-.2 2.45c-.04.47.33.86.8.86h15.31c.42 0 .77-.32.8-.74.13-1.77-1.22-3.21-2.99-3.21H6.29c-.1-.44-.3-.86-.61-1.21a2.62 2.62 0 0 0-1.91-.84H2c-.41 0-.75.34-.75.75s.34.75.75.75h1.74c.31 0 .6.13.81.35.21.23.31.53.29.84Z"></path>
                    <path d="M20.51 8.75H5.17c-.42 0-.76.32-.8.73l-.36 4.35C3.87 15.53 5.21 17 6.92 17h11.12c1.5 0 2.82-1.23 2.93-2.73l.33-4.67a.782.782 0 0 0-.79-.85Z"></path>
                </svg>
                <p><?php esc_html_e('Your cart is empty!', 'nader'); ?></p>
            </div>

            <?php
        } else {
            woocommerce_mini_cart();
        }
        ?>
    </div>
</div>


