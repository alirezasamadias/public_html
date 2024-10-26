<?php

defined('ABSPATH') || die();

if (function_exists('acf_add_local_field_group')):

    // menu settings
    acf_add_local_field_group(array(
        'key'                   => 'group_62ce6dae61cf2',
        'title'                 => 'تنظیمات فهرست',
        'fields'                => array(
            array(
                'key'           => 'field_62e6d4e580faf',
                'label'         => 'نوع آیکون',
                'name'          => 'icon-type',
                'type'          => 'button_group',
                'choices'       => array(
                    'font-icon' => 'فونت آیکون',
                    'svg'       => 'svg',
                    'image'     => 'تصویر',
                ),
                'allow_null'    => 1,
                'layout'        => 'horizontal',
                'return_format' => 'value',
            ),
            array(
                'key'               => 'field_62ce6dc7a6309',
                'label'             => 'کلاس آیکون',
                'name'              => 'font-icon-class',
                'type'              => 'text',
                'instructions'      => 'کلاس آیکون را وارد کنید',
                'required'          => 1,
                'conditional_logic' => array(
                    array(
                        array(
                            'field'    => 'field_62e6d4e580faf',
                            'operator' => '==',
                            'value'    => 'font-icon',
                        ),
                    ),
                ),
            ),
            array(
                'key'               => 'field_62e6d55cd3744',
                'label'             => 'تصویر',
                'name'              => 'image-link',
                'type'              => 'image',
                'required'          => 1,
                'conditional_logic' => array(
                    array(
                        array(
                            'field'    => 'field_62e6d4e580faf',
                            'operator' => '==',
                            'value'    => 'image',
                        ),
                    ),
                ),
                'return_format'     => 'url',
                'preview_size'      => 'thumbnail',
                'library'           => 'all',
            ),
            array(
                'key'               => 'field_62e6d586d3745',
                'label'             => 'SVG',
                'name'              => 'svg',
                'type'              => 'textarea',
                'required'          => 1,
                'conditional_logic' => array(
                    array(
                        array(
                            'field'    => 'field_62e6d4e580faf',
                            'operator' => '==',
                            'value'    => 'svg',
                        ),
                    ),
                ),
            ),
            array(
                'key'           => 'field_65decb398c2f6',
                'label'         => 'نوع فهرست',
                'name'          => 'menu_type',
                'type'          => 'button_group',
                'choices'       => array(
                    'menu_simple'         => 'منوی آبشاری ساده',
                    'mega_menu_simple'    => 'مگامنو ساده',
                    'mega_menu_column'    => 'مگامنو ستونی',
                    'mega_menu_elementor' => 'مگامنو المنتور',
                ),
                'default_value' => 'none',
                'return_format' => 'value',
                'allow_null'    => 0,
                'layout'        => 'horizontal',
            ),
            array(
                'key'               => 'field_662de2bb63963',
                'label'             => 'قالب',
                'name'              => 'mega_menu_elementor_template',
                'type'              => 'post_object',
                'required'          => 1,
                'conditional_logic' => array(
                    array(
                        array(
                            'field'    => 'field_65decb398c2f6',
                            'operator' => '==',
                            'value'    => 'mega_menu_elementor',
                        ),
                    ),
                ),
                'post_type'         => array(
                    0 => 'elementor_library',
                ),
                'return_format'     => 'id',
                'multiple'          => 0,
                'allow_null'        => 0,
                'bidirectional'     => 0,
                'ui'                => 1,
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'nav_menu_item',
                    'operator' => '==',
                    'value'    => 'all',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
        'show_in_rest'          => false,
    ));

    // page settings
    acf_add_local_field_group(array(
        'key'                   => 'group_62f6687af1742',
        'title'                 => 'تنظیمات برگه',
        'fields'                => array(
            array(
                'key'           => 'field_62f6688edb798',
                'label'         => 'منو اختصاصی برگه',
                'name'          => 'select-menu',
                'type'          => 'select',
                'instructions'  => 'در صورت نیاز میتوانید یک منو خاص را فقط برای این برگه انتخاب کنید.',
                'choices'       => array(
                    42 => 'فهرست صفحه اصلی 1',
                ),
                'allow_null'    => 1,
                'multiple'      => 0,
                'ajax'          => 0,
                'placeholder'   => '',
                'return_format' => 'value',
                'ui'            => 1,
                'wrapper'       => array(
                    'width' => '50',
                ),
            ),
            array(
                'key'           => 'field_11b8f56a855ac',
                'label'         => 'حذف عنوان',
                'name'          => 'disable-page-title',
                'type'          => 'true_false',
                'default_value' => 0,
                'ui'            => 1,
                'wrapper'       => array(
                    'width' => '50',
                ),
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'page',
                ),
            ),
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'post',
                ),
            ),
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'project',
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

    // project gallery
    acf_add_local_field_group(array(
        'key'                   => 'group_63713447411d6',
        'title'                 => 'گالری تصویر پروژه',
        'fields'                => array(
            array(
                'key'           => 'field_637134472bd7f',
                'label'         => 'گالری تصاویر پروژه',
                'name'          => 'project-gallery-image',
                'type'          => 'gallery',
                'return_format' => 'id',
                'library'       => 'all',
                'insert'        => 'append',
                'preview_size'  => 'woocommerce_gallery_thumbnail',
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'project',
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

    // team information
    acf_add_local_field_group(array(
        'key'                   => 'group_6684440be0e5e',
        'title'                 => 'اطلاعات',
        'fields'                => array(
            array(
                'key'   => 'field_6684440989898',
                'label' => 'توضیح کوتاه',
                'name'  => 'excerpt',
                'type'  => 'textarea',
            ),
            array(
                'key'   => 'field_6684440cea89b',
                'label' => 'موقعیت',
                'name'  => 'position',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_668444a6ea89c',
                'label' => 'تخصص',
                'name'  => 'expertise',
                'type'  => 'text',

            ),
            array(
                'key'   => 'field_668444c5ea89d',
                'label' => 'سابقه کاری',
                'name'  => 'work_experience',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_668444ddea89e',
                'label' => 'ایمیل',
                'name'  => 'email',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_668444e7ea89f',
                'label' => 'شماره تماس',
                'name'  => 'contact_number',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_668444feea8a0',
                'label' => 'فیسبوک',
                'name'  => 'facebook',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_6684450cea8a1',
                'label' => 'لینکداین',
                'name'  => 'linkedin',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_6684451bea8a2',
                'label' => 'اینستاگرام',
                'name'  => 'instagram',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_6684452eea8a3',
                'label' => 'توییتر',
                'name'  => 'twitter',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_6684453eea8a4',
                'label' => 'گیت هاب',
                'name'  => 'github',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_6684454bea8a5',
                'label' => 'گیت لب',
                'name'  => 'gitlab',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_66844556ea8a6',
                'label' => 'پینترست',
                'name'  => 'pinterest',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_66844564ea8a7',
                'label' => 'دریبل',
                'name'  => 'dribbble',
                'type'  => 'text',
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'team',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => '',
        'active'                => true,
        'show_in_rest'          => 0,
    ));
    acf_add_local_field_group(array(
        'key'                   => 'group_3384440be945e',
        'title'                 => 'تنظیمات برگه',
        'fields'                => array(
            array(
                'key'           => 'field_999ff88edb798',
                'label'         => 'منو اختصاصی برگه',
                'name'          => 'select-menu',
                'type'          => 'select',
                'instructions'  => 'در صورت نیاز میتوانید یک منو خاص را فقط برای این برگه انتخاب کنید.',
                'choices'       => array(
                    42 => 'فهرست صفحه اصلی 1',
                ),
                'allow_null'    => 1,
                'multiple'      => 0,
                'ajax'          => 0,
                'placeholder'   => '',
                'return_format' => 'value',
                'ui'            => 1,
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'team',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => '',
        'active'                => true,
        'show_in_rest'          => 0,
    ));


    // product features
    acf_add_local_field_group(array(
        'key'                   => 'group_63e1deb8ac2d0',
        'title'                 => 'لیست ویژگی‌های محصول',
        'fields'                => array(
            array(
                'key'           => 'field_63e1deb938ffc',
                'label'         => 'ویژگی‌های محصول',
                'name'          => 'product-features',
                'type'          => 'repeater',
                'layout'        => 'block',
                'button_label'  => 'سطر جدید',
                'rows_per_page' => 20,
                'sub_fields'    => array(
                    array(
                        'key'             => 'field_63e1e94638ffd',
                        'label'           => 'عنوان',
                        'name'            => 'title',
                        'type'            => 'text',
                        'wrapper'         => array(
                            'width' => '30',
                        ),
                        'parent_repeater' => 'field_63e1deb938ffc',
                    ),
                    array(
                        'key'   => 'field_63e1e95d38ffe',
                        'label' => 'ویژگی',
                        'name'  => 'feature',
                        'type'  => 'text',
                        'wrapper'         => array(
                            'width' => '70',
                        ),
                        'parent_repeater' => 'field_63e1deb938ffc',
                    ),
                ),
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'product',
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

    // theme settings
    acf_add_local_field_group(array(
        'key'                   => 'group_62ce6ab65fc1c',
        'title'                 => 'تنظیمات قالب نادر',
        'fields'                => array(
            array(
                'key'       => 'field_62e6366f0e72f',
                'label'     => 'عمومی',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'           => 'field_62ce6c39bb66b',
                'label'         => 'لوگو سایت',
                'name'          => 'site-logo',
                'type'          => 'image',
                'return_format' => 'url',
                'library'       => 'all',
                'mime_types'    => 'jpg,jpeg,png,webp',
                'preview_size'  => 'thumbnail',
            ),
            array(
                'key'               => 'field_62ce6c8f6984b',
                'label'             => 'متن کپی رایت',
                'name'              => 'copyright-text',
                'type'              => 'textarea',
                'instructions'      => 'فقط برای فوتر غیر المنتوری است',
                'conditional_logic' => array(
                    array(
                        array(
                            'field'    => 'field_62f384bc6b1c3',
                            'operator' => '==empty',
                        ),
                    ),
                ),
                'rows'              => 3,
            ),
            array(
                'key'        => 'field_62ea68ee4d00f',
                'label'      => 'منو موبایل',
                'name'       => 'mobile-menu',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => array(
                    array(
                        'key'           => 'field_62ea68ee4d010',
                        'label'         => 'عنوان',
                        'name'          => 'title',
                        'type'          => 'text',
                        'wrapper'       => array(
                            'width' => '50',
                        ),
                        'default_value' => 'نادر',
                    ),
                    array(
                        'key'           => 'field_62ea691a4d013',
                        'label'         => 'زیر عنوان',
                        'name'          => 'subtitle',
                        'type'          => 'text',
                        'wrapper'       => array(
                            'width' => '50',
                        ),
                        'default_value' => 'قالب وردپرس شخصی و شرکتی',
                    ),
                ),
            ),
            array(
                'key'       => 'field_62e8f3f114e9b',
                'label'     => 'برگه ها',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'        => 'field_62e8f40314e9c',
                'label'      => 'ادامه مطلب نوشته',
                'name'       => 'nader-single',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => array(
                    array(
                        'key'           => 'field_92e8f57a855bd',
                        'label'         => 'نویسنده',
                        'name'          => 'author',
                        'type'          => 'true_false',
                        'wrapper'       => array(
                            'width' => '25',
                        ),
                        'default_value' => 1,
                        'ui'            => 1,
                    ),
                    array(
                        'key'           => 'field_62e8f59c855e0',
                        'label'         => 'دسته بندی',
                        'name'          => 'category',
                        'type'          => 'true_false',
                        'wrapper'       => array(
                            'width' => '25',
                        ),
                        'default_value' => 1,
                        'ui'            => 1,
                    ),
                    array(
                        'key'           => 'field_62e8f57a855dd',
                        'label'         => 'تاریخ',
                        'name'          => 'date',
                        'type'          => 'true_false',
                        'wrapper'       => array(
                            'width' => '25',
                        ),
                        'default_value' => 1,
                        'ui'            => 1,
                    ),
                    array(
                        'key'           => 'field_62e8c57b675dd',
                        'label'         => 'بازدید',
                        'name'          => 'view',
                        'type'          => 'true_false',
                        'wrapper'       => array(
                            'width' => '25',
                        ),
                        'default_value' => 1,
                        'ui'            => 1,
                    ),
                    array(
                        'key'           => 'field_62e7b97b675dd',
                        'label'         => 'نظرات',
                        'name'          => 'comment',
                        'type'          => 'true_false',
                        'wrapper'       => array(
                            'width' => '25',
                        ),
                        'default_value' => 1,
                        'ui'            => 1,
                    ),
                    array(
                        'key'           => 'field_13d9bb3513e76',
                        'label'         => 'برگه وبلاگ',
                        'name'          => 'blog-page',
                        'type'          => 'post_object',
                        'wrapper'       => array(
                            'width' => '25',
                        ),
                        'post_type'     => array(
                            0 => 'page',
                        ),
                        'return_format' => 'id',
                        'multiple'      => 0,
                        'allow_null'    => 1,
                        'ui'            => 1,
                    ),
                ),
            ),
            array(
                'key'        => 'field_62e8f5d61358f',
                'label'      => 'ادامه مطلب پروژه',
                'name'       => 'nader-single-project',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => array(
                    array(
                        'key'           => 'field_62e8f5d613591',
                        'label'         => 'دسته بندی',
                        'name'          => 'category',
                        'type'          => 'true_false',
                        'wrapper'       => array(
                            'width' => '25',
                        ),
                        'default_value' => 1,
                        'ui'            => 1,
                    ),
                    array(
                        'key'           => 'field_62fe85d613591',
                        'label'         => 'بازدید',
                        'name'          => 'view',
                        'type'          => 'true_false',
                        'wrapper'       => array(
                            'width' => '25',
                        ),
                        'default_value' => 1,
                        'ui'            => 1,
                    ),
                    array(
                        'key'           => 'field_62e8f5d694601',
                        'label'         => 'نظرات',
                        'name'          => 'comment',
                        'type'          => 'true_false',
                        'wrapper'       => array(
                            'width' => '25',
                        ),
                        'default_value' => 1,
                        'ui'            => 1,
                    ),
                    array(
                        'key'           => 'field_9d69bb3153e76',
                        'label'         => 'برگه پروژه ها',
                        'name'          => 'project-page',
                        'type'          => 'post_object',
                        'wrapper'       => array(
                            'width' => '25',
                        ),
                        'post_type'     => array(
                            0 => 'page',
                        ),
                        'return_format' => 'id',
                        'multiple'      => 0,
                        'allow_null'    => 1,
                        'ui'            => 1,
                    ),

                    array(
                        'key'     => 'field_917sss79d3rsq',
                        'label'   => 'عنوان تب محتوا',
                        'name'    => 'content-tab-title',
                        'type'    => 'text',
                        'wrapper' => array(
                            'width' => '30',
                        ),
                    ),
                    array(
                        'key'     => 'field_917s6d53d3rsq',
                        'label'   => 'عنوان تب فرم سفارش',
                        'name'    => 'order-form-tab-title',
                        'type'    => 'text',
                        'wrapper' => array(
                            'width' => '30',
                        ),
                    ),
                    array(
                        'key'           => 'field_63df5c3513e93',
                        'label'         => 'فرم سفارش پروزه',
                        'name'          => 'order-form',
                        'type'          => 'post_object',
                        'wrapper'       => array(
                            'width' => '40',
                        ),
                        'post_type'     => array(
                            0 => 'elementor_library',
                        ),
                        'return_format' => 'id',
                        'multiple'      => 0,
                        'allow_null'    => 1,
                        'ui'            => 1,
                    ),
                ),
            ),
            array(
                'key'           => 'field_63dff1080b940',
                'label'         => 'ویژگی های اختصاصی پروژه',
                'instructions'  => 'در صورت طراحی ادامه مطلب پروژه با المنتور، این بخش نیاز به پر کردن ندارد.',
                'name'          => 'custom-project-details',
                'type'          => 'repeater',
                'layout'        => 'block',
                'button_label'  => 'سطر جدید',
                'collapsed'     => 'field_63dff31a3d7c9',
                'rows_per_page' => 20,
                'sub_fields'    => array(
                    array(
                        'key'             => 'field_63dff31a3d7c9',
                        'label'           => 'عنوان',
                        'name'            => 'title',
                        'type'            => 'text',
                        'wrapper'         => array(
                            'width' => '50',
                        ),
                        'parent_repeater' => 'field_63dff1080b940',
                    ),
                    array(
                        'key'             => 'field_63dff3293d7ca',
                        'label'           => 'کلید',
                        'name'            => 'key',
                        'type'            => 'text',
                        'wrapper'         => array(
                            'width' => '50',
                        ),
                        'parent_repeater' => 'field_63dff1080b940',
                    ),
                    array(
                        'key'             => 'field_63dff3003d7c8',
                        'label'           => 'آیکون SVG',
                        'name'            => 'icon',
                        'type'            => 'textarea',
                        'rows'            => 4,
                        'parent_repeater' => 'field_63dff1080b940',
                    ),
                ),
            ),
            array(
                'key'           => 'field_94596c39bb66b',
                'label'         => 'بکگراند هدر آرشیو',
                'name'          => 'archive-header-bg',
                'type'          => 'image',
                'return_format' => 'url',
                'library'       => 'all',
                'mime_types'    => 'jpg,jpeg,png,webp',
                'preview_size'  => 'medium',
            ),

            array(
                'key'          => 'field_6300e022d5668',
                'label'        => 'بستن آکاردئون',
                'type'         => 'accordion',
                'open'         => 0,
                'multi_expand' => 0,
                'endpoint'     => 1,
            ),

            array(
                'key'       => 'field_63e68e5d96027',
                'label'     => 'فروشگاه',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'           => 'field_63e68e7896028',
                'label'         => 'تعداد محصولات هر برگه آرشیو',
                'name'          => 'nader-shop-posts-per-page',
                'type'          => 'number',
                'default_value' => 8,
            ),

            array(
                'key'           => 'field_66f7d21a471fa',
                'label'         => 'زمانی که محصول قیمت نداشته باشد در صفحه محصول نمایش داده شود:',
                'name'          => 'nader-single-product-without-price-replace',
                'type'          => 'button_group',
                'choices'       => array(
                    '\'\''   => 'هیچ',
                    'text'   => 'متن',
                    'button' => 'دکمه',
                ),
                'default_value' => '',
                'return_format' => 'value',
                'allow_null'    => 0,
                'layout'        => 'horizontal',
            ),
            array(
                'key'               => 'field_66f7d380797ac',
                'label'             => 'متن جایگزین',
                'name'              => 'nader-single-product-without-price-replace--text',
                'type'              => 'text',
                'conditional_logic' => array(
                    array(
                        array(
                            'field'    => 'field_66f7d21a471fa',
                            'operator' => '==',
                            'value'    => 'text',
                        ),
                    ),
                ),
                'default_value'     => 'تماس بگیرید',
            ),
            array(
                'key'               => 'field_66f7d3ad797ad',
                'label'             => 'عنوان دکمه',
                'name'              => 'nader-single-product-without-price-replace--button-title',
                'type'              => 'text',
                'conditional_logic' => array(
                    array(
                        array(
                            'field'    => 'field_66f7d21a471fa',
                            'operator' => '==',
                            'value'    => 'button',
                        ),
                    ),
                ),
            ),
            array(
                'key'               => 'field_66f7d3d9797ae',
                'label'             => 'لینک دکمه',
                'name'              => 'nader-single-product-without-price-replace--button-link',
                'type'              => 'text',
                'conditional_logic' => array(
                    array(
                        array(
                            'field'    => 'field_66f7d21a471fa',
                            'operator' => '==',
                            'value'    => 'button',
                        ),
                    ),
                ),
            ),

            array(
                'key'           => 'field_888ffffd9797ae',
                'label'         => 'نمایش دکمه یا متن جایگزین قیمت، در کارت های آرشیو فروشگاه',
                'name'          => 'nader-single-product-without-price-replace--in-archive',
                'type'          => 'true_false',
                'default_value' => 0,
                'ui'            => 1,
            ),

            array(
                'key'           => 'field_66f7d3ad999da',
                'label'         => 'متن جایگزین محصولات با قیمت صفر',
                'name'          => 'nader-single-product-without-price-replace--free',
                'type'          => 'text',
                'default_value' => 'رایگان',
            ),

            array(
                'key'       => 'field_62e6788f0e72f',
                'label'     => 'سایدبارها',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),

            array(
                'key'           => 'field_630bb56822f86',
                'label'         => 'سایدبار پست',
                'name'          => 'sidebar-posts',
                'type'          => 'true_false',
                'default_value' => 1,
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_630bb56822b68',
                'label'         => 'سایدبار برگه',
                'name'          => 'sidebar-page',
                'type'          => 'true_false',
                'default_value' => 1,
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_630bb56833f48',
                'label'         => 'سایدبار پروژه',
                'name'          => 'sidebar-projects',
                'type'          => 'true_false',
                'default_value' => 1,
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_630bb56833f48',
                'label'         => 'سایدبار کارمند',
                'name'          => 'sidebar-team',
                'type'          => 'true_false',
                'default_value' => 1,
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_630bb55892f48',
                'label'         => 'سایدبار آرشیو',
                'name'          => 'sidebar-archive',
                'type'          => 'true_false',
                'default_value' => 1,
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_560cb56822f48',
                'label'         => 'سایدبار فروشگاه',
                'name'          => 'sidebar-shop',
                'type'          => 'true_false',
                'default_value' => 1,
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_910cb56822f48',
                'label'         => 'سایدبار محصول',
                'name'          => 'sidebar-product',
                'type'          => 'true_false',
                'default_value' => 1,
                'ui'            => 1,
            ),

            array(
                'key'       => 'field_630bb54122f47',
                'label'     => 'موارد جانبی',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'           => 'field_630bb56822f48',
                'label'         => 'وضعیت لودر',
                'name'          => 'loader-enable',
                'type'          => 'true_false',
                'wrapper'       => array(
                    'width' => '50',
                ),
                'default_value' => 1,
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_62ebbe2751605',
                'label'         => 'نوع لودر',
                'name'          => 'loader-type',
                'type'          => 'button_group',
                'wrapper'       => array(
                    'width' => '50',
                ),
                'choices'       => array(
                    'simple' => 'ساده',
                    'linear' => 'خطی',
                ),
                'return_format' => 'value',
                'allow_null'    => 0,
                'layout'        => 'horizontal',
            ),
            array(
                'key'           => 'field_630bb63f22f4c',
                'label'         => 'وضعیت دنبال کننده موس',
                'name'          => 'mouse-cursor-enable',
                'type'          => 'true_false',
                'default_value' => 1,
                'ui'            => 1,
            ),

            array(
                'key'           => 'field_630bb67f22f4d',
                'label'         => 'وضعیت دکمه تماس پایین منو',
                'name'          => 'menu-bottom-contact-enable',
                'type'          => 'true_false',
                'wrapper'       => array(
                    'width' => '20',
                ),
                'default_value' => 1,
                'ui'            => 1,
            ),
            array(
                'key'     => 'field_630bb6ab22f4e',
                'label'   => 'عنوان دکمه تماس پایین منو',
                'name'    => 'menu-bottom-contact-title',
                'type'    => 'text',
                'wrapper' => array(
                    'width' => '40',
                ),
            ),
            array(
                'key'     => 'field_630bb6c722f4f',
                'label'   => 'لینک دکمه تماس پایین منو',
                'name'    => 'menu-bottom-contact-link',
                'type'    => 'text',
                'wrapper' => array(
                    'width' => '40',
                ),
            ),
            array(
                'key'        => 'field_630730ec414b8',
                'label'      => 'لیست شبکه های اجتماعی',
                'name'       => 'mobile-menu-bottom-socials',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => array(
                    array(
                        'key'           => 'field_630730ec414b9',
                        'label'         => 'وضعیت',
                        'name'          => 'enable',
                        'type'          => 'true_false',
                        'default_value' => 1,
                        'ui'            => 1,
                    ),
                    array(
                        'key'               => 'field_630731cdf7cc3',
                        'label'             => 'فیسبوک',
                        'name'              => 'facebook',
                        'type'              => 'text',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field'    => 'field_630730ec414b9',
                                    'operator' => '==',
                                    'value'    => '1',
                                ),
                            ),
                        ),
                        'wrapper'           => array(
                            'width' => '25',
                        ),
                    ),
                    array(
                        'key'               => 'field_63073203f7cc6',
                        'label'             => 'توییتر',
                        'name'              => 'twitter',
                        'type'              => 'text',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field'    => 'field_630730ec414b9',
                                    'operator' => '==',
                                    'value'    => '1',
                                ),
                            ),
                        ),
                        'wrapper'           => array(
                            'width' => '25',
                        ),
                    ),
                    array(
                        'key'               => 'field_63073206f7cc8',
                        'label'             => 'لینکداین',
                        'name'              => 'linkedin',
                        'type'              => 'text',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field'    => 'field_630730ec414b9',
                                    'operator' => '==',
                                    'value'    => '1',
                                ),
                            ),
                        ),
                        'wrapper'           => array(
                            'width' => '25',
                        ),
                    ),
                    array(
                        'key'               => 'field_59773206f7bb7',
                        'label'             => 'اینستاگرام',
                        'name'              => 'instagram',
                        'type'              => 'text',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field'    => 'field_630730ec414b9',
                                    'operator' => '==',
                                    'value'    => '1',
                                ),
                            ),
                        ),
                        'wrapper'           => array(
                            'width' => '25',
                        ),
                    ),
                    array(
                        'key'   => 'field_63073205f7cc7',
                        'label' => 'تلگرام',
                        'name'  => 'telegram',
                        'type'  => 'text',

                        'conditional_logic' => array(
                            array(
                                array(
                                    'field'    => 'field_630730ec414b9',
                                    'operator' => '==',
                                    'value'    => '1',
                                ),
                            ),
                        ),
                        'wrapper'           => array(
                            'width' => '25',
                        ),
                    ),
                    array(
                        'key'   => 'field_63073203f7cc5',
                        'label' => 'واتساپ',
                        'name'  => 'whatsapp',
                        'type'  => 'text',

                        'conditional_logic' => array(
                            array(
                                array(
                                    'field'    => 'field_630730ec414b9',
                                    'operator' => '==',
                                    'value'    => '1',
                                ),
                            ),
                        ),
                        'wrapper'           => array(
                            'width' => '25',
                        ),
                    ),
                    array(
                        'key'               => 'field_63073201f7cc4',
                        'label'             => 'دریبل',
                        'name'              => 'dribbble',
                        'type'              => 'text',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field'    => 'field_630730ec414b9',
                                    'operator' => '==',
                                    'value'    => '1',
                                ),
                            ),
                        ),
                        'wrapper'           => array(
                            'width' => '25',
                        ),
                    ),
                    array(
                        'key'   => 'field_6307325cf7ccb',
                        'label' => 'بیهنس',
                        'name'  => 'behance',
                        'type'  => 'text',

                        'conditional_logic' => array(
                            array(
                                array(
                                    'field'    => 'field_630730ec414b9',
                                    'operator' => '==',
                                    'value'    => '1',
                                ),
                            ),
                        ),
                        'wrapper'           => array(
                            'width' => '25',
                        ),
                    ),
                    array(
                        'key'   => 'field_6307325bf7cca',
                        'label' => 'گیت هاب',
                        'name'  => 'github',
                        'type'  => 'text',

                        'conditional_logic' => array(
                            array(
                                array(
                                    'field'    => 'field_630730ec414b9',
                                    'operator' => '==',
                                    'value'    => '1',
                                ),
                            ),
                        ),
                        'wrapper'           => array(
                            'width' => '25',
                        ),
                    ),
                    array(
                        'key'   => 'field_6307325bf7cc9',
                        'label' => 'گیت لب',
                        'name'  => 'gitlab',
                        'type'  => 'text',

                        'conditional_logic' => array(
                            array(
                                array(
                                    'field'    => 'field_630730ec414b9',
                                    'operator' => '==',
                                    'value'    => '1',
                                ),
                            ),
                        ),
                        'wrapper'           => array(
                            'width' => '25',
                        ),
                    ),
                    array(
                        'key'   => 'field_630736a9a9ccc',
                        'label' => 'یوتیوب',
                        'name'  => 'youtube',
                        'type'  => 'text',

                        'conditional_logic' => array(
                            array(
                                array(
                                    'field'    => 'field_630730ec414b9',
                                    'operator' => '==',
                                    'value'    => '1',
                                ),
                            ),
                        ),
                        'wrapper'           => array(
                            'width' => '25',
                        ),
                    ),
                    array(
                        'key'   => 'field_630736b5a9ccd',
                        'label' => 'آپارات',
                        'name'  => 'aparat',
                        'type'  => 'text',

                        'conditional_logic' => array(
                            array(
                                array(
                                    'field'    => 'field_630730ec414b9',
                                    'operator' => '==',
                                    'value'    => '1',
                                ),
                            ),
                        ),
                        'wrapper'           => array(
                            'width' => '25',
                        ),
                    ),
                    array(
                        'key'   => 'field_6307329bf7ccc',
                        'label' => 'ایمیل',
                        'name'  => 'email',
                        'type'  => 'text',

                        'conditional_logic' => array(
                            array(
                                array(
                                    'field'    => 'field_630730ec414b9',
                                    'operator' => '==',
                                    'value'    => '1',
                                ),
                            ),
                        ),
                        'wrapper'           => array(
                            'width' => '25',
                        ),
                    ),
                ),
            ),
            array(
                'key'          => 'field_63f3190679a38',
                'label'        => 'کلمات کلیدی جستجو',
                'name'         => 'nader-search-keywords',
                'aria-label'   => '',
                'type'         => 'repeater',
                'instructions' => '',
                'required'     => 0,

                'wrapper'       => array(
                    'width' => '',
                    'class' => '',
                    'id'    => '',
                ),
                'layout'        => 'block',
                'pagination'    => 0,
                'min'           => 0,
                'max'           => 0,
                'collapsed'     => '',
                'button_label'  => 'سطر جدید',
                'rows_per_page' => 20,
                'sub_fields'    => array(
                    array(
                        'key'             => 'field_63f3196679a39',
                        'label'           => 'کلمه کلیدی',
                        'name'            => 'keyword',
                        'type'            => 'text',
                        'parent_repeater' => 'field_63f3190679a38',
                    ),
                ),
            ),
            array(
                'key'       => 'field_630ag54122b38',
                'label'     => 'دکمه های گوشه ای',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'           => 'field_630bb5c822f4a',
                'label'         => 'وضعیت دکمه بالابر',
                'name'          => 'scroll-to-top-enable',
                'type'          => 'true_false',
                'wrapper'       => array(
                    'width' => '50',
                ),
                'default_value' => 1,
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_62e636a40e731',
                'label'         => 'نوع دکمه بالابر',
                'name'          => 'scroll-to-top-type',
                'type'          => 'button_group',
                'wrapper'       => array(
                    'width' => '50',
                ),
                'choices'       => array(
                    'simple' => 'ساده',
                    'line'   => 'خطی',
                ),
                'default_value' => 'line',
                'return_format' => 'value',
                'allow_null'    => 0,
                'layout'        => 'horizontal',
            ),
            array(
                'key'           => 'field_63721a9474694',
                'label'         => 'وضعیت دکمه سبد خرید',
                'name'          => 'cart-btn-enable',
                'type'          => 'true_false',
                'default_value' => 1,
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_63721a9374693',
                'label'         => 'وضعیت دکمه جستجو',
                'name'          => 'search-btn-enable',
                'type'          => 'true_false',
                'default_value' => 1,
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_649da30da5e26',
                'label'         => 'نحوه نمایش دکمه های دلخواه',
                'name'          => 'corner-btns-display-style',
                'type'          => 'button_group',
                'choices'       => array(
                    'float' => 'شناور',
                    'popup' => 'پاپ آپ',
                ),
                'default_value' => 'float',
                'return_format' => 'value',
                'allow_null'    => 0,
                'layout'        => 'horizontal',
                'wrapper'       => array(
                    'width' => '50',
                ),
            ),
            array(
                'key'     => 'field_647aaaa3d3rsq',
                'label'   => 'عنوان باکس پاپ آپ دکمه های دلخواه',
                'name'    => 'popup-corner-btns-title',
                'type'    => 'text',
                'wrapper' => array(
                    'width' => '50',
                ),
            ),
            array(
                'key'           => 'field_647ece3fd3efe',
                'label'         => 'دکمه های دلخواه',
                'name'          => 'custom-corner-buttons',
                'type'          => 'repeater',
                'layout'        => 'table',
                'pagination'    => 0,
                'min'           => 0,
                'max'           => 0,
                'button_label'  => 'دکمه جدید',
                'collapsed'     => 'field_647ecea3d3eff',
                'rows_per_page' => 20,
                'instructions'  => 'نحوه تغییر دکمه ها به رنگ دلخواه در راهنمای آنلاین توضیح داده شده است',
                'sub_fields'    => array(
                    array(
                        'key'             => 'field_647ecea3d3eff',
                        'label'           => 'لینک',
                        'name'            => 'link',
                        'type'            => 'text',
                        'parent_repeater' => 'field_647ece3fd3efe',
                    ),
                    array(
                        'key'             => 'field_647ecea3d3rsq',
                        'label'           => 'عنوان',
                        'name'            => 'title',
                        'type'            => 'text',
                        'parent_repeater' => 'field_647ece3fd3efe',
                    ),
                    array(
                        'key'             => 'field_910ce6ab22f4e',
                        'label'           => 'کلاس دلخواه',
                        'name'            => 'class',
                        'type'            => 'text',
                        'parent_repeater' => 'field_647ece3fd3efe',
                    ),
                    array(
                        'key'             => 'field_647eceb3d3f00',
                        'label'           => 'آیکون',
                        'name'            => 'icon',
                        'type'            => 'textarea',
                        'parent_repeater' => 'field_647ece3fd3efe',
                    ),
                ),
            ),

            array(
                'key'       => 'field_111155553ef5c',
                'label'     => 'ورود / عضویت',
                'type'      => 'tab',
                'placement' => 'top',
            ),
            array(
                'key'          => 'field_649da3c1a5e27',
                'label'        => 'وضعیت دکمه گوشه ای ورود/عضویت ایجکسی',
                'name'         => 'ajax-login-btn-enable',
                'type'         => 'true_false',
                'instructions' => 'برای حذف بخش عضویت، از تنظمیات وردپرس نام نویسی را غیرفعال کنید.',
                'ui'           => 1,
            ),

            array(
                'key'           => 'field_649da3c1a5e72',
                'label'         => 'وضعیت ورود/عضویت ایجکسی',
                'name'          => 'ajax-login-enable',
                'type'          => 'true_false',
                'instructions'  => 'این کل بخش ورود اختصاصی را غیرفعال میکند',
                'ui'            => 1,
                'default_value' => 1,
            ),
            array(
                'key'          => 'field_649da3c1a3rsq',
                'label'        => 'آدرس ریدایرکت پس از ورود',
                'instructions' => 'برای صفحه اصلی خالی بگذارید. به http یا https بودن سایت دقت کنید!',
                'name'         => 'ajax-login-redirect',
                'type'         => 'text',
            ),

            array(
                'key'       => 'field_634d6f723ef5c',
                'label'     => 'رنگ بندی',
                'type'      => 'tab',
                'placement' => 'top',
            ),
            array(
                'key'            => 'field_62ce6acfa8b7a',
                'label'          => 'رنگ اصلی',
                'name'           => 'site-color',
                'type'           => 'color_picker',
                'default_value'  => '#d79d4b',
                'enable_opacity' => 0,
                'return_format'  => 'string',
            ),
            array(
                'key'            => 'field_634d7af94d999',
                'label'          => 'رنگ متن هدر آرشیو',
                'name'           => 'archive-header-text-color',
                'type'           => 'color_picker',
                'enable_opacity' => 0,
                'return_format'  => 'string',
            ),
            array(
                'key'        => 'field_639ae1a0cb524',
                'label'      => 'منو دسکتاپ',
                'name'       => 'desktop-menu-color',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => array(
                    array(
                        'key'            => 'field_639ae1a1cb525',
                        'label'          => 'بکگراند',
                        'name'           => 'bg',
                        'type'           => 'color_picker',
                        'wrapper'        => array(
                            'width' => '25',
                        ),
                        'default_value'  => '#ffffff',
                        'enable_opacity' => 0,
                    ),
                    array(
                        'key'            => 'field_888ae1a1cb525',
                        'label'          => 'بکگراند لوگو',
                        'name'           => 'logo-bg',
                        'type'           => 'color_picker',
                        'wrapper'        => array(
                            'width' => '25',
                        ),
                        'default_value'  => '#222222',
                        'enable_opacity' => 0,
                    ),
                    array(
                        'key'            => 'field_111ae1a1cb525',
                        'label'          => 'بکگراند دکمه تماس',
                        'name'           => 'contact-bg',
                        'type'           => 'color_picker',
                        'wrapper'        => array(
                            'width' => '25',
                        ),
                        'default_value'  => '#222222',
                        'enable_opacity' => 0,
                    ),
                    array(
                        'key'            => 'field_639ae1a1cb526',
                        'label'          => 'رنگ اولیه لینک',
                        'name'           => 'link-normal-color',
                        'type'           => 'color_picker',
                        'wrapper'        => array(
                            'width' => '25',
                        ),
                        'default_value'  => '#222',
                        'enable_opacity' => 0,
                    ),
                    array(
                        'key'            => 'field_639ae1a1cb527',
                        'label'          => 'رنگ هاور لینک',
                        'name'           => 'link-hover-color',
                        'type'           => 'color_picker',
                        'wrapper'        => array(
                            'width' => '25',
                        ),
                        'default_value'  => '#fff',
                        'enable_opacity' => 0,
                    ),
                    array(
                        'key'            => 'field_639ae1a1cb528',
                        'label'          => 'بکگراند هاور لینک',
                        'name'           => 'link-hover-bg',
                        'type'           => 'color_picker',
                        'wrapper'        => array(
                            'width' => '25',
                        ),
                        'default_value'  => '#222',
                        'enable_opacity' => 0,
                        'return_format'  => 'string',
                    ),
                ),
            ),
            array(
                'key'        => 'field_6344557d3ef61',
                'label'      => 'هدر بالا موبایل',
                'name'       => 'mobile-header-color',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => array(
                    array(
                        'key'            => 'field_634d709f3e111',
                        'label'          => 'بکگراند',
                        'name'           => 'bg',
                        'type'           => 'color_picker',
                        'wrapper'        => array(
                            'width' => '20',
                        ),
                        'default_value'  => '#3e4041',
                        'enable_opacity' => 0,
                        'return_format'  => 'string',
                    ),
                    array(
                        'key'            => 'field_634d71173e222',
                        'label'          => 'بکگراند لوگو',
                        'name'           => 'logo-bg',
                        'type'           => 'color_picker',
                        'wrapper'        => array(
                            'width' => '20',
                        ),
                        'default_value'  => '#222',
                        'enable_opacity' => 0,
                        'return_format'  => 'string',
                    ),
                    array(
                        'key'            => 'field_634d70d13e333',
                        'label'          => 'رنگ دکمه باز کننده منو موبایل',
                        'name'           => 'opener-icon',
                        'type'           => 'color_picker',
                        'wrapper'        => array(
                            'width' => '20',
                        ),
                        'default_value'  => '#fff',
                        'enable_opacity' => 0,
                        'return_format'  => 'string',
                    ),
                ),
            ),
            array(
                'key'        => 'field_634d707d3ef61',
                'label'      => 'منو موبایل',
                'name'       => 'mobile-menu-color',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => array(
                    array(
                        'key'            => 'field_634d709f3ef62',
                        'label'          => 'بکگراند',
                        'name'           => 'bg',
                        'type'           => 'color_picker',
                        'wrapper'        => array(
                            'width' => '20',
                        ),
                        'default_value'  => '#ffffff',
                        'enable_opacity' => 0,
                        'return_format'  => 'string',
                    ),
                    array(
                        'key'            => 'field_634d71173ef66',
                        'label'          => 'بکگراند لوگو',
                        'name'           => 'logo-bg',
                        'type'           => 'color_picker',
                        'wrapper'        => array(
                            'width' => '20',
                        ),
                        'default_value'  => '#444',
                        'enable_opacity' => 0,
                        'return_format'  => 'string',
                    ),
                    array(
                        'key'            => 'field_634d70d13ef63',
                        'label'          => 'رنگ متن',
                        'name'           => 'text-color',
                        'type'           => 'color_picker',
                        'wrapper'        => array(
                            'width' => '20',
                        ),
                        'default_value'  => '#222',
                        'enable_opacity' => 0,
                        'return_format'  => 'string',
                    ),
                    array(
                        'key'            => 'field_634d70e63ef64',
                        'label'          => 'رنگ لینک',
                        'name'           => 'link-color',
                        'type'           => 'color_picker',
                        'wrapper'        => array(
                            'width' => '20',
                        ),
                        'default_value'  => '#222',
                        'enable_opacity' => 0,
                        'return_format'  => 'string',
                    ),
                    array(
                        'key'            => 'field_634d70f53ef65',
                        'label'          => 'بکگراند لینک',
                        'name'           => 'link-bg',
                        'type'           => 'color_picker',
                        'wrapper'        => array(
                            'width' => '20',
                        ),
                        'default_value'  => '#D9D9DC',
                        'enable_opacity' => 0,
                        'return_format'  => 'string',
                    ),
                    array(
                        'key'            => 'field_634d71303ef67',
                        'label'          => 'رنگ دکمه بستن منو',
                        'name'           => 'menu-closer-color',
                        'type'           => 'color_picker',
                        'wrapper'        => array(
                            'width' => '20',
                        ),
                        'default_value'  => '#222',
                        'enable_opacity' => 0,
                        'return_format'  => 'string',
                    ),
                ),
            ),
            array(
                'key'        => 'field_634d7a594d7b6',
                'label'      => 'فوتر',
                'name'       => 'footer-color',
                'type'       => 'group',
                'layout'     => 'block',
                'sub_fields' => array(
                    array(
                        'key'            => 'field_634d7a764d7b7',
                        'label'          => 'بکگراند',
                        'name'           => 'bg',
                        'type'           => 'color_picker',
                        'wrapper'        => array(
                            'width' => '25',
                        ),
                        'default_value'  => '#222',
                        'enable_opacity' => 0,
                    ),
                    array(
                        'key'            => 'field_634d7a8d4d7b8',
                        'label'          => 'رنگ متن',
                        'name'           => 'text-color',
                        'type'           => 'color_picker',
                        'wrapper'        => array(
                            'width' => '25',
                        ),
                        'default_value'  => '#fff',
                        'enable_opacity' => 0,
                    ),
                ),
            ),

        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'nader-settings',
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

endif;


