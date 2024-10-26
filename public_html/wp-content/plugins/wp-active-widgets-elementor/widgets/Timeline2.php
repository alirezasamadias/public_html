<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_Timeline2 extends Widget_Base
{

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-timeline-2', AE_E_CSS_DIR . 'timeline-2.css');
        return ['wp-active-we-timeline-2'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'تایم لاین 2';
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

        $timeline = new \Elementor\Repeater();
        AE_E_UTILS::IMAGE($timeline, 'image', 'تصویر', true);
        AE_E_UTILS::TXT_FIELD($timeline, 'title', 'عنوان', '', true);
        AE_E_UTILS::TXT_FIELD($timeline, 'subtitle', 'زیرعنوان', '', true);
        AE_E_UTILS::URL_FIELD($timeline, 'link', 'لینک', true, 'title!', '');
        AE_E_UTILS::TEXTAREA($timeline, 'text', 'متن', '', true);
        $this->add_control(
            'timelines',
            [
                'label'       => 'موارد',
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $timeline->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        AE_E_UTILS::TEXT_ALIGNMENT($this, 'tl2-text-alignment', '.wp-active-we-timeline-2 .timeline-2-item .tl2-content');

        $this->end_controls_section();


        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {

        // item
        AE_E_UTILS::SECTION_START($this, 'style-item', 'آیتم', 'style');
        AE_E_UTILS::COLOR_FIELD($this, 'item-bg', 'بکگراند', '', '.wp-active-we-timeline-2 .timeline-2-item .tl2-content, {{WRAPPER}} .wp-active-we-timeline-2 .timeline-2-item:before', 'background');
        AE_E_UTILS::DynamicStyleControls($this, 'item-style', '.wp-active-we-timeline-2 .timeline-2-item .tl2-content', [
            'padding', 'border-radius'
        ]);
        AE_E_UTILS::SECTION_END($this);


        // image
        AE_E_UTILS::SECTION_START($this, 'style-image', 'تصویر', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'image-height', 'ارتفاع', 100, 350, null, '.wp-active-we-timeline-2 .timeline-2-item .image-holder', 'height');
        AE_E_UTILS::DynamicStyleControls($this, 'image-style', '.wp-active-we-timeline-2 .timeline-2-item .image-holder', [
            'padding', 'bg', 'border', 'border-radius', 'shadow'
        ]);
        AE_E_UTILS::SECTION_END($this);


        // text
        AE_E_UTILS::SECTION_START($this, 'style-text', 'متن', 'style');
        AE_E_UTILS::Separator($this, 'title', 'عنوان');
        AE_E_UTILS::DynamicStyleControls($this, 'title-style', '.wp-active-we-timeline-2 .timeline-2-item .tl2-title', [
            'font', 'color', 'margin'
        ]);
        AE_E_UTILS::Separator($this, 'subtitle', 'زیرعنوان');
        AE_E_UTILS::DynamicStyleControls($this, 'subtitle-style', '.wp-active-we-timeline-2 .timeline-2-item .tl2-subtitle', [
            'font', 'color', 'margin'
        ]);
        AE_E_UTILS::Separator($this, 'text', 'متن');
        AE_E_UTILS::DynamicStyleControls($this, 'text-style', '.wp-active-we-timeline-2 .timeline-2-item .tl2-text', [
            'font', 'color', 'margin'
        ]);
        AE_E_UTILS::SECTION_END($this);


        // others
        AE_E_UTILS::SECTION_START($this, 'style-others', 'جزئیات', 'style');
        AE_E_UTILS::COLOR_FIELD($this, 'line-bg', 'رنگ خط', '', '.wp-active-we-timeline-2 .timeline-2-line', 'background');
        AE_E_UTILS::COLOR_FIELD($this, 'dot-bg', 'رنگ نقطه', '', '.wp-active-we-timeline-2 .timeline-2-item .tl2-dot', 'background');
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $timeline = $settings['timelines'];
        $i        = 0;

        ?>
        <div class="wp-active-we-timeline-2">

            <span class="timeline-2-line"></span>

            <?php foreach ($timeline as $item) { ?>

                <div class="timeline-2-item dfx">
                    <span class="tl2-dot"></span>
                    <div class="tl2-content">
                        <div class="image-holder">
                            <?php AE_E_UTILS::ImageGenerator($item, 'image', 'full', 'tl2-img'); ?>
                        </div>
                        <?php
                        if (!empty($item['link']['url'])) {
                            $this->add_link_attributes('item-link' . $i, $item['link']);
                            $this->add_render_attribute('item-link' . $i, 'title', $item['title']);
                            echo '<a ' . $this->get_render_attribute_string('item-link' . $i) . '>';
                        }

                        AE_E_UTILS::TxtHtmlGenerator($this, $item, 'title', 'h4', 'tl2-title');

                        if (!empty($item['link']['url'])) {
                            echo '</a>';
                        }

                        AE_E_UTILS::TxtHtmlGenerator($this, $item, 'subtitle', 'span', 'tl2-subtitle');

                        AE_E_UTILS::TxtHtmlGenerator($this, $item, 'text', 'p', 'tl2-text');
                        ?>
                    </div>
                </div>

                <?php $i++;
            } ?>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_Timeline2());
