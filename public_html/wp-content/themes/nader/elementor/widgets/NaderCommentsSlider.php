<?php

namespace Elementor;

use RP_Utils;

defined('ABSPATH') || die();

class NaderCommentsSlider extends Widget_Base{

    public function get_script_depends()
    {
        wp_register_script('nader-slick-slider', NADER_JS_DIR . 'slick.min.js', ['jquery'], 1, true);
        wp_register_script('nader-comments-slider-widget', NADER_ELEMENTOR_JS_DIR . 'nader-comments-slider.js', ['jquery', 'nader-slick-slider'], '1.0.0', true);
        return ['jquery', 'nader-slick-slider', 'nader-comments-slider-widget'];
    }

    public function get_style_depends()
    {
        wp_register_style('nader-slick', NADER_CSS_DIR . 'slick.css', [], 1);
        return ['nader-slick'];
    }

    public function get_name()
    {
        return 'NaderCommentsSlider';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : اسلایدر نظرات';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-testimonial-carousel';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        $comments = new \Elementor\Repeater();
        RP_Utils::TXT_FIELD($comments, 'name', 'نام');
        RP_Utils::TXT_FIELD($comments, 'position', 'جایگاه');
        RP_Utils::TEXTAREA($comments, 'description', 'توضیح');
        RP_Utils::IMAGE($comments, 'image', 'تصویر');
        $this->add_control('comments', ['label' => 'نظرات', 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $comments->get_controls(), 'title_field' => '{{{ name }}}',]);

        $this->end_controls_section();


        // nav style
        $this->start_controls_section('feedback-nav-styles', ['label' => 'ناوبری', 'tab' => Controls_Manager::TAB_STYLE]);
        $this->add_responsive_control('nav-opacity-normal', ['label' => 'شفافیت تصویر', 'type' => Controls_Manager::SLIDER, 'label_block' => true, 'size_units' => ['px'], 'range' => ['px' => ['min' => 0.1, 'max' => 1, 'step' => 0.01],], 'default' => ['size' => 0.5], 'selectors' => ['{{WRAPPER}} .nader-comments-slider .feedbackNav .navItem' => 'opacity: {{SIZE}};',],]);
        $this->add_responsive_control('nav-scale-normal', ['label' => 'مقیاس تصویر', 'type' => Controls_Manager::SLIDER, 'label_block' => true, 'size_units' => ['px'], 'range' => ['px' => ['min' => 0.5, 'max' => 1, 'step' => 0.01],], 'default' => ['size' => 0.8], 'selectors' => ['{{WRAPPER}} .nader-comments-slider .feedbackNav .navItem' => 'transform: scale({{SIZE}});-webkit-transform: scale({{SIZE}});',],]);
        $nav_styles = [['type' => 'slider', 'title' => 'فاصله', 'min' => 320, 'max' => 510, 'def' => 460, 'css' => 'max-width', 'target' => '.nader-comments-slider .feedbackNav'], ['type' => 'slider', 'title' => 'فاصله', 'min' => 0, 'max' => 100, 'def' => 40, 'css' => 'margin-bottom',], ['type' => '4dir', 'css' => 'border-radius', 'title' => 'خمیدگی عادی', 'uniq' => 'normal', 'target' => '.nader-comments-slider .feedbackNav .navItem'], ['type' => '4dir', 'css' => 'border-radius', 'title' => 'خمیدگی فعال', 'uniq' => 'active', 'target' => '.nader-comments-slider .feedbackNav .navItem.slick-center'],];
        RP_Utils::VariantUtils($this, 'feedback-nav-styles', '.nader-comments-slider .feedbackNav', $nav_styles);
        $this->end_controls_section();


        $this->start_controls_section('feedback-carousel-styles', ['label' => 'محتوا', 'tab' => Controls_Manager::TAB_STYLE]);
        $content_styles = [['type' => 'color-v', 'title' => 'رنگ آیکون پشت متن نظر', 'css' => 'fill', 'target' => '.nader-comments-slider .feedbackCarousel .item .details .quote-icon svg path', 'uniq' => 'svg-icon'], ['type' => 'text-align', 'target' => '.nader-comments-slider .feedbackCarousel .item .details'], ['type' => 'sep', 'title' => 'نظر', 'uniq' => 'speech'], ['type' => 'text-small', 'uniq' => 'speech', 'target' => '.nader-comments-slider .feedbackCarousel .item .speech'], ['type' => 'slider', 'title' => 'فاصله', 'min' => 0, 'max' => 100, 'def' => 25, 'css' => 'margin-top', 'target' => '.nader-comments-slider .feedbackCarousel .item .feedback-footer'], ['type' => 'sep', 'title' => 'نام', 'uniq' => 'name'], ['type' => 'text-small', 'uniq' => 'name', 'target' => '.nader-comments-slider .feedbackCarousel .item .name'], ['type' => 'sep', 'title' => 'جایگاه', 'uniq' => 'position'], ['type' => 'text-small', 'uniq' => 'position', 'target' => '.nader-comments-slider .feedbackCarousel .item .designation'],];
        RP_Utils::VariantUtils($this, 'feedback-carousel-styles', '', $content_styles);
        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $comments = $settings['comments'];

        if (!empty($comments)) {
            ?>

            <div class="nader-comments-slider">

                <div class="feedbackNav">
                    <?php
                    foreach ($comments as $comment) {
                        $name = $comment['name'];
                        $image = $comment['image'];
                        ?>
                        <div class="navItem">
                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_html($name); ?>"
                                 width="100"
                                 height="100">
                        </div>
                    <?php } ?>
                </div>

                <div class="feedbackCarousel">
                    <?php
                    foreach ($comments as $comment) {
                        $name = $comment['name'];
                        $position = $comment['position'];
                        $description = $comment['description'];
                        ?>
                        <div class="item">
                            <div class="details">
                                <span class="quote-icon">
                                    <svg width="94" height="81" viewBox="0 0 94 81" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_2319_2)">
                                    <path d="M0.0198195 58.3423C0.0198195 70.5981 9.95452 80.5328 22.2101 80.5328C34.4659 80.5328 44.4006 70.5981 44.4006 58.3423C44.4006 46.0865 34.4659 36.152 22.2101 36.152C19.6914 36.152 17.2804 36.5911 15.0233 37.3649C20.0171 8.72427 42.3513 -9.74568 21.6476 5.45545C-1.30972 22.3118 -0.00476774 57.6642 0.0209204 58.3121C0.0209204 58.3222 0.0198195 58.3312 0.0198195 58.3423Z"
                                          fill="black" fill-opacity="0.08"/>
                                    <path d="M48.8382 58.3423C48.8382 70.5981 58.7729 80.5328 71.0287 80.5328C83.2845 80.5328 93.2192 70.5981 93.2192 58.3423C93.2192 46.0865 83.2843 36.152 71.0285 36.152C68.5096 36.152 66.0987 36.5911 63.8417 37.3649C68.8354 8.72427 91.1696 -9.74568 70.4659 5.45545C47.5086 22.3118 48.8134 57.6642 48.8393 58.3121C48.8393 58.3222 48.8382 58.3312 48.8382 58.3423Z"
                                          fill="black" fill-opacity="0.08"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_2319_2">
                                    <rect width="94" height="81" fill="white"/>
                                    </clipPath>
                                    </defs>
                                    </svg>
                                </span>
                                <p class="speech"><?php echo esc_html($description); ?></p>
                                <div class="feedback-footer">
                                    <?php if (!empty($name)) { ?>
                                        <h3 class="name"><?php echo esc_html($name); ?></h3>
                                    <?php }

                                    if (!empty($position)) { ?>
                                        <p class="designation"><?php echo esc_html($position); ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            </div>
            <?php
        }

    }
}

Plugin::instance()->widgets_manager->register(new NaderCommentsSlider());
