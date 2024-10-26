<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_FantasyLineSeparator extends Widget_Base
{


    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'خط فانتزی جداکننده';
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

        AE_E_UTILS::SECTION_START($this, 'regular', 'عمومی');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'lines-height', 'ارتفاع', 0, 10, 4, '.wp-active-we-fantasy-line-separator', 'height');
        $this->add_responsive_control(
            'lines-distance',
            [
                'label'       => 'فاصله بین',
                'type'        => Controls_Manager::SLIDER,
                'label_block' => true,
                'size_units'  => ['px'],
                'range'       => [
                    'px' => [
                        'min' => 0,
                        'max' => 250,
                    ],
                ],
                'selectors'   => [
                    'body.rtl {{WRAPPER}} .wp-active-we-fantasy-line-separator:after'      => 'right: {{SIZE}}px;',
                    'body:not(rtl) {{WRAPPER}} .wp-active-we-fantasy-line-separator:after' => 'left: {{SIZE}}px;',
                ],
            ]
        );
        AE_E_UTILS::SECTION_END($this);


        AE_E_UTILS::SECTION_START($this, 'line-1', 'خط اول');
        AE_E_UTILS::COLOR_FIELD($this, 'line-1-color', 'رنگ', '', '.wp-active-we-fantasy-line-separator:before', 'background');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'line-1-width', 'عرض', 0, 200, 50, '.wp-active-we-fantasy-line-separator:before', 'width');
        AE_E_UTILS::SECTION_END($this);


        AE_E_UTILS::SECTION_START($this, 'line-2', 'خط دوم');
        AE_E_UTILS::COLOR_FIELD($this, 'line-2-color', 'رنگ', '', '.wp-active-we-fantasy-line-separator:after', 'background');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'line-2-width', 'عرض', 0, 200, 10, '.wp-active-we-fantasy-line-separator:after', 'width');
        AE_E_UTILS::SECTION_END($this);
    }

    protected function render()
    { ?>
        <span class="wp-active-we-fantasy-line-separator"></span>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_FantasyLineSeparator());
