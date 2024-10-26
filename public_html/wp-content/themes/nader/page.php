<?php
defined('ABSPATH') || die();
get_header();
the_post();

$sec_class = 'col-xl-8 col-lg-8';
$has_sidebar  = true;
if (ACF_ENABLED) {
    $has_sidebar = get_field('sidebar-page', 'options');
}
if (!$has_sidebar) {
    $sec_class = 'col-xl-12';
}

?>
    <div class="main container my-5">
        <div class="row justify-content-center mx-0">

            <div class="single-content-section <?php echo $sec_class;?>">

                <?php NaderUtils::breadcrumb(); ?>

                <div class="sc-inner post-content p-4">
                    <?php get_template_part('parts/single/page', 'title'); ?>
                    <?php if (has_post_thumbnail()) { ?>
                        <div class="page-thumbnail mb-4"><?php the_post_thumbnail(); ?></div>
                    <?php } ?>
                    <?php the_content(); ?>
                </div>

                <?php if (comments_open()) { ?>
                    <div class="sc-inner post-comments mt-4 p-4">
                        <?php comments_template(); ?>
                    </div>
                <?php } ?>
            </div>

            <?php
            if ($has_sidebar) {
                get_sidebar('page');
            }
            ?>
        </div>
    </div>
<?php

get_footer();

