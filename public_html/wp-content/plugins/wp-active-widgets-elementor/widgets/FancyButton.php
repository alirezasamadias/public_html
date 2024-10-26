<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_FancyButton extends Widget_Base
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
        return 'دکمه فانتزی';
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

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);
        AE_E_UTILS::TXT_FIELD($this, 'btn-title', 'عنوان', 'دکمه فانتزی', true);
        AE_E_UTILS::URL_FIELD($this, 'btn-link', 'لینک', true);
        AE_E_UTILS::ICON($this, 'btn-');
        $icon_place = [
            'before' => 'قبل',
            'after'  => 'بعد'
        ];
        AE_E_UTILS::SELECT_FIELD($this, 'icon-place', 'مکان آیکون', $icon_place, 'before');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'btw-gap', 'فاصله بین', 0, 50, null, '.fancy-button-widget', 'gap');
        AE_E_UTILS::H_ALIGNMENT_MIN($this, 'btn-alignment','.fancy-button-widget-wrapper', 'flex-start');
        $this->add_control(
            'btn-custom-class',
            [
                'label'       => 'class دلخواه',
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'description'   =>  'کلاس ها را بدون نقطه و با فاصله از هم جدا کنید'
            ]
        );
        $this->end_controls_section();


        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {

        AE_E_UTILS::SECTION_START($this, 'btn-style', 'استایل', 'style');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'btn-padding', 'Padding', '.fancy-button-widget', 'padding');
        AE_E_UTILS::FONT_FIELD($this, 'btn-text_font', 'تایپوگرافی', '.fancy-button-widget span span');

        AE_E_UTILS::TAB_START($this, 'btn-styles');
        AE_E_UTILS::COLOR_FIELD($this, 'btn-text_color', 'رنگ', '', '.fancy-button-widget span span', 'color');
        AE_E_UTILS::BACKGROUND_WO_IMG_FIELD($this, 'btn-bg', '.fancy-button-widget');
        AE_E_UTILS::BORDER_FIELD($this,'btn-border', 'نوع کادر دور', '.fancy-button-widget');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'btn-border-radius', 'خمیدگی', '.fancy-button-widget', 'border-radius');
        AE_E_UTILS::SHADOW_FIELD($this, 'btn-shadow', 'سایه', '.fancy-button-widget');
        AE_E_UTILS::TAB_MIDDLE($this, 'btn-styles');
        AE_E_UTILS::COLOR_FIELD($this, 'btn-text_color_hover', 'رنگ', '', '.fancy-button-widget:hover span span', 'color');
        AE_E_UTILS::BACKGROUND_WO_IMG_FIELD($this, 'btn-bg-hover', '.fancy-button-widget:hover');
        AE_E_UTILS::BORDER_FIELD($this,'btn-border-hover', 'نوع کادر دور', '.fancy-button-widget:hover');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'btn-border-radius-hover', 'خمیدگی', '.fancy-button-widget:hover', 'border-radius');
        AE_E_UTILS::SHADOW_FIELD($this, 'btn-shadow-hover', 'سایه', '.fancy-button-widget:hover');
        AE_E_UTILS::TAB_END($this);

        AE_E_UTILS::SECTION_END($this);


        AE_E_UTILS::SECTION_START($this, 'btn-icon-style', 'آیکون', 'style');
        AE_E_UTILS::IconUtils($this, 'btn-icon', '.icon', '.fancy-button-widget');
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $title      = $settings['btn-title'];
        $icon_place = $settings['icon-place'];

        $this->add_link_attributes('fancy_btn', $settings['btn-link']);
        $this->add_render_attribute('fancy_btn', 'class', 'fancy-button-widget dfx aic jcc gap-10');

        if (!empty($settings['btn-custom-class'])) {
            $this->add_render_attribute('fancy_btn', 'class', $settings['btn-custom-class']);
        }

        ?>

        <div class="fancy-button-widget-wrapper dfx aic">
            <a <?php $this->print_render_attribute_string('fancy_btn') ?>>
                <?php
                if ($icon_place === 'before') {
                    AE_E_UTILS::ICON_PRINT($this, $settings, 'btn-');
                }
                ?>
                <span class="texts">
                    <span class="t1"><?php echo $title; ?></span>
                    <span class="t2"><?php echo $title; ?></span>
                </span>
                <?php
                if ($icon_place === 'after') {
                    AE_E_UTILS::ICON_PRINT($this, $settings, 'btn-');
                }
                ?>
            </a>
        </div>
        <?php

    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_FancyButton());
