<?php

namespace Elementor;

use RP_Utils;

defined('ABSPATH') || die();

class NaderAnimatedTitle extends Widget_Base
{

    public function get_script_depends()
    {
        wp_register_script('nader-animated-headline-widget', NADER_ELEMENTOR_JS_DIR . 'nader-animated-headline.js', ['jquery'], '1.0.0', true);
        return ['jquery', 'nader-animated-headline-widget'];
    }

    public function get_name()
    {
        return 'NaderAnimatedTitle';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : عنوان انیمیشنی';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-t-letter';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        RP_Utils::TXT_FIELD($this, 'title', 'عنوان', 'عنوان', true);
        RP_Utils::HTML_TAG($this, 'title-tag', 'عنوان');

        RP_Utils::SELECT_FIELD($this,
            'split-type',
            'نوع جداسازی',
            [
                'FULL' => 'کامل',
                'WORD' => 'کلمه به کلمه',
                'CHAR' => 'حرف به حرف'
            ],
            'WORD'
        );
        RP_Utils::SELECT_FIELD($this,
            'direction',
            'جهت فاصله',
            [
                'top'    => 'بالا',
                'bottom' => 'پایین',
                'left'   => 'چپ',
                'right'  => 'راست',
            ],
            'bottom'
        );
        $this->add_control('direction-distance', [
            'label'       => 'فاصله',
            'type'        => Controls_Manager::NUMBER,
            'label_block' => false,
            'min'         => 10,
            'max'         => 50,
            'step'        => 1,
            'default'     => 20,
            'selectors'   => [
                '{{WRAPPER}} .nader-animated-headline .nader-animated-headline-title span' => '{{direction.VALUE}}: {{VALUE}}px',
            ],
        ]);

        RP_Utils::NUMBER_FIELD($this,
            'delay',
            'تاخیر اولیه',
            0,
            2000,
            10,
            300,
            true
        );
        RP_Utils::NUMBER_FIELD($this, 'speed', 'سرعت اضافه شدن', 0, 1000, 1, 150, true);

        $this->add_control('animation-speed', [
            'label'       => 'سرعت انیمیشن css',
            'type'        => Controls_Manager::NUMBER,
            'label_block' => false,
            'min'         => 0,
            'max'         => 1500,
            'step'        => 10,
            'default'     => 300,
            'selectors'   => [
                '{{WRAPPER}} .nader-animated-headline .nader-animated-headline-title span' => 'transition: all {{VALUE/1000}}ms',
            ],
        ]);

        $this->end_controls_section();


        $this->start_controls_section('style', [
            'label' => 'استایل',
            'tab'   => Controls_Manager::TAB_STYLE
        ]);
        $styles = [
            [
                'type' => 'text'
            ]
        ];
        RP_Utils::VariantUtils($this,
            'styles',
            '.nader-animated-headline .nader-animated-headline-title',
            $styles
        );
        $this->end_controls_section();
    }

    private function generate_text($string)
    {
        $settings   = $this->get_settings_for_display();
        $split_type = $settings['split-type'];

        $text_array = [];
        $output     = '';

        if ($split_type === 'WORD') {
            $text_array = explode(' ', $string);

            foreach ($text_array as $text) {
                $output .= '<span>' . esc_html($text) . '</span>';
                if (end($text_array) !== $text) {
                    $output .= '<span class="space"> </span>';
                }
            }
        }

        if ($split_type === 'CHAR') {
            for ($i = 0; $i < strlen($string); ++$i) {
                if (function_exists('mb_substr')) {
                    $text_array[] = mb_substr($string, $i, 1, 'UTF-8');
                } else {
                    $text_array[] = substr($string, $i, 1, 'UTF-8');
                }
            }

            foreach ($text_array as $ch) {
                if ($ch === '') {
                    continue;
                }

                if ($ch === ' ') {
                    $output .= '<span class="space"> </span>';
                } else {
                    $output .= '<span>' . esc_html($ch) . '</span>';
                }
            }
        }

        if ($split_type === 'FULL') {
            $output .= '<span>' . $string . '</span>';
        }

        return $output;
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $title    = $settings['title'];

        if (!empty($title)) {
            $tt        = $settings['title-tag'];
            $delay     = $settings['delay'];
            $speed     = $settings['speed'];
            $direction = $settings['direction'];

            $text = $this->generate_text($title);

            ?>

            <div class="nader-animated-headline dir-<?php echo esc_html($direction
            ); ?>"
                 data-delay="<?php echo esc_html($delay); ?>"
                 data-speed="<?php echo esc_html($speed); ?>">
                <?php
                echo '<' . $tt . ' class="nader-animated-headline-title">';
                echo $text;
                echo '</' . $tt . '>';
                ?>
            </div>

            <?php
        }
    }

}

Plugin::instance()->widgets_manager->register(new NaderAnimatedTitle());
