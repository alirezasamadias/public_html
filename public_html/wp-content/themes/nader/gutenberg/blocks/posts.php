<?php
defined('ABSPATH') || die();

$post_type      = get_field('nader-block-posts-post-type');
$query_type     = get_field('nader-block-posts-query-type');
$posts_per_page = get_field('nader-block-posts-posts-per-page');

$qa = [
    'post_type'           => $post_type,
    'posts_per_page'      => $posts_per_page,
    'post__not_in'        => [get_the_ID()],
    'post_status'         => 'publish',
    'no_found_rows'       => 1,
    'ignore_sticky_posts' => 1,
    'order'               => 'DESC',
];

if ($query_type === 'random') {
    $qa['orderby'] = 'rand';
} elseif ($query_type === 'related') {

    $singular_post_type = get_post_type();
    if ($singular_post_type === 'post') {
        $qa['category__in'] = wp_get_post_categories(get_the_ID());
    } elseif ($singular_post_type === 'project') {

        $terms = wp_get_post_terms(get_the_ID(), 'project_cat');

        if (empty($terms)) {
            return;
        }

        // extract terms id
        $terms = array_map(function ($x) {
            return $x->term_id;
        }, $terms);

        $qa['tax_query'] = [
            [
                'taxonomy' => 'project_cat',
                'field'    => 'term_id',
                'terms'    => $terms
            ]
        ];
    }
}

$posts_query = new WP_Query($qa);

if (!$posts_query->have_posts()) {
    return;
}

$title  = get_field('nader-block-posts-title');
$icon   = get_field('nader-block-posts-icon');
$header = [
    'icon'  => $icon,
    'title' => $title
];
get_template_part('parts/sidebar/sidebar-item', 'header', $header);


$view = get_field('nader-block-posts-view');
$date = get_field('nader-block-posts-date');

$args = [
    'view' => $view,
    'date' => $date
];

?>

<ul class="si-posts">
    <?php
    while ($posts_query->have_posts()) {
        $posts_query->the_post();
        get_template_part('parts/loop/card', 'sidebar-simple', $args);
    }
    wp_reset_postdata();
    ?>
</ul>
