<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_FUNCTIONS;
use AE_E_UTILS;
use WP_Query;
use WP_ACTIVE_WE_QueryBuilder;

class WP_ACTIVE_WE_PostsColumn extends Widget_Base
{

    use WP_ACTIVE_WE_QueryBuilder;

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-posts-column', AE_E_CSS_DIR . 'posts-column.css');
        return ['wp-active-we-posts-column'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'پست های ستونی';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-post-list';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);
        AE_E_UTILS::IMAGE_SIZE($this, 'post-image', 'medium_large');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'row-gap', 'فاصله بین عمودی', 0, 50, null,
            '.posts-column', 'row-gap');

        AE_E_UTILS::SWITCH_FIELD($this, 'use-ajax', 'لود ایجکسی');
        AE_E_UTILS::SELECT_FIELD($this, 'ajax-loading-type', 'زمان اجرای ایجکس', [
            'scroll'  => 'هنگام رسیدن به پست',
            'timeout' => 'به محض لود صفحه'
        ], 'scroll', 'use-ajax', 'yes');

        AE_E_UTILS::SWITCH_FIELD($this, 'show-view', 'بازدید');
        AE_E_UTILS::SWITCH_FIELD($this, 'show-date', 'تاریخ');

        $this->end_controls_section();

        $this->QuerySettings();


        $this->register_controls_styles();

        $this->QueryNotHavePostsStyle();

    }

    protected function register_controls_styles()
    {

        // box styles
        AE_E_UTILS::SECTION_START($this, 'item-box-style', 'آیتم', 'style');

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
        }

        $this->add_render_attribute('post-grid-container', 'class', ['wp-active-we-posts-column']);

        ?>
        <div <?php $this->print_render_attribute_string('post-grid-container'); ?>>
            <?php
            if ($use_ajax) {
                echo '<ul class="posts-column d-grid">';
                for ($i = 0; $i < $posts_per_page; $i++) {
                    $this->placeholder();
                }
                echo '</ul>';
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
        $this->add_render_attribute('post-grid-container', 'data-post-structure', json_encode($this->postStructure($settings)));
        $this->add_render_attribute('post-grid-container', 'data-ajax-result-place', '.elementor-element-' . $this->get_id() . ' .wp-active-we-posts-column .posts-column');

        $widget_data = [
            'wid' => $this->get_id(),
            'post_class' => 'post-item',
            'image_size' => $settings['post-image_size'],
            'image_class' => 'post-thumbnail'
        ];

        $this->add_render_attribute('post-grid-container', 'data-widget-data', json_encode($widget_data));
    }

    protected function placeholder()
    {
        ?>
        <li class="post-item placeholder animated-placeholder">
            <span class="image-holder dfx skeleton-bg"></span>
            <div class="details">
                <span class="title skeleton-bg dfx w100 h20"></span>
                <span class="date skeleton-bg mt-1 w50px h12"></span>
                <span class="view skeleton-bg mt-1 w50px h12"></span>
            </div>
        </li>
        <?php
    }

    protected function postStructure($settings)
    {
        $date = $settings['show-date'];
        $view = $settings['show-view'];

        $post_structure = '<li class="{post_class}">';
        $post_structure .= '{thumbnail}';
        $post_structure .= '<div class="details">';
        $post_structure .= '<a href="{link}" title="{title}"><h2>{title}</h2></a>';
        $post_structure .= '<div class="view-date dfx mt-1">';
        if ($date === 'yes') {
            $post_structure .= '<span class="date">' . __('Date', 'wp-active-widgets-elementor') . ': {date_full}</span>';
        }
        if ($view === 'yes') {
            $post_structure .= '<span class="view">' . __('View', 'wp-active-widgets-elementor') . ': {view}</span>';
        }
        $post_structure .= '</div>'; // END view-date
        $post_structure .= '</div>'; // END details
        $post_structure .= '</li>'; // END post-item

        return $post_structure;
    }

    protected function printQuery($settings, $query)
    {
        $img_size = $settings['post-image_size'];
        $view = $settings['show-view'];
        $date = $settings['show-date'];

        if ($query->have_posts()) {
        echo '<ul class="posts-column d-grid">';
        while ($query->have_posts()) {
            $query->the_post();

            $title = get_the_title();

            ?>

            <li <?php post_class('post-item'); ?>>

                <?php AE_E_FUNCTIONS::thePostThumbnail($img_size); ?>
                <div class="details">
                    <a href="<?php the_permalink(); ?>" title="<?php esc_html_e($title); ?>">
                        <h2><?php esc_html_e($title); ?></h2>
                    </a>
                    <div class="view-date mt-1">
                        <?php if ($date) { ?>
                            <span class="date"><?php echo __('Date', 'wp-active-widgets-elementor') . ': ' . get_the_date(); ?></span>
                        <?php }
                        if ($view && AE_E_FUNCTIONS::isActiveViews()) { ?>
                            <span class="view"><?php echo __('View', 'wp-active-widgets-elementor') . ': ' . AE_E_FUNCTIONS::getPostViews(); ?></span>
                        <?php } ?>
                    </div>
                </div>

            </li>

            <?php
        }
        echo '</ul>';

        } else {
            echo '<p class="no-post-found">';
            echo !empty($settings['no_post_found']) ? $settings['no_post_found'] : __('No article found!', 'wp-active-widgets-elementor');
            echo '</p>';
        }

        wp_reset_postdata();
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_PostsColumn());
