<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_FeaturedBoxes extends Widget_Base
{

    public function get_script_depends()
    {
        return ['wp-active-we-intro-animation'];
    }

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-featured-boxes', AE_E_CSS_DIR . 'featured-boxes.css');
        return ['wp-active-we-featured-boxes'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'جعبه های ویژگی ها';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-icon-box';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        $feature_boxes = new \Elementor\Repeater();
        AE_E_UTILS::ICON($feature_boxes, 'f_icon');
        AE_E_UTILS::TXT_FIELD($feature_boxes, 'title', 'عنوان', 'عنوان ویژگی', true);
        AE_E_UTILS::TXT_FIELD($feature_boxes, 'subtitle', 'زیرعنوان', 'این یک زیرعنوان است', true);
        AE_E_UTILS::TEXTAREA($feature_boxes, 'text', 'متن', '', true);
        AE_E_UTILS::URL_FIELD($feature_boxes, 'link', 'لینک', true);
        AE_E_UTILS::ICON($feature_boxes, 'link-');
        $this->add_control(
            'boxes',
            [
                'label'       => 'موارد',
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $feature_boxes->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_responsive_control(
            'items-per-row',
            [
                'label'       => 'ستون',
                'type'        => Controls_Manager::NUMBER,
                'label_block' => false,
                'min'         => 1,
                'max'         => 6,
                'dynamic'     => [
                    'active' => true,
                ],
                'selectors'   => [
                    '{{WRAPPER}} .wp-active-we-featured-boxes' => 'grid-template-columns: repeat({{VALUE}}, 1fr)'
                ]
            ]
        );
        $this->add_responsive_control(
            'box-alignment',
            [
                'label'     => 'چیدمان',
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start' => [
                        'title' => 'راست',
                        'icon'  => 'eicon-flex eicon-align-end-h',
                    ],
                    'center'     => [
                        'title' => 'وسط',
                        'icon'  => 'eicon-flex eicon-align-center-h',
                    ],
                    'flex-end'   => [
                        'title' => 'چپ',
                        'icon'  => 'eicon-flex eicon-align-start-h',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .feature-box' => 'align-items: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'text-alignment',
            [
                'label'     => 'جهت متن',
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'justify' => [
                        'title' => 'هم تراز',
                        'icon'  => 'eicon-text-align-justify',
                    ],
                    'right'   => [
                        'title' => 'راست',
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'center'  => [
                        'title' => 'وسط',
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'left'    => [
                        'title' => 'چپ',
                        'icon'  => 'eicon-text-align-left',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .feature-box .f_text' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        AE_E_UTILS::SWITCH_FIELD($this, 'intro-animation', 'انیمیشن ورود');

        $this->end_controls_section();


        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {

        // box tyles
        AE_E_UTILS::SECTION_START($this, 'box-style', 'باکس', 'style');

        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'columns-gap', 'فاصله بین افقی', 0, 100, null,
            '.wp-active-we-featured-boxes', 'column-gap');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'row-gap', 'فاصله بین عمودی', 0, 100, null,
            '.wp-active-we-featured-boxes', 'row-gap');


        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'box-height', 'ارتفاع', 100, 400, null, '.feature-box', 'height');

        AE_E_UTILS::TAB_START($this, 'box-utils-normal');
        AE_E_UTILS::DynamicStyleControls($this, 'box-utils-normal', '.feature-box', [
            'padding', 'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_MIDDLE($this, 'box-utils-hover');
        AE_E_UTILS::DynamicStyleControls($this, 'box-utils-hover', '.feature-box:hover', [
            'padding', 'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);
        AE_E_UTILS::SECTION_END($this);


        // icon style
        AE_E_UTILS::SECTION_START($this, 'box-icon-style', 'آیکون', 'style');
        AE_E_UTILS::IconUtils($this, 'main-icon', '.main-icon', '.feature-box');
        AE_E_UTILS::SECTION_END($this);

        // title style
        AE_E_UTILS::SECTION_START($this, 'title-style', 'عنوان', 'style');
        AE_E_UTILS::FONT_FIELD($this, 'title-text-font', 'تایپوگرافی', '.f_title');
        AE_E_UTILS::COLOR_FIELD($this, 'title-text-color', 'رنگ', '', '.f_title', 'color');
        AE_E_UTILS::COLOR_FIELD($this, 'title-text-color-hover', 'رنگ هاور', '', '.feature-box:hover .f_title', 'color');
        AE_E_UTILS::SECTION_END($this);

        // subtitle style
        AE_E_UTILS::SECTION_START($this, 'subtitle-style', 'زیرعنوان', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'subtitle-distance', 'فاصله', 0, 50, null, '.f_subtitle', 'margin-top');
        AE_E_UTILS::FONT_FIELD($this, 'subtitle-text-font', 'تایپوگرافی', '.f_subtitle');
        AE_E_UTILS::COLOR_FIELD($this, 'subtitle-text-color', 'رنگ', '', '.f_subtitle', 'color');
        AE_E_UTILS::COLOR_FIELD($this, 'subtitle-text-color-hover', 'رنگ هاور', '', '.feature-box:hover .f_subtitle', 'color');
        AE_E_UTILS::SECTION_END($this);

        // text style
        AE_E_UTILS::SECTION_START($this, 'paragraph-style', 'متن', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'paragraph-distance', 'فاصله', 0, 50, null, '.f_text', 'margin-top');
        AE_E_UTILS::FONT_FIELD($this, 'paragraph-text-font', 'تایپوگرافی', '.f_text');
        AE_E_UTILS::COLOR_FIELD($this, 'paragraph-text-color', 'رنگ', '', '.f_text', 'color');
        AE_E_UTILS::COLOR_FIELD($this, 'paragraph-text-color-hover', 'رنگ هاور', '', '.feature-box:hover .f_text', 'color');
        AE_E_UTILS::SECTION_END($this);

        // link
        AE_E_UTILS::SECTION_START($this, 'link-style', 'لینک', 'style');

        AE_E_UTILS::H_ALIGNMENT_MIN($this, 'link-alignment', '.wp-active-we-feature-box-holder');

        AE_E_UTILS::DIMENSIONS_FIELD($this, 'link-tn-margin', 'فاصله', '.f_link', 'margin');

        $this->add_responsive_control(
            'link-btn-width-height',
            [
                'label'       => 'اندازه',
                'type'        => Controls_Manager::SLIDER,
                'label_block' => true,
                'size_units'  => ['px'],
                'range'       => [
                    'px' => [
                        'min' => 40,
                        'max' => 80,
                    ],
                ],
                'selectors'   => [
                    '{{WRAPPER}} .f_link' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                ],
            ]
        );
        AE_E_UTILS::TAB_START($this, 'link-btn-utils-normal');
        $this->add_responsive_control(
            'link_icon_font_size',
            [
                'label'      => 'اندازه',
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .f_link i'   => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} .f_link svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                    '{{WRAPPER}} .f_link img' => 'width: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_control(
            'link_icon_color',
            [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .f_link i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .f_link svg' => 'fill: {{VALUE}};',
                ]
            ]
        );
        AE_E_UTILS::DynamicStyleControls($this, 'link-btn-utils-normal', '.f_link', [
            'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_MIDDLE($this, 'link-btn-utils-hover');
        $this->add_responsive_control(
            'link_icon_size_hover',
            [
                'label'      => 'اندازه',
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .f_link:hover i'   => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} .f_link:hover svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                    '{{WRAPPER}} .f_link:hover img' => 'width: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_control(
            'link_icon_color_hover',
            [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .f_link:hover i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .f_link:hover svg' => 'fill: {{VALUE}};',
                ]
            ]
        );
        AE_E_UTILS::DynamicStyleControls($this, 'link-btn-utils-hover', '.f_link:hover', [
            'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $boxes = $settings['boxes'];
        if (empty($boxes)) {
            return;
        }

        $this->add_render_attribute('featured-boxes-container', 'class', ['wp-active-we-featured-boxes', 'd-grid']);
        if ($settings['intro-animation'] === 'yes') {
            $this->add_render_attribute('featured-boxes-container', 'class', 'active-animation');
            $this->add_render_attribute('featured-boxes-container', 'data-animation-target', '.elementor-element-' . $this->get_id() . ' .wp-active-we-feature-box-holder');
            $this->add_render_attribute('featured-boxes-container', 'data-animation-offset', '100');
        }

        ?>
        <div <?php $this->print_render_attribute_string('featured-boxes-container'); ?>>
            <?php
            $i = 0;
            foreach ($boxes as $box) {

                $this->add_link_attributes('link' . $i, $box['link']);
                $this->add_render_attribute('link' . $i, 'class', ['f_link', 'dfx', 'aic', 'jcc']);
                $this->add_render_attribute('link' . $i, 'title', $box['title']);

                ?>

                <div class="wp-active-we-feature-box-holder dfx dir-v aic">
                    <div class="feature-box dfx dir-v aic">
                        <?php AE_E_UTILS::ICON_PRINT($this, $box, 'f_icon', 'main-icon'); ?>
                        <?php AE_E_UTILS::TxtHtmlGenerator($this, $box, 'title', 'h3', 'f_title'); ?>
                        <?php AE_E_UTILS::TxtHtmlGenerator($this, $box, 'subtitle', 'span', 'f_subtitle'); ?>
                        <?php AE_E_UTILS::TxtHtmlGenerator($this, $box, 'text', 'p', 'f_text'); ?>
                    </div>
                    <?php if (!empty($box['link']['url'])) { ?>
                        <a <?php $this->print_render_attribute_string('link' . $i); ?>>
                            <?php AE_E_UTILS::ICON_PRINT($this, $box, 'link-'); ?>
                        </a>
                    <?php } ?>
                </div>
                <?php $i++;
            }
            ?>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_FeaturedBoxes());
