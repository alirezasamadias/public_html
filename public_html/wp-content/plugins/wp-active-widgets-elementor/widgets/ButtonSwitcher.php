<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_ButtonSwitcher extends \Elementor\Widget_Base{

    public function get_script_depends()
    {
        wp_register_script('wp-active-we-button-switcher', AE_E_JS_DIR . 'button-switcher.js', ['jquery'], '1.0.0', true);
        return ['jquery', 'wp-active-we-button-switcher'];
    }

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-fancy-button', AE_E_CSS_DIR . 'fancy-button.css',);
        return ['wp-active-we-fancy-button'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'switcher دکمه ';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-button';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        AE_E_UTILS::SECTION_START($this, 'settings', 'تنظیمات');

        $buttons = new \Elementor\Repeater();
        AE_E_UTILS::TXT_FIELD($buttons, 'title', 'عنوان', '', true);
        AE_E_UTILS::TXT_FIELD($buttons, 'css_class', 'id/css class', '', true);
        AE_E_UTILS::ICON($buttons, 'button-');
        $this->add_control('buttons', [
            'label'       => 'دکمه ها',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $buttons->get_controls(),
            'title_field' => '{{{ title }}}',
        ]);

        $icon_place = [
            'before' => 'قبل',
            'after'  => 'بعد',
            'top'    => 'بالا',
            'bottom' => 'پایین'
        ];
        AE_E_UTILS::SELECT_FIELD($this, 'icon-place', 'مکان آیکون', $icon_place, 'before');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'icon-btw-gap', 'فاصله بین آیکون و متن', 0, 50, null, '.fancy-button-widget', 'gap');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'buttons-btw-gap', 'فاصله بین دکمه ها', 0, 100, null, '.wp-active-we-button-switcher', 'gap');

        AE_E_UTILS::H_ALIGNMENT_MIN($this, 'btn-alignment', '.fancy-button-widget-wrapper', 'flex-start');

        AE_E_UTILS::SECTION_END($this);


        $this->register_controls_styles_button();
        $this->register_controls_styles_icon();
    }

    protected function register_controls_styles_button()
    {

        AE_E_UTILS::SECTION_START($this, 'button-styles', 'دکمه', 'style');

        AE_E_UTILS::FONT_FIELD($this, 'btn-styles-typography', 'تایپوگرافی', '.btn-switcher');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'btn-styles-padding', 'Padding', '.btn-switcher', 'padding');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'btn-width', 'عرض', 0, 300, null, '.btn-switcher', 'width');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'btn-height', 'ارتفاع', 0, 300, null, '.btn-switcher', 'height');

        AE_E_UTILS::TAB_START($this, 'button');
        AE_E_UTILS::DynamicStyleControls($this, 'btn-styles-normal', '.btn-switcher', [
            'color',
            'background',
            'border',
            'radius',
            'shadow',
        ]);
        AE_E_UTILS::TAB_MIDDLE($this, 'button');
        AE_E_UTILS::DynamicStyleControls($this, 'btn-styles-hover', '.btn-switcher:hover', [
            'color',
            'background',
            'border',
            'radius',
            'shadow',
        ]);
        AE_E_UTILS::TAB_MIDDLE($this, 'button', true);
        AE_E_UTILS::DynamicStyleControls($this, 'btn-styles-active', '.btn-switcher.active', [
            'color',
            'background',
            'border',
            'radius',
            'shadow',
        ]);
        AE_E_UTILS::TAB_END($this);


        AE_E_UTILS::SECTION_END($this);

    }


    protected function register_controls_styles_icon()
    {

        AE_E_UTILS::SECTION_START($this, 'icon-styles', 'آیکون', 'style');

        AE_E_UTILS::TAB_START($this, 'icon');
        AE_E_UTILS::IconUtilsLight($this, 'icon-normal', '.btn-switcher .icon');
        AE_E_UTILS::TAB_MIDDLE($this, 'icon');
        AE_E_UTILS::IconUtilsLight($this, 'icon-hover', '.btn-switcher:hover .icon');
        AE_E_UTILS::TAB_MIDDLE($this, 'icon', true);
        AE_E_UTILS::IconUtilsLight($this, 'icon-active', '.btn-switcher.active .icon');
        AE_E_UTILS::TAB_END($this);

        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $buttons = $settings['buttons'];
        $icon_place = $settings['icon-place'];
        ?>
        <div class="wp-active-we-button-switcher fancy-button-widget-wrapper dfx aic wrap ae-gap-10">
            <?php
            $counter = 1;
            foreach ($buttons as $button) {
                $txt = $button['title'];
                $class = $button['css_class'];

                $this->add_render_attribute('button' . $counter, 'class', 'btn-switcher fancy-button-widget dfx aic jcc ae-gap-10');
                if ($counter === 1) {
                    $this->add_render_attribute('button' . $counter, 'class', 'active');
                }

                if ($icon_place === 'top' || $icon_place === 'bottom') {
                    $this->add_render_attribute('button' . $counter, 'class', 'dir-v');
                }

                $this->add_render_attribute('button' . $counter, 'title', $txt);
                if (!empty($class)) {
                    $this->add_render_attribute('button' . $counter, 'data-target', $class);
                }
                ?>
                <button <?php $this->print_render_attribute_string('button' . $counter); ?>>
                    <?php
                    if ($icon_place === 'before' || $icon_place === 'top') {
                        AE_E_UTILS::ICON_PRINT($this, $button, 'button-');
                    }
                    ?>
                    <span class="texts">
                        <span class="t1"><?php echo esc_html($txt); ?></span>
                        <span class="t2"><?php echo esc_html($txt); ?></span>
                    </span>
                    <?php
                    if ($icon_place === 'after' || $icon_place === 'bottom') {
                        AE_E_UTILS::ICON_PRINT($this, $button, 'button-');
                    }
                    ?>
                </button>
                <?php $counter++;
            } ?>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_ButtonSwitcher());
