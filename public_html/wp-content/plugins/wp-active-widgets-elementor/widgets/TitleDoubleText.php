<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_TitleDoubleText extends Widget_Base
{

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'عنوان 2 تایی';
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

        AE_E_UTILS::TXT_FIELD($this, 'text-1', 'متن 1', 'عنوان 1', true);
        AE_E_UTILS::HTML_TAG($this, 'text-1-html', 'متن 1');
        AE_E_UTILS::TXT_FIELD($this, 'text-2', 'متن 2', 'عنوان 2', true);
        AE_E_UTILS::HTML_TAG($this, 'text-2-html', 'متن 2');

        $this->end_controls_section();


        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {

        AE_E_UTILS::SECTION_START($this, 'texts-styles', 'استایل', 'style');
        $directions = [
            ''       => 'افقی',
            'column' => 'عمودی'
        ];
        AE_E_UTILS::SELECT_FIELD_STYLE($this, 'texts-direction', 'چینش', $directions, '', '.wp-active-we-title-double-title', 'flex-direction');
        AE_E_UTILS::H_ALIGNMENT_MIN($this, 'alignment-horizontal', '.wp-active-we-title-double-title','','texts-direction', '');
        AE_E_UTILS::V_ALIGNMENT($this, 'alignment-column', '.wp-active-we-title-double-title', 'texts-direction', 'column');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'texts-gap', 'فاصله بین متن ها', 0, 100, null, '.wp-active-we-title-double-title', 'gap');
        AE_E_UTILS::SECTION_END($this);


        AE_E_UTILS::SECTION_START($this, 'text-1-styles', 'متن 1', 'style');
        AE_E_UTILS::TextUtils($this, 'text-1', '.text-1');
        AE_E_UTILS::BoxUtils($this,'text-1-utils','.text-1');
        AE_E_UTILS::SECTION_END($this);


        AE_E_UTILS::SECTION_START($this, 'text-2-styles', 'متن 2', 'style');
        AE_E_UTILS::TextUtils($this, 'text-2', '.text-2');
        AE_E_UTILS::BoxUtils($this,'text-2-utils','.text-2');
        AE_E_UTILS::SECTION_END($this);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="wp-active-we-title-double-title dfx aic">
            <?php AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'text-1', 'text-1-html', 'text-1'); ?>
            <?php AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'text-2', 'text-2-html', 'text-2'); ?>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_TitleDoubleText());
