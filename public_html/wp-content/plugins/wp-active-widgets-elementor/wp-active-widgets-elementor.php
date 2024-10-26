<?php
defined('ABSPATH') || die();
/**
 * Plugin Name: WP ACTIVE WIDGETS ELEMENTOR
 * Version: 2.8.0
 * Description: پلاگین ویجت های اختصاصی المنتور ساخته شده بدست علی عمادزاده
 * Author: Ali Emadzadeh
 * Author URI:https://www.rtl-theme.com/author/halbia/
 * Domain Path: /lang
 * Text Domain: wp-active-widgets-elementor
 */

load_plugin_textdomain('wp-active-widgets-elementor', false, dirname( plugin_basename( __FILE__ ) ) . '/lang');

add_action('admin_notices', function () {
    if (!is_plugin_active('elementor/elementor.php')) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p>افزونه المنتور غیرفعال یا حذف شده است. بعضی از بخش های سایت نمایش داده نمیشوند.</p>
        </div>
        <?php
    }
});

if (!function_exists('is_plugin_active')) {
    require_once(ABSPATH . 'wp-admin/includes/plugin.php');
}
if (!is_plugin_active('elementor/elementor.php')) {
    return;
}

require_once 'elementor-init-new.php';

