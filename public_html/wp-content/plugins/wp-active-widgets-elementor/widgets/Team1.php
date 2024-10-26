<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_Team1 extends Widget_Base
{

    public function get_script_depends()
    {
        return ['wp-active-we-intro-animation'];
    }
    
    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'عضو تیم 1';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-person';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        AE_E_UTILS::SECTION_START($this, 'settings', 'تنظیمات');
        AE_E_UTILS::TXT_FIELD($this, 'name', 'نام', 'علی عمادزاده', true);
        AE_E_UTILS::TXT_FIELD($this, 'position', 'جایگاه', 'مدیرعامل', true);

        AE_E_UTILS::URL_FIELD($this, 'link', 'لینک', true);

        AE_E_UTILS::IMAGE($this, 'team-image', 'تصویر');
        AE_E_UTILS::IMAGE_SIZE($this, 'team-image');
        
        AE_E_UTILS::SWITCH_FIELD($this, 'intro-animation', 'انیمیشن ورود');

        AE_E_UTILS::SECTION_END($this);

        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {

        // image
        AE_E_UTILS::SECTION_START($this, 'image-styles', 'تصویر', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'image-height', 'ارتفاع', 0, 500, null, '.image-holder img', 'height');
        AE_E_UTILS::DynamicStyleControls($this, 'image', '.image-holder', [
            'padding', 'bg', 'border', 'radius', 'shadow'
        ]);
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'image-mb', 'فاصله', 0, 50, null, '.image-holder', 'margin-bottom');
        AE_E_UTILS::SECTION_END($this);


        // texts
        AE_E_UTILS::SECTION_START($this, 'texts-styles', 'متن ها', 'style');
        AE_E_UTILS::TEXT_ALIGNMENT($this, 'texts-alignment', '.team-info');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'texts-gap', 'فاصله بین', 0, 50, null, '.team-info', 'gap');
        AE_E_UTILS::Separator($this, 'name', 'نام');
        AE_E_UTILS::TextUtils($this, 'name', '.name');
        AE_E_UTILS::Separator($this, 'position', 'جایگاه');
        AE_E_UTILS::TextUtils($this, 'position', '.position');
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if (empty($settings['team-image']['url'])) {
            return;
        }

        $name     = $settings['name'];
        $position = $settings['position'];

        $this->add_render_attribute('team-wrapper', 'class', 'wp-active-we-team-1');
        if ($settings['intro-animation'] === 'yes') {
            $this->add_render_attribute('team-wrapper', 'class', 'active-animation');
            $this->add_render_attribute('team-wrapper', 'data-animation-target', '.elementor-element-' . $this->get_id() . ' .wp-active-we-team-1');
            $this->add_render_attribute('team-wrapper', 'data-animation-offset', '100');
        }

        $is_link = false;
        if (!empty($settings['link']['url'])) {
            $this->add_link_attributes('team-wrapper', $settings['link']);
            $is_link = true;
        }

        if ($is_link) {
            echo '<a ' . $this->get_render_attribute_string('team-wrapper') . '>';
        } else {
            echo '<div ' . $this->get_render_attribute_string('team-wrapper') . '>';
        }

        echo '<div class="image-holder dfx aic jcc w100">';
        AE_E_UTILS::ImageGenerator($settings, 'team-image', 'team-image_size', 'team-image');
        echo '</div>';

        echo '<div class="team-info dfx dir-v">';
        if (!empty($name)) {
            echo '<b class="name">' . $name . '</b>';
        }
        if (!empty($position)) {
            echo '<span class="position">' . $position . '</span>';
        }
        echo '</div>';

        if ($is_link) {
            echo '</a>';
        } else {
            echo '</div>';
        }

    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_Team1());
