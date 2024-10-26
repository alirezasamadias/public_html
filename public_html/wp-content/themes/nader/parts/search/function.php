<?php
defined('ABSPATH') || die();

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('nader-search', get_stylesheet_directory_uri() . '/parts/search/search.min.css');
    wp_enqueue_script('nader-search', get_stylesheet_directory_uri() . '/parts/search/search.js', ['jquery'], 1, true);
    wp_localize_script('nader-search', 'NADER_SEARCH_AJAX', [
        'admin_ajax_url' => admin_url('admin-ajax.php'),
        'security_nonce' => wp_create_nonce('ajax_security_nonce'),
    ]);
});

add_action('wp_ajax_nader_search_ajax', 'nader_search_ajax');
add_action('wp_ajax_nopriv_nader_search_ajax', 'nader_search_ajax');

function nader_search_ajax()
{
    check_ajax_referer('ajax_security_nonce', 'nonce');

    if (strlen($_POST['s']) > 50) {
        wp_send_json_error(['status' => 'error']);
        die();
    }

    $post_type = $_POST['post_type'];
    if (!in_array($_POST['post_type'], ['all', 'post', 'product', 'team', 'project'])) {
        wp_send_json_error(['status' => 'error']);
        die();
    }

    $search_query_post = null;

    $data = '<ul class="d-grid gap-2">';

    $search_args = [
        's'              => trim($_POST['s']),
        'posts_per_page' => 12,
        'post_type'      => 'post'
    ];

    $i = 0;

    if (in_array($post_type, ['post', 'project', 'team'])) {
        $search_args['post_type'] = $post_type;

        $search_query_post = new WP_Query($search_args);
        if ($search_query_post->have_posts()) {
            $i = 0;
            while ($search_query_post->have_posts()) {
                $search_query_post->the_post();
                if ($i == 7) {
                    break;
                }

                $title = get_the_title();
                $link = get_the_permalink();

                $data .= '<li class="post"><a href="' . esc_url($link) . '" title="' . esc_html($title) . '" class="d-flex align-items-center gap-2">';
                $data .= get_the_post_thumbnail(get_the_ID(), 'thumbnail');
                $data .= '<div class="details"><h3 class="title">' . esc_html($title) . '</h3>';
                $data .= '<span class="date mt-1">' . __('Date', 'nader') . ': ' . get_the_date('Y/M/d') . '</span>';
                if (RealPressHelper::isActiveViews()) {
                    $data .= '<span class="view mt-1">' . __('View', 'nader') . ': ' . RealPressHelper::getPostViews() . '</span>';
                }
                $data .= '</div></a></li>';
                $i++;
            }
        }
    }

    if ($post_type === 'product') {
        $search_args['post_type'] = 'product';
        $search_query_post = new WP_Query($search_args);
        if ($search_query_post->have_posts()) {
            $i = 0;
            while ($search_query_post->have_posts()) {
                $search_query_post->the_post();
                if ($i == 7) {
                    break;
                }

                $title = get_the_title();
                $link = get_the_permalink();

                $product = wc_get_product();

                $data .= '<li class="product"><a href="' . esc_url($link) . '" title="' . esc_html($title) . '" class="d-flex align-items-center gap-2">';
                $data .= woocommerce_get_product_thumbnail();
                $data .= '<div class="details"><h3 class="title">' . esc_html($title) . '</h3>';
                if ($product->get_price() !== '' && $product->get_price() > 0) {
                    $data .= '<span class="price">' . $product->get_price_html() . '</span>';
                }
                $data .= '</div></a></li>';
                $i++;
            }
        }
    }

    if ($post_type === 'all') {
        $search_args['post_type'] = ['post', 'project', 'team'];

        if (function_exists('WC')) {
            $search_args['post_type'][] = 'product';
        }

        $search_query_post = new WP_Query($search_args);
        if ($search_query_post->have_posts()) {
            $i = 0;
            while ($search_query_post->have_posts()) {
                $search_query_post->the_post();
                if ($i == 10) {
                    break;
                }

                $title = get_the_title();
                $link = get_the_permalink();

                if ($post_type !== 'product') {
                    $data .= '<li class="post"><a href="' . esc_url($link) . '" title="' . esc_html($title) . '" class="d-flex align-items-center gap-2">';
                    $data .= get_the_post_thumbnail(get_the_ID(), 'thumbnail');
                    $data .= '<div class="details"><h3 class="title">' . esc_html($title) . '</h3>';
                    $data .= '<span class="date mt-1">' . __('Date', 'nader') . ': ' . get_the_date('Y/M/d') . '</span>';
                    if (RealPressHelper::isActiveViews()) {
                        $data .= '<span class="view mt-1">' . __('View', 'nader') . ': ' . RealPressHelper::getPostViews() . '</span>';
                    }
                } else {
                    $product = wc_get_product();

                    $data .= '<li class="product"><a href="' . esc_url($link) . '" title="' . esc_html($title) . '" class="d-flex align-items-center gap-2">';
                    $data .= woocommerce_get_product_thumbnail();
                    $data .= '<div class="details"><h3 class="title">' . esc_html($title) . '</h3>';
                    $data .= '<span class="price">' . $product->get_price_html() . '</span>';
                }
                $data .= '</div></a></li>';

                $i++;
            }
        }
    }

    $data .= '</ul>';

    if ($search_query_post->post_count > $i) {
        $result_link = '<a href="' . get_site_url() . '/?s=' . $_POST['s'] . '&post_type=' . $post_type . '">' . __('All results', 'nader') . '</a>';
        $data .= '<p class="all-results d-flex align-items-center justify-content-center mt-2 mb-0">' . $result_link . '</p>';
    }

    if (!$search_query_post->have_posts()) {
        $data = '<p class="mb-0 text-center">' . __('Unfortunately, there is no post!', 'nader') . '</p>';
    }

    echo $data;

    die();
}

function nader_modify_search_query($query)
{
    if (!is_admin() && $query->is_main_query() && is_search()) {
        // Not a query for an admin page.
        // It's the main query for a front end page of your site.
        $post_type = $_GET['post_type'];
        if ($post_type !== 'all') {
            $query->set('post_type', $post_type);
        } else {
            $post_types = ['post', 'project', 'team'];
            if (function_exists('WC')) {
                $post_types[] = 'product';
            }
            $query->set('post_type', $post_types);
        }
    }
}

add_action('pre_get_posts', 'nader_modify_search_query');
