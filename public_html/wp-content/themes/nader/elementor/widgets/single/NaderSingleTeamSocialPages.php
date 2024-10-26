<?php

namespace Elementor;

defined('ABSPATH') || die();

use RP_Utils;

class NaderSingleTeamSocialPages extends Widget_Base{

    public function get_name()
    {
        return 'NaderSingleTeamSocialPages';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : شبکه های اجتماعی کارمند';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-share';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {
        RP_Utils::SECTION_START($this, 'styles', 'استایل', 'style');
        RP_Utils::SLIDER_FIELD_PIX_STYLE($this,'items-gap','فاصله بین',0,50,null,'.member-socials','gap');
        RP_Utils::IconUtils($this, 'item','', 'a');
        RP_Utils::SECTION_END($this);
    }

    protected function render()
    {
        get_template_part('parts/team/social-pages');
    }
}

Plugin::instance()->widgets_manager->register(new NaderSingleTeamSocialPages());
