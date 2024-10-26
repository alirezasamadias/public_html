<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_TitleWithButton1 extends Widget_Base
{

    public function get_style_depends()
    {
        wp_register_style('AE_E_TitleWithButton1', AE_E_CSS_DIR . 'title-with-button-1.css');
        return ['AE_E_TitleWithButton1'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'عنوان دکمه دار 1';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-t-letter';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        AE_E_UTILS::TXT_FIELD($this, 'title', 'عنوان', 'عنوان دکمه دار 1', true);
        AE_E_UTILS::HTML_TAG($this, 'title-html-tag', 'عنوان', 'h2');

        AE_E_UTILS::TXT_FIELD($this, 'btn-title', 'عنوان دکمه', 'بیشتر', true);
        AE_E_UTILS::URL_FIELD($this, 'btn-url', 'لینک دکمه', true);

        $this->end_controls_section();


        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {

        // dots styles
        AE_E_UTILS::SECTION_START($this, 'dots-sec', 'نقاط', 'style');
        $this->add_control(
            'dots-color',
            [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'description' => 'از رنگ های ذخیره شده استفاده نکنید!',
                'selectors'   => [
                    '{{WRAPPER}} .twb1-bg' => 'background-image: radial-gradient({{VALUE}} 0px, transparent 2px);',
                ]
            ]
        );
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'dots-height', 'ارتفاع', 10, 300, null, '.twb1-bg', 'height');
        $this->add_control(
            'dots-space',
            [
                'label'       => 'فاصله',
                'type'        => Controls_Manager::SLIDER,
                'label_block' => true,
                'size_units'  => ['px'],
                'range'       => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'   => [
                    'body:not(.rtl) {{WRAPPER}} .wp-active-we-title-with-button-1' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '.rtl {{WRAPPER}} .wp-active-we-title-with-button-1'           => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        AE_E_UTILS::SECTION_END($this);


        // button
        AE_E_UTILS::SECTION_START($this, 'button-sec', 'دکمه', 'style');

        AE_E_UTILS::FONT_FIELD($this, 'btn-typography', 'تایپوگرافی', 'a');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'btn-padding', 'padding', 'a', 'padding');

        AE_E_UTILS::TAB_START($this, 'btn-tab-normal');

        AE_E_UTILS::COLOR_FIELD($this, 'btn-color-normal', 'رنگ', '', 'a', 'color');
        AE_E_UTILS::BACKGROUND_WO_IMG_FIELD($this, 'btn-bg-normal', 'a');
        AE_E_UTILS::BORDER_FIELD($this, 'btn-border-normal', 'حاشیه', 'a');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'btn-border-radius-normal', 'خمیدگی', 'a', 'border-radius');

        AE_E_UTILS::TAB_MIDDLE($this, 'btn-tab-hover');

        AE_E_UTILS::COLOR_FIELD($this, 'btn-color-hover', 'رنگ', '', 'a:hover', 'color');
        AE_E_UTILS::BACKGROUND_WO_IMG_FIELD($this, 'btn-bg-hover', 'a:hover');
        AE_E_UTILS::BORDER_FIELD($this, 'btn-border-hover', 'حاشیه', 'a:hover');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'btn-border-radius-hover', 'خمیدگی', 'a:hover', 'border-radius');

        AE_E_UTILS::TAB_END($this);
        AE_E_UTILS::SECTION_END($this);


        // title
        AE_E_UTILS::SECTION_START($this, 'title-sec', 'عنوان', 'style');

        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'title-distance', 'فاصله', 0, 100, null, '.twb1-title', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'title-typography', '.twb1-title');

        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $title     = $settings['title'];
        $tg        = $settings['title-html-tag'];
        $btn_title = $settings['btn-title'];

        $this->add_link_attributes('btn-link', $settings['btn-url']);

        ?>
        <div class="wp-active-we-title-with-button-1">
            <span class="twb1-bg"></span>
            <div class="twb1-texts">
                <a <?php $this->print_render_attribute_string('btn-link'); ?>><?php echo esc_html($btn_title); ?></a>
                <?php echo "<$tg class='twb1-title'>" . esc_html($title) . "</$tg>"; ?>
            </div>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_TitleWithButton1());
