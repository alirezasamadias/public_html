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

class AE_E_UTILS{

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

    public static function NUMBER_FIELD_STYLE($widget, string $id, string $title, string $target, string $selector, $min = 0, $max = 100, $step = 1, $default = 5, $dynamic = false, $condition = false, $condition_value = '')
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
                '{{WRAPPER}} ' . $target => $selector . ':{{VALUE}};'
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
                'size' => $default,
                'unit' => '%'
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

    public static function ICON_PRINT($widget, $settings, $icon_id, $class = '', bool $echo = true)
    {
        $html = '';
        $migrated = isset($settings['__fa4_migrated'][$icon_id . 'selected_icon']);
        $is_new = empty($settings[$icon_id . 'icon']) && Icons_Manager::is_migration_allowed();

        if ('icon' == $settings[$icon_id . 'icon_type']) {
            if (!empty($settings[$icon_id . 'icon_type']) && !empty($settings[$icon_id . 'selected_icon']['value'])) {
                $html .= '<div class="icon ' . $class . ' dfx jcc aic">';
            }

            if ($is_new || $migrated) {
                $html .= Icons_Manager::try_get_icon_html($settings[$icon_id . 'selected_icon'], ['aria-hidden' => 'true']);
            } else {
                $html .= '<i ' . $widget->get_render_attribute_string('font-icon') . '></i>';
            }

            if (!empty($settings[$icon_id . 'icon_type']) && !empty($settings[$icon_id . 'selected_icon']['value'])) {
                $html .= '</div>';
            }
        } elseif ('image' == $settings[$icon_id . 'icon_type']) {
            $html .= '<div class="icon ' . $class . ' dfx jcc aic">';
            $html .= '<img src="' . $settings[$icon_id . 'image']['url'] . '" alt="' . $settings[$icon_id . 'image_alt'] . '">';
            $html .= '</div>';
        }

        if ($echo) {
            echo $html;
        } else {
            return $html;
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
            if (substr($parent_target, 0, -1) === ' ') {
                $parent_target = str_replace(' ', '', $parent_target);
            }

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

    public static function IconUtilsLight($widget, string $id, string $target, string $attached_to_title = '', $hover = false)
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
        if ($hover) {
            $widget->add_control($id . '_icon_color_hover', [
                'label'       => 'رنگ هاور' . $attached_to_title,
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} ' . $target . ':hover i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $target . ':hover svg' => 'fill: {{VALUE}};',
                ]
            ]);
        }
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

    public static function SameWithHeight($widget, string $id, string $target, int $min = 50, int $max = 150, $default = 50, $condition = false, $condition_value = '')
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

    public static function TomanSvg()
    {
        return '<svg viewBox="0 0 15 16" fill="#222" xmlns="http://www.w3.org/2000/svg" width="20" height="20"><path d="M1.96758 6.55C2.24091 6.55 2.48091 6.50667 2.68758 6.42C2.89424 6.34 3.06424 6.23 3.19758 6.09C3.33758 5.95 3.44424 5.78667 3.51758 5.6C3.59091 5.41333 3.63424 5.21333 3.64758 5H2.79758C2.45758 5 2.17758 4.96333 1.95758 4.89C1.73758 4.81667 1.56424 4.71 1.43758 4.57C1.31091 4.43 1.22091 4.26 1.16758 4.06C1.12091 3.85333 1.09758 3.62333 1.09758 3.37C1.09758 3.11667 1.13424 2.87667 1.20758 2.65C1.28091 2.41667 1.38758 2.21333 1.52758 2.04C1.66758 1.86667 1.84091 1.73 2.04758 1.63C2.26091 1.52333 2.50758 1.47 2.78758 1.47C3.00758 1.47 3.21758 1.50667 3.41758 1.58C3.62424 1.65333 3.80424 1.77 3.95758 1.93C4.11091 2.08333 4.23091 2.28667 4.31758 2.54C4.41091 2.79333 4.45758 3.1 4.45758 3.46V4.12H5.34758C5.42758 4.12 5.48091 4.15667 5.50758 4.23C5.54091 4.29667 5.55758 4.40333 5.55758 4.55C5.55758 4.70333 5.54091 4.81667 5.50758 4.89C5.48091 4.96333 5.42758 5 5.34758 5H4.43758C4.42424 5.32667 4.35758 5.63667 4.23758 5.93C4.12424 6.22333 3.96424 6.48 3.75758 6.7C3.55091 6.92 3.30091 7.09333 3.00758 7.22C2.71424 7.35333 2.38758 7.42 2.02758 7.42H0.987578L0.927578 6.55H1.96758ZM1.87758 3.32C1.87758 3.60667 1.94424 3.81333 2.07758 3.94C2.21758 4.06 2.48424 4.12 2.87758 4.12H3.66758V3.5C3.66758 3.08 3.58425 2.78 3.41758 2.6C3.25758 2.41333 3.03091 2.32 2.73758 2.32C2.46424 2.32 2.25091 2.41 2.09758 2.59C1.95091 2.76333 1.87758 3.00667 1.87758 3.32ZM7.00156 4.12C7.08823 4.12 7.1449 4.15667 7.17156 4.23C7.2049 4.29667 7.22156 4.40333 7.22156 4.55C7.22156 4.70333 7.2049 4.81667 7.17156 4.89C7.1449 4.96333 7.08823 5 7.00156 5H5.35156C5.2649 5 5.20823 4.96667 5.18156 4.9C5.14823 4.82667 5.13156 4.72 5.13156 4.58C5.13156 4.42 5.14823 4.30333 5.18156 4.23C5.20823 4.15667 5.2649 4.12 5.35156 4.12H7.00156ZM8.65195 4.12C8.73862 4.12 8.79529 4.15667 8.82195 4.23C8.85529 4.29667 8.87195 4.40333 8.87195 4.55C8.87195 4.70333 8.85529 4.81667 8.82195 4.89C8.79529 4.96333 8.73862 5 8.65195 5H7.00195C6.91529 5 6.85862 4.96667 6.83195 4.9C6.79862 4.82667 6.78195 4.72 6.78195 4.58C6.78195 4.42 6.79862 4.30333 6.83195 4.23C6.85862 4.15667 6.91529 4.12 7.00195 4.12H8.65195ZM10.3023 4.12C10.389 4.12 10.4457 4.15667 10.4723 4.23C10.5057 4.29667 10.5223 4.40333 10.5223 4.55C10.5223 4.70333 10.5057 4.81667 10.4723 4.89C10.4457 4.96333 10.389 5 10.3023 5H8.65234C8.56568 5 8.50901 4.96667 8.48234 4.9C8.44901 4.82667 8.43234 4.72 8.43234 4.58C8.43234 4.42 8.44901 4.30333 8.48234 4.23C8.50901 4.15667 8.56568 4.12 8.65234 4.12H10.3023ZM11.9527 4.12C12.0394 4.12 12.0961 4.15667 12.1227 4.23C12.1561 4.29667 12.1727 4.40333 12.1727 4.55C12.1727 4.70333 12.1561 4.81667 12.1227 4.89C12.0961 4.96333 12.0394 5 11.9527 5H10.3027C10.2161 5 10.1594 4.96667 10.1327 4.9C10.0994 4.82667 10.0827 4.72 10.0827 4.58C10.0827 4.42 10.0994 4.30333 10.1327 4.23C10.1594 4.15667 10.2161 4.12 10.3027 4.12H11.9527ZM12.8631 4.12C13.1031 4.12 13.2898 4.05667 13.4231 3.93C13.5631 3.80333 13.6331 3.62333 13.6331 3.39V2.11H14.4531V3.43C14.4531 3.93667 14.3165 4.32667 14.0431 4.6C13.7765 4.86667 13.4031 5 12.9231 5H11.9531C11.8665 5 11.8098 4.96667 11.7831 4.9C11.7498 4.82667 11.7331 4.72 11.7331 4.58C11.7331 4.42 11.7498 4.30333 11.7831 4.23C11.8098 4.15667 11.8665 4.12 11.9531 4.12H12.8631ZM14.5231 0.88H13.6131V0.0399998H14.5231V0.88ZM13.1831 0.88H12.2731V0.0399998H13.1831V0.88ZM5.64703 12.77C5.64703 13.1367 5.58703 13.48 5.46703 13.8C5.3537 14.1267 5.19036 14.41 4.97703 14.65C4.7637 14.89 4.5037 15.0767 4.19703 15.21C3.89036 15.35 3.54703 15.42 3.16703 15.42H2.55703C1.81036 15.42 1.23036 15.19 0.817031 14.73C0.403698 14.27 0.197031 13.64 0.197031 12.84V11.07H1.00703V12.81C1.00703 13.33 1.13703 13.75 1.39703 14.07C1.65703 14.39 2.0837 14.55 2.67703 14.55H3.11703C3.41703 14.55 3.6737 14.5033 3.88703 14.41C4.10703 14.3167 4.28703 14.19 4.42703 14.03C4.56703 13.87 4.67036 13.6833 4.73703 13.47C4.8037 13.2567 4.83703 13.0333 4.83703 12.8V10.11H5.64703V12.77ZM3.26703 9.92H2.28703V9.06H3.26703V9.92ZM8.23117 13C8.05117 13 7.87784 12.9767 7.71117 12.93C7.54451 12.8767 7.39784 12.79 7.27117 12.67C7.15117 12.55 7.05451 12.3933 6.98117 12.2C6.90784 12 6.87117 11.7533 6.87117 11.46V6.8H7.69117V11.28C7.69117 11.5333 7.74451 11.7367 7.85117 11.89C7.96451 12.0433 8.14117 12.12 8.38117 12.12H8.58117C8.72784 12.12 8.80117 12.2633 8.80117 12.55C8.80117 12.85 8.72784 13 8.58117 13H8.23117ZM10.234 12.12C10.3207 12.12 10.3773 12.1567 10.404 12.23C10.4373 12.2967 10.454 12.4033 10.454 12.55C10.454 12.7033 10.4373 12.8167 10.404 12.89C10.3773 12.9633 10.3207 13 10.234 13H8.58398C8.49732 13 8.44065 12.9667 8.41398 12.9C8.38065 12.8267 8.36398 12.72 8.36398 12.58C8.36398 12.42 8.38065 12.3033 8.41398 12.23C8.44065 12.1567 8.49732 12.12 8.58398 12.12H10.234ZM10.3644 12.12C10.871 12.12 11.1244 11.9067 11.1244 11.48V11.17C11.1244 10.6033 11.271 10.1567 11.5644 9.83C11.8644 9.49667 12.2777 9.33 12.8044 9.33C13.0777 9.33 13.3177 9.37667 13.5244 9.47C13.731 9.55667 13.9044 9.68 14.0444 9.84C14.1844 10 14.2877 10.1933 14.3544 10.42C14.4277 10.64 14.4644 10.8833 14.4644 11.15C14.4644 11.7367 14.3144 12.1933 14.0144 12.52C13.7144 12.84 13.301 13 12.7744 13C12.5077 13 12.251 12.95 12.0044 12.85C11.7644 12.7433 11.5777 12.5667 11.4444 12.32C11.3844 12.46 11.311 12.5767 11.2244 12.67C11.1377 12.7567 11.0477 12.8267 10.9544 12.88C10.861 12.9267 10.761 12.96 10.6544 12.98C10.5544 12.9933 10.4577 13 10.3644 13H10.2344C10.1477 13 10.091 12.9667 10.0644 12.9C10.031 12.8267 10.0144 12.72 10.0144 12.58C10.0144 12.42 10.031 12.3033 10.0644 12.23C10.091 12.1567 10.1477 12.12 10.2344 12.12H10.3644ZM13.6644 11.21C13.6644 10.9167 13.5977 10.6767 13.4644 10.49C13.3377 10.3033 13.111 10.21 12.7844 10.21C12.4844 10.21 12.261 10.3 12.1144 10.48C11.9744 10.66 11.9044 10.9133 11.9044 11.24C11.9044 11.5333 11.9844 11.7533 12.1444 11.9C12.311 12.0467 12.521 12.12 12.7744 12.12C13.0744 12.12 13.2977 12.0433 13.4444 11.89C13.591 11.73 13.6644 11.5033 13.6644 11.21Z"></path></svg>';
    }

    public static function StarSvg($class = '')
    {
        $svg = '<svg ';
        if (!empty($class)) {
            $svg .= 'class="' . $class . '" ';
        }
        $svg .= 'xmlns="http://www.w3.org/2000/svg" fill="#222" viewBox="0 0 24 24"><path d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z"></path></svg>';
        return $svg;
    }

}
