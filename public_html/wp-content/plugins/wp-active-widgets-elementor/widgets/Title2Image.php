<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_Title2Image extends Widget_Base{

    public function get_style_depends()
    {
        wp_register_style('AE_E_Title2Image', AE_E_CSS_DIR . 'title-2-image.css');
        return ['AE_E_Title2Image'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'عنوان با 2 تصویر';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-t-letter';
    }

    public function get_categories()
    {
        return [AE_E_PLUGIN_NAME];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        $ds = [
            'dir-v' => 'عمودی',
            ''      => 'افقی'
        ];
        AE_E_UTILS::SELECT_FIELD($this, 'display-style', 'استایل نمایش', $ds, '');
        AE_E_UTILS::TXT_FIELD($this, 'title-main', 'عنوان اصلی', 'عنوان اصلی', true);
        AE_E_UTILS::HTML_TAG($this, 'title-main-tag', 'عنوان اصلی', 'h2', 'title-main!', '');
        AE_E_UTILS::TXT_FIELD($this, 'title-second', 'عنوان فرعی', 'لورم ایپسوم متنی ساختگی است', true);
        AE_E_UTILS::HTML_TAG($this, 'title-second-tag', 'عنوان فرعی', 'span', 'title-second!', '');

        AE_E_UTILS::IMAGE($this, 'image-1', 'تصویر 1', 'true');
        AE_E_UTILS::IMAGE_SIZE($this, 'image-1');
        AE_E_UTILS::IMAGE($this, 'image-2', 'تصویر 2', 'true');
        AE_E_UTILS::IMAGE_SIZE($this, 'image-2');

        $this->end_controls_section();

        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {

        AE_E_UTILS::SECTION_START($this, 'box-section-style', 'استایل', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'images-gap', 'فاصله بین تصاویر و متن', 0, 200, null, '.title-2-image', 'gap');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'texts-gap', 'فاصله بین متن ها', 0, 50, null, '.title-2-image .texts', 'gap');
        AE_E_UTILS::TextUtils($this, 'main-title', '.title-main', false, false, 'title-main!', '');
        AE_E_UTILS::TextUtils($this, 'second-title', '.title-second', false, false, 'title-second!', '');
        AE_E_UTILS::TEXT_ALIGNMENT($this, 'text-alignment', '.texts');
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $style = $settings['display-style'];
        ?>
        <div class="title-2-image dfx jcc aic ae-gap-15 <?php echo $style; ?>">
            <?php Group_Control_Image_Size::print_attachment_image_html($settings, 'image-1', 'image-1'); ?>
            <div class="texts dfx dir-v aic jcc">
                <?php AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'title-main', 'title-main-tag', 'title-main'); ?>
                <?php AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'title-second', 'title-second-tag', 'title-second'); ?>
            </div>
            <?php Group_Control_Image_Size::print_attachment_image_html($settings, 'image-2', 'image-2'); ?>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_Title2Image());
