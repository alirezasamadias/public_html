<?php

defined('ABSPATH') || die();

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Utils;

class RP_Utils{

    public static function SECTION_START($widget, string $id, string $title, string $type = '', $condition = false, $condition_value = '')
    {
        $control_args = ['label' => $title];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        if ($type === 'style') {
            $control_args['tab'] = Controls_Manager::TAB_STYLE;
        }

        $widget->start_controls_section($id, $control_args);
    }

    public static function SECTION_END($widget)
    {
        $widget->end_controls_section();
    }

    public static function TXT_FIELD($widget, string $id, string $title, string $default = '', $dynamic = false, $condition = false, $condition_value = '')
    {
        $control_args = [
            'label'       => $title,
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'dynamic'     => [
                'active' => $dynamic,
            ],
            'default'     => $default
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_control($id, $control_args);
    }

    public static function URL_FIELD($widget, string $id, string $title, $dynamic = false, $condition = false, $condition_value = '')
    {

        $control_args = [
            'label'       => $title,
            'type'        => Controls_Manager::URL,
            'label_block' => true,
            'dynamic'     => [
                'active' => $dynamic,
            ],
            'placeholder' => 'https://your-link.com',
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_control($id, $control_args);
    }

    public static function NUMBER_FIELD($widget, string $id, string $title, $min = 0, $max = 100, $step = 1, $default = 5, $dynamic = false, $condition = false, $condition_value = '')
    {
        $control_args = [
            'label'       => $title,
            'type'        => Controls_Manager::NUMBER,
            'label_block' => false,
            'min'         => $min,
            'max'         => $max,
            'step'        => $step,
            'default'     => $default,
            'dynamic'     => [
                'active' => $dynamic,
            ],
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_control($id, $control_args);
    }

    public static function NUMBER_FIELD_STYLE($widget, string $id, string $title, string $target, string $selector, string $unit = 'px', $min = 0, $max = 100, $step = 1, $default = 5, $dynamic = false, $condition = false, $condition_value = '')
    {
        $control_args = [
            'label'       => $title,
            'type'        => Controls_Manager::NUMBER,
            'label_block' => false,
            'min'         => $min,
            'max'         => $max,
            'step'        => $step,
            'default'     => $default,
            'selectors'   => [
                '{{WRAPPER}} ' . $target => $selector . ':{{VALUE}}' . $unit,
            ],
            'dynamic'     => [
                'active' => $dynamic,
            ],
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_responsive_control($id, $control_args);
    }

    public static function TEXTAREA($widget, string $id, string $title, string $default = '', $dynamic = false, $condition = false, $condition_value = '')
    {
        $control_args = [
            'label'       => $title,
            'type'        => Controls_Manager::TEXTAREA,
            'rows'        => 7,
            'label_block' => true,
            'dynamic'     => [
                'active' => $dynamic,
            ],
            'default'     => $default
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_control($id, $control_args);
    }

    public static function SWITCH_FIELD($widget, string $id, string $title, string $default = '', bool $label_block = false, $condition = false, $condition_value = null)
    {
        $control_args = [
            'label'        => $title,
            'type'         => Controls_Manager::SWITCHER,
            'label_block'  => $label_block,
            'label_on'     => 'بله',
            'label_off'    => 'خیر',
            'return_value' => 'yes',
            'default'      => $default
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_control($id, $control_args);
    }

    public static function SELECT_FIELD($widget, string $id, string $title, array $options, string $default, $condition = false, $condition_value = null)
    {
        $control_args = [
            'label'       => $title,
            'type'        => Controls_Manager::SELECT,
            'label_block' => false,
            'options'     => $options,
            'default'     => $default
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_control($id, $control_args);
    }

    public static function SELECT_FIELD_STYLE($widget, string $id, string $title, array $options, string $default, string $target, string $selector, $condition = false, $condition_value = null)
    {
        $control_args = [
            'label'       => $title,
            'type'        => Controls_Manager::SELECT,
            'label_block' => false,
            'options'     => $options,
            'default'     => $default,
            'selectors'   => [
                '{{WRAPPER}} ' . $target => $selector . ':{{VALUE}};'
            ]
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_responsive_control($id, $control_args);
    }

    public static function MULTIPLE_SELECT_FIELD($widget, string $id, string $title, array $options, array $default, $condition = false, $condition_value = null)
    {
        $control_args = [
            'label'       => $title,
            'type'        => Controls_Manager::SELECT2,
            'label_block' => false,
            'options'     => $options,
            'default'     => $default,
            'multiple'    => true,
            'sortable'    => true
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_control($id, $control_args);
    }

    public static function CHOOSE_FIELD_STYLE($widget, string $id, string $title, array $options, string $default, string $target, string $selector, $condition = false, $condition_value = null)
    {
        $control_args = [
            'label'       => $title,
            'type'        => Controls_Manager::CHOOSE,
            'label_block' => false,
            'options'     => $options,
            'default'     => $default,
            'toggle'      => true,
            'selectors'   => [
                '{{WRAPPER}} ' . $target => $selector . ':{{VALUE}};'
            ]
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_responsive_control($id, $control_args);
    }

    public static function SLIDER_FIELD_STYLE($widget, string $id, string $title, int $min, int $max, $default, string $class, string $selector, $condition = false, $condition_value = null)
    {
        $control_args = [
            'label'       => $title,
            'type'        => Controls_Manager::SLIDER,
            'label_block' => true,
            'size_units'  => ['px', '%'],
            'range'       => [
                'px' => [
                    'min' => $min,
                    'max' => $max,
                ],
                '%'  => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'default'     => [
                'size' => $default
            ],
            'selectors'   => [
                '{{WRAPPER}} ' . $class => $selector . ': {{SIZE}}{{UNIT}};',
            ],
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_responsive_control($id, $control_args);
    }

    public static function SLIDER_FIELD_PIX_STYLE($widget, string $id, string $title, int $min, int $max, $default, string $class, string $selector, $condition = false, $condition_value = '')
    {
        $control_args = [
            'label'       => $title,
            'type'        => Controls_Manager::SLIDER,
            'label_block' => true,
            'size_units'  => ['px'],
            'range'       => [
                'px' => [
                    'min' => $min,
                    'max' => $max,
                ],
            ],
            'selectors'   => [
                '{{WRAPPER}} ' . $class => $selector . ': {{SIZE}}px;',
            ],
        ];

        if (!is_null($default)) {
            $control_args['default'] = ['size' => $default];
        }

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_responsive_control($id, $control_args);
    }

    public static function SLIDER_FIELD_PERCENT_STYLE($widget, string $id, string $title, int $min, int $max, $default, string $class, string $selector, $condition = false, $condition_value = '')
    {
        $control_args = [
            'label'       => $title,
            'type'        => Controls_Manager::SLIDER,
            'label_block' => true,
            'size_units'  => ['%'],
            'range'       => [
                '%' => [
                    'min' => $min,
                    'max' => $max,
                ],
            ],
            'selectors'   => [
                '{{WRAPPER}} ' . $class => $selector . ': {{SIZE}}%;',
            ],
        ];

        if (!is_null($default)) {
            $control_args['default'] = ['size' => $default];
        }

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_responsive_control($id, $control_args);
    }


    public static function DIMENSIONS_FIELD($widget, string $id, string $title, string $class, string $selector, $condition = false, $condition_value = '')
    {
        $control_args = [
            'label'     => $title,
            'type'      => \Elementor\Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} ' . $class => $selector . ': {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px',
            ]
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_responsive_control($id, $control_args);
    }

    public static function COLOR_FIELD($widget, string $id, string $title, string $default, string $class, string $style_selector, $condition = false, $condition_value = '')
    {

        $control_args = [
            'label'       => $title,
            'label_block' => false,
            'type'        => \Elementor\Controls_Manager::COLOR,
            'default'     => $default,
            'selectors'   => [
                '{{WRAPPER}} ' . $class => $style_selector . ': {{VALUE}};',
            ]
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_control($id, $control_args);
    }

    public static function FONT_FIELD($widget, string $id, string $title, string $class, $condition = false, $condition_value = '')
    {

        $control_args = [
            'name'       => $id,
            'label'      => $title,
            'show_label' => true,
            'selector'   => '{{WRAPPER}} ' . $class,
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_group_control(Group_Control_Typography::get_type(), $control_args);
    }

    public static function FONT_STROKE_FIELD($widget, string $id, string $class, $condition = false, $condition_value = '')
    {
        $control_args = [
            'name'     => $id,
            'selector' => '{{WRAPPER}} ' . $class,
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_group_control(Group_Control_Text_Stroke::get_type(), $control_args);
    }

    public static function BORDER_FIELD($widget, string $id, string $title, string $class, $condition = false, $condition_value = '')
    {

        $control_args = [
            'name'       => $id,
            'label'      => $title,
            'show_label' => true,
            'selector'   => '{{WRAPPER}} ' . $class,
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_group_control(Group_Control_Border::get_type(), $control_args);
    }

    public static function SHADOW_FIELD($widget, string $id, string $title, string $class, $condition = false, $condition_value = '')
    {

        $control_args = [
            'name'       => $id,
            'label'      => $title,
            'show_label' => true,
            'selector'   => '{{WRAPPER}} ' . $class,
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        return $widget->add_group_control(Group_Control_Box_Shadow::get_type(), $control_args);
    }

    public static function BACKGROUND_FIELD($widget, string $id, string $class, $condition = false, $condition_value = '')
    {

        $control_args = [
            'name'     => $id,
            'selector' => '{{WRAPPER}} ' . $class,
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_group_control(Group_Control_Background::get_type(), $control_args);
    }

    public static function BACKGROUND_WO_IMG_FIELD($widget, string $id, string $class, $condition = false, $condition_value = '')
    {

        $control_args = [
            'name'     => $id,
            'selector' => '{{WRAPPER}} ' . $class,
            'exclude'  => [
                'image'
            ]
        ];

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_group_control(Group_Control_Background::get_type(), $control_args);
    }

    public static function ICON($widget, string $id, $default = 'fas fa-star')
    {
        $widget->add_control($id . 'icon_type', [
            'label'   => 'نوع آیکون',
            'type'    => Controls_Manager::CHOOSE,
            'toggle'  => false,
            'default' => 'icon',
            'options' => [
                'icon'  => [
                    'title' => 'آیکون',
                    'icon'  => $default
                ],
                'image' => [
                    'title' => 'عکس',
                    'icon'  => 'far fa-image'
                ],
            ]
        ]);
        $widget->add_control($id . 'selected_icon', [
            'label'            => 'آیکون',
            'type'             => Controls_Manager::ICONS,
            'fa4compatibility' => 'icon',
            'default'          => [
                'value'   => $default,
                'library' => 'fa-solid',
            ],
            'condition'        => [
                $id . 'icon_type' => 'icon',
            ],
            'label_block'      => false,
            'skin'             => 'inline'
        ]);
        $widget->add_control($id . 'image', [
            'label'     => 'عکس',
            'type'      => Controls_Manager::MEDIA,
            'default'   => [
                'url' => Utils::get_placeholder_image_src(),
            ],
            'condition' => [
                $id . 'icon_type' => 'image',
            ]
        ]);
        $widget->add_control($id . 'image_alt', [
            'label'     => 'متن جایگزین تصویر',
            'type'      => Controls_Manager::TEXT,
            'default'   => 'متن جایگزین تصویر',
            'dynamic'   => [
                'active' => true
            ],
            'condition' => [
                $id . 'icon_type' => 'image',
            ]
        ]);
    }

    public static function ICON_PRINT($widget, $settings, $icon_id, $class = '')
    {
        $migrated = isset($settings['__fa4_migrated'][$icon_id . 'selected_icon']);
        $is_new = empty($settings[$icon_id . 'icon']) && Icons_Manager::is_migration_allowed();

        if ('icon' == $settings[$icon_id . 'icon_type']) {
            if (!empty($settings[$icon_id . 'icon_type']) && !empty($settings[$icon_id . 'selected_icon']['value'])) {
                echo '<div class="icon ' . $class . ' dfx jcc aic">';
            }

            if ($is_new || $migrated) {
                Icons_Manager::render_icon($settings[$icon_id . 'selected_icon'], ['aria-hidden' => 'true']);
            } else {
                echo '<i ' . $widget->get_render_attribute_string('font-icon') . '></i>';
            }

            if (!empty($settings[$icon_id . 'icon_type']) && !empty($settings[$icon_id . 'selected_icon']['value'])) {
                echo '</div>';
            }
        } elseif ('image' == $settings[$icon_id . 'icon_type']) {
            echo '<div class="icon ' . $class . ' dfx jcc aic">';
            echo '<img src="' . $settings[$icon_id . 'image']['url'] . '" alt="' . $settings[$icon_id . 'image_alt'] . '">';
            echo '</div>';
        }
    }

    public static function IMAGE($widget, string $id, string $title, $dynamic = true, $condition = false, $condition_value = '')
    {
        $args = [
            'label'   => $title,
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            'dynamic' => [
                'active' => $dynamic,
            ],
        ];

        if ($condition) {
            $args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_control($id, $args);
    }

    public static function IMAGE_SIZE($widget, string $id, string $def = 'large', $condition = false, $condition_value = '')
    {
        $args = [
            'name'      => $id,
            // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
            'default'   => $def,
            'separator' => 'none',
        ];

        if ($condition) {
            $args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_group_control(Group_Control_Image_Size::get_type(), $args);
    }

    public static function ImageGenerator($settings, string $img_key, string $img_size_key = null, string $class_name = '')
    {
        $img = $settings[$img_key];
        if (empty($img['url'])) {
            return;
        }

        if (!empty($class_name)) {
            echo wp_get_attachment_image($img['id'], !empty($settings[$img_size_key]) ? $settings[$img_size_key] : $img_size_key, '', ['class' => $class_name]);
        } else {
            echo wp_get_attachment_image($img['id'], !empty($settings[$img_size_key]) ? $settings[$img_size_key] : $img_size_key);
        }

    }

    public static function HEADING_FIELD($widget, string $id, string $title, $condition = false, $condition_value = '')
    {
        $args = [
            'label'       => $title,
            'label_block' => true,
            'type'        => \Elementor\Controls_Manager::HEADING,
        ];

        if ($condition) {
            $args['condition'] = [
                $condition => $condition_value
            ];
        }

        return $widget->add_control($id, $args);
    }

    public static function TEXT_ALIGNMENT($widget, string $id, string $class, $condition = false, $condition_value = '')
    {
        $args = [
            'label'     => 'تراز متن',
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
                'left'    => [
                    'title' => 'چپ',
                    'icon'  => 'eicon-text-align-left',
                ],
                'center'  => [
                    'title' => 'وسط',
                    'icon'  => 'eicon-text-align-center',
                ],
                'right'   => [
                    'title' => 'راست',
                    'icon'  => 'eicon-text-align-right',
                ],
                'justify' => [
                    'title' => 'هم تراز',
                    'icon'  => 'eicon-text-align-justify',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} ' . $class => 'text-align: {{VALUE}};',
            ],
        ];

        if ($condition) {
            $args['condition'] = [
                $condition => $condition_value
            ];
        }

        return $widget->add_responsive_control($id, $args);

    }

    public static function SCROLLER($widget, string $id, string $target)
    {
        self::SLIDER_FIELD_STYLE($widget, $id . 'scroller_width', 'عرض نوار اسکرول', 2, 10, 4, $target . '::-webkit-scrollbar', 'width');
        self::COLOR_FIELD($widget, $id . 'scroller_tracker_bg', 'رنگ ریل نوار اسکرول', '', $target . '::-webkit-scrollbar-track', 'background');
        self::COLOR_FIELD($widget, $id . 'scroller_bg', 'رنگ نوار اسکرول', '#161616', $target . '::-webkit-scrollbar-thumb', 'background');
        self::COLOR_FIELD($widget, $id . 'scroller_bg_hover', 'رنگ هاور نوار اسکرول', '#333333', $target . '::-webkit-scrollbar-thumb:hover', 'background');
    }

    public static function HTML_TAG($widget, string $id, string $title, string $default = 'h3', $condition = false, $condition_value = '')
    {
        $cond = [];
        if (!empty($condition)) {
            $cond['condition'] = [
                $condition => $condition_value
            ];
        }
        $widget->add_control($id, array_merge([
            'label'       => 'تگ HTML ' . $title,
            'type'        => Controls_Manager::SELECT,
            'label_block' => false,
            'options'     => [
                'h1'     => 'h1',
                'h2'     => 'h2',
                'h3'     => 'h3',
                'h4'     => 'h4',
                'h5'     => 'h5',
                'h6'     => 'h6',
                'span'   => 'span',
                'strong' => 'strong',
                'b'      => 'b',
                'div'    => 'div',
                'p'      => 'p',
            ],
            'default'     => $default
        ], $cond));
    }

    public static function TxtHtmlGenerator($widget, $settings, $text_control_name, $html_control_name, $class_name = '', $foreach_counter = 0)
    {
        $text = $settings[$text_control_name];
        $html = !empty($settings[$html_control_name]) ? $settings[$html_control_name] : $html_control_name;
        if (!empty($text)) {
            $widget->add_render_attribute($text_control_name . 'ara' . $foreach_counter, 'class', $class_name);
            echo '<' . $html . ' ' . $widget->get_render_attribute_string($text_control_name . 'ara' . $foreach_counter) . '>';
            echo __($text, 'wp-active-widgets-elementor');
            echo '</' . $html . '>';
        }
    }

    public static function H_ALIGNMENT($widget, string $id, string $target, $condition = false, $condition_value = '')
    {
        $args = [
            'label'       => 'چیدمان افقی',
            'type'        => Controls_Manager::CHOOSE,
            'label_block' => false,
            'options'     => [
                'flex-start'    => [
                    'title' => esc_html_x('Start', 'Flex Container Control', 'elementor'),
                    'icon'  => 'eicon-flex ' . is_rtl() ? 'eicon-justify-end-h' : 'eicon-justify-start-h',
                ],
                'center'        => [
                    'title' => esc_html_x('Center', 'Flex Container Control', 'elementor'),
                    'icon'  => 'eicon-flex eicon-justify-center-h',
                ],
                'flex-end'      => [
                    'title' => esc_html_x('End', 'Flex Container Control', 'elementor'),
                    'icon'  => 'eicon-flex ' . is_rtl() ? 'eicon-justify-start-h' : 'eicon-justify-end-h',
                ],
                'space-between' => [
                    'title' => esc_html_x('Space Between', 'Flex Container Control', 'elementor'),
                    'icon'  => 'eicon-flex eicon-justify-space-between-h',
                ],
                'space-around'  => [
                    'title' => esc_html_x('Space Around', 'Flex Container Control', 'elementor'),
                    'icon'  => 'eicon-flex eicon-justify-space-around-h',
                ],
                'space-evenly'  => [
                    'title' => esc_html_x('Space Evenly', 'Flex Container Control', 'elementor'),
                    'icon'  => 'eicon-flex eicon-justify-space-evenly-h',
                ],
            ],
            'default'     => 'flex-start',
            'selectors'   => [
                '{{WRAPPER}} ' . $target => 'justify-content: {{VALUE}}'
            ]
        ];
        $cond = [];
        if (!empty($condition)) {
            $cond['condition'] = [
                $condition => $condition_value
            ];
        }
        $widget->add_responsive_control($id, array_merge($args, $cond));
    }

    public static function H_ALIGNMENT_MIN($widget, string $id, string $target, $default = '', $condition = false, $condition_value = '')
    {
        $args = [
            'label'       => 'چیدمان افقی',
            'type'        => Controls_Manager::CHOOSE,
            'label_block' => false,
            'options'     => [
                'flex-start' => [
                    'title' => esc_html_x('Start', 'Flex Container Control', 'elementor'),
                    'icon'  => 'eicon-flex ' . is_rtl() ? 'eicon-justify-end-h' : 'eicon-justify-start-h',
                ],
                'center'     => [
                    'title' => esc_html_x('Center', 'Flex Container Control', 'elementor'),
                    'icon'  => 'eicon-flex eicon-justify-center-h',
                ],
                'flex-end'   => [
                    'title' => esc_html_x('End', 'Flex Container Control', 'elementor'),
                    'icon'  => 'eicon-flex ' . is_rtl() ? 'eicon-justify-start-h' : 'eicon-justify-end-h',
                ],
            ],
            'selectors'   => [
                '{{WRAPPER}} ' . $target => 'justify-content: {{VALUE}}'
            ]
        ];
        $cond = [];
        if (!empty($condition)) {
            $cond['condition'] = [
                $condition => $condition_value
            ];
        }
        if (!empty($default)) {
            $cond['default'] = $default;
        }
        $widget->add_responsive_control($id, array_merge($args, $cond));
    }

    public static function V_ALIGNMENT($widget, string $id, string $target, $condition = false, $condition_value = '')
    {
        $args = [
            'label'       => 'چیدمان عمودی',
            'type'        => Controls_Manager::CHOOSE,
            'label_block' => false,
            'options'     => [
                'flex-start' => [
                    'title' => esc_html_x('Start', 'Flex Container Control', 'elementor'),
                    'icon'  => 'eicon-flex eicon-align-start-v',
                ],
                'center'     => [
                    'title' => esc_html_x('Center', 'Flex Container Control', 'elementor'),
                    'icon'  => 'eicon-flex eicon-align-center-v',
                ],
                'flex-end'   => [
                    'title' => esc_html_x('End', 'Flex Container Control', 'elementor'),
                    'icon'  => 'eicon-flex eicon-align-end-v',
                ],
                'stretch'    => [
                    'title' => esc_html_x('Stretch', 'Flex Container Control', 'elementor'),
                    'icon'  => 'eicon-flex eicon-align-stretch-v',
                ],
            ],
            'default'     => 'flex-start',
            'selectors'   => [
                '{{WRAPPER}} ' . $target => 'align-items: {{VALUE}}'
            ]
        ];
        $cond = [];
        if (!empty($condition)) {
            $cond['condition'] = [
                $condition => $condition_value
            ];
        }
        $widget->add_responsive_control($id, array_merge($args, $cond));
    }

    public static function grid_columns($widget, string $id, string $target)
    {
        $widget->add_responsive_control($id, [
            'label'       => 'تعداد ستونها',
            'type'        => Controls_Manager::SELECT,
            'label_block' => false,
            'options'     => [
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
            ],
            'default'     => 1,
            'selectors'   => [
                '{{WRAPPER}} ' . $target => 'grid-template-columns: repeat({{VALUE}}, 1fr)'
            ]
        ]);
    }

    public static function DIVIDER_FIELD($widget, $id, $condition = false, $condition_value = '')
    {
        $args = ['type' => Controls_Manager::DIVIDER];

        if ($condition) {
            $args['condition'] = [
                $condition => $condition_value
            ];
        }
        $widget->add_control($id, $args);
    }

    public static function NOTICE($widget, $id, string $msg, $condition = false, $condition_value = '')
    {
        $args = [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw'  => $msg
        ];

        if ($condition) {
            $args['condition'] = [
                $condition => $condition_value
            ];
        }
        $widget->add_control($id, $args);
    }

    public static function TAB_START($widget, $id)
    {
        $widget->start_controls_tabs($id . '_tab');
        $widget->start_controls_tab($id . '_tab_normal', ['label' => 'حالت عادی']);
    }

    public static function TAB_MIDDLE($widget, $id, $active = false)
    {
        if ($active) {
            $widget->end_controls_tab();
            $widget->start_controls_tab($id . '_tab_active', ['label' => 'حالت فعال']);
        } else {
            $widget->end_controls_tab();
            $widget->start_controls_tab($id . '_tab_hover', ['label' => 'حالت هاور']);
        }
    }

    public static function TAB_MIDDLE_($widget, $id, $title)
    {
        $widget->end_controls_tab();
        $widget->start_controls_tab($id, ['label' => $title]);
    }

    public static function TAB_END($widget)
    {
        $widget->end_controls_tab();
        $widget->end_controls_tabs();
    }

    public static function Separator($widget, string $id, string $title, $condition = false, $condition_value = '')
    {
        self::DIVIDER_FIELD($widget, $id . '_divider_d1', $condition, $condition_value);
        self::HEADING_FIELD($widget, $id . '_divider_heading', $title, $condition, $condition_value);
        self::DIVIDER_FIELD($widget, $id . '_divider_d2', $condition, $condition_value);
    }

    public static function BoxUtils($widget, string $id, string $target, string $parent_target = '', bool $active = false, bool $parent_active = false, bool $font = false)
    {
        if ($font) {
            self::FONT_FIELD($widget, $id . '_font_settings', 'تایپوگرافی', $parent_target . $target);
        }

        self::DIMENSIONS_FIELD($widget, $id . '_margin', 'فاصله بیرونی', $parent_target . $target, 'margin');
        self::DIMENSIONS_FIELD($widget, $id . '_padding', 'فاصله درونی', $parent_target . $target, 'padding');

        $widget->start_controls_tabs($id . '-tab');
        $widget->start_controls_tab($id . '-tab-normal', ['label' => 'حالت عادی']);

        self::COLOR_FIELD($widget, $id . '_color', 'رنگ', '', $parent_target . $target, 'color');
        self::BACKGROUND_FIELD($widget, $id . '_bg', $parent_target . $target);
        self::BORDER_FIELD($widget, $id . '_border', 'حاشیه', $parent_target . $target);
        self::DIMENSIONS_FIELD($widget, $id . '_border_radius', 'گردی حاشیه', $parent_target . $target, 'border-radius');
        self::SHADOW_FIELD($widget, $id . '_shadow', 'سایه', $parent_target . $target);

        $widget->end_controls_tab();
        $widget->start_controls_tab($id . '-tab-hover', ['label' => 'حالت هاور']);

        if (!empty($parent_target)) {
            $parent_target = str_replace(' ', '', $parent_target);

            self::COLOR_FIELD($widget, $id . '_color_hover', 'رنگ', '', $parent_target . ':hover ' . $target, 'color');
            self::BACKGROUND_FIELD($widget, $id . '_bg_hover', $parent_target . ':hover ' . $target);
            self::BORDER_FIELD($widget, $id . '_border_hover', 'حاشیه', $parent_target . ':hover ' . $target);
            self::DIMENSIONS_FIELD($widget, $id . '_border_radius_hover', 'گردی حاشیه', $parent_target . ':hover ' . $target, 'border-radius');
            self::SHADOW_FIELD($widget, $id . '_shadow_hover', 'سایه', $parent_target . ':hover ' . $target);
        } else {
            self::COLOR_FIELD($widget, $id . '_color_hover', 'رنگ', '', $target . ':hover', 'color');
            self::BACKGROUND_FIELD($widget, $id . '_bg_hover', $target . ':hover');
            self::BORDER_FIELD($widget, $id . '_border_hover', 'حاشیه', $target . ':hover');
            self::DIMENSIONS_FIELD($widget, $id . '_border_radius_hover', 'گردی حاشیه', $target . ':hover', 'border-radius');
            self::SHADOW_FIELD($widget, $id . '_shadow_hover', 'سایه', $target . ':hover');
        }

        $widget->end_controls_tab();

        if ($active && !$parent_active) {
            $widget->start_controls_tab($id . '-tab-active', ['label' => 'حالت فعال']);

            self::COLOR_FIELD($widget, $id . '_color_active', 'رنگ', '', $parent_target . $target . '.active', 'color');
            self::BACKGROUND_FIELD($widget, $id . '_bg_active', $parent_target . $target . '.active');
            self::BORDER_FIELD($widget, $id . '_border_active', 'حاشیه', $parent_target . $target . '.active');
            self::DIMENSIONS_FIELD($widget, $id . '_border_radius_active', 'گردی حاشیه', $parent_target . $target . '.active', 'border-radius');
            self::SHADOW_FIELD($widget, $id . '_shadow_active', 'سایه', $parent_target . $target . '.active');

            $widget->end_controls_tab();
        }

        if ($parent_active && !$active) {
            $widget->start_controls_tab($id . '-tab-active', ['label' => 'حالت فعال']);

            self::COLOR_FIELD($widget, $id . '_color_active', 'رنگ', '', $parent_target . '.active ' . $target, 'color');
            self::BACKGROUND_FIELD($widget, $id . '_bg_active', $parent_target . '.active ' . $target);
            self::BORDER_FIELD($widget, $id . '_border_active', 'حاشیه', $parent_target . '.active ' . $target);
            self::DIMENSIONS_FIELD($widget, $id . '_border_radius_active', 'گردی حاشیه', $parent_target . '.active ' . $target, 'border-radius');
            self::SHADOW_FIELD($widget, $id . '_shadow_active', 'سایه', $parent_target . '.active ' . $target);

            $widget->end_controls_tab();
        }

        $widget->end_controls_tabs();
    }

    public static function ButtonUtils($widget, string $id, string $target, string $parent_target = '', bool $active = false, bool $parent_active = false)
    {
        self::SLIDER_FIELD_STYLE($widget, $id . '_width', 'عرض', 20, 200, null, $parent_target . $target, 'width');
        self::SLIDER_FIELD_STYLE($widget, $id . '_height', ' ارتفاع', 20, 100, null, $parent_target . $target, 'height');
        self::FONT_FIELD($widget, $id . '_font_settings', 'فونت', $parent_target . $target);

        self::DIMENSIONS_FIELD($widget, $id . '_margin', 'فاصله بیرونی', $parent_target . $target, 'margin');

        $widget->start_controls_tabs($id . '-tab');
        $widget->start_controls_tab($id . '-tab-normal', ['label' => 'حالت عادی']);

        self::COLOR_FIELD($widget, $id . '_color', 'رنگ', '', $parent_target . $target, 'color');
        self::BACKGROUND_FIELD($widget, $id . '_bg', $parent_target . $target);
        self::BORDER_FIELD($widget, $id . '_border', 'حاشیه', $parent_target . $target);
        self::DIMENSIONS_FIELD($widget, $id . '_border_radius', 'گردی حاشیه', $parent_target . $target, 'border-radius');
        self::SHADOW_FIELD($widget, $id . '_shadow', 'سایه', $parent_target . $target);

        $widget->end_controls_tab();
        $widget->start_controls_tab($id . '-tab-hover', ['label' => 'حالت هاور']);

        if (!empty($parent_target)) {
            $parent_target = str_replace(' ', '', $parent_target);

            self::COLOR_FIELD($widget, $id . '_color_hover', 'رنگ', '', $parent_target . ':hover ' . $target, 'color');
            self::BACKGROUND_FIELD($widget, $id . '_bg_hover', $parent_target . ':hover ' . $target);
            self::BORDER_FIELD($widget, $id . '_border_hover', 'حاشیه', $parent_target . ':hover ' . $target);
            self::DIMENSIONS_FIELD($widget, $id . '_border_radius_hover', 'گردی حاشیه', $parent_target . ':hover ' . $target, 'border-radius');
            self::SHADOW_FIELD($widget, $id . '_shadow_hover', 'سایه', $parent_target . ':hover ' . $target);
        } else {
            self::COLOR_FIELD($widget, $id . '_color_hover', 'رنگ', '', $target . ':hover', 'color');
            self::BACKGROUND_FIELD($widget, $id . '_bg_hover', $target . ':hover');
            self::BORDER_FIELD($widget, $id . '_border_hover', 'حاشیه', $target . ':hover');
            self::DIMENSIONS_FIELD($widget, $id . '_border_radius_hover', 'گردی حاشیه', $target . ':hover', 'border-radius');
            self::SHADOW_FIELD($widget, $id . '_shadow_hover', 'سایه', $target . ':hover');
        }

        $widget->end_controls_tab();

        if ($active && !$parent_active) {
            $widget->start_controls_tab($id . '-tab-active', ['label' => 'حالت فعال']);

            self::COLOR_FIELD($widget, $id . '_color_active', 'رنگ', '', $parent_target . $target . '.active', 'color');
            self::BACKGROUND_FIELD($widget, $id . '_bg_active', $parent_target . $target . '.active');
            self::BORDER_FIELD($widget, $id . '_border_active', 'حاشیه', $parent_target . $target . '.active');
            self::DIMENSIONS_FIELD($widget, $id . '_border_radius_active', 'گردی حاشیه', $parent_target . $target . '.active', 'border-radius');
            self::SHADOW_FIELD($widget, $id . '_shadow_active', 'سایه', $parent_target . $target . '.active');

            $widget->end_controls_tab();
        }

        if ($parent_active && !$active) {
            $widget->start_controls_tab($id . '-tab-active', ['label' => 'حالت فعال']);

            self::COLOR_FIELD($widget, $id . '_color_active', 'رنگ', '', $parent_target . '.active ' . $target, 'color');
            self::BACKGROUND_FIELD($widget, $id . '_bg_active', $parent_target . '.active ' . $target);
            self::BORDER_FIELD($widget, $id . '_border_active', 'حاشیه', $parent_target . '.active ' . $target);
            self::DIMENSIONS_FIELD($widget, $id . '_border_radius_active', 'گردی حاشیه', $parent_target . '.active ' . $target, 'border-radius');
            self::SHADOW_FIELD($widget, $id . '_shadow_active', 'سایه', $parent_target . '.active ' . $target);

            $widget->end_controls_tab();
        }

        $widget->end_controls_tabs();
    }

    public static function IconUtils($widget, string $id, string $target, string $parent_target = '', bool $active = false, bool $parent_active = false)
    {
        if (!empty($parent_target)) {
            $parent_target .= ' ';
        }

        self::SLIDER_FIELD_STYLE($widget, $id . '_icon_width', 'عرض باکس', 20, 100, null, $parent_target . $target, 'width');
        self::SLIDER_FIELD_STYLE($widget, $id . '_icon_height', 'ارتفاع باکس', 20, 100, null, $parent_target . $target, 'height');
        self::DIMENSIONS_FIELD($widget, $id . '_margin', 'فاصله بیرونی', $parent_target . $target, 'margin');
        self::DIMENSIONS_FIELD($widget, $id . '_padding', 'فاصله درونی', $parent_target . $target, 'padding');

        /**
         * Normal State
         */
        $widget->start_controls_tabs($id . '-tab');
        $widget->start_controls_tab($id . '-tab-normal', ['label' => 'حالت عادی']);

        $widget->add_responsive_control($id . '_icon_font_size', [
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
                '{{WRAPPER}} ' . $parent_target . $target . ' i'   => 'font-size: {{SIZE}}px;',
                '{{WRAPPER}} ' . $parent_target . $target . ' svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                '{{WRAPPER}} ' . $parent_target . $target . ' img' => 'width: {{SIZE}}px;',
            ],
        ]);
        $widget->add_control($id . '_icon_color', [
            'label'       => 'رنگ',
            'label_block' => false,
            'type'        => \Elementor\Controls_Manager::COLOR,
            'selectors'   => [
                '{{WRAPPER}} ' . $parent_target . $target . ' i'   => 'color: {{VALUE}};',
                '{{WRAPPER}} ' . $parent_target . $target . ' svg' => 'fill: {{VALUE}};',
            ]
        ]);
        $widget->add_control($id . '_icon_path_color', [
            'label'       => 'رنگ path',
            'label_block' => false,
            'type'        => \Elementor\Controls_Manager::COLOR,
            'selectors'   => [
                '{{WRAPPER}} ' . $parent_target . $target . ' svg path' => 'fill: {{VALUE}};',
            ]
        ]);

        self::BACKGROUND_FIELD($widget, $id . '_icon_box_bg', $parent_target . $target);
        self::BORDER_FIELD($widget, $id . '_icon_box_border', 'حاشیه', $parent_target . $target);
        self::DIMENSIONS_FIELD($widget, $id . '_icon_box_border_radius', 'خمیدگی', $parent_target . $target, 'border-radius');
        self::SHADOW_FIELD($widget, $id . '_icon_box_shadow', 'سایه', $parent_target . $target);

        $widget->end_controls_tab();

        /**
         * Hover State
         */
        $widget->start_controls_tab($id . '-tab-hover', ['label' => 'حالت هاور']);

        if (!empty($parent_target)) {
            $parent_target = str_replace(' ', '', $parent_target);

            $widget->add_responsive_control($id . '_icon_font_size_hover', [
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
                    '{{WRAPPER}} ' . $parent_target . ':hover ' . $target . ' i'   => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} ' . $parent_target . ':hover ' . $target . ' svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                    '{{WRAPPER}} ' . $parent_target . ':hover ' . $target . ' img' => 'width: {{SIZE}}px;',
                ],
            ]);
            $widget->add_control($id . '_icon_color_hover', [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} ' . $parent_target . ':hover ' . $target . ' i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $parent_target . ':hover ' . $target . ' svg' => 'fill: {{VALUE}};',
                ]
            ]);
            $widget->add_control($id . '_icon_path_color_hover', [
                'label'       => 'رنگ path',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} ' . $parent_target . ':hover ' . $target . ' svg path' => 'fill: {{VALUE}};',
                ]
            ]);
            self::BACKGROUND_FIELD($widget, $id . '_icon_box_bg_hover', $parent_target . ':hover ' . $target);
            self::BORDER_FIELD($widget, $id . '_icon_box_border_hover', 'حاشیه', $parent_target . ':hover ' . $target);
            self::DIMENSIONS_FIELD($widget, $id . '_icon_box_border_radius_hover', 'خمیدگی', $parent_target . ':hover ' . $target, 'border-radius');
            self::SHADOW_FIELD($widget, $id . '_icon_box_shadow_hover', 'سایه', $parent_target . ':hover ' . $target);
        } else {
            $widget->add_responsive_control($id . '_icon_font_size_hover', [
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
                    '{{WRAPPER}} ' . $target . ':hover' . ' i'   => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} ' . $target . ':hover' . ' svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                    '{{WRAPPER}} ' . $target . ':hover' . ' img' => 'width: {{SIZE}}px;',
                ],
            ]);
            $widget->add_control($id . '_icon_color_hover', [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} ' . $target . ':hover' . ' i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $target . ':hover' . ' svg' => 'fill: {{VALUE}};',
                ]
            ]);
            $widget->add_control($id . '_icon_path_color_hover', [
                'label'       => 'رنگ path',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} ' . $target . ':hover' . ' svg path' => 'fill: {{VALUE}};',
                ]
            ]);
            self::BACKGROUND_FIELD($widget, $id . '_icon_box_bg_hover', $target . ':hover');
            self::BORDER_FIELD($widget, $id . '_icon_box_border_hover', 'حاشیه', $target . ':hover');
            self::DIMENSIONS_FIELD($widget, $id . '_icon_box_border_radius_hover', 'خمیدگی', $target . ':hover', 'border-radius');
            self::SHADOW_FIELD($widget, $id . '_icon_box_shadow_hover', 'سایه', $target . ':hover');
        }

        $widget->end_controls_tab();

        if ($active && !$parent_active) {
            $widget->start_controls_tab($id . '-tab-active', ['label' => 'حالت فعال']);

            $widget->add_responsive_control($id . '_icon_font_size_active', [
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
                    '{{WRAPPER}} ' . $parent_target . $target . '.active' . ' i'   => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} ' . $parent_target . $target . '.active' . ' svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                    '{{WRAPPER}} ' . $parent_target . $target . '.active' . ' img' => 'width: {{SIZE}}px;',
                ],
            ]);
            $widget->add_control($id . '_icon_color_active', [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} ' . $parent_target . $target . '.active' . ' i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $parent_target . $target . '.active' . ' svg' => 'fill: {{VALUE}};',
                ]
            ]);
            $widget->add_control($id . '_icon_path_color_active', [
                'label'       => 'رنگ path',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} ' . $parent_target . $target . '.active' . ' svg path' => 'fill: {{VALUE}};',
                ]
            ]);
            self::BACKGROUND_FIELD($widget, $id . '_icon_box_bg_active', $parent_target . $target . '.active');
            self::BORDER_FIELD($widget, $id . '_icon_box_border_active', 'حاشیه', $parent_target . $target . '.active');
            self::DIMENSIONS_FIELD($widget, $id . '_icon_box_border_radius_active', 'خمیدگی', $parent_target . $target . '.active', 'border-radius');
            self::SHADOW_FIELD($widget, $id . '_icon_box_shadow_active', 'سایه', $parent_target . $target . '.active');

            $widget->end_controls_tab();
        }

        if ($parent_active && !$active) {
            $widget->start_controls_tab($id . '-tab-active', ['label' => 'حالت فعال']);

            $widget->add_responsive_control($id . '_icon_font_size_active', [
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
                    '{{WRAPPER}} ' . $parent_target . '.active ' . $target . ' i'   => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} ' . $parent_target . '.active ' . $target . ' svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                    '{{WRAPPER}} ' . $parent_target . '.active ' . $target . ' img' => 'width: {{SIZE}}px;',
                ],
            ]);
            $widget->add_control($id . '_icon_color_active', [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} ' . $parent_target . '.active ' . $target . ' i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $parent_target . '.active ' . $target . ' svg' => 'fill: {{VALUE}};',
                ]
            ]);

            $widget->add_control($id . '_icon_path_color_active', [
                'label'       => 'رنگ path',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} ' . $parent_target . '.active ' . $target . ' svg path' => 'fill: {{VALUE}};',
                ]
            ]);
            self::BACKGROUND_FIELD($widget, $id . '_icon_box_bg_active', $parent_target . '.active ' . $target);
            self::BORDER_FIELD($widget, $id . '_icon_box_border_active', 'حاشیه', $parent_target . '.active ' . $target);
            self::DIMENSIONS_FIELD($widget, $id . '_icon_box_border_radius_active', 'خمیدگی', $parent_target . '.active ' . $target, 'border-radius');
            self::SHADOW_FIELD($widget, $id . '_icon_box_shadow_active', 'سایه', $parent_target . '.active ' . $target);

            $widget->end_controls_tab();
        }

        $widget->end_controls_tabs();
    }

    public static function IconUtilsLight($widget, string $id, string $target, string $attached_to_title = '')
    {
        $widget->add_responsive_control($id . '_icon_size', [
            'label'      => 'اندازه' . $attached_to_title,
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min' => 10,
                    'max' => 200,
                ],
            ],
            'selectors'  => [
                '{{WRAPPER}} ' . $target . ' i'   => 'font-size: {{SIZE}}px;',
                '{{WRAPPER}} ' . $target . ' svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                '{{WRAPPER}} ' . $target . ' img' => 'width: {{SIZE}}px;',
            ],
        ]);
        $widget->add_control($id . '_icon_color', [
            'label'       => 'رنگ' . $attached_to_title,
            'label_block' => false,
            'type'        => \Elementor\Controls_Manager::COLOR,
            'selectors'   => [
                '{{WRAPPER}} ' . $target . ' i'   => 'color: {{VALUE}};',
                '{{WRAPPER}} ' . $target . ' svg' => 'fill: {{VALUE}};',
            ]
        ]);
    }

    public static function TextUtils($widget, string $id, string $target, bool $hover = false, bool $has_svg_icon = false, $condition = false, $condition_value = '')
    {
        self::FONT_FIELD($widget, $id . '_font', 'فونت', $target, $condition, $condition_value);
        self::COLOR_FIELD($widget, $id . '_color', 'رنگ', '', $target, 'color', $condition, $condition_value);
        if ($hover) {
            self::COLOR_FIELD($widget, $id . '_color_hover', 'رنگ هاور', '', $target . ':hover', 'color', $condition, $condition_value);
        }
        if ($has_svg_icon) {
            self::COLOR_FIELD($widget, $id . '_icon_color', 'رنگ آیکون', '', $target . ' svg', 'fill', $condition, $condition_value);
            if ($hover) {
                self::COLOR_FIELD($widget, $id . '_icon_color_hover', 'رنگ آیکون هاور', '', $target . ':hover svg', 'fill', $condition, $condition_value);
            }
        }
    }


    /**
     * @param          $widget
     * @param string $id
     * @param string $target
     * @param array $ELEMENTS -> pattern => ['element-name' => 'human-readable-name']
     *
     * @return void
     */
    public static function VariantUtils($widget, string $id, string $target, array $ELEMENTS)
    {
        $init_target = $target;

        foreach ($ELEMENTS as $ELEMENT) {
            $uniq = '';
            if (!empty($ELEMENT['uniq'])) {
                $uniq = $ELEMENT['uniq'];
            }

            if (!empty($ELEMENT['target'])) {
                $target = $ELEMENT['target'];
            } else {
                $target = $init_target;
            }

            $def = '';
            if (!empty($ELEMENT['def'])) {
                $def = $ELEMENT['def'];
            }

            $condition = false;
            $condition_value = '';
            if (!empty($ELEMENT['cond'])) {
                $condition = $ELEMENT['cond'];
                $condition_value = $ELEMENT['cond_val'];
            }

            switch ($ELEMENT['type']) {
                case '4dir':
                    self::DIMENSIONS_FIELD($widget, $id . '-dimension-' . $ELEMENT['css'] . '-' . $uniq, $ELEMENT['title'], $target, $ELEMENT['css'], $condition, $condition_value);
                    break;

                case 'slider':
                    self::SLIDER_FIELD_STYLE($widget, $id . '-slider-' . $ELEMENT['css'] . '-' . $uniq, $ELEMENT['title'], $ELEMENT['min'], $ELEMENT['max'], $def, $target, $ELEMENT['css'], $condition, $condition_value);
                    break;

                case 'bg':
                    self::BACKGROUND_FIELD($widget, $id . '-bg-' . $uniq, $target, $condition, $condition_value);
                    break;

                case 'bg-c':
                    self::BACKGROUND_WO_IMG_FIELD($widget, $id . '-bg-' . $uniq, $target, $condition, $condition_value);
                    break;

                case 'color':
                    self::COLOR_FIELD($widget, $id . '-color-' . $uniq, $ELEMENT['title'], $def, $target, 'color', $condition, $condition_value);
                    break;

                case 'color-v':
                    self::COLOR_FIELD($widget, $id . '-color-bg-' . $uniq, $ELEMENT['title'], $def, $target, $ELEMENT['css'], $condition, $condition_value);
                    break;

                case 'border':
                    self::BORDER_FIELD($widget, $id . '-border-' . $uniq, $ELEMENT['title'], $target, $condition, $condition_value);
                    break;

                case 'shadow':
                    self::SHADOW_FIELD($widget, $id . '-box-shadow-' . $uniq, $ELEMENT['title'], $target, $condition, $condition_value);
                    break;

                case 'font':
                    self::FONT_FIELD($widget, $id . '-font-' . $uniq, $ELEMENT['title'], $target, $condition, $condition_value);
                    break;

                case 'text-align':
                    self::TEXT_ALIGNMENT($widget, $id . '-txt-alignment-' . $uniq, $target, $condition, $condition_value);
                    break;

                case 'sep':
                    self::DIVIDER_FIELD($widget, $id . '-divider-d1-' . $uniq, $condition, $condition_value);
                    self::HEADING_FIELD($widget, $id . '-heading-' . $uniq, $ELEMENT['title'], $condition, $condition_value);
                    self::DIVIDER_FIELD($widget, $id . '-divider-d2-' . $uniq, $condition, $condition_value);
                    break;

                case 'box-styles':
                    self::DIMENSIONS_FIELD($widget, $id . '-dimension-padding' . '-' . $uniq, 'فاصله داخلی', $target, 'padding');
                    self::DIMENSIONS_FIELD($widget, $id . '-dimension-margin' . '-' . $uniq, 'فاصله بیرونی', $target, 'margin');
                    self::DIMENSIONS_FIELD($widget, $id . '-dimension-border-radius' . '-' . $uniq, 'خمیدگی', $target, 'border-radius');
                    self::BACKGROUND_FIELD($widget, $id . '-bg-' . $uniq, $target);
                    self::BORDER_FIELD($widget, $id . '-border-' . $uniq, 'خط دور', $target);
                    self::SHADOW_FIELD($widget, $id . '-box-shadow-' . $uniq, 'سایه', $target);

                    break;

                case 'text':
                    self::FONT_FIELD($widget, $id . '-font-' . $uniq, 'تایپوگرافی', $target, $condition, $condition_value);

                    self::FONT_STROKE_FIELD($widget, $id . '-font-strok-' . $uniq, $target, $condition, $condition_value);

                    self::TEXT_ALIGNMENT($widget, $id . '-text-alignment-' . $uniq, $target, $condition, $condition_value);

                    self::COLOR_FIELD($widget, $id . '-color-' . $uniq, 'رنگ', $def, $target, 'color', $condition, $condition_value);
                    break;

                case 'text-small':
                    self::FONT_FIELD($widget, $id . '-font-' . $uniq, 'تایپوگرافی', $target, $condition, $condition_value);

                    self::COLOR_FIELD($widget, $id . '-color-' . $uniq, 'رنگ', $def, $target, 'color', $condition, $condition_value);
                    break;

                case 'tab-start':
                    self::TAB_START($widget, $id . '-start-' . $uniq);
                    break;
                case 'tab-end':
                    self::TAB_END($widget);
                    break;
                case 'tab-middle':
                    self::TAB_MIDDLE_($widget, $id . '-middle-' . $uniq, $ELEMENT['title']);
                    break;
            }

            $target = $init_target;
        }
    }

    public static function DynamicStyleControls($widget, string $id, string $target, $controls)
    {

        foreach ($controls as $control) {
            switch ($control) {
                case 'font':
                case 'typography':
                    self::FONT_FIELD($widget, $id . '_typography', 'تایپوگرافی', $target);
                    break;
                case 'padding':
                    self::DIMENSIONS_FIELD($widget, $id . '_padding', 'فاصله داخلی', $target, 'padding');
                    break;
                case 'margin':
                    self::DIMENSIONS_FIELD($widget, $id . '_margin', 'فاصله خارجی', $target, 'margin');
                    break;
                case 'border':
                    self::BORDER_FIELD($widget, $id . '_border', 'حاشیه', $target);
                    break;
                case 'border-radius':
                case 'border_radius':
                case 'radius':
                    self::DIMENSIONS_FIELD($widget, $id . '_border_radius', 'خمیدگی', $target, 'border-radius');
                    break;
                case 'shadow':
                case 'box-shadow':
                case 'box_shadow':
                    self::SHADOW_FIELD($widget, $id . '_box_shadow', 'سایه', $target);
                    break;
                case 'color':
                case 'rang':
                    self::COLOR_FIELD($widget, $id . '_color', 'رنگ', '', $target, 'color');
                    break;
                case 'bg':
                case 'background':
                    self::BACKGROUND_WO_IMG_FIELD($widget, $id . '_bg', $target);
                    break;
            }
        }

    }

    public static function SameWithHeight($widget, string $id, string $target, int $min = 50, int $max = 150, int $default = 50, $condition = false, $condition_value = '')
    {
        $control_args = [
            'label'       => 'عرض و ارتفاع',
            'type'        => Controls_Manager::SLIDER,
            'label_block' => true,
            'size_units'  => ['px'],
            'range'       => [
                'px' => [
                    'min' => $min,
                    'max' => $max,
                ],
            ],
            'selectors'   => [
                '{{WRAPPER}} ' . $target => 'width: {{SIZE}}px;height: {{SIZE}}px;',
            ],
        ];

        if (!is_null($default)) {
            $control_args['default'] = ['size' => $default];
        }

        if ($condition !== false) {
            $control_args['condition'] = [
                $condition => $condition_value
            ];
        }

        $widget->add_responsive_control($id, $control_args);
    }
}
