<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;
use AE_E_FUNCTIONS;

class WP_ACTIVE_WE_DropdownMenuOneColumn extends Widget_Base{

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-dropdown-menu-one-column', AE_E_CSS_DIR . 'dropdown-menu-one-column.min.css');
        return ['wp-active-we-dropdown-menu-one-column'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'منو دراپ دون تک ستونی';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-nav-menu';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);
        $menus = AE_E_FUNCTIONS::getMenusList();
        AE_E_UTILS::SELECT_FIELD($this, 'selected-menu', 'فهرست', $menus, array_key_first($menus));
        AE_E_UTILS::TXT_FIELD($this, 'title', 'عنوان', 'منوی دراپ دون تک ستونی', true);
        AE_E_UTILS::SWITCH_FIELD($this, 'open-with-click', 'باز شدن با کلیک');
        AE_E_UTILS::Separator($this, 'menu-icon', 'آیکون منو');
        AE_E_UTILS::ICON($this, 'menu-icon', 'fa fa-bars');
        AE_E_UTILS::Separator($this, 'opener-icon', 'آیکون بازکردن');
        AE_E_UTILS::ICON($this, 'opener-icon', 'fa fa-arrow-down');
        AE_E_UTILS::Separator($this, 'closer-icon', 'آیکون بستن');
        AE_E_UTILS::ICON($this, 'closer-icon', 'fa fa-arrow-up');
        $this->end_controls_section();


        $this->styles_opener();
        $this->styles_dropdown_menu();
    }

    protected function styles_opener()
    {
        AE_E_UTILS::SECTION_START($this, 'opener', 'باکس بازکننده', 'style');
        $this->add_responsive_control('opener-height', [
            'label'       => 'ارتفاع',
            'type'        => Controls_Manager::SLIDER,
            'label_block' => true,
            'size_units'  => ['px'],
            'range'       => [
                'px' => [
                    'min' => 20,
                    'max' => 80,
                ],
            ],
            'selectors'   => [
                '{{WRAPPER}} .menu-opener'                                                          => 'height: {{SIZE}}px;',
                '{{WRAPPER}} .wp-active-we-dropdown-menu-one-column:not(.open-with-click):hover>ul' => 'top: {{SIZE}}px;',
                '{{WRAPPER}} .wp-active-we-dropdown-menu-one-column.open-with-click.active>ul'      => 'top: {{SIZE}}px;',
            ],
        ]);
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'opener-gap', 'فاصله', 0, 200, null, '.menu-opener', 'gap');
        AE_E_UTILS::BoxUtils($this, 'opener', '.menu-opener');
        AE_E_UTILS::SECTION_END($this);


        AE_E_UTILS::SECTION_START($this, 'opener-title', 'عنوان باکس بازکننده', 'style');
        AE_E_UTILS::FONT_FIELD($this, 'title-typography', 'تایپوگرافی', '.menu-title');
        AE_E_UTILS::COLOR_FIELD($this, 'title-color-normal', 'رنگ عادی', '', '.menu-title', 'color');
        AE_E_UTILS::COLOR_FIELD($this, 'title-color-hover', 'رنگ هاور', '', '.menu-opener:hover .menu-title', 'color');
        AE_E_UTILS::SECTION_END($this);


        AE_E_UTILS::SECTION_START($this, 'opener-icons', 'آیکون های باکس بازکننده', 'style');
        AE_E_UTILS::Separator($this, 'menu-icon-separator', 'آیکون منو');
        AE_E_UTILS::IconUtils($this, 'menu-icon', '.menu-icon', '.wp-active-we-dropdown-menu-one-column');
        AE_E_UTILS::Separator($this, 'opener-icon-separator', 'آیکون باز کردن/بستن');
        AE_E_UTILS::IconUtils($this, 'opener-icon', '.menu-status-icon .icon', '.wp-active-we-dropdown-menu-one-column');
        AE_E_UTILS::SECTION_END($this);
    }

    protected function styles_dropdown_menu()
    {
        AE_E_UTILS::SECTION_START($this, 'dropdown-menu-box', 'باکس منو', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'ddm-box-min-width', 'عرض', 100, 400, null, '.wp-active-we-dropdown-menu-one-column ul', 'min-width');
        AE_E_UTILS::DynamicStyleControls($this, 'ddm-box', '.wp-active-we-dropdown-menu-one-column ul', [
            'padding',
            'background',
            'border',
            'radius',
            'shadow',
        ]);
        AE_E_UTILS::SECTION_END($this);

        AE_E_UTILS::SECTION_START($this, 'dropdown-menu-link', 'لینک', 'style');
        AE_E_UTILS::FONT_FIELD($this, 'ddm-link-typography', 'تایپوگرافی', '.wp-active-we-dropdown-menu-one-column ul li a');
        AE_E_UTILS::COLOR_FIELD($this, 'ddm-link-color-normal', 'رنگ عادی', '', '.wp-active-we-dropdown-menu-one-column ul li a', 'color');
        AE_E_UTILS::COLOR_FIELD($this, 'ddm-link-color-hover', 'رنگ هاور', '', '.wp-active-we-dropdown-menu-one-column ul li a:hover', 'color');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'ddm-link-padding', 'فاصله داخلی', '.wp-active-we-dropdown-menu-one-column ul li a', 'padding');
        AE_E_UTILS::COLOR_FIELD($this, 'ddm-link-arrow-color-normal', 'رنگ آیکون عادی', '', 'li.menu-item-has-children>a:after', 'border-color');
        AE_E_UTILS::COLOR_FIELD($this, 'ddm-link-arrow-color-hover', 'رنگ آیکون هاور', '', 'li.menu-item-has-children>a:hover:after', 'border-color');
        AE_E_UTILS::SECTION_END($this);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $open_with_click = $settings['open-with-click'];

        $this->add_render_attribute('ddmoc', 'class', 'wp-active-we-dropdown-menu-one-column');
        if (!empty($open_with_click)) {
            $this->add_render_attribute('ddmoc', 'class', 'open-with-click');
            $this->add_render_attribute('ddmoc', 'data-handler', ".menu-opener");
            $this->add_render_attribute('ddmoc', 'data-target', ".wp-active-we-ddmoc");
        }

        ?>
        <div <?php $this->print_render_attribute_string('ddmoc'); ?>>
            <?php $this->menu_opener($settings); ?>
            <?php $this->dropdown($settings); ?>
        </div>
        <?php
    }

    private function menu_opener($settings)
    {
        ?>
        <div class="menu-opener dfx aic jcsb">
            <div class="menu-opener-title-wrapper dfx aic">
                <?php AE_E_UTILS::ICON_PRINT($this, $settings, 'menu-icon', 'menu-icon'); ?>
                <?php AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'title', 'span', 'menu-title'); ?>
            </div>
            <span class="menu-status-icon">
                <?php AE_E_UTILS::ICON_PRINT($this, $settings, 'opener-icon', 'opener-icon'); ?>
                <?php AE_E_UTILS::ICON_PRINT($this, $settings, 'closer-icon', 'closer-icon'); ?>
            </span>
        </div>
        <?php
    }

    private function dropdown($settings)
    {

        $menu = $settings['selected-menu'];
        $menu_args = [
            'menu'       => $menu,
            'menu_class' => 'wp-active-we-ddmoc',
            'container'  => 'ul',
        ];

        wp_nav_menu($menu_args);

    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_DropdownMenuOneColumn());
