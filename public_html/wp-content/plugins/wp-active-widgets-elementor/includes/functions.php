<?php

final class AE_E_FUNCTIONS{

    public static function getPrice($product)
    {
        $output = '';
        if ($product->is_in_stock()) {
            $empty_price = false;

            // variable product
            if ($product->is_type('variable')) {

                $available_variations = $product->get_available_variations();
                $default_attributes = $product->get_default_attributes();
                $isDefVariation = false;
                $price = null;

                if (!empty($default_attributes)) {
                    // if default variation is set -> get its price
                    foreach ($available_variations as $variation) {
                        foreach ($default_attributes as $key => $val) {
                            if ($variation['attributes']['attribute_' . $key] == $val) {
                                $isDefVariation = true;
                            }
                        }
                        if ($isDefVariation) {
                            $price = $variation['display_price'];
                        }
                    }
                } else {
                    // otherwise, get first variation price
                    $price = $available_variations[0]['display_price'];
                }

                $output .= '<b class="normal-price">' . number_format($price, 0, '', ',') . '</b>';

            } else {
                $sale_price = $product->get_sale_price();
                $normal_price = $product->get_regular_price();

                // simple product
                if ($product->is_on_sale()) {
                    $output .= '<span class="d-grid">';
                    $output .= '<del class="del-price">' . number_format($normal_price, 0, '', ',') . '</del>';
                    $output .= '<b class="normal-price">' . number_format($sale_price, 0, '', ',') . '</b>';
                    $output .= '</span>';
                } else {
                    if (empty($normal_price)) {
                        $empty_price = true;
                        $output .= '<b class="normal-price">' . __('Call Us', 'wp-active-widgets-elementor') . '</b>';
                    } else {
                        $output .= '<b class="normal-price">' . number_format($normal_price, 0, '', ',') . '</b>';
                    }
                }
            }
            if (!$empty_price) {
                $output .= '<span class="woocommerce-Price-currencySymbol">' . get_woocommerce_currency_symbol() . '</span>';
            }
        } else {
            $output .= '<b class="unavailable">' . __('Unavailable', 'wp-active-widgets-elementor') . '</b>';
        }

        return $output;
    }

    /**
     * @param $product
     * @return array|false
     *
     * return-template:
     * variable: ['price', 'symbol'] -> the price is, selected variation`s price or first variation`s price
     * simple: ['price', 'del_price', 'symbol']
     * unavailable: false
     */
    public static function getPriceArray($product)
    {
        $output = [];
        if ($product->is_in_stock()) {

            // variable product
            if ($product->is_type('variable')) {

                $available_variations = $product->get_available_variations();
                $default_attributes = $product->get_default_attributes();
                $isDefVariation = false;
                $price = null;

                if (!empty($default_attributes)) {
                    // if default variation is set -> get its price
                    foreach ($available_variations as $variation) {
                        foreach ($default_attributes as $key => $val) {
                            if ($variation['attributes']['attribute_' . $key] == $val) {
                                $isDefVariation = true;
                            }
                        }
                        if ($isDefVariation) {
                            $price = $variation['display_price'];
                        }
                    }
                } else {
                    // otherwise, get first variation price
                    $price = $available_variations[0]['display_price'];
                }

                $output['price'] = number_format($price, 0, '', ',');

            } else {
                $sale_price = $product->get_sale_price();
                $normal_price = $product->get_regular_price();

                // simple product
                if ($product->is_on_sale()) {
                    $output['price'] = number_format($sale_price, 0, '', ',');
                    $output['del_price'] = number_format($normal_price, 0, '', ',');
                } else {
                    $output['price'] = number_format($normal_price, 0, '', ',');
                }
            }
            $output['symbol'] = get_woocommerce_currency_symbol();
        } else {
            $output = false;
        }

        return $output;
    }

    public static function getPostFirstCategory($post_id = 0, $taxonomy = '')
    {
        if ($post_id === 0 || is_null($post_id)) {
            $post_id = get_the_ID();
        }

        if (empty($taxonomy)) {
            $post_type = get_post_type();

            if ($post_type === 'post') {
                $taxonomy = 'category';
            } elseif ($post_type === 'project') {
                if (taxonomy_exists('project_cat')) {
                    $taxonomy = 'project_cat';
                } elseif (taxonomy_exists('projects_category')) {
                    $taxonomy = 'projects_category';
                }
            } elseif ($post_type === 'product') {
                $taxonomy = 'product_cat';
            }
        }

        $cats = get_the_terms($post_id, $taxonomy);

        if (!is_array($cats) || is_wp_error($cats)) {
            return false;
        }

        return $cats[0];

    }

    public static function extractQueryTerms($QUERY, $tax_name)
    {
        if (empty($tax_name)) {
            return '';
        }

        $terms = [];
        while ($QUERY->have_posts()) {
            $QUERY->the_post();
            $pt = get_the_terms(get_the_ID(), $tax_name);
            if ($pt !== false && !is_wp_error($pt)) {
                foreach ($pt as $term) {
                    $terms[] = [$tax_name . '-' . $term->term_id => $term->name];
                }
            }
        }

        wp_reset_postdata();

        // unique array
        return array_map("unserialize", array_unique(array_map("serialize", $terms)));
    }

    public static function extractPostTerms($post_id, $taxonomy)
    {
        $terms_object = get_the_terms($post_id, $taxonomy);
        if (!is_array($terms_object) || is_wp_error($terms_object)) {
            return false;
        }
        $temp = [];
        foreach ($terms_object as $term) {
            $temp[] = $term->term_id;
        }
        return $temp;
    }

    public static function getRegisteredTaxonomies(bool $just_name = false)
    {
        $taxonomies = get_taxonomies(['public' => true], 'objects');

        $exceptions = [
            'elementor_library_category',
        ];
        $items = [];
        if ($just_name) {
            foreach ($taxonomies as $taxonomy) {
                if (!in_array($taxonomy->name, $exceptions)) {
                    $items[] = $taxonomy->name;
                }
            }
            return $items;
        }
        foreach ($taxonomies as $taxonomy) {
            if (!in_array($taxonomy->name, $exceptions)) {
                $items[$taxonomy->name] = $taxonomy->label;
            }
        }

        return $items;
    }

    public static function getRegisteredPostTypes(bool $just_name = false)
    {
        $post_types = get_post_types(['public' => true], 'objects');

        $exceptions = [
            'attachment',
            'e-floating-buttons',
            'elementor_library'
        ];
        $temp = [];
        if ($just_name) {
            foreach ($post_types as $post_type) {
                if (!in_array($post_type->name, $exceptions)) {
                    $temp[] = $post_type->name;
                }
            }
            return $temp;
        }

        foreach ($post_types as $post_type) {
            if (!in_array($post_type->name, $exceptions)) {
                $temp[$post_type->name] = $post_type->label;
            }
        }

        return $temp;
    }

    public static function thePostThumbnail($size = 'medium_large')
    {
        if (has_post_thumbnail()) {
            the_post_thumbnail($size);
        } else {
            echo '<img src="' . AE_E_IMG_DIR . 'placeholder-1.svg' . '" alt="' . get_the_title() . '">';
        }
    }

    public static function isActiveViews()
    {
        if (function_exists('the_views')) {
            return true;
        }

        return false;
    }

    public static function getPostViews()
    {
        $v = get_post_meta(get_the_ID(), 'views', true);
        return !empty($v) ? $v : 0;
    }

    public static function getMenusList()
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

    public static function galleryInLoop(int $post_id, $image_size)
    {
        $post_type = get_post_type($post_id);
        $post_thumb_id = get_post_thumbnail_id($post_id);
        if ($post_type === 'project') {
            $gallery_items = get_post_meta($post_id, 'project-gallery-image', true);
            if (empty($gallery_items)) {
                // it`s for savis
                $gallery_items = get_post_meta($post_id, '_gallery', true);
            }
        } elseif ($post_type === 'product') {
            $gallery_items = get_post_meta($post_id, '_product_image_gallery', true);
            if (!empty($gallery_items)) {
                $gallery_items = explode(',', $gallery_items);
            }
        }
        if (empty($gallery_items)) {
            return '';
        }


        $html = '<div class="gil-pages d-grid w100" style="grid-template-columns: repeat(' . count($gallery_items) + 1 . ',1fr)">';
        $html .= '<span class="gil-page dfx aie" data-image-id="' . esc_attr($post_thumb_id) . '" ';
        $html .= 'data-url="' . get_the_post_thumbnail_url($post_id, $image_size) . '" ';
        $html .= 'data-srcset="' . wp_get_attachment_image_srcset($post_thumb_id) . '"> ';
        $html .= '<span class="dfx w100 trans03"></span>';
        $html .= '</span>'; // END .gil-page
        foreach ($gallery_items as $gallery_item) {
            $html .= '<span class="gil-page dfx aie" ';
            $html .= 'data-image-id="' . esc_attr($gallery_item) . '" ';
            $html .= 'data-url="' . wp_get_attachment_image_url($gallery_item, $image_size) . '" ';
            $html .= 'data-srcset="' . wp_get_attachment_image_srcset($gallery_item) . '">';
            $html .= '<span class="dfx w100 trans03"></span>';
            $html .= '</span>';
        }
        $html .= '</div>'; // END .gil-pages

        return $html;
    }

    public static function cfInLoop($widget, $settings, int $post_id)
    {
        $fields = $settings['custom-fields'];
        if (empty($fields)) {
            return;
        }

        ?>
        <ul class="custom-field dfx dir-v w100">
            <?php
            foreach ($fields as $field) {
                $value = get_post_meta($post_id, $field['key'], true);
                if (empty($value)) {
                    continue;
                }
                ?>
                <li class="field-wrapper <?php echo 'key-' . esc_html($field['key']); ?> dfx aic wrap">
                    <?php
                    AE_E_UTILS::ICON_PRINT($widget, $field, 'field-');

                    echo '<div class="field-value-wrapper">';
                    if (!empty($field['title'])) {
                        echo '<span class="field-title">' . $field['title'] . '</span>';
                    }
                    echo '<span class="field-value">' . $value . '</span>';
                    echo '</div>';
                    ?>
                </li>
            <?php } ?>
        </ul>
        <?php
    }

    public static function cfStructureForAjax($widget, $fields)
    {
        $block = [
            'wrapper' => [
                'start' => '<ul class="custom-field dfx dir-v w100">',
                'end'   => '</ul>'
            ]
        ];

        $items = [];
        foreach ($fields as $field) {
            $template = '<li class="field-wrapper key-' . $field['key'] . ' dfx aic wrap">';
            $template .= AE_E_UTILS::ICON_PRINT($widget, $field, 'field-', '', false);
            $template .= '<div class="field-value-wrapper">';
            if (!empty($field['title'])) {
                $template .= '<span class="field-title">' . $field['title'] . '</span>';
            }
            $template .= '<span class="field-value">{custom_field_value}</span>';

            $template .= '</div>';
            $template .= '</li>';

            $items[] = [
                'key'      => $field['key'],
                'template' => $template
            ];
        }
        $block['items'] = $items;

        return $block;
    }

    public static function getPostsByQuery()
    {
        $search_string = isset($_POST['q']) ? sanitize_text_field(wp_unslash($_POST['q'])) : ''; // phpcs:ignore
        $post_type = isset($_POST['post_type']) ? $_POST['post_type'] : 'post';                  // phpcs:ignore
        $results = array();

        $query = new WP_Query(array(
            's'              => $search_string,
            'post_type'      => $post_type,
            'posts_per_page' => -1,
        ));

        if (!isset($query->posts)) {
            return;
        }

        foreach ($query->posts as $post) {
            $results[] = array(
                'id'   => $post->ID,
                'text' => $post->post_title,
            );
        }

        wp_send_json($results);
    }

    public static function getPostsTitleById()
    {
        $ids = isset($_POST['id']) ? $_POST['id'] : array();                    // phpcs:ignore
        $post_type = isset($_POST['post_type']) ? $_POST['post_type'] : 'post'; // phpcs:ignore
        $results = array();

        $query = new WP_Query(array(
            'post_type'      => $post_type,
            'post__in'       => $ids,
            'posts_per_page' => -1,
            'orderby'        => 'post__in',
        ));

        if (!isset($query->posts)) {
            return;
        }

        foreach ($query->posts as $post) {
            $results[$post->ID] = $post->post_title;
        }

        wp_send_json($results);
    }

    public static function getTaxonomiesTitleById()
    {
        $ids = isset($_POST['id']) ? $_POST['id'] : array(); // phpcs:ignore
        $results = array();

        $args = array(
            'include' => $ids,
        );

        $terms = get_terms($args);

        if (is_array($terms) && $terms) {
            foreach ($terms as $term) {
                if (is_object($term)) {
                    $results[$term->term_id] = $term->name . ' (' . $term->taxonomy . ')';
                }
            }
        }

        wp_send_json($results);
    }

    public static function getTaxonomiesByQuery()
    {
        $search_string = isset($_POST['q']) ? sanitize_text_field(wp_unslash($_POST['q'])) : ''; // phpcs:ignore
        $taxonomy = isset($_POST['taxonomy']) ? $_POST['taxonomy'] : '';                         // phpcs:ignore
        $results = array();

        $args = array(
            'taxonomy'   => $taxonomy,
            'hide_empty' => false,
            'search'     => $search_string,
        );

        $terms = get_terms($args);

        if (is_array($terms) && $terms) {
            foreach ($terms as $term) {
                if (is_object($term)) {
                    $results[] = array(
                        'id'   => $term->term_id,
                        'text' => $term->name . ' (' . $term->taxonomy . ')',
                    );
                }
            }
        }

        wp_send_json($results);
    }
}

//var_dump(AE_E_FUNCTIONS::getRegisteredPostTypes());