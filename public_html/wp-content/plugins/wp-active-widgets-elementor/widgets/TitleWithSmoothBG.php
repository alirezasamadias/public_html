<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_TitleWithSmoothBG extends Widget_Base
{

    public string $svg_right_top = '<svg viewBox="0 0 313 208.1"><g><g><path d="M0,0V208.1H.1a119.86,119.86,0,0,0,85-35.2l134-134A132.84,132.84,0,0,1,313,0Z"/></g></g></svg>';
    public string $svg_left_top = '<svg x="0px" y="0px" viewBox="0 0 313 208.1" ><g><g><path d="M0,0c35.2,0,69,14,93.9,38.9l134,134c22.5,22.6,53.1,35.2,85,35.2h0.1V0L0,0z"/></g></g></svg>';

    public string $svg_right_bottom = '<svg viewBox="0 0 313 208.1"><g><g><path d="M313,208.1c-35.2,0-69-14-93.9-38.9l-134-134C62.6,12.6,32,0,0.1,0L0,0l0,208.1H313z"/></g></g></svg>';
    public string $svg_left_bottom = '<svg x="0px" y="0px" viewBox="0 0 313 208.1"><g><g><path d="M313,208.1V0h-0.1c-31.9,0-62.5,12.6-85,35.2l-134,134C69,194.1,35.2,208.1,0,208.1H313z"/></g></g></svg>';

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-title-with-smooth-bg', AE_E_CSS_DIR . 'title-with-smooth-bg.css');
        return ['wp-active-we-title-with-smooth-bg'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'عنوان با بکگراند نرم';
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

        AE_E_UTILS::SECTION_START($this, 'settings', 'تنظیمات');
        AE_E_UTILS::SELECT_FIELD($this, 'w-type', 'استایل', [
            'top'    => 'top',
            'bottom' => 'bottom'
        ], 'top');
        AE_E_UTILS::ICON($this, 'twsb');
        AE_E_UTILS::TXT_FIELD($this, 'title', 'عنوان', 'عنوان با بکگراند', true);
        AE_E_UTILS::TXT_FIELD($this, 'subtitle', 'زیرعنوان', 'زیرعنوان', true);
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'texts-distance', 'فاصله از پایین', 0, 100, null, '.wp-active-we-title-with-smooth-bg .texts', 'bottom');
        AE_E_UTILS::SECTION_END($this);


        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {

        // background
        AE_E_UTILS::SECTION_START($this, 'bg-styles', 'بکگراند', 'style');
        $items = '.wp-active-we-title-with-smooth-bg .shape .c-shape, {{WRAPPER}} .wp-active-we-title-with-smooth-bg .shape svg';
        $this->add_control(
            'bg-color',
            [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .wp-active-we-title-with-smooth-bg .shape .c-shape' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .wp-active-we-title-with-smooth-bg .shape svg'      => 'fill: {{VALUE}};',
                ]
            ]
        );
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'item-height', 'ارتفاع بکگراند', 40, 100, null, $items, 'height');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'item-width', 'عرض بکگراند', 0, 300, null, '.wp-active-we-title-with-smooth-bg .shape .c-shape', 'width');
        AE_E_UTILS::SECTION_END($this);


        // icon
        AE_E_UTILS::SECTION_START($this, 'icon-styles', 'آیکون', 'style');
        AE_E_UTILS::IconUtils($this, 'icon-style', '.icon', '.wp-active-we-title-with-smooth-bg .inner-box');
        AE_E_UTILS::SECTION_END($this);


        // title
        AE_E_UTILS::SECTION_START($this, 'title-styles', 'عنوان', 'style', 'title!', '');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'title-mt', 'فاصله', 0, 50, null, '.wp-active-we-title-with-smooth-bg .texts h3', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'text-title', '.wp-active-we-title-with-smooth-bg .texts h3');
        AE_E_UTILS::SECTION_END($this);


        // subtitle
        AE_E_UTILS::SECTION_START($this, 'subtitle-styles', 'زیرعنوان', 'style', 'subtitle!', '');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'subtitle-mt', 'فاصله', 0, 50, null, '.wp-active-we-title-with-smooth-bg .texts span', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'text-subtitle', '.wp-active-we-title-with-smooth-bg .texts span');
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $type     = $settings['w-type'];
        ?>
        <div class="wp-active-we-title-with-smooth-bg dfx jcc">

            <div class="inner-box dfx jcc">
                <div class="shape dfx aic jcc ae-gap-0">
                    <?php if (is_rtl()) { ?>
                        <span class="right-shape svg-box dfx"><?php echo $type === 'top' ? $this->svg_right_top : $this->svg_right_bottom; ?></span>
                        <span class="c-shape dfx"></span>
                        <span class="left-shape svg-box dfx"><?php echo $type === 'top' ? $this->svg_left_top : $this->svg_left_bottom; ?></span>
                    <?php } else { ?>
                        <span class="left-shape svg-box dfx"><?php echo $type === 'top' ? $this->svg_left_top : $this->svg_left_bottom; ?></span>
                        <span class="c-shape dfx"></span>
                        <span class="right-shape svg-box dfx"><?php echo $type === 'top' ? $this->svg_right_top : $this->svg_right_bottom; ?></span>
                    <?php } ?>
                </div>

                <div class="texts dfx dir-v aic jcc">
                    <?php AE_E_UTILS::ICON_PRINT($this, $settings, 'twsb'); ?>
                    <?php AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'title', 'h3', 'title'); ?>
                    <?php AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'subtitle', 'span', 'subtitle'); ?>
                </div>
            </div>
        </div>
        <?php
    }

}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_TitleWithSmoothBG());
