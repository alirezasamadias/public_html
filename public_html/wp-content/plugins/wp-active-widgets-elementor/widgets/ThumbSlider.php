<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;
use WP_ACTIVE_WE_OwlCarousel;

class WP_ACTIVE_WE_ThumbSlider extends Widget_Base
{
    use WP_ACTIVE_WE_OwlCarousel;

    public function get_script_depends()
    {
        return ['wp-active-we-owl-slider', 'wp-active-we-intro-animation'];
    }

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-thumb-slider', AE_E_CSS_DIR . 'thumb-slider.css');
        return ['owl-css', 'owl-theme-default', 'wp-active-we-thumb-slider'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'اسلایدر بندانگشتی';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-slider-push';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        // slides
        $this->start_controls_section('slides', ['label' => 'اسلایدها']);

        $slides = new \Elementor\Repeater();
        AE_E_UTILS::IMAGE($slides, 'image', 'تصویر', 'true');
        AE_E_UTILS::IMAGE_SIZE($slides, 'image_size', 'full');
        AE_E_UTILS::TXT_FIELD($slides, 'title', 'عنوان', '', true);
        AE_E_UTILS::TXT_FIELD($slides, 'subtitle', 'زیر عنوان', '', true);
        AE_E_UTILS::URL_FIELD($slides, 'link', 'لینک', true);
        $this->add_control(
            'thumb_slides',
            [
                'label'       => 'اسلایدها',
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $slides->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        AE_E_UTILS::SWITCH_FIELD($this, 'intro-animation', 'انیمیشن ورود');

        AE_E_UTILS::SECTION_END($this);


        // slider settings
        $this->OwlSettings();

        $this->register_controls_styles();

    }


    protected function register_controls_styles()
    {

        // box
        AE_E_UTILS::SECTION_START($this, 'style-box', 'باکس', 'style');
        AE_E_UTILS::BoxUtils($this, 'box', '.thumb-slide .thumb-wrapper');
        AE_E_UTILS::SECTION_END($this);


        // title
        AE_E_UTILS::SECTION_START($this, 'style-title', 'عنوان', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'title-mt', 'فاصله', 0, 100, 10, '.thumb-slide .thumb-wrapper span', 'margin-top');
        AE_E_UTILS::FONT_FIELD($this, 'typography', 'تایپوگرافی', '.thumb-slide span');
        AE_E_UTILS::COLOR_FIELD($this, 'color', 'رنگ', '', '.thumb-slide .thumb-wrapper span', 'color');
        AE_E_UTILS::COLOR_FIELD($this, 'color-hover', 'رنگ هاور', '', '.thumb-slide .thumb-wrapper:hover span', 'color');
        AE_E_UTILS::SECTION_END($this);


        // subtitle
        AE_E_UTILS::SECTION_START($this, 'style-subtitle', 'زیر عنوان', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'subtitle-mt', 'فاصله', 0, 50, 5, '.thumb-slide .thumb-wrapper span.subtitle', 'margin-top');
        AE_E_UTILS::FONT_FIELD($this, 'subtitle-typography', 'تایپوگرافی', '.thumb-slide span.subtitle');
        AE_E_UTILS::COLOR_FIELD($this, 'subtitle-color', 'رنگ', '', '.thumb-slide .thumb-wrapper span.subtitle', 'color');
        AE_E_UTILS::COLOR_FIELD($this, 'subtitle-color-hover', 'رنگ هاور', '', '.thumb-slide .thumb-wrapper:hover span.subtitle', 'color');
        AE_E_UTILS::SECTION_END($this);


        // image
        AE_E_UTILS::SECTION_START($this, 'style-image', 'تصویر', 'style');
        AE_E_UTILS::BACKGROUND_WO_IMG_FIELD($this, 'image-bg', '.thumb-slide .thumb-wrapper img');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'image-padding', 'padding', '.thumb-slide .thumb-wrapper img', 'padding');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'image-border-radius', 'خمیدگی', '.thumb-slide .thumb-wrapper img', 'border-radius');
        AE_E_UTILS::SHADOW_FIELD($this, 'image-shadow', 'سایه', '.thumb-slide .thumb-wrapper img');
        AE_E_UTILS::SECTION_END($this);


        $this->OwlStylesNextPrevBtn();
        $this->OwlStylesDotSettings();
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $slides = $settings['thumb_slides'];

        $this->add_render_attribute('slider_wrapper_attr', 'class', 'wp-active-we-thumb-slider slider-container w100 dfx aic jcsb');
        $this->add_render_attribute('slider_wrapper_attr', 'data-slider-settings', json_encode($this->RenderOwlSettings()));
        if ($settings['intro-animation'] === 'yes') {
            $this->add_render_attribute('slider_wrapper_attr', 'class', 'active-animation');
            $this->add_render_attribute('slider_wrapper_attr', 'data-animation-target', '.elementor-element-' . $this->get_id() . ' .thumb-slide');
            $this->add_render_attribute('slider_wrapper_attr', 'data-animation-offset', '100');
        }

        if (!empty($slides)) {

            ?>

            <div <?php $this->print_render_attribute_string('slider_wrapper_attr'); ?>>
                <div class="owl-carousel">

                    <?php

                    $i = 0;

                    foreach ($slides

                    as $slide) {

                    $image_id   = $slide['image']['id'];
                    $image_size = $slide['image_size_size'];
                    $title      = $slide['title'];
                    $subtitle   = $slide['subtitle'];
                    $this->add_link_attributes('link' . $i, $slide['link']);
                    $this->add_render_attribute('link' . $i, 'class', 'thumb-wrapper');
                    $link = $slide['link']['url'];


                    echo '<div class="thumb-slide">';
                    if (!empty($link)) {
                    ?>
                    <a <?php $this->print_render_attribute_string('link' . $i); ?>>
                        <?php
                        } else {
                            echo '<div class="thumb-wrapper">';
                        }

                        echo wp_get_attachment_image($image_id, $image_size);


                        if (!empty($title)) {
                            echo '<span>' . esc_html($title) . '</span>';
                        }
                        if (!empty($subtitle)) {
                            echo '<span class="subtitle">' . esc_html($subtitle) . '</span>';
                        }


                        if (!empty($link)) {
                            echo '</a>';
                        } else {
                            echo '</div>';
                        }
                        echo '</div>';

                        $i++;
                        }

                        ?>

                </div>
            </div>
            <?php
        }
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_ThumbSlider());
