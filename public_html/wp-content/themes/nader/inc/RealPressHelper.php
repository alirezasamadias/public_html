<?php

defined('ABSPATH') || die();

final class RealPressHelper{


    /**
     * @param $value
     *
     * @return void
     */
    public static function print_r($value)
    {
        echo '<pre dir="ltr">';
        print_r($value);
        echo '</pre>';
    }


    /**
     * @return bool
     */
    public static function isEditingElementor(): bool
    {
        return \Elementor\Plugin::$instance->editor->is_edit_mode() === true;
    }


    /**
     * @param $template
     *
     * @return false|string
     */
    public static function loadElementorContent($template)
    {
        if (!empty($template) && self::isActiveElementor()) {
            $response = \Elementor\Plugin::instance()->documents->get($template);
            if (!empty($response)) {
                return $response->get_content(true);
            }
        }
    }

    /**
     * @param string|null $string
     * @param string $delimiter
     *
     * @return array|false
     *
     * <br /> for strings that listed by new line
     */
    public static function stringToArray($string = null, string $delimiter = ',')
    {
        if (empty($string) || ($string === null) || $string === false) {
            return false;
        }

        $listed = \explode($delimiter, $string);
        $list_dirty = array_map('trim', $listed);
        $list = array_filter($list_dirty, function($value) {
            if ($value) {
                return $value;
            }
        });

        return $list;
    }


    /**
     * @param $string
     *
     * @return array|false|string[]
     */
    public static function NL_StringToArray($string)
    {
        if (empty($string) || ($string === null) || $string === false) {
            return false;
        }

        return preg_split('/\r\n|\r|\n/', $string);
    }


    // get list of product attributes
    public static function getWooPAs()
    {
        $package = [];
        $taxonomies = get_object_taxonomies('product');
        if (!empty($taxonomies)) {
            $names = [];
            foreach ($taxonomies as $taxonomy) {
                $names[] = self::getTaxonomyNameFromSlug($taxonomy);
            }
            $package = array_combine($taxonomies, $names);
        }

        unset($package['product_type']);
        unset($package['product_visibility']);
        unset($package['product_cat']);
        unset($package['product_tag']);
        unset($package['product_shipping_class']);

        return $package;
    }

    public static function getProductCatThumbnail($term_id)
    {
        if (!empty($term_id)) {
            $thumb_id = get_term_meta($term_id, 'thumbnail_id', true);
            return wp_get_attachment_thumb_url($thumb_id);
        }
    }


    /**
     * if $justNames == true: return array that key & value are the same == term title
     *
     * @param string $taxonomy
     * @param bool $justNames
     *
     * @return array|false
     */
    public static function getTaxonomy(string $taxonomy = 'category', bool $justNames = false)
    {
        $container = [];

        if (!taxonomy_exists($taxonomy)) {
            return false;
        }

        $args = [
            'taxonomy'   => $taxonomy,
            'hide_empty' => false,
        ];
        $terms = get_terms($args);

        if ($justNames === true) {
            foreach ($terms as $term) {
                $container[$term->name] = $term->name;
            }
        } else {
            foreach ($terms as $term) {
                $container[$term->term_id] = $term->name;
            }
        }

        return $container;
    }


    public static function getTermName($term)
    {
        if (!empty($term) && is_numeric($term) || is_object($term)) {
            $term = get_term($term);
            if (!is_wp_error($term)) {
                return $term->name;
            }
        }
    }


    public static function getTermMeta($term_id, $meta_key)
    {
        if (!empty($term_id)) {
            return get_term_meta($term_id, $meta_key, true);
        }

        return false;
    }


    /**
     * @param          $Query
     * @param string $taxonomy_name
     *
     * @return array
     */
    public static function getQueryTerms($Query, string $taxonomy_name = 'category')
    {
        $terms = [];
        while ($Query->have_posts()) {
            $Query->the_post();
            $pt = get_the_terms(get_the_ID(), $taxonomy_name);
            if ($pt !== false && !is_wp_error($pt)) {
                foreach ($pt as $term) {
                    $terms[] = [$term->term_id => $term->name];
                }
            }
        }

        // unique array
        return array_map("unserialize", array_unique(array_map("serialize", $terms)));
    }


    /**
     * @param array $args
     *
     * @return array
     */
    public static function getPosts(array $args)
    {
        $stack = [];

        $defaults = [
            'post_type'      => 'post',
            'posts_per_page' => -1
        ];

        $Query = new WP_Query(array_replace_recursive($defaults, $args));

        if ($Query->have_posts()) {
            while ($Query->have_posts()) {
                $Query->the_post();
                $stack[get_the_ID()] = get_the_title();
            }
        }

        wp_reset_postdata();

        return $stack;
    }


    /**
     * @return array
     */
    public static function getMenus()
    {
        $menus = wp_get_nav_menus();

        $container = [];
        if (!empty($menus)) {
            foreach ($menus as $menu) {
                $container[$menu->term_id] = $menu->name;
            }
        }

        return $container;
    }

    public static function isLocationHasMenu(string $theme_location)
    {
        $theme_locations = get_nav_menu_locations();
        $menu_obj = get_term($theme_locations[$theme_location], 'nav_menu');

        if (!empty($menu_obj->name)) {
            return true;
        }

        return false;
    }


    /**
     * @param string $metaKey
     *
     * @return mixed
     */
    public static function getMeta(string $metaKey)
    {
        return get_post_meta(get_the_ID(), $metaKey, true);
    }


    public static function getPostViews()
    {
        $v = get_post_meta(get_the_ID(), 'views', true);
        return !empty($v) ? $v : 0;
    }


    /**
     * @return array
     */
    public static function getRegisteredTaxonomies()
    {
        $taxonomies = get_taxonomies(null, 'objects');
        $items = [];

        foreach ($taxonomies as $taxonomy) {
            $items[$taxonomy->name] = $taxonomy->label;
        }

        return $items;
    }


    /**
     * @param $taxonomy_slug
     *
     * @return false|string
     */
    public static function getTaxonomyNameFromSlug($taxonomy_slug)
    {
        $taxonomies = get_taxonomies(null, 'objects');
        foreach ($taxonomies as $taxonomy) {
            if ($taxonomy->name === $taxonomy_slug) {
                return $taxonomy->label;
            }
        }

        return false;
    }


    /**
     * @param $post_id
     *
     * @return false|mixed|WP_Term
     */
    public static function getPostFirstCategory($post_id = null)
    {
        $post_type = get_post_type($post_id);
        $taxonomy = '';

        if ($post_type === 'post') {
            $taxonomy = 'category';
        } elseif ($post_type === 'project') {
            $taxonomy = 'project_cat';
        } elseif ($post_type === 'product') {
            $taxonomy = 'product_cat';
        }

        $cats = get_the_terms($post_id, $taxonomy);

        if (is_wp_error($cats) || !$cats) {
            return false;
        }

        return $cats[0];
    }


    /**
     * @param $hex
     * @param $steps
     *
     * @return string
     * @see url
     *      https://stackoverflow.com/questions/3512311/how-to-generate-lighter-darker-color-with-php
     *
     */
    public static function colorLD($hex, $steps)
    {
        // Steps should be between -255 and 255. Negative = darker, positive = lighter
        $steps = max(-255, min(255, $steps));

        // Normalize into a six character long hex string
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
        }

        // Split into three parts: R, G and B
        $color_parts = str_split($hex, 2);
        $return = '#';

        foreach ($color_parts as $color) {
            $color = hexdec($color);                                  // Convert to decimal
            $color = max(0, min(255, $color + $steps));               // Adjust color
            $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
        }

        return $return;
    }


    /**
     * @param int $length
     *
     * @return false|string
     */
    public static function idGenerator(int $length)
    {
        $numbers = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $lowerCases = [
            'a',
            'b',
            'c',
            'd',
            'e',
            'f',
            'g',
            'h',
            'i',
            'j',
            'k',
            'l',
            'm',
            'n',
            'o',
            'p',
            'q',
            'r',
            's',
            't',
            'u',
            'v',
            'w',
            'x',
            'y',
            'z'
        ];
        $upperCases = [];

        // Create Uppercase Alphabets
        foreach ($lowerCases as $alpha) {
            $upperCases[] = strtoupper($alpha);
        }

        $store = array_merge($numbers, $lowerCases, $upperCases);

        shuffle($store);

        $store = 'x' . substr(implode($store), 0, $length - 1);

        return $store;
    }


    /**
     * @param $number
     *
     * @return array|float|int|string|string[]
     */
    public static function formatNumber($number)
    {
        if (empty($number) || is_null($number)) {
            return 0;
        }

        // strip any formatting
        $number = (0 + str_replace(",", "", $number));

        if (!is_numeric($number)) {
            return 0;
        }

        $precision = 2;
        if ($number >= 1000 && $number < 1000000) {
            $formatted = number_format($number / 1000, $precision) . 'K';
        } elseif ($number >= 1000000 && $number < 1000000000) {
            $formatted = number_format($number / 1000000, $precision) . 'M';
        } elseif ($number >= 1000000000) {
            $formatted = number_format($number / 1000000000, $precision) . 'B';
        } else {
            $formatted = $number; // Number is less than 1000
        }
        $formatted = str_replace('.00', '', $formatted);

        return $formatted;
    }


    /**
     * @param string $data_name
     * @param array|null $data
     *
     * @return void
     */
    public static function insertJsonToElement(string $data_name, array $data = null)
    {
        if ($data) {
            echo sprintf('data-' . $data_name . '=\'%1$s\'', json_encode($data));
        }
    }


    /**
     * @param $url
     *
     * @return array
     */
    public static function getAttachmentIdByUrl($url)
    {
        global $wpdb;

        return $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url));
    }


    /**
     * @param int $user_id
     *
     * @return int|int[]|\WP_Comment[]
     */
    public static function getUserCommentsCount(int $user_id)
    {
        $args = [
            'user_id' => $user_id,
            'count'   => true
        ];

        return get_comments($args);
    }


    /**
     * @param int $user_id
     * @param int $count
     *
     * @return int|int[]|\WP_Comment[]
     */
    public static function getUserLatestComments(int $user_id, int $count)
    {
        $args = [
            'user_id' => $user_id,
            'number'  => $count
        ];
        return get_comments($args);
    }

    public static function getUserLatestOrders(int $user_id, int $order_count = 5)
    {
        $customer_orders = get_posts([
            'numberposts' => $order_count,
            'meta_key'    => '_customer_user',
            'meta_value'  => $user_id,
            'post_type'   => wc_get_order_types('view-orders'),
            'post_status' => array_keys(wc_get_order_statuses()),
        ]);

        if ($customer_orders) {
            return $customer_orders;
        }

        return false;
    }

    public static function getUserAllOrdersCount()
    {
        if (RealPressHelper::isActiveWC()) {
            $customer_orders = new WP_Query([
                'posts_per_page' => -1,
                'meta_key'       => '_customer_user',
                'meta_value'     => get_current_user_id(),
                'post_type'      => ['shop_order'],
                'post_status'    => [
                    'wc-completed',
                    'wc-pending',
                    'wc-processing',
                    'wc-on-hold',
                    'wc-cancelled',
                    'wc-refunded',
                    'wc-failed'
                ],
                'fields'         => 'ids',
                'no_found_rows'  => true,
            ]);

            if ($customer_orders->have_posts()) {
                return $customer_orders->post_count;
            }

            wp_reset_postdata();
        }

        return 0;
    }

    public static function getUserTotalOrdersCost()
    {
        if (RealPressHelper::isActiveWC()) {

            $customer_orders = get_posts(array(
                'numberposts' => -1,
                'meta_key'    => '_customer_user',
                'meta_value'  => get_current_user_id(),
                'post_type'   => array('shop_order'),
                'post_status' => array('wc-completed')
            ));

            $total = 0;
            foreach ($customer_orders as $customer_order) {
                $order = wc_get_order($customer_order);
                $total += $order->get_total();
            }

            return $total;
        }

        return 0;
    }

    public static function getUserCompletedOrdersCount()
    {
        if (RealPressHelper::isActiveWC()) {
            $customer_orders = new WP_Query([
                'posts_per_page' => -1,
                'meta_key'       => '_customer_user',
                'meta_value'     => get_current_user_id(),
                'post_type'      => ['shop_order'],
                'post_status'    => ['wc-completed'],
                'fields'         => 'ids',
                'no_found_rows'  => true,
            ]);

            if ($customer_orders->have_posts()) {
                return $customer_orders->post_count;
            }

            wp_reset_postdata();
        }

        return 0;
    }

    public static function getUserCancelledOrdersCount()
    {
        if (RealPressHelper::isActiveWC()) {
            $customer_orders = new WP_Query([
                'posts_per_page' => -1,
                'meta_key'       => '_customer_user',
                'meta_value'     => get_current_user_id(),
                'post_type'      => ['shop_order'],
                'post_status'    => ['wc-cancelled'],
                'fields'         => 'ids',
                'no_found_rows'  => true,
            ]);

            if ($customer_orders->have_posts()) {
                return $customer_orders->post_count;
            }

            wp_reset_postdata();
        }

        return 0;
    }

    public static function getUserPendingOrdersCount()
    {
        if (RealPressHelper::isActiveWC()) {
            $customer_orders = new WP_Query([
                'posts_per_page' => -1,
                'meta_key'       => '_customer_user',
                'meta_value'     => get_current_user_id(),
                'post_type'      => ['shop_order'],
                'post_status'    => ['wc-pending'],
                'fields'         => 'ids',
                'no_found_rows'  => true,
            ]);

            if ($customer_orders->have_posts()) {
                return $customer_orders->post_count;
            }

            wp_reset_postdata();
        }

        return 0;
    }

    public static function getUserProccessingOrdersCount()
    {
        if (RealPressHelper::isActiveWC()) {
            $customer_orders = new WP_Query([
                'posts_per_page' => -1,
                'meta_key'       => '_customer_user',
                'meta_value'     => get_current_user_id(),
                'post_type'      => ['shop_order'],
                'post_status'    => ['wc-processing'],
                'fields'         => 'ids',
                'no_found_rows'  => true,
            ]);

            if ($customer_orders->have_posts()) {
                return $customer_orders->post_count;
            }

            wp_reset_postdata();
        }

        return 0;
    }

    public static function getUserOnholdOrdersCount()
    {
        if (RealPressHelper::isActiveWC()) {
            $customer_orders = new WP_Query([
                'posts_per_page' => -1,
                'meta_key'       => '_customer_user',
                'meta_value'     => get_current_user_id(),
                'post_type'      => ['shop_order'],
                'post_status'    => ['wc-on-hold'],
                'fields'         => 'ids',
                'no_found_rows'  => true,
            ]);

            if ($customer_orders->have_posts()) {
                return $customer_orders->post_count;
            }

            wp_reset_postdata();
        }

        return 0;
    }


    /**
     * @param $menu_slug
     * @param $title
     * @param $icon
     *
     * @return void
     */
    public static function createAcfOptionPage($menu_slug, $title, $icon)
    {
        add_action('acf/init', function() use ($menu_slug, $title, $icon) {
            if (function_exists('acf_add_options_page')) {
                // Register options page.
                acf_add_options_page([
                    'page_title'      => $title,
                    'menu_title'      => $title,
                    'menu_slug'       => $menu_slug,
                    'redirect'        => false,
                    'icon_url'        => $icon,
                    'update_button'   => 'ذخیره تنظمیات',
                    'updated_message' => 'تنظیمات ذخیره شد',
                ]);
            }
        });
    }


    public static function acfAllowSvgForMenu()
    {
        add_filter('wp_kses_allowed_html', function($tags, $context) {
            if ($context === 'acf') {
                $tags['svg'] = array(
                    'xmlns'       => true,
                    'fill'        => true,
                    'viewbox'     => true,
                    'role'        => true,
                    'aria-hidden' => true,
                    'focusable'   => true,
                );
                $tags['path'] = array(
                    'd'       => true,
                    'fill'    => true,
                    'opacity' => true
                );
            }

            return $tags;
        }, 10, 2);
    }

    public static function allowSvgUploading()
    {
        add_filter('upload_mimes', function($mimes) {
            $mimes['svg'] = 'image/svg+xml';
            return $mimes;
        });
    }


    public static function add_F_I_ColumnToDashboard(array $post_types = ['post'])
    {

        foreach ($post_types as $post_type) {
            // Add the posts and pages columns filter. Same function for both.
            add_filter('manage_' . $post_type . '_posts_columns', function($columns) {
                $columns['nader_dashboard_thumb'] = 'تصویر';
                return $columns;
            });

            // Add featured image thumbnail to the WP Admin table.
            add_action('manage_' . $post_type . '_posts_custom_column', function($columns) {
                switch ($columns) {
                    case 'nader_dashboard_thumb':
                        if (function_exists('the_post_thumbnail'))
                            the_post_thumbnail(['60', '60']);
                        break;
                }
            });

            // Move the new column at the first place.
            add_filter('manage_' . $post_type . '_posts_columns', function($columns) {
                $n_columns = array();
                $move = 'nader_dashboard_thumb'; // which column to move
                $before = 'title';               // move before this column

                foreach ($columns as $key => $value) {
                    if ($key == $before) {
                        $n_columns[$move] = $move;
                    }
                    $n_columns[$key] = $value;
                }
                return $n_columns;
            });

        }

        // Format the column width with CSS
        add_action('admin_head', function() {
            echo '<style>.column-nader_dashboard_thumb {width: 60px;}</style>';
        });

    }


    public static function fixDateForPolylang()
    {
        add_filter('get_the_date', function($the_date, $format, $post) {
            if (defined('POLYLANG')) {

                if (get_locale() === 'fa_IR') {
                    return $the_date;
                }

                $timestamp = get_post_timestamp($post);
                return date($format, $timestamp);
            }

            return $the_date;
        }, 100, 3);
    }


    public static function isActiveViews()
    {
        if (function_exists('the_views')) {
            return true;
        }

        return false;
    }

    public static function isActiveUlike()
    {
        if (function_exists('wp_ulike')) {
            return true;
        }

        return false;
    }

    public static function isActiveElementor()
    {
        if (is_plugin_active('elementor/elementor.php')) {
            return true;
        }

        return false;
    }

    public static function isActiveWpml()
    {
        if (is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
            return true;
        }

        return false;
    }

    public static function isActiveAcfPro()
    {
        if (is_plugin_active('advanced-custom-fields-pro/acf.php')) {
            return true;
        }

        return false;
    }

    public static function isActiveWC()
    {
        if (function_exists('WC')) {
            return true;
        }

        return false;
    }

    public static function isActivePageNavi()
    {
        if (is_plugin_active('wp-pagenavi/wp-pagenavi.php')) {
            return true;
        }

        return false;
    }

    public static function isActiveWooWallet()
    {
        if (function_exists('woo_wallet')) {
            return true;
        }

        return false;
    }

}
