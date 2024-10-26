<?php

namespace Elementor;

defined('ABSPATH') || die();

use RP_Utils;
use OwlCarousel;
use RealPressHelper;

class NaderSingleProjectGallery extends Widget_Base{

    use OwlCarousel;

    public function get_script_depends()
    {
        wp_register_script('nader-single-project-gallery', NADER_ELEMENTOR_JS_DIR . 'nader-single-project-gallery.js', [
            'nader-owl-carousel',
            'fancybox-gallery'
        ], 1, true);
        return ['nader-owl-carousel', 'fancybox-gallery', 'nader-single-project-gallery'];
    }

    public function get_style_depends()
    {
        return ['nader-owl-css'];
    }

    public function get_name()
    {
        return 'NaderSingleProjectGallery';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : گالری تصاویر پروژه';
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
        RP_Utils::SWITCH_FIELD($this, 'replace_with_f_image', 'جایگزین کردن با تصویر شاخص اگر گالری خالی باشد', '');
        RP_Utils::SWITCH_FIELD($this, 'add_f_image_to_slider', 'افزودن تصویر شاخص به اسلایدر', '');
        RP_Utils::IMAGE_SIZE($this,'image','medium_large');
        RP_Utils::SECTION_END($this);


        RP_Utils::SECTION_START($this, 'styles', 'استایل','style');
        RP_Utils::SLIDER_FIELD_PIX_STYLE($this, 'height', 'ارتفاع', 50, 500, 300, '.nader-single-project-gallery, {{WRAPPER}} .gallery-item img, {{WRAPPER}} .project-image-thumbnail', 'height');
        RP_Utils::DIMENSIONS_FIELD($this,'border-radius','خمیدگی','.nader-single-project-gallery, {{WRAPPER}} .gallery-item img, {{WRAPPER}} .project-image-thumbnail','border-radius');
        RP_Utils::SECTION_END($this);


        $this->OwlSettings();
        $this->OwlStylesNextPrevBtn();
        $this->OwlStylesDotSettings();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $replace_with_f_image = $settings['replace_with_f_image'];
        $add_f_image_to_slider = $settings['add_f_image_to_slider'];
        $slider_settings = $this->RenderOwlSettings();
        $gallery = get_post_meta(get_the_ID(), 'project-gallery-image', true);
        $image_size = $settings['image_size'];


        if (empty($gallery) && empty($replace_with_f_image)) {
            return;
        }

        if (empty($gallery) && !empty($replace_with_f_image) && has_post_thumbnail()) {
            ?>
            <a href="<?php the_post_thumbnail_url('full'); ?>" data-lightbox="nader-single-thumbnail" class="project-image-thumbnail">
                <?php the_post_thumbnail($image_size); ?>
            </a>
            <?php
            return;
        }

        ?>
        <div class="nader-single-project-gallery fancybox-gallery owl-carousel" <?php RealPressHelper::insertJsonToElement('slider', $slider_settings); ?>>
            <?php
            if (!empty($add_f_image_to_slider) && has_post_thumbnail()) {
                ?>
                <div class="gallery-item"
                     data-src="<?php the_post_thumbnail_url('full'); ?>"
                     data-fancybox="fancybox-gallery">
                    <?php the_post_thumbnail($image_size); ?>
                </div>
                <?php
            }
            foreach ($gallery as $image) {
                echo '<div class="gallery-item" data-src="' . wp_get_attachment_image_url($image, 'full') . '" data-fancybox="fancybox-gallery">';
                echo wp_get_attachment_image($image, $image_size, '', ['data-no-lazy' => '1']);
                echo '</div>';
            }
            ?>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new NaderSingleProjectGallery());
