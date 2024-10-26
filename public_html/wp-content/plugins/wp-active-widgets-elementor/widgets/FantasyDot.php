<?php
namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_FantasyDot extends Widget_Base {

    public function get_style_depends()
    {
        wp_register_style('AE_E_Fantasy_Dot', AE_E_CSS_DIR . 'fantasy-dot.css');
        return ['AE_E_Fantasy_Dot'];
    }

    public function get_name() {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title() {
        return 'نقاط فانتزی';
    }

    public function get_icon() {
        return 'wp-active-we-widget eicon-t-letter';
    }

    public function get_categories() {
        return [ AE_E_PLUGIN_NAME ];
    }

    protected function register_controls() {
        $this->start_controls_section( 'settings', [ 'label' => 'تنظیمات' ] );

        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'width', 'عرض', 10, 300, 50, '.fantasy-dot', 'width');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'height', 'ارتفاع', 10, 300, 50, '.fantasy-dot', 'height');
//        $this->add_control(
//            'bw-distance',
//            [
//                'label'       => 'فاصله بین',
//                'type'        => Controls_Manager::SLIDER,
//                'label_block' => true,
//                'size_units'  => ['px'],
//                'range'       => [
//                    'px' => [
//                        'min' => 4,
//                        'max' => 30,
//                    ],
//                ],
//                'selectors'   => [
//                    '{{WRAPPER}} .fantasy-dot' => 'border-radius: {{VALUE}}px;',
//                ],
//            ]
//        );
        $this->add_control(
            'fantasy-color',
            [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .fantasy-dot' => 'background-image: radial-gradient({{VALUE}} 0px, transparent 2px);',
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        echo '<span class="fantasy-dot"></span>';
    }
}

Plugin::instance()->widgets_manager->register( new WP_ACTIVE_WE_FantasyDot() );
