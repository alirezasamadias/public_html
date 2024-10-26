<?php

namespace Elementor;

defined('ABSPATH') || die();

use WP_Query;
use AE_E_UTILS;
use AE_E_FUNCTIONS;
use WP_ACTIVE_WE_QueryBuilder;

class WP_ACTIVE_WE_ProjectsGallery5 extends Widget_Base
{

    use WP_ACTIVE_WE_QueryBuilder;

    public function get_script_depends()
    {
        return ['wp-active-we-intro-animation'];
    }

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-projects-gallery-5', AE_E_CSS_DIR . 'projects-gallery-5.css');
        return ['wp-active-we-projects-gallery-5'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'گالری پروژه 5';
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

        AE_E_UTILS::NOTICE($this, 'posts-per-page', 'تعداد پست را 8 یا 16 قرار دهید.');

        AE_E_UTILS::IMAGE_SIZE($this, 'projects-gallery-image');

        AE_E_UTILS::SWITCH_FIELD($this, 'lightbox-btn', 'باز کردن تصویر', 'yes');

        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'columns-gap', 'فاصله بین افقی', 0, 100, null,
            '.wp-active-we-projects-gallery-5', 'column-gap');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'row-gap', 'فاصله بین عمودی', 0, 100, null,
            '.wp-active-we-projects-gallery-5', 'row-gap');

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

        // item styles
        AE_E_UTILS::SECTION_START($this, 'item-style', 'آیتم', 'style');

        AE_E_UTILS::TAB_START($this, 'project-item');
        AE_E_UTILS::DynamicStyleControls($this, 'project-item-normal', '.wp-active-we-projects-gallery .project-item', [
            'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::Separator($this, 'box-cover', 'روکش');
        AE_E_UTILS::BACKGROUND_WO_IMG_FIELD($this, 'box-cover', '.wp-active-we-projects-gallery-5 .project-item .bg-overlay');
        AE_E_UTILS::TAB_MIDDLE($this, 'project-item');
        AE_E_UTILS::DynamicStyleControls($this, 'project-item-hover', '.wp-active-we-projects-gallery .project-item:hover', [
            'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);
        AE_E_UTILS::SECTION_END($this);


        // title styles
        AE_E_UTILS::SECTION_START($this, 'title-style', 'عنوان', 'style');
        AE_E_UTILS::TextUtils($this, 'title', '.wp-active-we-projects-gallery-5 .project-item .details-holder .title');
        AE_E_UTILS::SECTION_END($this);


        // lightbox opener
        AE_E_UTILS::SECTION_START($this, 'lightbox-btn-style', 'دکمه', 'style', 'lightbox-btn', 'yes');
        AE_E_UTILS::COLOR_FIELD($this, 'lightbox-btn_color', 'رنگ', '', '.wp-active-we-projects-gallery-5 .project-item .details-holder .viewer-btn svg', 'fill');
        AE_E_UTILS::DynamicStyleControls($this, 'lightbox-btn', '.wp-active-we-projects-gallery-5 .project-item .details-holder .viewer-btn', [
            'bg', 'border', 'radius', 'shadow'
        ]);
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
                $this->add_render_attribute('projects-gallery-container', 'class', 'wo-post');
            }
        }


        $this->add_render_attribute('projects-gallery-container', 'class', ['wp-active-we-projects-gallery-5', 'wp-active-we-projects-gallery', 'd-grid']);
        if ($settings['intro-animation'] === 'yes') {
            $this->add_render_attribute('projects-gallery-container', 'class', 'active-animation');
            $this->add_render_attribute('projects-gallery-container', 'data-animation-target', '.elementor-element-' . $this->get_id() . ' .project-item');
            $this->add_render_attribute('projects-gallery-container', 'data-animation-offset', '100');
        }

        ?>
        <div <?php $this->print_render_attribute_string('projects-gallery-container'); ?>>

            <?php
            if ($use_ajax) {
                for ($i = 1; $i <= $posts_per_page; $i++) {
                    $this->placeholder($i);
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
        $this->add_render_attribute('projects-gallery-container', 'class', 'wp-active-we-ajax-container');
        $this->add_render_attribute('projects-gallery-container', 'data-query-args', json_encode($query_args));
        $this->add_render_attribute('projects-gallery-container', 'data-ajax-type', $settings['ajax-loading-type']);
        $this->add_render_attribute('projects-gallery-container', 'data-ajax-status', 'before_start');
        $this->add_render_attribute('projects-gallery-container', 'data-post-structure', json_encode($this->postStructure($settings)));
        $this->add_render_attribute('projects-gallery-container', 'data-ajax-result-place', '.elementor-element-' . $this->get_id() . ' .wp-active-we-projects-gallery-5');

        $widget_data = [
            'wid'         => $this->get_id(),
            'post_class'  => 'project-item animation-item',
            'image_size'  => $settings['projects-gallery-image_size'],
            'image_class' => 'project-image',
            'counter'     => [
                'pseudo' => 'project-item-',
                'start'  => '1'
            ]
        ];
        if ($settings['intro-animation'] === 'yes') {
            $widget_data['post_class'] .= ' item-has-intro-animation';
        }
        $this->add_render_attribute('projects-gallery-container', 'data-widget-data', json_encode($widget_data));
    }


    protected function placeholder($i)
    {
        ?>
        <div class="project-item <?php echo 'project-item-' . $i; ?> animated-placeholder">
            <span class="project-image dfx w100 skeleton-bg"></span>
        </div>
        <?php
    }


    protected function postStructure($settings)
    {
        $post_structure = '<div class="{post_class}">';
        $post_structure .= '{thumbnail}';
        $post_structure .= '<span class="bg-overlay"></span>';
        $post_structure .= '<div class="details-holder dfx dir-v aic jce ae-gap-15">';
        if ($settings['lightbox-btn'] === 'yes') {
            $post_structure .= '<a href="{thumbnail_url_full}" title="{title}" class="viewer-btn dfx aic jcc" data-elementor-lightbox-slideshow="project-gallery-5-{wid}">';
            $post_structure .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9-9-4.032-9-9 4.032-9 9-9zm0 16c3.867 0 7-3.133 7-7 0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7zm8.485.071l2.829 2.828-1.415 1.415-2.828-2.829 1.414-1.414z"></path></svg>';
            $post_structure .= '</a>';
        }
        $post_structure .= '<a href="{link}" title="{title}" class="title">{title}</a>';
        $post_structure .= '</div>'; // END .details-holder
        $post_structure .= '</div>'; // END .post-item

        return $post_structure;
    }


    protected function printQuery($settings, $query)
    {
        $ID           = $this->get_id();
        $image_size   = $settings['projects-gallery-image_size'];
        $lightbox_btn = $settings['lightbox-btn'];

        $i = 1;
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div <?php post_class(['project-item', 'project-item-' . $i]); ?>>
                <?php the_post_thumbnail($image_size, ['class' => 'project-image']); ?>
                <span class="bg-overlay"></span>
                <div class="details-holder dfx dir-v aic jce ae-gap-15">
                    <?php if ($lightbox_btn === 'yes') { ?>
                        <a href="<?php the_post_thumbnail_url('full'); ?>" title="<?php the_title(); ?>"
                           class="viewer-btn dfx aic jcc"
                           data-elementor-lightbox-slideshow="project-gallery-5-<?php echo $ID; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <path d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9-9-4.032-9-9 4.032-9 9-9zm0 16c3.867 0 7-3.133 7-7 0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7zm8.485.071l2.829 2.828-1.415 1.415-2.828-2.829 1.414-1.414z"></path>
                            </svg>
                        </a>
                    <?php } ?>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="title">
                        <?php the_title(); ?>
                    </a>
                </div>
            </div>
            <?php $i++;
        }

        if (!$query->have_posts()) {
            $this->QueryNotHavePostsMessage();
        }

        wp_reset_postdata();

    }


}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_ProjectsGallery5());
