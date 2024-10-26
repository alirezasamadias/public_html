<?php
defined('ABSPATH') || die();


add_action('acf/init', 'nader_register_gutenberg_blocks');
function nader_register_gutenberg_blocks()
{
    if (function_exists('acf_register_block_type')) {

        acf_register_block_type(array(
            'name'            => 'nader-separator',
            'title'           => 'نادر: جداکننده سایدبار',
            'render_template' => get_template_directory() . '/gutenberg/blocks/separator.php',
            'category'        => 'nader',
            'icon'            => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 21v-4H7v4H5v-5a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v5h-2zM7 3v4h10V3h2v5a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V3h2zM2 9l4 3-4 3V9zm20 0v6l-4-3 4-3z"/></svg>',
            'keywords'        => array('separator'),
        ));

        acf_register_block_type(array(
            'name'            => 'nader-heading',
            'title'           => 'نادر: عنوان سایدبار',
            'render_template' => get_template_directory() . '/gutenberg/blocks/heading.php',
            'category'        => 'nader',
            'icon'            => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 11V4h2v17h-2v-8H7v8H5V4h2v7z"/></svg>',
            'keywords'        => array('title'),
        ));

        acf_register_block_type(array(
            'name'            => 'nader-category',
            'title'           => 'نادر: دسته بندی',
            'description'     => 'دسته بندی های مختلف را در سایدبار نمایش دهید',
            'render_template' => get_template_directory() . '/gutenberg/blocks/category.php',
            'category'        => 'nader',
            'icon'            => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M8 4h13v2H8V4zm-5-.5h3v3H3v-3zm0 7h3v3H3v-3zm0 7h3v3H3v-3zM8 11h13v2H8v-2zm0 7h13v2H8v-2z"/></svg>',
            'keywords'        => array('category', 'taxonomy', 'terms'),
            'enqueue_style' =>  NADER_BLOCKS_ASSETS_DIR . 'category.css'
        ));

        acf_register_block_type(array(
            'name'            => 'nader-posts',
            'title'           => 'نادر: پست',
            'description'     => 'نمایش انواع پست ها در سایدبار',
            'render_template' => get_template_directory() . '/gutenberg/blocks/posts.php',
            'category'        => 'nader',
            'icon'            => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M11 4h10v2H11V4zm0 4h6v2h-6V8zm0 6h10v2H11v-2zm0 4h6v2h-6v-2zM3 4h6v6H3V4zm2 2v2h2V6H5zm-2 8h6v6H3v-6zm2 2v2h2v-2H5z"/></svg>',
            'keywords'        => array('posts', 'projects'),
            'enqueue_style' =>  NADER_BLOCKS_ASSETS_DIR . 'posts.css'
        ));

        acf_register_block_type(array(
            'name'            => 'nader-share',
            'title'           => 'نادر: انتشار در شبکه های اجتماعی',
            'render_template' => get_template_directory() . '/gutenberg/blocks/share.php',
            'category'        => 'nader',
            'icon'            => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M13.12 17.023l-4.199-2.29a4 4 0 1 1 0-5.465l4.2-2.29a4 4 0 1 1 .959 1.755l-4.2 2.29a4.008 4.008 0 0 1 0 1.954l4.199 2.29a4 4 0 1 1-.959 1.755zM6 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm11-6a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm0 12a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>',
            'keywords'        => array('share'),
        ));

    }
}

if (function_exists('acf_add_local_field_group')) {
    require_once 'settings/category.php';
    require_once 'settings/posts.php';
    require_once 'settings/heading.php';
}
