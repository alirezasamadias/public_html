<?php
defined('ABSPATH') || die();
/**
 * New breadcrumb
 * It's used for blog, page exc...
 * for woocommerce pages -> using woocommerce_breadcrumb() and checkout-breadcrumb.php
 */
$container[] = [
    'link' => home_url(),
    'title' => __('Home', 'nader'),
];

if (is_singular()) {
    if (is_singular('post')) {
        if (ACF_ENABLED) {
            $blog_page = get_field('nader-single', 'options');
            if (!empty($blog_page['blog-page'])) {
                $container[] = [
                    'link' => get_the_permalink($blog_page['blog-page']),
                    'title' => __('Blog', 'nader')
                ];
            }
        }

        $cat = RealPressHelper::getPostFirstCategory();
        if (!empty($cat)) {
            $container[] = [
                'link' => get_category_link($cat->term_id),
                'title' => $cat->name
            ];
        }
        $container[] = [
            'link' => '',
            'title' => get_the_title()
        ];


        // if it is a page
    } elseif (is_singular('project')) {
        if (ACF_ENABLED) {
            $project_page = get_field('nader-single-project', 'options');
            if (!empty($project_page['project-page'])) {
                $post_type = get_post_type_object('project');
                $container[] = [
                    'link' => get_the_permalink($project_page['project-page']),
                    'title' => $post_type->labels->singular_name
                ];
            }
        }

        $cat = RealPressHelper::getPostFirstCategory();
        if (!empty($cat)) {
            $container[] = [
                'link' => get_category_link($cat->term_id),
                'title' => $cat->name
            ];
        }
        $container[] = [
            'link' => '',
            'title' => get_the_title()
        ];

    } // if it is a project
    elseif (is_singular('team')) {
        $post_type = get_post_type_object('team');
        $container[] = [
            'link' => get_post_type_archive_link('team'),
            'title' => __('Team', 'nader')
        ];
        $container[] = [
            'link' => '',
            'title' => get_the_title()
        ];

    } // if it is a project
    elseif (is_singular('product')) {

        $container[] = [
            'link' => get_permalink(wc_get_page_id('shop')),
            'title' => __('Shop', 'nader')
        ];

        $cat = RealPressHelper::getPostFirstCategory();
        if (!empty($cat)) {
            $container[] = [
                'link' => get_category_link($cat->term_id),
                'title' => $cat->name
            ];
        }
        $container[] = [
            'link' => '',
            'title' => get_the_title()
        ];

    } // if it is a page
    elseif (is_singular('page')) {

        $pageObj = get_post();

        if ($pageObj->post_parent == 0) {
            $container[] = [
                'link' => '',
                'title' => get_the_title()
            ];
        } else {

            $pageParentID = $pageObj->post_parent;
            $page_container = [];

            while ($pageParentID) {
                $pageObj = get_post($pageParentID);
                $page_container[] = [
                    'link' => $pageObj->guid,
                    'title' => $pageObj->post_title,
                ];
                $pageParentID = $pageObj->post_parent;
            }

            $page_container = array_reverse($page_container);

            $page_container[] = [
                'link' => '',
                'title' => get_the_title(),
            ];

            $container = array_merge($container, $page_container);
        }

    } else {
        $container[] = [
            'link' => '',
            'title' => get_the_title()
        ];
    }
} elseif (is_category()) {
    global $wp_query;
    $catObj = $wp_query->get_queried_object();
    $catID = $catObj->cat_ID;
    if (!$catObj->category_parent) {
        $container[] = [
            'link' => '',
            'title' => __('Category: ', 'nader') . $catObj->name,
        ];
    } else {
        $catParentID = $catObj->category_parent;

        $cat_container = [];

        while ($catParentID) {
            $catObj = get_category($catParentID);

            $cat_container[] = [
                'link' => get_category_link($catObj),
                'title' => $catObj->name,
            ];

            $catParentID = $catObj->category_parent;
        }

        $cat_container = array_reverse($cat_container);

        $cat_container[] = [
            'link' => '',
            'title' => get_category($catID)->name,
        ];

        $container = array_merge($container, $cat_container);
    }
} elseif (is_tag()) {
    global $wp_query;
    $container[] = [
        'link' => '',
        'title' => __('Tag: ', 'nader') . single_tag_title('', false),
    ];
} elseif (is_archive()) {
    $queried_object = get_queried_object();
    $title = null;
    $prefix = null;

    if ($queried_object) {

        if (is_post_type_archive()) {
            $container[] = [
                'link' => '',
                'title' => $queried_object->label,
            ];
        }

        if (is_tax()) {
            $tax = get_taxonomy($queried_object->taxonomy);
            $title = single_term_title('', false);
            $prefix = $tax->labels->singular_name;
            $container[] = [
                'link' => '',
                'title' => $prefix . ': ' . $title,
            ];
        }
    }

} elseif (is_search()) {
    $container[] = [
        'link' => '',
        'title' => __('Search for: ', 'nader') . get_search_query()
    ];
} elseif (is_day() || is_month() || is_year()) {

    $container[] = [
        'link' => get_year_link(get_the_time('Y')),
        'title' => get_the_time('Y')
    ];

    if (is_month() || is_day()) {
        $container[] = [
            'link' => get_month_link(get_the_time('Y'), get_the_time('m')),
            'title' => get_the_time('M')
        ];

        if (is_day()) {
            $container[] = [
                'link' => get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')),
                'title' => get_the_time('d')
            ];
        }
    }
}
if ($pageNumber = get_query_var('paged')) {
    $container[] = [
        'link' => '',
        'title' => __('Page: ', 'nader') . $pageNumber,
    ];
}

foreach ($container as $key => $item) {
    if ($key !== array_key_last($container)) {
        if (!empty($item['link'])) {
            echo '<a href="' . $item["link"] . '" title="' . esc_html($item['title']) . '">' . esc_html($item['title']) . '</a>';
        } else {
            echo '<span>' . esc_html($item['title']) . '</span>';
        }
        echo '<span class="delimiter">/</span>';
    } else {
        echo $item['title'];
    }
}
