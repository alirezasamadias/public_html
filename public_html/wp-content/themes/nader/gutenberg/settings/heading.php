<?php
defined('ABSPATH') || die();

acf_add_local_field_group(array(
    'key'                   => 'group_63ef3b4c2321d',
    'title'                 => 'تنظیمات عنوان سایدبار',
    'fields'                => array(
        array(
            'key'               => 'field_63ef3b4c49ea5',
            'label'             => 'عنوان',
            'name'              => 'nader-block-heading-title',
            'type'              => 'text',
            'required'          => 0,
            'conditional_logic' => 0,
            'default_value'     => 'عنوان سایدبار',
        ),
        array(
            'key'               => 'field_63ef3b8149ea6',
            'label'             => 'آیکون',
            'name'              => 'nader-block-heading-icon',
            'type'              => 'textarea',
            'instructions'      => 'از سایت remixicon.com می‌توانید آیکون انتخاب کنید',
            'required'          => 0,
            'conditional_logic' => 0,
        ),
    ),
    'location'              => array(
        array(
            array(
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'acf/nader-heading',
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

