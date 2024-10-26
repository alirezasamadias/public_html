<?php

namespace Elementor;

defined('ABSPATH') || die();

use RP_Utils;

class NaderSingleTags extends Widget_Base
{

    public function get_name()
    {
        return 'NaderSingleTags';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : برچسب های پست';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-tags';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {
        RP_Utils::SECTION_START($this, 'b-styles', 'عنوان');
        RP_Utils::TextUtils($this, 'b', 'b');
        RP_Utils::SECTION_END($this);


        RP_Utils::SECTION_START($this, 'link-styles', 'لینک');
        RP_Utils::TextUtils($this, 'link', 'a');
        RP_Utils::SECTION_END($this);
    }

    protected function render()
    {
        $tax_name = 'post_tag';
        if (is_singular('project')) {
            $tax_name = 'project_tag';
        }
        if (has_term('', $tax_name)) {
            the_terms(get_the_ID(), $tax_name, '<b>' . __('tags:', 'nader') . ' </b>', '، ');
        }
    }
}

Plugin::instance()->widgets_manager->register(new NaderSingleTags());
