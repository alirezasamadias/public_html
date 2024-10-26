<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_IconButton extends Widget_Base{

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'دکمه آیکون';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-favorite';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);
        AE_E_UTILS::ICON($this, 'icon-button');
        AE_E_UTILS::URL_FIELD($this, 'icon-button-link', 'لینک', true);
        $this->add_control('icon-button-custom-class', [
            'label'       => 'class دلخواه',
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'description' => 'کلاس ها را بدون نقطه و با فاصله از هم جدا کنید'
        ]);
        AE_E_UTILS::H_ALIGNMENT_MIN($this, 'icon-button-alignment', '.wp-active-we-icon-button-block');

        $this->end_controls_section();

        AE_E_UTILS::SECTION_START($this, 'btn-styles', 'استایل');
        AE_E_UTILS::IconUtils($this, 'icon-button', '.icon', '.wp-active-we-icon-button');
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_link_attributes('icon-button-link', $settings['icon-button-link']);
        $this->add_render_attribute('icon-button-link', 'class', 'wp-active-we-icon-button');
        if (!empty($settings['icon-button-custom-class'])) {
            $this->add_render_attribute('icon-button-link', 'class', $settings['icon-button-custom-class']);
        }

        $btn_link = $settings['icon-button-link'];
        ?>
        <div class="wp-active-we-icon-button-block w100 dfx aic">
            <?php if (!empty($btn_link['url'])) { ?>
                <a <?php $this->print_render_attribute_string('icon-button-link'); ?>>
                    <?php AE_E_UTILS::ICON_PRINT($this, $settings, 'icon-button', 'trans03'); ?>
                </a>
            <?php } else { ?>
                <button type="button" <?php $this->print_render_attribute_string('icon-button-link'); ?>>
                    <?php AE_E_UTILS::ICON_PRINT($this, $settings, 'icon-button', 'trans03'); ?>
                </button>
            <?php } ?>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_IconButton());
