<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_FUNCTIONS;
use AE_E_UTILS;
use WP_Query;
use WP_ACTIVE_WE_QueryBuilder;
use WP_ACTIVE_WE_OwlCarousel;

class WP_ACTIVE_WE_PostsSlider1 extends Widget_Base{

    use WP_ACTIVE_WE_QueryBuilder;
    use WP_ACTIVE_WE_OwlCarousel;

    public function get_script_depends()
    {
        return ['jquery', 'owl-js', 'wp-active-we-owl-slider', 'wp-active-we-intro-animation'];
    }

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-posts-slider-1', AE_E_CSS_DIR . 'posts-slider-1.css');
        return ['owl-css', 'owl-theme-default', 'wp-active-we-posts-slider-1'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'اسلایدر پست ها 1';
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

        $fields = new \Elementor\Repeater();
        AE_E_UTILS::TXT_FIELD($fields, 'title', 'عنوان', 'عنوان', true);
        AE_E_UTILS::TXT_FIELD($fields, 'key', 'کلید زمینه دلخواه', '');
        AE_E_UTILS::ICON($fields, 'field-');
        $this->add_control('custom-fields', [
            'label'         => 'فیلدهای دلخواه',
            'type'          => \Elementor\Controls_Manager::REPEATER,
            'fields'        => $fields->get_controls(),
            'title_field'   => '{{{ title }}}',
            'prevent_empty' => false,
        ]);

        $this->add_group_control(Group_Control_Image_Size::get_type(), [
            'name'      => 'image-dimensions',
            // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
            'default'   => 'medium_large',
            'separator' => 'none',
            'exclude'   => ['custom']
        ]);

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

        //Box
        AE_E_UTILS::SECTION_START($this, 'box-sec-style', 'آیتم', 'style');
        AE_E_UTILS::BoxUtils($this, 'item-box', '.post-item');
        AE_E_UTILS::SECTION_END($this);


        //image
        AE_E_UTILS::SECTION_START($this, 'image-sec-style', 'تصویر', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'image-height', 'ارتفاع', 100, 300, null, '.thumb-holder', 'height');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'image-border-radius', 'خمیدگی', '.thumb-holder', 'border-radius');
        AE_E_UTILS::SECTION_END($this);


        // title
        AE_E_UTILS::SECTION_START($this, 'title-sec-style', 'عنوان', 'style');
        AE_E_UTILS::NUMBER_FIELD_STYLE($this, 'item-title-line-clamp', 'تعداد خط', '.post-title a', '-webkit-line-clamp', 1, 3, 1, null);
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'item-title-line-height', 'ارتفاع', 20, 80, null, '.post-title a', 'height');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'item-title-padding', 'padding', '.post-title a', 'padding');
        AE_E_UTILS::TextUtils($this, 'item-title', '.post-title a', true);
        AE_E_UTILS::SECTION_END($this);


        // fields
        AE_E_UTILS::SECTION_START($this, 'fields-sec-style', 'فیلدهای دلخواه', 'style');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'fields-box-padding', 'فاصله داخلی باکس', '.custom-field', 'padding');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'fields-space', 'فاصله بین', 0, 30, null, '.custom-field', 'gap');
        AE_E_UTILS::Separator($this, 'field-icon', 'آیکون');
        AE_E_UTILS::IconUtilsLight($this, 'field-icon', '.icon');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'field-icon-distance', 'فاصله', 0, 30, 0, '.field-wrapper', 'gap');

        AE_E_UTILS::Separator($this, 'field-title', 'عنوان');
        AE_E_UTILS::TextUtils($this, 'field-title', '.custom-field li .field-title');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'field-title-distance', 'فاصله', 0, 30, 0, '.field-value-wrapper', 'gap');

        AE_E_UTILS::Separator($this, 'field-value', 'مقدار');
        AE_E_UTILS::TextUtils($this, 'field-value', '.custom-field li .field-value');

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
                $this->add_render_attribute('post-slider-1', 'class', 'wo-post');
            }
        }

        $slider_settings = $this->RenderOwlSettings();
        $this->add_render_attribute('post-slider-1', 'class', 'wp-active-we-posts-slider-1 slider-container owl-carousel');
        $this->add_render_attribute('post-slider-1', 'data-slider-settings', json_encode($slider_settings));
        if ($settings['intro-animation'] === 'yes') {
            $this->add_render_attribute('post-slider-1', 'class', 'active-animation');
            $this->add_render_attribute('post-slider-1', 'data-animation-target', '.elementor-element-' . $this->get_id() . ' .post-item');
            $this->add_render_attribute('post-slider-1', 'data-animation-offset', '100');
        }


        ?>
        <div <?php $this->print_render_attribute_string('post-slider-1'); ?>>

            <?php
            if ($use_ajax) {
                for ($i = 0; $i < $posts_per_page; $i++) {
                    $this->post_placeholder();
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
        $this->add_render_attribute('post-slider-1', 'class', 'wp-active-we-ajax-container');
        $this->add_render_attribute('post-slider-1', 'data-query-args', json_encode($query_args));
        $this->add_render_attribute('post-slider-1', 'data-ajax-type', $settings['ajax-loading-type']);
        $this->add_render_attribute('post-slider-1', 'data-ajax-status', 'before_start');
        $this->add_render_attribute('post-slider-1', 'data-post-structure', json_encode($this->post_structure()));
        $this->add_render_attribute('post-slider-1', 'data-ajax-result-place', '.elementor-element-' . $this->get_id() . ' .wp-active-we-posts-slider-1');

        $widget_data = [
            'wid'        => $this->get_id(),
            'post_class' => 'post-item',
            'image_size' => $settings['image-dimensions_size'],
        ];

        if ($settings['intro-animation'] === 'yes') {
            $widget_data['post_class'] .= ' item-has-intro-animation';
        }

        $fields = $settings['custom-fields'];
        if (!empty($fields)) {
            $widget_data['custom_fields'] = AE_E_FUNCTIONS::cfStructureForAjax($this, $fields);
        }

        $this->add_render_attribute('post-slider-1', 'data-widget-data', json_encode($widget_data));
    }


    protected function post_placeholder()
    {
        $custom_fields = $this->get_settings_for_display('custom-fields');

        ?>
        <div class="post-item placeholder animated-placeholder">
            <span class="image-holder dfx w100 skeleton-bg"></span>
            <span class="post-title dfx w100 skeleton-bg h20 mt10"></span>
            <?php
            if (!empty($custom_fields)) {
                foreach ($custom_fields as $custom_field) {
                    echo '<span class="meta-holder dfx w100 h12 mt3 skeleton-bg"></span>';
                }
            } ?>
        </div>
        <?php
    }


    protected function post_structure()
    {
        $post_structure = '<div class="{post_class}">';
        $post_structure .= '<a href="{link}" title="{title}" class="thumb-holder">';
        $post_structure .= '{thumbnail}';
        $post_structure .= '</a>';
        $post_structure .= '<h3 class="post-title">';
        $post_structure .= '<a href="{link}" title="{title}" class="ellipsis-1">{title}</a>';
        $post_structure .= '</h3>';
        $post_structure .= '{custom_fields}';
        $post_structure .= '</div>'; // END .post-item

        return $post_structure;
    }

    protected function print_query($settings, $query)
    {

        $thumb_size = $settings['image-dimensions_size'];

        ?>
        <?php
        while ($query->have_posts()) {
            $query->the_post();
            $link = get_the_permalink();
            $title = get_the_title();
            ?>

            <div <?php post_class('post-item'); ?>>
                <a href="<?php echo esc_url($link); ?>" title="<?php esc_html_e($title); ?>" class="thumb-holder">
                    <?php the_post_thumbnail($thumb_size); ?>
                </a>
                <h3 class="post-title">
                    <a href="<?php echo esc_url($link); ?>" title="<?php esc_html_e($title); ?>" class="ellipsis-1">
                        <?php esc_html_e($title); ?>
                    </a>
                </h3>
                <?php AE_E_FUNCTIONS::cfInLoop($this, $settings, get_the_ID()); ?>
            </div>

        <?php }

        if (!$query->have_posts()) {
            $this->QueryNotHavePostsMessage();
        }

        ?>

        <?php
        wp_reset_postdata();

    }

}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_PostsSlider1());
