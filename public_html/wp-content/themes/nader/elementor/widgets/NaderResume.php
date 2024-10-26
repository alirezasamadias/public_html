<?php

namespace Elementor;

use RP_Utils;

defined('ABSPATH') || die();

class NaderResume extends Widget_Base{

    public function get_name()
    {
        return 'NaderResume';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : رزومه';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-toggle';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        RP_Utils::TXT_FIELD($this, 'title', 'عنوان', 'رزومه', true);
        RP_Utils::ICON($this, 'resume-');
        RP_Utils::SELECT_FIELD($this, 'title-place', 'مکان عنوان', ['odd' => 'راست', 'even' => 'چپ'], 'odd');

        $resume = new \Elementor\Repeater();
        RP_Utils::TXT_FIELD($resume, 'title', 'عنوان');
        RP_Utils::TXT_FIELD($resume, 'date', 'تاریخ');
        RP_Utils::TEXTAREA($resume, 'description', 'توضیح');
        $this->add_control('resumes', [
                'label'       => 'رزومه',
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $resume->get_controls(),
                'title_field' => '{{{ title }}} - {{{ date }}}',
            ]);

        $this->end_controls_section();


        // title box
        $this->start_controls_section('title-box-styles', [
            'label' => 'باکس عنوان',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);

        $icon_box_style = [
            [
                'type'  => 'slider',
                'title' => 'عرض',
                'min'   => 80,
                'max'   => 200,
                'def'   => 140,
                'css'   => 'width',
            ],
            [
                'type'  => '4dir',
                'title' => 'فاصله داخلی',
                'css'   => 'padding',
            ],
            [
                'type' => 'bg',
            ],
            [
                'type'  => 'border',
                'title' => 'خط دور'
            ],
            [
                'type'  => '4dir',
                'title' => 'خمیدگی',
                'css'   => 'border-radius',
            ],
            [
                'type'  => 'sep',
                'uniq'  => 'title-text',
                'title' => 'عنوان'
            ],
            [
                'type'   => 'text-small',
                'uniq'   => 'title-text',
                'target' => '.box-title'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله',
                'min'    => 0,
                'max'    => 50,
                'def'    => 10,
                'css'    => 'margin-top',
                'uniq'   => 'title-text',
                'target' => '.box-title'
            ],
            [
                'type'  => 'sep',
                'uniq'  => 'icon',
                'title' => 'آیکون'
            ],
        ];
        RP_Utils::VariantUtils($this, 'icon-box-style', '.nader-resume .icon-box', $icon_box_style);

        $this->add_responsive_control('icon-box-style-icon-size', [
                'label'      => 'اندازه',
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
                    '{{WRAPPER}} .icon i'   => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} .icon svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                    '{{WRAPPER}} .icon img' => 'width: {{SIZE}}px;',
                ],
            ]);
        $this->add_control('icon-box-style-icon-color', [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .icon i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .icon svg' => 'fill: {{VALUE}};',
                ]
            ]);

        $this->end_controls_section();


        // resume item
        $this->start_controls_section('resume-item-styles', [
            'label' => 'آیتم روزمه',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);

        $resume_item_style = [
            [
                'type'  => 'sep',
                'uniq'  => 'bx-style',
                'title' => 'آیتم'
            ],
            [
                'type'  => '4dir',
                'title' => 'فاصله داخلی',
                'css'   => 'padding',
            ],
            [
                'type' => 'bg',
            ],
            [
                'type'  => 'border',
                'title' => 'خط دور'
            ],
            [
                'type'  => '4dir',
                'title' => 'خمیدگی',
                'css'   => 'border-radius',
            ],
        ];
        RP_Utils::VariantUtils($this, 'resume-item-style', '.nader-resume .timeline .timeline-item', $resume_item_style);

        $resume_texts_style = [
            [
                'type'  => 'sep',
                'uniq'  => 'date',
                'title' => 'تاریخ'
            ],
            [
                'type'   => 'text-small',
                'uniq'   => 'date',
                'target' => '.nader-resume .timeline .timeline-item .years-range'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله',
                'min'    => 0,
                'max'    => 50,
                'def'    => 5,
                'css'    => 'margin-bottom',
                'uniq'   => 'date',
                'target' => '.nader-resume .timeline .timeline-item .years-range'
            ],
            [
                'type'  => 'sep',
                'uniq'  => 'title',
                'title' => 'عنوان'
            ],
            [
                'type'   => 'text-small',
                'uniq'   => 'title',
                'target' => '.nader-resume .timeline .timeline-item .title'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله',
                'min'    => 0,
                'max'    => 50,
                'def'    => 15,
                'css'    => 'margin-bottom',
                'uniq'   => 'title',
                'target' => '.nader-resume .timeline .timeline-item .title'
            ],
            [
                'type'  => 'sep',
                'uniq'  => 'description',
                'title' => 'توضیح'
            ],
            [
                'type'   => 'text-small',
                'uniq'   => 'description',
                'target' => '.nader-resume .timeline .timeline-item p'
            ],
        ];
        RP_Utils::VariantUtils($this, 'resume-texts-style', '', $resume_texts_style);

        $this->end_controls_section();


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $title_place = $settings['title-place'];
        $title = $settings['title'];

        $resume_items = $settings['resumes'];

        if (!empty($resume_items)) {
            ?>

            <div class="nader-resume <?php echo $title_place; ?>">
                <div class="icon-box text-center<?php if ($title_place === 'even') {
                    echo ' order-lg-last';
                } ?>">
                    <?php
                    RP_Utils::ICON_PRINT($this, $settings, 'resume-');
                    ?>
                    <h4 class="box-title"><?php echo esc_html($title); ?></h4>
                </div>
                <div class="timeline<?php if ($title_place === 'even') {
                    echo ' order-lg-first';
                } ?>">
                    <div class="timeline-divider"></div>
                    <?php
                    foreach ($resume_items as $resume_item) {
                        ?>
                        <div class="timeline-item">
                            <?php if (!empty($resume_item['date'])) { ?>
                                <div class="years-range"><?php echo esc_html($resume_item['date']); ?></div>
                            <?php } ?>
                            <?php if (!empty($resume_item['title'])) { ?>
                                <h3 class="title"><?php echo esc_html($resume_item['title']); ?></h3>
                            <?php } ?>
                            <?php if (!empty($resume_item['description'])) { ?>
                                <p><?php echo esc_html($resume_item['description']); ?></p>
                            <?php } ?>

                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <?php
        }

    }
}

Plugin::instance()->widgets_manager->register(new NaderResume());
