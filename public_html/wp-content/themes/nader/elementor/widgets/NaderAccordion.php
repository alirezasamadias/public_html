<?php

namespace Elementor;

use RP_Utils;
use RealPressHelper;

defined('ABSPATH') || die();

class NaderAccordion extends Widget_Base
{

    public function get_script_depends()
    {
        wp_register_script('nader-accordion-widget', NADER_ELEMENTOR_JS_DIR . 'nader-accordion.js', ['jquery'], '1.0.0', true);

        return ['jquery', 'nader-accordion-widget'];
    }

    public function get_name()
    {
        return 'NaderAccordion';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : آکاردئون';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-accordion';
    }

    public function get_keywords()
    {
        return ['accordion', 'tabs', 'toggle', 'آکاردئون', 'تب'];
    }

    private function getTemplates()
    {
        $stack = [];
        $Query = new \WP_Query($defaults = [
            'post_type'      => 'elementor_library',
            'posts_per_page' => -1
        ]);

        if ($Query->have_posts()) {
            while ($Query->have_posts()) {
                $Query->the_post();
                $stack[get_the_ID()] = get_the_title();
            }
        }

        wp_reset_postdata();

        return $stack;
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);
        $accordion = new \Elementor\Repeater();
        RP_Utils::TXT_FIELD($accordion, 'title', 'عنوان');
        RP_Utils::ICON($accordion, 'accordion-');
        RP_Utils::SELECT_FIELD($accordion, 'content-type', 'نوع محتوا', [
            'WYSIWYG'  => 'متن',
            'TEMPLATE' => 'قالب'
        ], 'WYSIWYG');
        $accordion->add_control(
            'description',
            [
                'label'       => 'توضیح',
                'type'        => \Elementor\Controls_Manager::WYSIWYG,
                'placeholder' => 'متن خود را بنویسید',
                'condition'   => [
                    'content-type' => 'WYSIWYG'
                ]
            ]
        );
        $templates = $this->getTemplates();
        $accordion->add_control(
            'template',
            [
                'label'       => 'قالب',
                'type'        => Controls_Manager::SELECT,
                'label_block' => false,
                'options'     => $templates,
                'condition'   => [
                    'content-type' => 'TEMPLATE'
                ]
            ]
        );
        $this->add_control(
            'accordion',
            [
                'label'       => 'آکاردئون',
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $accordion->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );
        RP_Utils::HTML_TAG($this, 'title-tag', 'عنوان');
        RP_Utils::SWITCH_FIELD($this, 'toggle', 'آیا با باز شدن یک مورد بقیه بسته شود؟', 'yes');
        RP_Utils::NUMBER_FIELD($this,
            'open-item',
            'کدام آیتم در ابتدا باشد؟',
            0,
            100,
            1,
            1,
            true);
        RP_Utils::Separator($this, 'icon-opener', 'آیکون باز کردن');
        RP_Utils::ICON($this, 'icon-opener', 'fas fa-plus');
        RP_Utils::Separator($this, 'icon-closer', 'آیکون بستن');
        RP_Utils::ICON($this, 'icon-closer', 'fas fa-minus');
        $this->end_controls_section();


        // styles
        $this->start_controls_section('header', [
            'label' => 'سربرگ',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);
        $header_styles = [
            [
                'type'   => 'font',
                'title'  => 'تایپوگرافی',
                'target' => '.nader-accordion .nader-accordion-header .accordion-title'
            ],
            [
                'type'  => '4dir',
                'css'   => 'padding',
                'title' => 'فاصله داخلی'
            ],
            [
                'type'   => 'slider',
                'title'  => 'فاصله آیکون و متن',
                'min'    => 0,
                'max'    => 50,
                'def'    => 15,
                'css'    => 'gap',
                'target' => '.nader-accordion .nader-accordion-header .accordion-title'
            ],
            [
                'type' => 'tab-start'
            ],
            [
                'type'   => 'color',
                'title'  => 'رنگ',
                'target' => '.nader-accordion .nader-accordion-header .accordion-title'
            ],
            [
                'type' => 'bg-c',
            ],
            [
                'type'  => 'border',
                'title' => 'حاشیه'
            ],
            [
                'type'  => 'shadow',
                'title' => 'سایه'
            ],
            [
                'type'  => '4dir',
                'css'   => 'border-radius',
                'title' => 'خمیدگی'
            ],
            [
                'type'  => 'tab-middle',
                'title' => 'حالت فعال'
            ],
            [
                'type'   => 'color',
                'title'  => 'رنگ',
                'uniq'   => 'active',
                'target' => '.nader-accordion .nader-accordion-item.active .nader-accordion-header .accordion-title'
            ],
            [
                'type'   => 'bg-c',
                'uniq'   => 'active',
                'target' => '.nader-accordion .nader-accordion-item.active .nader-accordion-header'
            ],
            [
                'type'   => 'border',
                'title'  => 'حاشیه',
                'uniq'   => 'active',
                'target' => '.nader-accordion .nader-accordion-item.active .nader-accordion-header'
            ],
            [
                'type'   => 'shadow',
                'title'  => 'سایه',
                'uniq'   => 'active',
                'target' => '.nader-accordion .nader-accordion-item.active .nader-accordion-header'
            ],
            [
                'type'   => '4dir',
                'css'    => 'border-radius',
                'title'  => 'خمیدگی',
                'uniq'   => 'active',
                'target' => '.nader-accordion .nader-accordion-item.active .nader-accordion-header'
            ],
            [
                'type' => 'tab-end'
            ],

        ];
        RP_Utils::VariantUtils($this,
            'header-style',
            '.nader-accordion .nader-accordion-item .nader-accordion-header',
            $header_styles);


        // main icon styles
        RP_Utils::Separator($this, 'main-head-icon', 'آیکون اصلی');
        $this->add_responsive_control(
            'header-icon-size',
            [
                'label'      => 'اندازه',
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 24,
                ],
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 14,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .nader-accordion .nader-accordion-header .accordion-title .icon i'   => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} .nader-accordion .nader-accordion-header .accordion-title .icon svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                    '{{WRAPPER}} .nader-accordion .nader-accordion-header .accordion-title .icon img' => 'width: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_control(
            'header-icon-color',
            [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .nader-accordion .nader-accordion-item .nader-accordion-header .accordion-title .icon i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .nader-accordion .nader-accordion-item .nader-accordion-header .accordion-title .icon svg' => 'fill: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'header-icon-color-active',
            [
                'label'       => 'رنگ فعال',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .nader-accordion .nader-accordion-item.active .nader-accordion-header .accordion-title .icon i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .nader-accordion .nader-accordion-item.active .nader-accordion-header .accordion-title .icon svg' => 'fill: {{VALUE}};',
                ]
            ]
        );


        //opener/closer icon styles
        RP_Utils::Separator($this, 'open-close-head-icon', 'آیکون باز و بسته');
        $this->add_responsive_control(
            'header-opener-closer-icon-size',
            [
                'label'      => 'اندازه',
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 16,
                ],
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .nader-accordion .nader-accordion-item .nader-accordion-header .accordion-status-icon .icon i'   => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} .nader-accordion .nader-accordion-item .nader-accordion-header .accordion-status-icon .icon svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                    '{{WRAPPER}} .nader-accordion .nader-accordion-item .nader-accordion-header .accordion-status-icon .icon img' => 'width: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_control(
            'header-opener-icon-color',
            [
                'label'       => 'رنگ آیکون باز',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .nader-accordion .nader-accordion-header .accordion-status-icon.btn_opener i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .nader-accordion .nader-accordion-header .accordion-status-icon.btn_opener svg' => 'fill: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'header-closer-icon-color',
            [
                'label'       => 'رنگ آیکون بسته',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .nader-accordion .nader-accordion-header .accordion-status-icon.btn_closer i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .nader-accordion .nader-accordion-header .accordion-status-icon.btn_closer svg' => 'fill: {{VALUE}};',
                ]
            ]
        );
        $this->end_controls_section();


        // content styles
        $this->start_controls_section('content', [
            'label' => 'باکس محتوا',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);
        $content_styles = [
            [
                'type'  => '4dir',
                'css'   => 'padding',
                'title' => 'فاصله داخلی'
            ],
            [
                'type'  => 'font',
                'title' => 'تایپوگرافی',
            ],
            [
                'type' => 'text-align',
            ],
            [
                'type'   => 'color',
                'title'  => 'رنگ',
                'target' => '.nader-accordion .nader-accordion-item .nader-accordion-content p'
            ],
            [
                'type' => 'bg-c',
            ],
            [
                'type'  => 'border',
                'title' => 'حاشیه'
            ],
            [
                'type'  => '4dir',
                'css'   => 'border-radius',
                'title' => 'خمیدگی'
            ],
            [
                'type'  => 'shadow',
                'title' => 'سایه'
            ],
        ];
        RP_Utils::VariantUtils($this,
            'content-style',
            '.nader-accordion .nader-accordion-content',
            $content_styles);
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $accordions     = $settings['accordion'];
        $tt             = $settings['title-tag'];
        $open_item      = $settings['open-item'];
        $toggle_setting = $settings['toggle'];

        if (!empty($accordions)) {
            ?>

            <div class="nader-accordion"
                 data-toggle-setting="<?php echo (bool)esc_html($toggle_setting); ?>">

                <?php

                $i = 1;

                foreach ($accordions as $accordion) {
                    $title        = $accordion['title'];
                    $content_type = $accordion['content-type'];

                    ?>

                    <div class="nader-accordion-item<?php if ($open_item === $i) {
                        echo ' open-item active';
                    } ?>">
                        <div role="button" class="nader-accordion-header dfx aic">
                            <?php
                            echo '<' . $tt . ' class="accordion-title dfx aic">';
                            RP_Utils::ICON_PRINT($this, $accordion, 'accordion-');
                            echo esc_html($title);
                            echo '</' . $tt . '>';
                            ?>
                            <span class="accordion-status-icon dfx aic jcc btn_opener">
                                <?php RP_Utils::ICON_PRINT($this, $settings, 'icon-opener'); ?>
                            </span>
                            <span class="accordion-status-icon dfx aic jcc btn_closer">
                                <?php RP_Utils::ICON_PRINT($this, $settings, 'icon-closer'); ?>
                            </span>
                        </div>
                        <div class="nader-accordion-content">
                            <?php
                            if ($content_type === 'WYSIWYG') {
                                echo $accordion['description'];
                            }
                            if ($content_type === 'TEMPLATE') {
                                RealPressHelper::loadElementorContent($accordion['template']);
                            }
                            ?>
                        </div>
                    </div>

                    <?php
                    $i++;
                } ?>

            </div>

            <?php
        }
    }
}

Plugin::instance()->widgets_manager->register(new NaderAccordion());
