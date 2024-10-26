<?php

use Elementor\Controls_Manager;

defined('ABSPATH') || die();

trait WP_ACTIVE_WE_OwlCarousel
{

    private function OwlSettings()
    {

        $this->start_controls_section('slider-settings', ['label' => 'تنظیمات اسلایدر']);

        AE_E_UTILS::NUMBER_FIELD($this, 'items', 'تعداد اسلاید برای نمایش', 1, 12, 1, 3);
        AE_E_UTILS::NUMBER_FIELD($this, 'slideBy', 'تعداد اسلاید در هر حرکت', 1, 100, 1, 1);
        AE_E_UTILS::NUMBER_FIELD($this, 'smartSpeed', 'سرعت انتقال', 100, 1000, 10, 300);
        AE_E_UTILS::SWITCH_FIELD($this, 'loop', 'حلقه بی نهایت');
        AE_E_UTILS::SWITCH_FIELD($this, 'autoplay', 'پخش خودکار');
        AE_E_UTILS::NUMBER_FIELD($this, 'autoplayTimeout', 'سرعت پخش خودکار', 1000, 10000, 100, 3000, true, 'autoplay', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'autoplayHoverPause', 'توقف پخش خودکار در هاور', 'yes', '', 'autoplay', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'dots', 'نقاط کنترلی');
        $dot_alignments = [
            'flex-start' => [
                'icon'  => 'eicon-h-align-right',
                'title' => 'ابتدا'
            ],
            'center'     => [
                'icon'  => 'eicon-h-align-center',
                'title' => 'وسط'
            ],
            'flex-end'   => [
                'icon'  => 'eicon-h-align-left',
                'title' => 'انتها'
            ]
        ];
        AE_E_UTILS::CHOOSE_FIELD_STYLE($this, 'dots-alignment', 'مکان نقاط', $dot_alignments, 'center', '.owl-carousel .owl-dots', 'justify-content', 'dots!', '');
        AE_E_UTILS::NUMBER_FIELD($this, 'dotsEach', 'تعداد اسلاید در نقطه کنترلی', 1, 10, 1, 1, true, 'dots', 'yes');
        $arrows = [
            ''           => 'غیر فعال',
            'default'    => 'پیشفرض',
            'custom-btn' => 'دلخواه'
        ];
        AE_E_UTILS::SELECT_FIELD($this, 'nav', 'دکمه های کنترلی', $arrows, 'default');
        AE_E_UTILS::TXT_FIELD($this, 'NextNavText', 'دکمه بعدی', '', false, 'nav', 'custom-btn');
        AE_E_UTILS::TXT_FIELD($this, 'PrevNavText', 'دکمه قبلی', '', false, 'nav', 'custom-btn');

        AE_E_UTILS::NUMBER_FIELD($this, 'margin', 'فاصله بین آیتم ها', 0, 100, 1, 15);

        AE_E_UTILS::SWITCH_FIELD($this, 'center', 'حالت وسط');

        AE_E_UTILS::SWITCH_FIELD($this, 'mouseDrag', 'دراگ با موس', 'yes');

        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'box-padding-top', 'پدینگ بالای باکس', 0, 100, 0, '.owl-carousel .owl-stage', 'padding-top');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'box-padding-bottom', 'پدینگ پایین باکس', 0, 100, 0, '.owl-carousel .owl-stage', 'padding-bottom');

        $this->add_control(
            'stage-padding',
            [
                'label'       => 'پدینگ اطراف باکس',
                'type'        => Controls_Manager::SLIDER,
                'label_block' => true,
                'size_units'  => ['px'],
                'range'       => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'     => [
                    'size' => 0
                ],
            ]
        );

        $stage_overflow = [
            'hidden'  => [
                'title' => 'مخفی',
                'icon'  => 'eicon-close',
            ],
            'visible' => [
                'title' => 'قابل مشاهده',
                'icon'  => 'eicon-preview-medium',
            ],
        ];
        AE_E_UTILS::CHOOSE_FIELD_STYLE($this, 'stage-overflow', 'سرریز', $stage_overflow, 'hidden', '.owl-stage-outer', 'overflow');

        AE_E_UTILS::SWITCH_FIELD($this, 'responsive', 'ریسپانسیو');

        $repeater = new \Elementor\Repeater();

        AE_E_UTILS::NUMBER_FIELD($repeater, 'breakpoint', 'نقطه شکست', 320, 1440, 1, 1024);
        AE_E_UTILS::NUMBER_FIELD($repeater, 'items', 'تعداد اسلاید برای نمایش', 1, 12);
        AE_E_UTILS::NUMBER_FIELD($repeater, 'slideBy', 'تعداد اسلاید در هر حرکت', 1, 100, 1, 1);
        AE_E_UTILS::NUMBER_FIELD($repeater, 'margin', 'فاصله بین آیتم ها', 0, 100, 1, 15);
        $repeater->add_control(
            'stage-padding',
            [
                'label'       => 'پدینگ اطراف باکس',
                'type'        => Controls_Manager::SLIDER,
                'label_block' => true,
                'size_units'  => ['px'],
                'range'       => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'     => [
                    'size' => 0
                ],
            ]
        );

        $this->add_control(
            'responsive_breakpoints',
            [
                'label'         => 'breakpoints',
                'type'          => \Elementor\Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'title_field'   => 'از {{{ breakpoint }}}px به بالا {{items}} آیتم',
                'prevent_empty' => false,
                'condition'     => [
                    'responsive' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

    }

    private function RenderOwlSettings()
    {
        $settings = $this->get_settings_for_display();

        $data = [];
        if (!empty($settings['items'])) {
            $data['items'] = $settings['items'];
        }

        if (!empty($settings['slideBy'])) {
            $data['slideBy'] = $settings['slideBy'];
        }

        if (!empty($settings['smartSpeed'])) {
            $data['smartSpeed'] = $settings['smartSpeed'];
        }

        if (!empty($settings['autoplayTimeout'])) {
            $data['autoplayTimeout'] = $settings['autoplayTimeout'];
        }

        if (!empty($settings['dotsEach'])) {
            $data['dotsEach'] = $settings['dotsEach'];
        }

        if (!empty($settings['margin'])) {
            $data['margin'] = $settings['margin'];
        }

        if (!empty($settings['stage-padding'])) {
            $data['stagePadding'] = $settings['stage-padding']['size'];
        }

        $data['responsiveRefreshRate'] = 100;

        $data['autoplay']           = $settings['autoplay'] === 'yes' ? true : false;
        $data['loop']               = $settings['loop'] === 'yes' ? true : false;
        $data['dots']               = $settings['dots'] === 'yes' ? true : false;
        $data['center']             = $settings['center'] === 'yes' ? true : false;
        $data['autoplayHoverPause'] = $settings['autoplayHoverPause'] === 'yes' ? true : false;
        $data['rtl']                = is_rtl();
        $data['mouseDrag']          = $settings['mouseDrag'] === 'yes' ? true : false;


        if (!empty($settings['nav'])) {

            if ($settings['nav'] === 'default') {
                $data['nav'] = true;
                $next_icon   = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"/></svg>';
                $prev_icon   = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M10.828 12l4.95 4.95-1.414 1.414L8 12l6.364-6.364 1.414 1.414z"/></svg>';

                $data['navText'] = [$next_icon, $prev_icon];
            } else {
                $data['navNextBtn'] = $settings['NextNavText'];
                $data['navPrevBtn'] = $settings['PrevNavText'];
            }

        } else {
            $data['nav'] = false;
        }

        if (!empty($settings['responsive']) && !empty($settings['responsive_breakpoints'])) {

            $breakpoints = $settings['responsive_breakpoints'];

            $temp = [];
            foreach ($breakpoints as $breakpoint) {

                $temp[$breakpoint['breakpoint']] = [
                    'items'        => $breakpoint['items'],
                    'slideBy'      => $breakpoint['slideBy'],
                    'margin'       => $breakpoint['margin'],
                    'stagePadding' => $breakpoint['stage-padding']['size'],
                ];
            }

            $data['responsive'] = $temp;
        }

        return $data;
    }

    private function OwlStylesNextPrevBtn()
    {

        // next prev arrows styles
        $this->start_controls_section('slider-nav-styles', [
            'label'     => 'استایل دکمه های بعدی و قبلی',
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
                'nav' => 'default'
            ]
        ]);

        AE_E_UTILS::TAB_START($this, 'nav-btn');

        $this->add_responsive_control(
            'nav-side-space-normal',
            [
                'label'       => 'فاصله از کنار',
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
                    '{{WRAPPER}} .owl-carousel .owl-nav button.owl-next' => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .owl-carousel .owl-nav button.owl-prev' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'nav-width-normal', 'عرض', 20, 100, 40, '.owl-carousel .owl-nav button', 'width');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'nav-height-normal', 'ارتفاع', 20, 200, 40, '.owl-carousel .owl-nav button', 'height');
        $this->add_control(
            'nav-icon-size-normal',
            [
                'label'       => 'اندازه آیکون',
                'type'        => Controls_Manager::SLIDER,
                'label_block' => true,
                'size_units'  => ['px'],
                'range'       => [
                    'px' => [
                        'min' => 14,
                        'max' => 40,
                    ],
                ],
                'default'     => [
                    'size' => 18
                ],
                'selectors'   => [
                    '{{WRAPPER}} .owl-carousel .owl-nav button svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
                ],
            ]
        );
        AE_E_UTILS::COLOR_FIELD($this, 'nav-icon-color-normal', 'رنگ آیکون', '', '.owl-carousel .owl-nav button svg', 'fill');
        AE_E_UTILS::BACKGROUND_FIELD($this, 'nav-bg-normal', '.owl-carousel .owl-nav button');
        AE_E_UTILS::BORDER_FIELD($this, 'nav-border-normal', 'بوردر', '.owl-carousel .owl-nav button');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'nav-border-radius-normal', 'خمیدگی', 0, 100, 50, '.owl-carousel .owl-nav button', 'border-radius');
        AE_E_UTILS::SHADOW_FIELD($this, 'nav-box-shadow-normal', 'سایه', '.owl-carousel .owl-nav button');

        AE_E_UTILS::TAB_MIDDLE($this, 'nav-btn');

        $this->add_responsive_control(
            'nav-side-space-hover',
            [
                'label'       => 'فاصله از کنار',
                'type'        => Controls_Manager::SLIDER,
                'label_block' => true,
                'size_units'  => ['px'],
                'range'       => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors'   => [
                    '{{WRAPPER}} .owl-carousel .owl-nav button.owl-next:hover' => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .owl-carousel .owl-nav button.owl-prev:hover' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'nav-width-hover', 'عرض', 20, 100, null, '.owl-carousel .owl-nav button:hover', 'width');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'nav-height-hover', 'ارتفاع', 20, 100, null, '.owl-carousel .owl-nav button:hover', 'height');
        $this->add_control(
            'nav-icon-size-hover',
            [
                'label'       => 'اندازه آیکون',
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
                    '{{WRAPPER}} .owl-carousel .owl-nav button:hover svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
                ],
            ]
        );
        AE_E_UTILS::COLOR_FIELD($this, 'nav-icon-color-hover', 'رنگ آیکون', '', '.owl-carousel .owl-nav button:hover svg', 'fill');
        AE_E_UTILS::BACKGROUND_FIELD($this, 'nav-bg-hover', '.owl-carousel .owl-nav button:hover');
        AE_E_UTILS::BORDER_FIELD($this, 'nav-border-hover', 'بوردر', '.owl-carousel .owl-nav button:hover');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'nav-border-radius-hover', 'خمیدگی', 0, 100, null, '.owl-carousel .owl-nav button:hover', 'border-radius');
        AE_E_UTILS::SHADOW_FIELD($this, 'nav-box-shadow-hover', 'سایه', '.owl-carousel .owl-nav button:hover');

        AE_E_UTILS::TAB_END($this);
        $this->end_controls_section();

    }

    private function OwlStylesDotSettings()
    {


        // dots styles
        $this->start_controls_section('slider-dots-styles', [
            'label'     => 'استایل نقاط کنترلی',
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
                'dots' => 'yes'
            ]
        ]);

        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'dots-margin-top', 'فاصله از بالا', 0, 100, 50, '.owl-carousel .owl-dots', 'margin-top');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'dots-gap', 'فاصله بین', 0, 20, 4, '.owl-carousel .owl-dots', 'gap');

        AE_E_UTILS::TAB_START($this, 'dots-btn');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'dots-width-normal', 'عرض', 6, 40, 12, '.owl-carousel .owl-dots button.owl-dot', 'width');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'dots-height-normal', 'ارتفاع', 6, 40, 12, '.owl-carousel .owl-dots button.owl-dot', 'height');
        AE_E_UTILS::BACKGROUND_FIELD($this, 'dots-bg-normal', '.owl-carousel .owl-dots button.owl-dot');
        AE_E_UTILS::BORDER_FIELD($this, 'dots-border-normal', 'بوردر', '.owl-carousel .owl-dots button.owl-dot');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'dots-border-radius-normal', 'خمیدگی', 0, 50, 50, '.owl-carousel .owl-dots button.owl-dot', 'border-radius');

        AE_E_UTILS::TAB_MIDDLE_($this, 'dots-btn', 'فعال');

        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'dots-width-active', 'عرض', 6, 40, 24, '.owl-carousel .owl-dots button.owl-dot.active', 'width');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'dots-height-active', 'ارتفاع', 6, 40, 12, '.owl-carousel .owl-dots button.owl-dot.active', 'height');
        AE_E_UTILS::BACKGROUND_FIELD($this, 'dots-bg-active', '.owl-carousel .owl-dots button.owl-dot.active');
        AE_E_UTILS::BORDER_FIELD($this, 'dots-border-active', 'بوردر', '.owl-carousel .owl-dots button.owl-dot.active');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'dots-border-radius-active', 'خمیدگی', 0, 50, 50, '.owl-carousel .owl-dots button.owl-dot.active', 'border-radius');

        AE_E_UTILS::TAB_END($this);

        $this->end_controls_section();

    }

}

