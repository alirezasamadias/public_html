<?php
defined('ABSPATH') || exit;

$main_color = get_field('site-color', 'options');
$archive_header_color = get_field('archive-header-text-color', 'options');
$header_color = get_field('header-color-bg', 'options');
$footer_color = get_field('footer-color', 'options');
$mobile_header_color = get_field('mobile-header-color', 'options');
$mobile_menu_color = get_field('mobile-menu-color', 'options');
$desktop_menu_color = get_field('desktop-menu-color', 'options');
if (empty($main_color)) {
    return;
}

?>
    <style>
        :root {
            --nader-color-main: <?php echo esc_html($main_color); ?>
        }

        <?php if (!empty($footer_color['bg'])) { ?>
        .site-footer {
            background: <?php echo esc_html($footer_color['bg']); ?>;
        }

        <?php }

        if (!empty($footer_color['text-color'])) { ?>
        .site-footer p {
            color: <?php echo esc_html($footer_color['text-color']); ?>;
        }

        <?php }

        if (!empty($mobile_menu_color['bg'])) { ?>
        .mobile-menu {
            background: <?php echo esc_html($mobile_menu_color['bg']); ?>;
        }

        <?php }

        if (!empty($mobile_menu_color['text-color'])) { ?>
        .mobile-menu .menu-header h3,
        .mobile-menu .menu-header p {
            color: <?php echo esc_html($mobile_menu_color['text-color']); ?>;
        }

        <?php }

        if (!empty($mobile_menu_color['link-color'])) { ?>
        .mobile-menu .menu li a {
            color: <?php echo esc_html($mobile_menu_color['link-color']); ?>;
            border-bottom-color: <?php echo esc_html($mobile_menu_color['link-bg']); ?>;
        }

        .mobile-menu .menu li svg {
            fill: <?php echo esc_html($mobile_menu_color['link-color']); ?>;
        }

        <?php }

        if (!empty($mobile_menu_color['link-bg'])) { ?>
        .mobile-menu .menu li.active a,
        .mobile-menu .menu li:hover a {
            background: <?php echo esc_html($mobile_menu_color['link-bg']); ?>;
        }

        <?php }

        if (!empty($mobile_menu_color['logo-bg'])) { ?>
        .mobile-menu .menu-header .hero-img {
            background: <?php echo esc_html($mobile_menu_color['logo-bg']); ?>;
        }

        <?php }

        if (!empty($mobile_menu_color['menu-closer-color'])) { ?>
        .mobile-menu .menu-header .close-menu::before,
        .mobile-menu .menu-header .close-menu::after {
            background-color: <?php echo esc_html($mobile_menu_color['menu-closer-color']); ?>;
        }

        <?php }


        /**
        * Mobile header
        */
        if (!empty($mobile_header_color['bg'])) {
            echo '.mob-header{background:'.$mobile_header_color['bg'].'}';
        }
        if (!empty($mobile_header_color['logo-bg'])) {
            echo '.mob-header .nav-brand a{background:'.$mobile_header_color['logo-bg'].'}';
        }
        if (!empty($mobile_header_color['opener-icon'])) {
            echo '.mob-header .toggler-menu span{background:'.$mobile_header_color['opener-icon'].'}';
        }


        /**
        * Desktop menu
         */
        if (!empty($desktop_menu_color['bg'])) { ?>
        .site-header {
            background: <?php echo $desktop_menu_color['bg']; ?>;
        }

        <?php }
        if (!empty($desktop_menu_color['link-normal-color'])) { ?>
        .site-header .menu ul li a {
            color: <?php echo $desktop_menu_color['link-normal-color']; ?>;
        }

        <?php }
        if (!empty($desktop_menu_color['link-hover-color'])) { ?>

        .site-header .menu ul li a:hover,
        .site-header .menu ul li a.active {
            color: <?php echo $desktop_menu_color['link-hover-color']; ?>;
        }

        <?php }
        if (!empty($desktop_menu_color['link-hover-bg'])) { ?>
        .site-header .menu ul li a:hover,
        .site-header .menu ul li a.active {
            background: <?php echo $desktop_menu_color['link-hover-bg']; ?>;
        }

        <?php } ?>
        <?php if (!empty($archive_header_color)) { ?>
        .archive-banner h1 {
            color: <?php echo $archive_header_color;?>
        }

        <?php }

         if (!empty($desktop_menu_color['logo-bg'])) {
             echo '.site-header .nav-brand{background-color:'.$desktop_menu_color['logo-bg'].'}';
         }
         if (!empty($desktop_menu_color['contact-bg'])) {
             echo '.site-header .contact-btn:'.$desktop_menu_color['contact-bg'].'}';
         }

         ?>
    </style>
<?php