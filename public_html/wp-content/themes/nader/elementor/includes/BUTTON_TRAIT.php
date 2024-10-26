<?php

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

trait BUTTON_TRAIT {

	private function nader_button_1_settings() {

		RP_Utils::TXT_FIELD( $this, 'nader-btn-1-title', 'عنوان', 'دکمه نادر', true );

		$this->add_control(
			'nader-btn-1-link',
			[
				'label'       => 'لینک',
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => 'https://your-link.com',
				'default'     => [
					'url' => '#',
				],
			]
		);

		RP_Utils::ICON( $this, 'nader-btn-1-icon' );

		$icon_place = [
			'before' => 'قبل',
			'after'  => 'بعد'
		];
		RP_Utils::SELECT_FIELD( $this, 'nader-btn-1-icon-place', 'مکان آیکون', $icon_place, 'after' );

		RP_Utils::SLIDER_FIELD_PIX_STYLE( $this, 'nader-btn-1-icon-distance', 'فاصله بین', 0, 100, 15, '.theme-btn', 'gap' );

	}

	private function nader_button_1_style() {
		$this->start_controls_section( 'nader-btn-1-styles', [
			'label' => 'استایل دکمه',
			'tab'   => Controls_Manager::TAB_STYLE
		] );

		$btn_styles = [
			[
				'type' => 'tab-start'
			],
			[
				'type' => 'text-small',
			],
			[
				'type' => 'box-styles'
			],
			[
				'type'  => 'tab-middle',
				'title' => 'هاور'
			],
			[
				'type'   => 'text-small',
				'uniq'   => 'hover',
				'target' => '.theme-btn:hover'
			],
			[
				'type'   => 'box-styles',
				'uniq'   => 'hover',
				'target' => '.theme-btn:hover'
			],
			[
				'type' => 'tab-end'
			]
		];
		RP_Utils::VariantUtils( $this, 'nader-btn-1-styles', '.theme-btn', $btn_styles );

		$this->end_controls_section();


		// border styles
		$this->start_controls_section( 'nader-btn-1-border-styles', [
			'label' => 'خط دور دکمه',
			'tab'   => Controls_Manager::TAB_STYLE
		] );

		$btn_border_styles = [
			[
				'type'  => 'slider',
				'title' => 'ضخامت',
				'min'   => 1,
				'max'   => 10,
				'def'   => 1,
				'css'   => 'border-width'
			],
			[
				'type'  => 'color-v',
				'title' => 'رنگ',
				'css'   => 'border-color'
			],
			[
				'type'  => '4dir',
				'title' => 'خمیدگی',
				'css'   => 'border-radius'
			]

		];
		RP_Utils::VariantUtils( $this, 'nader-btn-1-border---styles', '.theme-btn::before', $btn_border_styles );
		$this->end_controls_section();


		// icon styles
		$this->start_controls_section( 'nader-btn-1-icon-styles', [
			'label' => 'آیکون دکمه',
			'tab'   => Controls_Manager::TAB_STYLE
		] );

		$this->add_responsive_control(
			'nader-btn-1-icon-size',
			[
				'label'      => 'اندازه آیکون',
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 20,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .theme-btn .icon i'   => 'font-size: {{SIZE}}px;',
					'{{WRAPPER}} .theme-btn .icon svg' => 'width: {{SIZE}}px;',
					'{{WRAPPER}} .theme-btn .icon img' => 'width: {{SIZE}}px;',
				],
			]
		);
		$this->add_control(
			'nader-btn-1-icon-color-normal',
			[
				'label'       => 'رنگ',
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::COLOR,
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .theme-btn .icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .theme-btn .icon svg' => 'fill: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'nader-btn-1-icon-color-hover',
			[
				'label'       => 'رنگ هاور',
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::COLOR,
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .theme-btn:hover .icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .theme-btn:hover .icon svg' => 'fill: {{VALUE}};',
				]
			]
		);
		$this->end_controls_section();
	}

	private function nader_button_1_render() {

		$settings = $this->get_settings_for_display();

		$title = $settings['nader-btn-1-title'];

		$icon_place = $settings['nader-btn-1-icon-place'];

		$this->add_render_attribute( 'nader-btn-1', 'role', 'button' );
		$this->add_render_attribute( 'nader-btn-1', 'class', 'theme-btn dfx jcc aic' );

		if ( ! empty( $settings['nader-btn-1-link']['url'] ) ) {
			$this->add_link_attributes( 'nader-btn-1', $settings['nader-btn-1-link'] );
		}

		?>

		<a <?php $this->print_render_attribute_string( 'nader-btn-1' ); ?>>
			<?php
			if ( $icon_place === 'before' ) {
				RP_Utils::ICON_PRINT( $this, $settings, 'nader-btn-1-icon' );
			}

			if ( ! empty( $title ) ) {
				echo esc_html( $title );
			}

			if ( $icon_place === 'after' ) {
				RP_Utils::ICON_PRINT( $this, $settings, 'nader-btn-1-icon' );
			}
			?>
		</a>

		<?php

	}

}