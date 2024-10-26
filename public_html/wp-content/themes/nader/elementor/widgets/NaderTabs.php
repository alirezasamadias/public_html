<?php

namespace Elementor;

use RP_Utils;
use RealPressHelper;

defined( 'ABSPATH' ) || die();

class NaderTabs extends Widget_Base {

	public function get_script_depends() {
		wp_register_script( 'nader-tabs-widget',
			NADER_ELEMENTOR_JS_DIR . 'nader-tabs.js',
			[ 'jquery' ],
			'1.0.0',
			true );

		return [ 'jquery', 'nader-tabs-widget' ];
	}

	public function get_name() {
		return 'NaderTabs';
	}

	public function get_title() {
		return PLUGIN_NAME_FA . ' : زبانه ها';
	}

	public function get_icon() {
		return 'nader-widget eicon-tabs';
	}

	public function get_keywords() {
		return [ 'accordion', 'tabs', 'toggle', 'آکاردئون', 'تب' ];
	}

	private function getTemplates() {
		$stack = [];
		$Query = new \WP_Query( $defaults = [
			'post_type'      => 'elementor_library',
			'posts_per_page' => - 1
		] );

		if ( $Query->have_posts() ) {
			while ( $Query->have_posts() ) {
				$Query->the_post();
				$stack[ get_the_ID() ] = get_the_title();
			}
		}

		wp_reset_postdata();

		return $stack;
	}

	public function get_categories() {
		return [ PLUGIN_NAME ];
	}

	protected function register_controls() {
		$this->start_controls_section( 'settings', [ 'label' => 'تنظیمات' ] );

		$tabs = new \Elementor\Repeater();
		RP_Utils::TXT_FIELD( $tabs, 'title', 'عنوان' );
		RP_Utils::ICON( $tabs, 'tab-' );
		RP_Utils::SELECT_FIELD( $tabs, 'content-type', 'نوع محتوا', [
			'WYSIWYG'  => 'متن',
			'TEMPLATE' => 'قالب'
		], 'WYSIWYG' );
		$tabs->add_control(
			'description',
			[
				'label'       => 'توضیح',
				'type'        => \Elementor\Controls_Manager::WYSIWYG,
				'placeholder' => 'متن خود را بنویسید',
				'condition'   => [
					'content-type' => 'WYSIWYG'
				]
			]
		);
		$templates = $this->getTemplates();
		$tabs->add_control(
			'template',
			[
				'label'       => 'قالب',
				'type'        => Controls_Manager::SELECT,
				'label_block' => false,
				'options'     => $templates,
				'condition'   => [
					'content-type' => 'TEMPLATE'
				]
			]
		);
		$this->add_control(
			'tabs',
			[
				'label'       => 'تب ها',
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $tabs->get_controls(),
				'title_field' => '{{{ title }}}',
			]
		);

		RP_Utils::DIVIDER_FIELD( $this, 'd1' );

		RP_Utils::HTML_TAG( $this, 'title-tag', 'عنوان' );

		RP_Utils::DIVIDER_FIELD( $this, 'd2' );

		$this->add_responsive_control(
			'tab-type',
			[
				'label'     => 'جهت',
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'row'    => [
						'title' => 'افقی',
						'icon'  => 'eicon-h-align-left',
					],
					'column' => [
						'title' => 'عمودی',
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'   => 'column',
				'selectors' => [
					'{{WRAPPER}} .nader-tabs' => 'flex-direction: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'tab-alignment-row',
			[
				'label'     => 'تراز',
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => 'ابتدا',
						'icon'  => 'eicon-v-align-top',
					],
					'center'     => [
						'title' => 'وسط',
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end'   => [
						'title' => 'انتها',
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'   => 'center',
				'condition' => [
					'tab-type' => 'row'
				],
				'selectors' => [
					'{{WRAPPER}} .nader-tabs' => 'align-items: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section( 'header', [
			'label' => 'سربرگ',
			'tab'   => Controls_Manager::TAB_STYLE
		] );
		$this->add_responsive_control(
			'heading-item-width',
			[
				'label'       => 'عرض',
				'type'        => Controls_Manager::SLIDER,
				'label_block' => true,
				'size_units'  => [ 'px', '%' ],
				'range'       => [
					'px' => [
						'min' => 60,
						'max' => 360,
					],
				],
				'condition'   => [
					'tab-type' => 'row'
				],
				'selectors'   => [
					'{{WRAPPER}} .nader-tabs .nader-tabs-header' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$header_styles = [
			[
				'type'  => 'slider',
				'title' => 'فاصله بین آیتم ها',
				'min'   => 0,
				'max'   => 100,
				'def'   => 0,
				'css'   => 'gap',
			],
			[
				'type'  => '4dir',
				'title' => 'فاصله داخلی',
				'css'   => 'padding'
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
				'title' => 'خمیدگی',
				'css'   => 'border-radius'
			],
			[
				'type'  => 'shadow',
				'title' => 'سایه'
			],
		];
		RP_Utils::VariantUtils( $this,
			'header-style',
			'.nader-tabs .nader-tabs-header',
			$header_styles );

		$this->end_controls_section();


		// styles
		$this->start_controls_section( 'header-items', [
			'label' => 'آیتم های سربرگ',
			'tab'   => Controls_Manager::TAB_STYLE
		] );
		$this->add_responsive_control(
			'tab-title-alignment',
			[
				'label'     => 'جهت',
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => 'ابتدا',
						'icon'  => 'eicon-h-align-right',
					],
					'center'     => [
						'title' => 'وسط',
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'   => [
						'title' => 'انتها',
						'icon'  => 'eicon-h-align-left',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .nader-tabs .nader-tabs-header .nader-tabs-item-title' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$header_items_styles = [
			[
				'type'   => 'slider',
				'title'  => 'فاصله آیکون و متن',
				'min'    => 0,
				'max'    => 100,
				'def'    => 15,
				'css'    => 'gap',
				'uniq'   => 'between-text-and-title',
				'target' => '.nader-tabs .nader-tabs-header .nader-tabs-item-title .title'
			],
			[
				'type'  => '4dir',
				'css'   => 'padding',
				'title' => 'فاصله داخلی'
			],
			[
				'type'   => 'font',
				'title'  => 'تایپوگرافی',
				'target' => '.nader-tabs .nader-tabs-header .nader-tabs-item-title .title'
			],
			[
				'type' => 'tab-start'
			],
			[
				'type'   => 'color',
				'title'  => 'رنگ',
				'target' => '.nader-tabs .nader-tabs-header .nader-tabs-item-title .title'
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
			[
				'type'  => 'tab-middle',
				'title' => 'حالت فعال'
			],
			[
				'type'   => 'color',
				'title'  => 'رنگ',
				'uniq'   => 'active',
				'target' => '.nader-tabs .nader-tabs-header .nader-tabs-item-title.active .title'
			],
			[
				'type'   => 'bg-c',
				'uniq'   => 'active',
				'target' => '.nader-tabs .nader-tabs-header .nader-tabs-item-title.active'
			],
			[
				'type'   => 'border',
				'title'  => 'حاشیه',
				'uniq'   => 'active',
				'target' => '.nader-tabs .nader-tabs-header .nader-tabs-item-title.active'
			],
			[
				'type'   => '4dir',
				'css'    => 'border-radius',
				'title'  => 'خمیدگی',
				'uniq'   => 'active',
				'target' => '.nader-tabs .nader-tabs-header .nader-tabs-item-title.active'
			],
			[
				'type'   => 'shadow',
				'title'  => 'سایه',
				'uniq'   => 'active',
				'target' => '.nader-tabs .nader-tabs-header .nader-tabs-item-title.active'
			],
			[
				'type' => 'tab-end'
			],
            [
                    'type'  =>  'sep',
                    'title' =>  'آیکون'
            ]
		];
		RP_Utils::VariantUtils( $this,
			'header-items-style',
			'.nader-tabs .nader-tabs-header .nader-tabs-item-title',
			$header_items_styles );

		// main icon styles
		$this->add_responsive_control(
			'header-icon-size',
			[
				'label'      => 'اندازه آیکون',
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 16,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 14,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .nader-tabs .nader-tabs-header .nader-tabs-item-title .title i'   => 'font-size: {{SIZE}}px;',
					'{{WRAPPER}} .nader-tabs .nader-tabs-header .nader-tabs-item-title .title svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
					'{{WRAPPER}} .nader-tabs .nader-tabs-header .nader-tabs-item-title .title img' => 'width: {{SIZE}}px;',
				],
			]
		);
		$this->add_responsive_control(
			'header-icon-size_active',
			[
				'label'      => 'اندازه آیکون فعال',
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 14,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .nader-tabs .nader-tabs-header .nader-tabs-item-title.active .title i'   => 'font-size: {{SIZE}}px;',
					'{{WRAPPER}} .nader-tabs .nader-tabs-header .nader-tabs-item-title.active .title svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
					'{{WRAPPER}} .nader-tabs .nader-tabs-header .nader-tabs-item-title.active .title img' => 'width: {{SIZE}}px;',
				],
			]
		);
		$this->add_control(
			'header-icon-color',
			[
				'label'       => 'رنگ آیکون',
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .nader-tabs .nader-tabs-header .nader-tabs-item-title .title i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .nader-tabs .nader-tabs-header .nader-tabs-item-title .title svg' => 'fill: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'header-icon-color-active',
			[
				'label'       => 'رنگ فعال آیکون',
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .nader-tabs .nader-tabs-header .nader-tabs-item-title.active .title i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .nader-tabs .nader-tabs-header .nader-tabs-item-title.active .title svg' => 'fill: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();


		$this->start_controls_section( 'body', [
			'label' => 'بدنه',
			'tab'   => Controls_Manager::TAB_STYLE
		] );
		$this->add_responsive_control(
			'body-item-width',
			[
				'label'       => 'عرض',
				'type'        => Controls_Manager::SLIDER,
				'label_block' => true,
				'size_units'  => [ 'px', '%' ],
				'range'       => [
					'px' => [
						'min' => 200,
						'max' => 1400,
					],
				],
				'condition'   => [
					'tab-type' => 'row'
				],
				'selectors'   => [
					'{{WRAPPER}} .nader-tabs .nader-tabs-body' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$body_styles = [
			[
				'type'   => 'text-small',
				'target' => '.nader-tabs .nader-tabs-body .nader-tabs-item-content.tab-content-type-WYSIWYG p',
			],
			[
				'type'   => 'text-align',
				'target' => '.nader-tabs .nader-tabs-body .nader-tabs-item-content.tab-content-type-WYSIWYG p'
			],
			[
				'type'  => '4dir',
				'css'   => 'padding',
				'title' => 'فاصله داخلی'
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
                'title' =>  'سایه',
            ]
		];
		RP_Utils::VariantUtils( $this, 'body-style', '.nader-tabs .nader-tabs-body', $body_styles );
		$this->end_controls_section();
	}


	protected function render() {
		$settings = $this->get_settings_for_display();
		$ID       = $this->get_id();

		$tabs = $settings['tabs'];
		$tt   = $settings['title-tag'];

		if ( ! empty( $tabs ) ) {
			?>

            <div class="nader-tabs tabs-<?php echo $ID; ?>">

                <div class="nader-tabs-header dfx aic">
					<?php
					$i = 1;
					foreach ( $tabs as $tab ) {
						?>
                        <div role="button"
                             class="nader-tabs-item-title dfx aic jcc<?php if ( $i === 1 ) {
							     echo ' active';
						     } ?>"
                             data-tab-target=".tabs-<?php echo $ID; ?> .nader-tabs-content-fi-<?php echo $i; ?>">
							<?php
							echo '<' . $tt . ' class="title dfx aic jcc">';
							RP_Utils::ICON_PRINT( $this, $tab, 'tab-' );
							echo esc_html( $tab['title'] );
							echo '</' . $tt . '>';
							?>
                        </div>
						<?php
						$i ++;
					} ?>
                </div>

                <div class="nader-tabs-body">
					<?php
					$j = 1;
					foreach ( $tabs as $tab ) {
						$content_type = $tab['content-type'];
						?>
                        <div class="nader-tabs-item-content tab-content-type-<?php echo esc_html($content_type); ?> nader-tabs-content-fi-<?php echo $j;
						if ( $j === 1 ) {
							echo ' active show';
						} ?>">
							<?php
							if ( $content_type === 'WYSIWYG' ) {
								echo $tab['description'];
							}
							if ( $content_type === 'TEMPLATE' ) {
								RealPressHelper::loadElementorContent( $tab['template'] );
							}
							?>
                        </div>
						<?php
						$j ++;
					} ?>
                </div>

            </div>

			<?php
		}
	}

}

Plugin::instance()->widgets_manager->register( new NaderTabs() );
