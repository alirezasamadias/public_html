<?php

namespace Elementor;

use RP_Utils;

defined('ABSPATH') || die();

class NaderBanner extends Widget_Base
{

    public function get_style_depends()
    {
        wp_register_style('nader-banner', NADER_ELEMENTOR_CSS_DIR . 'nader-banner.css');
        return ['nader-banner'];
    }

    public function get_name()
    {
        return 'NaderBanner';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : بنر';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-image';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {

        RP_Utils::SECTION_START($this, 'settings', 'تنظیمات');

        RP_Utils::IMAGE($this, 'selected-image', 'تصویر', true);
        RP_Utils::IMAGE_SIZE($this, 'selected-image');

        RP_Utils::TXT_FIELD($this, 'title', 'عنوان اصلی', 'عنوان بنر نادر', true);
        RP_Utils::TXT_FIELD($this, 'title-2', 'عنوان فرعی', 'اطلاعات بیشتر', true);
        RP_Utils::URL_FIELD($this, 'link', 'لینک', true);

        RP_Utils::SWITCH_FIELD($this, 'reverse-effect', 'افکت برعکس شود؟');

        RP_Utils::SECTION_END($this);


        $this->register_controls_styles();

    }

    protected function register_controls_styles() {
        RP_Utils::SECTION_START($this, 'styles', 'تنظیمات', 'style');
        RP_Utils::SLIDER_FIELD_PIX_STYLE($this, 'box-height', 'ارتفاع', 200, 700, null, '.nader-image-banner', 'height');
        RP_Utils::DIMENSIONS_FIELD($this, 'box-border-radius', 'خمیدگی', '.nader-image-banner', 'border-radius');
        RP_Utils::BACKGROUND_WO_IMG_FIELD($this, 'box-overlay', '.nader-image-banner .details');
        RP_Utils::DIMENSIONS_FIELD($this, 'box-padding', 'فاصله داخلی', '.nader-image-banner .details', 'padding');
        RP_Utils::SHADOW_FIELD($this, 'banner-box-shadow', 'سایه', '.nader-image-banner');
        RP_Utils::Separator($this, 'main-title', 'عنوان اصلی');
        RP_Utils::TextUtils($this, 'main-title', '.nader-image-banner .details .main-title');
        RP_Utils::Separator($this, 'second-title', 'عنوان فرعی');
        RP_Utils::TextUtils($this, 'second-title', '.nader-image-banner .details .second-title');
        RP_Utils::SECTION_END($this);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $title          = $settings['title'];
        $link_2         = $settings['title-2'];
        $image          = $settings['selected-image'];
        $image_size     = $settings['selected-image_size'];
        $reverse_effect = $settings['reverse-effect'];

        $this->add_link_attributes('nader-image-banner', $settings['link']);
        $this->add_render_attribute('nader-image-banner', 'class', 'nader-image-banner d-flex');
        if ($reverse_effect) {
            $this->add_render_attribute('nader-image-banner', 'class', 'reverse-effect');
        }

        ?>

        <a <?php $this->print_render_attribute_string('nader-image-banner'); ?>>
            <?php echo wp_get_attachment_image($image['id'], $image_size); ?>
            <div class="details">
                <div class="inner">
                    <?php if (!empty($title)) { ?>
                        <span class="main-title"><?php echo $title; ?></span>
                    <?php }

                    if (!empty($link_2)) { ?>
                        <span class="second-title"><?php echo $link_2; ?></span>
                    <?php } ?>
                </div>
            </div>
        </a>

        <?php

    }
}

Plugin::instance()->widgets_manager->register(new NaderBanner());
