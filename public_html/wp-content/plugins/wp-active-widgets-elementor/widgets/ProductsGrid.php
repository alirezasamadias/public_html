<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;
use WP_Query;
use AE_E_FUNCTIONS;
use WP_ACTIVE_WE_QueryBuilder;

class WP_ACTIVE_WE_ProductsGrid extends Widget_Base
{

    use WP_ACTIVE_WE_QueryBuilder;

    public function get_script_depends()
    {
        return ['wp-active-we-intro-animation'];
    }

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-products-grid', AE_E_CSS_DIR . 'products-grid.css');
        return ['wp-active-we-products-grid'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'محصولات 1';
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
                'max'         => 5,
                'step'        => 1,
                'selectors'   => [
                    '{{WRAPPER}} .wp-active-we-products-grid' => 'grid-template-columns: repeat({{SIZE}}, 1fr)',
                ],
            ]
        );
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'columns-gap', 'فاصله بین افقی', 0, 50, null,
            '.wp-active-we-products-grid', 'column-gap');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'row-gap', 'فاصله بین عمودی', 0, 50, null,
            '.wp-active-we-products-grid', 'row-gap');

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
        AE_E_UTILS::DynamicStyleControls($this, 'item-normal', '.wp-active-we-products-grid .product-item', [
            'padding', 'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_MIDDLE($this, 'product-item');
        AE_E_UTILS::DynamicStyleControls($this, 'item-hover', '.wp-active-we-products-grid .product-item:hover', [
            'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);
        AE_E_UTILS::SECTION_END($this);


        // image style
        AE_E_UTILS::SECTION_START($this, 'image-styles', 'تصویر', 'style');
        AE_E_UTILS::SELECT_FIELD_STYLE($this, 'image-style', 'حالت تصویر', [
            'contain' => 'contain',
            'cover'   => 'cover'
        ], 'contain', '.wp-active-we-products-grid .product-item .image-holder img', 'object-fit');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'image-height', 'ارتفاع', 150, 300, null,
            '.wp-active-we-products-grid .product-item .image-holder', 'height');
        AE_E_UTILS::DynamicStyleControls($this, 'image-styles', '.wp-active-we-products-grid .product-item .image-holder', [
            'padding', 'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::SECTION_END($this);


        // title styles
        AE_E_UTILS::SECTION_START($this, 'title-styles', 'عنوان', 'style');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'title-distances', 'فاصله', '.wp-active-we-products-grid .product-item .product-title', 'margin');

        AE_E_UTILS::NUMBER_FIELD_STYLE($this, 'title-line-clamp', 'تعداد خط', '.wp-active-we-products-grid .product-item .product-title', '-webkit-line-clamp', 1, 3, 1, null);
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'title-line-height', 'ارتفاع', 20, 80, null, '.wp-active-we-products-grid .product-item .product-title', 'height');

        AE_E_UTILS::TextUtils($this, 'title', '.wp-active-we-products-grid .product-item .product-title', true);
        AE_E_UTILS::SECTION_END($this);


        // price styles
        $target = '.wp-active-we-products-grid .product-item .product-details .price-holder';
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


        // buy button
        AE_E_UTILS::SECTION_START($this, 'buy-button-styles', 'دکمه خرید', 'style');
        AE_E_UTILS::TAB_START($this, 'product-buy-button');
        AE_E_UTILS::COLOR_FIELD($this, 'but-button-icon-color', 'رنگ آیکون', '', '.wp-active-we-products-grid .product-item .product-details .buy-btn svg', 'fill');
        AE_E_UTILS::DynamicStyleControls($this, 'buy-button-normal', '.wp-active-we-products-grid .product-item .product-details .buy-btn', [
            'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_MIDDLE($this, 'product-buy-button');
        AE_E_UTILS::COLOR_FIELD($this, 'but-button-icon-hover', 'رنگ آیکون', '', '.wp-active-we-products-grid .product-item .product-details .buy-btn:hover svg', 'fill');
        AE_E_UTILS::DynamicStyleControls($this, 'buy-button-hover', '.wp-active-we-products-grid .product-item .product-details .buy-btn:hover', [
            'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);
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

        $this->add_render_attribute('products-container', 'class', ['wp-active-we-products-grid', 'd-grid', 'ae-gap-20']);
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
        $this->add_render_attribute('products-container', 'data-ajax-result-place', '.elementor-element-' . $this->get_id() . ' .wp-active-we-products-grid');

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
            <span class="product-title dfx w100 h20 skeleton-bg"></span>
            <div class="product-details dfx aie jcsb">
                <span class="price-holder dfx skeleton-bg"></span>
                <span class="buy-btn dfx aic jcc skeleton-bg"></span>
            </div>
        </div>
        <?php
    }

    protected function postStructure()
    {
        $post_structure = '<div class="{post_class}">';
        $post_structure .= '<div class="image-holder">{thumbnail}</div>';
        $post_structure .= '<h2 class="product-title ellipsis-2"><a href="{link}" title="{title}">{title}</a></h2>';
        $post_structure .= '<div class="product-details dfx aie jcsb"><div class="price-holder dfx aic ae-gap-5">{price}</div>';
        $post_structure .= '<a href="{link}" title="' . __("Add to cart", "woocommerce") . '" class="buy-btn dfx aic jcc"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path opacity=".4" d="M16.49 22H7.51C4 22 3.24 19.99 3.53 17.53l.9-7.5C4.66 8.09 5 6.5 8.4 6.5h7.2c3.4 0 3.74 1.59 3.97 3.53l.75 6.25.15 1.25.03.24c.21 2.35-.61 4.23-4.01 4.23Z"></path>
        <path d="M16 8.75c-.41 0-.75-.34-.75-.75V4.5c0-1.08-.67-1.75-1.75-1.75h-3c-1.08 0-1.75.67-1.75 1.75V8c0 .41-.34.75-.75.75s-.75-.34-.75-.75V4.5c0-1.91 1.34-3.25 3.25-3.25h3c1.91 0 3.25 1.34 3.25 3.25V8c0 .41-.34.75-.75.75ZM20.5 17.771c-.03.01-.06.01-.09.01H8a.749.749 0 1 1 0-1.5h12.32l.15 1.25.03.24Z"></path>
    </svg></a>';
        $post_structure .= '</div>'; // END .product-details
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

                <div class="image-holder">
                    <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail($img_size);
                    } else {
                        echo '<img src="' . AE_E_IMG_DIR . 'placeholder-1.svg">';
                    }
                    ?>
                </div>

                <h2 class="product-title ellipsis-2">
                    <a href="<?php echo esc_url($link); ?>" title="<?php esc_html_e($title); ?>">
                        <?php esc_html_e($title); ?>
                    </a>
                </h2>

                <div class="product-details dfx aie jcsb">

                    <div class="price-holder dfx aic ae-gap-5">
                        <?php echo AE_E_FUNCTIONS::getPrice($product); ?>
                    </div>

                    <a href="<?php echo esc_url($link); ?>" title="<?php _e('Add to cart', 'woocommerce'); ?>"
                       class="buy-btn dfx aic jcc">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path opacity=".4" d="M16.49 22H7.51C4 22 3.24 19.99 3.53 17.53l.9-7.5C4.66 8.09 5 6.5 8.4 6.5h7.2c3.4 0 3.74 1.59 3.97 3.53l.75 6.25.15 1.25.03.24c.21 2.35-.61 4.23-4.01 4.23Z"></path>
                            <path d="M16 8.75c-.41 0-.75-.34-.75-.75V4.5c0-1.08-.67-1.75-1.75-1.75h-3c-1.08 0-1.75.67-1.75 1.75V8c0 .41-.34.75-.75.75s-.75-.34-.75-.75V4.5c0-1.91 1.34-3.25 3.25-3.25h3c1.91 0 3.25 1.34 3.25 3.25V8c0 .41-.34.75-.75.75ZM20.5 17.771c-.03.01-.06.01-.09.01H8a.749.749 0 1 1 0-1.5h12.32l.15 1.25.03.24Z"></path>
                        </svg>
                    </a>
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

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_ProductsGrid());
