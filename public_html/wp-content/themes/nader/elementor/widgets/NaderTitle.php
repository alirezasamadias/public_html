<?php

namespace Elementor;

use RP_Utils;

defined( 'ABSPATH' ) || die();

class NaderTitle extends Widget_Base {

	public function get_name() {
		return 'NaderTitle';
	}

	public function get_title() {
		return PLUGIN_NAME_FA . ' : عنوان';
	}

	public function get_icon() {
		return 'nader-widget eicon-t-letter';
	}

	public function get_categories() {
		return [ PLUGIN_NAME ];
	}

	protected function register_controls() {

		$this->start_controls_section( 'settings', [ 'label' => 'تنظیمات' ] );

		RP_Utils::TXT_FIELD( $this, 'text_before', 'متن قبل', '', true );
		RP_Utils::TXT_FIELD( $this, 'text_main', 'متن وسط', '', true );
		RP_Utils::TXT_FIELD( $this, 'text_after', 'متن بعد', '', true );
		RP_Utils::HTML_TAG( $this, 'html_tag', 'عنوان' );

		RP_Utils::SWITCH_FIELD( $this, 'long-line', 'جداکننده بلند' );

		$this->end_controls_section();


		// text styles
		$this->start_controls_section( 'text-styles', [
			'label' => 'استایل متن',
			'tab'   => Controls_Manager::TAB_STYLE
		] );
		$text_styles = [
			[
				'type'  => 'slider',
				'title' => 'فاصله بین متن و خط بلند',
				'min'   => 5,
				'max'   => 100,
				'def'   => 20,
				'css'   => 'padding-left'
			],
			[
				'type' => 'bg',
				'uniq' => 'texts_bg',
			],
			[
				'type'  => 'sep',
				'title' => 'پیشفرض',
				'uniq'  => 'tba-sep'
			],
			[
				'type' => 'text-small',
				'uniq' => 'tba',
			],
			[
				'type'  => 'sep',
				'title' => 'متن وسط',
				'uniq'  => 't-main-sep'
			],
			[
				'type'   => 'text-small',
				'uniq'   => 't-main',
				'target' => '.nader_title span'
			],
		];
		RP_Utils::VariantUtils( $this, 'text_styles', '.nader_title .text_wrapper', $text_styles );
		$this->end_controls_section();


		// short line
		$this->start_controls_section( 'short-line-styles', [
			'label'     => 'خط زیر متن اصلی',
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'text_main!' => ''
			]
		] );
		$nader_main_title_underline = [
			[
				'type' => 'bg',
			],
			[
				'type'  => 'slider',
				'title' => 'ارتفاع',
				'min'   => 1,
				'max'   => 20,
				'def'   => 9,
				'css'   => 'height'
			],
			[
				'type'  => 'slider',
				'title' => 'فاصله',
				'min'   => - 30,
				'max'   => 50,
				'def'   => 13,
				'css'   => 'bottom'
			],
			[
				'type'  =>  '4dir',
				'title' =>  'خمیدگی',
				'css'   =>  'border-radius'
			]
		];
		RP_Utils::VariantUtils( $this, 'main-text-underline', '.nader_title .text_wrapper span::before', $nader_main_title_underline );
		$this->end_controls_section();


		// long line
		$this->start_controls_section( 'long-line-styles', [
			'label'     => 'خط بلند',
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'long-line' => 'yes'
			]
		] );
		$nader_long_line_before = [
			[
				'type' => 'bg',
			],
			[
				'type'  => 'slider',
				'title' => 'ارتفاع',
				'min'   => 1,
				'max'   => 10,
				'def'   => 2,
				'css'   => 'height'
			]
		];
		RP_Utils::VariantUtils( $this, 'nader-title-llb', '.nader_title.long_line .before', $nader_long_line_before );


		$nader_long_line_after = [
			[
				'type' => 'bg',
			],
			[
				'type'  => 'slider',
				'title' => 'ارتفاع',
				'min'   => 1,
				'max'   => 10,
				'def'   => 2,
				'css'   => 'height'
			],
			[
				'type'  => 'slider',
				'title' => 'عرض',
				'min'   => 0,
				'max'   => 100,
				'def'   => 50,
				'css'   => 'width'
			]
		];
		RP_Utils::VariantUtils( $this, 'nader-title-lla', '.nader_title.long_line::after', $nader_long_line_after );
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$text_before = $settings['text_before'];
		$text_after  = $settings['text_after'];
		$text_main   = $settings['text_main'];

		$tt = $settings['html_tag'];

		// add class to element
		$this->add_render_attribute( 'title_class', 'class', 'nader_title' );
		$long_line = $settings['long-line'];
		if ( ! empty( $long_line ) ) {
			$this->add_render_attribute( 'title_class', 'class', 'long_line' );
		}

		echo '<div  ' . $this->get_render_attribute_string( 'title_class' ) . '>';
		echo '<span class="before"></span>';
		echo '<' . $tt . ' class="text_wrapper">';
		if ( ! empty( $text_before ) ) {
			echo esc_html( $text_before );
		}

		if ( ! empty( $text_main ) ) {
			echo ' <span>' . esc_html( $text_main ) . '</span>';
		}

		if ( ! empty( $text_after ) ) {
			echo ' ' . esc_html( $text_after );
		}
		echo '</' . $tt . '>';
		echo '</div>';

	}
}

Plugin::instance()->widgets_manager->register( new NaderTitle() );
