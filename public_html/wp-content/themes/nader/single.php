<?php
defined('ABSPATH') || die();
get_header();
the_post();

$has_sidebar = true;
if (ACF_ENABLED) {
    $has_sidebar = get_field('sidebar-posts', 'options');
}

?>
<div class="main container">
    <div class="row justify-content-center mx-0">
        <?php
        get_template_part('parts/single/banner');
        NaderUtils::breadcrumb();
        get_template_part('parts/single/content');

        if ($has_sidebar) {
            get_sidebar();
        }
        ?>
    </div>
</div>
<?php

get_footer();
