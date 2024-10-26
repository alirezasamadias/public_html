<?php

namespace Elementor;

use RP_Utils;

defined('ABSPATH') || die();

class NaderCounter extends Widget_Base{

    public function get_script_depends()
    {
        wp_register_script('nader-jquery-counter-up', NADER_JS_DIR . 'jquery.counterup.min.js', ['jquery'], 1, true);
        wp_register_script('nader-counter-widget', NADER_ELEMENTOR_JS_DIR . 'nader-counter.js', [
            'jquery',
            'nader-waypoints',
            'nader-jquery-counter-up'
        ], '1.0.0', true);
        return ['jquery', 'nader-counter-widget'];
    }

    public function get_name()
    {
        return 'NaderCounter';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : شمارنده';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-counter';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        $c_styles = [
            'default'    => 'زیر هم',
            'horizontal' => 'افقی'
        ];
        RP_Utils::SELECT_FIELD($this, 'counter-style', '', $c_styles, 'default');
        RP_Utils::TXT_FIELD($this, 'title', 'عنوان', 'مشتری راضی', true);
        RP_Utils::NUMBER_FIELD($this, 'number', 'عدد', 0, null, 1, 100, true);
        RP_Utils::TEXT_ALIGNMENT($this, 'alignment-text', '.funfacts-item', 'counter-style', 'default');


        RP_Utils::ICON($this, 'counter_icon');
        RP_Utils::H_ALIGNMENT_MIN($this,'alignment-icon','.nader-counter','','counter-style','default');

        RP_Utils::SLIDER_FIELD_STYLE($this, 'horizontal-gap', 'فاصله بین', 0, 100, null, '.nader-counter', 'gap', 'counter-style', 'horizontal');

        $this->end_controls_section();


        // text styles
        $this->start_controls_section('text-styles', [
            'label' => 'استایل متن',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);
        $text_styles = [
            [
                'type'  => 'sep',
                'title' => 'عدد',
                'uniq'  => 'counter'
            ],
            [
                'type'   => 'text-small',
                'uniq'   => 'counter',
                'target' => '.counter'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله از بالا',
                'min'    => 0,
                'max'    => 100,
                'def'    => 0,
                'css'    => 'margin-top',
                'uniq'   => 'counter',
                'target' => '.counter'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله از پایین',
                'min'    => 0,
                'max'    => 100,
                'def'    => 0,
                'css'    => 'margin-bottom',
                'uniq'   => 'counter',
                'target' => '.counter'
            ],
            [
                'type'  => 'sep',
                'title' => 'عنوان',
                'uniq'  => 'title'
            ],
            [
                'type'   => 'text-small',
                'uniq'   => 'title',
                'target' => 'p'
            ]
        ];
        RP_Utils::VariantUtils($this, 'text_styles', '', $text_styles);
        $this->end_controls_section();


        // icon
        $this->start_controls_section('section_icon', [
            'label' => 'آیکون (قدیمی)',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);
        RP_Utils::NOTICE($this, 'old-icon-styler-notice', 'لطفا از بخش آیکون جدید استفاده کنید');
        $this->add_responsive_control('icon-font-size', [
                'label'      => 'اندازه',
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 42,
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
            ]);
        $this->add_control('icon-color', [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .nader-counter .icon i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .nader-counter .icon svg' => 'fill: {{VALUE}};',
                ]
            ]);
        $this->end_controls_section();

        // new Styler
        RP_Utils::SECTION_START($this, 'icon-styler-new', 'آیکون (جدید)', 'style');
        RP_Utils::HEADING_FIELD($this, 'new-icon-styler', 'استایل دهنده جدید');
        RP_Utils::IconUtils($this, 'icon', '.icon');
        RP_Utils::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $title = $settings['title'];
        $number = $settings['number'];

        $style = $settings['counter-style'];

        $this->add_render_attribute('counter','class','nader-counter funfacts-item dfx aic jcc');
        if ($style == 'default') {
            $this->add_render_attribute('counter','class','dir-v');
        }

        ?>

        <div <?php $this->print_render_attribute_string('counter'); ?>>
            <?php RP_Utils::ICON_PRINT($this, $settings, 'counter_icon','shrink0'); ?>

            <?php if ($style === 'horizontal') {
                echo '<div class="details">';
            } ?>
            <h5 class="counter"><?php echo $number; ?></h5>
            <p class="mb-0"><?php echo $title; ?></p>
            <?php if ($style === 'horizontal') {
                echo '</div>';
            } ?>
        </div>

        <?php

    }
}

Plugin::instance()->widgets_manager->register(new NaderCounter());
