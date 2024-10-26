<?php

namespace Elementor;

use RP_Utils;

defined('ABSPATH') || die();

class NaderSearchOpener extends Widget_Base{

    public function get_name()
    {
        return 'NaderSearchOpener';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : جستجو';
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

        RP_Utils::SLIDER_FIELD_PIX_STYLE($this, 'btn-height', 'ارتفاع', 20, 100, null, '.search-opener', 'height');
        RP_Utils::SLIDER_FIELD_PIX_STYLE($this, 'btn-width', 'عرض', 20, 100, null, '.search-opener', 'width');
        $this->add_control('icon-size', [
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
                    '{{WRAPPER}} .search-opener svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
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
                    '{{WRAPPER}} .search-opener svg' => 'fill: {{VALUE}};',
                ]
            ]);
        RP_Utils::DynamicStyleControls($this, 'btn-normal', '.search-opener', $controls);
        RP_Utils::TAB_MIDDLE($this, 'hover-state');
        $this->add_control('icon-color-hover', [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .search-opener:hover svg' => 'fill: {{VALUE}};',
                ]
            ]);
        RP_Utils::DynamicStyleControls($this, 'btn-hover', '.search-opener:hover', $controls);
        RP_Utils::TAB_END($this);


        $this->end_controls_section();

    }

    protected function render()
    {
        ?>
        <span class="search-opener dfx aic jcc" role="button" title="<?php _e('search', 'nader'); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path opacity=".4" d="M11.01 20.02a9.01 9.01 0 1 0 0-18.02 9.01 9.01 0 0 0 0 18.02Z"></path>
                <path d="M21.99 18.95c-.33-.61-1.03-.95-1.97-.95-.71 0-1.32.29-1.68.79-.36.5-.44 1.17-.22 1.84.43 1.3 1.18 1.59 1.59 1.64.06.01.12.01.19.01.44 0 1.12-.19 1.78-1.18.53-.77.63-1.54.31-2.15Z"></path>
            </svg>
		</span>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new NaderSearchOpener());
