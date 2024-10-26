<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;
use WP_Query;
use WP_ACTIVE_WE_QueryBuilder;

class WP_ACTIVE_WE_PostsGrid2 extends Widget_Base{

    use WP_ACTIVE_WE_QueryBuilder;

    public function get_script_depends()
    {
        return ['wp-active-we-intro-animation'];
    }

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-posts-grid-2', AE_E_CSS_DIR . 'posts-grid-2.css');
        return ['wp-active-we-posts-grid-2'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'پست های گرید بندی 2';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-gallery-grid';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);
        AE_E_UTILS::IMAGE_SIZE($this, 'post-image', 'medium_large');
        $this->add_responsive_control('post-columns', [
                'label'       => 'تعداد ستون',
                'type'        => Controls_Manager::NUMBER,
                'label_block' => false,
                'min'         => 1,
                'max'         => 5,
                'step'        => 1,
                'selectors'   => [
                    '{{WRAPPER}} .wp-active-we-posts-grid' => 'grid-template-columns: repeat({{SIZE}}, 1fr)',
                ],
            ]);
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'columns-gap', 'فاصله بین افقی', 0, 50, null, '.wp-active-we-posts-grid', 'column-gap');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'row-gap', 'فاصله بین عمودی', 0, 50, null, '.wp-active-we-posts-grid', 'row-gap');

        AE_E_UTILS::SWITCH_FIELD($this, 'use-ajax', 'لود ایجکسی');
        AE_E_UTILS::SELECT_FIELD($this, 'ajax-loading-type', 'زمان اجرای ایجکس', [
            'scroll'  => 'هنگام رسیدن به پست',
            'timeout' => 'به محض لود صفحه'
        ], 'scroll', 'use-ajax', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'intro-animation', 'انیمیشن ورود');

        $this->end_controls_section();

        $this->QuerySettings();


        $this->register_controls_styles();

        $this->QueryNotHavePostsStyle();

    }

    protected function register_controls_styles()
    {

        // box styles
        AE_E_UTILS::SECTION_START($this, 'item-box-style', 'آیتم', 'style');
        AE_E_UTILS::TAB_START($this, 'post-item');
        AE_E_UTILS::DynamicStyleControls($this, 'item-normal', '.wp-active-we-posts-grid .post-item', [
            'padding',
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::TAB_MIDDLE($this, 'post-item');
        AE_E_UTILS::DynamicStyleControls($this, 'item-hover', '.wp-active-we-posts-grid .post-item:hover', [
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);
        AE_E_UTILS::SECTION_END($this);


        // image
        AE_E_UTILS::SECTION_START($this, 'image-styles', 'تصویر', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'image-height', 'ارتفاع', 150, 300, null, '.wp-active-we-posts-grid .post-item .thumbnail-box .image-holder', 'height');
        AE_E_UTILS::DynamicStyleControls($this, 'image-styles', '.wp-active-we-posts-grid .post-item .thumbnail-box .image-holder', [
            'padding',
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::SECTION_END($this);


        // title
        AE_E_UTILS::SECTION_START($this, 'title-styles', 'عنوان', 'style');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'title-distances', 'فاصله', '.wp-active-we-posts-grid .post-item .title', 'margin');
        AE_E_UTILS::TextUtils($this, 'title', '.wp-active-we-posts-grid .post-item .title', true);
        AE_E_UTILS::SECTION_END($this);


        // date
        AE_E_UTILS::SECTION_START($this, 'date-styles', 'تاریخ', 'style');
        AE_E_UTILS::DynamicStyleControls($this, 'date-styles', '.wp-active-we-posts-grid .post-item .date', [
            'padding',
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::Separator($this, 'date-d', 'روز');
        AE_E_UTILS::TextUtils($this, 'date-d', '.wp-active-we-posts-grid .post-item .date .d');
        AE_E_UTILS::Separator($this, 'date-m', 'ماه');
        AE_E_UTILS::TextUtils($this, 'date-m', '.wp-active-we-posts-grid .post-item .date .m');
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $use_ajax = $settings['use-ajax'];
        $query = null;
        $posts_per_page = 0;
        if ($use_ajax === 'yes') {
            $posts_per_page = $settings['posts_per_page'];
            $this->ajaxify($settings);
        } else {
            $query_args = $this->QueryArgBuilder();
            $query = new WP_Query($query_args);

            if (!$query->have_posts()) {
                $this->add_render_attribute('post-grid-container', 'class', 'grid-one-col');
            }
        }

        $this->add_render_attribute('post-grid-container', 'class', ['wp-active-we-posts-grid', 'd-grid']);
        if ($settings['intro-animation'] === 'yes') {
            $this->add_render_attribute('post-grid-container', 'class', 'active-animation');
            $this->add_render_attribute('post-grid-container', 'data-animation-target', '.elementor-element-' . $this->get_id() . ' .post-item');
            $this->add_render_attribute('post-grid-container', 'data-animation-offset', '100');
        }

        ?>
        <div <?php $this->print_render_attribute_string('post-grid-container'); ?>>
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
        $this->add_render_attribute('post-grid-container', 'class', 'wp-active-we-ajax-container');
        $this->add_render_attribute('post-grid-container', 'data-query-args', json_encode($query_args));
        $this->add_render_attribute('post-grid-container', 'data-ajax-type', $settings['ajax-loading-type']);
        $this->add_render_attribute('post-grid-container', 'data-ajax-status', 'before_start');
        $this->add_render_attribute('post-grid-container', 'data-post-structure', json_encode($this->postStructure()));
        $this->add_render_attribute('post-grid-container', 'data-ajax-result-place', '.elementor-element-' . $this->get_id() . ' .wp-active-we-posts-grid');

        $widget_data = [
            'wid'         => $this->get_id(),
            'post_class'  => 'post-item',
            'image_size'  => $settings['post-image_size'],
            'image_class' => 'post-thumbnail'
        ];
        if ($settings['intro-animation'] === 'yes') {
            $widget_data['post_class'] .= ' item-has-intro-animation';
        }
        $this->add_render_attribute('post-grid-container', 'data-widget-data', json_encode($widget_data));
    }

    protected function placeholder()
    {
        ?>
        <div class="post-item placeholder animated-placeholder">
            <div class="thumbnail-box dfx"><span class="image-holder dfx w100 skeleton-bg"></span></a></div>
            <span class="dfx w100 title skeleton-bg h20"></span>
        </div>

        <?php
    }

    protected function postStructure()
    {
        $post_structure = '<div class="{post_class}">';
        $post_structure .= '<div class="thumbnail-box">';
        $post_structure .= '<a href="{link}" title="{title}" class="image-holder">{thumbnail}</a>';
        $post_structure .= '<div class="date dfx dir-v aic jcc"><b class="d">{date_d}</b><span class="m">{date_M}</span></div>'; // END data
        $post_structure .= '</div>';                                                                                             // END thumbnail-box
        $post_structure .= '<a href="{link}" title="{title}" class="title">{title}</a>';
        $post_structure .= '</div>'; // END post-item

        return $post_structure;
    }

    protected function printQuery($settings, $query)
    {
        $img_size = $settings['post-image_size'];

        while ($query->have_posts()) {
            $query->the_post();

            $title = get_the_title();
            $link = get_the_permalink();

            ?>

            <div <?php post_class('post-item'); ?>>

                <div class="thumbnail-box">
                    <a href="<?php echo esc_url($link); ?>"
                       title="<?php esc_html_e($title); ?>" class="image-holder">
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail($img_size, ['class' => 'post-thumbnail']);
                        } else {
                            echo '<img src="' . AE_E_IMG_DIR . 'placeholder-1.svg' . '" alt="' . get_the_title() . '" class="post-thumbnail">';
                        }
                        ?>
                    </a>

                    <div class="date dfx dir-v aic jcc">
                        <b class="d"><?php echo get_the_date('d'); ?></b>
                        <span class="m"><?php echo get_the_date('M'); ?></span>
                    </div>

                </div>

                <a href="<?php echo esc_url($link); ?>" title="<?php esc_html_e($title); ?>" class="title">
                    <?php esc_html_e($title); ?>
                </a>

            </div>

            <?php
        }

        if (!$query->have_posts()) {
            $this->QueryNotHavePostsMessage();
        }

        wp_reset_postdata();
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_PostsGrid2());
