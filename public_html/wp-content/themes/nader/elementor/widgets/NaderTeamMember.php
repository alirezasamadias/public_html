<?php

namespace Elementor;

use RP_Utils;

defined( 'ABSPATH' ) || die();

class NaderTeamMember extends Widget_Base {

	public function get_name() {
		return 'NaderTeamMember';
	}

	public function get_title() {
		return PLUGIN_NAME_FA . ' : عضو گروه';
	}

	public function get_icon() {
		return 'nader-widget eicon-person';
	}

	public function get_categories() {
		return [ PLUGIN_NAME ];
	}

	protected function register_controls() {

		$this->start_controls_section( 'settings', [ 'label' => 'تنظیمات' ] );

		RP_Utils::TXT_FIELD( $this, 'title', 'نام', 'نام عضو گروه', true );
		RP_Utils::TXT_FIELD( $this, 'position', 'جایگاه', 'جایگاه عضو گروه', true );

		RP_Utils::IMAGE( $this, 'image', 'تصویر' );

		$social = new \Elementor\Repeater();
		RP_Utils::TXT_FIELD( $social, 'title', 'عنوان' );
		RP_Utils::URL_FIELD( $social, 'link', 'لینک' );
        RP_Utils::ICON($social,'selected');
		$this->add_control(
			'socials',
			[
				'label'       => 'شبکه های اجتماعی',
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $social->get_controls(),
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();


		// box styles
		$this->start_controls_section( 'styles', [
			'label' => 'استایل',
			'tab'   => Controls_Manager::TAB_STYLE
		] );
		$styles = [
			[
				'type' => 'box-styles'
			]
		];
		RP_Utils::VariantUtils( $this, 'team-member-card-styles', '.NaderTeamMember', $styles );
		$this->end_controls_section();


		// image
		$this->start_controls_section( 'image-styles', [
			'label' => 'تصویر',
			'tab'   => Controls_Manager::TAB_STYLE
		] );
		RP_Utils::SLIDER_FIELD_PIX_STYLE( $this, 'image-size-css-height', 'ارتفاع', 100, 500, 400, '.NaderTeamMember .thumb', 'height' );
		RP_Utils::DIMENSIONS_FIELD( $this, 'image-border-radius', 'خمیدگی', '.NaderTeamMember .thumb img', 'border-radius' );
		$this->end_controls_section();


		// content
		$this->start_controls_section( 'content-styles', [
			'label' => 'محتوا',
			'tab'   => Controls_Manager::TAB_STYLE
		] );
		$content_styles = [
			[
				'type'  => '4dir',
				'title' => 'فاصله',
				'uniq'  => 'footer-box',
				'css'   => 'padding'
			],
			[
				'type'  => 'sep',
				'title' => 'نام',
				'uniq'  => 'name',
			],
			[
				'type'   => 'text-small',
				'target' => '.NaderTeamMember .card-footer h4',
				'uniq'   => 'name'
			],
			[
				'type'  => 'sep',
				'title' => 'جایگاه',
				'uniq'  => 'position',
			],
			[
				'type'   => 'text-small',
				'target' => '.NaderTeamMember .card-footer h6',
				'uniq'   => 'position'
			],
		];
		RP_Utils::VariantUtils( $this, 'team-member-card-footer', '.NaderTeamMember .card-footer', $content_styles );
		$this->end_controls_section();


		// socials
		$this->start_controls_section( 'socials-styles', [
			'label' => 'شبکه های اجتماعی',
			'tab'   => Controls_Manager::TAB_STYLE
		] );
		$socials_styles = [
			[
				'type'  => 'sep',
				'title' => 'دکمه',
				'uniq'  => 'change-btn',
			],
			[
				'type'   => 'slider',
				'title'  => 'فاصله',
				'min'    => 0,
				'max'    => 50,
				'def'    => 15,
				'css'    => 'gap',
				'uniq'   => 'change-btn',
				'target' => '.NaderTeamMember .card-footer'
			],
			[
				'type' => 'bg-c',
				'uniq' => 'change-btn',
			],
			[
				'type'   => 'color-v',
				'title'  => 'رنگ آیکون',
				'css'    => 'fill',
				'uniq'   => 'change-btn',
				'target' => '.NaderTeamMember .card-footer .media-holder span .smb path'
			],
			[
				'type'  => '4dir',
				'title' => 'خمیدگی',
				'uniq'  => 'change-btn',
				'css'   => 'border-radius'
			],
			[
				'type'  => 'sep',
				'title' => 'آیکون ها',
				'uniq'  => 'socials-box',
			],
			[
				'type'   => 'slider',
				'title'  => 'فاصله',
				'min'    => 0,
				'max'    => 40,
				'def'    => 20,
				'css'    => 'padding-bottom',
				'uniq'   => 'socials-box',
				'target' => '.NaderTeamMember .card-footer .media-holder .drop-menu'
			],
			[
				'type'   => 'bg-c',
				'uniq'   => 'socials-box',
				'target' => '.NaderTeamMember .card-footer .media-holder .drop-menu ul'
			],
			[
				'type'   => '4dir',
				'title'  => 'خمیدگی',
				'uniq'   => 'socials-box',
				'css'    => 'border-radius',
				'target' => '.NaderTeamMember .card-footer .media-holder .drop-menu ul'
			],
		];
		RP_Utils::VariantUtils( $this, 'team-member-socials', '.NaderTeamMember .card-footer .media-holder span', $socials_styles );

		$this->add_responsive_control(
			'team-member-socials-icon-size',
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
					'{{WRAPPER}} .NaderTeamMember .card-footer .media-holder .drop-menu a i'   => 'font-size: {{SIZE}}px;',
					'{{WRAPPER}} .NaderTeamMember .card-footer .media-holder .drop-menu a svg' => 'width: {{SIZE}}px;',
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
					'{{WRAPPER}} .NaderTeamMember .card-footer .media-holder .drop-menu a i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .NaderTeamMember .card-footer .media-holder .drop-menu a svg' => 'fill: {{VALUE}};',
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
					'{{WRAPPER}} .NaderTeamMember .card-footer .media-holder .drop-menu a:hover i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .NaderTeamMember .card-footer .media-holder .drop-menu a:hover svg' => 'fill: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$image    = $settings['image'];
		$name     = $settings['title'];
		$position = $settings['position'];
		$socials  = $settings['socials'];

		?>

        <div class="NaderTeamMember card">
            <div class="thumb dfx ab-icon jcc">
                <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_html( $name ); ?>">
            </div>
            <div class="card-footer d-flex">
                <div class="media-holder">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="smb expand" width="35.861" height="17.806"
                             viewBox="0 0 35.861 17.806">
                          <path d="M19.844,8.906Q31.232,19.2,35.022,22.532a1.515,1.515,0,0,0,2.3.138q1.118-.971-.086-2.123L20.844,5.848a1.5,1.5,0,0,0-1-.348,1.651,1.651,0,0,0-1.041.348L2.384,20.952a1.331,1.331,0,0,0,.066,1.939,1.646,1.646,0,0,0,2.1.085Z"
                                transform="translate(-2.002 -5.5)" fill="#555" fill-rule="evenodd"/>
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" class="smb elips" width="32.055" height="7.933"
                             viewBox="0 0 32.055 7.933">
                          <g transform="translate(0 -12.061)">
                            <path id="Path_1" data-name="Path 1"
                                  d="M3.968,12.061a3.966,3.966,0,1,0,3.966,3.966A3.965,3.965,0,0,0,3.968,12.061Zm12.265,0a3.966,3.966,0,1,0,3.97,3.965A3.967,3.967,0,0,0,16.233,12.061Zm11.857,0a3.966,3.966,0,1,0,3.965,3.967A3.967,3.967,0,0,0,28.09,12.061Z"/>
                          </g>
                        </svg>

                    </span>
					<?php if ( ! empty( $socials ) ) { ?>
                        <div class="drop-menu">
                            <ul>
								<?php
								$i = 0;
								foreach ( $socials as $social ) {
									$this->add_link_attributes( 'link' . $i, $social['link'] );
									?>
                                    <li>
                                        <a <?php $this->print_render_attribute_string( 'link' . $i ); ?>>
											<?php RP_Utils::ICON_PRINT($this,$social,'selected'); ?>
                                        </a>
                                    </li>
									<?php
									$i ++;
								}
								?>
                            </ul>
                        </div>
					<?php } ?>
                </div>
                <div class="info">
                    <h4><?php echo esc_html( $name ); ?></h4>
                    <h6><?php echo esc_html( $position ); ?></h6>
                </div>
            </div>
        </div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new NaderTeamMember() );
