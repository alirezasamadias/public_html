<?php
namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_Box3Text extends Widget_Base {

    public function get_name() {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title() {
        return  'جعبه 3 متنی';
    }

    public function get_icon() {
        return 'wp-active-we-widget eicon-t-letter';
    }

    public function get_categories() {
        return [ 'WP_ACTIVE_WE' ];
    }

    protected function register_controls() {

        $this->start_controls_section( 'settings', [ 'label' => 'تنظیمات' ] );
        AE_E_UTILS::TXT_FIELD($this, 'title', 'عنوان', 'این عنوان است', true);
        AE_E_UTILS::HTML_TAG($this, 'title-tag', 'عنوان', 'h3','title!', '');
        AE_E_UTILS::TXT_FIELD($this, 'subtitle', 'زیرعنوان', 'این زیرعنوان است', true);
        AE_E_UTILS::HTML_TAG($this, 'subtitle-tag', 'زیرعنوان', 'span','subtitle!', '');
        AE_E_UTILS::TEXTAREA($this, 'text', 'متن');

        AE_E_UTILS::TEXT_ALIGNMENT($this, 'all-texts-alignment', '.title, {{WRAPPER}} .subtitle, {{WRAPPER}} .text');

        $this->end_controls_section();


        $this->register_controls_styles();
    }

    protected function register_controls_styles() {

        // title
        AE_E_UTILS::SECTION_START($this, 'title-style', 'عنوان', 'style');
        AE_E_UTILS::TextUtils($this, 'title', '.title');
        AE_E_UTILS::COLOR_FIELD($this, 'title_color_hover', 'رنگ هاور', '', '.elementor-widget-container:hover .title', 'color');
        AE_E_UTILS::SECTION_END($this);


        // subtitle
        AE_E_UTILS::SECTION_START($this, 'subtitle-style', 'زیرعنوان', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'subtitle-mt', 'فاصله', 0, 100, null, '.subtitle', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'subtitle', '.subtitle');
        AE_E_UTILS::COLOR_FIELD($this, 'subtitle_color_hover', 'رنگ هاور', '', '.elementor-widget-container:hover .subtitle', 'color');
        AE_E_UTILS::SECTION_END($this);


        // text
        AE_E_UTILS::SECTION_START($this, 'text-style', 'متن', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'text-mt', 'فاصله', 0, 100, null, '.text', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'text', '.text');
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="wp-active-we-box-3-text">
            <?php AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'title', 'title-tag' ,'title trans03'); ?>
            <?php AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'subtitle', 'subtitle-tag' ,'subtitle trans03 dfx'); ?>
            <?php AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'text', 'p' ,'text'); ?>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new WP_ACTIVE_WE_Box3Text() );
