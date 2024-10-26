<?php
defined('ABSPATH') || die();

$header = [
    'icon'  => get_field('nader-block-heading-icon'),
    'title' => get_field('nader-block-heading-title'),
];
get_template_part('parts/sidebar/sidebar-item', 'header', $header);
