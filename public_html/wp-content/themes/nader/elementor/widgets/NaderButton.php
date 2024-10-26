<?php
namespace Elementor;

defined( 'ABSPATH' ) || die();

class NaderButton extends Widget_Base {

	use \BUTTON_TRAIT;

	public function get_name() {
		return 'NaderButton';
	}

	public function get_title() {
		return PLUGIN_NAME_FA . ' : دکمه';
	}

	public function get_icon() {
		return 'nader-widget eicon-button';
	}

	public function get_categories() {
		return [ PLUGIN_NAME ];
	}

	protected function register_controls() {

		$this->start_controls_section( 'settings', [ 'label' => 'تنظیمات' ] );

        // in trait_nader_button
        $this->nader_button_1_settings();

		$this->add_responsive_control(
			'full-width',
			[
				'label'                => 'تمام عرض',
				'type'                 => Controls_Manager::SWITCHER,
				'label_on'             => 'بله',
				'label_off'            => 'خیر',
				'return_value'         => 'yes',
				'default'              => '',
				'selectors_dictionary' => [
					'yes' => 'block',
					''    => 'flex'
				],
				'selectors'            => [
					'{{WRAPPER}} .elementor-widget-container' => 'display: {{VALUE}}'
				]
			]
		);
		$this->add_responsive_control(
			'btn-alignment',
			[
				'label'     => 'جهت',
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => 'راست',
						'icon'  => 'eicon-text-align-right',
					],
					'center'     => [
						'title' => 'وسط',
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [
						'title' => 'چپ',
						'icon'  => 'eicon-text-align-left',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'justify-content: {{VALUE}};',
				],
				'condition' => [
					'full-width' => ''
				]
			]
		);

		$this->end_controls_section();


		// btn styles
		$this->nader_button_1_style();

	}

	protected function render() {

		$this->nader_button_1_render();

	}

}

Plugin::instance()->widgets_manager->register( new NaderButton() );
