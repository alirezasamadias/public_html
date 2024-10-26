<?php

namespace Elementor;

use RP_Utils;

defined('ABSPATH') || die();

class NaderServiceBox extends Widget_Base
{

    public function get_name()
    {
        return 'NaderServiceBox';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : باکس خدمات';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-table-of-contents';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        RP_Utils::TXT_FIELD($this, 'title', 'عنوان', 'باکس خدمات', true);
        RP_Utils::ICON($this, 'service-box-icon');

        $this->add_responsive_control('icon-alignment', [
            'label' => 'تراز آیکون',
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'flex-end' => [
                    'title' => 'پایان',
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => 'وسط',
                    'icon' => 'eicon-text-align-center',
                ],
                'flex-start' => [
                    'title' => 'آغاز',
                    'icon' => 'eicon-text-align-right',
                ],
            ],
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .nader-service-box .icon' => 'justify-content: {{VALUE}}'
            ],
        ]);

        RP_Utils::TEXTAREA($this, 'description', 'توضیح', '', true);

        RP_Utils::TXT_FIELD($this,
            'link_title',
            'عنوان لینک',
            'بیشتر...',
            true
        );
        RP_Utils::URL_FIELD($this, 'link', 'لینک', true);

        RP_Utils::TEXT_ALIGNMENT($this,
            'text-alignment',
            '.nader-service-box'
        );

        $this->end_controls_section();


        // box styles
        $this->start_controls_section('box-styles', [
            'label' => 'استایل باکس',
            'tab' => Controls_Manager::TAB_STYLE
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
                'type' => 'tab-middle',
                'title' => 'هاور'
            ],
            [
                'type' => 'box-styles',
                'uniq' => 'hover',
                'target' => '.nader-service-box:hover'
            ],
            [
                'type' => 'tab-end'
            ]
        ];
        RP_Utils::VariantUtils($this,
            'box-styles',
            '.nader-service-box',
            $box_styles
        );
        $this->end_controls_section();


        // icon styles
        $this->start_controls_section('icon-styles', [
            'label' => 'آیکون',
            'tab' => Controls_Manager::TAB_STYLE
        ]);

        $this->add_responsive_control('icon-size', [
            'label' => 'اندازه',
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 32,
            ],
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 20,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .icon i' => 'font-size: {{SIZE}}px;',
                '{{WRAPPER}} .icon svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                '{{WRAPPER}} .icon img' => 'width: {{SIZE}}px;',
            ],
        ]);

        $this->add_control('icon-color-normal', [
            'label' => 'رنگ عادی',
            'label_block' => false,
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .nader-service-box .icon i' => 'color: {{VALUE}};',
                '{{WRAPPER}} .nader-service-box .icon svg' => 'fill: {{VALUE}};',
            ],
            'condition' => [
                'service-box-iconicon_type!' => 'image'
            ]
        ]);
        $this->add_control('icon-color-hover', [
            'label' => 'رنگ هاور',
            'label_block' => false,
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .nader-service-box:hover .icon i' => 'color: {{VALUE}};',
                '{{WRAPPER}} .nader-service-box:hover .icon svg' => 'fill: {{VALUE}};',
            ],
            'condition' => [
                'service-box-iconicon_type!' => 'image'
            ]
        ]);

        RP_Utils::SLIDER_FIELD_PERCENT_STYLE($this,
            'icon-before-first-width',
            'عرض اولیه بکگراند باکس',
            0,
            100,
            50,
            '.nader-service-box .icon::before',
            'width'
        );

        $icon_box_style = [
            [
                'type' => 'slider',
                'title' => 'عرض اصلی باکس',
                'min' => 40,
                'max' => 100,
                'def' => 60,
                'css' => 'width',
                'uniq' => 'main-icon-box-width',
                'target' => '.nader-service-box .icon'
            ],
            [
                'type' => 'slider',
                'title' => 'ارتفاع',
                'min' => 40,
                'max' => 100,
                'def' => 60,
                'css' => 'height',
                'target' => '.nader-service-box .icon'
            ],
            [
                'type' => 'slider',
                'title' => 'فاصله از بالا',
                'min' => -100,
                'max' => 100,
                'def' => 0,
                'css' => 'margin-top',
                'target' => '.nader-service-box .icon'
            ],
            [
                'type' => 'slider',
                'title' => 'فاصله از پایین',
                'min' => 0,
                'max' => 100,
                'def' => 15,
                'css' => 'margin-bottom',
                'target' => '.nader-service-box .icon'
            ],
            [
                'type' => 'tab-start'
            ],
            [
                'type' => 'bg-c',
            ],
            [
                'type' => '4dir',
                'title' => 'خمیدگی',
                'css' => 'border-radius',
            ],
            [
                'type' => 'shadow',
                'uniq' => 'normal',
                'title' => 'سایه'
            ],
            [
                'type' => 'tab-middle',
                'title' => 'حالت هاور',
            ],
            [
                'type' => 'bg-c',
                'uniq' => 'hover',
                'target' => '.nader-service-box:hover .icon::before'
            ],
            [
                'type' => '4dir',
                'uniq' => 'hover',
                'title' => 'خمیدگی',
                'css' => 'border-radius',
                'target' => '.nader-service-box:hover .icon::before'
            ],
            [
                'type' => 'shadow',
                'uniq' => 'hover',
                'title' => 'سایه',
                'target' => '.nader-service-box:hover .icon::before'
            ],
            [
                'type' => 'tab-end',
            ],
            [
                'type' => 'sep',
                'title' => 'تغییر مکان'
            ],
        ];
        RP_Utils::VariantUtils($this,
            'icon-box-style',
            '.nader-service-box .icon::before',
            $icon_box_style
        );

        $this->add_responsive_control('icon-translate-x-normal', [
            'label' => 'X Normal',
            'type' => Controls_Manager::SLIDER,
            'label_block' => true,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => -100,
                    'max' => 100,
                ],
            ],
            'default' => [
                'size' => 0
            ],
            'render_type' => 'ui'

        ]);
        $this->add_responsive_control('icon-translate-x-hover', [
            'label' => 'X Hover',
            'type' => Controls_Manager::SLIDER,
            'label_block' => true,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => -100,
                    'max' => 100,
                ],
            ],
            'default' => [
                'size' => 0
            ],
            'render_type' => 'ui'
        ]);

        $this->add_responsive_control('icon-translate-y-normal', [
            'label' => 'Y Normal',
            'type' => Controls_Manager::SLIDER,
            'label_block' => true,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => -100,
                    'max' => 100,
                ],
            ],
            'default' => [
                'size' => 0
            ],
            'selectors' => [
                '{{WRAPPER}} .nader-service-box .icon' => 'transform: translate( {{icon-translate-x-normal.SIZE}}px ,{{SIZE}}px);',
            ],
        ]);
        $this->add_responsive_control('icon-translate-y-hover', [
            'label' => 'Y Hover',
            'type' => Controls_Manager::SLIDER,
            'label_block' => true,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => -100,
                    'max' => 100,
                ],
            ],
            'default' => [
                'size' => 0
            ],
            'selectors' => [
                '{{WRAPPER}} .nader-service-box:hover .icon' => 'transform: translate({{icon-translate-x-hover.SIZE}}px,{{SIZE}}px);',
            ],
        ]);

        $this->end_controls_section();


        // texts style
        $this->start_controls_section('texts-style', [
            'label' => 'متن',
            'tab' => Controls_Manager::TAB_STYLE
        ]);
        $texts_style = [
            [
                'type' => 'sep',
                'title' => 'عنوان'
            ],
            [
                'type' => 'text-small',
            ],
            [
                'type' => 'color',
                'title' => 'رنگ هاور',
                'uniq' => 'title-color-hover',
                'target' => '.nader-service-box:hover .service-title'
            ],
            [
                'type' => 'slider',
                'title' => 'فاصله',
                'min' => 0,
                'max' => 100,
                'def' => 20,
                'css' => 'margin-bottom',
            ],
            [
                'type' => 'sep',
                'title' => 'توضیح',
                'uniq' => 'desc'
            ],
            [
                'type' => 'text-small',
                'target' => '.nader-service-box p',
                'uniq' => 'desc'
            ],
            [
                'type' => 'slider',
                'title' => 'فاصله پایین',
                'min' => 0,
                'max' => 100,
                'def' => 30,
                'uniq' => 'desc',
                'css' => 'margin-bottom',
                'target' => '.nader-service-box p'
            ],
        ];
        RP_Utils::VariantUtils($this,
            'texts-style',
            '.nader-service-box .service-title',
            $texts_style
        );
        $this->end_controls_section();


        // button style
        $this->start_controls_section('button-style', [
            'label' => 'دکمه',
            'tab' => Controls_Manager::TAB_STYLE
        ]);

        $button_style = [
            [
                'type' => 'font',
                'title' => 'تایپوگرافی'
            ],
            [
                'type' => 'slider',
                'title' => 'عرض',
                'min' => 40,
                'max' => 140,
                'def' => 40,
                'css' => 'width',
                'target' => '.btn-style2:before'
            ],
            [
                'type' => '4dir',
                'css' => 'padding',
                'title' => 'فاصله داخلی'
            ],
            [
                'type' => 'color',
                'title' => 'رنگ'
            ],
            [
                'type' => 'bg',
                'target' => '.btn-style2:before'
            ],
            [
                'type' => '4dir',
                'css' => 'border-radius',
                'title' => 'خمیدگی',
                'target' => '.btn-style2:before'
            ]
        ];
        RP_Utils::VariantUtils($this,
            'button-style',
            '.btn-style2',
            $button_style
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $title = $settings['title'];
        $description = $settings['description'];
        $link_title = $settings['link_title'];


        if (!empty($settings['link']['url'])) {
            $this->add_link_attributes('service-btn', $settings['link']);
            $this->add_render_attribute('service-btn', 'role', 'button');
            $this->add_render_attribute('service-btn', 'class', 'btn-style2');
            $this->add_render_attribute('service-btn', 'class', 'jcc');
        }

        ?>

        <div class="nader-service-box-wrapper">
            <div class="nader-service-box dfx dir-v jcc aic">

                <?php RP_Utils::ICON_PRINT($this, $settings, 'service-box-icon'); ?>

                <?php
                if (!empty($title)) { ?>
                    <h3 class="service-title"><?php echo esc_html($title); ?></h3>
                <?php }

                if (!empty($description)) { ?>
                    <p><?php echo esc_html($description); ?></p>
                <?php }

                if (!empty($link_title)) { ?>
                    <a <?php $this->print_render_attribute_string('service-btn'
                    ); ?>><?php echo esc_html($link_title); ?></a>
                <?php }

                ?>
            </div>
        </div>

        <?php
    }

}

Plugin::instance()->widgets_manager->register(new NaderServiceBox());
