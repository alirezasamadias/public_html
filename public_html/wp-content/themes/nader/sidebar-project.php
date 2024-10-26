<?php
defined('ABSPATH') || die();

?>
<div class="single-sidebar-section col-xl-4 col-lg-4">
    <?php
    if (is_active_sidebar('project_sidebar')) {
        echo '<div class="sidebar-item p-4 mb-4">';
        dynamic_sidebar('project_sidebar');
        echo '</div>';
    }
    ?>
</div>
