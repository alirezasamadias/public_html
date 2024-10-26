<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;
use WP_Query;
use WP_ACTIVE_WE_QueryBuilder;
use WP_ACTIVE_WE_OwlCarousel;
use AE_E_FUNCTIONS;

class WP_ACTIVE_WE_PostsSlider4 extends Widget_Base
{

    use WP_ACTIVE_WE_QueryBuilder;
    use WP_ACTIVE_WE_OwlCarousel;

    public function get_script_depends()
    {
        return ['jquery', 'owl-js', 'wp-active-we-owl-slider', 'wp-active-we-intro-animation'];
    }

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-posts-slider-4', AE_E_CSS_DIR . 'posts-slider-4.css');
        return ['owl-css', 'owl-theme-default', 'wp-active-we-posts-slider-4'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'اسلایدر پست ها 4';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-carousel-loop';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);
        AE_E_UTILS::SELECT_FIELD($this, 'meta-type', 'نوع متا', [
            'comment' => 'دیدگاه',
            'date'    => 'تاریخ انتشار',
            'view'    => 'بازدید',
        ], 'comment');
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image-dimensions',
                'default'   => 'medium_large',
                'separator' => 'none',
                'exclude'   => ['custom']
            ]
        );
        AE_E_UTILS::NUMBER_FIELD_STYLE($this, 'excerpt-lines', 'تعداد خط خلاصه', '.wp-active-we-posts-slider-4 .post-item p', '-webkit-line-clamp', 2, 5, 1, null);

        AE_E_UTILS::SWITCH_FIELD($this, 'use-ajax', 'لود ایجکسی');
        AE_E_UTILS::SELECT_FIELD($this, 'ajax-loading-type', 'زمان اجرای ایجکس', [
            'scroll'  => 'هنگام رسیدن به پست',
            'timeout' => 'به محض لود صفحه'
        ], 'scroll', 'use-ajax', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'intro-animation', 'انیمیشن ورود');

        $this->end_controls_section();

        // Query Settings
        $this->QuerySettings();

        // Slider Settings
        $this->OwlSettings();

        $this->register_controls_styles();

        $this->OwlStylesNextPrevBtn();
        $this->OwlStylesDotSettings();

        $this->QueryNotHavePostsStyle();

    }

    protected function register_controls_styles()
    {
        // box item
        AE_E_UTILS::SECTION_START($this, 'box-style', 'آیتم', 'style');
        AE_E_UTILS::TAB_START($this, 'post-item');
        $this->add_control(
            'item-normal_bg',
            [
                'label'       => 'بکگراند',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .wp-active-we-posts-slider-4 .post-item'                                      => 'background: {{VALUE}};',
                    '{{WRAPPER}} .wp-active-we-posts-slider-4 .post-item .thumb-holder .meta-holder .meta-svg' => 'fill: {{VALUE}};',
                ]
            ]
        );
        AE_E_UTILS::DynamicStyleControls($this, 'item-normal', '.wp-active-we-posts-slider-4 .post-item', [
            'padding', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_MIDDLE($this, 'post-item');
        $this->add_control(
            'item-hover_bg',
            [
                'label'       => 'بکگراند',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .wp-active-we-posts-slider-4 .post-item:hover'                                      => 'background: {{VALUE}};',
                    '{{WRAPPER}} .wp-active-we-posts-slider-4 .post-item:hover .thumb-holder .meta-holder .meta-svg' => 'fill: {{VALUE}};',
                ]
            ]
        );
        AE_E_UTILS::DynamicStyleControls($this, 'item-hover', '.wp-active-we-posts-slider-4 .post-item:hover', [
            'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);
        AE_E_UTILS::SECTION_END($this);


        // image styles
        AE_E_UTILS::SECTION_START($this, 'image-style', 'تصویر', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'image-height', 'ارتفاع', 100, 300, null,
            '.wp-active-we-posts-slider-4 .post-item .thumb-holder', 'height');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'image-radius', 'خمیدگی', '.wp-active-we-posts-slider-4 .post-item .thumb-holder', 'border-radius');
        AE_E_UTILS::SECTION_END($this);


        // meta
        AE_E_UTILS::SECTION_START($this, 'meta-style', 'متا', 'style');
        AE_E_UTILS::TextUtils($this, 'meta', '.wp-active-we-posts-slider-4 .post-item .thumb-holder .meta-holder .meta');
        AE_E_UTILS::COLOR_FIELD($this, 'meta-icon-color', 'رنگ آیکون', '', '.wp-active-we-posts-slider-4 .post-item .thumb-holder .meta-holder .meta svg', 'fill');
        AE_E_UTILS::SECTION_END($this);


        // title styles
        AE_E_UTILS::SECTION_START($this, 'title-style', 'عنوان', 'style');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'info-padding', 'فاصله داخلی متن ها', '.wp-active-we-posts-slider-4 .post-item .post-infos', 'padding');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'title-gap', 'فاصله', 0, 50, null,
            '.wp-active-we-posts-slider-4 .post-item', 'gap');

        AE_E_UTILS::NUMBER_FIELD_STYLE($this,'item-title-line-clamp','تعداد خط','.post-item .post-title h2','-webkit-line-clamp',1,3,1,null);
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this,'item-title-line-height','ارتفاع',20,80,null,'.post-item .post-title h2','height');

        AE_E_UTILS::TextUtils($this, 'title', '.wp-active-we-posts-slider-4 .post-item .post-title h2');
        AE_E_UTILS::COLOR_FIELD($this, 'title_color_hover', 'رنگ هاور', '', '.wp-active-we-posts-slider-4 .post-item .post-title:hover h2', 'color');
        AE_E_UTILS::SECTION_END($this);


        // excerpt styles
        AE_E_UTILS::SECTION_START($this, 'excerpt-style', 'خلاصه', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'excerpt-gap', 'فاصله', 0, 50, null,
            '.wp-active-we-posts-slider-4 .post-item .post-infos', 'gap');
        AE_E_UTILS::TextUtils($this, 'excerpt', '.wp-active-we-posts-slider-4 .post-item p');
        AE_E_UTILS::SECTION_END($this);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $use_ajax       = $settings['use-ajax'];
        $query          = null;
        $posts_per_page = $settings['posts_per_page'];
        if ($use_ajax === 'yes') {
            $this->ajaxify($settings);
        } else {
            $query_args = $this->QueryArgBuilder();
            $query      = new WP_Query($query_args);

            if (!$query->have_posts()) {
                $this->add_render_attribute('post-slider-4', 'class', 'wo-post');
            }
        }

        $slider_settings = $this->RenderOwlSettings();
        $this->add_render_attribute('post-slider-4', 'class', ['wp-active-we-posts-slider-4', 'slider-container', 'owl-carousel']);
        $this->add_render_attribute('post-slider-4', 'data-slider-settings', json_encode($slider_settings));
        if ($settings['intro-animation'] === 'yes') {
            $this->add_render_attribute('post-slider-4', 'class', 'active-animation');
            $this->add_render_attribute('post-slider-4', 'data-animation-target', '.elementor-element-' . $this->get_id() . ' .post-item');
            $this->add_render_attribute('post-slider-4', 'data-animation-offset', '100');
        }

        ?>
        <div <?php $this->print_render_attribute_string('post-slider-4'); ?>>
            <?php
            if ($use_ajax) {
                for ($i = 0; $i < $posts_per_page; $i++) {
                    $this->placeholder();
                }
            } else {
                $this->printQuery($settings, $query);
            }
            ?>
        </div>
        <?php

    }

    protected function ajaxify($settings)
    {

        $query_args = $this->QueryArgBuilder();
        $this->add_render_attribute('post-slider-4', 'class', 'wp-active-we-ajax-container');
        $this->add_render_attribute('post-slider-4', 'data-query-args', json_encode($query_args));
        $this->add_render_attribute('post-slider-4', 'data-ajax-type', $settings['ajax-loading-type']);
        $this->add_render_attribute('post-slider-4', 'data-ajax-status', 'before_start');
        $this->add_render_attribute('post-slider-4', 'data-post-structure', json_encode($this->postStructure($settings)));
        $this->add_render_attribute('post-slider-4', 'data-ajax-result-place', '.elementor-element-' . $this->get_id() . ' .wp-active-we-posts-slider-4');

        $widget_data = [
            'wid'         => $this->get_id(),
            'post_class'  => 'post-item d-grid',
            'image_size'  => $settings['image-dimensions_size'],
            'image_class' => 'post-thumbnail'
        ];
        if ($settings['intro-animation'] === 'yes') {
            $widget_data['post_class'] .= ' item-has-intro-animation';
        }
        $this->add_render_attribute('post-slider-4', 'data-widget-data', json_encode($widget_data));
    }


    protected function placeholder()
    {
        $meta_place_svg = '<svg class="meta-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 383.35 75.04"><g><g><path d="M383.35,75a33.22,33.22,0,0,1-27.07-14.13L330,23.44A55.1,55.1,0,0,0,284.86,0H98.48a55.13,55.13,0,0,0-45.1,23.44L27.06,60.91A33.18,33.18,0,0,1,0,75Z"/></g></g></svg>';

        ?>

        <div class="post-item d-grid placeholder animated-placeholder">
            <div class="thumb-holder">
                <span class="post-thumbnail dfx w100 skeleton-bg"></span>
                <div class="meta-holder dfx aic jcc"><?php echo $meta_place_svg; ?></div>
            </div>
            <div class="post-infos dfx dir-v ae-gap-10">
                <span class="post-title dfx w100 h20 skeleton-bg"></span>
                <div class="excerpt d-grid ae-gap-5">
                    <span class="dfx w100 h20 skeleton-bg"></span>
                    <span class="dfx w100 h20 skeleton-bg"></span>
                    <span class="dfx w100 h20 skeleton-bg"></span>
                </div>
            </div>
        </div>

        <?php

    }


    protected function postStructure($settings)
    {

        $meta_type      = $settings['meta-type'];
        $meta_place_svg = '<svg class="meta-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 383.35 75.04"><g><g><path d="M383.35,75a33.22,33.22,0,0,1-27.07-14.13L330,23.44A55.1,55.1,0,0,0,284.86,0H98.48a55.13,55.13,0,0,0-45.1,23.44L27.06,60.91A33.18,33.18,0,0,1,0,75Z"/></g></g></svg>';

        $post_structure = '<div class="{post_class}">';
        $post_structure .= '<div class="thumb-holder">';
        $post_structure .= '{thumbnail}';
        $post_structure .= '<div class="meta-holder dfx aic jcc">';
        $post_structure .= $meta_place_svg;
        $post_structure .= '<div class="meta dfx aic ae-gap-5">';
        if ($meta_type === 'comment') {
            $post_structure .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6.45455 19L2 22.5V4C2 3.44772 2.44772 3 3 3H21C21.5523 3 22 3.44772 22 4V18C22 18.5523 21.5523 19 21 19H6.45455ZM5.76282 17H20V5H4V18.3851L5.76282 17ZM11 10H13V12H11V10ZM7 10H9V12H7V10ZM15 10H17V12H15V10Z"></path></svg>';
            $post_structure .= '{comment}';
        } elseif ($meta_type === 'view' && function_exists('the_views')) {
            $post_structure .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3ZM12.0003 19C16.2359 19 19.8603 16.052 20.7777 12C19.8603 7.94803 16.2359 5 12.0003 5C7.7646 5 4.14022 7.94803 3.22278 12C4.14022 16.052 7.7646 19 12.0003 19ZM12.0003 16.5C9.51498 16.5 7.50026 14.4853 7.50026 12C7.50026 9.51472 9.51498 7.5 12.0003 7.5C14.4855 7.5 16.5003 9.51472 16.5003 12C16.5003 14.4853 14.4855 16.5 12.0003 16.5ZM12.0003 14.5C13.381 14.5 14.5003 13.3807 14.5003 12C14.5003 10.6193 13.381 9.5 12.0003 9.5C10.6196 9.5 9.50026 10.6193 9.50026 12C9.50026 13.3807 10.6196 14.5 12.0003 14.5Z"></path></svg>';
            $post_structure .= '{view}';
        } elseif ($meta_type === 'date') {
            $post_structure .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z"></path></svg>';
            $post_structure .= '{date_d_m}';
        }
        $post_structure .= '</div></div></div>'; // END .meta-holder // END .meta // END .thumb-holder

        $post_structure .= '<div class="post-infos dfx dir-v">';
        $post_structure .= '<a href="{link}" title="{title}" class="post-title dfx"><h2 class="ellipsis-1">{title}</h2></a>';
        $post_structure .= '<p>{excerpt}</p>';
        $post_structure .= '</div>'; // END .post-infos
        $post_structure .= '</div>'; // END .post-item
        return $post_structure;
    }


    protected function printQuery($settings, $query)
    {
        $thumb_size = $settings['image-dimensions_size'];
        $meta_type  = $settings['meta-type'];

        $meta_place_svg = '<svg class="meta-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 383.35 75.04"><g><g><path d="M383.35,75a33.22,33.22,0,0,1-27.07-14.13L330,23.44A55.1,55.1,0,0,0,284.86,0H98.48a55.13,55.13,0,0,0-45.1,23.44L27.06,60.91A33.18,33.18,0,0,1,0,75Z"/></g></g></svg>';

        while ($query->have_posts()) {
            $query->the_post();
            $link  = get_the_permalink();
            $title = get_the_title();
            ?>
            <div <?php post_class(['post-item', 'd-grid']); ?>>

                <div class="thumb-holder">
                    <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail($thumb_size, ['class' => 'post-thumbnail']);
                    } else {
                        echo '<img src="' . AE_E_IMG_DIR . 'placeholder-1.svg' . '" alt="' . get_the_title() . '" class="post-thumbnail">';
                    }
                    ?>
                    <div class="meta-holder dfx aic jcc">
                        <?php echo $meta_place_svg; ?>
                        <div class="meta dfx aic ae-gap-5">
                            <?php
                            if ($meta_type === 'comment') {
                                echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6.45455 19L2 22.5V4C2 3.44772 2.44772 3 3 3H21C21.5523 3 22 3.44772 22 4V18C22 18.5523 21.5523 19 21 19H6.45455ZM5.76282 17H20V5H4V18.3851L5.76282 17ZM11 10H13V12H11V10ZM7 10H9V12H7V10ZM15 10H17V12H15V10Z"></path></svg>';
                                comments_number();
                            } elseif ($meta_type === 'view' && function_exists('the_views')) {
                                echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3ZM12.0003 19C16.2359 19 19.8603 16.052 20.7777 12C19.8603 7.94803 16.2359 5 12.0003 5C7.7646 5 4.14022 7.94803 3.22278 12C4.14022 16.052 7.7646 19 12.0003 19ZM12.0003 16.5C9.51498 16.5 7.50026 14.4853 7.50026 12C7.50026 9.51472 9.51498 7.5 12.0003 7.5C14.4855 7.5 16.5003 9.51472 16.5003 12C16.5003 14.4853 14.4855 16.5 12.0003 16.5ZM12.0003 14.5C13.381 14.5 14.5003 13.3807 14.5003 12C14.5003 10.6193 13.381 9.5 12.0003 9.5C10.6196 9.5 9.50026 10.6193 9.50026 12C9.50026 13.3807 10.6196 14.5 12.0003 14.5Z"></path></svg>';
                                echo (int)get_post_meta(get_the_ID(), 'views', true);
                            } elseif ($meta_type === 'date') {
                                echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z"></path></svg>';
                                echo get_the_date('d M');
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="post-infos dfx dir-v">
                    <a href="<?php echo esc_url($link); ?>" title="<?php esc_html_e($title); ?>"
                       class="post-title dfx">
                        <h2 class="ellipsis-1"><?php esc_html_e($title); ?></h2>
                    </a>
                    <?php the_excerpt(); ?>
                </div>
            </div>
        <?php }

        if (!$query->have_posts()) {
            $this->QueryNotHavePostsMessage();
        }

        wp_reset_postdata();
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_PostsSlider4());
