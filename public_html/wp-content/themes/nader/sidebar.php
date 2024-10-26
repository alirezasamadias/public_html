<?php
defined('ABSPATH') || die();

?>
<div class="single-sidebar-section col-xl-4 col-lg-4">
    <?php
    if (is_archive() || is_search()) {
        if (is_active_sidebar('archive_sidebar')) {
            echo '<div class="sidebar-item p-4 mb-4">';
            dynamic_sidebar('archive_sidebar');
            echo '</div>';
        }
    } else {
        if (is_active_sidebar('default_sidebar')) {
            echo '<div class="sidebar-item p-4 mb-4">';
            dynamic_sidebar('default_sidebar');
            echo '</div>';
        }
    }
    ?>
</div>
