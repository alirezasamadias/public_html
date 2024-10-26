<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;
use WP_Query;
use AE_E_FUNCTIONS;
use WP_ACTIVE_WE_QueryBuilder;
use WP_ACTIVE_WE_QueryFilters;

class WP_ACTIVE_WE_ProjectsGallery2 extends Widget_Base{

    use WP_ACTIVE_WE_QueryBuilder;
    use WP_ACTIVE_WE_QueryFilters;

    public function get_script_depends()
    {
        return ['jquery', 'wp-active-we-projects-gallery-filter', 'wp-active-we-intro-animation'];
    }

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-projects-gallery-2', AE_E_CSS_DIR . 'projects-gallery-2.css');
        return ['wp-active-we-projects-gallery-2'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'گالری پروژه 2';
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

        $this->add_responsive_control('gallery-columns', [
            'label'       => 'تعداد ستون',
            'type'        => Controls_Manager::NUMBER,
            'label_block' => false,
            'min'         => 1,
            'max'         => 5,
            'step'        => 1,
            'default'     => 4,
            'selectors'   => [
                '{{WRAPPER}} .wp-active-we-projects-gallery-2 .projects-inner' => 'grid-template-columns: repeat({{SIZE}}, 1fr)',
            ],
        ]);
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'columns-gap', 'فاصله بین افقی', 0, 100, null, '.wp-active-we-projects-gallery-2 .projects-inner', 'column-gap');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'row-gap', 'فاصله بین عمودی', 0, 100, null, '.wp-active-we-projects-gallery-2 .projects-inner', 'row-gap');

        AE_E_UTILS::SWITCH_FIELD($this, 'intro-animation', 'انیمیشن ورود');

        $this->end_controls_section();

        // Query Settings
        $this->QuerySettings();

        //filter style
        $this->FilterStyles();

        $this->register_controls_styles();

        $this->QueryNotHavePostsStyle();

    }

    protected function register_controls_styles()
    {

        // item style
        AE_E_UTILS::SECTION_START($this, 'project-item-section', 'آیتم', 'style');

        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'project-item-height', 'ارتفاع', 250, 360, null, '.project-item', 'height');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'project-item-padding', 'فاصله داخلی متن', '.project-item h3', 'padding');

        AE_E_UTILS::NUMBER_FIELD_STYLE($this, 'item-title-line-clamp', 'تعداد خط', '.project-item h3', '-webkit-line-clamp', 1, 3, 1, null);
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'item-title-line-height', 'ارتفاع', 20, 80, null, '.project-item h3', 'height');

        AE_E_UTILS::TextUtils($this, 'project-item-title', '.project-item h3');
        $this->add_responsive_control('project-item-border-radius', [
            'label'     => 'خمیدگی',
            'type'      => \Elementor\Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .project-item .main-image'       => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px',
                '{{WRAPPER}} .project-item .branch-cards img' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px',
                '{{WRAPPER}} .project-item h3'                => 'border-radius: 0 0 {{BOTTOM}}px {{LEFT}}px',
            ]
        ]);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'       => 'project-item-shadow',
            'label'      => 'سایه',
            'show_label' => true,
            'selector'   => '{{WRAPPER}} .project-item .main-image,{{WRAPPER}} .project-item .branch-cards img'
        ]);

        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $ID = $this->get_id();
        $image_size = $settings['projects-gallery-image-size_size'];


        $ARGS = $this->QueryArgBuilder();
        $QUERY = new WP_Query($ARGS);

        if ($QUERY->have_posts()) {

            $taxonomy = $settings['filter'];

            $this->add_render_attribute('projects-gallery-container', 'class', [
                'wp-active-we-projects-gallery-2',
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

                <?php $this->DisplayFilters($QUERY); ?>

                <div class="projects-inner d-grid">
                    <?php
                    while ($QUERY->have_posts()) {
                        $QUERY->the_post();
                        $post_id = get_the_ID();
                        $gallery_images = get_post_meta($post_id, 'project-gallery-image', true);
                        if (empty($gallery_images)) {
                            $gallery_images = get_post_meta($post_id, '_gallery', true);
                        }
                        $classes = ['project-item', 'all'];
                        $terms = get_the_terms($post_id, $taxonomy);
                        if (!empty($terms)) {
                            foreach ($terms as $term) {
                                $classes[] = $taxonomy . '-' . $term->term_id;
                            }
                        }
                        ?>
                        <a href="<?php the_permalink(); ?>"
                           title="<?php the_title(); ?>" <?php post_class($classes); ?>>
                            <div class="branch-cards">
                                <?php
                                if (!empty($gallery_images) && count($gallery_images) > 2) {
                                    echo wp_get_attachment_image($gallery_images[0], $image_size, '', ['class' => 'branch-1']);
                                    echo wp_get_attachment_image($gallery_images[1], $image_size, '', ['class' => 'branch-2']);
                                } else {
                                    the_post_thumbnail($image_size, ['class' => 'branch-1']);
                                    the_post_thumbnail($image_size, ['class' => 'branch-2']);
                                }
                                ?>
                            </div>
                            <?php the_post_thumbnail($image_size, ['class' => 'main-image']); ?>
                            <h3 class="ellipsis-2"><?php the_title(); ?></h3>
                        </a>
                    <?php } ?>
                </div>
                <!--/.projects-inner-->
            </div>
            <?php
        }
        wp_reset_postdata();
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_ProjectsGallery2());
