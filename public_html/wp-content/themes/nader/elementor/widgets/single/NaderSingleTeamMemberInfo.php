<?php

namespace Elementor;

defined('ABSPATH') || die();

use RP_Utils;

class NaderSingleTeamMemberInfo extends Widget_Base{

    public function get_name()
    {
        return 'NaderSingleTeamMemberInfo';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : اطلاعات کارمند';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-user-circle-o';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {
        RP_Utils::SECTION_START($this, 'general', 'کلی');
        $this->add_responsive_control('columns', [
            'label'       => 'ستون',
            'type'        => Controls_Manager::NUMBER,
            'label_block' => false,
            'min'         => 1,
            'max'         => 5,
            'selectors'   => [
                '{{WRAPPER}} .member-info' => 'grid-template-columns:repeat({{VALUE}}, 1fr)',
            ],
        ]);
        RP_Utils::SLIDER_FIELD_PIX_STYLE($this, 'items-gap', 'فاصله بین', 0, 50, null, '.member-info', 'gap');
        RP_Utils::SECTION_END($this);


        RP_Utils::SECTION_START($this, 'texts', 'متن ها');
        RP_Utils::Separator($this,'title','عنوان');
        RP_Utils::TextUtils($this,'title','.member-info .pib .pibt .bt');
        RP_Utils::Separator($this,'info','متن');
        RP_Utils::TextUtils($this,'info','.member-info .pib .pibt .ba');
        RP_Utils::SECTION_END($this);


        RP_Utils::SECTION_START($this, 'icon', 'آیکون');
        RP_Utils::IconUtils($this,'icon','.icon', '.pib');
        RP_Utils::SECTION_END($this);
    }

    protected function render()
    {
        get_template_part('parts/team/member-info');
    }
}

Plugin::instance()->widgets_manager->register(new NaderSingleTeamMemberInfo());
