<?php
defined('ABSPATH') || die();
get_header();
the_post();

$has_sidebar = true;
if (ACF_ENABLED) {
    $has_sidebar = get_field('sidebar-projects', 'options');
}

?>
    <div class="main container">
        <div class="row justify-content-center mx-0">
            <?php
            get_template_part('parts/project/banner');
            NaderUtils::breadcrumb();
            get_template_part('parts/project/content');
            if ($has_sidebar) {
                get_sidebar('project');
            }
            ?>
        </div>
    </div>
<?php

get_footer();

