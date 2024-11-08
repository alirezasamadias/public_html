<?php
defined('ABSPATH') || die();

acf_add_local_field_group(array(
    'key'                   => 'group_63ee82cfd32e6',
    'title'                 => 'تنظیمات بلوک پست ها',
    'fields'                => array(
        array(
            'key'               => 'field_63ee84dbc6572',
            'label'             => 'عنوان',
            'name'              => 'nader-block-posts-title',
            'type'              => 'text',
            'required'          => 0,
            'conditional_logic' => 0,
        ),
        array(
            'key'               => 'field_63ef1e5a3d3fb',
            'label'             => 'آیکون',
            'name'              => 'nader-block-posts-icon',
            'type'              => 'textarea',
            'required'          => 0,
            'conditional_logic' => 0,
            'rows'              => 4,
        ),
        array(
            'key'               => 'field_63ee8a603a9e0',
            'label'             => 'حالت کوئری',
            'name'              => 'nader-block-posts-query-type',
            'type'              => 'radio',
            'required'          => 0,
            'conditional_logic' => 0,
            'choices'           => array(
                'new'     => 'جدید',
                'random'  => 'تصادفی',
                'related' => 'مرتبط',
            ),
            'default_value'     => 'new',
            'return_format'     => 'value',
            'allow_null'        => 0,
            'other_choice'      => 0,
            'layout'            => 'vertical',
            'save_other_choice' => 0,
        ),
        array(
            'key'               => 'field_63ee82d0b76cc',
            'label'             => 'نوع پست',
            'name'              => 'nader-block-posts-post-type',
            'type'              => 'radio',
            'required'          => 0,
            'conditional_logic' => 0,
            'choices'           => array(
                'post'    => 'پست',
                'project' => 'پروژه',
            ),
            'default_value'     => 'post',
            'return_format'     => 'value',
            'allow_null'        => 0,
            'other_choice'      => 0,
            'layout'            => 'vertical',
            'save_other_choice' => 0,
        ),
        array(
            'key'               => 'field_63ee8342b76cd',
            'label'             => 'تعداد پست',
            'name'              => 'nader-block-posts-posts-per-page',
            'type'              => 'number',
            'required'          => 0,
            'conditional_logic' => 0,
            'default_value'     => 5,
        ),
        array(
            'key'               => 'field_63ee83cdb76ce',
            'label'             => 'نمایش تاریخ',
            'name'              => 'nader-block-posts-date',
            'type'              => 'true_false',
            'required'          => 0,
            'conditional_logic' => 0,
            'default_value'     => 1,
            'ui'                => 1,
        ),
        array(
            'key'               => 'field_63ee83f1b76cf',
            'label'             => 'نمایش بازدید',
            'name'              => 'nader-block-posts-view',
            'type'              => 'true_false',
            'required'          => 0,
            'conditional_logic' => 0,
            'default_value'     => 0,
            'ui'                => 1,
        ),
    ),
    'location'              => array(
        array(
            array(
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'acf/nader-posts',
            ),
        ),
    ),
    'menu_order'            => 0,
    'position'              => 'normal',
    'style'                 => 'default',
    'label_placement'       => 'top',
    'instruction_placement' => 'label',
    'active'                => true,
    'show_in_rest'          => 0,
));
