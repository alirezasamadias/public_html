<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_DoubleFancyButton extends Widget_Base
{

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-fancy-button', AE_E_CSS_DIR . 'fancy-button.css',);
        return ['wp-active-we-fancy-button'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'دکمه فانتزی دوتایی';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-button';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {
        $icon_place = [
            'before' => 'قبل',
            'after'  => 'بعد'
        ];

        // button 1
        $this->start_controls_section('button-1', ['label' => 'دکمه 1']);
        AE_E_UTILS::ICON($this, 'btn-1');
        AE_E_UTILS::TXT_FIELD($this, 'btn-1-text', 'عنوان', 'دکمه 1', true);
        AE_E_UTILS::URL_FIELD($this, 'btn-1-link', 'لینک', true);
        AE_E_UTILS::SELECT_FIELD($this, 'btn-1-icon-place', 'مکان آیکون', $icon_place, 'before');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'btn-1-btw-gap', 'فاصله بین', 0, 50, null, '.btn-1', 'gap');
        $this->add_control(
            'btn-1-custom-class',
            [
                'label'       => 'class دلخواه',
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'description'   =>  'کلاس ها را بدون نقطه و با فاصله از هم جدا کنید'
            ]
        );

        $this->end_controls_section();


        // button 2
        $this->start_controls_section('button-2', ['label' => 'دکمه 2']);
        AE_E_UTILS::ICON($this, 'btn-2');
        AE_E_UTILS::TXT_FIELD($this, 'btn-2-text', 'عنوان', 'دکمه 2', true);
        AE_E_UTILS::URL_FIELD($this, 'btn-2-link', 'لینک', true);
        AE_E_UTILS::SELECT_FIELD($this, 'btn-2-icon-place', 'مکان آیکون', $icon_place, 'before');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'btn-2-btw-gap', 'فاصله بین', 0, 50, null, '.btn-2', 'gap');
        $this->add_control(
            'btn-2-custom-class',
            [
                'label'       => 'class دلخواه',
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'description'   =>  'کلاس ها را بدون نقطه و با فاصله از هم جدا کنید'
            ]
        );

        $this->end_controls_section();

        AE_E_UTILS::SECTION_START($this, 'settings', 'تنظیمات');
        AE_E_UTILS::CHOOSE_FIELD_STYLE($this, 'btns-direction', 'جهت', [
            'row'    => [
                'icon'  => 'eicon-arrow-left',
                'title' => 'افقی'
            ],
            'column' => [
                'icon'  => 'eicon-arrow-down',
                'title' => 'عمودی'
            ]
        ], 'row', '.fancy-button-widget-wrapper', 'flex-direction');
        AE_E_UTILS::H_ALIGNMENT_MIN($this, 'btn-alignment-h', '.fancy-button-widget-wrapper', 'flex-start', 'btns-direction', 'row');
        AE_E_UTILS::V_ALIGNMENT($this, 'btn-alignment-v', '.fancy-button-widget-wrapper', 'btns-direction', 'column');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'btns-btw-gap', 'فاصله بین', 0, 100, null, '.fancy-button-widget-wrapper', 'gap');

        AE_E_UTILS::SECTION_END($this);

        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {

        // button 1
        AE_E_UTILS::SECTION_START($this, 'btn-1-style', 'دکمه 1', 'style');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'btn-1-padding', 'Padding', '.btn-1', 'padding');
        AE_E_UTILS::FONT_FIELD($this, 'btn-1-text_font', 'تایپوگرافی', '.btn-1 span span');

        AE_E_UTILS::TAB_START($this, 'btn-1-styles');
        AE_E_UTILS::COLOR_FIELD($this, 'btn-1-normal-style_color', 'رنگ', '', '.btn-1 span span', 'color');
        AE_E_UTILS::DynamicStyleControls($this, 'btn-1-normal-style', '.btn-1', [
            'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_MIDDLE($this, 'btn-1-styles');
        AE_E_UTILS::COLOR_FIELD($this, 'btn-1-hover-style_color', 'رنگ', '', '.btn-1:hover span span', 'color');
        AE_E_UTILS::DynamicStyleControls($this, 'btn-1-hover-style', '.btn-1:hover', [
            'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);

        AE_E_UTILS::SECTION_END($this);

        AE_E_UTILS::SECTION_START($this, 'btn-1-icon-style', 'آیکون دکمه 1', 'style');
        AE_E_UTILS::IconUtils($this, 'btn-1-icon', '.icon', '.btn-1');
        AE_E_UTILS::SECTION_END($this);


        // button 2
        AE_E_UTILS::SECTION_START($this, 'btn-2-style', 'دکمه 2', 'style');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'btn-2-padding', 'Padding', '.btn-2', 'padding');
        AE_E_UTILS::FONT_FIELD($this, 'btn-2-text_font', 'تایپوگرافی', '.btn-2 span span');

        AE_E_UTILS::TAB_START($this, 'btn-2-styles');
        AE_E_UTILS::COLOR_FIELD($this, 'btn-2-normal-style_color', 'رنگ', '', '.btn-2 span span', 'color');
        AE_E_UTILS::DynamicStyleControls($this, 'btn-2-normal-style', '.btn-2', [
            'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_MIDDLE($this, 'btn-2-styles');
        AE_E_UTILS::COLOR_FIELD($this, 'btn-2-hover-style_color', 'رنگ', '', '.btn-2:hover span span', 'color');
        AE_E_UTILS::DynamicStyleControls($this, 'btn-2-hover-style', '.btn-2:hover', [
            'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);
        AE_E_UTILS::SECTION_END($this);

        AE_E_UTILS::SECTION_START($this, 'btn-2-icon-style', 'آیکون دکمه 2', 'style');
        AE_E_UTILS::IconUtils($this, 'btn-2-icon', '.icon', '.btn-2');
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $title1      = $settings['btn-1-text'];
        $title2      = $settings['btn-2-text'];
        $icon_place1 = $settings['btn-1-icon-place'];
        $icon_place2 = $settings['btn-2-icon-place'];

        $this->add_link_attributes('fancy_btn_1', $settings['btn-1-link']);
        $this->add_render_attribute('fancy_btn_1', 'class', 'fancy-button-widget btn-1 dfx aic jcc gap-10');
        if (!empty($settings['btn-1-custom-class'])) {
            $this->add_render_attribute('fancy_btn_1', 'class', $settings['btn-1-custom-class']);
        }
        $this->add_link_attributes('fancy_btn_2', $settings['btn-2-link']);
        $this->add_render_attribute('fancy_btn_2', 'class', 'fancy-button-widget btn-2 dfx aic jcc gap-10');
        if (!empty($settings['btn-2-custom-class'])) {
            $this->add_render_attribute('fancy_btn_2', 'class', $settings['btn-2-custom-class']);
        }

        ?>
        <div class="wp-active-we-double-fancy-button fancy-button-widget-wrapper dfx aic ae-gap-20">
            <a <?php $this->print_render_attribute_string('fancy_btn_1') ?>>
                <?php
                if ($icon_place1 === 'before') {
                    AE_E_UTILS::ICON_PRINT($this, $settings, 'btn-1');
                }
                ?>
                <span class="texts">
                    <span class="t1"><?php echo $title1; ?></span>
                    <span class="t2"><?php echo $title1; ?></span>
                </span>
                <?php
                if ($icon_place1 === 'after') {
                    AE_E_UTILS::ICON_PRINT($this, $settings, 'btn-1');
                }
                ?>
            </a>
            <a <?php $this->print_render_attribute_string('fancy_btn_2') ?>>
                <?php
                if ($icon_place2 === 'before') {
                    AE_E_UTILS::ICON_PRINT($this, $settings, 'btn-2');
                }
                ?>
                <span class="texts">
                    <span class="t1"><?php echo $title2; ?></span>
                    <span class="t2"><?php echo $title2; ?></span>
                </span>
                <?php
                if ($icon_place2 === 'after') {
                    AE_E_UTILS::ICON_PRINT($this, $settings, 'btn-2');
                }
                ?>
            </a>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_DoubleFancyButton());
