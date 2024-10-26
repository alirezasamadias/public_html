<?php
defined('ABSPATH') || die();
?>
<header class="site-header navbar-collapse-toggle" id="navbar">
    <?php
    get_template_part( 'parts/header/brand' );
    get_template_part( 'parts/header/menu' );
    get_template_part( 'parts/header/contact', 'btn' );
    ?>
</header>
<?php
get_template_part( 'parts/header/menu', 'mobile' );
