<?php

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

trait IMAGE_EFFECT {

	private function create_parallax_controls( $id, $condition = '', $condition_value = '' ) {
		$control_args = [
			'label'        => 'پارالاکس',
			'type'         => \Elementor\Controls_Manager::POPOVER_TOGGLE,
			'label_off'    => 'پیشفرض',
			'return_value' => 'yes',
			'default'      => '',
		];
		if ( ! empty( $condition ) ) {
			$control_args[ 'condition' ] = [
				$condition    =>  $condition_value
			];
		}

		$this->add_control(
			$id,
			$control_args
		);

		$this->start_popover();
		$orientation = [
			'up'         => 'بالا',
			'right'      => 'راست',
			'down'       => 'پایین',
			'left'       => 'چپ',
			'up right'   => 'بالا راست',
			'up left'    => 'بالا چپ',
			'down right' => 'پایین راست',
			'down left'  => 'پایین چپ',
		];
		RP_Utils::SELECT_FIELD( $this, $id . '-orientation', 'جهت', $orientation, 'up', $id, 'yes' );
		RP_Utils::NUMBER_FIELD( $this, $id . '-delay', 'مکث', 0, 2, 0.01, 0, true, $id, 'yes' );
		RP_Utils::NUMBER_FIELD( $this, $id . '-scale', 'بزرگنمایی', 1.1, 3, 0.1, 1.5, true, $id, 'yes' );
		$this->end_popover();

	}

	private function create_rellax_controls( $id, $condition = '', $condition_value = '' ) {
		$control_args = [
			'label'        => 'پارالاکس خارجی',
			'type'         => \Elementor\Controls_Manager::POPOVER_TOGGLE,
			'label_off'    => 'پیشفرض',
			'return_value' => 'yes',
			'default'      => '',
		];
		if ( ! empty( $condition ) ) {
			$control_args[ 'condition' ] = [
				$condition    =>  $condition_value
			];
		}

		$this->add_control(
			$id,
			$control_args
		);
		$this->start_popover();
		RP_Utils::NUMBER_FIELD( $this, $id . '-speed', 'سرعت', - 10, 10, 0.1, 2, true, $id, 'yes' );
		$this->end_popover();
	}

	private function create_tilt_controls( $id, $condition = '', $condition_value = '' ) {

		$control_args = [
			'label'        => 'کج کردن',
			'type'         => \Elementor\Controls_Manager::POPOVER_TOGGLE,
			'label_off'    => 'پیشفرض',
			'return_value' => 'yes',
			'default'      => '',
		];
		if ( ! empty( $condition ) ) {
			$control_args[ 'condition' ] = [
				$condition    =>  $condition_value
			];
		}

		$this->add_control(
			$id,
			$control_args
		);

		$this->start_popover();
		RP_Utils::NUMBER_FIELD( $this, $id . '-tilt', 'مقدار کج', 10, 100, 1, 20, true, $id, 'yes' );
		RP_Utils::NUMBER_FIELD( $this, $id . '-perspective', 'perspective', 1000, 10000, 10, 2000, true, $id, 'yes' );
		RP_Utils::NUMBER_FIELD( $this, $id . '-speed', 'سرعت', 100, 2500, 1, 300, true, $id, 'yes' );
		RP_Utils::NUMBER_FIELD( $this, $id . '-scale', 'بزرگنمایی', 1, 1.3, 0.01, 1, true, $id, 'yes' );
		$this->end_popover();
	}

	private function get_parallax_settings( $id ) {

		$settings = $this->get_settings_for_display();

		$output = [];

		if ( ! empty( $settings[ $id ] ) ) {
			if ( ! empty( $settings[ $id . '-delay' ] ) ) {
				$output['delay'] = $settings[ $id . '-delay' ];
			}

			if ( ! empty( $settings[ $id . '-scale' ] ) ) {
				$output['scale'] = $settings[ $id . '-scale' ];
			}

			if ( ! empty( $settings[ $id . '-orientation' ] ) ) {
				$output['orientation'] = $settings[ $id . '-orientation' ];
			}
		}

		return $output;

	}

	private function get_rellax_settings( $id ) {

		$settings = $this->get_settings_for_display();

		$output = [];

		if ( ! empty( $settings[ $id ] ) && ! empty( $settings[ $id . '-speed' ] ) ) {
			$output['speed'] = $settings[ $id . '-speed' ];
		}

		return $output;

	}

	private function get_tilt_settings( $id ) {
		$settings = $this->get_settings_for_display();

		$output = [];
		if ( ! empty( $settings[ $id ] ) ) {

			$output['glare']    = true;
			$output['maxGlare'] = 0.5;

			if ( ! empty( $settings[ $id . '-scale' ] ) ) {
				$output['scale'] = $settings[ $id . '-scale' ];
			}
			if ( ! empty( $settings[ $id . '-speed' ] ) ) {
				$output['speed'] = $settings[ $id . '-speed' ];
			}
			if ( ! empty( $settings[ $id . '-tilt' ] ) ) {
				$output['tilt'] = $settings[ $id . '-tilt' ];
			}
			if ( ! empty( $settings[ $id . '-perspective' ] ) ) {
				$output['perspective'] = $settings[ $id . '-perspective' ];
			}
		}

		return $output;
	}

}

