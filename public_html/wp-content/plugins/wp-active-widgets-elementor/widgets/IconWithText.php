<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_IconWithText extends Widget_Base{

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'آیکون با متن';
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
        AE_E_UTILS::ICON($this, 'icon_w_text');
        AE_E_UTILS::TXT_FIELD($this, 'text', 'متن', 'لورم ایپسوم', true);
        AE_E_UTILS::HTML_TAG($this, 'text_tag', 'متن');
        AE_E_UTILS::URL_FIELD($this, 'link', 'لینک', true);
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'elements_distance','فاصله بین',0,100,null,'.wp-active-we-icon-with-text','gap');
        $this->end_controls_section();


        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {

        AE_E_UTILS::SECTION_START($this, 'box', 'باکس', 'style');
        AE_E_UTILS::BoxUtils($this, 'box', '.wp-active-we-icon-with-text');
        AE_E_UTILS::SECTION_END($this);


        AE_E_UTILS::SECTION_START($this, 'icon_box', 'آیکون', 'style');
        AE_E_UTILS::IconUtils($this, 'icon_styles', '.icon', '.wp-active-we-icon-with-text');
        AE_E_UTILS::SECTION_END($this);


        AE_E_UTILS::SECTION_START($this, 'text_styles', 'متن', 'style');
        AE_E_UTILS::FONT_FIELD($this, 'text_typography', 'تاریپوگرافی', '.wp-active-we-icon-with-text .text');
        AE_E_UTILS::COLOR_FIELD($this, 'text_color_normal', 'رنگ عادی', '', '.wp-active-we-icon-with-text .text', 'color');
        AE_E_UTILS::COLOR_FIELD($this, 'text_color_hover', 'رنگ هاور', '', '.wp-active-we-icon-with-text:hover .text', 'color');
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $this->add_link_attributes('icon_w_text', $settings['link']);
        $this->add_render_attribute('icon_w_text', 'class', 'wp-active-we-icon-with-text dfx dir-v aic jcc');
        ?>
        <a <?php $this->print_render_attribute_string('icon_w_text'); ?>>
            <?php
            AE_E_UTILS::ICON_PRINT($this, $settings, 'icon_w_text');
            AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'text', 'text_tag', 'text');
            ?>
        </a>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_IconWithText());
