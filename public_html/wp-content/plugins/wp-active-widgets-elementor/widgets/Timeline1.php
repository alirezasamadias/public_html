<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_Timeline extends Widget_Base
{

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-timeline', AE_E_CSS_DIR . 'timeline.css');
        return ['wp-active-we-timeline'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'تایم لاین 1';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-table-of-contents';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        $time_line = new \Elementor\Repeater();
        AE_E_UTILS::TXT_FIELD($time_line, 'title', 'عنوان', '', true);
        AE_E_UTILS::TXT_FIELD($time_line, 'subtitle', 'زیرعنوان', '', true);
        AE_E_UTILS::TXT_FIELD($time_line, 'flag', 'پرچم', '', true);
        AE_E_UTILS::TEXTAREA($time_line, 'text', 'متن', '', true);
        $this->add_control(
            'time-line',
            [
                'label'       => 'موارد',
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $time_line->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();


        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {
        // item
        AE_E_UTILS::SECTION_START($this, 'item-style', 'آیتم', 'style');
        $this->add_responsive_control(
            'items-distance',
            [
                'label'       => 'فاصله بین',
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
                    '{{WRAPPER}} .wp-active-we-timeline ul li'            => 'padding-bottom: {{SIZE}}px;',
                    '{{WRAPPER}} .wp-active-we-timeline ul li:last-child' => 'padding-bottom: 0;',
                ],
            ]
        );
        AE_E_UTILS::DynamicStyleControls($this, 'item', '.wp-active-we-timeline ul li .texts', [
            'margin', 'padding', 'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::SECTION_END($this);

        // title
        AE_E_UTILS::SECTION_START($this, 'title-style', 'عنوان', 'style');
        AE_E_UTILS::TextUtils($this, 'title', '.title');
        AE_E_UTILS::SECTION_END($this);

        // subtitle
        AE_E_UTILS::SECTION_START($this, 'subtitle-style', 'زیرعنوان', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'subtitle-mt', 'فاصله', 0, 100, null, '.subtitle', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'subtitle', '.subtitle');
        AE_E_UTILS::SECTION_END($this);

        // flag
        AE_E_UTILS::SECTION_START($this, 'flag-style', 'پرچم', 'style');
        $this->add_responsive_control(
            'flag-width',
            [
                'label'       => 'عرض',
                'type'        => Controls_Manager::SLIDER,
                'label_block' => true,
                'size_units'  => ['px'],
                'range'       => [
                    'px' => [
                        'min' => 60,
                        'max' => 100,
                    ],
                ],
                'default'     => [
                    'unit' => 'px',
                    'size' => 60,
                ],
                'selectors'   => [
                    '{{WRAPPER}} .wp-active-we-timeline ul li .flag'                => 'width: {{SIZE}}px;',
                    '.rtl {{WRAPPER}} .wp-active-we-timeline ul li .flag'           => 'right: calc(-{{SIZE}}px - 15px); left: auto;',
                    'body:not(.rtl) {{WRAPPER}} .wp-active-we-timeline ul li .flag' => 'left: calc(-{{SIZE}}px - 15px); right: auto;',
                    '.rtl {{WRAPPER}} .wp-active-we-timeline'                       => 'margin-right: calc({{SIZE}}px + 15px);margin-left: auto;',
                    'body:not(.rtl) {{WRAPPER}} .wp-active-we-timeline'             => 'margin-left: calc({{SIZE}}px + 15px);margin-right: auto;',
                ],
            ]
        );
        AE_E_UTILS::TextUtils($this, 'flag', '.flag');
        AE_E_UTILS::COLOR_FIELD($this, 'flag-bg', 'بکگراند', '', '.wp-active-we-timeline ul li .flag, {{WRAPPER}} .wp-active-we-timeline ul li .flag:before', 'background');
        AE_E_UTILS::SECTION_END($this);

        // text
        AE_E_UTILS::SECTION_START($this, 'text-style', 'متن', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'text-mt', 'فاصله', 0, 100, null, '.text', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'text', '.text');
        AE_E_UTILS::SECTION_END($this);

        // others
        AE_E_UTILS::SECTION_START($this, 'others-style', 'دیگر', 'style');
        AE_E_UTILS::COLOR_FIELD($this, 'line-bg', 'بکگراند خط کنار', '', '.wp-active-we-timeline ul li:before', 'background');
        AE_E_UTILS::COLOR_FIELD($this, 'dot-bg', 'بکگراند نقطه', '', '.wp-active-we-timeline ul li:after', 'background');
        AE_E_UTILS::SECTION_END($this);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $time_line = $settings['time-line'];

        if (empty($time_line)) {
            return;
        }

        ?>
        <div class="wp-active-we-timeline">

            <ul class="timeline-tree">
                <?php foreach ($time_line as $item) { ?>
                    <li>
                        <?php AE_E_UTILS::TxtHtmlGenerator($this, $item, 'flag', 'b', 'flag dfx aic jcc'); ?>
                        <div class="texts dfx dir-v">
                            <?php AE_E_UTILS::TxtHtmlGenerator($this, $item, 'title', 'strong', 'title'); ?>
                            <?php AE_E_UTILS::TxtHtmlGenerator($this, $item, 'subtitle', 'span', 'subtitle'); ?>
                            <?php AE_E_UTILS::TxtHtmlGenerator($this, $item, 'text', 'p', 'text'); ?>
                        </div>
                    </li>
                <?php } ?>
            </ul>

        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_Timeline());
