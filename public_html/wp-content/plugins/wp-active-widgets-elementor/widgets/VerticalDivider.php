<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_VerticalDivider extends Widget_Base{

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'جداکننده عمودی';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-divider';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);
        AE_E_UTILS::SELECT_FIELD_STYLE($this, 'border-style', 'استایل', [
            'solid'  => 'خط',
            'dotted' => 'نقطه چین',
            'dashed' => 'خط چین'
        ], 'solid', '.wp-active-we-vertical-divider', 'border-left-style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'border-width', 'عرض', 1, 5, 1,'.wp-active-we-vertical-divider', 'border-left-width');
        AE_E_UTILS::SLIDER_FIELD_STYLE($this, 'border-height', 'ارتفاع', 5, 200, 100,'.wp-active-we-vertical-divider', 'height');
        AE_E_UTILS::COLOR_FIELD($this, 'border-color', 'رنگ', '#222', '.wp-active-we-vertical-divider', 'border-left-color');
        $this->end_controls_section();
    }

    protected function render()
    {
        echo '<div class="vertical-divider-wrapper dfx aic jcc"><span class="wp-active-we-vertical-divider"></span></div>';
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_VerticalDivider());
