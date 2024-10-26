<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_FUNCTIONS;
use AE_E_UTILS;
use WP_Query;
use WP_ACTIVE_WE_QueryBuilder;
use WP_ACTIVE_WE_OwlCarousel;

class WP_ACTIVE_WE_PostsSlider2 extends Widget_Base{

    use WP_ACTIVE_WE_QueryBuilder;
    use WP_ACTIVE_WE_OwlCarousel;

    public function get_script_depends()
    {
        return ['jquery', 'owl-js', 'wp-active-we-owl-slider', 'wp-active-we-intro-animation'];
    }

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-posts-slider-2', AE_E_CSS_DIR . 'posts-slider-2.css');
        return ['owl-css', 'owl-theme-default', 'wp-active-we-posts-slider-2'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'اسلایدر پست ها 2';
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

        $this->add_group_control(Group_Control_Image_Size::get_type(), [
            'name'      => 'image-dimensions',
            // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
            'default'   => 'medium_large',
            'separator' => 'none',
            'exclude'   => ['custom']
        ]);

        AE_E_UTILS::SWITCH_FIELD($this, 'has-excerpt', 'خلاصه', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'has-author', 'نویسنده', 'yes');
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

        $this->QueryNotHavePostsStyle();
    }

    protected function register_controls_styles()
    {

        // box item
        AE_E_UTILS::SECTION_START($this, 'box-style', 'آیتم', 'style');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'info-box-padding', 'فاصله داخلی باکس داخلی', '.post-infos', 'padding');

        AE_E_UTILS::TAB_START($this, 'post-item');
        AE_E_UTILS::DynamicStyleControls($this, 'item-normal', '.wp-active-we-posts-slider-2 .post-item', [
            'padding',
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::TAB_MIDDLE($this, 'post-item');
        AE_E_UTILS::DynamicStyleControls($this, 'item-hover', '.wp-active-we-posts-slider-2 .post-item:hover', [
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);
        AE_E_UTILS::SECTION_END($this);


        // image styles
        AE_E_UTILS::SECTION_START($this, 'image-style', 'تصویر', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'image-height', 'ارتفاع', 100, 300, null, '.wp-active-we-posts-slider-2 .post-item .image-holder', 'height');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'image-mb', 'فاصله', 0, 50, null, '.wp-active-we-posts-slider-2 .post-item .image-holder', 'margin-bottom');
        AE_E_UTILS::TAB_START($this, 'post-image');
        AE_E_UTILS::DynamicStyleControls($this, 'image-normal', '.wp-active-we-posts-slider-2 .post-item .image-holder', [
            'padding',
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::TAB_MIDDLE($this, 'post-image');
        AE_E_UTILS::DynamicStyleControls($this, 'image-hover', '.wp-active-we-posts-slider-2 .post-item:hover .image-holder', [
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);
        AE_E_UTILS::SECTION_END($this);


        // category styles
        AE_E_UTILS::SECTION_START($this, 'category-style', 'دسته بندی', 'style', 'has-category!', '');
        AE_E_UTILS::TextUtils($this, 'category', '.wp-active-we-posts-slider-2 .post-item .thumb-holder .category', true);
        AE_E_UTILS::DynamicStyleControls($this, 'category', '.wp-active-we-posts-slider-2 .post-item .thumb-holder .category', [
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::SECTION_END($this);


        // date & author
        AE_E_UTILS::SECTION_START($this, 'date-author-style', 'تاریخ و نویسنده', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'date-author-mb', 'فاصله', 0, 50, null, '.wp-active-we-posts-slider-2 .post-item .post-details', 'margin-bottom');
        AE_E_UTILS::FONT_FIELD($this, 'date-author-typography', 'تایپوگرافی', '.wp-active-we-posts-slider-2 .post-item .post-details');
        AE_E_UTILS::COLOR_FIELD($this, 'date-author-color', 'رنگ متن', '', '.wp-active-we-posts-slider-2 .post-item .post-details', 'color');
        AE_E_UTILS::COLOR_FIELD($this, 'date-author-icon-color', 'رنگ آیکون', '', '.wp-active-we-posts-slider-2 .post-item .post-details svg', 'fill');
        AE_E_UTILS::SECTION_END($this);


        // title styles
        AE_E_UTILS::SECTION_START($this, 'title-style', 'عنوان', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'title-mt', 'فاصله', 0, 50, null, '.wp-active-we-posts-slider-2 .post-item .post-title', 'margin-top');

        AE_E_UTILS::NUMBER_FIELD_STYLE($this, 'item-title-line-clamp', 'تعداد خط', '.post-item .post-title h2', '-webkit-line-clamp', 1, 3, 1, null);
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'item-title-line-height', 'ارتفاع', 20, 80, null, '.post-item .post-title h2', 'height');

        AE_E_UTILS::TextUtils($this, 'title', '.wp-active-we-posts-slider-2 .post-item .post-title h2');
        AE_E_UTILS::COLOR_FIELD($this, 'title_color_normal_box_hover', 'رنگ عادی در هاور باکس', '', '.wp-active-we-posts-slider-2 .post-item:hover .post-title', 'color');
        AE_E_UTILS::COLOR_FIELD($this, 'title_color_hover', 'رنگ هاور', '', '.wp-active-we-posts-slider-2 .post-item:hover .post-title:hover', 'color');
        AE_E_UTILS::SECTION_END($this);


        // excerpt styles
        AE_E_UTILS::SECTION_START($this, 'excerpt-style', 'خلاصه', 'style', 'has-excerpt!', '');
        AE_E_UTILS::NUMBER_FIELD_STYLE($this, 'excerpt-lines', 'تعداد خط', '.wp-active-we-posts-slider-2 .post-item p', '-webkit-line-clamp', 2, 7, 1, null, true);
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'excerpt-mt', 'فاصله', 0, 50, null, '.wp-active-we-posts-slider-2 .post-item p', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'excerpt', '.wp-active-we-posts-slider-2 .post-item p');
        AE_E_UTILS::COLOR_FIELD($this, 'excerpt_color_hover', 'رنگ هاور', '', '.wp-active-we-posts-slider-2 .post-item:hover  p', 'color');
        AE_E_UTILS::SECTION_END($this);


        $this->OwlStylesNextPrevBtn();
        $this->OwlStylesDotSettings();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $use_ajax = $settings['use-ajax'];
        $query = null;
        $posts_per_page = $settings['posts_per_page'];
        if ($use_ajax === 'yes') {
            $this->ajaxify($settings);
        } else {
            $query_args = $this->QueryArgBuilder();
            $query = new WP_Query($query_args);

            if (!$query->have_posts()) {
                $this->add_render_attribute('post-slider-2', 'class', 'wo-post');
            }
        }

        $slider_settings = $this->RenderOwlSettings();
        $this->add_render_attribute('post-slider-2', 'class', 'wp-active-we-posts-slider-2 slider-container owl-carousel');
        $this->add_render_attribute('post-slider-2', 'data-slider-settings', json_encode($slider_settings));
        if ($settings['intro-animation'] === 'yes') {
            $this->add_render_attribute('post-slider-2', 'class', 'active-animation');
            $this->add_render_attribute('post-slider-2', 'data-animation-target', '.elementor-element-' . $this->get_id() . ' .post-item');
            $this->add_render_attribute('post-slider-2', 'data-animation-offset', '100');
        }

        ?>
        <div <?php $this->print_render_attribute_string('post-slider-2'); ?>>

            <?php
            if ($use_ajax) {
                for ($i = 0; $i < $posts_per_page; $i++) {
                    $this->post_placeholder($settings);
                }
            } else {
                $this->print_query($settings, $query);
            }
            ?>

        </div>
        <?php
    }


    protected function ajaxify($settings)
    {

        $query_args = $this->QueryArgBuilder();
        $this->add_render_attribute('post-slider-2', 'class', 'wp-active-we-ajax-container');
        $this->add_render_attribute('post-slider-2', 'data-query-args', json_encode($query_args));
        $this->add_render_attribute('post-slider-2', 'data-ajax-type', $settings['ajax-loading-type']);
        $this->add_render_attribute('post-slider-2', 'data-ajax-status', 'before_start');
        $this->add_render_attribute('post-slider-2', 'data-post-structure', json_encode($this->post_structure()));
        $this->add_render_attribute('post-slider-2', 'data-ajax-result-place', '.elementor-element-' . $this->get_id() . ' .wp-active-we-posts-slider-2');

        $widget_data = [
            'wid'         => $this->get_id(),
            'post_class'  => 'post-item',
            'image_size'  => $settings['image-dimensions_size'],
            'image_class' => 'post-thumbnail'
        ];
        if ($settings['intro-animation'] === 'yes') {
            $widget_data['post_class'] .= ' item-has-intro-animation';
        }
        $this->add_render_attribute('post-slider-2', 'data-widget-data', json_encode($widget_data));
    }


    protected function post_placeholder($settings)
    {
        ?>
        <div class="post-item placeholder animated-placeholder">
            <div class="thumb-holder"><span class="image-holder dfx w100 skeleton-bg"></span></div>
            <div class="post-infos">
                <div class="post-details dfx aic wrap ae-gap-15">
                    <span class="post-author dfx h20 skeleton-bg"></span>
                    <span class="post-date dfx h20 skeleton-bg"></span>
                </div>
                <span class="post-title ellipsis-1 dfx w100 skeleton-bg h20"></span>
                <?php if ($settings['has-excerpt'] === 'yes') { ?>
                    <span class="excerpt dfx w100 skeleton-bg h20 mt10"></span>
                    <span class="excerpt dfx w100 skeleton-bg h20 mt3"></span>
                    <span class="excerpt dfx w100 skeleton-bg h20 mt3"></span>
                    <span class="excerpt dfx w100 skeleton-bg h20 mt3"></span>
                <?php } ?>
            </div>
        </div>
        <?php
    }


    protected function post_structure()
    {
        $settings = $this->get_settings_for_display();
        $author = $settings['has-author'];
        $date = $settings['has-date'];
        $category = $settings['has-category'];
        $excerpt = $settings['has-excerpt'];


        $post_structure = '<div class="{post_class}">';
        $post_structure .= '<div class="thumb-holder"><a href="{link}" title="{title}" class="image-holder">{thumbnail}</a>';
        if ($category == 'yes') {
            $post_structure .= '<a href="{cat_link}" title="{cat_title}" class="category">{cat_title}</a>';
        }
        $post_structure .= '</div>'; // END .thumb-holder
        $post_structure .= '<div class="post-infos">';
        if ($author == 'yes' || $date == 'yes') {
            $post_structure .= '<div class="post-details dfx aic wrap ae-gap-15">';
            if ($author == 'yes') {
                $post_structure .= '<span class="post-author dfx aic ae-gap-5">';
                $post_structure .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 22H18V20C18 18.3431 16.6569 17 15 17H9C7.34315 17 6 18.3431 6 20V22H4V20C4 17.2386 6.23858 15 9 15H15C17.7614 15 20 17.2386 20 20V22ZM12 13C8.68629 13 6 10.3137 6 7C6 3.68629 8.68629 1 12 1C15.3137 1 18 3.68629 18 7C18 10.3137 15.3137 13 12 13ZM12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z"></path></svg>';
                $post_structure .= '{author}';
                $post_structure .= '</span>';
            }
            if ($date == 'yes') {
                $post_structure .= '<span class="post-date dfx aic ae-gap-5">';
                $post_structure .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM13 12H17V14H11V7H13V12Z"></path></svg>';
                $post_structure .= '{date_full}';
                $post_structure .= '</span>';
            }
            $post_structure .= '</div>'; // END .post-details
        }
        $post_structure .= '<a href="{link}" title="{title}" class="post-title dfx"><h2 class="ellipsis-1">{title}</h2></a>';
        if ($excerpt == 'yes') {
            $post_structure .= '<p>{excerpt}</p>';
        }
        $post_structure .= '</div>'; // END .post-infos

        $post_structure .= '</div>'; // END .post-item

        return $post_structure;
    }


    protected function print_query($settings, $query)
    {

        $thumb_size = $settings['image-dimensions_size'];
        $author = $settings['has-author'];
        $date = $settings['has-date'];
        $category = $settings['has-category'];
        $excerpt = $settings['has-excerpt'];

        while ($query->have_posts()) {
            $query->the_post();
            $link = get_the_permalink();
            $title = get_the_title();
            $term = AE_E_FUNCTIONS::getPostFirstCategory();
            ?>

            <div <?php post_class('post-item'); ?>>
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
                    <?php if ($author == 'yes' || $date == 'yes') { ?>
                        <div class="post-details dfx aic wrap ae-gap-15">
                            <?php if ($author == 'yes') { ?>
                                <span class="post-author dfx aic ae-gap-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M20 22H18V20C18 18.3431 16.6569 17 15 17H9C7.34315 17 6 18.3431 6 20V22H4V20C4 17.2386 6.23858 15 9 15H15C17.7614 15 20 17.2386 20 20V22ZM12 13C8.68629 13 6 10.3137 6 7C6 3.68629 8.68629 1 12 1C15.3137 1 18 3.68629 18 7C18 10.3137 15.3137 13 12 13ZM12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z"></path>
                                    </svg>
                                    <?php esc_html_e(get_the_author_meta('nickname')); ?>
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

                    <a href="<?php echo esc_url($link); ?>" title="<?php esc_html_e($title); ?>" class="post-title dfx">
                        <h2 class="ellipsis-1"><?php esc_html_e($title); ?></h2>
                    </a>

                    <?php
                    if ($excerpt == 'yes') {
                        the_excerpt();
                    }
                    ?>
                </div>

            </div>

        <?php }

        if (!$query->have_posts()) {
            $this->QueryNotHavePostsMessage();
        }

        wp_reset_postdata();
    }

}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_PostsSlider2());
