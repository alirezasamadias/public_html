<?php

namespace Elementor;

use RP_Utils;
use IMAGE_EFFECT;

defined( 'ABSPATH' ) || die();

class Nader2Image extends Widget_Base {

	use IMAGE_EFFECT;

	public function get_script_depends() {

		wp_register_script( 'nader-block2image-widget', NADER_ELEMENTOR_JS_DIR . 'nader-block2image.js', ['jquery', 'nader-tilt', 'nader-rellax', 'nader-simple-parallax'], '1.0', true );

		return [
			'jquery',
			'nader-rellax',
			'nader-simple-parallax',
			'nader-tilt',
			'nader-block2image-widget'
		];

	}

	public function get_name() {
		return 'Nader2Image';
	}

	public function get_title() {
		return PLUGIN_NAME_FA . ' : 2 تصویر';
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
			'corner-top-left'     => 'گوشه بالا چپ',
			'corner-top-right'    => 'گوشه بالا راست',
			'corner-bottom-right' => 'گوشه پایین راست',
			'corner-bottom-left'  => 'گوشه پایین چپ',
			'strait-left'         => 'مستقیم چپ',
			'strait-right'        => 'مستقیم راست',
		];
		RP_Utils::SELECT_FIELD( $this, 'block-style', 'نوع', $image_block_style, 'corner-bottom-left' );

		RP_Utils::DIVIDER_FIELD( $this, 'dvr1' );

		RP_Utils::IMAGE( $this, 'image1', 'تصویر 1' );
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image-1',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'large',
				'separator' => 'none',
				'exclude'   => [ 'custom' ]
			]
		);
		$this->create_rellax_controls( 'rellax-1', 'tilt-1' );
		$this->create_tilt_controls( 'tilt-1', 'rellax-1' );

		RP_Utils::DIVIDER_FIELD( $this, 'dvr2' );

		RP_Utils::IMAGE( $this, 'image2', 'تصویر 2' );
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image-2',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'medium_large',
				'separator' => 'none',
				'exclude'   => [ 'custom' ]
			]
		);
		$this->create_rellax_controls( 'rellax-2', 'tilt-2' );
		$this->create_tilt_controls( 'tilt-2', 'rellax-2' );

		$this->end_controls_section();


		// styles
		$this->start_controls_section( 'styles', [
			'label' => 'استایل',
			'tab'   => Controls_Manager::TAB_STYLE
		] );
		$this->add_responsive_control(
			'main-height',
			[
				'label'       => 'ارتفاع',
				'type'        => Controls_Manager::SLIDER,
				'label_block' => true,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px' => [
						'min' => 200,
						'max' => 900,
					],
				],
				'default'     => [
					'size' => 500
				],
				'selectors'   => [
					'{{WRAPPER}} .nader-2-image-block' => 'height: {{SIZE}}px;',
				],
			]
		);
		$this->add_responsive_control(
			'image-1-height',
			[
				'label'       => 'ارتفاع تصویر 1',
				'type'        => Controls_Manager::SLIDER,
				'label_block' => true,
				'size_units'  => [ '%' ],
				'selectors'   => [
					'{{WRAPPER}} .nader-2-image-block.corner-top-left .image-box-1'     => 'height: {{SIZE}}%;',
					'{{WRAPPER}} .nader-2-image-block.corner-top-right .image-box-1'    => 'height: {{SIZE}}%;',
					'{{WRAPPER}} .nader-2-image-block.corner-bottom-left .image-box-1'  => 'height: {{SIZE}}%;',
					'{{WRAPPER}} .nader-2-image-block.corner-bottom-right .image-box-1' => 'height: {{SIZE}}%;',
				],
				'condition'   => [
					'block-style' => [
						'corner-top-left',
						'corner-top-right',
						'corner-bottom-left',
						'corner-bottom-right',
					]
				]
			]
		);
		$this->add_responsive_control(
			'image-1-width',
			[
				'label'       => 'عرض تصویر 1',
				'type'        => Controls_Manager::SLIDER,
				'label_block' => true,
				'size_units'  => [ '%' ],
				'selectors'   => [
					'{{WRAPPER}} .nader-1-image-block.strait-left .image-box-1'         => 'width: {{SIZE}}%;',
					'{{WRAPPER}} .nader-1-image-block.strait-right .image-box-1'        => 'width: {{SIZE}}%;',
					'{{WRAPPER}} .nader-1-image-block.corner-top-left .image-box-1'     => 'width: {{SIZE}}%;',
					'{{WRAPPER}} .nader-1-image-block.corner-top-right .image-box-1'    => 'width: {{SIZE}}%; right: calc(100% - {{SIZE}}%);',
					'{{WRAPPER}} .nader-1-image-block.corner-bottom-left .image-box-1'  => 'width: {{SIZE}}%;',
					'{{WRAPPER}} .nader-1-image-block.corner-bottom-right .image-box-1' => 'width: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'image-2-height',
			[
				'label'       => 'ارتفاع تصویر 2',
				'type'        => Controls_Manager::SLIDER,
				'label_block' => true,
				'size_units'  => [ '%' ],
				'selectors'   => [
					'{{WRAPPER}} .nader-2-image-block.strait-left .image-box-2'         => 'height: {{SIZE}}%; top: calc((100% - {{SIZE}}%) / 2);',
					'{{WRAPPER}} .nader-2-image-block.strait-right .image-box-2'        => 'height: {{SIZE}}%; top: calc((100% - {{SIZE}}%) / 2);',
					'{{WRAPPER}} .nader-2-image-block.corner-top-left .image-box-2'     => 'height: {{SIZE}}%;',
					'{{WRAPPER}} .nader-2-image-block.corner-top-right .image-box-2'    => 'height: {{SIZE}}%;',
					'{{WRAPPER}} .nader-2-image-block.corner-bottom-left .image-box-2'  => 'height: {{SIZE}}%;',
					'{{WRAPPER}} .nader-2-image-block.corner-bottom-right .image-box-2' => 'height: {{SIZE}}%;',
				],
			]
		);
		$this->add_responsive_control(
			'image-2-width',
			[
				'label'       => 'عرض تصویر 2',
				'type'        => Controls_Manager::SLIDER,
				'label_block' => true,
				'size_units'  => [ '%' ],
				'selectors'   => [
					'{{WRAPPER}} .nader-2-image-block.strait-left .image-box-2'         => 'width: {{SIZE}}%;',
					'{{WRAPPER}} .nader-2-image-block.strait-right .image-box-2'        => 'width: {{SIZE}}%;',
					'{{WRAPPER}} .nader-2-image-block.corner-top-left .image-box-2'     => 'width: {{SIZE}}%;',
					'{{WRAPPER}} .nader-2-image-block.corner-top-right .image-box-2'    => 'width: {{SIZE}}%;',
					'{{WRAPPER}} .nader-2-image-block.corner-bottom-left .image-box-2'  => 'width: {{SIZE}}%;',
					'{{WRAPPER}} .nader-2-image-block.corner-bottom-right .image-box-2' => 'width: {{SIZE}}%;',
				],
			]
		);


		$styles = [
			[
				'type'   => '4dir',
				'title'  => 'خمیدگی تصویر 1',
				'css'    => 'border-radius',
				'target' => '.nader-2-image-block .image-box-1',
				'uniq'   => 'image-1'
			],
			[
				'type'   => 'shadow',
				'title'  => 'سایه تصویر 1',
				'target' => '.nader-2-image-block .image-box-1',
				'uniq'   => 'image-1'
			],
			[
				'type'   => '4dir',
				'title'  => 'خمیدگی تصویر 2',
				'css'    => 'border-radius',
				'target' => '.nader-2-image-block .image-box-2',
				'uniq'   => 'image-2'
			],
			[
				'type'   => 'shadow',
				'title'  => 'سایه تصویر 2',
				'target' => '.nader-2-image-block .image-box-2',
				'uniq'   => 'image-2'
			],
		];
		RP_Utils::VariantUtils( $this, 'styles', '', $styles );
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$block_style = $settings['block-style'];
		$this->add_render_attribute( 'Nader2ImgContainerAttr', 'class', 'nader-2-image-block' );
		$this->add_render_attribute( 'Nader2ImgContainerAttr', 'class', $block_style );


		// image 1 settings & attributes
		$ts = $this->get_tilt_settings( 'tilt-1' );
		$rs = $this->get_rellax_settings( 'rellax-1' );
		$this->add_render_attribute( 'image-1-attr', 'data-tilt-settings', json_encode( $ts ) );
		$this->add_render_attribute( 'image-1-attr', 'data-rellax-settings', json_encode( $rs ) );
		$this->add_render_attribute( 'image-1-attr', 'class', 'image-box image-box-1' );

		$image1 = $settings['image1'];
		if ( ! empty( $image1 ) ) {
			$img_size = $settings['image-1_size'];
			$this->add_render_attribute( 'image-1', 'src', esc_url( wp_get_attachment_image_src( $image1['id'], $img_size )[0] ) );
			$this->add_render_attribute( 'image-1', 'alt', $image1['alt'] );
		}


		// image 2 settings & attributes
		$ts = $this->get_tilt_settings( 'tilt-2' );
		$rs = $this->get_rellax_settings( 'rellax-2' );
		$this->add_render_attribute( 'image-2-attr', 'data-tilt-settings', json_encode( $ts ) );
		$this->add_render_attribute( 'image-2-attr', 'data-rellax-settings', json_encode( $rs ) );
		$this->add_render_attribute( 'image-2-attr', 'class', 'image-box image-box-2' );

		$image2 = $settings['image2'];
		if ( ! empty( $image2 ) ) {
			$img_size = $settings['image-2_size'];
			$this->add_render_attribute( 'image-2', 'src', esc_url( wp_get_attachment_image_src( $image2['id'], $img_size )[0] ) );
			$this->add_render_attribute( 'image-2', 'alt', $image2['alt'] );
		}

		?>

        <div <?php $this->print_render_attribute_string( 'Nader2ImgContainerAttr' ); ?>>

            <div <?php $this->print_render_attribute_string( 'image-1-attr' ); ?>>
                <img <?php $this->print_render_attribute_string( 'image-1' ); ?>>
            </div>

            <div <?php $this->print_render_attribute_string( 'image-2-attr' ); ?>>
                <img <?php $this->print_render_attribute_string( 'image-2' ); ?>>
            </div>

        </div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new Nader2Image() );
