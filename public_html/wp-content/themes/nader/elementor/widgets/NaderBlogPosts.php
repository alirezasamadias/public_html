<?php

namespace Elementor;

use RealPressHelper;
use RP_Utils;
use WP_QUERY_TRAIT;

defined('ABSPATH') || die();

class NaderBlogPosts extends Widget_Base{

    use WP_QUERY_TRAIT;

    public function get_name()
    {
        return 'NaderBlogPosts';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : پست ها';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-post-list';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        $this->add_responsive_control('style', [
            'label'                => 'حالت',
            'type'                 => Controls_Manager::SELECT,
            'label_block'          => false,
            'options'              => [
                'column' => 'عمودی',
                'row'    => 'افقی'
            ],
            'default'              => 'column',
            'selectors_dictionary' => [
                'column' => 'display: flex; flex-direction: column;',
                'row'    => 'display: flex; flex-direction: row;'
            ],
            'selectors'            => [
                '{{WRAPPER}} .nader-blog-posts .blog-post-item' => '{{VALUE}}'
            ]
        ]);

        $this->add_responsive_control('column', [
            'label'       => 'ستون',
            'type'        => Controls_Manager::NUMBER,
            'label_block' => false,
            'min'         => 1,
            'max'         => 5,
            'step'        => 1,
            'default'     => 3,
            'dynamic'     => [
                'active' => true,
            ],
            'selectors'   => [
                '{{WRAPPER}} .nader-blog-posts' => 'grid-template-columns: repeat({{VALUE}}, 1fr)'
            ]
        ]);
        RP_Utils::SLIDER_FIELD_PIX_STYLE($this, 'columns-gap', 'فاصله بین افقی', 0, 100, 25, '.nader-blog-posts', 'column-gap');
        RP_Utils::SLIDER_FIELD_PIX_STYLE($this, 'row-gap', 'فاصله بین عمودی', 0, 100, 25, '.nader-blog-posts', 'row-gap');

        RP_Utils::SWITCH_FIELD($this, 'date', 'تاریخ', 'yes');
        RP_Utils::SWITCH_FIELD($this, 'category', 'دسته بندی', 'yes');
        RP_Utils::SWITCH_FIELD($this, 'read-more-btn', 'دکمه ادامه مطلب', 'yes');
        RP_Utils::SWITCH_FIELD($this, 'price', 'قیمت', 'yes');
        RP_Utils::TXT_FIELD($this, 'read-more-btn-text', 'متن دکمه ادامه مطلب', 'بیشتر...', true, 'read-more-btn', 'yes');
        RP_Utils::SWITCH_FIELD($this, 'excerpt', 'خلاصه مطلب', 'yes');
        RP_Utils::NUMBER_FIELD($this, 'excerpt-length', 'طول خلاصه مطلب', 10, 55, 1, 30, true, 'excerpt', 'yes');

        $this->add_group_control(Group_Control_Image_Size::get_type(), [
            'name'      => 'image-dimensions_size',
            // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
            'default'   => 'large',
            'separator' => 'none',
            'exclude'   => ['custom']
        ]);

        RP_Utils::SLIDER_FIELD_PIX_STYLE($this, 'image-size-css-height', 'ارتفاع تصویر', 100, 500, 240, '.nader-blog-posts .blog-post-item .post-media', 'height');
        $this->add_responsive_control('image-size-css-width', [
            'label'       => 'عرض تصویر',
            'type'        => Controls_Manager::SLIDER,
            'label_block' => true,
            'size_units'  => ['%'],
            'range'       => [
                '%' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'default'     => [
                'size' => 35
            ],
            'selectors'   => [
                '{{WRAPPER}} .nader-blog-posts .blog-post-item .post-media' => 'width: {{SIZE}}%;',
            ],
        ]);
        $this->add_responsive_control('content-size-css-width', [
            'label'       => 'عرض محتوا',
            'type'        => Controls_Manager::SLIDER,
            'label_block' => true,
            'size_units'  => ['%'],
            'range'       => [
                '%' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'default'     => [
                'size' => 60
            ],
            'selectors'   => [
                '{{WRAPPER}} .nader-blog-posts .blog-post-item .post-details' => 'width: {{SIZE}}%',
            ],
        ]);
        $this->add_responsive_control('image-distance', [
            'label'       => 'فاصله بین تصویر و محتوا',
            'type'        => Controls_Manager::SLIDER,
            'label_block' => true,
            'size_units'  => ['px'],
            'range'       => [
                'px' => [
                    'min' => 0,
                    'max' => 50,
                ],
            ],
            'default'     => [
                'size' => 20
            ],
            'selectors'   => [
                '{{WRAPPER}} .nader-blog-posts .blog-post-item' => 'gap: {{SIZE}}px;',
            ],
        ]);

        $this->end_controls_section();

        // Query Settings
        $this->QuerySettings();


        // styles
        RP_Utils::SECTION_START($this, 'styles', 'استایل', 'style');
        $blog_item = [
            [
                'type'   => '4dir',
                'title'  => 'خمیدگی تصویر',
                'css'    => 'border-radius',
                'uniq'   => 'image-border-radius',
                'target' => '.nader-blog-posts .blog-post-item .post-media'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله تصویر از بالا',
                'min'    => -100,
                'max'    => 100,
                'def'    => 0,
                'css'    => 'margin-top',
                'uniq'   => 'image-mt',
                'target' => '.nader-blog-posts .blog-post-item .post-media'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله باکس اطلاعات از بالا',
                'min'    => 0,
                'max'    => 50,
                'def'    => 10,
                'css'    => 'margin-top',
                'uniq'   => 'detail-box-mt',
                'target' => '.nader-blog-posts .blog-post-item .post-details'
            ],
            [
                'type' => 'tab-start',
            ],
            [
                'type' => 'box-styles',
                'uniq' => 'normal',
            ],
            [
                'type'  => 'tab-middle',
                'title' => 'هاور'
            ],
            [
                'type'   => 'box-styles',
                'uniq'   => 'hover',
                'target' => '.blog-post-item-wrapper:hover'
            ],
            [
                'type' => 'tab-end',
            ],
        ];
        RP_Utils::VariantUtils($this, 'blog-item', '.blog-post-item', $blog_item);
        RP_Utils::SECTION_END($this);


        // texts style
        RP_Utils::SECTION_START($this, 'texts-styles', 'متن', 'style');
        $texts_style = [
            [
                'type'   => '4dir',
                'title'  => 'فاصله داخلی',
                'uniq'   => 'text-box',
                'css'    => 'padding',
                'target' => '.nader-blog-posts .blog-post-item .post-details'
            ],
            [
                'type'  => 'sep',
                'title' => 'عنوان',
                'uniq'  => 'title'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله',
                'min'    => 0,
                'max'    => 50,
                'def'    => 10,
                'css'    => 'margin-bottom',
                'uniq'   => 'title',
                'target' => '.nader-blog-posts .blog-post-item .post-details .blog-title'
            ],
            [
                'type'   => 'text-small',
                'uniq'   => 'title',
                'target' => '.nader-blog-posts .blog-post-item .post-details .blog-title a'
            ],
            [
                'type'   => 'color',
                'uniq'   => 'title-hover',
                'target' => '.nader-blog-posts .blog-post-item .post-details .blog-title a:hover',
                'title'  => 'رنگ هاور'
            ],
            [
                'type'   => 'text-align',
                'uniq'   => 'title',
                'target' => '.nader-blog-posts .blog-post-item .post-details .blog-title'
            ],
            [
                'type'  => 'sep',
                'title' => 'خلاصه',
                'uniq'  => 'excerpt'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله',
                'min'    => 0,
                'max'    => 50,
                'def'    => 20,
                'css'    => 'margin-bottom',
                'uniq'   => 'excerpt',
                'target' => '.nader-blog-posts .blog-post-item .post-details .desc'
            ],
            [
                'type'   => 'text-small',
                'uniq'   => 'excerpt',
                'target' => '.nader-blog-posts .blog-post-item .post-details .desc'
            ],
            [
                'type'   => 'text-align',
                'uniq'   => 'excerpt',
                'target' => '.nader-blog-posts .blog-post-item .post-details .desc'
            ],
            [
                'type'  => 'sep',
                'title' => 'دسته بندی و تاریخ',
                'uniq'  => 'cat-date'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله',
                'min'    => 0,
                'max'    => 30,
                'def'    => 5,
                'css'    => 'margin-bottom',
                'uniq'   => 'cat-date',
                'target' => '.nader-blog-posts .blog-post-item .post-details .date'
            ],
            [
                'type'   => 'text-small',
                'uniq'   => 'cat-date',
                'target' => '.nader-blog-posts .blog-post-item .post-details .date'
            ],
            [
                'type'   => 'color-v',
                'uniq'   => 'cat-normal',
                'target' => '.nader-blog-posts .blog-post-item .post-details .date a',
                'title'  => 'رنگ لینک',
                'css'    => 'color'
            ],
            [
                'type'   => 'color-v',
                'uniq'   => 'cat-hover',
                'target' => '.nader-blog-posts .blog-post-item .post-details .date a:hover',
                'title'  => 'رنگ هاور لینک',
                'css'    => 'color'
            ],
            [
                'type'  => 'sep',
                'title' => 'قیمت',
                'uniq'  => 'price'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله بالا',
                'min'    => 0,
                'max'    => 50,
                'def'    => 5,
                'css'    => 'margin-top',
                'uniq'   => 'price',
                'target' => '.nader-blog-posts .blog-post-item .post-details .product-price'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله پایین',
                'min'    => 0,
                'max'    => 50,
                'def'    => 5,
                'css'    => 'margin-bottom',
                'uniq'   => 'price',
                'target' => '.nader-blog-posts .blog-post-item .post-details .product-price'
            ],
            [
                'type'   => 'text-small',
                'uniq'   => 'price',
                'target' => '.nader-blog-posts .blog-post-item .post-details .product-price'
            ],
            [
                'type'   => 'text-align',
                'uniq'   => 'price',
                'target' => '.nader-blog-posts .blog-post-item .post-details .product-price'
            ],
        ];
        RP_Utils::VariantUtils($this, 'item-texts', '', $texts_style);
        RP_Utils::SECTION_END($this);


        // button style
        $this->start_controls_section('button-style', [
            'label' => 'دکمه',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);
        $button_style = [
            [
                'type'   => '4dir',
                'title'  => 'فاصله داخلی',
                'uniq'   => 'normal',
                'css'    => 'padding',
                'target' => '.btn-style2',
            ],
            [
                'type'   => 'text-small',
                'uniq'   => 'normal',
                'target' => '.btn-style2',
            ],
            [
                'type'   => 'color',
                'uniq'   => 'hover',
                'target' => '.nader-blog-posts .blog-post-item-wrapper:hover [class*="btn"]',
                'title'  => 'رنگ هاور'
            ],
            [
                'type'   => 'color-v',
                'uniq'   => 'normal',
                'target' => '.btn-style2:before',
                'title'  => 'بکگراند',
                'css'    => 'background-color'
            ],
            [
                'type'   => 'color-v',
                'uniq'   => 'hover',
                'target' => '.nader-blog-posts .blog-post-item-wrapper:hover [class*="btn"]::before',
                'title'  => 'بکگراند هاور',
                'css'    => 'background-color'
            ],
            [
                'type'   => '4dir',
                'title'  => 'خمیدگی',
                'uniq'   => 'normal',
                'css'    => 'border-radius',
                'target' => '.btn-style2',
            ],
        ];
        RP_Utils::VariantUtils($this, 'read-more-btn', '', $button_style);
        $this->end_controls_section();


        // pagination
        $this->start_controls_section('pagination', [
            'label'     => 'صفحه بندی',
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
                'no_found_rows' => 'yes'
            ]
        ]);
        $pagination = [
            [
                'type'  => 'sep',
                'title' => 'باکس',
                'uniq'  => 'box'
            ],
            [
                'type' => 'text-small',
                'uniq' => 'regular-texts',
            ],
            [
                'type' => 'box-styles'
            ],
            [
                'type'  => 'sep',
                'title' => 'لینک',
                'uniq'  => 'link'
            ],
            [
                'type' => 'tab-start',
            ],
            [
                'type'   => 'box-styles',
                'uniq'   => 'normal',
                'target' => '.wp-pagenavi a'
            ],
            [
                'type'  => 'tab-middle',
                'title' => 'حالت هاور'
            ],
            [
                'type'   => 'color',
                'uniq'   => 'hover',
                'title'  => 'رنگ',
                'target' => '.wp-pagenavi a:hover'
            ],
            [
                'type'   => 'box-styles',
                'uniq'   => 'hover',
                'target' => '.wp-pagenavi a:hover'
            ],
            [
                'type' => 'tab-end',
            ],
            [
                'type'  => 'sep',
                'title' => 'فعال',
                'uniq'  => 'active'
            ],
            [
                'type'   => 'text-small',
                'uniq'   => 'active',
                'target' => '.wp-pagenavi span.current'
            ],
            [
                'type'   => 'box-styles',
                'uniq'   => 'active',
                'target' => '.wp-pagenavi span.current'
            ],
        ];
        RP_Utils::VariantUtils($this, 'pagination', '.wp-pagenavi', $pagination);
        $this->end_controls_section();


        // QUERY have no post Style
        $this->start_controls_section('no-more-posts-msg-styles', [
            'label' => 'پیام عدم وجود پست',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);
        RP_Utils::VariantUtils($this, 'this-query-has-no-post', '.nader-query-have-not-post', [
            [
                'type' => 'text-small',
            ],
            [
                'type' => 'text-align'
            ],
            [
                'type' => 'box-styles'
            ]
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $ARGS = $this->QueryArgBuilder();
        $QUERY = new \WP_Query($ARGS);

        if ($QUERY->have_posts()) {
            $date = $settings['date'];
            $category = $settings['category'];
            $read_more_btn = $settings['read-more-btn'];
            $read_more_btn_text = $settings['read-more-btn-text'];
            $price = $settings['price'];
            $excerpt = $settings['excerpt'];
            $excerpt_length = $settings['excerpt-length'];

            $image_size = $settings['image-dimensions_size_size'];

            ?>

            <div class="nader-blog-posts blog-post-group">

                <?php
                while ($QUERY->have_posts()) {
                    $QUERY->the_post();

                    $post_type = get_post_type(get_the_ID());

                    ?>
                    <div class="blog-post-item-wrapper">
                        <div <?php post_class('blog-post-item'); ?>>
                            <div class="post-media">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <img src="<?php the_post_thumbnail_url($image_size); ?>"
                                         class="img-fluid" width="325"
                                         height="205"
                                         alt="<?php the_title(); ?>">
                                </a>
                            </div>
                            <div class="post-details">
                                <?php
                                if ($date || $category) {
                                    ?>
                                    <p class="date">
                                        <?php
                                        if ($date) {
                                            echo get_the_date();
                                        }

                                        if ($category) {
                                            if ($date) {
                                                echo ' - ';
                                            }

                                            $CAT = RealPressHelper::getPostFirstCategory();
                                            if ($CAT) { ?>
                                                <a href="<?php echo esc_url(get_term_link($CAT->term_id)); ?>"
                                                   title="<?php echo esc_html($CAT->name); ?>"
                                                   rel="category">
                                                    <?php echo esc_html($CAT->name); ?>
                                                </a>
                                            <?php }
                                        } ?>
                                    </p>
                                <?php } ?>
                                <h2 class="blog-title ellipsis-2">
                                    <a href="<?php the_permalink(); ?>"
                                       title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <?php
                                if ($post_type !== 'product' && $excerpt) {
                                    $excerpt_txt = get_the_excerpt();
                                    $excerpt_txt = str_replace('[...]', '', $excerpt_txt);
                                    $excerpt_txt = explode(' ', $excerpt_txt);
                                    $excerpt_txt = array_slice($excerpt_txt, 0, $excerpt_length);
                                    $excerpt_txt = implode(' ', $excerpt_txt);
                                    ?>
                                    <p class="desc"><?php echo wp_kses_post($excerpt_txt); ?></p>
                                <?php }

                                if ($price && function_exists('WC') && get_post_type() === 'product') {
                                    $product = wc_get_product(get_the_ID());

                                    echo '<div class="product-price">' . $product->get_price_html() . '</div>';
                                }

                                if ($read_more_btn) { ?>
                                    <a href="<?php the_permalink(); ?>" class="btn-style2"
                                       title="<?php the_title(); ?>"><?php echo esc_html($read_more_btn_text); ?></a>
                                <?php }

                                ?>
                            </div>
                        </div>
                    </div>
                <?php }
                ?>

            </div>

            <?php

            $pn_args = ['echo' => false, 'query' => $QUERY];
            if (!empty(ae_pagination($pn_args))) {
                ae_pagination(['query' => $QUERY]);
            }
        } else {
            $msg = $settings['no_post_found'];
            ?>
            <p class="nader-query-have-not-post"><?php echo esc_html($msg); ?></p>
            <?php
        }

        wp_reset_postdata();
    }

}

Plugin::instance()->widgets_manager->register(new NaderBlogPosts());
