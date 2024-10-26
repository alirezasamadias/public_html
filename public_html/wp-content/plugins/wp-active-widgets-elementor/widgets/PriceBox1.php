<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_PriceBox1 extends Widget_Base{

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-price-box-1', AE_E_CSS_DIR . 'price-box-1.min.css');
        return ['wp-active-we-price-box-1'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'باکس قیمت 1';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-price-table';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        AE_E_UTILS::TXT_FIELD($this, 'title', 'عنوان', 'پلن طلایی', true);
        AE_E_UTILS::TXT_FIELD($this, 'subtitle', 'زیرعنوان', '', true);
        AE_E_UTILS::TXT_FIELD($this, 'price', 'قیمت', '150,000', true);
        AE_E_UTILS::SWITCH_FIELD($this, 'toman', 'نمایش تومان', 'yes', false, 'price!', '');
        AE_E_UTILS::ICON($this, 'price-');


        AE_E_UTILS::TXT_FIELD($this, 'badge-1', 'لیبل 1', '', true);
        AE_E_UTILS::TXT_FIELD($this, 'badge-2', 'لیبل 2', '', true);
        AE_E_UTILS::TEXT_ALIGNMENT($this, 'badge-alignment', '.price-box-label');

        $lines = new \Elementor\Repeater();
        AE_E_UTILS::TXT_FIELD($lines, 'title', 'ویژگی', '', true);
        AE_E_UTILS::ICON($lines, 'lines-icon');
        $this->add_control('lines', [
            'label'         => 'ویژگی های فعال',
            'type'          => \Elementor\Controls_Manager::REPEATER,
            'fields'        => $lines->get_controls(),
            'title_field'   => '{{{ title }}}',
            'prevent_empty' => false,
        ]);

        $lines_de_active = new \Elementor\Repeater();
        AE_E_UTILS::TXT_FIELD($lines_de_active, 'title', 'ویژگی', '', true);
        AE_E_UTILS::ICON($lines_de_active, 'lines-icon');
        $this->add_control('lines_de_active', [
            'label'         => 'ویژگی های غیرفعال',
            'type'          => \Elementor\Controls_Manager::REPEATER,
            'fields'        => $lines_de_active->get_controls(),
            'title_field'   => '{{{ title }}}',
            'prevent_empty' => false,
        ]);

        AE_E_UTILS::TEXTAREA($this, 'text', 'متن', '', true);

        AE_E_UTILS::H_ALIGNMENT_MIN($this, 'body-alignment', '.price-box-body');
        AE_E_UTILS::TXT_FIELD($this, 'btn-title', 'عنوان دکمه', 'سفارش پلن', true);
        AE_E_UTILS::URL_FIELD($this, 'btn-link', 'لینک دکمه', true, 'btn-title!', '');

        $this->end_controls_section();

        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {
        // box
        AE_E_UTILS::SECTION_START($this, 'price-box-style', 'باکس', 'style');
        AE_E_UTILS::BoxUtils($this, 'price-box', '.price-box-inner');
        AE_E_UTILS::SECTION_END($this);

        // header icon
        AE_E_UTILS::SECTION_START($this, 'header-icon-style', 'آیکون هدر', 'style');
        AE_E_UTILS::IconUtils($this, 'btn-icon', '.price-box-header .icon');
        AE_E_UTILS::SECTION_END($this);

        // title
        AE_E_UTILS::SECTION_START($this, 'header-title-style', 'عنوان', 'style', 'title!', '');
        AE_E_UTILS::TextUtils($this, 'header-title', '.price-box-title');
        AE_E_UTILS::TEXT_ALIGNMENT($this, 'title-align', '.price-box-title');
        AE_E_UTILS::SECTION_END($this);

        // subtitle
        AE_E_UTILS::SECTION_START($this, 'header-subtitle-style', 'زیرعنوان', 'style', 'subtitle!', '');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'subtitle-distance', 'فاصله از بالا', 0, 100, null, '.price-box-subtitle', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'header-subtitle', '.price-box-subtitle');
        AE_E_UTILS::TEXT_ALIGNMENT($this, 'subtitle-align', '.price-box-subtitle');
        AE_E_UTILS::SECTION_END($this);


        // label 1
        AE_E_UTILS::SECTION_START($this, 'label-1-style', 'لیبل 1', 'style', 'badge-1!', '');
        AE_E_UTILS::BoxUtils($this, 'label-1', '.label-1', '.price-box-inner ', false, false, true);
        AE_E_UTILS::SECTION_END($this);

        // label 2
        AE_E_UTILS::SECTION_START($this, 'label-2-style', 'لیبل 2', 'style', 'badge-2!', '');
        AE_E_UTILS::BoxUtils($this, 'label-2', '.label-2', '.price-box-inner ', false, false, true);
        AE_E_UTILS::SECTION_END($this);


        // body
        AE_E_UTILS::SECTION_START($this, 'body-styles', 'ویژگی ها', 'style');

        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'body-distance', 'فاصله از بالا', 0, 100, null, '.price-box-body', 'margin-top');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'body-lines-gap', 'فاصله بین خطوط', 0, 100, null, '.price-box-body ul', 'gap');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'body-feature-gap', 'فاصله آیکون و متن', 0, 50, null, '.price-box-body ul li', 'gap');

        AE_E_UTILS::Separator($this, 'active-lines', 'ویژگی های فعال');
        AE_E_UTILS::FONT_FIELD($this, 'line-active-typography', 'تایپوگرافی', '.price-box-body ul li:not(.line-de-active)');
        AE_E_UTILS::COLOR_FIELD($this, 'line-active-color', 'رنگ', '', '.price-box-body ul li:not(.line-de-active)', 'color');
        AE_E_UTILS::IconUtilsLight($this, 'line-active-icon', '.price-box-body ul li:not(.line-de-active)', ' آیکون');

        AE_E_UTILS::Separator($this, 'de-active-lines', 'ویژگی های غیر فعال');
        AE_E_UTILS::FONT_FIELD($this, 'line-de-active-typography', 'تایپوگرافی', '.price-box-body .line-de-active');
        AE_E_UTILS::COLOR_FIELD($this, 'line-de-active-color', 'رنگ', '', '.price-box-body .line-de-active', 'color');
        AE_E_UTILS::IconUtilsLight($this, 'line-de-active-icon', '.price-box-body .line-de-active', ' آیکون');

        AE_E_UTILS::SECTION_END($this);


        // text
        AE_E_UTILS::SECTION_START($this, 'box-text-styles', 'متن', 'style', 'text!', '');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'price-text-distance', 'فاصله از بالا', 0, 100, null, '.price-box-text', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'price-text', '.price-box-text');
        AE_E_UTILS::TEXT_ALIGNMENT($this, 'price-text-align', '.price-box-text');
        AE_E_UTILS::SECTION_END($this);

        //footer
        AE_E_UTILS::SECTION_START($this, 'box-footer-styles', 'متن', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'footer-distance', 'فاصله از بالا', 0, 100, null, '.price-box-footer', 'margin-top', 'price', '');
        AE_E_UTILS::SECTION_END($this);

        // footer price
        AE_E_UTILS::SECTION_START($this, 'price-styles', 'قیمت', 'style', 'price!', '');
        AE_E_UTILS::TextUtils($this, 'price', '.price-text');
        AE_E_UTILS::COLOR_FIELD($this, 'toman-svg-color', 'رنگ تومان', '', '.price-text svg', 'fill');
        AE_E_UTILS::SECTION_END($this);


        // footer button
        AE_E_UTILS::SECTION_START($this, 'button-styles', 'دکمه', 'style', 'btn-title!', '');
        AE_E_UTILS::TAB_START($this, 'button');
        AE_E_UTILS::DynamicStyleControls($this, 'button-normal', '.price-box-button', [
            'font',
            'color',
            'padding',
            'background',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::TAB_MIDDLE($this, 'button');
        AE_E_UTILS::DynamicStyleControls($this, 'button-hover', '.price-box-button:hover', [
            'color',
            'padding',
            'background',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);

        AE_E_UTILS::SECTION_END($this);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $lines = $settings['lines'];
        $lines_de_active = $settings['lines_de_active'];
        $text = $settings['text'];

        $price = trim($settings['price']);
        $toman = $settings['toman'];
        $btn_title = trim($settings['btn-title']);


        if (!empty($btn_title) || !empty($price)) {
            $this->add_render_attribute('price-footer', 'class', 'price-box-footer w100 dfx wrap');

            // if empty $btn_title -> throw fetal error
            if (!empty($btn_title)) {
                $this->add_link_attributes('button', $settings['btn-link']);
                $this->add_render_attribute('button', 'class', 'price-box-button');
            }

            if (empty($btn_title) || empty($price)) {
                $this->add_render_attribute('price-footer', 'class', 'jcc');
            } else {
                $this->add_render_attribute('price-footer', 'class', 'jcsb');
            }
        }

        ?>
        <div class="wp-active-we-price-box-1 w100">
            <div class="price-box-inner w100">
                <div class="price-box-header dfx dir-v aic">
                    <?php AE_E_UTILS::ICON_PRINT($this, $settings, 'price-', 'price-box-icon trans03'); ?>
                    <?php AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'title', 'h3', 'price-box-title'); ?>
                    <?php AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'subtitle', 'h4', 'price-box-subtitle'); ?>
                </div>

                <?php AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'badge-1', 'span', 'price-box-label label-1'); ?>
                <?php AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'badge-2', 'span', 'price-box-label label-2'); ?>

                <?php if (!empty([$lines, $lines_de_active, $text])) { ?>
                    <div class="price-box-body d-grid aic jcc">
                        <?php if (!empty([$lines, $lines_de_active])) { ?>
                            <ul class="list d-grid ae-gap-15">
                                <?php foreach ($lines as $line) {
                                    if (empty($line['title'])) {
                                        continue;
                                    }
                                    ?>
                                    <li class="dfx aic ae-gap-7">
                                        <?php AE_E_UTILS::ICON_PRINT($this, $line, 'lines-icon', 'price-box-icon'); ?>
                                        <?php echo !empty($line['title']) ? $line['title'] : ''; ?>
                                    </li>
                                <?php }
                                foreach ($lines_de_active as $line) {
                                    if (empty($line['title'])) {
                                        continue;
                                    }
                                    ?>
                                    <li class="line-de-active dfx aic ae-gap-7">
                                        <?php AE_E_UTILS::ICON_PRINT($this, $line, 'lines-icon', 'price-box-icon'); ?>
                                        <?php echo !empty($line['title']) ? $line['title'] : ''; ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php }
                        if (!empty($text)) {
                            echo '<p class="price-box-text">' . $text . '</p>';
                        } ?>
                    </div>
                <?php }

                if (!empty([$btn_title, $price])) { ?>
                    <div <?php $this->print_render_attribute_string('price-footer'); ?>>
                        <?php if (!empty($price)) { ?>
                            <span class="price-text dfx aic ae-gap-5">
                                <?php echo esc_html($price); ?>
                                <?php if (!empty($toman)) {
                                    echo AE_E_UTILS::TomanSvg();
                                } ?>
                            </span>
                        <?php }
                        if (!empty($btn_title)) { ?>
                            <a <?php $this->print_render_attribute_string('button'); ?>>
                                <?php echo esc_html($btn_title); ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>

            </div>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_PriceBox1());
