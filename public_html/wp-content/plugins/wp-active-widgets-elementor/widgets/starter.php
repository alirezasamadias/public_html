<?php
namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_S extends Widget_Base {

//    public function get_script_depends() {
//        wp_register_script('wp-active-we-', AE_E_JS_DIR . '', ['jquery'], '1.0.0', true);
//        return ['jquery','wp-active-we-'];
//    }

//    public function get_style_depends()
//    {
//        wp_register_style('wp-active-we-', AE_E_CSS_DIR . '');
//        return [''];
//    }

    public function get_name() {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title() {
        return  '';
    }

    public function get_icon() {
        return 'wp-active-we-widget eicon-t-letter';
    }

    public function get_categories() {
        return [ 'WP_ACTIVE_WE' ];
    }

    protected function register_controls() {

        $this->start_controls_section( 'settings', [ 'label' => 'تنظیمات' ] );

        $this->end_controls_section();



        $this->register_controls_styles();
    }

    protected function register_controls_styles() {

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="wp-active-we-">

        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new WP_ACTIVE_WE_S() );
