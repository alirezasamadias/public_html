<?php

namespace Elementor;

defined('ABSPATH') || die();

require_once AE_E_PATH . 'includes/WP_ACTIVE_WE_SimpleMenuWalker.php';
use AE_E_UTILS;
use AE_E_FUNCTIONS;
use WP_ACTIVE_WE_SimpleMenuWalker;

class WP_ACTIVE_WE_VerticalMenu extends Widget_Base
{

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-vertical-menu', AE_E_CSS_DIR . 'vertical-menu.css');
        return ['wp-active-we-vertical-menu'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return  'منو عمودی';
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

        $styles = [
            'simple' => 'ساده',
            'dot'    => 'نقطه',
            'circle' => 'دایره',
            'line-v' => 'خط عمودی',
            'line-h' => 'خط افقی',
        ];
        AE_E_UTILS::SELECT_FIELD($this, 'selected-style', 'استایل', $styles, array_key_first($styles));

        $this->add_control(
            'menu-columns',
            [
                'label'       => 'تعداد ستون',
                'type'        => Controls_Manager::NUMBER,
                'label_block' => false,
                'min'         => 1,
                'max'         => 10,
                'step'        => 1,
                'default'     => 1,
                'selectors'   => [
                    '{{WRAPPER}} .wp-active-we-vertical-menu' => 'grid-template-columns: repeat({{VALUE}}, 1fr)'
                ]
            ]
        );

        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'grid-gap-row', 'فاصله عمودی', 0, 30, null, '.wp-active-we-vertical-menu', 'row-gap');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'grid-gap-column', 'فاصله افقی', 0, 100, null, '.wp-active-we-vertical-menu', 'column-gap');

        $this->end_controls_section();


        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {

        // text
        AE_E_UTILS::SECTION_START($this, 'text-style', 'متن', 'style');
        AE_E_UTILS::TextUtils($this, 'wp-active-we-vertical-menu-text', '.wp-active-we-vertical-menu a', true);
        AE_E_UTILS::SECTION_END($this);

        // before
        AE_E_UTILS::SECTION_START($this, 'before-style', 'تزئین', 'style', 'selected-style!', 'simple');

        $this->add_control(
            'before-color-normal',
            [
                'label'       => 'رنگ اولیه',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .wp-active-we-vertical-menu:not(.circle) a:before' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .wp-active-we-vertical-menu.circle a:before'       => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .wp-active-we-vertical-menu.dot a:before'          => 'box-shadow: 0 0 7px {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'before-color-hover',
            [
                'label'       => 'رنگ ثانویه',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .wp-active-we-vertical-menu:not(.circle) a:hover:before' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .wp-active-we-vertical-menu.circle a:hover:before'       => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .wp-active-we-vertical-menu.dot a:hover:before'          => 'box-shadow: 0 0 7px {{VALUE}};',
                ]
            ]
        );

        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {

        $settings  = $this->get_settings_for_display();
        $style     = $settings['selected-style'];
        $menu      = $settings['selected-menu'];
        $menu_args = [
            'menu'       => $menu,
            'menu_class' => 'wp-active-we-vertical-menu d-grid ' . $style,
            'menu_id'    => 'wp-active-we-vertical-menu',
            'container'  => 'ul',
            'walker'     => new WP_ACTIVE_WE_SimpleMenuWalker()
        ];

        wp_nav_menu($menu_args);

    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_VerticalMenu());
