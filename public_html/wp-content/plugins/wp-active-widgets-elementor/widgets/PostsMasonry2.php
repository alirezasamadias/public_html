<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;
use WP_Query;
use WP_ACTIVE_WE_QueryBuilder;
use AE_E_FUNCTIONS;

class WP_ACTIVE_WE_PostsMasonry2 extends Widget_Base
{

    use WP_ACTIVE_WE_QueryBuilder;

    public function get_script_depends()
    {
        return ['wp-active-we-intro-animation'];
    }

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-posts-masonry-2', AE_E_CSS_DIR . 'posts-masonry-2.css');
        return ['wp-active-we-posts-masonry-2'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'پست ها استایل کاشی 2';
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
        AE_E_UTILS::SWITCH_FIELD($this, 'category', 'دسته بندی', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'comment', 'نظر', 'yes');

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
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'columns-gap', 'فاصله بین افقی', 0, 50, null,
            '.wp-active-we-posts-masonry-2', 'column-gap');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'row-gap', 'فاصله بین عمودی', 0, 50, null,
            '.wp-active-we-posts-masonry-2 .tiny-posts', 'row-gap');
        AE_E_UTILS::DynamicStyleControls($this, 'post-item-style', '.wp-active-we-posts-masonry-2 .post-item', [
            'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::SECTION_END($this);


        // big items styles
        AE_E_UTILS::SECTION_START($this, 'big-items-style', 'پست های بزرگ', 'style');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'big-item-padding', 'فاصله داخلی', '.wp-active-we-posts-masonry-2 .big-post', 'padding');
        AE_E_UTILS::Separator($this, 'big-item-title', 'عنوان');
        AE_E_UTILS::FONT_FIELD($this, 'big-item-title-font', 'تایپوگرافی', '.wp-active-we-posts-masonry-2 .big-post .post-title h2');
        AE_E_UTILS::COLOR_FIELD($this, 'big-item-title-color', 'رنگ', '', '.wp-active-we-posts-masonry-2 .big-post .post-title h2', 'color');
        AE_E_UTILS::COLOR_FIELD($this, 'big-item-title-color-hover', 'رنگ هاور', '', '.wp-active-we-posts-masonry-2 .big-post .post-title:hover h2', 'color');

        AE_E_UTILS::Separator($this, 'big-item-infos', 'جزئیات');
        AE_E_UTILS::FONT_FIELD($this, 'big-item-infos-font', 'تایپوگرافی', '.wp-active-we-posts-masonry-2 .big-post .details .post-info .info-item');
        AE_E_UTILS::COLOR_FIELD($this, 'big-item-infos-color', 'رنگ', '', '.wp-active-we-posts-masonry-2 .big-post .details .post-info .info-item', 'color');
        AE_E_UTILS::COLOR_FIELD($this, 'big-item-infos-color-link-hover', 'رنگ هاور لینک', '', '.wp-active-we-posts-masonry-2 .big-post .details .post-info a.info-item:hover', 'color');
        AE_E_UTILS::COLOR_FIELD($this, 'big-item-infos-icon-color', 'رنگ آیکون', '', '.wp-active-we-posts-masonry-2 .big-post .details .post-info .info-item svg', 'fill');

        AE_E_UTILS::SECTION_END($this);


        // big items date
        AE_E_UTILS::SECTION_START($this, 'big-item-date-style', 'تاریخ پست های بزرگ', 'style', 'date', 'yes');
        AE_E_UTILS::FONT_FIELD($this, 'big-item-font-date-day', 'تایپوگرافی روز', '.wp-active-we-posts-masonry-2 .big-post .date .d');
        AE_E_UTILS::COLOR_FIELD($this, 'big-item-color-date-day', 'رنگ روز', '', '.wp-active-we-posts-masonry-2 .big-post .date .d', 'color');
        AE_E_UTILS::FONT_FIELD($this, 'big-item-font-date-month', 'تایپوگرافی ماه', '.wp-active-we-posts-masonry-2 .big-post .date .m');
        AE_E_UTILS::COLOR_FIELD($this, 'big-item-color-date-month', 'رنگ ماه', '', '.wp-active-we-posts-masonry-2 .big-post .date .m', 'color');
        AE_E_UTILS::DynamicStyleControls($this, 'big-item-date', '.wp-active-we-posts-masonry-2 .big-post .date', [
            'padding', 'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::SECTION_END($this);


        // tiny items
        AE_E_UTILS::SECTION_START($this, 'tiny-items-style', 'پست های کوچک', 'style');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'tiny-item-padding', 'فایله داخلی', '.wp-active-we-posts-masonry-2 .tiny-post', 'padding');

        AE_E_UTILS::Separator($this, 'tiny-item-title', 'عنوان');
        AE_E_UTILS::FONT_FIELD($this, 'tiny-item-title-font', 'تایپوگرافی', '.wp-active-we-posts-masonry-2 .tiny-posts .post-title h2');
        AE_E_UTILS::COLOR_FIELD($this, 'tiny-item-title-color', 'رنگ', '', '.wp-active-we-posts-masonry-2 .tiny-posts .post-title h2', 'color');
        AE_E_UTILS::COLOR_FIELD($this, 'tiny-item-title-color-hover', 'رنگ هاور', '', '.wp-active-we-posts-masonry-2 .tiny-posts .post-title:hover h2', 'color');

        AE_E_UTILS::Separator($this, 'tiny-item-infos', 'جزئیات');
        AE_E_UTILS::FONT_FIELD($this, 'tiny-item-infos-font', 'تایپوگرافی', '.wp-active-we-posts-masonry-2 .tiny-posts .details');
        AE_E_UTILS::COLOR_FIELD($this, 'tiny-item-infos-color', 'رنگ', '', '.wp-active-we-posts-masonry-2 .tiny-post .details .post-info .info-item', 'color');
        AE_E_UTILS::COLOR_FIELD($this, 'tiny-item-infos-color-link-hover', 'رنگ هاور لینک', '', '.wp-active-we-posts-masonry-2 .tiny-post .details .post-info a.info-item:hover', 'color');

        AE_E_UTILS::SECTION_END($this);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $query_args = $this->QueryArgBuilder();
        $query      = new WP_Query($query_args);

        if (!$query->have_posts()) {
            return;
        }

        $category_switch = $settings['category'];
        $comment         = $settings['comment'];
        $date            = $settings['date'];

        $this->add_render_attribute('post-masonry-container', 'class', ['wp-active-we-posts-masonry-2', 'd-grid']);
        if ($settings['intro-animation'] === 'yes') {
            $this->add_render_attribute('post-masonry-container', 'class', 'active-animation');
            $this->add_render_attribute('post-masonry-container', 'data-animation-target', '.elementor-element-' . $this->get_id() . ' .post-item');
            $this->add_render_attribute('post-masonry-container', 'data-animation-offset', '100');
        }

        ?>
        <div <?php $this->print_render_attribute_string('post-masonry-container'); ?>>
            <?php
            $counter = 1;
            while ($query->have_posts()) {
            $query->the_post();

            $link     = get_the_permalink();
            $title    = get_the_title();
            $category = AE_E_FUNCTIONS::getPostFirstCategory();

            if ($counter === 1 || $counter === 2) {
                ?>
                <div class="big-post post-item">
                    <a href="<?php echo esc_url($link); ?>" title="<?php esc_html_e($title); ?>" class="post-thumbnail">
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('medium_large');
                        } else {
                            echo '<img src="' . AE_E_IMG_DIR . 'default-thumb.jpg' . '" alt="' . $title . '">';
                        }
                        ?>
                    </a>
                    <?php if ($date) { ?>
                        <span class="date dfx dir-v aic jcc">
                        <span class="d"><?php echo get_the_date('d') ?></span>
                        <span class="m"><?php echo get_the_date('M') ?></span>
                    </span>
                    <?php } ?>
                    <div class="details">
                        <?php if ($category_switch || $comment) { ?>
                            <div class="post-info dfx wrap aic ae-gap-20">
                                <?php if ($category_switch) { ?>
                                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                                       title="<?php esc_html_e($category->name); ?>" rel="category"
                                       class="category info-item dfx aic ae-gap-5">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                             height="24">
                                            <path fill="none" d="M0 0h24v24H0z"/>
                                            <path d="M5 2h14a1 1 0 0 1 1 1v19.143a.5.5 0 0 1-.766.424L12 18.03l-7.234 4.536A.5.5 0 0 1 4 22.143V3a1 1 0 0 1 1-1zm13 2H6v15.432l6-3.761 6 3.761V4z"/>
                                        </svg>
                                        <?php esc_html_e($category->name); ?>
                                    </a>
                                <?php } ?>
                                <?php if ($comment) { ?>
                                    <span class="comment-number info-item dfx aic ae-gap-5">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                             height="24">
                                            <path fill="none" d="M0 0h24v24H0z"/>
                                            <path d="M6.455 19L2 22.5V4a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H6.455zm-.692-2H20V5H4v13.385L5.763 17zM11 10h2v2h-2v-2zm-4 0h2v2H7v-2zm8 0h2v2h-2v-2z"/>
                                        </svg>
                                        <?php comments_number(); ?>
                                    </span>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <a href="<?php echo esc_url($link); ?>" title="<?php esc_html_e($title); ?>"
                           class="post-title">
                            <h2><?php esc_html_e($title); ?></h2>
                        </a>
                    </div>
                </div>
            <?php } ?>

            <?php if ($counter > 2) { ?>
            <?php if ($counter === 3) { ?>
            <div class="tiny-posts d-grid ae-gap-20">
                <?php } ?>

                <div class="tiny-post post-item dfx aic ae-gap-10">
                    <a href="<?php echo esc_url($link); ?>" title="<?php esc_html_e($title); ?>" class="post-thumbnail">
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('thumbnail');
                        } else {
                            echo '<img src="' . AE_E_IMG_DIR . 'default-thumb.jpg' . '" alt="' . $title . '">';
                        }
                        ?>
                    </a>
                    <div class="details">
                        <a href="<?php echo esc_url($link); ?>" title="<?php esc_html_e($title); ?>"
                           class="post-title">
                            <h2><?php esc_html_e($title); ?></h2>
                        </a>
                        <?php if ($date || $category_switch || $comment) { ?>
                            <div class="post-info dfx wrap aic ae-gap-10">
                                <?php if ($category_switch) { ?>
                                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                                       title="<?php esc_html_e($category->name); ?>" rel="category"
                                       class="category info-item"><?php esc_html_e($category->name); ?></a>
                                <?php } ?>
                                <?php if ($comment) { ?>
                                    <span class="comment-number info-item"><?php comments_number(); ?></span>
                                <?php } ?>
                                <?php if ($date) { ?>
                                    <span class="date info-item"><?php echo get_the_date('Y/M/d') ?></span>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <?php }
                $counter++;
                } ?>
            </div>
            <!--/.tiny-posts-->
        </div>
        <?php

        wp_reset_postdata();
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_PostsMasonry2());
