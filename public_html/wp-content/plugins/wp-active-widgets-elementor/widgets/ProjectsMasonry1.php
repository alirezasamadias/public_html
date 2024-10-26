<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;
use WP_Query;
use WP_ACTIVE_WE_QueryBuilder;

class WP_ACTIVE_WE_ProjectsMasonry1 extends Widget_Base
{

    use WP_ACTIVE_WE_QueryBuilder;

    public function get_script_depends()
    {
        return ['wp-active-we-intro-animation'];
    }

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-projects-masonry-1', AE_E_CSS_DIR . 'project-masonry-1.css');
        return ['wp-active-we-projects-masonry-1'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'پروژه ها: استایل کاشی 1';
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

        AE_E_UTILS::NOTICE($this, 'project-notice', 'تعداد پست ها یا آیتم ها برای این گالری باید 9 تا باشد!');
        $gallery_type = [
            'manual' => 'دستی',
            'posts'  => 'پست',
        ];
        AE_E_UTILS::SELECT_FIELD($this, 'gallery-type', 'نوع گالری', $gallery_type, 'manual');

        $project_items = new \Elementor\Repeater();
        AE_E_UTILS::IMAGE($project_items, 'image', 'تصویر', 'true');
        AE_E_UTILS::TXT_FIELD($project_items, 'title', 'عنوان', '', true);
        AE_E_UTILS::URL_FIELD($project_items, 'link', 'لینک', true);
        $this->add_control(
            'project-items',
            [
                'label'       => 'پروژه ها',
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $project_items->get_controls(),
                'title_field' => '{{{ title }}}',
                'condition'   => [
                    'gallery-type' => 'manual'
                ]
            ]
        );

        AE_E_UTILS::SWITCH_FIELD($this, 'use-ajax', 'لود ایجکسی', '', true, 'gallery-type', 'posts');
        AE_E_UTILS::SELECT_FIELD($this, 'ajax-loading-type', 'زمان اجرای ایجکس', [
            'scroll'  => 'هنگام رسیدن به پست',
            'timeout' => 'به محض لود صفحه'
        ], 'scroll', 'use-ajax', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'intro-animation', 'انیمیشن ورود');

        $this->end_controls_section();

        $this->QuerySettings('gallery-type', 'posts');

        $this->register_controls_styles();


        $this->QueryNotHavePostsStyle();

    }

    protected function register_controls_styles()
    {
        AE_E_UTILS::SECTION_START($this, 'box-style', 'استایل', 'style');
        $gap = [
            'ae-gap-0'  => '0',
            'ae-gap-5'  => '5',
            'ae-gap-10' => '10',
            'ae-gap-15' => '15',
            'ae-gap-20' => '20',
        ];
        AE_E_UTILS::SELECT_FIELD($this, 'box-gap', 'فاصله بین', $gap, 'ae-gap-20');

        AE_E_UTILS::BACKGROUND_WO_IMG_FIELD($this, 'item-style_bg', '.wp-active-we-projects-masonry-1 .project-item .details');
        AE_E_UTILS::DynamicStyleControls($this, 'item-style', '.wp-active-we-projects-masonry-1 .project-item', ['border', 'radius', 'shadow']);

        AE_E_UTILS::Separator($this, 'title', 'عنوان');
        AE_E_UTILS::TextUtils($this, 'title', '.wp-active-we-projects-masonry-1 .project-item .details .link');

        AE_E_UTILS::Separator($this, 'icon', 'آیکون');
        AE_E_UTILS::BACKGROUND_WO_IMG_FIELD($this, 'icon-bg', '.wp-active-we-projects-masonry-1 .project-item .details .opener');
        AE_E_UTILS::COLOR_FIELD($this, 'icon-fill', 'رنگ', '', '.wp-active-we-projects-masonry-1 .project-item .details .opener svg', 'fill');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'icon-radius', 'خمیدگی', '.wp-active-we-projects-masonry-1 .project-item .details .opener', 'border-radius');

        AE_E_UTILS::SECTION_END($this);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $id       = $this->get_id();


        $use_ajax       = $settings['use-ajax'];
        $query          = null;
        $posts_per_page = 9;
        if ($use_ajax === 'yes') {
            $this->ajaxify($settings);
        } else {
            $query_args                   = $this->QueryArgBuilder();
            $query_args['posts_per_page'] = 9;
            $query                        = new WP_Query($query_args);

            if (!$query->have_posts()) {
                $this->add_render_attribute('projects-masonry-container', 'class', 'grid-one-col');
            }
        }


        $gallery_type = $settings['gallery-type'];
        $gap          = $settings['box-gap'];

        $this->add_render_attribute('projects-masonry-container', 'class', ['wp-active-we-projects-masonry-1', 'd-grid', $gap]);
        if ($settings['intro-animation'] === 'yes') {
            $this->add_render_attribute('projects-masonry-container', 'class', 'active-animation');
            $this->add_render_attribute('projects-masonry-container', 'data-animation-target', '.elementor-element-' . $this->get_id() . ' .project-item');
            $this->add_render_attribute('projects-masonry-container', 'data-animation-offset', '100');
        }

        ?>
        <div <?php $this->print_render_attribute_string('projects-masonry-container'); ?>>
            <?php
            if ($gallery_type === 'posts') {

                if ($use_ajax) {
                    for ($counter = 1; $counter <= $posts_per_page; $counter++) {
                        ?>
                        <div class="project-item skeleton-bg pi<?php echo $counter; ?>"></div>
                        <?php
                    }
                } else {
                    $this->printQuery($settings, $query);
                }

            } else {
                $gallery = $settings['project-items'];

                if (!empty($gallery)) {
                    $counter = 1;
                    foreach ($gallery as $item) {
                        $image_id = $item['image']['id'];
                        $title    = $item['title'];
                        $this->add_link_attributes('link' . $counter, $item['link']);
                        $this->add_render_attribute('link' . $counter, 'class', 'link');
                        $this->add_render_attribute('link' . $counter, 'title', $title);
                        $link = $item['link']['url'];

                        ?>
                        <div class="project-item pi<?php echo $counter; ?>">
                            <?php

                            echo wp_get_attachment_image($image_id, 'medium_large', '', ['class' => 'project-image']);

                            ?>
                            <div class="details dfx dir-v aic jcc ae-gap-10">
                                <a href="<?php echo wp_get_attachment_image_url($image_id, 'full'); ?>"
                                   title="<?php the_title(); ?>"
                                   class="opener dfx aic jcc"
                                   data-elementor-lightbox-slideshow="project-masonry-gallery-<?php echo $id; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0h24v24H0z"/>
                                        <path d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9-9-4.032-9-9 4.032-9 9-9zm0 16c3.867 0 7-3.133 7-7 0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7zm8.485.071l2.829 2.828-1.415 1.415-2.828-2.829 1.414-1.414z"/>
                                    </svg>
                                </a>
                                <?php if (!empty($link)) { ?>
                                    <a <?php $this->print_render_attribute_string('link' . $counter); ?>>
                                        <?php echo $title; ?>
                                    </a>
                                <?php } else { ?>
                                    <span class="link"><?php echo $title; ?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                        $counter++;
                    }
                }
            }
            ?>
        </div>
        <?php
    }

    protected function ajaxify($settings)
    {
        $query_args                   = $this->QueryArgBuilder();
        $query_args['posts_per_page'] = 9;
        $this->add_render_attribute('projects-masonry-container', 'class', 'wp-active-we-ajax-container');
        $this->add_render_attribute('projects-masonry-container', 'class', 'animated-placeholder');
        $this->add_render_attribute('projects-masonry-container', 'data-query-args', json_encode($query_args));
        $this->add_render_attribute('projects-gallery-container', 'data-ajax-type', $settings['ajax-loading-type']);
        $this->add_render_attribute('projects-masonry-container', 'data-ajax-status', 'before_start');
        $this->add_render_attribute('projects-masonry-container', 'data-post-structure', json_encode($this->postStructure()));
        $this->add_render_attribute('projects-masonry-container', 'data-ajax-result-place', '.elementor-element-' . $this->get_id() . ' .wp-active-we-projects-masonry-1');

        $widget_data = [
            'wid'         => $this->get_id(),
            'post_class'  => 'project-item',
            'counter'     => [
                'pseudo' => 'pi',
                'start'  => 1
            ],
            'image_size'  => 'medium_large',
            'image_class' => 'project-image'
        ];
        if ($settings['intro-animation'] === 'yes') {
            $widget_data['post_class'] .= ' item-has-intro-animation';
        }
        $this->add_render_attribute('projects-masonry-container', 'data-widget-data', json_encode($widget_data));
    }

    protected function postStructure()
    {
        $post_structure = '<div class="{post_class}">';
        $post_structure .= '{thumbnail}';
        $post_structure .= '<div class="details dfx dir-v aic jcc ae-gap-10">';
        $post_structure .= '<a href="{thumbnail_url_full}" title="{title}" class="opener dfx aic jcc" data-elementor-lightbox-slideshow="project-masonry-gallery-{wid}">';
        $post_structure .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9-9-4.032-9-9 4.032-9 9-9zm0 16c3.867 0 7-3.133 7-7 0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7zm8.485.071l2.829 2.828-1.415 1.415-2.828-2.829 1.414-1.414z"/></svg>';
        $post_structure .= '</a>';
        $post_structure .= '<a href="{link}" title="{title}" class="link">{title}</a>';
        $post_structure .= '</div>';
        $post_structure .= '</div>';

        return $post_structure;
    }

    protected function printQuery($settings, $query)
    {
        $id      = $this->get_id();
        $counter = 1;
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="project-item pi<?php echo $counter; ?>">
                <?php
                if (has_post_thumbnail()) {
                    the_post_thumbnail('medium_large', ['class' => 'project-image']);
                } else {
                    echo '<img src="' . AE_E_IMG_DIR . 'placeholder-1.svg' . '" alt="' . get_the_title() . '" class="project-image">';
                }
                ?>
                <div class="details dfx dir-v aic jcc ae-gap-10">
                    <a href="<?php the_post_thumbnail_url('full'); ?>" title="<?php the_title(); ?>"
                       class="opener dfx aic jcc"
                       data-elementor-lightbox-slideshow="project-masonry-gallery-<?php echo $id; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z"/>
                            <path d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9-9-4.032-9-9 4.032-9 9-9zm0 16c3.867 0 7-3.133 7-7 0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7zm8.485.071l2.829 2.828-1.415 1.415-2.828-2.829 1.414-1.414z"/>
                        </svg>
                    </a>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="link">
                        <?php the_title(); ?>
                    </a>
                </div>
            </div>
            <?php
            $counter++;
        }

        if (!$query->have_posts()) {
            $this->QueryNotHavePostsMessage();
        }

        wp_reset_postdata();
    }

}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_ProjectsMasonry1());
