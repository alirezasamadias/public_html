<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;
use WP_Query;
use AE_E_FUNCTIONS;
use WP_ACTIVE_WE_QueryBuilder;
use WP_ACTIVE_WE_QueryFilters;

class WP_ACTIVE_WE_ProjectsGallery3 extends Widget_Base
{

    use WP_ACTIVE_WE_QueryBuilder;
    use WP_ACTIVE_WE_QueryFilters;

    public function get_script_depends()
    {
        return ['jquery', 'wp-active-we-projects-gallery-filter', 'wp-active-we-intro-animation'];
    }

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-projects-gallery-3', AE_E_CSS_DIR . 'projects-gallery-3.css');
        return ['wp-active-we-projects-gallery-3'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'گالری پروژه 3';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-gallery-grid';
    }

    public function get_categories()
    {
        return [AE_E_PLUGIN_NAME];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        $this->FilterSettings();

        AE_E_UTILS::IMAGE_SIZE($this, 'projects-gallery-image-size');

        $this->add_responsive_control(
            'gallery-columns',
            [
                'label'       => 'تعداد ستون',
                'type'        => Controls_Manager::NUMBER,
                'label_block' => false,
                'min'         => 1,
                'max'         => 5,
                'step'        => 1,
                'default'     => 4,
                'selectors'   => [
                    '{{WRAPPER}} .wp-active-we-projects-gallery-3 .projects-inner' => 'grid-template-columns: repeat({{SIZE}}, 1fr)',
                ],
            ]
        );
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'columns-gap', 'فاصله بین افقی', 0, 100, null,
            '.wp-active-we-projects-gallery-3 .projects-inner', 'column-gap');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'row-gap', 'فاصله بین عمودی', 0, 100, null,
            '.wp-active-we-projects-gallery-3 .projects-inner', 'row-gap');

        AE_E_UTILS::SWITCH_FIELD($this, 'use-ajax', 'لود ایجکسی');
        AE_E_UTILS::SELECT_FIELD($this, 'ajax-loading-type', 'زمان اجرای ایجکس', [
            'scroll'  => 'هنگام رسیدن به پست',
            'timeout' => 'به محض لود صفحه'
        ], 'scroll', 'use-ajax', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'intro-animation', 'انیمیشن ورود');

        $this->end_controls_section();

        // Query Settings
        $this->QuerySettings();
        $this->register_controls_styles();

        $this->QueryNotHavePostsStyle();

    }

    protected function register_controls_styles()
    {
        //filter style
        $this->FilterStyles();


        // item styles
        AE_E_UTILS::SECTION_START($this, 'item-style', 'آیتم', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'project-item-height', 'ارتفاع', 200, 400, null, '.wp-active-we-projects-gallery .project-item', 'height');

        AE_E_UTILS::TAB_START($this, 'project-item');
        AE_E_UTILS::DynamicStyleControls($this, 'project-item-normal', '.wp-active-we-projects-gallery .project-item', [
            'padding', 'bg', 'border', 'radius', 'shadow'
        ]);

        AE_E_UTILS::Separator($this, 'box-cover', 'روکش');
        AE_E_UTILS::BACKGROUND_WO_IMG_FIELD($this, 'box-cover', '.wp-active-we-projects-gallery-3 .project-item:before');
        AE_E_UTILS::TAB_MIDDLE($this, 'project-item');
        AE_E_UTILS::DynamicStyleControls($this, 'project-item-hover', '.wp-active-we-projects-gallery .project-item:hover', [
            'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::Separator($this, 'box-cover-hover', 'روکش');
        AE_E_UTILS::BACKGROUND_WO_IMG_FIELD($this, 'box-cover-hover', '.wp-active-we-projects-gallery-3 .project-item:hover:before');
        AE_E_UTILS::TAB_END($this);
        AE_E_UTILS::SECTION_END($this);


        // title styles
        AE_E_UTILS::SECTION_START($this, 'title-style', 'عنوان', 'style');
        AE_E_UTILS::TextUtils($this, 'title', '.wp-active-we-projects-gallery-3 .project-item .details-holder .title', true);
        AE_E_UTILS::SECTION_END($this);


        // category styles
        AE_E_UTILS::SECTION_START($this, 'category-style', 'دسته بندی', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'category-mb', 'فاصله', 0, 100, null, '.wp-active-we-projects-gallery-3 .project-item .details-holder .category', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'category', '.wp-active-we-projects-gallery-3 .project-item .details-holder .category', true);
        AE_E_UTILS::SECTION_END($this);


        // more button
        AE_E_UTILS::SECTION_START($this, 'more-style', 'دکمه بیشتر', 'style');

        AE_E_UTILS::COLOR_FIELD($this, 'more-border-color', 'رنگ حاشیه', '', '.wp-active-we-projects-gallery-3 .more-btn', 'border-color');
        AE_E_UTILS::COLOR_FIELD($this, 'more-border-color-hover', 'رنگ هاور حاشیه', '', '.wp-active-we-projects-gallery-3 .more-btn:hover', 'border-color');

        AE_E_UTILS::COLOR_FIELD($this, 'more-icon-color', 'رنگ آیکون', '', '.wp-active-we-projects-gallery-3 .more-btn svg', 'fill');
        AE_E_UTILS::COLOR_FIELD($this, 'more-icon-color-hover', 'رنگ هاور آیکون', '', '.wp-active-we-projects-gallery-3 .more-btn:hover svg', 'fill');

        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $ID       = $this->get_id();

        $use_ajax       = $settings['use-ajax'];
        $query          = null;
        $posts_per_page = $settings['posts_per_page'];
        if ($use_ajax === 'yes') {
            $this->ajaxify($settings);
        } else {
            $query_args = $this->QueryArgBuilder();
            $query      = new WP_Query($query_args);

            if (!$query->have_posts()) {
                $this->add_render_attribute('projects-gallery-container', 'class', 'wo-post');
            }
        }


        $this->add_render_attribute('projects-gallery-container', 'class', ['wp-active-we-projects-gallery-3', 'wp-active-we-projects-gallery', 'projects-gallery-' . $ID]);
        $this->add_render_attribute('projects-gallery-container', 'data-wid', $ID);
        if ($settings['intro-animation'] === 'yes') {
            $this->add_render_attribute('projects-gallery-container', 'class', 'active-animation');
            $this->add_render_attribute('projects-gallery-container', 'data-animation-target', '.elementor-element-' . $this->get_id() . ' .project-item');
            $this->add_render_attribute('projects-gallery-container', 'data-animation-offset', '100');
        }

        ?>
        <div <?php $this->print_render_attribute_string('projects-gallery-container'); ?>>

            <?php
            if ($use_ajax) {
                if ($settings['enable-filters'] === 'yes') {
                    $this->FilterPlaceholder();
                }

                echo '<div class="projects-inner d-grid animated-placeholder">';
                for ($i = 0; $i < $posts_per_page; $i++) {
                    $this->placeholder();
                }
                echo '</div>';
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
        $this->add_render_attribute('projects-gallery-container', 'class', 'wp-active-we-ajax-container');
        $this->add_render_attribute('projects-gallery-container', 'data-query-args', json_encode($query_args));
        $this->add_render_attribute('projects-gallery-container', 'data-ajax-type', $settings['ajax-loading-type']);
        $this->add_render_attribute('projects-gallery-container', 'data-ajax-status', 'before_start');
        $this->add_render_attribute('projects-gallery-container', 'data-post-structure', json_encode($this->post_structure()));
        $this->add_render_attribute('projects-gallery-container', 'data-ajax-result-place', '.elementor-element-' . $this->get_id() . ' .wp-active-we-projects-gallery-3 .projects-inner');
        if ($settings['enable-filters'] === 'yes') {
            $this->add_render_attribute('projects-gallery-container', 'data-ajax-filter-structure', json_encode($this->FilterStructureForAjax()));
            $this->add_render_attribute('projects-gallery-container', 'data-ajax-result-place-filter', '.elementor-element-' . $this->get_id() . ' .wp-active-we-projects-gallery-3 .filter-buttons');
        }

        $widget_data = [
            'wid'         => $this->get_id(),
            'post_class'  => 'project-item all',
            'image_size'  => $settings['projects-gallery-image-size_size'],
            'image_class' => 'project-image',
            'filter'      => [
                'enable'   => $settings['enable-filters'] === 'yes',
                'taxonomy' => $settings['filter']
            ]
        ];
        if ($settings['intro-animation'] === 'yes') {
            $widget_data['post_class'] .= ' item-has-intro-animation';
        }
        $this->add_render_attribute('projects-gallery-container', 'data-widget-data', json_encode($widget_data));
    }


    protected function placeholder()
    {
        ?>
        <div class="project-item">
            <span class="project-image dfx w100 skeleton-bg"></span>
        </div>
        <?php
    }


    protected function post_structure()
    {
        $post_structure = '<div class="{post_class}">';
        $post_structure .= '{thumbnail}';
        $post_structure .= '<div class="details-holder">';
        $post_structure .= '#cat<a href="{cat_link}" title="{cat_title}" class="category">{cat_title}</a>cat#';
        $post_structure .= '<a href="{link}" title="{title}" class="title">{title}</a>';
        $post_structure .= '</div>'; // END .details-holder
        $post_structure .= '<a href="{link}" title="{title}" class="more-btn dfx aic jcc">';
        $post_structure .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z"></path></svg>';
        $post_structure .= '</a>';
        $post_structure .= '</div>'; // END .project-item

        return $post_structure;
    }


    protected function filters_structure()
    {
        return [
            'all' => '<button class="active" data-filter=".all" data-class-name="all">'. __('All', 'wp-active-widgets-elementor') .'</button>',
            'btn' => '<button data-filter="{filter_select}" data-class-name="{filter_class}" title="{filter_title}">{filter_title}</button>'
        ];
    }


    protected function print_query($settings, $query)
    {
        $image_size    = $settings['projects-gallery-image-size_size'];
        $enable_filter = $settings['enable-filters'];
        $taxonomy      = $settings['filter'];
        $filters       = AE_E_FUNCTIONS::extractQueryTerms($query, $taxonomy);

        if ($enable_filter === 'yes' && !empty($filters)) { ?>
            <div class="filter-buttons dfx wrap aic jcc ae-gap-5">
                <button class="active" data-filter=".all" data-class-name="all">
                    <?php _e('All', 'wp-active-widgets-elementor'); ?>
                </button>
                <?php foreach ($filters as $filter) { ?>
                    <button data-filter=".<?php echo esc_attr(key($filter)); ?>"
                            data-class-name="<?php echo esc_attr(key($filter)); ?>"
                            title="<?php echo esc_html(current($filter)); ?>">
                        <?php echo esc_html(current($filter)); ?>
                    </button>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="projects-inner d-grid">
            <?php
            while ($query->have_posts()) {
                $query->the_post();
                $title = get_the_title();
                $category = AE_E_FUNCTIONS::getPostFirstCategory();
                $classes  = ['project-item', 'all'];
                $terms    = get_the_terms(get_the_ID(), $taxonomy);
                if (!empty($terms)) {
                    foreach ($terms as $term) {
                        $classes[] = $taxonomy . '-' . $term->term_id;
                    }
                }
                ?>
                <div <?php post_class($classes); ?>>
                    <?php the_post_thumbnail($image_size, ['class' => 'project-image']); ?>
                    <div class="details-holder">
                        <?php if ($category) { ?>
                            <a href="<?php echo esc_url(get_term_link($category->term_id)); ?>"
                               title="<?php esc_html_e($category->name); ?>"
                               class="category"><?php esc_html_e($category->name); ?></a>
                        <?php } ?>
                        <a href="<?php the_permalink(); ?>" title="<?php echo esc_html($title); ?>" class="title">
                            <?php echo esc_html($title); ?>
                        </a>
                    </div>
                    <a href="<?php the_permalink(); ?>" title="<?php echo esc_html($title); ?>" class="more-btn dfx aic jcc">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z"></path>
                        </svg>
                    </a>
                </div>
            <?php }

            if (!$query->have_posts()) {
                $this->QueryNotHavePostsMessage();
            }

            ?>

        </div>
        <!--/.projects-inner-->
        <?php
        wp_reset_postdata();

    }

}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_ProjectsGallery3());
