<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_LinearIconBox extends Widget_Base
{

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'جعبه آیکون خطی';
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
        AE_E_UTILS::TXT_FIELD($this, 'lib-text', 'متن', 'متن', true);
        AE_E_UTILS::TXT_FIELD($this, 'lib-subtitle', 'زیرعنوان', '', true);

        AE_E_UTILS::ICON($this, 'lib-');
        $icon_place = [
            'before' => 'قبل',
            'after'  => 'بعد'
        ];
        AE_E_UTILS::SELECT_FIELD($this, 'icon-place', 'مکان آیکون', $icon_place, 'before');
        AE_E_UTILS::URL_FIELD($this, 'lib-link', 'لینک', true);
        AE_E_UTILS::H_ALIGNMENT_MIN($this, 'icon-box-alignment','.wp-active-we-linear-icon-box-wrapper', 'flex-start');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'btw-gap', 'فاصله بین آیکون و متن', 0, 50, null, '.wp-active-we-linear-icon-box', 'gap');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'btw-texts-gap', 'فاصله بین متن ها', 0, 50, null, '.wp-active-we-linear-icon-box .texts', 'gap');

        $this->end_controls_section();


        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {

        // box
        AE_E_UTILS::SECTION_START($this, 'box-style-section', 'باکس', 'style');
        AE_E_UTILS::BoxUtils($this, 'box-style', '.wp-active-we-linear-icon-box');
        AE_E_UTILS::SECTION_END($this);


        // text
        AE_E_UTILS::SECTION_START($this, 'text-style', 'متن', 'style');
        AE_E_UTILS::TextUtils($this, 'text', '.wp-active-we-linear-icon-box', true);
        AE_E_UTILS::SECTION_END($this);


        // subtitle
        AE_E_UTILS::SECTION_START($this, 'subtitle-style', 'زیرعنوان', 'style', 'lib-subtitle!', '');
        AE_E_UTILS::TextUtils($this, 'subtitle', '.wp-active-we-linear-icon-box .subtitle');
        AE_E_UTILS::COLOR_FIELD($this, 'subtitle-hover', 'رنگ هاور', '', '.wp-active-we-linear-icon-box:hover .subtitle', 'hover');
        AE_E_UTILS::SECTION_END($this);


        // icon
        AE_E_UTILS::SECTION_START($this, 'icon-style', 'آیکون', 'style');
        AE_E_UTILS::IconUtils($this, 'icon_style', '.icon', '.wp-active-we-linear-icon-box');
        AE_E_UTILS::SECTION_END($this);
    }

    protected function render()
    {
        $settings    = $this->get_settings_for_display();
        $text        = $settings['lib-text'];
        $subtitle    = $settings['lib-subtitle'];
        $link        = $settings['lib-link'];
        $box_classes = 'wp-active-we-linear-icon-box aic gap-10 w100';
        if (!empty($link['url'])) {
            $this->add_link_attributes('lib-link', $settings['lib-link']);
            $this->add_render_attribute('lib-link', 'class', $box_classes);
        }
        $icon_place = $settings['icon-place'];

        ?>
        <div class="wp-active-we-linear-icon-box-wrapper dfx aic">
            <?php
            if (!empty($link['url'])) { ?>
                <a <?php $this->print_render_attribute_string('lib-link'); ?>>
                    <?php
                    if ($icon_place === 'before') {
                        AE_E_UTILS::ICON_PRINT($this, $settings, 'lib-', 'trans03');
                    }
                    ?>
                    <div class="texts dfx dir-v">
                        <?php
                        echo '<span class="title dfx">' . esc_html($text) . '</span>';
                        if (!empty($subtitle)) {
                            echo '<span class="subtitle dfx">' . esc_html($subtitle) . '</span>';
                        }
                        ?>
                    </div>
                    <?php
                    if ($icon_place === 'after') {
                        AE_E_UTILS::ICON_PRINT($this, $settings, 'lib-', 'trans03');
                    }
                    ?>
                </a>
            <?php } else { ?>
                <div class="<?php echo $box_classes; ?>">
                    <?php
                    if ($icon_place === 'before') {
                        AE_E_UTILS::ICON_PRINT($this, $settings, 'lib-', 'trans03');
                    }
                    ?>
                    <div class="texts dfx dir-v">
                        <?php
                        echo '<span class="title dfx">' . esc_html__($text, 'wp-active-widgets-elementor') . '</span>';
                        if (!empty($subtitle)) {
                            echo '<span class="subtitle dfx">' . __($subtitle,'wp-active-widgets-elementor') . '</span>';
                        }
                        ?>
                    </div>
                    <?php
                    if ($icon_place === 'after') {
                        AE_E_UTILS::ICON_PRINT($this, $settings, 'lib-', 'trans03');
                    }
                    ?>
                </div>
            <?php } ?>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_LinearIconBox());
