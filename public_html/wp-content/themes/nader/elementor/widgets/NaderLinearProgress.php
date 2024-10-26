<?php

namespace Elementor;

use RP_Utils;

defined( 'ABSPATH' ) || die();

class NaderLinearProgress extends Widget_Base {

	public function get_script_depends() {
		wp_register_script( 'nader-linear-progress-widget', NADER_ELEMENTOR_JS_DIR . 'nader-linear-progress.js', [
			'jquery',
			'nader-waypoints',
		], '1.0.0', true );
		return [ 'jquery', 'nader-linear-progress-widget' ];
	}

	public function get_name() {
		return 'NaderLinearProgress';
	}

	public function get_title() {
		return PLUGIN_NAME_FA . ' : نوار پیشرفت خطی';
	}

	public function get_icon() {
		return 'nader-widget eicon-skill-bar';
	}

	public function get_categories() {
		return [ PLUGIN_NAME ];
	}

	protected function register_controls() {

		$this->start_controls_section( 'settings', [ 'label' => 'تنظیمات' ] );

		RP_Utils::SELECT_FIELD( $this, 'style', '', [ 'style-1' => 'استایل 1', 'style-2' => 'استایل 2' ], 'style-1' );

		RP_Utils::TXT_FIELD( $this, 'title', 'عنوان', 'عنوان', true );
		RP_Utils::ICON( $this, 'linear-progress-' );
		$this->add_control(
			'percentage',
			[
				'label'       => 'درصد',
				'type'        => Controls_Manager::SLIDER,
				'label_block' => true,
				'size_units'  => [ 'px' ],
				'dynamic'     => [
					'active' => true,
				],
				'range'       => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'     => [
					'size' => 80
				],
			]
		);
		RP_Utils::SWITCH_FIELD( $this, 'display-percentage-in-style-2', 'نمایش درصد', 'yes', false, 'style', 'style-2' );

		RP_Utils::NUMBER_FIELD( $this, 'duration', 'سرعت', 0, 1500, 10, 350, true );

		$this->end_controls_section();


		// style 1 box
		$this->start_controls_section( 'style-1', [
			'label'     => 'استایل',
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'style' => 'style-1'
			]
		] );
		$style1box = [
			[
				'type'  => 'slider',
				'title' => 'ارتفاع',
				'min'   => 40,
				'max'   => 150,
				'def'   => 50,
				'css'   => 'height',
			],
			[
				'type' => 'box-styles'
			]
		];
		RP_Utils::VariantUtils( $this, 'style-1-box', '.nader-linear-progress-style-1 .nader-progress-line', $style1box );
		$this->end_controls_section();


        // style 1 percentage
		$this->start_controls_section( 'style-1-percent', [
			'label'     => 'درصد',
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'style' => 'style-1'
			]
		] );
		$style1percent = [
			[
				'type'  => 'slider',
				'title' => 'عرض',
				'min'   => 40,
				'max'   => 150,
				'def'   => 50,
				'css'   => 'width',
			],
			[
				'type'  => '4dir',
				'css'   => 'padding',
				'title' => 'فاصله داخلی'
			],
			[
				'type' => 'text-small'
			],
			[
				'type' => 'bg-c'
			],
			[
				'type'  => 'border',
				'title' => 'حاشیه'
			],
			[
				'type'  => '4dir',
				'css'   => 'border-radius',
				'title' => 'خمیدگی'
			],
			[
				'type'  => 'shadow',
				'title' => 'سایه'
			],
		];
		RP_Utils::VariantUtils( $this, 'style-1-percent', '.nader-linear-progress-style-1 .nader-progress-percent', $style1percent );
		$this->end_controls_section();


		// style 2 progress box
		$this->start_controls_section( 'style-2-box', [
			'label'     => 'استایل بکگراند نوار',
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'style' => 'style-2'
			]
		] );
		$style2box = [
			[
				'type'  => 'slider',
				'title' => 'ارتفاع',
				'min'   => 6,
				'max'   => 100,
				'def'   => 10,
				'css'   => 'height',
			],
			[
				'type' => 'box-styles'
			]
		];
		RP_Utils::VariantUtils( $this, 'style-2-box', '.nader-linear-progress-style-2 .nader-progress-line-box', $style2box );
		$this->end_controls_section();


		// style 2 progress line
		$this->start_controls_section( 'style-2-line', [
			'label'     => 'استایل نوار',
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'style' => 'style-2'
			]
		] );
		$style2box = [
			[
				'type' => 'bg-c',
			],
			[
				'type'  => 'border',
				'title' => 'حاشیه'
			],
			[
				'type'  => '4dir',
				'title' => 'خمیدگی',
				'css'   => 'border-radius'
			],
			[
				'type'  => 'shadow',
				'title' => 'سایه'
			]
		];
		RP_Utils::VariantUtils( $this, 'style-2-line', '.nader-linear-progress-style-2 .nader-progress-line', $style2box );
		$this->end_controls_section();


		// title styles
		$this->start_controls_section( 'style-content', [
			'label' => 'عنوان',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );
		$title = [
			[
				'type'  => 'slider',
				'title' => 'فاصله بین آیکون و عنوان',
				'min'   => 0,
				'max'   => 100,
				'def'   => 10,
				'css'   => 'gap',
			],
			[
				'type' => 'text-small'
			],
			[
				'type'  => 'sep',
				'title' => 'درصد استایل 2',
				'uniq'  => 'percent'
			],
			[
				'type'   => 'text-small',
				'uniq'   => 'percent',
				'target' => '.nader-linear-progress-style-2 .nader-progress-header .nader-progress-percent'
			],
			[
				'type'  => 'sep',
				'title' => 'آیکون',
				'uniq'  => 'icon'
			],

		];
		RP_Utils::VariantUtils( $this, 'progress-title', '.nader-linear-progress .nader-progress-title', $title );
		$this->add_responsive_control(
			'icon-size',
			[
				'label'      => 'اندازه',
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
					'{{WRAPPER}} .nader-linear-progress .nader-progress-title .icon i'   => 'font-size: {{SIZE}}px;',
					'{{WRAPPER}} .nader-linear-progress .nader-progress-title .icon svg' => 'width: {{SIZE}}px;',
					'{{WRAPPER}} .nader-linear-progress .nader-progress-title .icon img' => 'width: {{SIZE}}px;',
				],
			]
		);
		$this->add_control(
			'icon-color',
			[
				'label'       => 'رنگ',
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::COLOR,
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .nader-linear-progress .nader-progress-title .icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .nader-linear-progress .nader-progress-title .icon svg' => 'fill: {{VALUE}};',
				]
			]
		);
		$this->end_controls_section();


	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$style = $settings['style'];

		$title      = $settings['title'];
		$percentage = $settings['percentage'];
		$duration   = $settings['duration'];


		if ( $style === 'style-1' ) {
			?>

            <div class="nader-linear-progress nader-linear-progress-style-1"
                 data-value="<?php echo esc_html( $percentage['size'] ); ?>"
                 data-duration="<?php echo esc_html( $duration ); ?>">
                <div class="nader-progress-line dfx aic">
                    <strong class="nader-progress-title dfx aic">
						<?php
						RP_Utils::ICON_PRINT( $this, $settings, 'linear-progress-' );
						echo esc_html( $title );
						?>
                    </strong>
                    <span class="nader-progress-percent dfx aic jcc"><?php echo esc_html( $percentage['size'] ); ?>%</span>
                </div>
            </div>

			<?php
		}

		if ( $style === 'style-2' ) {
			$dpis2 = $settings['display-percentage-in-style-2'];
			?>

            <div class="nader-linear-progress nader-linear-progress-style-2"
                 data-value="<?php echo esc_html( $percentage['size'] ); ?>"
                 data-duration="<?php echo esc_html( $duration ); ?>"
                 data-direction="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
                <div class="nader-progress-header dfx aic jcsb">
                    <strong class="nader-progress-title dfx aic">
						<?php

						RP_Utils::ICON_PRINT( $this, $settings, 'linear-progress-' );

						echo esc_html( $title );
						?>
                    </strong>
					<?php if ( ! empty( $dpis2 ) && $dpis2 === 'yes' ) { ?>
                        <span class="nader-progress-percent dfx aic jcc"><?php echo esc_html( $percentage['size'] ); ?>%</span>
					<?php } ?>
                </div>
                <div class="nader-progress-line-box dfx aic">
                    <span class="nader-progress-line dfx"></span>
                </div>
            </div>

			<?php
		}

	}
}

Plugin::instance()->widgets_manager->register( new NaderLinearProgress() );
