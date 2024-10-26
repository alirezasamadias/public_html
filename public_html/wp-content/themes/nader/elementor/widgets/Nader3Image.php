<?php

namespace Elementor;

use RP_Utils;
use IMAGE_EFFECT;

defined( 'ABSPATH' ) || die();

class Nader3Image extends Widget_Base {

	use IMAGE_EFFECT;

	public function get_script_depends() {

		wp_register_script( 'nader-block3image-widget', NADER_ELEMENTOR_JS_DIR . 'nader-block3image.js', ['jquery', 'nader-tilt', 'nader-rellax', 'nader-simple-parallax'], '1.0', true );

		return ['jquery', 'nader-simple-parallax', 'nader-rellax', 'nader-tilt', 'nader-block3image-widget'];

	}

	public function get_name() {
		return 'Nader3Image';
	}

	public function get_title() {
		return PLUGIN_NAME_FA . ' : 3 تصویر';
	}

	public function get_icon() {
		return 'nader-widget eicon-image';
	}

	public function get_categories() {
		return [ PLUGIN_NAME ];
	}

	protected function register_controls() {

		$this->start_controls_section( 'settings', [ 'label' => 'تنظیمات' ] );

		$image_block_style = [
			'tall-in-start'  => 'کشیده در ابتدا',
			'tall-in-end'    => 'کشیده در انتها',
			'wide-in-top'    => 'عریض در بالا',
			'wide-in-bottom' => 'عریض در پایین',
		];
		RP_Utils::SELECT_FIELD( $this, 'block-style', 'نوع', $image_block_style, 'tall-in-start' );


		RP_Utils::IMAGE( $this, 'image1', 'تصویر 1' );
		RP_Utils::IMAGE_SIZE( $this, 'image-1', 'large' );
		$this->create_parallax_controls( 'parallax-1', 'rellax-1' );
		$this->create_rellax_controls( 'rellax-1', 'tilt-1' );
		$this->create_tilt_controls( 'tilt-1', 'rellax-1' );
		$this->add_control(
			'image-1-z-index',
			[
				'label'       => 'z-index',
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => 1,
				'max'         => 1000,
				'step'        => 1,
				'default'     => 10,
				'dynamic'     => [
					'active' => true,
				],
				'selectors'   => [
                        '{{WRAPPER}} .big-img'  =>  'z-index: {{VALUE}}'
				]
			]
		);
		RP_Utils::DIVIDER_FIELD( $this, 'dvr1' );

		RP_Utils::IMAGE( $this, 'image2', 'تصویر 2' );
		RP_Utils::IMAGE_SIZE( $this, 'image-2', 'medium_large' );
		$this->create_parallax_controls( 'parallax-2', 'rellax-2' );
		$this->create_rellax_controls( 'rellax-2', 'tilt-2' );
		$this->create_tilt_controls( 'tilt-2', 'rellax-2' );
		$this->add_control(
			'image-2-z-index',
			[
				'label'       => 'z-index',
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => 1,
				'max'         => 1000,
				'step'        => 1,
				'default'     => 10,
				'dynamic'     => [
					'active' => true,
				],
				'selectors'   => [
					'{{WRAPPER}} .thumb-1'  =>  'z-index: {{VALUE}}'
				]
			]
		);

		RP_Utils::DIVIDER_FIELD( $this, 'dvr2' );

		RP_Utils::IMAGE( $this, 'image3', 'تصویر 3' );
		RP_Utils::IMAGE_SIZE( $this, 'image-3', 'medium_large' );
		$this->create_parallax_controls( 'parallax-3', 'rellax-3' );
		$this->create_rellax_controls( 'rellax-3', 'tilt-3' );
		$this->create_tilt_controls( 'tilt-3', 'rellax-3' );
		$this->add_control(
			'image-3-z-index',
			[
				'label'       => 'z-index',
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => 1,
				'max'         => 1000,
				'step'        => 1,
				'default'     => 10,
				'dynamic'     => [
					'active' => true,
				],
				'selectors'   => [
					'{{WRAPPER}} .thumb-2'  =>  'z-index: {{VALUE}}'
				]
			]
		);

		$this->end_controls_section();


		// styles
		$this->start_controls_section( 'styles', [
			'label' => 'استایل',
			'tab'   => Controls_Manager::TAB_STYLE
		] );
		$this->add_responsive_control(
			'height-tall',
			[
				'label'       => 'ارتفاع',
				'type'        => Controls_Manager::SLIDER,
				'label_block' => true,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px' => [
						'min' => 200,
						'max' => 700,
					],
				],
				'default'     => [
					'size' => 500
				],
				'condition'   => [
					'block-style' => [ 'tall-in-start', 'tall-in-end' ]
				],
				'selectors'   => [
					'{{WRAPPER}} .nader-3-image-block'             => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .nader-3-image-block .tall-img'   => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .nader-3-image-block .double-img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'height-wide',
			[
				'label'       => 'ارتفاع',
				'type'        => Controls_Manager::SLIDER,
				'label_block' => true,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px' => [
						'min' => 200,
						'max' => 700,
					],
				],
				'default'     => [
					'size' => 500
				],
				'condition'   => [
					'block-style' => [ 'wide-in-top', 'wide-in-bottom' ]
				],
				'selectors'   => [
					'{{WRAPPER}} .nader-3-image-block'             => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .nader-3-image-block .wide-img'   => 'height: calc(50% - {{gap.SIZE}}px / 2);',
					'{{WRAPPER}} .nader-3-image-block .double-img' => 'height: calc(50% - {{gap.SIZE}}px / 2);',
				],
			]
		);

		$this->add_responsive_control(
			'gap',
			[
				'label'       => 'فاصله بین',
				'type'        => Controls_Manager::SLIDER,
				'label_block' => true,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'default'     => [
					'size' => 20
				],
				'selectors'   => [
					'{{WRAPPER}} .nader-3-image-block.tall-in-start, {{WRAPPER}} .nader-3-image-block.tall-in-end'                                               => 'gap: {{SIZE}}px;',
					'{{WRAPPER}} .nader-3-image-block.wide-in-top, {{WRAPPER}} .nader-3-image-block.wide-in-bottom'                                              => 'gap: {{SIZE}}px;',
					'{{WRAPPER}} .nader-3-image-block.tall-in-start .double-img, {{WRAPPER}} .nader-3-image-block.tall-in-end .double-img'                       => 'gap: {{SIZE}}px;',
					'{{WRAPPER}} .nader-3-image-block.wide-in-top .double-img, {{WRAPPER}} .nader-3-image-block.wide-in-bottom .double-img'                      => 'gap: {{SIZE}}px;',
					'{{WRAPPER}} .nader-3-image-block.tall-in-start .double-img .thumb-img, {{WRAPPER}} .nader-3-image-block.tall-in-end .double-img .thumb-img' => 'height: calc(50% - ({{SIZE}}px / 2));',
				],
			]
		);

		$border_radius = [
			[
				'type'   => '4dir',
				'uniq'   => 'big-img',
				'css'    => 'border-radius',
				'title'  => 'خمیدگی تصویر بزرگ',
				'target' => '.big-img',
			],
			[
				'type'   => 'shadow',
				'title'  => 'سایه تصویر بزرگ',
				'uniq'   => 'big-img',
				'target' => '.big-img',
			],
			[
				'type'   => '4dir',
				'uniq'   => 'thumb-1-img',
				'css'    => 'border-radius',
				'title'  => 'خمیدگی تصویر کوچک 1',
				'target' => '.thumb-1',
			],
			[
				'type'   => 'shadow',
				'title'  => 'سایه تصویر کوجک 1',
				'uniq'   => 'thumb-1-img',
				'target' => '.thumb-1',
			],
			[
				'type'   => '4dir',
				'uniq'   => 'thumb-2-img',
				'css'    => 'border-radius',
				'title'  => 'خمیدگی تصویر کوچک 2',
				'target' => '.thumb-2',
			],
			[
				'type'   => 'shadow',
				'title'  => 'سایه تصویر کوجک 2',
				'uniq'   => 'thumb-2-img',
				'target' => '.thumb-2',
			],
		];
		RP_Utils::VariantUtils( $this, 'item-style', '', $border_radius );
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$block_style = $settings['block-style'];

		$this->add_render_attribute( 'Nader3ImgContainerAttr', 'class', 'nader-3-image-block' );
		$this->add_render_attribute( 'Nader3ImgContainerAttr', 'class', $block_style );

		$image1 = $settings['image1'];
		if ( ! empty( $image1 ) ) {
			$img_size = $settings['image-1_size'];
			$this->add_render_attribute( 'image-1', 'src', esc_url( wp_get_attachment_image_src( $image1['id'], $img_size )[0] ) );
			$this->add_render_attribute( 'image-1', 'alt', $image1['alt'] );
			$this->add_render_attribute( 'image-1', 'class', 'parallax-img-1' );

			$ps = $this->get_parallax_settings( 'parallax-1' );
			$this->add_render_attribute( 'image-1', 'data-parallax-settings', json_encode( $ps ) );

		}

		$image2 = $settings['image2'];
		if ( ! empty( $image2 ) ) {
			$img_size = $settings['image-2_size'];
			$this->add_render_attribute( 'image-2', 'src', esc_url( wp_get_attachment_image_src( $image2['id'], $img_size )[0] ) );
			$this->add_render_attribute( 'image-2', 'alt', $image2['alt'] );
			$this->add_render_attribute( 'image-2', 'class', 'parallax-img-2' );

			$ps = $this->get_parallax_settings( 'parallax-2' );
			$this->add_render_attribute( 'image-2', 'data-parallax-settings', json_encode( $ps ) );
		}

		$image3 = $settings['image3'];
		if ( ! empty( $image3 ) ) {
			$img_size = $settings['image-3_size'];
			$this->add_render_attribute( 'image-3', 'src', esc_url( wp_get_attachment_image_src( $image3['id'], $img_size )[0] ) );
			$this->add_render_attribute( 'image-3', 'alt', $image3['alt'] );
			$this->add_render_attribute( 'image-3', 'class', 'parallax-img-3' );

			$ps = $this->get_parallax_settings( 'parallax-3' );
			$this->add_render_attribute( 'image-3', 'data-parallax-settings', json_encode( $ps ) );
		}


		?>

        <div <?php $this->print_render_attribute_string( 'Nader3ImgContainerAttr' ); ?>>

			<?php
			if ( $block_style === 'tall-in-start' || $block_style === 'tall-in-end' ) {
				$ts = $this->get_tilt_settings( 'tilt-1' );
				$rs = $this->get_rellax_settings( 'rellax-1' );
				$this->add_render_attribute( 'tall-img-box', 'class', 'tall-img big-img' );
				$this->add_render_attribute( 'tall-img-box', 'data-tilt-settings', json_encode( $ts ) );
				$this->add_render_attribute( 'tall-img-box', 'data-rellax-settings', json_encode( $rs ) );
				?>
                <div <?php $this->print_render_attribute_string( 'tall-img-box' ); ?>>
                    <img <?php $this->print_render_attribute_string( 'image-1' ); ?>>
                </div>
				<?php
			}
			?>

            <div class="double-img">
				<?php
				$ts = $this->get_tilt_settings( 'tilt-2' );
				$rs = $this->get_rellax_settings( 'rellax-2' );
				$this->add_render_attribute( 'thumb-1-img-box', 'class', 'thumb-img thumb-1' );
				$this->add_render_attribute( 'thumb-1-img-box', 'data-tilt-settings', json_encode( $ts ) );
				$this->add_render_attribute( 'thumb-1-img-box', 'data-rellax-settings', json_encode( $rs ) );

				?>
                <div <?php $this->print_render_attribute_string( 'thumb-1-img-box' ); ?>>
                    <img <?php $this->print_render_attribute_string( 'image-2' ); ?>>
                </div>

				<?php
				$ts = $this->get_tilt_settings( 'tilt-3' );
				$rs = $this->get_rellax_settings( 'rellax-3' );
				$this->add_render_attribute( 'thumb-2-img-box', 'class', 'thumb-img thumb-2' );
				$this->add_render_attribute( 'thumb-2-img-box', 'data-tilt-settings', json_encode( $ts ) );
				$this->add_render_attribute( 'thumb-2-img-box', 'data-rellax-settings', json_encode( $rs ) );

				?>
                <div <?php $this->print_render_attribute_string( 'thumb-2-img-box' ); ?>>
                    <img <?php $this->print_render_attribute_string( 'image-3' ); ?>>
                </div>
            </div>

			<?php
			if ( $block_style === 'wide-in-top' || $block_style === 'wide-in-bottom' ) {
				$ts = $this->get_tilt_settings( 'tilt-1' );
				$rs = $this->get_rellax_settings( 'rellax-1' );
				$this->add_render_attribute( 'wide-img-box', 'class', 'wide-img big-img' );
				$this->add_render_attribute( 'wide-img-box', 'data-tilt-settings', json_encode( $ts ) );
				$this->add_render_attribute( 'wide-img-box', 'data-rellax-settings', json_encode( $rs ) );

				?>
                <div <?php $this->print_render_attribute_string( 'wide-img-box' ); ?>>
                    <img <?php $this->print_render_attribute_string( 'image-1' ); ?>>
                </div>
				<?php
			}
			?>
        </div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new Nader3Image() );
