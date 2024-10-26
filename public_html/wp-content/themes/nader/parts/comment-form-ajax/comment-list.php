<?php
defined('ABSPATH') || exit;

wp_list_comments([
    'callback' => 'naderCommentsListCallback',
    'type'     => 'comment',
]);