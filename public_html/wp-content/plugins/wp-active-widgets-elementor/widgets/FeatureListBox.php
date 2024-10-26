<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_FeatureListBox extends Widget_Base
{

    public function get_script_depends()
    {
        return ['wp-active-we-intro-animation'];
    }

    public function get_style_depends()
    {
        wp_register_style('AE_E_FeatureListBox', AE_E_CSS_DIR . 'feature-list-box.css');
        return ['AE_E_FeatureListBox'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'جعبه لیست ویژگی ها';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-bullet-list';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        AE_E_UTILS::ICON($this, 'feature-list-box-');
        AE_E_UTILS::TXT_FIELD($this, 'title', 'عنوان', 'لیست ویژگی ها', true);
        AE_E_UTILS::HTML_TAG($this, 'title-html-tag', 'عنوان', 'h3', 'title!', '');
        $features = new \Elementor\Repeater();
        AE_E_UTILS::TXT_FIELD($features, 'text', 'متن', '', true);
        $this->add_control(
            'feature-list',
            [
                'label'       => 'موارد',
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $features->get_controls(),
                'title_field' => '{{{ text }}}',
            ]
        );

        AE_E_UTILS::Separator($this, 'list-items-icon', 'آیکونِ لیست');
        AE_E_UTILS::ICON($this, 'list-items-');

        AE_E_UTILS::SWITCH_FIELD($this, 'intro-animation', 'انیمیشن ورود');

        $this->end_controls_section();


        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {

        AE_E_UTILS::SECTION_START($this, 'style-box', 'باکس', 'style');
        AE_E_UTILS::TAB_START($this, 'box-utils-normal');
        AE_E_UTILS::DynamicStyleControls($this, 'box-utils-normal', '.wp-active-we-feature-list-box', [
            'padding', 'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_MIDDLE($this, 'box-utils-hover');
        AE_E_UTILS::DynamicStyleControls($this, 'box-utils-hover', '.wp-active-we-feature-list-box:hover', [
            'padding', 'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);
        AE_E_UTILS::SECTION_END($this);


        // icon
        AE_E_UTILS::SECTION_START($this, 'style-icon', 'آیکون', 'style');
        AE_E_UTILS::IconUtils($this, 'style-main-icon', '.main-icon', '.wp-active-we-feature-list-box');
        AE_E_UTILS::SECTION_END($this);


        // title
        AE_E_UTILS::SECTION_START($this, 'style-title', 'عنوان', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'title-mt', 'فاصله', 0, 100, null, '.wp-active-we-feature-list-box .flb-title', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'title', '.wp-active-we-feature-list-box .flb-title');
        AE_E_UTILS::SECTION_END($this);


        // list
        AE_E_UTILS::SECTION_START($this, 'style-list', 'لیست', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'list-mt', 'فاصله', 0, 100, null, '.wp-active-we-feature-list-box ul', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'list', '.wp-active-we-feature-list-box ul');
        AE_E_UTILS::Separator($this, 'list-item-icon', 'آیکونِ لیست');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'list-item-icon-margin', 'فاصله', '.wp-active-we-feature-list-box ul .list-item-icon', 'margin');
        AE_E_UTILS::IconUtilsLight($this, 'list-item-icon', '.wp-active-we-feature-list-box ul .list-item-icon');
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $list     = $settings['feature-list'];

        $this->add_render_attribute('feature-list-container', 'class', ['wp-active-we-feature-list-box', 'dfx', 'dir-v']);
        if ($settings['intro-animation'] === 'yes') {
            $this->add_render_attribute('feature-list-container', 'class', 'active-animation');
            $this->add_render_attribute('feature-list-container', 'data-animation-target', '.elementor-element-' . $this->get_id() . ' .wp-active-we-feature-list-box');
            $this->add_render_attribute('feature-list-container', 'data-animation-offset', '100');
        }

        echo '<div ' . $this->get_render_attribute_string('feature-list-container') . '>';

        AE_E_UTILS::ICON_PRINT($this, $settings, 'feature-list-box-', 'main-icon');
        AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'title', 'title-html-tag', 'flb-title');

        if (!empty($list)) {
            echo '<ul class="dfx dir-v ae-gap-10">';
            foreach ($list as $item) {
                echo '<li class="dfx ais">';
                AE_E_UTILS::ICON_PRINT($this, $settings, 'list-items-', 'list-item-icon');
                echo esc_html($item['text']) . '</li>';
            }
            echo '</ul>';
        }

        echo '</div>';
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_FeatureListBox());
