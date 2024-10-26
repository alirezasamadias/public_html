<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;
use WP_ACTIVE_WE_OwlCarousel;

class WP_ACTIVE_WE_Testimonials2 extends Widget_Base
{

    use WP_ACTIVE_WE_OwlCarousel;

    public function get_script_depends()
    {
        return ['jquery', 'owl-js', 'wp-active-we-owl-slider'];
    }

    public function get_style_depends()
    {
        wp_register_style('AE_E_Testimonials2', AE_E_CSS_DIR . 'testimonials-2.css');
        return ['owl-css', 'owl-theme-default', 'AE_E_Testimonials2'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'اسلایدر نظر مشتریان 2';
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

        AE_E_UTILS::TextUtils($this, 'comment', '.wp-active-we-testimonials .testimonial .text-box .text');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'comment-gap', 'فاصله', 0, 100, null, '.wp-active-we-testimonials .testimonial', 'gap');

        AE_E_UTILS::DynamicStyleControls($this, 'text-box', '.wp-active-we-testimonials .testimonial .text-box', [
            'padding', 'bg', 'radius', 'shadow'
        ]);
        AE_E_UTILS::SECTION_END($this);


        // details
        AE_E_UTILS::SECTION_START($this, 'style-details', 'جزئیات', 'style');
        AE_E_UTILS::Separator($this, 'comment-image', 'تصویر');
        $this->add_responsive_control(
            'comment-image-size',
            [
                'label'       => 'اندازه',
                'type'        => Controls_Manager::SLIDER,
                'label_block' => true,
                'size_units'  => ['px'],
                'range'       => [
                    'px' => [
                        'min' => 50,
                        'max' => 100,
                    ],
                ],
                'selectors'   => [
                    '{{WRAPPER}} .wp-active-we-testimonials .testimonial .details-box img' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                ],
            ]
        );
        AE_E_UTILS::DynamicStyleControls($this, 'comment-image', '.wp-active-we-testimonials .testimonial .details-box img', [
            'border', 'radius', 'shadow'
        ]);

        AE_E_UTILS::Separator($this, 'comment-name', 'نام');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'comment-name-gap', 'فاصله', 0, 100, null, '.wp-active-we-testimonials .testimonial .details-box', 'gap');
        AE_E_UTILS::TextUtils($this, 'comment-name', '.wp-active-we-testimonials .testimonial .details-box .comment-details b');

        AE_E_UTILS::Separator($this, 'comment-position', 'جایگاه');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'comment-position-gap', 'فاصله', 0, 100, null, '.wp-active-we-testimonials .testimonial .details-box .comment-details', 'gap');
        AE_E_UTILS::TextUtils($this, 'comment-position', '.wp-active-we-testimonials .testimonial .details-box .comment-details span');

        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $testimonials = $settings['testimonials'];
        if (empty($testimonials)) {
            return;
        }

        $this->add_render_attribute('testimonials_wrapper_attr', 'class', 'wp-active-we-testimonials-2 wp-active-we-testimonials w100 slider-container owl-carousel');
        $this->add_render_attribute('testimonials_wrapper_attr', 'data-slider-settings', json_encode($this->RenderOwlSettings()));

        ?>
        <div <?php $this->print_render_attribute_string('testimonials_wrapper_attr'); ?>>
            <?php
            foreach ($testimonials as $testimonial) {
                $comment  = $testimonial['comment'];
                $name     = $testimonial['name'];
                $position = $testimonial['position'];
                ?>
                <div class="testimonial dfx ae-gap-20">
                    <div class="details-box dfx dir-v ae-gap-10">
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
                    <div class="text-box">
                        <?php if (!empty($comment)) { ?>
                            <p class="text"><?php echo $comment; ?></p>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_Testimonials2());
