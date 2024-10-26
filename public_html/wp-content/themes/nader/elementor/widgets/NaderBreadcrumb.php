<?php

namespace Elementor;

use RP_Utils;

defined( 'ABSPATH' ) || die();

class NaderBreadcrumb extends Widget_Base {

	public function get_name() {
		return 'NaderBreadcrumb';
	}

	public function get_title() {
		return PLUGIN_NAME_FA . ' : بردکرامب';
	}

	public function get_icon() {
		return 'nader-widget eicon-chevron-double-left';
	}

	public function get_categories() {
		return [ PLUGIN_NAME ];
	}

	protected function register_controls() {

		$this->start_controls_section( 'style', [ 'label' => 'تنظیمات' ] );

        RP_Utils::SLIDER_FIELD_PIX_STYLE($this, 'gap', 'فاصله', 0, 30, null, '.nader-breadcrumb-elementor', 'gap');

        RP_Utils::Separator($this, 'link', 'لینک');
        RP_Utils::FONT_FIELD($this, 'link-font', 'تایپوگرافی', 'a');
        RP_Utils::COLOR_FIELD($this, 'link-color-normal', 'رنگ', '', 'a', 'color');
        RP_Utils::COLOR_FIELD($this, 'link-color-hover', 'رنگ هاور', '', 'a:hover', 'color');

        RP_Utils::Separator($this, 'target', 'مقصد');
        RP_Utils::FONT_FIELD($this, 'target-font', 'تایپوگرافی', '.nader-breadcrumb-elementor');
        RP_Utils::COLOR_FIELD($this, 'target-color', 'رنگ', '', '.nader-breadcrumb-elementor', 'color');

        RP_Utils::Separator($this, 'delimiter', 'جداکننده');
        RP_Utils::FONT_FIELD($this, 'delimiter-font', 'تایپوگرافی', '.delimiter');
        RP_Utils::COLOR_FIELD($this, 'delimiter-color', 'رنگ', '', '.delimiter', 'color');


		$this->end_controls_section();

	}

	protected function render() {
        echo '<div class="nader-breadcrumb-elementor dfx flex-wrap">';
        get_template_part('parts/global/breadcrumb');
        echo '</div>';
	}
}

Plugin::instance()->widgets_manager->register( new NaderBreadcrumb() );
