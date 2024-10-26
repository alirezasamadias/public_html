<?php

namespace Elementor;

defined( 'ABSPATH' ) || die();

use RP_Utils;

class NaderFloatingMenu extends Widget_Base {

	public function get_script_depends() {

		wp_register_script( 'nader-floating-menu-widget', NADER_ELEMENTOR_JS_DIR . 'nader-floating-menu.js', ['jquery',], '1.0', true );

		return ['jquery', 'nader-floating-menu-widget'];

	}

	public function get_name() {
		return 'NaderFloatingMenu';
	}

	public function get_title() {
		return PLUGIN_NAME_FA . ' : منو شناور';
	}

	public function get_icon() {
		return 'nader-widget eicon-anchor';
	}

	public function get_categories() {
		return [ PLUGIN_NAME ];
	}

	protected function register_controls() {

		$this->start_controls_section( 'settings', [ 'label' => 'تنظیمات' ] );

		$floating_menu = new \Elementor\Repeater();
		RP_Utils::TXT_FIELD( $floating_menu, 'title', 'عنوان', 'عنوان', true );
		RP_Utils::URL_FIELD( $floating_menu, 'link', 'لینک', true );
		RP_Utils::ICON( $floating_menu, 'menu-' );
		$this->add_control(
			'menu',
			[
				'label'       => 'منو شناور',
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $floating_menu->get_controls(),
				'title_field' => '{{{ title }}}'
			]
		);

		$this->end_controls_section();


		// box styles
		$this->start_controls_section( 'styles', [
			'label' => 'استایل',
			'tab'   => Controls_Manager::TAB_STYLE
		] );
		$box_styles = [
			[
				'type'  => 'slider',
				'css'   => 'width',
				'title' => 'عرض',
				'min'   => 40,
				'max'   => 150,
				'def'   => 50
			],
			[
				'type'  => 'slider',
				'css'   => 'bottom',
				'title' => 'فاصله پایین',
				'min'   => 0,
				'max'   => 150,
				'def'   => 30
			],
			[
				'type'  => 'slider',
				'css'   => 'right',
				'title' => 'فاصله راست',
				'min'   => 0,
				'max'   => 150,
				'def'   => 30
			],
			[
				'type' => 'bg-c',
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
		RP_Utils::VariantUtils( $this, 'box-styles', '.nader-floating-menu', $box_styles );
		$this->end_controls_section();


		// icon styles
		$this->start_controls_section( 'icon-styles', [
			'label' => 'آیکون',
			'tab'   => Controls_Manager::TAB_STYLE
		] );
		$this->add_responsive_control(
			'icon-size',
			[
				'label'      => 'اندازه',
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 16,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 40,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .icon i'   => 'font-size: {{SIZE}}px;',
					'{{WRAPPER}} .icon svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
					'{{WRAPPER}} .icon img' => 'width: {{SIZE}}px;',
				],
			]
		);
		$this->add_control(
			'icon-color',
			[
				'label'       => 'رنگ',
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .nader-floating-menu li .icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .nader-floating-menu li .icon svg' => 'fill: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'icon-active-color',
			[
				'label'       => 'رنگ فعال',
				'label_block' => false,
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .nader-floating-menu li.active .icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .nader-floating-menu li.active .icon svg' => 'fill: {{VALUE}};',
				]
			]
		);
		$this->end_controls_section();


		// link styles
		$this->start_controls_section( 'link-styles', [
			'label' => 'لینک',
			'tab'   => Controls_Manager::TAB_STYLE
		] );

		// typography

		// color -> text
		// bg

		$link_style = [
			[
				'type'   => '4dir',
				'title'  => 'فاصله داخلی',
				'css'    => 'padding',
				'target' => '.nader-floating-menu a'
			],
			[
				'type'  => 'font',
				'title' => 'تایپوگرافی'
			],
			[
				'type'  => 'color',
				'title' => 'رنگ',

			],
			[
				'type'   => 'slider',
				'title'  => 'فاصله بین آیکون و متن',
				'min'    => 0,
				'max'    => 50,
				'def'    => 15,
				'css'    => 'gap',
				'target' => '.nader-floating-menu a'
			],
			[
				'type'   => 'bg-c',
				'title'  => 'بکگراند',
				'target' => '.nader-floating-menu li'
			],
			[
				'type'   => 'bg-c',
				'title'  => 'بکگراند فعال',
				'uniq'   => 'active',
				'target' => '.nader-floating-menu li.active'
			]
		];
		RP_Utils::VariantUtils( $this, 'link', '.nader-floating-menu span', $link_style );
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$menu = $settings['menu'];
		if ( empty( $menu ) ) {
			return;
		}


		?>

        <div class="nader-floating-menu">
            <ul>
				<?php
				$i = 0;
				foreach ( $menu as $item ) {
					$this->add_link_attributes( 'link-' . $i, $item['link'] );
					?>
                    <li>
                        <a <?php $this->print_render_attribute_string( 'link-' . $i ); ?>>
							<?php
							RP_Utils::ICON_PRINT( $this, $item, 'menu-' );
							if ( ! empty( $item['title'] ) ) {
								echo '<span>';
								echo esc_html( $item['title'] );
								echo '</span>';
							}
							?>
                        </a>
                    </li>
					<?php
					$i ++;
				}
				?>
            </ul>
        </div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new NaderFloatingMenu() );
