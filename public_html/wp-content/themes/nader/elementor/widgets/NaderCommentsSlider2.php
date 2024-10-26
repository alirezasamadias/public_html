<?php

namespace Elementor;

use RP_Utils;
use OwlCarousel;

defined( 'ABSPATH' ) || die();

class NaderCommentsSlider2 extends Widget_Base {

	use OwlCarousel;

	public function get_script_depends() {
		wp_register_script( 'nader-owl-carousel', NADER_JS_DIR . 'owl.carousel.min.js', [ 'jquery' ], 1, true );
		wp_register_script( 'nader-comments-slider-2-widget', NADER_ELEMENTOR_JS_DIR . 'nader-comments-slider-2.js', ['jquery', 'nader-owl-carousel'], '1.0.0', true );

		return [
			'jquery', 'nader-owl-carousel', 'nader-comments-slider-2-widget'
		];
	}

	public function get_style_depends() {
		wp_register_style( 'nader-owl-css', NADER_CSS_DIR . 'owl.carousel.min.css', [], 1 );
		return ['nader-owl-css' ];
	}

	public function get_name() {
		return 'NaderCommentsSlider2';
	}

	public function get_title() {
		return PLUGIN_NAME_FA . ' : اسلایدر نظرات 2';
	}

	public function get_icon() {
		return 'nader-widget eicon-testimonial-carousel';
	}

	public function get_categories() {
		return [ PLUGIN_NAME ];
	}

	protected function register_controls() {
		$this->start_controls_section( 'settings', [ 'label' => 'تنظیمات' ] );

		$comments = new \Elementor\Repeater();
		RP_Utils::TXT_FIELD( $comments, 'name', 'نام' );
		RP_Utils::TXT_FIELD( $comments, 'position', 'جایگاه' );
		RP_Utils::TEXTAREA( $comments, 'description', 'توضیح' );
		RP_Utils::IMAGE( $comments, 'image', 'تصویر' );
		$this->add_control( 'comments', [
			'label' => 'نظرات', 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $comments->get_controls(), 'title_field' => '{{{ name }}}',
		] );

		RP_Utils::SWITCH_FIELD( $this, 'quote-icon', 'آیکون بالای نظر', 'yes' );
		RP_Utils::ICON( $this, 'quote-icon', 'fas fa-quote-right' );

		$this->end_controls_section();


		// slider settings
		$this->OwlSettings();


		// Comment Box Item
		$this->start_controls_section( 'comment-item-box-style', [
			'label' => 'باکس آیتم', 'tab' => Controls_Manager::TAB_STYLE
		] );
		$cm_item_box_style = [ [ 'type' => 'box-styles' ] ];
		RP_Utils::VariantUtils( $this, 'cm-item-box-style', '.comment-item', $cm_item_box_style );
		$this->end_controls_section();


		// QUOTE ICON STYLES
		$this->start_controls_section( 'comment-icon-style', [
			'label'     => 'آیکون', 'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'quote-icon' => 'yes'
			]
		] );
		$this->add_responsive_control(
			'quote-alignment',
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
				'default'   => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .nader-comments-slider-2 .comment-item .quote-icon .icon' => 'justify-content: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'quote-icon-size',
			[
				'label'      => 'اندازه',
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default'    => [
					'size' => 60
				],
				'range'      => [
					'px' => [
						'min' => 20,
						'max' => 120,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .nader-comments-slider-2 .comment-item .quote-icon .icon i'   => 'font-size: {{SIZE}}px;',
					'{{WRAPPER}} .nader-comments-slider-2 .comment-item .quote-icon .icon svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
					'{{WRAPPER}} .nader-comments-slider-2 .comment-item .quote-icon .icon img' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
				],
			]
		);
		$this->add_control(
			'quote-color',
			[
				'label'       => 'رنگ',
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::COLOR,
				'default'     => '#dfdfdf',
				'selectors'   => [
					'{{WRAPPER}} .nader-comments-slider-2 .comment-item .quote-icon .icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .nader-comments-slider-2 .comment-item .quote-icon .icon svg' => 'fill: {{VALUE}};',
				]
			]
		);
		$this->end_controls_section();


		// TEXTS STYLES
		$this->start_controls_section( 'comment-item-text-style', [
			'label' => 'متن', 'tab' => Controls_Manager::TAB_STYLE
		] );
		$cm_item_texts_style = [
			[
				'type'  => 'sep',
				'title' => 'متنِ نظر',
				'uniq'  => 'description'
			],
			[
				'type'   => 'text-small',
				'uniq'   => 'description',
				'target' => '.nader-comments-slider-2 .comment-item p'
			],
			[
				'type'   => 'slider',
				'title'  => 'فاصله بالا',
				'min'    => 0,
				'max'    => 50,
				'def'    => 10,
				'css'    => 'margin-top',
				'target' => '.nader-comments-slider-2 .comment-item p'
			],
			[
				'type'   => 'slider',
				'title'  => 'فاصله پایین',
				'min'    => 0,
				'max'    => 50,
				'def'    => 30,
				'css'    => 'margin-bottom',
				'target' => '.nader-comments-slider-2 .comment-item p'
			],
			[
				'type'  => 'sep',
				'title' => 'نام',
				'uniq'  => 'name'
			],
			[
				'type'   => 'text-small',
				'uniq'   => 'name',
				'target' => '.nader-comments-slider-2 .comment-item .details strong'
			],
			[
				'type'  => 'sep',
				'title' => 'جایگاه',
				'uniq'  => 'position'
			],
			[
				'type'   => 'text-small',
				'uniq'   => 'position',
				'target' => '.nader-comments-slider-2 .comment-item .details span'
			]
		];
		RP_Utils::VariantUtils( $this, 'cm-item-texts-style', '', $cm_item_texts_style );
		$this->end_controls_section();


		// IMAGE STYLES
		$this->start_controls_section( 'comment-item-image-style', [
			'label' => 'تصویر', 'tab' => Controls_Manager::TAB_STYLE
		] );
		$image_styles = [
			[
				'type'  => 'slider',
				'title' => 'عرض',
				'min'   => 50,
				'max'   => 120,
				'def'   => 70,
				'css'   => 'width',
			],
			[
				'type'  => 'slider',
				'title' => 'ارتفاع',
				'min'   => 50,
				'max'   => 120,
				'def'   => 70,
				'css'   => 'height',
			],
			[
				'type' => 'box-styles'
			]
		];
		RP_Utils::VariantUtils( $this,
			'cm-item-image-style',
			'.nader-comments-slider-2 .comment-item .info img',
			$image_styles );
		$this->end_controls_section();


		// slider next prev buttons styles
		$this->OwlStylesNextPrevBtn();

		// slider dots styles
		$this->OwlStylesDotSettings();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
//        echo '<pre>';
//        var_dump($settings);
//        echo '</pre>';

		$slider_settings = $this->RenderOwlSettings();
		$this->add_render_attribute( 'nader-comments-slider-2-attrs',
			'class',
			'nader-comments-slider-2' );
		$this->add_render_attribute( 'nader-comments-slider-2-attrs',
			'class',
			'owl-carousel' );
		$this->add_render_attribute( 'nader-comments-slider-2-attrs',
			'data-slider-settings',
			json_encode( $slider_settings ) );


		$comments = $settings['comments'];

		if ( ! empty( $comments ) ) {
			?>

            <!--start comment item-->
            <div <?php $this->print_render_attribute_string( 'nader-comments-slider-2-attrs' ); ?>>

				<?php
				foreach ( $comments as $comment ) {
					$name        = $comment['name'];
					$position    = $comment['position'];
					$description = $comment['description'];
					$image       = $comment['image'];

					$quote_icon_switch = $settings['quote-icon'];

					?>
                    <div class="comment-item-wrapper">
                        <div class="comment-item">

							<?php if ( ! empty( $quote_icon_switch ) ) { ?>
                                <div class="quote-icon">
									<?php RP_Utils::ICON_PRINT( $this, $settings, 'quote-icon' ); ?>
                                </div>
							<?php } ?>

                            <p class="description">
								<?php echo esc_html( $description ); ?>
                            </p>

                            <div class="info dfx aic">
                                <img src="<?php echo esc_url( $image['url'] ); ?>"
                                     alt="<?php echo esc_html( $name ); ?>">
                                <div class="details">
                                    <strong><?php echo esc_html( $name ); ?></strong>
                                    <span><?php echo esc_html( $position ); ?></span>
                                </div>
                            </div>

                        </div>
                    </div>

				<?php } ?>

            </div>
            <!--end comment item-->

			<?php
		}
	}

}

Plugin::instance()->widgets_manager->register( new NaderCommentsSlider2() );
