<?php

namespace Elementor;

use RP_Utils;
use RealPressHelper;
use NaderMenuWalker;

defined('ABSPATH') || die();

class NaderMobileNavigation extends Widget_Base
{

    public function get_script_depends()
    {
        wp_register_script('nader-mobile-navigation', NADER_ELEMENTOR_JS_DIR . 'nader-mobile-navigation.js', ['jquery'], '1', true);
        return ['jquery', 'nader-mobile-navigation'];
    }

    public function get_style_depends()
    {
        wp_register_style('nader-mobile-navigation', NADER_ELEMENTOR_CSS_DIR . 'nader-mobile-navigation.min.css');
        return ['nader-mobile-navigation'];
    }

    public function get_name()
    {
        return 'NaderMobileNavigation';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : فهرست عمودی موبایل';
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
        RP_Utils::SECTION_START($this, 'first-row', 'استایل', 'style');

        RP_Utils::FONT_FIELD($this, 'fr-typography', 'تایپوگرافی', '.nader-mobile-navigation .nav-link');
        $fr_controls = [
            'padding',
            'color',
            'bg',
            'border',
            'border-radius',
            'shadow',
        ];
        RP_Utils::TAB_START($this, 'fr-tab');
        RP_Utils::DynamicStyleControls($this, 'fr-normal', '.nader-mobile-navigation .nav-link', $fr_controls);
        RP_Utils::TAB_MIDDLE($this, 'fr-tab');
        RP_Utils::DynamicStyleControls($this, 'fr-hover', '.nader-mobile-navigation .nav-link:hover', $fr_controls);
        RP_Utils::TAB_END($this);

        RP_Utils::SECTION_END($this);


        // icon
        RP_Utils::SECTION_START($this, 'fr-icon', 'آیکون', 'style');
        RP_Utils::SLIDER_FIELD_PIX_STYLE($this, 'fr-icon-gap', 'فاصله', 0, 30, null, '.nader-mobile-navigation .nav-link', 'gap');
        $this->add_responsive_control(
            'fr-icon-size',
            [
                'label'       => 'اندازه',
                'type'        => Controls_Manager::SLIDER,
                'label_block' => true,
                'size_units'  => ['px'],
                'range'       => [
                    'px' => [
                        'min' => 14,
                        'max' => 40,
                    ],
                ],
                'selectors'   => [
                    '{{WRAPPER}} .nader-mobile-navigation .nav-link > svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
                    '{{WRAPPER}} .nader-mobile-navigation .nav-link > img' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
                    '{{WRAPPER}} .nader-mobile-navigation .nav-link > i'   => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} .nader-mobile-navigation .nav-link .mega_menu_column-column_title > svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
                    '{{WRAPPER}} .nader-mobile-navigation .nav-link .mega_menu_column-column_title > img' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
                    '{{WRAPPER}} .nader-mobile-navigation .nav-link .mega_menu_column-column_title > i'   => 'font-size: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_control(
            'fr-icon-color-normal',
            [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .nader-mobile-navigation .nav-link svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .nader-mobile-navigation .nav-link i'   => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'fr-svg-color-normal',
            [
                'label' => 'رنگ path',
                'description' => 'در حالتی که رنگ برای svg عمل نکرد، از این گزینه استفاده کنید.',
                'label_block' => false,
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nader-mobile-navigation .nav-link svg:not(.dd-svg) path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'fr-icon-color-hover',
            [
                'label'       => 'رنگ هاور',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .nader-mobile-navigation .nav-link:hover svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .nader-mobile-navigation .nav-link:hover i'   => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'fr-svg-color-hover',
            [
                'label' => 'رنگ path هاور',
                'description' => 'در حالتی که رنگ برای svg عمل نکرد، از این گزینه استفاده کنید.',
                'label_block' => false,
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nader-mobile-navigation .nav-link:hover svg:not(.dd-svg) path' => 'fill: {{VALUE}};',
                ]
            ]
        );
        RP_Utils::SECTION_END($this);


        // sub menus
        RP_Utils::SECTION_START($this, 'submenus', 'زیرمنوها', 'style');

        RP_Utils::DIMENSIONS_FIELD($this, 'submenu-padding', 'padding', '.nader-mobile-navigation li > .sub-menu', 'padding');

        RP_Utils::Separator($this, 'submenu-1-bg', 'بکگراند زیر منو 1');
        RP_Utils::BACKGROUND_WO_IMG_FIELD($this, 'submenu-1-bg', '.nader-mobile-navigation li > ul');

        RP_Utils::Separator($this, 'submenu-2-bg', 'بکگراند زیر منو 2');
        RP_Utils::BACKGROUND_WO_IMG_FIELD($this, 'submenu-2-bg', '.nader-mobile-navigation ul ul');

        RP_Utils::Separator($this, 'submenu-3-bg', 'بکگراند زیر منو 3');
        RP_Utils::BACKGROUND_WO_IMG_FIELD($this, 'submenu-3-bg', '.nader-mobile-navigation ul ul ul');

        RP_Utils::Separator($this, 'mega-menu-column-head', 'توضیح');
        RP_Utils::FONT_FIELD($this, 'mega-menu-column-head-description-typography', 'تایپوگرافی', '.mega_menu_column-column_description');
        RP_Utils::COLOR_FIELD($this, 'mega-menu-column-head-description-color', 'رنگ', '','.mega_menu_column-column_description', 'color');

        RP_Utils::SECTION_END($this);


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $menu     = $settings['selected-menu'];

        $nav_menu_args = [
            'menu_class' => 'nader-mobile-navigation list-unstyled d-flex',
            'menu_id'    => 'nav',
            'container'  => 'ul',
            'menu'       => $menu,
            'walker'     => new NaderMenuWalker()
        ];

        wp_nav_menu($nav_menu_args);

    }
}

Plugin::instance()->widgets_manager->register(new NaderMobileNavigation());
