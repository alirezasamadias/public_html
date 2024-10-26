<?php

namespace Elementor;

use RP_Utils;

defined( 'ABSPATH' ) || die();

class NaderPriceTable extends Widget_Base {

	use \BUTTON_TRAIT;

	public function get_name() {
		return 'NaderPriceTable';
	}

	public function get_title() {
		return PLUGIN_NAME_FA . ' : باکس قیمت';
	}

	public function get_icon() {
		return 'nader-widget eicon-price-table';
	}

	public function get_categories() {
		return [ PLUGIN_NAME ];
	}

	protected function register_controls() {

		$this->start_controls_section( 'settings', [ 'label' => 'تنظیمات' ] );

		RP_Utils::TXT_FIELD( $this, 'title', 'عنوان', 'جدول تعرفه', true );
		RP_Utils::TXT_FIELD( $this, 'price', 'قیمت', '8000 ت', true );

		RP_Utils::ICON( $this, 'price-table-' );


		$price_features = new \Elementor\Repeater();
		RP_Utils::TXT_FIELD( $price_features, 'text', 'متن' );
		$this->add_control(
			'price_features',
			[
				'label'       => 'موارد',
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $price_features->get_controls(),
				'title_field' => '{{{ text }}}',
			]
		);

		$this->end_controls_section();


		// button settings
		$this->start_controls_section( 'btn-settings', [ 'label' => 'دکمه' ] );
		// in trait_nader_button
		$this->nader_button_1_settings();
		$this->end_controls_section();


		// text styles
		$this->start_controls_section( 'styles', [
			'label' => 'استایل کلی',
			'tab'   => Controls_Manager::TAB_STYLE
		] );
		$price_list_style = [
			[
				'type' => 'box-styles'
			]
		];
		RP_Utils::VariantUtils( $this, 'price-list-style', '.nader-pricing-plan-item', $price_list_style );
		$this->end_controls_section();


		// icon style
		$this->start_controls_section( 'icon-style', [
			'label' => 'آیکون هدر',
			'tab'   => Controls_Manager::TAB_STYLE
		] );

		$icon_box_style = [
			[
				'type'  => 'sep',
				'title' => 'باکس آیکون',
				'uniq'  => 'box-icon'
			],
			[
				'type'  => 'slider',
				'title' => 'عرض',
				'min'   => 60,
				'max'   => 150,
				'def'   => 82,
				'css'   => 'width',
			],
			[
				'type'  => '4dir',
				'title' => 'خمیدگی',
				'css'   => 'border-radius',
			],
			[
				'type' => 'bg',
				'uniq' => 'normal'
			],
			[
				'type'   => 'bg',
				'uniq'   => 'hover',
				'target' => '.nader-pricing-plan-item:hover .pricing-header .icon'
			],
			[
				'type'  => 'sep',
				'title' => 'آیکون',
				'uniq'  => 'icon'
			],

		];
		RP_Utils::VariantUtils( $this, 'icon-box', '.nader-pricing-plan-item .pricing-header .icon', $icon_box_style );

		$this->add_responsive_control(
			'pricing-plan-item-icon-size',
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
					'{{WRAPPER}} .nader-pricing-plan-item .pricing-header .icon i'   => 'font-size: {{SIZE}}px;',
					'{{WRAPPER}} .nader-pricing-plan-item .pricing-header .icon svg' => 'width: {{SIZE}}px;',
					'{{WRAPPER}} .nader-pricing-plan-item .pricing-header .icon img' => 'width: {{SIZE}}px;',
				],
			]
		);
		$this->add_control(
			'pricing-plan-item-icon-color-normal',
			[
				'label'       => 'رنگ',
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::COLOR,
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .nader-pricing-plan-item .pricing-header .icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .nader-pricing-plan-item .pricing-header .icon svg' => 'fill: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'pricing-plan-item-icon-color-hover',
			[
				'label'       => 'رنگ هاور',
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::COLOR,
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .nader-pricing-plan-item:hover .pricing-header .icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .nader-pricing-plan-item:hover .pricing-header .icon svg' => 'fill: {{VALUE}};',
				]
			]
		);
		$this->end_controls_section();


		// icon style
		$this->start_controls_section( 'content-style', [
			'label' => 'محتوا',
			'tab'   => Controls_Manager::TAB_STYLE
		] );
		$texts_style = [
			[
				'type'  => 'sep',
				'title' => 'عنوان',
				'uniq'  => 'title'
			],
			[
				'type'   => 'text-small',
				'target' => '.nader-pricing-plan-item h2 span',
				'uniq'   => 'title',
			],
			[
				'type'  => 'sep',
				'title' => 'قیمت',
				'uniq'  => 'price'
			],
			[
				'type'   => 'slider',
				'title'  => 'فاصله از بالا',
				'min'    => 0,
				'max'    => 100,
				'def'    => 20,
				'css'    => 'gap',
				'uniq'   => 'price',
				'target' => '.nader-pricing-plan-item h2'
			],
			[
				'type'   => 'text-small',
				'target' => '.nader-pricing-plan-item h2',
				'uniq'   => 'price',
			],
			[
				'type'  => 'sep',
				'title' => 'موارد',
				'uniq'  => 'features'
			],
			[
				'type'   => 'slider',
				'title'  => 'فاصله از بالا',
				'min'    => 0,
				'max'    => 100,
				'def'    => 30,
				'css'    => 'margin-top',
				'uniq'   => 'features',
				'target' => '.nader-pricing-plan-item .pricing-body'
			],
			[
				'type'   => 'slider',
				'title'  => 'فاصله از پایین',
				'min'    => 0,
				'max'    => 100,
				'def'    => 40,
				'css'    => 'margin-bottom',
				'uniq'   => 'features',
				'target' => '.nader-pricing-plan-item .pricing-body'
			],
			[
				'type'   => 'text-small',
				'target' => '.nader-pricing-plan-item .pricing-body li',
				'uniq'   => 'features',
			],
			[
				'type'  => 'sep',
				'title' => 'آیکون قبل مورد',
				'uniq'  => 'features-before-icon'
			],
			[
				'type'   => '4dir',
				'title'  => 'فاصله',
				'css'    => 'margin',
				'target' => '.nader-pricing-plan-item .pricing-body li span',
				'uniq'   => 'features-before-icon'
			],
			[
				'type'   => 'color-v',
				'title'  => 'رنگ',
				'target' => '.nader-pricing-plan-item .pricing-body li span svg',
				'uniq'   => 'features-before-icon',
				'css'    => 'fill'
			],
			[
				'type'   => 'bg',
				'target' => '.nader-pricing-plan-item .pricing-body li span',
				'uniq'   => 'features-before-icon'
			],
			[
				'type'   => 'shadow',
				'target' => '.nader-pricing-plan-item .pricing-body li span',
				'title'  => 'سایه',
				'uniq'   => 'features-before-icon'
			]
		];
		RP_Utils::VariantUtils( $this, 'texts-style', '', $texts_style );
		$this->end_controls_section();


		$this->nader_button_1_style();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$title = $settings['title'];
		$price = $settings['price'];
		$list  = $settings['price_features'];

		?>

        <div class="pricing-plan-item">
            <div class="pricing-header">
				<?php
				RP_Utils::ICON_PRINT( $this, $settings, 'price-table-' );
				?>
                <h2 class="dfx jcc aic">
                    <span class="dfx"><?php echo esc_html( $title ); ?></span>
					<?php
					if ( ! empty( $price ) ) {
						echo esc_html( $price );
					}
					?>
                </h2>
            </div>
			<?php
			if ( ! empty( $list ) ) {
				?>
                <div class="pricing-body">
                    <ul>
						<?php foreach ( $list as $item ) { ?>
                            <li>
                                <span class="icon-check">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16.971" height="12.021"
                                         viewBox="0 0 16.971 12.021">
                                      <path id="Path_2" data-name="Path 2"
                                            d="M10,15.172l9.192-9.193,1.415,1.414L10,18,3.636,11.636,5.05,10.222Z"
                                            transform="translate(-3.636 -5.979)"/>
                                    </svg>
                                </span>
								<?php echo esc_html( $item['text'] ); ?>
                            </li>
						<?php } ?>
                    </ul>
                </div>
			<?php } ?>
            <div class="pricing-footer dfx jcc">
				<?php $this->nader_button_1_render(); ?>
            </div>
        </div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new NaderPriceTable() );
