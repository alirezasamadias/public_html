<?php

namespace Elementor;

use RP_Utils;

defined('ABSPATH') || die();

class NaderMiniCartOpener extends Widget_Base{

    public function get_name()
    {
        return 'NaderMiniCartOpener';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : سبد خرید';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-button';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        RP_Utils::Separator($this, 'btn-counter', 'شمارنده');
        RP_Utils::TextUtils($this, 'btn-counter', '.mini-cart-opener .cart-items-counter');
        RP_Utils::BACKGROUND_WO_IMG_FIELD($this, 'btn-counter-bg', '.mini-cart-opener .cart-items-counter');


        RP_Utils::Separator($this, 'btn-self', 'دکمه');
        RP_Utils::SLIDER_FIELD_PIX_STYLE($this, 'btn-height', 'ارتفاع', 20, 100, null, '.mini-cart-opener', 'height');
        RP_Utils::SLIDER_FIELD_PIX_STYLE($this, 'btn-width', 'عرض', 20, 100, null, '.mini-cart-opener', 'width');
        $this->add_control('icon-size', [
                'label'       => 'عرض',
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
                    '{{WRAPPER}} .mini-cart-opener svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
                ],
            ]);

        $controls = [
            'bg',
            'border',
            'border-radius',
            'shadow',
        ];
        RP_Utils::TAB_START($this, 'normal-state');
        $this->add_control('icon-color-normal', [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .mini-cart-opener svg' => 'fill: {{VALUE}};',
                ]
            ]);
        RP_Utils::DynamicStyleControls($this, 'btn-normal', '.mini-cart-opener', $controls);
        RP_Utils::TAB_MIDDLE($this, 'hover-state');
        $this->add_control('icon-color-hover', [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .mini-cart-opener:hover svg' => 'fill: {{VALUE}};',
                ]
            ]);
        RP_Utils::DynamicStyleControls($this, 'btn-hover', '.mini-cart-opener:hover', $controls);
        RP_Utils::TAB_END($this);


        $this->end_controls_section();

    }

    protected function render()
    {
        ?>
        <span class="mini-cart-opener cursor-pointer dfx aic jcc" role="button"
              title="<?php esc_html_e('Cart', 'nader'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path opacity=".4"
                      d="M16.49 22H7.51C4 22 3.24 19.99 3.53 17.53l.9-7.5C4.66 8.09 5 6.5 8.4 6.5h7.2c3.4 0 3.74 1.59 3.97 3.53l.75 6.25.15 1.25.03.24c.21 2.35-.61 4.23-4.01 4.23Z"></path>
                <path d="M16 8.75c-.41 0-.75-.34-.75-.75V4.5c0-1.08-.67-1.75-1.75-1.75h-3c-1.08 0-1.75.67-1.75 1.75V8c0 .41-.34.75-.75.75s-.75-.34-.75-.75V4.5c0-1.91 1.34-3.25 3.25-3.25h3c1.91 0 3.25 1.34 3.25 3.25V8c0 .41-.34.75-.75.75ZM20.5 17.771c-.03.01-.06.01-.09.01H8a.749.749 0 1 1 0-1.5h12.32l.15 1.25.03.24Z"></path>
            </svg>
            <span class="cart-items-counter dfx aic jcc"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        </span>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new NaderMiniCartOpener());
