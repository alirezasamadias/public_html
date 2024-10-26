<?php

namespace Elementor;

use RP_Utils;

defined('ABSPATH') || die();

class NaderProjects extends Widget_Base
{

    use \WP_QUERY_TRAIT;

    public function get_script_depends()
    {
        wp_register_script('nader-isotope', NADER_JS_DIR . 'isotope.pkgd.min.js', ['jquery'], 1, true);
        wp_register_script('nader-packery-mode-pkgd', NADER_JS_DIR . 'packery-mode.pkgd.min.js', ['jquery',], 1, true);
        wp_register_script('nader-projects-widget', NADER_ELEMENTOR_JS_DIR . 'nader-projects.js', ['jquery', 'nader-isotope', 'nader-packery-mode-pkgd',], '1.0.0', true);

        return ['jquery', 'nader-isotope', 'nader-packery-mode-pkgd', 'nader-projects-widget'];
    }

    public function get_name()
    {
        return 'NaderProjects';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : پروژه ها';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-gallery-grid';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        RP_Utils::SELECT_FIELD($this, 'column-desktop', 'ستون دسکتاپ', [
            'col-lg-6' => '2',
            'col-lg-4' => '3',
            'col-lg-3' => '4',
            'col-lg-2' => '6',
        ], 'col-lg-3');

        RP_Utils::SELECT_FIELD($this, 'column-tablet', 'ستون تبلت', [
            'col-md-6' => '2',
            'col-md-4' => '3',
            'col-md-3' => '4',
            'col-md-2' => '6',
        ], 'col-md-4');

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image-dimensions_size',
                // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
                'default'   => 'large',
                'separator' => 'none',
                'exclude'   => ['custom']
            ]
        );

        RP_Utils::SWITCH_FIELD($this, 'enable_filter', 'فیلتر', 'yes');
        $taxonomies = [
            'project_cat' => 'دسته پروژه ها',
            'category'    => 'دسته بندی ها',
            'post_tag'    => 'برچسب ها'
        ];
        RP_Utils::SELECT_FIELD($this, 'filter', 'تکسونومی', $taxonomies, 'project_cat', 'enable_filter', 'yes');

        $this->end_controls_section();

        // Query Settings
        $this->QuerySettings();


        // item styles
        $this->start_controls_section('item-styles', [
            'label' => 'استایل آیتم',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);
        RP_Utils::SELECT_FIELD($this, 'gutter', 'فاصله بین', [
            'g-0' => '0',
            'g-1' => '1',
            'g-2' => '2',
            'g-3' => '3',
            'g-4' => '4',
            'g-5' => '5',
        ], 'g-3');
        RP_Utils::SLIDER_FIELD_PIX_STYLE($this, 'item-height', 'ارتفاع', 100, 500, 400, '.nader-projects .portfolio-inner .item .img-box', 'height');
        RP_Utils::DIMENSIONS_FIELD($this, 'item-border-radius', 'خمیدگی', '.nader-projects .portfolio-inner .item', 'border-radius');
        RP_Utils::SHADOW_FIELD($this, 'item-shadow', 'سایه', '.nader-projects .portfolio-inner .item');
        $this->end_controls_section();


        // text style
        $this->start_controls_section('text-styles', [
            'label' => 'متن',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);
        $text_styles = [
            [
                'type'   => 'text-small',
                'target' => '.nader-projects .portfolio-inner .item .item-label p'
            ],
            [
                'type' => 'bg-c',
            ]
        ];
        RP_Utils::VariantUtils($this, 'text_styles', '.nader-projects .portfolio-inner .item .item-label', $text_styles);
        $this->end_controls_section();


        // filter
        $this->start_controls_section('filter-styles', [
            'label' => 'فیلتر',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);
        $filter_styles = [
            [
                'type'   => 'text-align',
                'uniq'   => 'box',
                'target' => '.nader-projects .filter-button'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله',
                'min'    => 0,
                'max'    => 100,
                'def'    => 60,
                'css'    => 'margin-bottom',
                'uniq'   => 'box',
                'target' => '.nader-projects .filter-button'
            ],
            [
                'type' => 'tab-start',
            ],
            [
                'type'  => '4dir',
                'css'   => 'padding',
                'title' => 'فاصله درونی'
            ],
            [
                'type' => 'text-small',
            ],
            [
                'type' => 'bg-c',
            ],
            [
                'type'  => 'border',
                'title' => 'حاشیه'
            ],
            [
                'type'  => '4dir',
                'css'   => 'border-radius',
                'title' => 'خمیدگی',
            ],
            [
                'type'  => 'tab-middle',
                'title' => 'فعال'
            ],
            [
                'type'   => '4dir',
                'css'    => 'padding',
                'title'  => 'فاصله درونی',
                'uniq'   => 'active',
                'target' => '.nader-projects .filter-button li.active'
            ],
            [
                'type'   => 'text-small',
                'uniq'   => 'active',
                'target' => '.nader-projects .filter-button li.active'
            ],
            [
                'type'   => 'bg-c',
                'uniq'   => 'active',
                'target' => '.nader-projects .filter-button li.active'
            ],
            [
                'type'   => 'border',
                'title'  => 'حاشیه',
                'uniq'   => 'active',
                'target' => '.nader-projects .filter-button li.active'
            ],
            [
                'type'   => '4dir',
                'css'    => 'border-radius',
                'title'  => 'خمیدگی',
                'uniq'   => 'active',
                'target' => '.nader-projects .filter-button li.active'
            ],
            [
                'type' => 'tab-end',
            ],
        ];
        RP_Utils::VariantUtils($this, 'filter-styles', '.nader-projects .filter-button li', $filter_styles);
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
            ['type' => 'text-small',],
            ['type' => 'text-align'],
            ['type' => 'box-styles']
        ]);
        $this->end_controls_section();

    }


    private function extract_terms($QUERY, $tax_name)
    {
        $terms = [];
        while ($QUERY->have_posts()) {
            $QUERY->the_post();
            $pt = get_the_terms(get_the_ID(), $tax_name);
            if ($pt !== false && !is_wp_error($pt)) {
                foreach ($pt as $term) {
                    $terms[] = [$tax_name . '-' . $term->term_id => $term->name];
                }
            }
        }

        wp_reset_postdata();

        // unique array
        return array_map("unserialize", array_unique(array_map("serialize", $terms)));
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $ID       = $this->get_id();

        $ARGS  = $this->QueryArgBuilder();
        $QUERY = new \WP_Query($ARGS);

        if ($QUERY->have_posts()) {

            $enable_filter = $settings['enable_filter'];
            $taxonomy      = $settings['filter'];
            $filters       = $this->extract_terms($QUERY, $taxonomy);

            $column_desktop = $settings['column-desktop'];
            $column_tablet  = $settings['column-tablet'];
            $gutter         = $settings['gutter'];
            $image_size     = $settings['image-dimensions_size_size'];

            ?>

            <div class="nader-projects nader-projects-<?php echo $ID; ?> portfolio-wrapper"
                 data-wid="<?php echo $ID; ?>">

                <?php if ($enable_filter && !empty($filters)) { ?>
                    <ul class="filter-button">
                        <li class="active" data-filter="*"><?php _e('All', 'nader'); ?></li>
                        <?php foreach ($filters as $filter) { ?>
                            <li data-filter=".<?php echo esc_attr(key($filter)); ?>"><?php echo esc_html(current($filter)); ?></li>
                        <?php } ?>
                    </ul>
                <?php } ?>

                <div class="portfolio-inner row <?php echo $gutter; ?>">
                    <?php
                    while ($QUERY->have_posts()) {
                        $QUERY->the_post();
                        $classes = ['col-12', 'col-sm-6', $column_tablet, $column_desktop, 'portfolio-item'];
                        $terms = get_the_terms(get_the_ID(), $taxonomy);
                        if (!empty($terms)) {
                            foreach ($terms as $term) {
                                $classes[] = $taxonomy . '-' . $term->term_id;
                            }
                        }
                        ?>
                        <div <?php post_class($classes); ?>>
                            <div class="item-wrapper">
                                <div class="item">
                                    <a href="<?php the_post_thumbnail_url('full'); ?>" title="<?php the_title(); ?>"
                                       class="img-box" data-elementor-lightbox-slideshow="nader-project-gallery">
                                        <img src="<?php the_post_thumbnail_url($image_size); ?>"
                                             alt="<?php the_title(); ?>" width="150" height="197">
                                    </a>
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <div class="item-label dfx aic jcc">
                                            <p><?php the_title(); ?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <?php

            $pn_args = ['echo' => false, 'query' => $QUERY];
            if (!empty(ae_pagination($pn_args))) {
                ae_pagination(array('query' => $QUERY));
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

Plugin::instance()->widgets_manager->register(new NaderProjects());
