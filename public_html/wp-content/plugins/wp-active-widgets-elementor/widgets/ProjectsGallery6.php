<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;
use WP_Query;
use AE_E_FUNCTIONS;
use WP_ACTIVE_WE_QueryBuilder;
use WP_ACTIVE_WE_QueryFilters;

class WP_ACTIVE_WE_ProjectsGallery6 extends Widget_Base{

    use WP_ACTIVE_WE_QueryBuilder;
    use WP_ACTIVE_WE_QueryFilters;

    public function get_script_depends()
    {
        return [
            'jquery',
            'wp-active-we-projects-gallery-filter',
            'wp-active-we-intro-animation',
            'wp-active-we-gallery-in-loop'
        ];
    }

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-projects-gallery-6', AE_E_CSS_DIR . 'projects-gallery-6.css');
        return ['wp-active-we-projects-gallery-6'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'گالری پروژه 6';
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

        AE_E_UTILS::SECTION_START($this, 'settings', 'تنظیمات');
        $this->FilterSettings();

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

        AE_E_UTILS::SWITCH_FIELD($this, 'use-ajax', 'لود ایجکسی');
        AE_E_UTILS::SELECT_FIELD($this, 'ajax-loading-type', 'زمان اجرای ایجکس', [
            'scroll'  => 'هنگام رسیدن به پست',
            'timeout' => 'به محض لود صفحه'
        ], 'scroll', 'use-ajax', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'intro-animation', 'انیمیشن ورود');
        AE_E_UTILS::SWITCH_FIELD($this, 'enable-gallery-in-loop', 'گالری در حلقه');

        AE_E_UTILS::IMAGE_SIZE($this, 'projects-gallery-image-size');
        $this->add_responsive_control('gallery-columns', [
            'label'       => 'تعداد ستون',
            'type'        => Controls_Manager::NUMBER,
            'label_block' => false,
            'min'         => 1,
            'max'         => 5,
            'step'        => 1,
            'selectors'   => [
                '{{WRAPPER}} .projects-inner' => 'grid-template-columns: repeat({{SIZE}}, 1fr)',
            ],
        ]);

        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'columns-gap', 'فاصله بین افقی', 0, 100, null, '.projects-inner', 'column-gap');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'row-gap', 'فاصله بین عمودی', 0, 100, null, '.projects-inner', 'row-gap');

        AE_E_UTILS::SECTION_END($this);


        // Query Settings
        $this->QuerySettings();

        // Styles
        $this->FilterStyles();
        $this->register_controls_styles();

        $this->QueryNotHavePostsStyle();

    }

    protected function register_controls_styles()
    {
        //Box
        AE_E_UTILS::SECTION_START($this, 'box-sec-style', 'آیتم', 'style');
        AE_E_UTILS::BoxUtils($this, 'item-box', '.project-item-inner');
        AE_E_UTILS::SECTION_END($this);


        // image styles
        AE_E_UTILS::SECTION_START($this, 'image-style', 'تصویر', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'image-height', 'ارتفاع تصویر', 100, 360, null, '.project-item .project-thumbnail', 'height');
        AE_E_UTILS::COLOR_FIELD($this, 'gil-color-normal', 'رنگ نشان عادی', '', '.project-item:hover .gil-page span', 'background');
        AE_E_UTILS::COLOR_FIELD($this, 'gil-color-hover', 'رنگ نشان هاور', '', '.project-item:hover .gil-page:hover span', 'background');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'gil-border-radius', 'خمیدگی','.project-item .project-thumbnail img','border-radius');
        AE_E_UTILS::SECTION_END($this);


        // title styles
        AE_E_UTILS::SECTION_START($this, 'title-style', 'عنوان', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'title-mt', 'فاصله', 0, 50, null, '.project-item .post-title', 'margin-top');

        AE_E_UTILS::NUMBER_FIELD_STYLE($this, 'item-title-line-clamp', 'تعداد خط', '.project-item .post-title', '-webkit-line-clamp', 1, 3, 1, null);
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'item-title-line-height', 'ارتفاع', 20, 80, null, '.project-item .post-title', 'height');

        AE_E_UTILS::TextUtils($this, 'title', '.project-item .post-title');
        AE_E_UTILS::COLOR_FIELD($this, 'title_color_normal_box_hover', 'رنگ عادی در هاور باکس', '', '.project-item:hover .post-title', 'color');
        AE_E_UTILS::COLOR_FIELD($this, 'title_color_hover', 'رنگ هاور', '', '.project-item:hover .post-title:hover', 'color');
        AE_E_UTILS::SECTION_END($this);


        // fields
        AE_E_UTILS::SECTION_START($this, 'fields-sec-style', 'فیلدهای دلخواه', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'fields-mt', 'فاصله از بالا', 0, 30, null, '.custom-field', 'margin-top');
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

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $ID = $this->get_id();

        $use_ajax = $settings['use-ajax'];
        $query = null;
        $posts_per_page = $settings['posts_per_page'];

        if ($use_ajax === 'yes') {
            $this->ajaxify($settings);
        } else {
            $query_args = $this->QueryArgBuilder();
            $query = new WP_Query($query_args);

            if (!$query->have_posts()) {
                $this->add_render_attribute('projects-gallery-container', 'class', 'wo-post');
            }
        }

        $this->add_render_attribute('projects-gallery-container', 'class', [
            'wp-active-we-projects-gallery-6',
            'wp-active-we-projects-gallery',
            'projects-gallery-' . $ID
        ]);
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
                    $this->post_placeholder();
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
        $this->add_render_attribute('projects-gallery-container', 'data-post-structure', json_encode($this->posts_structure()));
        $this->add_render_attribute('projects-gallery-container', 'data-ajax-result-place', '.elementor-element-' . $this->get_id() . ' .wp-active-we-projects-gallery-6 .projects-inner');
        if ($settings['enable-filters'] === 'yes') {
            $this->add_render_attribute('projects-gallery-container', 'data-ajax-filter-structure', json_encode($this->FilterStructureForAjax()));
            $this->add_render_attribute('projects-gallery-container', 'data-ajax-result-place-filter', '.elementor-element-' . $this->get_id() . ' .wp-active-we-projects-gallery-6 .filter-buttons');
        }

        $widget_data = [
            'wid'         => $this->get_id(),
            'post_class'  => 'project-item-wrapper project-item all w100 trans03',
            'image_size'  => $settings['projects-gallery-image-size_size'],
            'image_class' => 'project-image',
            'filter'      => [
                'enable'   => $settings['enable-filters'] === 'yes',
                'taxonomy' => $settings['filter']
            ],
        ];

        if ($settings['intro-animation'] === 'yes') {
            $widget_data['post_class'] .= ' item-has-intro-animation';
        }

        if ($settings['enable-gallery-in-loop'] === 'yes') {
            $widget_data['gallery_in_loop'] = true;
        }

        $fields = $settings['custom-fields'];
        if (!empty($fields)) {
            $widget_data['custom_fields'] = AE_E_FUNCTIONS::cfStructureForAjax($this, $fields);
        }

        $this->add_render_attribute('projects-gallery-container', 'data-widget-data', json_encode($widget_data));
    }

    protected function posts_structure()
    {
        $structure = '<div class="{post_class}">';
        $structure .= '<div class="project-item-inner">';
        $structure .= '<a href="{link}" title="{title}" class="project-thumbnail gallery-in-loop">';
        $structure .= '{gallery_in_loop}';
        $structure .= '{thumbnail}';
        $structure .= '</a>';   // END project-thumbnail
        $structure .= '<div class="details-holder dfx dir-v aic jcc">';
        $structure .= '<h3 class="title-holder w100">';
        $structure .= '<a href="{link}" title="{title}" class="post-title ellipsis-1">{title}</a>';
        $structure .= '</h3>';
        $structure .= '{custom_fields}';
        $structure .= '</div>'; // END details-holder
        $structure .= '</div>'; // END project-item-inner
        $structure .= '</div>'; // END
        return $structure;
    }

    protected function post_placeholder()
    {
        $custom_fields = $this->get_settings_for_display('custom-fields');
        ?>
        <div class="project-item placeholder animated-placeholder">
            <span class="project-thumbnail dfx w100 skeleton-bg"></span>
            <span class="title-holder dfx w100 h20 skeleton-bg"></span>
            <?php
            if (!empty($custom_fields)) {
                foreach ($custom_fields as $custom_field) {
                    echo '<span class="meta-holder dfx w100 h12 mt3 skeleton-bg"></span>';
                }
            } ?>
        </div>
        <?php
    }

    protected function print_query($settings, $query)
    {
        $image_size = $settings['projects-gallery-image-size_size'];
        $gallery_in_loop = !empty($settings['enable-gallery-in-loop']);

        $taxonomy = $settings['filter'];
        $this->DisplayFilters($query);
        ?>

        <div class="projects-inner d-grid">
            <?php

            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                $title = get_the_title();
                $classes = ['project-item-wrapper', 'project-item', 'all', 'w100', 'trans03'];
                $terms = get_the_terms($post_id, $taxonomy);
                if (!empty($terms)) {
                    foreach ($terms as $term) {
                        $classes[] = $taxonomy . '-' . $term->term_id;
                    }
                }
                ?>
                <div <?php post_class($classes); ?>>
                    <div class="project-item-inner">
                        <a href="<?php the_permalink(); ?>"
                           title="<?php echo esc_html($title); ?>"
                           class="project-thumbnail gallery-in-loop">
                            <?php
                            if ($gallery_in_loop && in_array(get_post_type($post_id), ['project', 'product'])) {
                                echo AE_E_FUNCTIONS::galleryInLoop($post_id, $image_size);
                            }

                            the_post_thumbnail($image_size, ['class' => 'project-image']);

                            ?>
                        </a>
                        <div class="details-holder dfx dir-v aic jcc">
                            <h3 class="title-holder w100">
                                <a href="<?php the_permalink(); ?>" title="<?php echo esc_html($title); ?>"
                                   class="post-title ellipsis-1">
                                    <?php echo esc_html($title); ?>
                                </a>
                            </h3>
                            <?php AE_E_FUNCTIONS::cfInLoop($this, $settings, $post_id); ?>
                        </div>
                    </div>
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

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_ProjectsGallery6());
