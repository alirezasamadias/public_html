<?php

namespace Elementor;

defined('ABSPATH') || die();

use RP_Utils;


class NaderInfoBox extends Widget_Base
{

    public function get_name()
    {
        return 'NaderInfoBox';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : باکس اطلاعات';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-icon-box';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        RP_Utils::TXT_FIELD($this, 'title', 'عنوان', 'اطلاعات', true);

        RP_Utils::ICON($this, 'info-box-');

        RP_Utils::TXT_FIELD($this, 'text1', 'متن 1', 'لورم ایپسوم', true);
        RP_Utils::TEXTAREA($this, 'text2', 'متن 2', 'متنی ساختگی است', true);

        $this->end_controls_section();


        $this->start_controls_section('box-styles', [
            'label' => 'باکس',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);

        $box_style = [
            [
                'type' => 'tab-start'
            ],
            [
                'type' => 'box-styles'
            ],
            [
                'type'  => 'tab-middle',
                'title' => 'حالت هاور'
            ],
            [
                'type'   => 'box-styles',
                'uniq'   => 'hover',
                'target' => '.nader-info-box:hover'
            ],
            [
                'type' => 'tab-end'
            ],
        ];
        RP_Utils::VariantUtils($this, 'box-style', '.nader-info-box', $box_style);

        $this->end_controls_section();


        // icon styles
        $this->start_controls_section('icon-styles', [
            'label' => 'آیکون',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);

        $this->add_responsive_control(
            'icon-size',
            [
                'label'      => 'اندازه',
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 32,
                ],
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 20,
                        'max' => 150,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .icon i'   => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} .icon svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                    '{{WRAPPER}} .icon img' => 'width: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_control(
            'icon-color-normal',
            [
                'label'       => 'رنگ عادی',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .nader-info-box .icon i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .nader-info-box .icon svg' => 'fill: {{VALUE}};',
                ],
                'condition'   => [
                    'info-box-icon_type!' => 'image'
                ]
            ]
        );
        $this->add_control(
            'icon-color-hover',
            [
                'label'       => 'رنگ هاور',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .nader-info-box:hover .icon i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .nader-info-box:hover .icon svg' => 'fill: {{VALUE}};',
                ],
                'condition'   => [
                    'info-box-icon_type!' => 'image'
                ]
            ]
        );

        RP_Utils::SLIDER_FIELD_PERCENT_STYLE($this,
            'icon-before-first-width',
            'عرض اولیه بکگراند باکس',
            0,
            100,
            50,
            '.nader-info-box .icon::before',
            'width'
        );

        $icon_box_style = [
            [
                'type'   => 'slider',
                'title'  => 'عرض اصلی باکس',
                'min'    => 42,
                'max'    => 150,
                'def'    => 50,
                'css'    => 'width',
                'target' => '.nader-info-box .icon'
            ],
            [
                'type'   => 'slider',
                'title'  => 'ارتفاع',
                'min'    => 42,
                'max'    => 150,
                'def'    => 50,
                'css'    => 'height',
                'target' => '.nader-info-box .icon'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله از بالا',
                'min'    => -100,
                'max'    => 100,
                'def'    => 0,
                'css'    => 'margin-top',
                'target' => '.nader-info-box .icon'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله از پایین',
                'min'    => 0,
                'max'    => 100,
                'def'    => 15,
                'css'    => 'margin-bottom',
                'target' => '.nader-info-box .icon'
            ],
            [
                'type' => 'tab-start'
            ],
            [
                'type'   => 'bg-c',
                'target' => '.nader-info-box .icon::before'
            ],
            [
                'type'   => '4dir',
                'title'  => 'خمیدگی',
                'css'    => 'border-radius',
                'target' => '.nader-info-box .icon::before'
            ],
            [
                'type'   => 'shadow',
                'title'  => 'سایه',
                'target' => '.nader-info-box .icon::before'
            ],
            [
                'type'  => 'tab-middle',
                'title' => 'حالت هاور',
            ],
            [
                'type'   => 'bg-c',
                'uniq'   => 'hover',
                'target' => '.nader-info-box:hover .icon::before'
            ],
            [
                'type'   => '4dir',
                'title'  => 'خمیدگی',
                'css'    => 'border-radius',
                'uniq'   => 'hover',
                'target' => '.nader-info-box:hover .icon::before'
            ],
            [
                'type'   => 'shadow',
                'uniq'   => 'hover',
                'target' => '.nader-info-box:hover .icon::before',
                'title'  => 'سایه'
            ],
            [
                'type' => 'tab-end',
            ],
            [
                'type'  => 'sep',
                'title' => 'تغییر مکان'
            ],
        ];
        RP_Utils::VariantUtils($this, 'icon-box-style', '.nader-info-box .icon', $icon_box_style);

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
                '{{WRAPPER}} .nader-info-box .icon' => 'transform: translate( {{icon-translate-x-normal.SIZE}}px ,{{SIZE}}px);',
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
                '{{WRAPPER}} .nader-info-box:hover .icon' => 'transform: translate({{icon-translate-x-hover.SIZE}}px,{{SIZE}}px);',
            ],
        ]);

        $this->end_controls_section();


        // text styles
        $this->start_controls_section('text-styles', [
            'label' => 'متن',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);

        $text_styles = [
            [
                'type'  => 'sep',
                'uniq'  => 'info-box-title',
                'title' => 'عنوان'
            ],
            [
                'type'   => 'text-small',
                'target' => '.nader-info-box .title',
                'uniq'   => 'info-box-title'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله از پایین',
                'min'    => 0,
                'max'    => 100,
                'def'    => 0,
                'css'    => 'margin-bottom',
                'uniq'   => 'info-box-title',
                'target' => '.nader-info-box .title',
            ],
            [
                'type'  => 'sep',
                'uniq'  => 'info-box-text1',
                'title' => 'متن 1'
            ],
            [
                'type'   => 'text-small',
                'target' => '.nader-info-box .text1',
                'uniq'   => 'info-box-text1'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله از پایین',
                'min'    => 0,
                'max'    => 100,
                'def'    => 0,
                'css'    => 'margin-bottom',
                'uniq'   => 'info-box-text1',
                'target' => '.nader-info-box .text1',
            ],
            [
                'type'  => 'sep',
                'uniq'  => 'info-box-text2',
                'title' => 'متن 2'
            ],
            [
                'type'   => 'text-small',
                'target' => '.nader-info-box .text2',
                'uniq'   => 'info-box-text2'
            ]
        ];
        RP_Utils::VariantUtils($this, 'text-styles', '', $text_styles);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $title = $settings['title'];
        $text1 = $settings['text1'];
        $text2 = $settings['text2'];

        ?>

        <div class="nader-info-box-wrapper">
            <div class="nader-info-box dfx dir-v aic jcc">
                <?php

                RP_Utils::ICON_PRINT($this, $settings, 'info-box-');

                if (!empty($title)) { ?>
                    <h3 class="title"><?php echo esc_html($title); ?></h3>
                <?php }

                if (!empty($text1)) { ?>
                    <p class="text1"><?php echo esc_html($text1); ?></p>
                <?php }

                if (!empty($text2)) { ?>
                    <p class="text2"><?php echo esc_html($text2); ?></p>
                <?php } ?>
            </div>
        </div>

        <?php
    }

}

Plugin::instance()->widgets_manager->register(new NaderInfoBox());
