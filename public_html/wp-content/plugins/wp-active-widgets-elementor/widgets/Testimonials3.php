<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;
use WP_ACTIVE_WE_OwlCarousel;

class WP_ACTIVE_WE_Testimonials3 extends Widget_Base{

    use WP_ACTIVE_WE_OwlCarousel;

    public function get_script_depends()
    {
        return ['jquery', 'owl-js', 'wp-active-we-owl-slider'];
    }

    public function get_style_depends()
    {
        wp_register_style('AE_E_Testimonials3', AE_E_CSS_DIR . 'testimonials-3.css');
        return ['owl-css', 'owl-theme-default', 'AE_E_Testimonials3'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'اسلایدر نظر مشتریان 3';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-testimonial-carousel';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('comments', ['label' => 'نظرات']);
        $comment = new \Elementor\Repeater();
        AE_E_UTILS::TXT_FIELD($comment, 'name', 'نام', 'علی عمادزاده', true);
        AE_E_UTILS::TXT_FIELD($comment, 'position', 'جایگاه', '', true);
        AE_E_UTILS::TEXTAREA($comment, 'comment', 'نظر', '', true);
        AE_E_UTILS::NUMBER_FIELD($comment, 'star', 'ستاره', 1, 5, 1, null);
        AE_E_UTILS::IMAGE($comment, 'image', 'تصویر', 'true');
        $this->add_control('testimonials', [
            'label'       => 'نظرات',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $comment->get_controls(),
            'title_field' => '{{{ name }}}',
        ]);
        $this->end_controls_section();

        // slider settings
        $this->OwlSettings();

        $this->register_controls_styles();

        $this->OwlStylesNextPrevBtn();
        $this->OwlStylesDotSettings();
    }

    protected function register_controls_styles()
    {

        // BOX
        AE_E_UTILS::SECTION_START($this, 'style-box', 'باکس', 'style');
        AE_E_UTILS::DynamicStyleControls($this, 'cm-box', '.testimonial', [
            'padding',
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::SECTION_END($this);


        // IMAGE
        AE_E_UTILS::SECTION_START($this, 'style-image', 'تصویر', 'style');
        AE_E_UTILS::SameWithHeight($this, 'cm-image-WH', '.tm-head img');
        AE_E_UTILS::DynamicStyleControls($this, 'cm-image', '.tm-head img', [
            'padding',
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::SECTION_END($this);


        // NAME
        AE_E_UTILS::SECTION_START($this, 'style-name', 'نام', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'cm-name-mt', 'فاصله', 0, 100, null, '.testimonial .name', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'cm-name', '.testimonial .name');
        AE_E_UTILS::SECTION_END($this);

        // POSITION
        AE_E_UTILS::SECTION_START($this, 'style-position', 'جایگاه', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'cm-position-mt', 'فاصله', 0, 100, null, '.testimonial .position', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'cm-position', '.testimonial .position');
        AE_E_UTILS::SECTION_END($this);

        // RATING
        AE_E_UTILS::SECTION_START($this, 'style-rating', 'ستاره', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'cm-rating-mt', 'فاصله از بالا', 0, 100, null, '.testimonial .rating', 'margin-top');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'cm-rating-gap', 'فاصله بین', 0, 100, null, '.testimonial .rating', 'gap');
        AE_E_UTILS::IconUtilsLight($this, 'cm-rating', '.testimonial .rating');
        AE_E_UTILS::COLOR_FIELD($this,'sm-rating-star-empty','رنگ ستاره خالی','','.rating svg.empty','fill');
        AE_E_UTILS::SECTION_END($this);


        // TEXT
        AE_E_UTILS::SECTION_START($this, 'style-text', 'متن', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'cm-text-mt', 'فاصله', 0, 100, null, '.testimonial .tm-body', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'cm-text', '.testimonial .tm-body');
        AE_E_UTILS::TEXT_ALIGNMENT($this, 'cm-text-alignment', '.testimonial .tm-body');
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $testimonials = $settings['testimonials'];
        if (empty($testimonials)) {
            return;
        }

        $this->add_render_attribute('testimonials_wrapper_attr', 'class', 'wp-active-we-testimonials-3 wp-active-we-testimonials w100 slider-container owl-carousel');
        $this->add_render_attribute('testimonials_wrapper_attr', 'data-slider-settings', json_encode($this->RenderOwlSettings()));

        ?>
        <div <?php $this->print_render_attribute_string('testimonials_wrapper_attr'); ?> >
            <?php
            foreach ($testimonials as $testimonial) :
                $star = $testimonial['star'];
                ?>
                <div class="testimonial">
                    <div class="tm-head dfx dir-v aic jcc">
                        <img src="<?php echo esc_url($testimonial['image']['url']); ?>"
                             alt="<?php echo esc_attr($testimonial['image']['alt']); ?>">
                        <?php AE_E_UTILS::TxtHtmlGenerator($this, $testimonial, 'name', 'span', 'name'); ?>
                        <?php AE_E_UTILS::TxtHtmlGenerator($this, $testimonial, 'position', 'span', 'position'); ?>
                        <?php
                        if (!empty($star)) {
                            echo '<div class="rating dfx jcc ae-gap-2 w100">';
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $star) {
                                    echo AE_E_UTILS::StarSvg('full');
                                } else {
                                    echo AE_E_UTILS::StarSvg('empty');
                                }
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <?php AE_E_UTILS::TxtHtmlGenerator($this, $testimonial, 'comment', 'p', 'tm-body'); ?>
                </div>

            <?php endforeach; ?>
        </div>
        <?php

    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_Testimonials3());
