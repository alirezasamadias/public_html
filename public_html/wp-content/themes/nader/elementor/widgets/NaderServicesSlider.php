<?php

namespace Elementor;

use RealPressHelper;
use RP_Utils;
use OwlCarousel;

defined('ABSPATH') || die();

class NaderServicesSlider extends Widget_Base{

    use OwlCarousel;

    public function get_script_depends()
    {
        wp_register_script('nader-owl-carousel', NADER_JS_DIR . 'owl.carousel.min.js', ['jquery'], 1, true);
        wp_register_script('nader-services-slider-widget', NADER_ELEMENTOR_JS_DIR . 'nader-services-slider.js', [
            'jquery',
            'nader-owl-carousel'
        ], '1.0.0', true);

        return ['jquery', 'nader-owl-carousel', 'nader-services-slider-widget'];
    }

    public function get_style_depends()
    {
        wp_register_style('nader-owl-css', NADER_CSS_DIR . 'owl.carousel.min.css');
        return ['nader-owl-css'];
    }

    public function get_name()
    {
        return 'NaderServicesSlider';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : اسلایدر خدمات';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-slider-push';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        $service_box_slider = new \Elementor\Repeater();

        RP_Utils::TXT_FIELD($service_box_slider, 'title', 'عنوان', 'باکس خدمات', true);
        RP_Utils::ICON($service_box_slider, 'service-box-');


        RP_Utils::TEXTAREA($service_box_slider, 'description', 'توضیح', '', true);

        RP_Utils::TXT_FIELD($service_box_slider, 'link_title', 'عنوان لینک', 'بیشتر...', true);
        RP_Utils::URL_FIELD($service_box_slider, 'link', 'لینک', true);

        $this->add_control('services', [
            'label'       => 'خدمات',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $service_box_slider->get_controls(),
            'title_field' => '{{{ title }}}'
        ]);


        $this->add_responsive_control(
            'icon-alignment',
            [
                'label' => 'چیدمان آیکون',
                'type' => Controls_Manager::SELECT,
                'label_block' => false,
                'options' => [
                    'flex-start' => 'آغاز',
                    'center' => 'وسط',
                    'flex-end' => 'پایان',
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .service-box-slider-icon-box' => 'justify-content: {{VALUE}}'
                ]
            ]
        );
        RP_Utils::TEXT_ALIGNMENT($this, 'text-alignment', '.nader-service-box');

        $this->end_controls_section();


        // slider settings
        $this->OwlSettings();


        // box styles
        $this->start_controls_section('box-styles', [
            'label' => 'استایل باکس',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);
        $box_styles = [
            [
                'type' => 'tab-start'
            ],
            [
                'type' => 'box-styles',
                'uniq' => 'normal'
            ],
            [
                'type'  => 'tab-middle',
                'title' => 'هاور'
            ],
            [
                'type'   => 'box-styles',
                'uniq'   => 'hover',
                'target' => '.nader-service-box:hover'
            ],
            [
                'type' => 'tab-end'
            ]
        ];
        RP_Utils::VariantUtils($this, 'box-styles', '.nader-service-box', $box_styles);
        $this->end_controls_section();


        // icon styles
        $this->start_controls_section('icon-styles', [
            'label' => 'آیکون',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);

        $this->add_responsive_control('icon-size', [
            'label'      => 'اندازه عادی',
            'type'       => Controls_Manager::SLIDER,
            'default'    => [
                'size' => 32,
            ],
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min' => 20,
                    'max' => 100,
                ],
            ],
            'selectors'  => [
                '{{WRAPPER}} .nader-service-box-wrapper .icon i'   => 'font-size: {{SIZE}}px;',
                '{{WRAPPER}} .nader-service-box-wrapper .icon svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                '{{WRAPPER}} .nader-service-box-wrapper .icon img' => 'width: {{SIZE}}px;',
            ],
        ]);
        $this->add_responsive_control('icon-size-hover', [
            'label'      => 'اندازه هاور',
            'type'       => Controls_Manager::SLIDER,
            'default'    => [
                'size' => 32,
            ],
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min' => 20,
                    'max' => 100,
                ],
            ],
            'selectors'  => [
                '{{WRAPPER}} .nader-service-box-wrapper:hover .icon i'   => 'font-size: {{SIZE}}px;',
                '{{WRAPPER}} .nader-service-box-wrapper:hover .icon svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                '{{WRAPPER}} .nader-service-box-wrapper:hover .icon img' => 'width: {{SIZE}}px;',
            ],
        ]);


        $this->add_control('icon-color-normal', [
            'label'       => 'رنگ عادی',
            'label_block' => false,
            'type'        => \Elementor\Controls_Manager::COLOR,
            'selectors'   => [
                '{{WRAPPER}} .nader-service-box .icon i'   => 'color: {{VALUE}};',
                '{{WRAPPER}} .nader-service-box .icon svg' => 'fill: {{VALUE}};',
            ]
        ]);
        $this->add_control('icon-color-hover', [
            'label'       => 'رنگ هاور',
            'label_block' => false,
            'type'        => \Elementor\Controls_Manager::COLOR,
            'selectors'   => [
                '{{WRAPPER}} .nader-service-box:hover .icon i'   => 'color: {{VALUE}};',
                '{{WRAPPER}} .nader-service-box:hover .icon svg' => 'fill: {{VALUE}};',
            ]
        ]);

        RP_Utils::SLIDER_FIELD_PERCENT_STYLE($this, 'icon-before-first-width', 'عرض اولیه بکگراند باکس', 0, 100, 50, '.nader-service-box .icon::before', 'width');

        $icon_box_style = [
            [
                'type'   => 'slider',
                'title'  => 'فاصله',
                'min'    => 0,
                'max'    => 100,
                'def'    => 15,
                'css'    => 'margin-bottom',
                'target' => '.nader-service-box .icon'
            ],
            [
                'type'   => 'slider',
                'title'  => 'عرض اصلی باکس',
                'min'    => 40,
                'max'    => 100,
                'def'    => 60,
                'css'    => 'width',
                'target' => '.nader-service-box .icon'
            ],
            [
                'type'   => 'slider',
                'title'  => 'ارتفاع',
                'min'    => 40,
                'max'    => 100,
                'def'    => 60,
                'css'    => 'height',
                'target' => '.nader-service-box .icon'
            ],
            [
                'type' => 'tab-start'
            ],
            [
                'type' => 'bg-c',
            ],
            [
                'type'  => '4dir',
                'title' => 'خمیدگی',
                'css'   => 'border-radius',
            ],
            [
                'type'  => 'shadow',
                'uniq'  => 'normal',
                'title' => 'سایه'
            ],
            [
                'type'  => 'tab-middle',
                'title' => 'حالت هاور',
            ],
            [
                'type'   => 'bg-c',
                'uniq'   => 'hover',
                'target' => '.nader-service-box:hover .icon::before'
            ],
            [
                'type'   => '4dir',
                'uniq'   => 'hover',
                'title'  => 'خمیدگی',
                'css'    => 'border-radius',
                'target' => '.nader-service-box:hover .icon::before'
            ],
            [
                'type'   => 'shadow',
                'uniq'   => 'hover',
                'title'  => 'سایه',
                'target' => '.nader-service-box:hover .icon::before'
            ],
            [
                'type' => 'tab-end',
            ],
            [
                'type'  => 'sep',
                'title' => 'تغییر مکان'
            ],
        ];
        RP_Utils::VariantUtils($this, 'icon-box-style', '.nader-service-box .icon::before', $icon_box_style);

        $this->add_responsive_control('icon-translate-x-normal', [
            'label'       => 'X Normal',
            'type'        => Controls_Manager::SLIDER,
            'label_block' => true,
            'size_units'  => ['px'],
            'range'       => [
                'px' => [
                    'min' => -100,
                    'max' => 100,
                ],
            ],
            'default'     => [
                'size' => 0
            ],
            'render_type' => 'ui'

        ]);
        $this->add_responsive_control('icon-translate-x-hover', [
            'label'       => 'X Hover',
            'type'        => Controls_Manager::SLIDER,
            'label_block' => true,
            'size_units'  => ['px'],
            'range'       => [
                'px' => [
                    'min' => -100,
                    'max' => 100,
                ],
            ],
            'default'     => [
                'size' => 0
            ],
            'render_type' => 'ui'
        ]);

        $this->add_responsive_control('icon-translate-y-normal', [
            'label'       => 'Y Normal',
            'type'        => Controls_Manager::SLIDER,
            'label_block' => true,
            'size_units'  => ['px'],
            'range'       => [
                'px' => [
                    'min' => -100,
                    'max' => 100,
                ],
            ],
            'default'     => [
                'size' => 0
            ],
            'selectors'   => [
                '{{WRAPPER}} .nader-service-box .icon' => 'transform: translate( {{icon-translate-x-normal.SIZE}}px ,{{SIZE}}px);',
            ],
        ]);
        $this->add_responsive_control('icon-translate-y-hover', [
            'label'       => 'Y Hover',
            'type'        => Controls_Manager::SLIDER,
            'label_block' => true,
            'size_units'  => ['px'],
            'range'       => [
                'px' => [
                    'min' => -100,
                    'max' => 100,
                ],
            ],
            'default'     => [
                'size' => 0
            ],
            'selectors'   => [
                '{{WRAPPER}} .nader-service-box:hover .icon' => 'transform: translate({{icon-translate-x-hover.SIZE}}px,{{SIZE}}px);',
            ],
        ]);

        $this->end_controls_section();


        // texts style
        $this->start_controls_section('texts-style', [
            'label' => 'متن',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);
        $texts_style = [
            [
                'type'  => 'sep',
                'title' => 'عنوان'
            ],
            [
                'type' => 'text-small',
            ],
            [
                'type'   => 'color',
                'title'  => 'رنگ هاور',
                'uniq'   => 'title-color-hover',
                'target' => '.nader-service-box:hover .service-title'
            ],
            [
                'type'  => 'slider',
                'title' => 'فاصله',
                'min'   => 0,
                'max'   => 100,
                'def'   => 20,
                'css'   => 'margin-bottom',
            ],
            [
                'type'  => 'sep',
                'title' => 'توضیح',
                'uniq'  => 'desc'
            ],
            [
                'type'   => 'text-small',
                'target' => '.nader-service-box p',
                'uniq'   => 'desc'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله',
                'min'    => 0,
                'max'    => 100,
                'def'    => 30,
                'uniq'   => 'desc',
                'css'    => 'margin-bottom',
                'target' => '.nader-service-box p'
            ],
        ];
        RP_Utils::VariantUtils($this, 'texts-style', '.nader-service-box .service-title', $texts_style);
        $this->end_controls_section();


        // button style
        $this->start_controls_section('button-style', [
            'label' => 'دکمه',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);
        $button_style = [
            [
                'type'  => 'font',
                'title' => 'تایپوگرافی'
            ],
            [
                'type'   => 'slider',
                'title'  => 'عرض',
                'min'    => 40,
                'max'    => 140,
                'def'    => 40,
                'css'    => 'width',
                'target' => '.btn-style2:before'
            ],
            [
                'type'  => '4dir',
                'css'   => 'padding',
                'title' => 'فاصله داخلی'
            ],
            [
                'type'  => 'color',
                'title' => 'رنگ'
            ],
            [
                'type'   => 'bg',
                'target' => '.btn-style2:before'
            ],
            [
                'type'   => '4dir',
                'css'    => 'border-radius',
                'title'  => 'خمیدگی',
                'target' => '.btn-style2:before'
            ]
        ];
        RP_Utils::VariantUtils($this, 'button-style', '.btn-style2', $button_style);
        $this->end_controls_section();


        $this->OwlStylesNextPrevBtn();

        $this->OwlStylesDotSettings();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $slider_settings = $this->RenderOwlSettings();
        $services = $settings['services'];

        $this->add_render_attribute('nader-service-slider-attrs', 'class', 'nader-services-slider');
        $this->add_render_attribute('nader-service-slider-attrs', 'class', 'owl-carousel');
        $this->add_render_attribute('nader-service-slider-attrs', 'data-slider-settings', json_encode($slider_settings));

        if (!empty($services)) {
            ?>

            <div <?php $this->print_render_attribute_string('nader-service-slider-attrs'); ?>>

                <?php

                $i = 1;

                foreach ($services as $service) {
                    $title = $service['title'];
                    $description = $service['description'];
                    $link_title = $service['link_title'];

                    if (!empty($service['link']['url'])) {
                        $this->add_link_attributes('service-btn' . $i, $service['link']);
                        $this->add_render_attribute('service-btn' . $i, 'role', 'button');
                        $this->add_render_attribute('service-btn' . $i, 'class', ['btn-style2', 'jcc']);
                    }

                    ?>

                    <div class="nader-service-box-wrapper">
                        <div class="nader-service-box">

                            <div class="service-box-slider-icon-box dfx jcc">
                                <?php RP_Utils::ICON_PRINT($this, $service, 'service-box-'); ?>
                            </div>

                            <?php if (!empty($title)) { ?>
                                <h3 class="service-title"><?php echo esc_html($title); ?></h3>
                            <?php }

                            if (!empty($description)) { ?>
                                <p><?php echo esc_html($description); ?></p>
                            <?php }

                            if (!empty($link_title)) { ?>
                                <a <?php $this->print_render_attribute_string('service-btn' . $i); ?>><?php echo esc_html($link_title); ?></a>
                            <?php }

                            ?>
                        </div>
                    </div>
                    <?php
                    $i++;
                }
                ?>

            </div>

            <?php
        }
    }

}

Plugin::instance()->widgets_manager->register(new NaderServicesSlider());
