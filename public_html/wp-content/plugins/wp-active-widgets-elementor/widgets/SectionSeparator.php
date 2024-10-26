<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_SectionSeparator extends Widget_Base
{

    public string $separator_svg_desktop = '<svg class="separator-svg desktop" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1351 52.39"><g><g><path d="M709.5,11.22h0a57.13,57.13,0,0,0-68,0h0a140.24,140.24,0,0,1-86.18,27.5C347.74,34.67,161.05,20.57,0,2.75V52.39H1351V2.75c-161.19,17.84-347.64,31.94-555.32,36A140.24,140.24,0,0,1,709.5,11.22Z"/></g></g></svg>';
    public string $separator_svg_mobile = '<svg class="separator-svg mobile" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 711.85 52.39"><g><g><path d="M389.93,11.23l0,0a57.11,57.11,0,0,0-68,0h0A126.87,126.87,0,0,1,237.75,35.8,1738.72,1738.72,0,0,1,0,2.75V52.39H711.85V2.75A1736.55,1736.55,0,0,1,474.12,35.81,126.79,126.79,0,0,1,389.93,11.23Z"/></g></g></svg>';

    public string $separator_svg_desktop_t_2 = '<svg class="separator-svg desktop" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1350.88 75.37"><g><g><path d="M0,0Q120.5,13.53,252.31,23c97.35,6.82,199.13,11.59,305,13.65q3.36,0,6.7.12a140.35,140.35,0,0,1,77.39,27.4,57.13,57.13,0,0,0,68,0,140.18,140.18,0,0,1,76.38-27.37q3.56-.2,7.13-.19c.54,0,1.08,0,1.62,0,105.54-2.08,207-6.83,304-13.63q131.67-9.23,252.28-23Z"/></g></g></svg>';
    public string $separator_svg_mobile_t_2 = '<svg class="separator-svg mobile" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 767.42 73.24"><g><g><path d="M0,0C40.5,8,82.72,15.06,126.56,20.85c47.2,6.23,96.28,11,147.13,13.84l.67,0,.66,0A140.24,140.24,0,0,1,349.7,62a57.13,57.13,0,0,0,68,0,140.29,140.29,0,0,1,72.84-27.15q2.85-.23,5.73-.32c49.93-2.88,98.15-7.57,144.55-13.7C684.68,15.07,726.91,8,767.42,0Z"/></g></g></svg>';

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-section-separator', AE_E_CSS_DIR . 'section-separator.css');
        return ['wp-active-we-section-separator'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'جداکننده سکشن';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-banner';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);
        AE_E_UTILS::SELECT_FIELD($this, 'separator-type', 'نوع', [
            'top'    => 'نوع 1',
            'bottom' => 'نوع 2'
        ], 'top');
        AE_E_UTILS::URL_FIELD($this, 'link', 'لینک', true);
        AE_E_UTILS::COLOR_FIELD($this, 'sep-svg', 'بکگراند', '', '.separator-svg', 'fill');
        $this->end_controls_section();


        AE_E_UTILS::SECTION_START($this, 'centered-icon', 'آیکون');
        AE_E_UTILS::ICON($this, 'section-separator');
        $trg = '.wp-active-we-section-separator.has-link .centered-icon-holder, {{WRAPPER}} .wp-active-we-section-separator:not(.has-link) .centered-icon';
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'centered-icon-distance', 'تنظیم جایگاه', 0, 50, null, $trg, 'top');
        AE_E_UTILS::IconUtilsLight($this, 'centered-icon', '.centered-icon');
        AE_E_UTILS::SWITCH_FIELD($this, 'has-down-animation', 'انیمیشن', '');
        AE_E_UTILS::SECTION_END($this);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $type     = $settings['separator-type'];
        $link     = $settings['link'];

        $icon_class = 'centered-icon';
        if ($settings['has-down-animation'] === 'yes') {
            $icon_class .= ' wp-active-we-separator-icon-fading';
        }

        ?>
        <div class="wp-active-we-section-separator<?php echo !empty($link['url']) ? ' has-link' : ''; ?> dfx aic jcc">
            <?php
            if ($type === 'top') {
                echo $this->separator_svg_desktop;
                echo $this->separator_svg_mobile;
            } else {
                echo $this->separator_svg_desktop_t_2;
                echo $this->separator_svg_mobile_t_2;
            }

            if (!empty($link['url'])) {
                $this->add_link_attributes('sep-link', $link);
                $this->add_render_attribute('sep-link', 'class', 'centered-icon-holder');
                echo '<a ' . $this->get_render_attribute_string('sep-link') . '>';
                AE_E_UTILS::ICON_PRINT($this, $settings, 'section-separator', $icon_class);
                echo '</a>';
            } else {
                AE_E_UTILS::ICON_PRINT($this, $settings, 'section-separator', $icon_class);
            }
            ?>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_SectionSeparator());
