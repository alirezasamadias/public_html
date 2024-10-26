<?php
defined('ABSPATH') || die();

$title = get_field('nader-block-category-title');
$icon = get_field('nader-block-category-icon');
$taxonomy = get_field('nader-block-category-taxonomy');
$show_number = get_field('nader-block-category-show-number');


$cat_header = [
    'icon'  => $icon,
    'title' => $title
];

get_template_part('parts/sidebar/sidebar-item', 'header', $cat_header);

$args = [
    'taxonomy'   => $taxonomy,
    'hide_empty' => (bool)!get_field('nader-block-category-show-empty-terms'),
];
$terms = get_terms($args);
?>

<ul class="si-category">
    <?php foreach ($terms as $term) { ?>
        <li>
            <a href="<?php echo get_category_link($term->term_id); ?>" title="<?php echo $term->name; ?>">
                <?php
                echo $term->name;
                if ($show_number) {
                    echo '<span class="number">(' . $term->count . ')</span>';
                }
                ?>
            </a>
        </li>
    <?php } ?>
</ul>
