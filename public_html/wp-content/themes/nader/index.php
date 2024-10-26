<?php
defined('ABSPATH') || die();

get_header();

$sec_class = 'col-xl-8 col-lg-8';
$has_sidebar = true;
$archive_bg = NADER_IMG_DIR . 'archive-banner-bg-min.jpg';
if (ACF_ENABLED) {
    $has_sidebar = get_field('sidebar-archive', 'options');
    $archive_bg_temp = get_field('archive-header-bg', 'options');
    if (!empty($archive_bg_temp)) {
        $archive_bg = $archive_bg_temp;
    }
    $archive_bg = apply_filters('nader/archive/header/bg', $archive_bg);
}
if (!$has_sidebar) {
    $sec_class = 'col-xl-12';
}

?>
    <div class="main container my-5">
        <div class="row justify-content-center mx-0">

            <div class="archive-content-section <?php echo $sec_class; ?>">

                <div class="archive-banner col-xl-12 mb-3 px-4 py-5"
                     style="background-image: url('<?php echo esc_url($archive_bg); ?>');">
                    <h1 class="text-center">
                        <?php
                        if (is_archive()) {
                            echo get_the_archive_title();
                        } elseif (is_search()) {
                            echo sprintf(__('Search results for: %s', 'nader'), get_search_query());
                        } else {
                            the_title();
                        }
                        ?>
                    </h1>
                </div>
                <!--/.archive-banner-->

                <?php
                NaderUtils::breadcrumb();

                if (have_posts()) {
                    echo '<div class="archive-loop">';
                    while (have_posts()) {
                        the_post();
                        if (is_post_type_archive('team')) {
                            get_template_part('parts/loop/card', 'team');
                        } else {
                            get_template_part('parts/loop/card', 'simple');
                        }
                    }
                    echo '</div>';

                    $pn_args = ['echo' => false];
                    if (function_exists('ae_pagination') && !empty(ae_pagination($pn_args))) {
                        ae_pagination();
                    }

                } else {
                    get_template_part('parts/loop/no-post');
                }

                ?>

            </div>

            <?php
            if ($has_sidebar) {
                get_sidebar();
            }
            ?>
        </div>
    </div>
<?php
get_footer();
