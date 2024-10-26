<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;
use WP_Query;
use WP_ACTIVE_WE_QueryBuilder;

class WP_ACTIVE_WE_PostsMasonry1 extends Widget_Base
{

    use WP_ACTIVE_WE_QueryBuilder;

    public function get_script_depends()
    {
        return ['wp-active-we-intro-animation'];
    }

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-posts-masonry-1', AE_E_CSS_DIR . 'posts-masonry-1.css');
        return ['wp-active-we-posts-masonry-1'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'پست ها استایل کاشی 1';
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

        AE_E_UTILS::SWITCH_FIELD($this, 'date', 'تاریخ', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'comment', 'نظر', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'author', 'نویسنده');

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

        // boxes
        AE_E_UTILS::SECTION_START($this, 'box-style', 'آیتم', 'style');

        $this->add_responsive_control(
            'item-height',
            [
                'label'       => 'ارتفاع',
                'type'        => Controls_Manager::SLIDER,
                'label_block' => true,
                'size_units'  => ['px'],
                'range'       => [
                    'px' => [
                        'min' => 200,
                        'max' => 400,
                    ],
                ],
                'selectors'   => [
                    '{{WRAPPER}} .wp-active-we-posts-masonry-1 .post-thumbnail'         => 'height: {{SIZE}}px;',
                    '{{WRAPPER}} .wp-active-we-posts-masonry-1 .item-2 .post-thumbnail' => 'height: calc({{SIZE}}px * 2 + {{row-gap.SIZE}}px);',
                ],
            ]
        );

        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'columns-gap', 'فاصله بین افقی', 0, 50, 20,
            '.wp-active-we-posts-masonry-1', 'column-gap');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'row-gap', 'فاصله بین عمودی', 0, 50, 20,
            '.wp-active-we-posts-masonry-1', 'row-gap');

        AE_E_UTILS::TAB_START($this, 'box-item');
        AE_E_UTILS::BACKGROUND_WO_IMG_FIELD($this, 'item-bg', '.wp-active-we-posts-masonry-1 .post-item:before');
        $box_controls = [
            'border',
            'border-radius',
            'shadow',
        ];
        AE_E_UTILS::DynamicStyleControls($this, 'box-style', '.wp-active-we-posts-masonry-1 .post-item', $box_controls);
        AE_E_UTILS::TAB_MIDDLE($this, 'box-item');
        AE_E_UTILS::BACKGROUND_WO_IMG_FIELD($this, 'item-bg-hover', '.wp-active-we-posts-masonry-1 .post-item:hover:before');
        AE_E_UTILS::DynamicStyleControls($this, 'box-style-hover', '.wp-active-we-posts-masonry-1 .post-item:hover', $box_controls);
        AE_E_UTILS::TAB_END($this);

        AE_E_UTILS::SECTION_END($this);


        // texts
        AE_E_UTILS::SECTION_START($this, 'texts-style', 'متن', 'style');
        AE_E_UTILS::Separator($this, 'title', 'عنوان');
        AE_E_UTILS::TextUtils($this, 'title', '.wp-active-we-posts-masonry-1 .infos .post-title');
        AE_E_UTILS::Separator($this, 'details', 'جزئیات');
        AE_E_UTILS::FONT_FIELD($this, 'details_font', 'فونت', '.wp-active-we-posts-masonry-1 .infos .details span');
        $this->add_control(
            'details_color',
            [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .wp-active-we-posts-masonry-1 .infos .details span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wp-active-we-posts-masonry-1 .infos .details svg'  => 'fill: {{VALUE}};',
                ]
            ]
        );

        AE_E_UTILS::SECTION_END($this);
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $use_ajax       = $settings['use-ajax'];
        $query          = null;
        $posts_per_page = 5;
        if ($use_ajax === 'yes') {
            $this->ajaxify($settings);
        } else {
            $query_args                   = $this->QueryArgBuilder();
            $query_args['posts_per_page'] = 5;
            $query                        = new WP_Query($query_args);

            if (!$query->have_posts()) {
                $this->add_render_attribute('post-masonry-container', 'class', 'grid-one-col');
            }
        }

        $this->add_render_attribute('post-masonry-container', 'class', ['wp-active-we-posts-masonry-1', 'd-grid']);
        if ($settings['intro-animation'] === 'yes') {
            $this->add_render_attribute('post-masonry-container', 'class', 'active-animation');
            $this->add_render_attribute('post-masonry-container', 'data-animation-target', '.elementor-element-' . $this->get_id() . ' .post-item');
            $this->add_render_attribute('post-masonry-container', 'data-animation-offset', '100');
        }

        ?>
        <div <?php $this->print_render_attribute_string('post-masonry-container'); ?>>
            <?php
            if ($use_ajax) {
                for ($i = 0; $i < $posts_per_page; $i++) {
                    ?>
                    <div class="post-item item-<?php echo $i; ?> dfx placeholder animated-placeholder">
                        <span class="post-thumbnail dfx w100 skeleton-bg"></span>
                    </div>
                    <?php
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
        $query_args                   = $this->QueryArgBuilder();
        $query_args['posts_per_page'] = 5;
        $this->add_render_attribute('post-masonry-container', 'class', 'wp-active-we-ajax-container');
        $this->add_render_attribute('post-masonry-container', 'data-query-args', json_encode($query_args));
        $this->add_render_attribute('post-masonry-container', 'data-ajax-type', $settings['ajax-loading-type']);
        $this->add_render_attribute('post-masonry-container', 'data-ajax-status', 'before_start');
        $this->add_render_attribute('post-masonry-container', 'data-post-structure', json_encode($this->postStructure()));
        $this->add_render_attribute('post-masonry-container', 'data-ajax-result-place', '.elementor-element-' . $this->get_id() . ' .wp-active-we-posts-masonry-1');

        $widget_data = [
            'wid'         => $this->get_id(),
            'post_class'  => 'post-item',
            'counter'     => [
                'pseudo' => 'item-',
                'start'  => 0
            ],
            'image_size'  => 'medium_large',
            'image_class' => 'post-thumbnail'
        ];
        if ($settings['intro-animation'] === 'yes') {
            $widget_data['post_class'] .= ' item-has-intro-animation';
        }
        $this->add_render_attribute('post-masonry-container', 'data-widget-data', json_encode($widget_data));
    }

    protected function postStructure()
    {
        $settings = $this->get_settings_for_display();

        $author  = $settings['author'];
        $comment = $settings['comment'];
        $date    = $settings['date'];

        $post_structure = '<a href="{link}" title="{title}" class="{post_class}">';
        $post_structure .= '{thumbnail}';
        $post_structure .= '<div class="infos"><h2 class="post-title">{title}</h2>';
        if ($author || $comment || $date) {
            $post_structure .= '';
            $post_structure .= '<div class="details dfx aic wrap ae-gap-15">';
            if ($date) {
                $post_structure .= '<span class="date">';
                $post_structure .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h4V1h2v2h6V1h2v2zm-2 2H9v2H7V5H4v4h16V5h-3v2h-2V5zm5 6H4v8h16v-8z"/></svg>';
                $post_structure .= '{date_full}</span>';
            }
            if ($comment) {
                $post_structure .= '<span class="comment">';
                $post_structure .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M5.455 15L1 18.5V3a1 1 0 0 1 1-1h15a1 1 0 0 1 1 1v12H5.455zm-.692-2H16V4H3v10.385L4.763 13zM8 17h10.237L20 18.385V8h1a1 1 0 0 1 1 1v13.5L17.545 19H9a1 1 0 0 1-1-1v-1z"/></svg>';
                $post_structure .= '{comment}</span>';
            }
            if ($author) {
                $post_structure .= '<span class="author">';
                $post_structure .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M20 22h-2v-2a3 3 0 0 0-3-3H9a3 3 0 0 0-3 3v2H4v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2zm-8-9a6 6 0 1 1 0-12 6 6 0 0 1 0 12zm0-2a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/></svg>';
                $post_structure .= '{author}</span>';
            }

            $post_structure .= '</div>'; // END .details
        }
        $post_structure .= '</div>'; // END .infos
        $post_structure .= '</a>'; // END .post-item

        return $post_structure;
    }

    protected function printQuery($settings, $query)
    {
        $author  = $settings['author'];
        $comment = $settings['comment'];
        $date    = $settings['date'];

        $counter = 0;
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <a href="<?php the_permalink(); ?>"
               title="<?php the_title(); ?>" <?php post_class(['post-item', 'item-' . $counter]); ?>>
                <?php
                if (has_post_thumbnail()) {
                    the_post_thumbnail('medium_large', ['class' => 'post-thumbnail']);
                } else {
                    echo '<img src="' . AE_E_IMG_DIR . 'placeholder-1.svg' . '" alt="' . get_the_title() . '" class="post-thumbnail">';
                }
                ?>

                <div class="infos">
                    <h2 class="post-title"><?php the_title(); ?></h2>
                    <?php if ($author || $comment || $date) { ?>
                        <div class="details dfx aic wrap ae-gap-15">
                            <?php if ($date) { ?>
                                <span class="date">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                         height="24">
                                        <path fill="none" d="M0 0h24v24H0z"/>
                                        <path d="M17 3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h4V1h2v2h6V1h2v2zm-2 2H9v2H7V5H4v4h16V5h-3v2h-2V5zm5 6H4v8h16v-8z"/>
                                    </svg>
                                    <?php echo get_the_date(); ?>
                                </span>
                            <?php } ?>
                            <?php if ($comment) { ?>
                                <span class="comment">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                         height="24">
                                        <path fill="none" d="M0 0h24v24H0z"/>
                                        <path d="M5.455 15L1 18.5V3a1 1 0 0 1 1-1h15a1 1 0 0 1 1 1v12H5.455zm-.692-2H16V4H3v10.385L4.763 13zM8 17h10.237L20 18.385V8h1a1 1 0 0 1 1 1v13.5L17.545 19H9a1 1 0 0 1-1-1v-1z"/>
                                    </svg>
                                    <?php comments_number(); ?>
                                </span>
                            <?php } ?>
                            <?php if ($author) { ?>
                                <span class="author">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                         height="24">
                                        <path fill="none" d="M0 0h24v24H0z"/>
                                        <path d="M20 22h-2v-2a3 3 0 0 0-3-3H9a3 3 0 0 0-3 3v2H4v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2zm-8-9a6 6 0 1 1 0-12 6 6 0 0 1 0 12zm0-2a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/>
                                    </svg>
                                    <?php echo get_the_author_meta('display_name'); ?>
                                </span>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </a>
            <?php $counter++;
        }

        if (!$query->have_posts()) {
            $this->QueryNotHavePostsMessage();
        }

        wp_reset_postdata();
    }

}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_PostsMasonry1());
