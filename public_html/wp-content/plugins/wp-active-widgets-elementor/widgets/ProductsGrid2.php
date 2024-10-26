<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;
use WP_Query;
use AE_E_FUNCTIONS;
use WP_ACTIVE_WE_QueryBuilder;

class WP_ACTIVE_WE_ProductsGrid2 extends Widget_Base
{

    use WP_ACTIVE_WE_QueryBuilder;

    public function get_script_depends()
    {
        return ['wp-active-we-intro-animation'];
    }

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-products-grid-2', AE_E_CSS_DIR . 'products-grid-2.css');
        return ['wp-active-we-products-grid-2'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'محصولات 2';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-products';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        AE_E_UTILS::NOTICE($this, 'notice-post-type', 'در تنظیمات کوئری، نوع نوشته را بر روی محصولات قرار دهید.');

        AE_E_UTILS::IMAGE_SIZE($this, 'product-image', 'medium_large');
        $this->add_responsive_control(
            'products-columns',
            [
                'label'       => 'تعداد ستون',
                'type'        => Controls_Manager::NUMBER,
                'label_block' => false,
                'min'         => 1,
                'max'         => 6,
                'step'        => 1,
                'selectors'   => [
                    '{{WRAPPER}} .wp-active-we-products-grid-2' => 'grid-template-columns: repeat({{SIZE}}, 1fr)',
                ],
            ]
        );
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'columns-gap', 'فاصله بین افقی', 0, 50, null,
            '.wp-active-we-products-grid-2', 'column-gap');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'row-gap', 'فاصله بین عمودی', 0, 50, null,
            '.wp-active-we-products-grid-2', 'row-gap');

        AE_E_UTILS::SWITCH_FIELD($this, 'use-ajax', 'لود ایجکسی');
        AE_E_UTILS::SELECT_FIELD($this, 'ajax-loading-type', 'زمان اجرای ایجکس', [
            'scroll'  => 'هنگام رسیدن به پست',
            'timeout' => 'به محض لود صفحه'
        ], 'scroll', 'use-ajax', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'intro-animation', 'انیمیشن ورود');

        $this->end_controls_section();

        $this->QuerySettings();


        $this->register_controls_styles();

        $this->QueryNotHavePostsStyle();

    }

    protected function register_controls_styles()
    {

        // box styles
        AE_E_UTILS::SECTION_START($this, 'item-styles', 'آیتم', 'style');
        AE_E_UTILS::TAB_START($this, 'product-item');
        AE_E_UTILS::DynamicStyleControls($this, 'item-normal', '.wp-active-we-products-grid-2 .product-item', [
            'padding', 'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_MIDDLE($this, 'product-item');
        AE_E_UTILS::DynamicStyleControls($this, 'item-hover', '.wp-active-we-products-grid-2 .product-item:hover', [
            'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);
        AE_E_UTILS::SECTION_END($this);


        // image style
        AE_E_UTILS::SECTION_START($this, 'image-styles', 'تصویر', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'image-height', 'ارتفاع', 150, 300, null,
            '.wp-active-we-products-grid-2 .product-item .image-holder', 'height');
        AE_E_UTILS::DynamicStyleControls($this, 'image-styles', '.wp-active-we-products-grid-2 .product-item .image-holder', [
            'padding', 'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::SECTION_END($this);


        // title styles
        AE_E_UTILS::SECTION_START($this, 'title-styles', 'عنوان', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'title-distances', 'فاصله', 0, 50, null,
            '.wp-active-we-products-grid-2 .product-item .details-holder', 'margin-top');
        AE_E_UTILS::NUMBER_FIELD_STYLE($this, 'title-line-clamp', 'تعداد خط', '.wp-active-we-products-grid-2 .product-item .product-title', '-webkit-line-clamp', 1, 3, 1, null);
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'title-line-height', 'ارتفاع', 20, 80, null, '.wp-active-we-products-grid-2 .product-item .product-title', 'height');

        AE_E_UTILS::TextUtils($this, 'title', '.wp-active-we-products-grid-2 .product-item .product-title');
        AE_E_UTILS::COLOR_FIELD($this, 'title-color-hover', 'رنگ هاور', '', '.wp-active-we-products-grid-2 .product-item .product-title:hover h2', 'color');
        AE_E_UTILS::SECTION_END($this);


        // price styles
        $target = '.wp-active-we-products-grid .product-item .price-holder';
        AE_E_UTILS::SECTION_START($this, 'price-style', 'قیمت', 'style');
        AE_E_UTILS::Separator($this, 'price-normal', 'عادی');
        AE_E_UTILS::TextUtils($this, 'price-normal', $target . ' .normal-price');
        AE_E_UTILS::Separator($this, 'price-del', 'خط خورده');
        AE_E_UTILS::TextUtils($this, 'price-del', $target . ' .del-price');
        AE_E_UTILS::Separator($this, 'price-symbol', 'تومان');
        AE_E_UTILS::TextUtils($this, 'price-symbol', $target . ' .woocommerce-Price-currencySymbol');
        AE_E_UTILS::Separator($this, 'price-unavailable', 'ناموجود');
        AE_E_UTILS::TextUtils($this, 'price-unavailable', $target . ' .unavailable');
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $use_ajax       = $settings['use-ajax'];
        $query          = null;
        $posts_per_page = $settings['posts_per_page'];
        if ($use_ajax === 'yes') {
            $this->ajaxify($settings);
        } else {
            $query_args              = $this->QueryArgBuilder();
            $query_args['post_type'] = 'product';
            $query                   = new WP_Query($query_args);

            if (!$query->have_posts()) {
                $this->add_render_attribute('products-container', 'class', 'grid-one-col');
            }
        }


        $this->add_render_attribute('products-container', 'class', ['wp-active-we-products-grid-2', 'd-grid', 'ae-gap-30']);
        if ($settings['intro-animation'] === 'yes') {
            $this->add_render_attribute('products-container', 'class', 'active-animation');
            $this->add_render_attribute('products-container', 'data-animation-target', '.elementor-element-' . $this->get_id() . ' .product-item');
            $this->add_render_attribute('products-container', 'data-animation-offset', '100');
        }

        ?>
        <div <?php $this->print_render_attribute_string('products-container'); ?>>

            <?php
            if ($use_ajax) {
                for ($i = 0; $i < $posts_per_page; $i++) {
                    $this->placeholder();
                }
            } else {
                $this->printQuery($settings, $query);
            }
            ?>


        </div>
        <?php
    }

    protected function ajaxify($settings)
    {

        $query_args              = $this->QueryArgBuilder();
        $query_args['post_type'] = 'product';
        $this->add_render_attribute('products-container', 'class', 'wp-active-we-ajax-container');
        $this->add_render_attribute('products-container', 'data-query-args', json_encode($query_args));
        $this->add_render_attribute('products-container', 'data-ajax-type', $settings['ajax-loading-type']);
        $this->add_render_attribute('products-container', 'data-ajax-status', 'before_start');
        $this->add_render_attribute('products-container', 'data-post-structure', json_encode($this->postStructure()));
        $this->add_render_attribute('products-container', 'data-ajax-result-place', '.elementor-element-' . $this->get_id() . ' .wp-active-we-products-grid-2');

        $widget_data = [
            'wid'         => $this->get_id(),
            'post_class' => 'product-item',
            'image_size' => $settings['product-image_size']
        ];
        if ($settings['intro-animation'] === 'yes') {
            $widget_data['post_class'] .= ' item-has-intro-animation';
        }
        $this->add_render_attribute('products-container', 'data-widget-data', json_encode($widget_data));
    }

    protected function placeholder()
    {
        ?>
        <div class="product-item placeholder animated-placeholder">
            <span class="image-holder dfx w100 skeleton-bg"></span>
            <div class="details-holder">
                <span class="product-title dfx w100 h20 skeleton-bg"></span>
                <span class="price-holder dfx w100 h20 skeleton-bg"></span>
            </div>
        </div>
        <?php
    }

    protected function postStructure()
    {
        $post_structure = '<div class="{post_class}">';
        $post_structure .= '<a href="{link}" title="{title}" class="image-holder">{thumbnail}</a>';
        $post_structure .= '<div class="details-holder">';
        $post_structure .= '<a href="{link}" title="{title}" class="product-title ellipsis-2"><h2>{title}</h2></a>'; // END .product-title
        $post_structure .= '<div class="price-holder">{price}</div>';
        $post_structure .= '</div>'; // END .details-holder
        $post_structure .= '</div>';

        return $post_structure;
    }

    protected function printQuery($settings, $query)
    {
        $img_size = $settings['product-image_size'];

        while ($query->have_posts()) {
            $query->the_post();
            $product = wc_get_product(get_the_ID());

            $link  = get_the_permalink();
            $title = get_the_title();

            ?>
            <div <?php wc_product_class('product-item'); ?>>
                <a href="<?php echo esc_url($link); ?>" title="<?php esc_html_e($title); ?>" class="image-holder">
                    <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail($img_size);
                    } else {
                        echo '<img src="' . AE_E_IMG_DIR . 'placeholder-1.svg">';
                    }
                    ?>
                </a>

                <div class="details-holder">
                    <a href="<?php echo esc_url($link); ?>" title="<?php esc_html_e($title); ?>" class="product-title ellipsis-2">
                        <h2><?php esc_html_e($title); ?></h2>
                    </a>

                    <div class="price-holder">
                        <?php echo AE_E_FUNCTIONS::getPrice($product); ?>
                    </div>
                </div>

            </div>
            <?php
        }

        if (!$query->have_posts()) {
            $this->QueryNotHavePostsMessage();
        }

        wp_reset_postdata();
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_ProductsGrid2());
