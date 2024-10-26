<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_IconBox extends Widget_Base{

    public function get_script_depends()
    {
        return ['wp-active-we-intro-animation'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'باکس آیکون';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-icon-box';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        AE_E_UTILS::ICON($this, 'icon-box-');
        AE_E_UTILS::TXT_FIELD($this, 'title', 'عنوان', 'این عنوان است', true);
        AE_E_UTILS::HTML_TAG($this, 'title-tag', 'عنوان', 'h3', 'title!', '');
        AE_E_UTILS::TXT_FIELD($this, 'subtitle', 'زیرعنوان', 'این زیرعنوان است', true);
        AE_E_UTILS::HTML_TAG($this, 'subtitle-tag', 'زیرعنوان', 'span', 'subtitle!', '');

        AE_E_UTILS::SWITCH_FIELD($this, 'icon-boxed-with-title', 'عنوان و آیکون در یک راستا باشد؟');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'icon-boxed-with-title-gap', 'فاصله بین آیکون و عناوین', 0, 50, 0, '.icon-box-container', 'gap', 'icon-boxed-with-title', 'yes');

        AE_E_UTILS::TEXTAREA($this, 'text', 'متن');

        AE_E_UTILS::TXT_FIELD($this, 'btn-title', 'عنوان لینک', '', true);
        AE_E_UTILS::URL_FIELD($this, 'btn-link', 'لینک', true, 'btn-title!', '');

        AE_E_UTILS::IMAGE($this, 'bg-img', 'بکگراند');
        AE_E_UTILS::IMAGE_SIZE($this, 'bg-img', 'medium_large');
        AE_E_UTILS::COLOR_FIELD($this, 'bg-overlay-color', 'رنگ روکش بکگراند', '', '.wp-active-we-icon-box:before', 'background');

        $this->add_responsive_control('items-alignment', [
            'label'       => 'چیدمان',
            'type'        => Controls_Manager::SELECT,
            'label_block' => false,
            'options'     => [
                'flex-start' => 'آغاز',
                'center'     => 'وسط',
                'flex-end'   => 'پایان',
            ],
            'default'     => 'flex-start',
            'selectors'   => [
                '{{WRAPPER}} .wp-active-we-icon-box' => 'align-items: {{VALUE}}'
            ]
        ]);

        AE_E_UTILS::SWITCH_FIELD($this, 'intro-animation', 'انیمیشن ورود');

        $this->end_controls_section();


        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {

        // box
        AE_E_UTILS::SECTION_START($this, 'style-box', 'باکس', 'style');
        AE_E_UTILS::TAB_START($this, 'box-item');
        AE_E_UTILS::DynamicStyleControls($this, 'box-normal', '.wp-active-we-icon-box', [
            'padding',
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::TAB_MIDDLE($this, 'box-item');
        AE_E_UTILS::DynamicStyleControls($this, 'box-hover', '.wp-active-we-icon-box:hover', [
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);
        AE_E_UTILS::SECTION_END($this);


        // icon
        AE_E_UTILS::SECTION_START($this, 'style-icon', 'آیکون', 'style');
        AE_E_UTILS::IconUtils($this, 'style-icon', '.icon', '.elementor-widget-container');
        AE_E_UTILS::SECTION_END($this);


        // title
        AE_E_UTILS::SECTION_START($this, 'title-style', 'عنوان', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'title-mt', 'فاصله', 0, 100, null, '.title', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'title', '.title');
        AE_E_UTILS::FONT_STROKE_FIELD($this, 'title-stroke', '.title');
        AE_E_UTILS::COLOR_FIELD($this, 'title_color_hover', 'رنگ هاور', '', '.elementor-widget-container:hover .title', 'color');
        AE_E_UTILS::SECTION_END($this);


        // subtitle
        AE_E_UTILS::SECTION_START($this, 'subtitle-style', 'زیرعنوان', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'subtitle-mt', 'فاصله', 0, 100, null, '.subtitle', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'subtitle', '.subtitle');
        AE_E_UTILS::FONT_STROKE_FIELD($this, 'subtitle-stroke', '.subtitle');
        AE_E_UTILS::COLOR_FIELD($this, 'subtitle_color_hover', 'رنگ هاور', '', '.elementor-widget-container:hover .subtitle', 'color');
        AE_E_UTILS::SECTION_END($this);


        // text
        AE_E_UTILS::SECTION_START($this, 'text-style', 'متن', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'text-mt', 'فاصله', 0, 100, null, '.text', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'text', '.text');
        AE_E_UTILS::COLOR_FIELD($this, 'text_color_hover', 'رنگ هاور', '', '.elementor-widget-container:hover .text', 'color');
        AE_E_UTILS::TEXT_ALIGNMENT($this, 'text_alignment', '.text');
        AE_E_UTILS::SECTION_END($this);


        // button
        AE_E_UTILS::SECTION_START($this, 'button-style', 'دکمه', 'style');

        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'btn-mt', 'فاصله', 0, 50, null, '.wp-active-we-icon-box a', 'margin-top');

        AE_E_UTILS::FONT_FIELD($this, 'btn-typography', 'تایپوگرافی', '.wp-active-we-icon-box a');

        AE_E_UTILS::TAB_START($this, 'btn-utils-normal');
        AE_E_UTILS::DynamicStyleControls($this, 'box-utils-normal', '.wp-active-we-icon-box a', [
            'padding',
            'color',
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::TAB_MIDDLE($this, 'btn-utils-hover');
        AE_E_UTILS::DynamicStyleControls($this, 'box-utils-hover', '.wp-active-we-icon-box a:hover', [
            'padding',
            'color',
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $iwt = $settings['icon-boxed-with-title'];

        $btn_title = $settings['btn-title'];

        $this->add_render_attribute('icon-box-container', 'class', ['wp-active-we-icon-box', 'dfx', 'dir-v']);
        if ($settings['intro-animation'] === 'yes') {
            $this->add_render_attribute('icon-box-container', 'class', 'active-animation');
            $this->add_render_attribute('icon-box-container', 'data-animation-target', '.elementor-element-' . $this->get_id() . ' .wp-active-we-icon-box');
            $this->add_render_attribute('icon-box-container', 'data-animation-offset', '100');
        }

        if (!empty($settings['bg-img'])) {
            $img_url = wp_get_attachment_image_url($settings['bg-img']['id'], $settings['bg-img_size']);
            if (!empty($img_url)) {
                $this->add_render_attribute('icon-box-container', 'style', 'background-image: url("' . $img_url . '")');
            }
        }

        ?>
        <div class="wp-active-we-icon-box-wrapper">
            <div <?php $this->print_render_attribute_string('icon-box-container'); ?>>

                <?php

                if (!empty($iwt)) {
                    echo '<div class="icon-box-container dfx jcc aic">';
                }
                AE_E_UTILS::ICON_PRINT($this, $settings, 'icon-box-');
                if (!empty($iwt)) {
                    echo '<div class="icon-box-title-container">';
                }
                AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'title', 'title-tag', 'title trans03');
                AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'subtitle', 'subtitle-tag', 'subtitle trans03 dfx');
                if (!empty($iwt)) {
                    echo '</div>';
                    echo '</div>';
                }

                AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'text', 'p', 'text trans03');

                if (!empty($btn_title)) {
                    $this->add_link_attributes('link-attrs', $settings['btn-link']);
                    echo '<a ' . $this->get_render_attribute_string('link-attrs') . ' class="trans03">' . esc_html($btn_title) . '</a>';
                }
                ?>
            </div>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_IconBox());
