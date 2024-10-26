<?php

namespace Elementor;

defined('ABSPATH') || die();

use RP_Utils;

class NaderSingleFontSizeChanger extends Widget_Base
{
    public function get_name()
    {
        return 'NaderSingleFontSizeChanger';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : تغییر دهنده اندازه فونت';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-font';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {
        RP_Utils::SECTION_START($this, 'settings', 'تنظیمات');

        RP_Utils::TXT_FIELD($this, 'target', 'کلاس یا آیدی هدف');
        RP_Utils::NUMBER_FIELD($this, 'default-size', 'اندازه پیشفرض', 8, 100, 1, 14);

        RP_Utils::SECTION_END($this);


        RP_Utils::SECTION_START($this, 'box-styles', 'باکس', 'style');
        $box = [
            'bg',
            'padding',
            'border',
            'radius',
        ];
        RP_Utils::DynamicStyleControls($this, 'box', '.font-size-changer', $box);
        RP_Utils::SECTION_END($this);


        // buttons
        RP_Utils::SECTION_START($this, 'buttons-styles', 'دکمه', 'style');

        $buttons = [
            'bg',
            'width',
            'height',
            'radius'
        ];
        RP_Utils::TAB_START($this, 'btn');
        RP_Utils::COLOR_FIELD($this, 'btn-normal-icon-color', 'رنگ', '', '.font-size-ch-btn svg', 'fill');
        RP_Utils::DynamicStyleControls($this, 'btn-normal', '.font-size-ch-btn', $buttons);
        RP_Utils::TAB_MIDDLE($this, 'btn');

        RP_Utils::COLOR_FIELD($this, 'btn-hover-icon-color', 'رنگ', '', '.font-size-ch-btn:hover svg', 'fill');
        RP_Utils::DynamicStyleControls($this, 'btn-hover', '.font-size-ch-btn:hover', $buttons);
        RP_Utils::TAB_END($this);

        RP_Utils::SECTION_END($this);
    }

    protected function render()
    {

        $settings = $this->get_settings_for_display();


        ?>

        <div class="font-size-changer d-flex align-items-center gap-2"
             data-font-size-changer-target="<?php echo esc_html($settings['target']); ?>"
             data-default-font-size="<?php echo esc_html($settings['default-size']); ?>px">

            <span class="font-size-ch-btn fz-reset dfx aic jcc cursor-pointer disable-select">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="none" d="M0 0h24v24H0z"/>
                    <path d="M10 6v15H8V6H2V4h14v2h-6zm8 8v7h-2v-7h-3v-2h8v2h-3z"/>
                </svg>
            </span>

            <div class="btn-actions d-flex align-items-center gap-1">
                <span class="font-size-ch-btn fz-increase dfx aic jcc cursor-pointer disable-select">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z"/>
                        <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/>
                    </svg>
                </span>
                <span class="font-size-ch-btn fz-decrease dfx aic jcc cursor-pointer disable-select">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z"/>
                        <path d="M5 11h14v2H5z"/>
                    </svg>
                </span>
            </div>
        </div>

        <?php
    }
}

Plugin::instance()->widgets_manager->register(new NaderSingleFontSizeChanger());
