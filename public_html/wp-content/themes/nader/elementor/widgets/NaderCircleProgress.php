<?php

namespace Elementor;

use RP_Utils;

defined( 'ABSPATH' ) || die();

class NaderCircleProgress extends Widget_Base {

	public function get_script_depends() {
		wp_register_script( 'nader-circle-progress', NADER_JS_DIR . 'circle-progress.min.js', [ 'jquery' ], 1, true );
		wp_register_script( 'nader-circle-progress-widget', NADER_ELEMENTOR_JS_DIR . 'nader-circle-progress.js', [
			'jquery',
			'nader-waypoints',
			'nader-circle-progress'
		], '1.0.0', true );
		return [ 'nader-circle-progress', 'nader-circle-progress-widget' ];
	}

	public function get_name() {
		return 'NaderCircleProgress';
	}

	public function get_title() {
		return PLUGIN_NAME_FA . ' : نوار پیشرفت دایره ای';
	}

	public function get_icon() {
		return 'nader-widget eicon-skill-bar';
	}

	public function get_categories() {
		return [ PLUGIN_NAME ];
	}

	protected function register_controls() {

		$this->start_controls_section( 'settings', [ 'label' => 'تنظیمات' ] );

		RP_Utils::TXT_FIELD( $this, 'title', 'عنوان', 'عنوان', true );
		RP_Utils::NUMBER_FIELD( $this, 'number', 'عدد', 0, 100, 1, 100, true );
		RP_Utils::IMAGE( $this, 'image', 'تصویر' );
        RP_Utils::IMAGE_SIZE($this,'image','medium');

		RP_Utils::NUMBER_FIELD( $this, 'thickness', 'ThickNess', 1, 20, 1, 7 );

		$this->add_responsive_control(
			'width',
			[
				'label'       => 'اندازه',
				'type'        => Controls_Manager::SLIDER,
				'label_block' => true,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px' => [
						'min' => 50,
						'max' => 300,
					],
				],
				'default'     => [
					'size' => 230
				],
				'selectors'   => [
					'{{WRAPPER}} .nader-circle-progress .circle' => 'width: {{SIZE}}px;',
				],
			]
		);

		$this->end_controls_section();


		// line styles
		$this->start_controls_section( 'styles', [
			'label' => 'استایل',
			'tab'   => Controls_Manager::TAB_STYLE
		] );
		$this->add_control(
			'emptyFill',
			[
				'label'       => 'رنگ نوار خالی',
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::COLOR,
				'default'     => '#dddddd',
			]
		);
		$this->add_control(
			'fill',
			[
				'label'       => 'رنگ نوار',
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::COLOR,
				'default'     => '#111111',
			]
		);

		$this->add_responsive_control(
			'inside-width-height',
			[
				'label'       => 'اندازه دایره داخلی',
				'type'        => Controls_Manager::SLIDER,
				'label_block' => true,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'     => [
					'size' => 90
				],
				'selectors'   => [
					'{{WRAPPER}} .nader-circle-progress .circle .center-text::before' => 'width: {{SIZE}}%;height: {{SIZE}}%;',
				],
			]
		);
		$this->add_control(
			'inside-bg',
			[
				'label'       => 'رنگ دایره داخلی',
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::COLOR,
				'default'     => '#111111bb',
				'selectors'   => [
					'{{WRAPPER}} .nader-circle-progress .circle .center-text::before' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();


		// text styles
		$this->start_controls_section( 'text-styles', [
			'label' => 'متن',
			'tab'   => Controls_Manager::TAB_STYLE
		] );
		$text_styles = [
			[
				'type'  => 'sep',
				'title' => 'عنوان',
				'uniq'  => 'title'
			],
			[
				'type'   => 'text-small',
				'target' => '.nader-circle-progress .circle .center-text p',
				'uniq'   => 'title'
			],
			[
				'type'  => 'sep',
				'title' => 'عدد',
				'uniq'  => 'number'
			],
			[
				'type'   => 'text-small',
				'target' => '.nader-circle-progress .circle .center-text span',
				'uniq'   => 'number'
			],
			[
				'type'   => 'slider',
				'title'  => 'فاصله از پایین',
				'min'    => 0,
				'max'    => 100,
				'def'    => 5,
				'css'    => 'margin-bottom',
				'uniq'   => 'number',
				'target' => '.nader-circle-progress .circle .center-text span'
			],
			[
				'type'  => 'sep',
				'title' => 'درصد',
				'uniq'  => 'percent'
			],
			[
				'type'   => 'text-small',
				'target' => '.nader-circle-progress .circle .center-text span::after',
				'uniq'   => 'percent'
			],
		];
		RP_Utils::VariantUtils( $this, 'text-styles', '', $text_styles );
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$title  = $settings['title'];
		$number = $settings['number'];
		$image  = $settings['image'];
		$size  = $settings['image_size'];
        if (empty($size)) {
            $size = 'medium';
        }

		$emptyFill = $settings['emptyFill'];
		$fill      = $settings['fill'];
		$thickness = $settings['thickness'];

		?>

        <div class="nader-circle-progress">
            <div class="circle" data-xthickness="<?php echo $thickness; ?>" data-xfill="<?php echo $fill; ?>"
                 data-xemptyFill="<?php echo $emptyFill; ?>"
                 data-percent="<?php if ( ! empty( $number ) ) {
				     echo $number;
			     } ?>">
                <div class="center-text label" data-bg-image="<?php if ( ! empty( $image ) ) {
					echo esc_url( wp_get_attachment_image_url($image['id'], $size) );
				} ?>">
                    <span></span>
                    <p><?php
						if ( ! empty( $title ) ) {
							echo esc_html( $title );
						}
						?></p>
                </div>
            </div>
        </div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new NaderCircleProgress() );
