<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;
use WP_Query;
use WP_ACTIVE_WE_QueryBuilder;
use WP_ACTIVE_WE_OwlCarousel;
use AE_E_FUNCTIONS;

class WP_ACTIVE_WE_PostsSlider3 extends Widget_Base
{

    use WP_ACTIVE_WE_QueryBuilder;
    use WP_ACTIVE_WE_OwlCarousel;

    public function get_script_depends()
    {
        return ['owl-js', 'wp-active-we-owl-slider', 'wp-active-we-intro-animation'];
    }

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-posts-slider-3', AE_E_CSS_DIR . 'posts-slider-3.css');
        return ['owl-css', 'owl-theme-default', 'wp-active-we-posts-slider-3'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'اسلایدر پست ها 3';
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

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image-dimensions',
                // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
                'default'   => 'medium_large',
                'separator' => 'none',
                'exclude'   => ['custom']
            ]
        );

        AE_E_UTILS::NUMBER_FIELD_STYLE($this,'excerpt-lines','تعداد خط خلاصه','.wp-active-we-posts-slider-3 .post-item p','-webkit-line-clamp',3,10,1,null);

        AE_E_UTILS::SWITCH_FIELD($this, 'has-comment', 'نظر', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'has-date', 'تاریخ', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'has-category', 'دسته بندی', 'yes');

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
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'image-height', 'ارتفاع', 200, 400, null,
            '.wp-active-we-posts-slider-3 .post-item .image-holder', 'height');
        AE_E_UTILS::DynamicStyleControls($this, 'item', '.wp-active-we-posts-slider-3 .post-item', [
            'bg', 'border', 'shadow'
        ]);
        AE_E_UTILS::SHADOW_FIELD($this, 'item-shadow_hover', 'سایه هاور', '.wp-active-we-posts-slider-3 .post-item:hover');
        $this->add_responsive_control(
            'item-border-radius',
            [
                'label'     => 'خمیدگی',
                'type'      => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wp-active-we-posts-slider-3 .post-item'               => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px',
                    '{{WRAPPER}} .wp-active-we-posts-slider-3 .post-item .thumb-holder' => 'border-radius: 0 {{RIGHT}}px {{BOTTOM}}px 0',
                ]
            ]
        );
        AE_E_UTILS::SECTION_END($this);


        // category styles
        AE_E_UTILS::SECTION_START($this, 'category-style', 'دسته بندی', 'style', 'has-category!', '');
        AE_E_UTILS::TextUtils($this, 'category', '.wp-active-we-posts-slider-3 .post-item .thumb-holder .category', true);
        AE_E_UTILS::DynamicStyleControls($this, 'category', '.wp-active-we-posts-slider-3 .post-item .thumb-holder .category', [
            'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::SECTION_END($this);


        // date & comment
        AE_E_UTILS::SECTION_START($this, 'date-comment-style', 'تاریخ و نظرات', 'style');
        AE_E_UTILS::TextUtils($this, 'date-comment', '.wp-active-we-posts-slider-3 .post-item .post-details');
        AE_E_UTILS::COLOR_FIELD($this, 'date-comment-icon-color', 'رنگ آیکون', '', '.wp-active-we-posts-slider-3 .post-item .post-details svg', 'fill');
        AE_E_UTILS::SECTION_END($this);


        // title styles
        AE_E_UTILS::SECTION_START($this, 'title-style', 'عنوان', 'style');
        AE_E_UTILS::TextUtils($this, 'title', '.wp-active-we-posts-slider-3 .post-item .post-title h2');
        AE_E_UTILS::COLOR_FIELD($this, 'title_color_hover', 'رنگ هاور', '', '.wp-active-we-posts-slider-3 .post-item .post-title:hover h2', 'color');
        AE_E_UTILS::SECTION_END($this);


        // excerpt styles
        AE_E_UTILS::SECTION_START($this, 'excerpt-style', 'خلاصه', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'excerpt-mt', 'فاصله', 0, 50, null,
            '.wp-active-we-posts-slider-3 .post-item p', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'excerpt', '.wp-active-we-posts-slider-3 .post-item p');
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
                $this->add_render_attribute('post-slider-3', 'class', 'wo-post');
            }
        }

        $slider_settings = $this->RenderOwlSettings();
        $this->add_render_attribute('post-slider-3', 'class', 'wp-active-we-posts-slider-3 slider-container owl-carousel');
        $this->add_render_attribute('post-slider-3', 'data-slider-settings', json_encode($slider_settings));
        if ($settings['intro-animation'] === 'yes') {
            $this->add_render_attribute('post-slider-3', 'class', 'active-animation');
            $this->add_render_attribute('post-slider-3', 'data-animation-target', '.elementor-element-' . $this->get_id() . ' .post-item');
            $this->add_render_attribute('post-slider-3', 'data-animation-offset', '100');
        }

        ?>
        <div <?php $this->print_render_attribute_string('post-slider-3'); ?>>
            <?php
            if ($use_ajax) {
                for ($i = 0; $i < $posts_per_page; $i++) {
                    $this->placeholder($settings);
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
        $this->add_render_attribute('post-slider-3', 'class', 'wp-active-we-ajax-container');
        $this->add_render_attribute('post-slider-3', 'data-query-args', json_encode($query_args));
        $this->add_render_attribute('post-slider-3', 'data-ajax-type', $settings['ajax-loading-type']);
        $this->add_render_attribute('post-slider-3', 'data-ajax-status', 'before_start');
        $this->add_render_attribute('post-slider-3', 'data-post-structure', json_encode($this->postStructure($settings)));
        $this->add_render_attribute('post-slider-3', 'data-ajax-result-place', '.elementor-element-' . $this->get_id() . ' .wp-active-we-posts-slider-3');

        $widget_data = [
            'wid'         => $this->get_id(),
            'post_class'  => 'post-item d-grid',
            'image_size'  => $settings['image-dimensions_size'],
            'image_class' => 'post-thumbnail'
        ];
        if ($settings['intro-animation'] === 'yes') {
            $widget_data['post_class'] .= ' item-has-intro-animation';
        }
        $this->add_render_attribute('post-slider-3', 'data-widget-data', json_encode($widget_data));
    }


    protected function placeholder($settings)
    {
        $comment = $settings['has-comment'];
        $date    = $settings['has-date'];
        ?>
        <div class="post-item d-grid placeholder animated-placeholder">
            <div class="thumb-holder"><span class="image-holder dfx w100 skeleton-bg"></span></div>

            <div class="post-infos">

                <span class="post-title dfx w100 h20 skeleton-bg"></span>
                <span class="post-title dfx w100 h20 skeleton-bg mt3"></span>

                <?php if ($comment == 'yes' || $date == 'yes') { ?>
                    <div class="post-details dfx aic wrap ae-gap-15">
                        <?php if ($comment == 'yes') { ?>
                            <span class="post-comment dfx w100 h20 skeleton-bg"></span>
                        <?php } ?>
                        <?php if ($date == 'yes') { ?>
                            <span class="post-date dfx w100 h20 skeleton-bg"></span>
                        <?php } ?>
                    </div>
                <?php } ?>

            </div>
        </div>
        <?php
    }


    protected function postStructure($settings)
    {

        $comment  = $settings['has-comment'];
        $date     = $settings['has-date'];
        $category = $settings['has-category'];


        $post_structure = '<div class="{post_class}">';
        $post_structure .= '<div class="thumb-holder">';
        $post_structure .= '<a href="{link}" title="{title}" class="image-holder">{thumbnail}</a>';
        if ($category == 'yes') {
            $post_structure .= '<a href="{cat_link}" title="{cat_title}" class="category">{cat_title}</a>';
        }
        $post_structure .= '</div>'; // END .thumb-holder
        $post_structure .= '<div class="post-infos">';
        $post_structure .= '<a href="{link}" title="{title}" class="post-title dfx"><h2>{title}</h2><br><br></a>';
        $post_structure .= '<p>{excerpt}</p>';

        if ($comment == 'yes' || $date == 'yes') {
            $post_structure .= '<div class="post-details dfx aic wrap ae-gap-15">';
            if ($comment == 'yes') {
                $post_structure .= '<span class="post-comment dfx aic ae-gap-5">';
                $post_structure .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6.45455 19L2 22.5V4C2 3.44772 2.44772 3 3 3H21C21.5523 3 22 3.44772 22 4V18C22 18.5523 21.5523 19 21 19H6.45455ZM5.76282 17H20V5H4V18.3851L5.76282 17ZM11 10H13V12H11V10ZM7 10H9V12H7V10ZM15 10H17V12H15V10Z"></path></svg>';
                $post_structure .= '{comment}</span>';
            }

            if ($date == 'yes') {
                $post_structure .= '<span class="post-date dfx aic ae-gap-5">';
                $post_structure .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM13 12H17V14H11V7H13V12Z"></path></svg>';
                $post_structure .= '{date_full}</span>';
            }
            $post_structure .= '</div>'; // END .post-details
        }
        $post_structure .= '</div>'; // END .post-infos

        $post_structure .= '</div>'; // END .post-item


        return $post_structure;
    }


    protected function printQuery($settings, $query)
    {
        $thumb_size = $settings['image-dimensions_size'];
        $comment    = $settings['has-comment'];
        $date       = $settings['has-date'];
        $category   = $settings['has-category'];

        while ($query->have_posts()) {
            $query->the_post();
            $link  = get_the_permalink();
            $title = get_the_title();
            $term  = AE_E_FUNCTIONS::getPostFirstCategory();
            ?>

            <div <?php post_class(['post-item', 'd-grid']); ?>>
                <div class="thumb-holder">
                    <a href="<?php echo esc_url($link); ?>" title="<?php esc_html_e($title); ?>"
                       class="image-holder">
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail($thumb_size, ['class' => 'post-thumbnail']);
                        } else {
                            echo '<img src="' . AE_E_IMG_DIR . 'placeholder-1.svg' . '" alt="' . get_the_title() . '" class="post-thumbnail">';
                        }
                        ?>
                    </a>
                    <?php if ($category == 'yes' && !empty($term)) { ?>
                        <a href="<?php echo get_term_link($term->term_id); ?>"
                           title="<?php esc_html_e($term->name); ?>" class="category">
                            <?php esc_html_e($term->name); ?>
                        </a>
                    <?php } ?>
                </div>

                <div class="post-infos">

                    <a href="<?php echo esc_url($link); ?>" title="<?php esc_html_e($title); ?>"
                       class="post-title dfx">
                        <h2><?php esc_html_e($title); ?></h2>
                        <br>
                        <br>
                    </a>

                    <?php the_excerpt(); ?>

                    <?php if ($comment == 'yes' || $date == 'yes') { ?>
                        <div class="post-details dfx aic wrap ae-gap-15">
                            <?php if ($comment == 'yes') { ?>
                                <span class="post-comment dfx aic ae-gap-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M6.45455 19L2 22.5V4C2 3.44772 2.44772 3 3 3H21C21.5523 3 22 3.44772 22 4V18C22 18.5523 21.5523 19 21 19H6.45455ZM5.76282 17H20V5H4V18.3851L5.76282 17ZM11 10H13V12H11V10ZM7 10H9V12H7V10ZM15 10H17V12H15V10Z"></path>
                                    </svg>
                                    <?php comments_number(); ?>
                                </span>
                            <?php } ?>
                            <?php if ($date == 'yes') { ?>
                                <span class="post-date dfx aic ae-gap-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM13 12H17V14H11V7H13V12Z"></path>
                                    </svg>
                                    <?php esc_html_e(get_the_date('y/m/d')); ?>
                                </span>
                            <?php } ?>
                        </div>
                    <?php } ?>

                </div>
            </div>
        <?php }

        if (!$query->have_posts()) {
            $this->QueryNotHavePostsMessage();
        }

        wp_reset_postdata();
    }

}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_PostsSlider3());
