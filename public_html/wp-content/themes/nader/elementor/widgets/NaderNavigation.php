<?php

namespace Elementor;

use RP_Utils;
use RealPressHelper;
use NaderMenuWalker;

defined('ABSPATH') || die();

class NaderNavigation extends Widget_Base
{

    public function get_style_depends()
    {
        wp_register_style('nader-navigation', NADER_ELEMENTOR_CSS_DIR . 'nader-navigation.min.css');
        return ['nader-navigation'];
    }

    public function get_name()
    {
        return 'NaderNavigation';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : فهرست';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-nav-menu';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        $menus = RealPressHelper::getMenus();
        RP_Utils::SELECT_FIELD($this, 'selected-menu', 'فهرست', $menus, array_key_first($menus));

        $this->end_controls_section();

        $this->register_controls_style();
    }

    protected function register_controls_style()
    {

        // first row
        RP_Utils::SECTION_START($this, 'first-row', 'ردیف اول', 'style');
        RP_Utils::FONT_FIELD($this, 'fr-typography', 'تایپوگرافی', '.nader-navigation .nav-link');

        $fr_controls = [
            'padding',
            'color',
            'bg',
            'border',
            'border-radius',
            'shadow',
        ];
        RP_Utils::TAB_START($this, 'fr-tab');
        RP_Utils::DynamicStyleControls($this, 'fr-normal', '.nader-navigation .nav-link', $fr_controls);
        RP_Utils::TAB_MIDDLE($this, 'fr-tab');
        RP_Utils::DynamicStyleControls($this, 'fr-hover', '.nader-navigation .nav-link:hover', $fr_controls);
        RP_Utils::TAB_END($this);

        RP_Utils::Separator($this, 'fr-icon', 'آیکون');
        RP_Utils::SLIDER_FIELD_PIX_STYLE($this, 'fr-icon-gap', 'فاصله', 0, 30, null, '.nader-navigation .nav-link', 'gap');
        $this->add_responsive_control(
            'fr-icon-size',
            [
                'label' => 'اندازه',
                'type' => Controls_Manager::SLIDER,
                'label_block' => true,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 14,
                        'max' => 40,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .nader-navigation .nav-link svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
                    '{{WRAPPER}} .nader-navigation .nav-link img' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
                    '{{WRAPPER}} .nader-navigation .nav-link i' => 'font-size: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_control(
            'fr-icon-color-normal',
            [
                'label' => 'رنگ',
                'label_block' => false,
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nader-navigation .nav-link svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .nader-navigation .nav-link i' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'fr-icon-color-hover',
            [
                'label' => 'رنگ هاور',
                'label_block' => false,
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nader-navigation .nav-link:hover svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .nader-navigation .nav-link:hover i' => 'color: {{VALUE}};',
                ]
            ]
        );

        RP_Utils::Separator($this, 'fr-dd-icon', 'آیکون دراپ دون');
        RP_Utils::COLOR_FIELD($this, 'fr-icon-dd-color-normal', 'رنگ', '', '.nader-navigation .nav-link .dropdown-icon svg', 'fill');
        RP_Utils::COLOR_FIELD($this, 'fr-icon-dd-color-hover', 'رنگ هاور', '', '.nader-navigation .nav-link:hover .dropdown-icon svg', 'fill');

        RP_Utils::SECTION_END($this);


        // submenu box
        RP_Utils::SECTION_START($this, 'submenu-box', 'باکس زیرمنو', 'style');
        RP_Utils::Separator($this, 'simple-dropdown-box', 'منوی ساده');

        $simple_menu_box_controls = [
            'bg',
            'border',
            'radius',
            'shadow'
        ];
        RP_Utils::DynamicStyleControls($this, 'submenu-box', '.nader-navigation > .menu_simple .sub-menu', $simple_menu_box_controls);


        RP_Utils::Separator($this, 'mega-menu-box', 'مگامنو');
        $mega_menu_box_controls = [
            'padding',
            'bg',
            'border',
            'shadow'
        ];
        RP_Utils::DynamicStyleControls($this, 'mega-menu-box', '.nader-navigation .mega-menu-box', $mega_menu_box_controls);

        RP_Utils::SECTION_END($this);


        // submenu item
        RP_Utils::SECTION_START($this, 'submenu-item', 'آیتم زیرمنو', 'style');
        RP_Utils::FONT_FIELD($this, 'submenu-item-typography', 'تایپوگرافی', '.nader-navigation ul .nav-link');
        $submenu_item_controls = [
            'padding',
            'color',
            'bg',
            'border',
            'border-radius',
            'shadow',
        ];
        RP_Utils::TAB_START($this, 'submenu-item-tab');
        RP_Utils::DynamicStyleControls($this, 'submenu-item-normal', '.nader-navigation ul .nav-link', $submenu_item_controls);
        RP_Utils::TAB_MIDDLE($this, 'submenu-item-tab');
        RP_Utils::DynamicStyleControls($this, 'submenu-item-hover', '.nader-navigation ul .nav-link:hover', $submenu_item_controls);
        RP_Utils::TAB_END($this);

        RP_Utils::Separator($this, 'submenu-item-icon', 'آیکون');
        RP_Utils::SLIDER_FIELD_PIX_STYLE($this, 'submenu-item-icon-gap', 'فاصله', 0, 30, null, '.nader-navigation ul .nav-link', 'gap');
        $this->add_responsive_control(
            'submenu-item-icon-size',
            [
                'label' => 'اندازه',
                'type' => Controls_Manager::SLIDER,
                'label_block' => true,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 14,
                        'max' => 40,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .nader-navigation ul .nav-link svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
                    '{{WRAPPER}} .nader-navigation ul .nav-link img' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
                    '{{WRAPPER}} .nader-navigation ul .nav-link i' => 'font-size: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_control(
            'submenu-item-icon-color-normal',
            [
                'label' => 'رنگ',
                'label_block' => false,
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nader-navigation ul .nav-link svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .nader-navigation ul .nav-link i' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'submenu-item-icon-color-hover',
            [
                'label' => 'رنگ هاور',
                'label_block' => false,
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nader-navigation ul .nav-link:hover svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .nader-navigation ul .nav-link:hover i' => 'color: {{VALUE}};',
                ]
            ]
        );

        RP_Utils::Separator($this, 'submenu-item-dd-icon', 'آیکون دراپ دون');
        RP_Utils::COLOR_FIELD($this, 'submenu-icon-dd-color-normal', 'رنگ', '', '.nader-navigation ul .nav-link .dropdown-icon svg', 'fill');
        RP_Utils::COLOR_FIELD($this, 'submenu-icon-dd-color-hover', 'رنگ هاور', '', '.nader-navigation ul .nav-link:hover .dropdown-icon svg', 'fill');

        RP_Utils::SECTION_END($this);


        RP_Utils::SECTION_START($this, 'mega-menu-column-head-item', 'سرستون مگامنو ستونی', 'style');

        RP_Utils::FONT_FIELD($this, 'mega-menu-column-head-item-title-typography', 'تایپوگرافی متن اصلی', '.nader-navigation .mega_menu_column_head .mega_menu_column-column_title');
        RP_Utils::FONT_FIELD($this, 'mega-menu-column-head-item-description-typography', 'تایپوگرافی متن توضیح', '.nader-navigation .mega_menu_column_head .mega_menu_column-column_description');

        $mega_menu_column_head_item_controls = [
            'padding',
            'bg',
            'border',
            'border-radius',
            'shadow',
        ];
        RP_Utils::TAB_START($this, 'mega-menu-column-head-item-tab');
        RP_Utils::COLOR_FIELD($this, 'mega-menu-column-head-item-title-color-normal', 'رنگ متن اصلی', '', '.nader-navigation .mega_menu_column_head .mega_menu_column-column_title', 'color');
        RP_Utils::COLOR_FIELD($this, 'mega-menu-column-head-item-description-color-normal', 'رنگ متن توضیح', '', '.nader-navigation .mega_menu_column_head .mega_menu_column-column_description', 'color');
        RP_Utils::DynamicStyleControls($this, 'mega-menu-column-head-item-normal', '.nader-navigation .mega_menu_column_head', $mega_menu_column_head_item_controls);

        RP_Utils::TAB_MIDDLE($this, 'mega-menu-column-head-item-tab');

        RP_Utils::COLOR_FIELD($this, 'mega-menu-column-head-item-title-color-hover', 'رنگ متن اصلی', '', '.nader-navigation .mega_menu_column_head:hover .mega_menu_column-column_title', 'color');
        RP_Utils::COLOR_FIELD($this, 'mega-menu-column-head-item-description-color-hover', 'رنگ متن توضیح', '', '.nader-navigation .mega_menu_column_head:hover .mega_menu_column-column_description', 'color');
        RP_Utils::DynamicStyleControls($this, 'mega-menu-column-head-item-hover', '.nader-navigation .mega_menu_column_head:hover', $mega_menu_column_head_item_controls);
        RP_Utils::TAB_END($this);

        RP_Utils::Separator($this, 'mega-menu-column-head-item-icon', 'آیکون');
        $this->add_responsive_control(
            'mega-menu-column-head-item-icon-size',
            [
                'label' => 'اندازه',
                'type' => Controls_Manager::SLIDER,
                'label_block' => true,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 14,
                        'max' => 40,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .nader-navigation ul .nav-link svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
                    '{{WRAPPER}} .nader-navigation ul .nav-link img' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
                    '{{WRAPPER}} .nader-navigation ul .nav-link i' => 'font-size: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_control(
            'mega-menu-column-head-item-icon-color-normal',
            [
                'label' => 'رنگ',
                'label_block' => false,
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nader-navigation ul .nav-link svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .nader-navigation ul .nav-link i' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'mega-menu-column-head-item-icon-color-normal-path',
            [
                'label' => 'رنگ path',
                'description' => 'در حالتی که برای svg عمل نکرد، از این گزینه استفاده کنید.',
                'label_block' => false,
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nader-navigation ul .nav-link svg:not(.dd-svg) path' => 'fill: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'mega-menu-column-head-item-icon-color-hover',
            [
                'label' => 'رنگ هاور',
                'label_block' => false,
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nader-navigation ul .nav-link:hover svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .nader-navigation ul .nav-link:hover i' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'mega-menu-column-head-item-icon-color-hover-path',
            [
                'label' => 'رنگ path هاور',
                'description' => 'در حالتی که برای svg عمل نکرد، از این گزینه استفاده کنید.',
                'label_block' => false,
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nader-navigation ul .nav-link:hover svg:not(.dd-svg) path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        RP_Utils::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $menu = $settings['selected-menu'];

        $nav_menu_args = [
            'menu_class' => 'nader-navigation list-unstyled d-flex',
            'menu_id' => 'nav',
            'container' => 'ul',
            'menu' => $menu,
            'walker' => new NaderMenuWalker($menu)
        ];

        wp_nav_menu($nav_menu_args);

    }
}

Plugin::instance()->widgets_manager->register(new NaderNavigation());
