<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_ARCHIVE_1 extends Widget_Base
{

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-archive-1', AE_E_CSS_DIR . 'archive-1.css');
        return ['wp-active-we-archive-1'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'آرشیو 1';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-archive-posts';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        AE_E_UTILS::SELECT_FIELD($this, 'card-style', 'نوع کارت', [
            'style-1' => 'نوع 1',
            'style-2' => 'نوع 2',
            'style-3' => 'نوع 3',
        ], 'style-1');

        AE_E_UTILS::grid_columns($this, 'archive-column', '.wp-active-we-archive');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'columns-gap', 'فاصله بین افقی', 0, 50, null,
            '.wp-active-we-archive', 'column-gap');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'row-gap', 'فاصله بین عمودی', 0, 50, null,
            '.wp-active-we-archive', 'row-gap');

        $this->end_controls_section();


        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {

        AE_E_UTILS::SECTION_START($this, 'cards-style', 'استایل کارت', 'style');

        AE_E_UTILS::FONT_FIELD($this, 'card-title-typography', 'تایپوگرافی عنوان', '.post-item-title h2');
        AE_E_UTILS::COLOR_FIELD($this, 'card-title-color', 'رنگ عنوان', '', '.post-item-title h2', 'color');
        AE_E_UTILS::FONT_FIELD($this, 'card-s1-view-date', 'تایپوگرافی بازدید و تاریخ', '.archive-card-simple .post-item-info', 'card-style', 'style-1');

        AE_E_UTILS::TAB_START($this, 'post-item');
        AE_E_UTILS::DynamicStyleControls($this, 'item-normal', '.archive-card', [
            'padding', 'bg', 'border', 'radius', 'shadow'
        ]);

        AE_E_UTILS::DIMENSIONS_FIELD($this, 's1-image-border-radius', 'خمیدگی تصویر', '.archive-card-simple .post-item-media img', 'border-radius');

        AE_E_UTILS::TAB_MIDDLE($this, 'post-item');
        AE_E_UTILS::DynamicStyleControls($this, 'item-hover', '.archive-card:hover', [
            'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);

        AE_E_UTILS::SECTION_END($this);


        // image card 3
        AE_E_UTILS::SECTION_START($this, 'cs3-image-styles', 'تصویر', 'style', 'card-style', 'style-3');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'cs3-image-height', 'ارتفاع', 150, 300, null,
            '.archive-card-3 .post-item-media .thumbnail-holder', 'height');
        AE_E_UTILS::DynamicStyleControls($this, 'cs3-image-styles', '.archive-card-3 .post-item-media .thumbnail-holder', [
            'padding', 'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::SECTION_END($this);


        // category card 3
        AE_E_UTILS::SECTION_START($this, 'cs3-category-style', 'دسته بندی', 'style', 'card-style', 'style-3');
        AE_E_UTILS::TextUtils($this, 'cs3-category', '.archive-card-3 .post-item-media .post-category', true);
        AE_E_UTILS::DynamicStyleControls($this, 'cs3-category', '.archive-card-3 .post-item-media .post-category', [
            'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::SECTION_END($this);


        // excerpt card 3
        AE_E_UTILS::SECTION_START($this, 'cs3-excerpt-styles', 'خلاصه', 'style', 'card-style', 'style-3');
        AE_E_UTILS::TextUtils($this, 'cs3-excerpt', '.archive-card-3 .post-item-details .excerpt');
        AE_E_UTILS::SECTION_END($this);


        // date card 3
        AE_E_UTILS::SECTION_START($this, 'cs3-date-styles', 'تاریخ', 'style', 'card-style', 'style-3');
        AE_E_UTILS::Separator($this, 'cs3-date-day', 'روز');
        AE_E_UTILS::TextUtils($this, 'dcs3-ate-day', '.archive-card-3 .post-item-details .date strong');
        AE_E_UTILS::DynamicStyleControls($this, 'cs3-date-day', '.archive-card-3 .post-item-details .date strong', [
            'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::Separator($this, 'cs3-date-month', 'ماه');
        AE_E_UTILS::TextUtils($this, 'cs3-date-month', '.archive-card-3 .post-item-details .date');
        AE_E_UTILS::SECTION_END($this);


        // no post
        AE_E_UTILS::SECTION_START($this, 'no-post-styles', 'پستی وجود ندارد', 'style');
        AE_E_UTILS::TextUtils($this, 'no-post-text', '.no-post-found p');
        AE_E_UTILS::DynamicStyleControls($this, 'no-post-styles', '.no-post-found', [
            'padding', 'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::SECTION_END($this);


        // pagination
        AE_E_UTILS::SECTION_START($this, 'pagination-styles', 'صفحه بندی', 'style');
        AE_E_UTILS::HEADING_FIELD($this, 'pg-h1', 'باکس');
        AE_E_UTILS::DynamicStyleControls($this, 'pagination-box-styles', '.wp-pagenavi', [
            'margin', 'padding', 'bg', 'border', 'radius', 'shadow'
        ]);

        AE_E_UTILS::HEADING_FIELD($this, 'pg-h2', 'دکمه ها');

        AE_E_UTILS::FONT_FIELD($this, 'pagination-typography', 'تایپوگرافی', '.wp-pagenavi a, {{WRAPPER}} .wp-pagenavi span');


        AE_E_UTILS::TAB_START($this, 'pagination-styles');

        AE_E_UTILS::DynamicStyleControls($this, 'pagination-btns-styles-normal', '.wp-pagenavi a', [
            'padding', 'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_MIDDLE_($this, 'pagination-styles-hover', 'هاور');
        AE_E_UTILS::DynamicStyleControls($this, 'pagination-btns-styles-hover', '.wp-pagenavi a:hover', [
            'padding', 'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_MIDDLE_($this, 'pagination-styles-active', 'فعال');
        AE_E_UTILS::DynamicStyleControls($this, 'pagination-btns-styles-active', '.wp-pagenavi .current', [
            'padding', 'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);

        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $card_style = $settings['card-style'];

        global $wp_query;
        $Query = new \WP_Query($wp_query->query_vars);


        if ($Query->have_posts()) {
            ?>
            <div class="wp-active-we-archive d-grid">
                <?php
                while ($Query->have_posts()) {
                    $Query->the_post();

                    switch ($card_style) {
                        case 'style-1':
                            require AE_E_PATH . 'cards/card-simple.php';
                            break;
                        case 'style-2':
                            require AE_E_PATH . 'cards/card-2.php';
                            break;
                        case 'style-3':
                            require AE_E_PATH . 'cards/card-3.php';
                            break;
                    }
                }
                ?>
            </div>
            <?php
            $pn_args = ['echo' => false];
            if (function_exists('ae_pagination') && !empty(ae_pagination($pn_args))) {
                ae_pagination();
            }
        } // END of 'if' have_posts
        else {
            require AE_E_PATH . 'cards/no-post.php';
        }

    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_ARCHIVE_1());
