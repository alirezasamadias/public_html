<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;
use WP_ACTIVE_WE_OwlCarousel;

class WP_ACTIVE_WE_Testimonials1 extends Widget_Base
{

    use WP_ACTIVE_WE_OwlCarousel;

    public function get_script_depends()
    {
        return ['jquery', 'owl-js', 'wp-active-we-owl-slider'];
    }

    public function get_style_depends()
    {
        wp_register_style('AE_E_Testimonials1', AE_E_CSS_DIR . 'testimonials-1.css');
        return ['owl-css', 'owl-theme-default', 'AE_E_Testimonials1'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'اسلایدر نظر مشتریان 1';
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
        AE_E_UTILS::TXT_FIELD($comment, 'position', 'جایگاه', 'طراح سایت', true);
        AE_E_UTILS::TEXTAREA($comment, 'comment', 'نظر', '', true);
        AE_E_UTILS::NUMBER_FIELD($comment, 'stars', 'ستاره', 0, 5, 1, 0, true);
        AE_E_UTILS::IMAGE($comment, 'image', 'تصویر', 'true');
        $this->add_control(
            'testimonials',
            [
                'label'       => 'نظرات',
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $comment->get_controls(),
                'title_field' => '{{{ name }}}',
            ]
        );
        $this->end_controls_section();

        // slider settings
        $this->OwlSettings();

        $this->register_controls_styles();

        $this->OwlStylesNextPrevBtn();
        $this->OwlStylesDotSettings();
    }

    protected function register_controls_styles()
    {

        AE_E_UTILS::SECTION_START($this, 'style-text-box', 'باکس متن', 'style');

        AE_E_UTILS::TextUtils($this, 'comment', '.wp-active-we-testimonials-1 .testimonial .text-box .text');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'comment-mb', 'فاصله', 0, 100, null, '.wp-active-we-testimonials-1 .testimonial .text-box .text', 'margin-bottom');

        AE_E_UTILS::DynamicStyleControls($this, 'text-box', '.wp-active-we-testimonials-1 .testimonial .text-box', [
            'padding', 'bg', 'radius', 'shadow'
        ]);
        AE_E_UTILS::COLOR_FIELD($this, 'text-triangle-bg', 'رنگ مثلث', '', '.wp-active-we-testimonials-1 .testimonial .text-box:before', 'color');

        AE_E_UTILS::COLOR_FIELD($this, 'stars-color', 'رنگ ستاره', '', '.wp-active-we-testimonials-1 .testimonial .text-box .stars svg', 'fill');

        AE_E_UTILS::SECTION_END($this);


        // details
        AE_E_UTILS::SECTION_START($this, 'style-details', 'جزئیات', 'style');
        AE_E_UTILS::Separator($this, 'comment-name', 'نام');
        AE_E_UTILS::TextUtils($this, 'comment-name', '.wp-active-we-testimonials-1 .testimonial .details-box .comment-details b');

        AE_E_UTILS::Separator($this, 'comment-position', 'جایگاه');
        AE_E_UTILS::TextUtils($this, 'comment-position', '.wp-active-we-testimonials-1 .testimonial .details-box .comment-details span');

        AE_E_UTILS::Separator($this, 'comment-image', 'تصویر');
        AE_E_UTILS::DynamicStyleControls($this, 'comment-image', '.wp-active-we-testimonials-1 .testimonial .details-box img', [
            'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $testimonials = $settings['testimonials'];
        if (empty($testimonials)) {
            return;
        }

        $this->add_render_attribute('testimonials_wrapper_attr', 'class', 'wp-active-we-testimonials-1 wp-active-we-testimonials w100 slider-container owl-carousel');
        $this->add_render_attribute('testimonials_wrapper_attr', 'data-slider-settings', json_encode($this->RenderOwlSettings()));

        ?>
        <div <?php $this->print_render_attribute_string('testimonials_wrapper_attr'); ?>>

            <?php
            foreach ($testimonials as $testimonial) {
                $stars    = $testimonial['stars'];
                $comment  = $testimonial['comment'];
                $name     = $testimonial['name'];
                $position = $testimonial['position'];
                ?>

                <div class="testimonial">
                    <div class="text-box">
                        <?php if (!empty($comment)) { ?>
                            <p class="text"><?php echo $comment; ?></p>
                        <?php } ?>
                        <?php if ($stars > 0) { ?>
                            <div class="stars dfx aic">
                                <?php
                                for ($i = 0; $i < 5; $i++) {
                                    if ($i < $stars) {
                                        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z"></path></svg>';
                                    } else {
                                        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26ZM12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502L9.96214 9.69434L5.12921 10.2674L8.70231 13.5717L7.75383 18.3451L12.0006 15.968Z"></path></svg>';
                                    }
                                }
                                ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="details-box dfx aic ae-gap-10">
                        <?php AE_E_UTILS::ImageGenerator($testimonial, 'image', 'full'); ?>
                        <div class="comment-details dfx dir-v">
                            <?php if (!empty($name)) { ?>
                                <b><?php esc_html_e($name); ?></b>
                            <?php } ?>
                            <?php if (!empty($position)) { ?>
                                <span><?php esc_html_e($position); ?></span>
                            <?php } ?>
                        </div>
                    </div>
                </div>

            <?php } ?>

        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_Testimonials1());
