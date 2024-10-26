<?php

defined('ABSPATH') || die();

$scroll_to_top_enable = ACF_ENABLED ? get_field('scroll-to-top-enable', 'options') : false;

if ($scroll_to_top_enable) {
    $scroll_to_top_type = get_field('scroll-to-top-type', 'options');

    if ($scroll_to_top_type === 'simple') {
        ?>
        <div id='scroll-to-top' class='topbutton btn-hide scroll-to-top-simple' role='button' title='<?php esc_html_e('Go Top', 'nader'); ?>'>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="m17.02 21.292-3.48-1.74c-.97-.48-2.1-.48-3.07 0l-3.48 1.74c-2.99 1.49-6.14-1.72-4.58-4.67l.82-1.54c.11-.21.29-.38.51-.48l12.64-5.7c.52-.23 1.13-.02 1.39.48l3.81 7.24c1.56 2.95-1.58 6.16-4.56 4.67Z"></path>
                <path opacity=".4" d="m15.6 7.69-8.28 3.73c-.93.42-1.87-.58-1.39-1.48l3.04-5.77c1.29-2.45 4.79-2.45 6.08 0l1.07 2.04c.28.55.04 1.23-.52 1.48Z"></path>
            </svg>
        </div>
        <?php
    }

    if ($scroll_to_top_type === 'line') {
        ?>
        <div id='scroll-to-top' class='topbutton btn-hide scroll-to-top-line' role='button' title='<?php esc_html_e('Go Top', 'nader'); ?>'>
                <span class="icon dfx aic jcc">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="m17.02 21.292-3.48-1.74c-.97-.48-2.1-.48-3.07 0l-3.48 1.74c-2.99 1.49-6.14-1.72-4.58-4.67l.82-1.54c.11-.21.29-.38.51-.48l12.64-5.7c.52-.23 1.13-.02 1.39.48l3.81 7.24c1.56 2.95-1.58 6.16-4.56 4.67Z"></path>
                        <path opacity=".4" d="m15.6 7.69-8.28 3.73c-.93.42-1.87-.58-1.39-1.48l3.04-5.77c1.29-2.45 4.79-2.45 6.08 0l1.07 2.04c.28.55.04 1.23-.52 1.48Z"></path>
                    </svg>
                </span>
            <span class='scroll-top-line'>
                <span class='scroll-top-fill'></span>
            </span>
        </div>
        <?php
    }
}
