<?php

use Elementor\Controls_Manager;

defined('ABSPATH') || die();

trait WP_ACTIVE_WE_QueryBuilder{

    protected function QuerySettings($condition = false, $condition_value = null)
    {
        $META_COMPARE_OPTIONS = [
            '='      => 'برابر باشد',
            '!='     => 'برابر نباشد',
            '>'      => 'بزرگتر',
            '>='     => 'بزرگتر مساوی',
            '<'      => 'کوچکتر',
            '<='     => 'کوچکتر مساوی',
            'IN'     => 'IN',
            'NOT IN' => 'NOT IN',
        ];

        $META_VALUE_TYPES = [
            'NUMERIC'  => 'NUMERIC',
            'BINARY'   => 'BINARY',
            'CHAR'     => 'CHAR',
            'DECIMAL'  => 'DECIMAL',
            'DATETIME' => 'DATETIME',
        ];

        $TAXONOMY_OPERATORS = [
            'IN'         => 'IN',
            'NOT IN'     => 'NOT IN',
            'EXISTS'     => 'EXISTS',
            'NOT EXISTS' => 'NOT EXISTS',
            'AND'        => 'AND',
        ];

        $POST_STATUS = [
            'publish' => 'منتشر شده',
            'private' => 'خصوصی',
            'pending' => 'در انتشار',
            'draft'   => 'پیش نویس',
            'trash'   => 'حذف شده',
            'any'     => 'هر نوع',
        ];


        if ($condition) {
            $condition = [
                $condition => $condition_value
            ];
            $this->start_controls_section('query_settings', ['label' => 'تنظیمات کوئری', 'condition' => $condition]);
        } else {
            $this->start_controls_section('query_settings', ['label' => 'تنظیمات کوئری']);
        }

        $this->add_control('related_posts', [
            'label'        => 'پست های مرتبط',
            'type'         => Controls_Manager::SWITCHER,
            'label_block'  => false,
            'label_on'     => 'بله',
            'label_off'    => 'خیر',
            'return_value' => 'yes',
            'default'      => '',
        ]);

        AE_E_UTILS::SELECT_FIELD($this, 'related_posts_taxonomy', 'تکسونومی مرتبط', AE_E_FUNCTIONS::getRegisteredTaxonomies(), '', 'related_posts', 'yes');

        AE_E_UTILS::MULTIPLE_SELECT_FIELD($this, 'post_type', 'نوع نوشته', AE_E_FUNCTIONS::getRegisteredPostTypes(), ['post'], 'related_posts', '');

        AE_E_UTILS::MULTIPLE_SELECT_FIELD($this, 'post_status', 'وضعیت نوشته', $POST_STATUS, ['publish']);

        $this->add_control('post__in', [
            'label'       => 'درج پست',
            'description' => 'در صورت درج پست، بقیه تنظیمات نادیده گرفته خواهد شد!',
            'type'        => 'wp_active_we_autocomplete',
            'search'      => 'wp_active_we_get_posts_by_query',
            'render'      => 'wp_active_we_get_posts_title_by_id',
            'post_type'   => AE_E_FUNCTIONS::getRegisteredPostTypes(true),
            'multiple'    => true,
            'label_block' => true,
            'condition'   => [
                'related_posts' => ''
            ]
        ]);

        $this->add_control('post__not_in', [
            'label'       => 'جدا کردن پست',
            'type'        => 'wp_active_we_autocomplete',
            'search'      => 'wp_active_we_get_posts_by_query',
            'render'      => 'wp_active_we_get_posts_title_by_id',
            'post_type'   => AE_E_FUNCTIONS::getRegisteredPostTypes(true),
            'multiple'    => true,
            'label_block' => true,
        ]);

        AE_E_UTILS::SWITCH_FIELD($this, 'exclude_this_post', 'نادیده گرفتن این پست', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'ignore_sticky_posts', 'نادیده گرفتن پست های چسبان', 'yes');
        AE_E_UTILS::NUMBER_FIELD($this, 'posts_per_page', 'تعداد نوشته', -1, 30);
        AE_E_UTILS::NUMBER_FIELD($this, 'offset', 'offset', 0, 100, 1, 0);
        AE_E_UTILS::SWITCH_FIELD($this, 'need_pagination', 'نیاز به صفحه بندی', '');


        $order = [
            'ASC'  => 'صعودی',
            'DESC' => 'نزولی'
        ];
        AE_E_UTILS::SELECT_FIELD($this, 'order', 'ترتیب', $order, 'DESC');

        $order_by = [
            'none'           => 'بدون ترتیب',
            'ID'             => 'ID',
            'title'          => 'عنوان',
            'name'           => 'نامک',
            'date'           => 'تاریخ انتشار',
            'modified'       => 'تاریخ ویرایش',
            'rand'           => 'تصادفی',
            'comment_count'  => 'تعداد کامنت',
            'meta_value'     => 'زمینه دلخواه',
            'meta_value_num' => 'زمینه دلخواه عددی',
        ];
        AE_E_UTILS::SELECT_FIELD($this, 'orderby', 'مرتب سازی', $order_by, 'date');
        $this->add_control('meta_value_key', [
            'label'       => 'کلید زمینه دلخواه',
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'dynamic'     => [
                'active' => true,
            ],
            'condition'   => [
                'orderby' => ['meta_value', 'meta_value_num']
            ]
        ]);
        $this->add_control('meta_value_compare', [
            'label'       => 'نوع عملیات زمینه دلخواه',
            'type'        => Controls_Manager::SELECT,
            'label_block' => false,
            'options'     => $META_COMPARE_OPTIONS,
            'default'     => '=',
            'condition'   => [
                'orderby' => ['meta_value', 'meta_value_num']
            ]
        ]);
        $this->add_control('meta_value_type', [
            'label'       => 'نوع مقایسه',
            'type'        => Controls_Manager::SELECT,
            'label_block' => false,
            'options'     => $META_VALUE_TYPES,
            'default'     => 'CHAR',
            'condition'   => [
                'orderby' => 'meta_value',
            ]
        ]);
        $this->add_control('meta_value_value', [
            'label'       => 'مقدار زمینه دلخواه',
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'dynamic'     => [
                'active' => true,
            ],
            'description' => 'با استفاده از کامای انگلیسی (,) چندین مقدار را از هم جدا کنید.',
            'condition'   => [
                'orderby'          => ['meta_value', 'meta_value_num'],
                'meta_value_type!' => 'DATETIME'
            ]
        ]);
        $this->add_control('meta_value_date', [
            'label'     => 'مقدار زمینه دلخواه',
            'type'      => \Elementor\Controls_Manager::DATE_TIME,
            'condition' => [
                'orderby'         => ['meta_value', 'meta_value_num'],
                'meta_value_type' => 'DATETIME'
            ]
        ]);

        $this->add_control('enable_tax_query', [
            'label'        => 'تکسونومی کوئری',
            'type'         => Controls_Manager::SWITCHER,
            'label_block'  => false,
            'label_on'     => 'بله',
            'label_off'    => 'خیر',
            'return_value' => 'yes',
            'default'      => '',
            'description'  => 'برای دریافت term های مشابه، فیلد را روی "آیدی" تنظیم کنید.',
            'separator'    => 'before',
            'condition'    => [
                'related_posts' => ''
            ]
        ]);
        $tax_query = new \Elementor\Repeater();
        $tax_query->add_control('taxonomy', [
            'label'       => 'تکسونومی',
            'type'        => Controls_Manager::SELECT2,
            'options'     => AE_E_FUNCTIONS::getRegisteredTaxonomies(),
            'label_block' => false,
            'default'     => 'category',
        ]);

        $tax_query->add_control('terms', [
            'label'       => 'دسته ها',
            'type'        => 'wp_active_we_autocomplete',
            'search'      => 'wp_active_we_get_taxonomies_by_query',
            'render'      => 'wp_active_we_get_taxonomies_title_by_id',
            'taxonomy'    => AE_E_FUNCTIONS::getRegisteredTaxonomies(true),
            'multiple'    => true,
            'label_block' => true,
        ]);

        AE_E_UTILS::SELECT_FIELD($tax_query, 'operator', 'نوع عملیات', $TAXONOMY_OPERATORS, 'IN');
        $this->add_control('tax_query', [
            'label'         => 'تکسونومی ها',
            'type'          => \Elementor\Controls_Manager::REPEATER,
            'fields'        => $tax_query->get_controls(),
            'title_field'   => '{{{ taxonomy }}} {{{ operator }}} {{{ terms }}}',
            'prevent_empty' => false,
            'condition'     => [
                'enable_tax_query' => 'yes',
                'related_posts'    => ''
            ]
        ]);
        $this->add_control('tax_relation', [
            'label'       => 'ارتباط بین تکسونومی ها',
            'type'        => Controls_Manager::SELECT2,
            'label_block' => false,
            'options'     => [
                'AND' => 'AND',
                'OR'  => 'OR'
            ],
            'default'     => 'AND',
            'condition'   => [
                'enable_tax_query' => 'yes',
                'related_posts'    => ''
            ]
        ]);


        $meta_query = new \Elementor\Repeater();
        $this->add_control('enable_meta_query', [
            'label'        => 'متا کوئری',
            'type'         => Controls_Manager::SWITCHER,
            'label_block'  => false,
            'label_on'     => 'بله',
            'label_off'    => 'خیر',
            'return_value' => 'yes',
            'default'      => '',
            'separator'    => 'before'
        ]);
        $meta_query->add_control('key', [
            'label'       => 'کلید',
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'dynamic'     => [
                'active' => true,
            ],
        ]);
        $meta_query->add_control('compare', [
            'label'       => 'نوع عملیات',
            'type'        => Controls_Manager::SELECT2,
            'label_block' => false,
            'dynamic'     => [
                'active' => true,
            ],
            'options'     => $META_COMPARE_OPTIONS,
            'default'     => '=',
        ]);
        $meta_query->add_control('value', [
            'label'       => 'مقدار',
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'dynamic'     => [
                'active' => true,
            ],
            'description' => 'وقتی "نوع عملیات" یکی از عملیات های IN / NOT IN / BETWEEN / NOT BETWEEN باشد میتوانید چندین مقدار وارد کنید.'
        ]);
        $this->add_control('meta_query', [
            'label'         => 'متا کوئری ها',
            'type'          => \Elementor\Controls_Manager::REPEATER,
            'fields'        => $meta_query->get_controls(),
            'title_field'   => '{{{ key }}} {{{ compare }}} {{{ value }}}',
            'prevent_empty' => false,
            'condition'     => [
                'enable_meta_query' => 'yes'
            ]
        ]);
        $this->add_control('meta_relation', [
            'label'       => 'ارتباط بین متا کوئری ها',
            'type'        => Controls_Manager::SELECT2,
            'options'     => [
                'AND' => 'AND',
                'OR'  => 'OR'
            ],
            'label_block' => false,
            'separator'   => 'after',
            'default'     => 'AND',
            'condition'   => [
                'enable_meta_query' => 'yes'
            ]
        ]);

        $this->add_control('no_post_found', [
            'label' => 'پیام عدم وجود پست',
            'type'  => Controls_Manager::TEXTAREA,
        ]);

        $this->end_controls_section();
    }

    protected function QueryArgBuilder()
    {
        $settings = $this->get_settings_for_display();
        $args = [];

        $order = $settings['order'] ?: 'DESC';
        $ignore_sticky_posts = (bool)$settings['ignore_sticky_posts'];
        $need_pagination = (bool)$settings['need_pagination'];
        $order_by = $settings['orderby'] ?: 'date';

        if (!empty($settings['post_type'])) {
            $post_type = $settings['post_type'];
            $args['post_type'] = count($post_type) > 1 ? $post_type : $post_type[0];
        }
        if (!empty($settings['post_status'])) {
            $post_status = $settings['post_status'];

            $args['post_status'] = count($post_status) > 1 ? $post_status : $post_status[0];
        }
        if (!empty($settings['post__in'])) {
            if (is_array($settings['post__in'])) {
                $args['post__in'] = $settings['post__in'];
            } elseif (is_string($settings['post__in'])) {
                $args['post__in'] = explode('|', $settings['post__in']);
            }
        }
        if (!empty($settings['post__not_in'])) {
            if (is_array($settings['post__not_in'])) {
                $args['post__not_in'] = $settings['post__not_in'];
            } elseif (is_string($settings['post__not_in'])) {
                $args['post__not_in'] = explode('|', $settings['post__not_in']);
            }
        }
        if (!empty($settings['exclude_this_post'])) {
            $args['post__not_in'][] = get_the_ID();
        }
        $args['posts_per_page'] = $settings['posts_per_page'] ?: 5;
        $args['offset'] = $settings['offset'] ?: 0;

        if ($need_pagination !== false) {
            $args['paged'] = get_query_var('paged') ? get_query_var('paged') : 1;
        } else {
            $args['no_found_rows'] = true;
        }

        $args['order'] = $order;
        $args['ignore_sticky_posts'] = $ignore_sticky_posts;

        $args['orderby'] = $order_by;

        // insert meta value -> orderby
        if ($order_by === 'meta_value' || $order_by === 'meta_value_num') {
            $meta_value_key = $settings['meta_value_key'] ?: '';

            $meta_value_value = $settings['meta_value_value'] ?: '';
            if (!empty($meta_value_value) && strpos($meta_value_value, ',') !== false) {
                $meta_value_value = explode(',', $meta_value_value);
            }

            $meta_value_date = $settings['meta_value_date'] ?: '';
            $meta_value_compare = $settings['meta_value_compare'];
            $meta_value_type = $settings['meta_value_type'] ?: '';

            if (!empty($meta_value_key) || !empty($meta_value_value) || !empty($meta_value_date)) {
                if (!empty($meta_value_key)) {
                    $args['meta_key'] = $meta_value_key;
                }

                if (!empty($meta_value_type)) {
                    $args['meta_type'] = $meta_value_type;
                }

                if (!empty($meta_value_value)) {
                    if ($order_by === 'meta_value') {
                        $args['meta_value'] = $meta_value_value;
                    }
                    if ($order_by === 'meta_value_num') {
                        $args['meta_value_num'] = (int)$meta_value_value;
                    }
                }

                if (!empty($meta_value_date)) {
                    $args['meta_value_date'] = $meta_value_date;
                    $args['orderby'] = 'meta_value';
                }

                // calculate meta_compare
                if (((!empty($meta_value_date) || !empty($meta_value_value)) && !empty($meta_value_key)) && !empty($meta_value_compare)) {
                    $args['meta_compare'] = $meta_value_compare;
                }

            }
        }


        // insert taxonomy query
        $related_posts = $settings['related_posts'];

        if (empty($related_posts)) {
            $enable_tax_query = $settings['enable_tax_query'];
            $tax_query = $settings['tax_query'];
            if (!empty($enable_tax_query) && !empty($tax_query)) {
                $tax_query_pack = [];

                if (count($tax_query) > 1) {
                    $tax_query_pack['relation'] = $settings['tax_relation'] ?: 'AND';
                }

                foreach ($tax_query as $item) {
                    if (!empty($item['terms'])) {
                        $pack['taxonomy'] = $item['taxonomy'];
                        $pack['field'] = 'term_id';
                        $pack['terms'] = is_array($item['terms']) ? $item['terms'] : array_map('trim', explode(',', $item['terms']));

                        if ($item['operator'] !== 'IN') {
                            $pack['operator'] = $item['operator'];
                        }
                        $tax_query_pack[] = $pack;
                    }
                }

                $args['tax_query'] = $tax_query_pack;
            }
        } else {
            $related_posts_taxonomy = $settings['related_posts_taxonomy'];
            if (!empty($related_posts_taxonomy)) {
                $terms = AE_E_FUNCTIONS::extractPostTerms(get_the_ID(), $related_posts_taxonomy);

                $args['tax_query'] = [
                    [
                        'taxonomy' => $related_posts_taxonomy,
                        'field'    => 'term_id',
                        'terms'    => $terms,
                    ]
                ];
            }
        }

        // if tax query wasn't used
        if (empty($enable_tax_query)) {
            $args['update_post_term_cache'] = false;
        }


        // insert meta query
        $enable_meta_query = $settings['enable_meta_query'];
        $meta_query = $settings['meta_query'];
        if (!empty($enable_meta_query) && !empty($meta_query)) {
            $meta_query_pack = [];

            if (count($meta_query) > 1) {
                $meta_query_pack['relation'] = $settings['meta_relation'] ?: 'AND';
            }

            foreach ($meta_query as $item) {
                $pack = [];

                if (!empty($item['key'])) {
                    $pack['key'] = $item['key'];
                }

                if (!empty($item['value'])) {
                    if (strpos($item['value'], ',') !== false) {
                        $pack['value'] = explode(',', $item['value']);
                    } else {
                        $pack['value'] = $item['value'];
                    }
                }

                if (!empty($item['compare']) && $item['compare'] !== '=' && !empty($item['key'])) {
                    $pack['compare'] = $item['compare'];
                }

                if (!empty($pack)) {
                    $meta_query_pack[] = $pack;
                }
            }

            $args['meta_query'] = $meta_query_pack;

        }


        // if meta_query not used
        if (empty($enable_meta_query) && $order_by !== 'meta_value' && $order_by !== 'meta_value_num') {
            $args['update_post_meta_cache'] = false;
        }

        if (!empty($settings['no_post_found'])) {
            $args['no_post_found'] = esc_html($settings['no_post_found']);
        }

        return $args;

    }


    protected function QueryNotHavePostsStyle()
    {
        AE_E_UTILS::SECTION_START($this, 'no-post-style', 'پستی نیست', 'style');
        AE_E_UTILS::TextUtils($this, 'no-post', 'p.no-post-found');
        AE_E_UTILS::TEXT_ALIGNMENT($this, 'no-post-alignment', 'p.no-post-found');
        AE_E_UTILS::SECTION_END($this);
    }

    protected function QueryNotHavePostsMessage()
    {
        echo '<p class="no-post-found">';
        echo !empty($settings['no_post_found']) ? $settings['no_post_found'] : __('No article found!', 'wp-active-widgets-elementor');
        echo '</p>';
    }

}
