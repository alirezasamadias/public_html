<?php
namespace Elementor;

defined('ABSPATH') || die();

use RP_Utils;
use RealPressHelper;
use NaderUtils;
use OwlCarousel;
use WP_QUERY_TRAIT;

class NaderBlogPostsSlider extends Widget_Base
{

    use OwlCarousel;
    use WP_QUERY_TRAIT;

    public function get_script_depends()
    {
        wp_register_script('nader-owl-carousel', NADER_JS_DIR . 'owl.carousel.min.js', ['jquery'], 1, true);
        wp_register_script('nader-blog-posts-slider-widget', NADER_ELEMENTOR_JS_DIR . 'nader-blog-posts-slider.js', ['jquery', 'nader-owl-carousel'], '1.0.0', true);

        return [
            'jquery',
            'nader-owl-carousel',
            'nader-blog-posts-slider-widget'
        ];
    }

    public function get_style_depends()
    {
        wp_register_style('nader-owl-css', NADER_CSS_DIR . 'owl.carousel.min.css');
        return ['nader-owl-css'];
    }

    public function get_name()
    {
        return 'NaderBlogPostsSlider';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : اسلایدر پست ها';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-slider-push';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        $slide_style = [
            'under-image' => 'زیر عکس',
            'overlay'     => 'روی عکس'
        ];
        RP_Utils::SELECT_FIELD($this, 'slide-style', 'استایل', $slide_style, 'under-image');

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image-dimensions_size',
                // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
                'default'   => 'medium',
                'separator' => 'none',
                'exclude'   => ['custom']
            ]
        );

        RP_Utils::SLIDER_FIELD_PIX_STYLE($this,
            'image-size-css-height',
            'ارتفاع عکس',
            100,
            400,
            200,
            '.blog-post-slider-item .blog-post-slider-media',
            'height');

        $this->end_controls_section();

        // Query Settings
        $this->QuerySettings();

        // slider settings
        $this->OwlSettings();


        // box styles
        $this->start_controls_section('box-styles', [
            'label' => 'باکس',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);
        $blog_item = [
            [
                'type' => 'box-styles',
                'uniq' => 'normal',
            ],
            [
                'type'  => 'sep',
                'title' => 'فوتر',
                'uniq'  => 'footer-normal'
            ],
            [
                'type'   => 'border',
                'title'  => 'حاشیه فوتر',
                'target' => '.blog-post-slider-item .blog-post-slider-footer',
                'uniq'   => 'footer-normal'
            ],
        ];
        RP_Utils::VariantUtils($this, 'blog-item', '.blog-post-slider-item', $blog_item);
        $this->end_controls_section();


        $this->start_controls_section('text-styles', [
            'label' => 'متن ها',
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);
        $text_styles = [
            [
                'type'  => 'sep',
                'uniq'  => 'title',
                'title' => 'عنوان',
            ],
            [
                'type'   => 'text-small',
                'uniq'   => 'title',
                'target' => '.blog-post-slider-item .blog-post-slider-body .post-item-title'
            ],
            [
                'type'   => 'color',
                'title'  => 'رنگ هاور',
                'uniq'   => 'title-hover',
                'target' => '.blog-post-slider-item .blog-post-slider-body .post-item-title a:hover'
            ],
            [
                'type'  => 'sep',
                'uniq'  => 'price',
                'title' => 'قیمت عادی',
            ],
            [
                'type'   => 'text-small',
                'uniq'   => 'price',
                'target' => '.blog-post-slider-item .blog-post-slider-body .product-details .price'
            ],
            [
                'type'  => 'sep',
                'uniq'  => 'price-del',
                'title' => 'قیمت خط خورده',
            ],
            [
                'type'   => 'text-small',
                'uniq'   => 'price-del',
                'target' => '.blog-post-slider-item .blog-post-slider-body .product-details .price del'
            ],
            [
                'type'  => 'sep',
                'uniq'  => 'rating',
                'title' => 'امتیاز',
            ],
            [
                'type'   => 'text-small',
                'uniq'   => 'rating',
                'target' => '.blog-post-slider-item .blog-post-slider-body .product-details .rating'
            ],
            [
                'type'  => 'sep',
                'uniq'  => 'footer',
                'title' => 'پاورقی',
            ],
            [
                'type'   => 'text-small',
                'target' => '.blog-post-slider-item .blog-post-slider-footer, {{WRAPPER}} .blog-post-slider-item .blog-post-slider-footer a',
                'uniq'   => 'slide-footer',
            ]
        ];
        RP_Utils::VariantUtils($this, 'text-styles', '', $text_styles);


        $this->add_control(
            'slide-add-to-cart-color',
            [
                'label'       => 'رنگ عادی افزودن به سبد خرید',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'default'     => '#D79D4B',
                'condition'   => [
                    'post_type' => 'product'
                ],
                'selectors'   => [
                    '{{WRAPPER}} .blog-post-slider-item .blog-post-slider-footer .add-to-cart-btn'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .blog-post-slider-item .blog-post-slider-footer .add-to-cart-btn svg' => 'fill: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'slide-add-to-cart-bg',
            [
                'label'       => 'بکگراند عادی افزودن به سبد خرید',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .blog-post-slider-item .blog-post-slider-footer .add-to-cart-btn' => 'background: {{VALUE}};',
                ],
                'condition'   => [
                    'post_type' => 'product'
                ],
            ]
        );
        $this->add_control(
            'slide-add-to-cart-color-hover',
            [
                'label'       => 'رنگ هاور افزودن به سبد خرید',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .blog-post-slider-item .blog-post-slider-footer .add-to-cart-btn:hover'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .blog-post-slider-item .blog-post-slider-footer .add-to-cart-btn:hover svg' => 'fill: {{VALUE}};',
                ],
                'condition'   => [
                    'post_type' => 'product'
                ],
            ]
        );
        $this->add_control(
            'slide-add-to-cart-bg-hover',
            [
                'label'       => 'بکگراند هاور افزودن به سبد خرید',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .blog-post-slider-item .blog-post-slider-footer .add-to-cart-btn:hover' => 'background: {{VALUE}};',
                ],
                'condition'   => [
                    'post_type' => 'product'
                ],
            ]
        );

        $this->end_controls_section();


        $this->OwlStylesNextPrevBtn();

        $this->OwlStylesDotSettings();
    }

    protected function render()
    {
        $settings   = $this->get_settings_for_display();
        $image_size = $settings['image-dimensions_size_size'];

        $slider_settings = $this->RenderOwlSettings();

        $slide_style = $settings['slide-style'];


        $this->add_render_attribute('nader-blog-posts-slider-attrs',
            'class',
            'nader-blog-posts-slider'
        );

        $ARGS  = $this->QueryArgBuilder();
        $QUERY = new \WP_Query($ARGS);

        if ($QUERY->have_posts()) {
            $this->add_render_attribute('nader-blog-posts-slider-attrs',
                'class',
                'owl-carousel'
            );

            $this->add_render_attribute('nader-blog-posts-slider-attrs',
                'data-slider-settings',
                json_encode($slider_settings)
            );

            $this->add_render_attribute('nader-blog-posts-slider-slide-item-class',
                'class',
                'blog-post-slider-item');
            $this->add_render_attribute('nader-blog-posts-slider-slide-item-class',
                'class',
                $slide_style);

            ?>

            <div <?php $this->print_render_attribute_string('nader-blog-posts-slider-attrs'); ?>>

                <?php

                $i = 1;

                while ($QUERY->have_posts()) {
                    $QUERY->the_post();
                    $post_type = get_post_type(get_the_ID());
                    $product   = null;
                    if ($post_type === 'product') {
                        if (!function_exists('WC')) {
                            continue;
                        }
                        $product = wc_get_product(get_the_ID());
                    }


                    $this->add_render_attribute('blog-post-slider-item-wrapper-attrs' . $i, 'class', 'blog-post-slider-item-wrapper');
                    $this->add_render_attribute('blog-post-slider-item-wrapper-attrs' . $i, 'class', get_post_class());

                    ?>
                    <div <?php $this->print_render_attribute_string('blog-post-slider-item-wrapper-attrs' . $i); ?>>
                        <div <?php $this->print_render_attribute_string('nader-blog-posts-slider-slide-item-class'); ?>>

                            <div class="blog-post-slider-media dfx jcc aic">
                                <?php the_post_thumbnail($image_size); ?>
                            </div>

                            <?php
                            if ($slide_style === 'overlay') {
                                echo '<div class="blog-post-slider-item-inner">';
                            }
                            ?>

                            <div class="blog-post-slider-body">
                                <h3 class="post-item-title ellipsis-2">
                                    <a href="<?php the_permalink(); ?>"
                                       title="<?php the_title() ?>">
                                        <?php the_title() ?>
                                        <br>
                                    </a>
                                </h3>

                                <?php
                                if ($post_type === 'product' && $slide_style !== 'overlay') {
                                    ?>
                                    <div class="product-details dfx jcsb aic">

                                        <strong class="price">
                                            <?php echo $product->get_price_html(); ?>
                                        </strong>

                                        <?php if (wc_review_ratings_enabled()) {
                                            echo '<span class="rating">';
                                            echo $product->get_average_rating() . ' ' . __('points', 'nader');
                                            echo '</span>';
                                        } ?>

                                    </div>
                                <?php } ?>

                            </div>


                            <?php if ($slide_style != 'overlay') { ?>
                                <div class="blog-post-slider-footer">
                                    <?php
                                    if ($post_type !== 'product') {
                                        echo get_the_date() . ' - ';
                                        $CAT = RealPressHelper::getPostFirstCategory();
                                        if ($CAT) { ?>
                                            <a href="<?php echo esc_url(get_term_link($CAT->term_id)); ?>"
                                               title="<?php echo esc_html($CAT->name); ?>"
                                               rel="category" class="cat_name">
                                                <?php echo esc_html($CAT->name); ?>
                                            </a>
                                        <?php }
                                    } else { ?>
                                        <a href="<?php echo esc_url(esc_url($product->add_to_cart_url())); ?>"
                                           title="<?php echo __('Add To Cart', 'nader'); ?>"
                                           class="add-to-cart-btn dfx aic jcc">
                                            <?php echo NaderUtils::iconAddToCart(2); ?>
                                            <?php echo __('Add To Cart', 'nader'); ?>
                                        </a>
                                    <?php }
                                    ?>
                                </div>
                                <!--/.blog-post-slider-footer-->
                                <?php
                            }


                            if ($slide_style === 'overlay') {
                                echo '</div>';
                            }

                            ?>
                        </div>
                        <!--/.blog-post-slider-item-->
                    </div>
                    <?php $i++;
                } ?>

            </div>

            <?php
        } else {
            $this->add_render_attribute('nader-blog-posts-slider-attrs',
                'class',
                'query-has-no-post'
            );
        }

        wp_reset_postdata();
    }

}

Plugin::instance()->widgets_manager->register(new NaderBlogPostsSlider());
