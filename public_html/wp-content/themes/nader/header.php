<?php defined('ABSPATH') || die(); ?>
    <!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <!-- Meta Information -->
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="<?php bloginfo('author'); ?>"/>
        <link rel="pingback" href="<?php echo esc_url(get_bloginfo('pingback_url')); ?>">
        <?php wp_head(); ?>
    </head>
<body <?php body_class('header-1'); ?>>

<?php

/**
 * Hook: wp_body_open
 *
 * @hooked NaderUtils::loader - 10
 */
wp_body_open();

get_template_part('parts/header/header');
