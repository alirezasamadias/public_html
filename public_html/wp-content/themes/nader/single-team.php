<?php
defined('ABSPATH') || die();
get_header();
the_post();

$has_sidebar  = true;
if (ACF_ENABLED) {
    $has_sidebar = get_field('sidebar-team', 'options');
}

?>
    <div class="main container">
        <div class="row justify-content-center mx-0">
            <?php
            get_template_part('parts/team/banner');
            NaderUtils::breadcrumb();
            get_template_part('parts/team/content');

            if ($has_sidebar) {
                get_sidebar('team');
            }
            ?>
        </div>
    </div>
<?php

get_footer();

