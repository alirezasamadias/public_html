<?php

require_once __DIR__ . '/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'register_required_plugins');

function register_required_plugins()
{

    $plugins_external_uri = 'https://ghaleblake.ir/plugins/';

    $plugins = array(

        array(
            'name' => 'المنتور',
            'slug' => 'elementor',
            'required' => true,
        ),

        array(
            'name' => 'المنتور پرو',
            'slug' => 'elementor-pro',
            'required' => true,
            'source' => $plugins_external_uri . 'elementor-pro.zip',
        ),

        array(
            'name' => 'زمینه های دلخواه پیشرفته حرفه ای',
            'slug' => 'advanced-custom-fields-pro',
            'required' => true,
            'source' => $plugins_external_uri . 'advanced-custom-fields-pro.zip'
        ),

        array(
            'name' => 'Polylang Pro',
            'slug' => 'polylang-pro',
            'required' => false,
            'source' => $plugins_external_uri . 'polylang-pro.zip'
        ),

        array(
            'name' => 'اتصال polylang به elementor',
            'slug' => 'connect-polylang-elementor',
            'required' => false,
        ),

        array(
            'name' => 'اتصال polylang به ACF',
            'slug' => 'acf-options-for-polylang',
            'required' => false,
        ),

        array(
            'name' => 'woocommerce',
            'slug' => 'woocommerce',
            'required' => false,
        ),

        array(
            'name' => 'ویجت های اختصاصی نادر',
            'slug' => 'wp-active-widgets-elementor',
            'required' => true,
            'source' => $plugins_external_uri . 'wp-active-widgets-elementor.zip'
        ),

    );

    if (function_exists('WC')) {
        $plugins[] = array(
            'name' => 'Advanced AJAX Product Filters for WooCommerce',
            'slug' => 'woocommerce-ajax-filters',
            'required' => false,
        );
        $plugins[] = array(
            'name' => 'WPC Smart Compare for WooCommerce',
            'slug' => 'woo-smart-compare',
            'required' => false,
        );
//        $plugins[] = array(
//            'name' => 'تیکت پشتیبانی',
//            'slug' => 'nirweb-support',
//            'required' => false,
//            'source' => $plugins_external_uri . 'nirweb-support.zip'
//        );
    }


    $config = array(
        'id' => 'nader',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu' => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug' => 'themes.php',            // Parent menu slug.
        'capability' => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices' => true,                    // Show admin notices or not.
        'dismissable' => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg' => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message' => '',                      // Message to output right before the plugins table.

        'strings' => array(
            'page_title' => esc_html__('نصب پلاگین‌های ضروری نادر', "nader"),
            'menu_title' => esc_html__('نصب پلاگین‌های نادر', "nader"),
            'installing' => esc_html__('در حال نصب پلاگین: %s', "nader"),
        ),
        'notice_can_install_required' => _n_noop(
            'نادر به این پلاگین نیاز دارد: %1$s.',
            'نادر به این پلاگین‌ها نیاز دارد: %1$s.',
            'nader'
        ),
        'notice_ask_to_update_maybe' => _n_noop(
            'آپدیت جدید برای این پلاگین موجود است: %1$s.',
            'این پلاگین‌ها را آپدیت کنید: %1$s.',
            'nader'
        ),
    );

    tgmpa($plugins, $config);
}
