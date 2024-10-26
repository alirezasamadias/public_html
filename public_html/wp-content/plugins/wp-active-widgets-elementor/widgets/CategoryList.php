<?php
namespace Elementor;

defined('ABSPATH') || die();

use AE_E_FUNCTIONS;
use AE_E_UTILS;

class WP_ACTIVE_WE_CategoryList extends Widget_Base {

//    public function get_script_depends() {
//        wp_register_script('', AE_E_JS_DIR . '', ['jquery'], '1.0.0', true);
//        return ['jquery',''];
//    }

    public function get_style_depends()
    {
        wp_register_style('category-list', AE_E_CSS_DIR . 'category-list.css',[],null);
        return ['category-list'];
    }

    public function get_name() {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title() {
        return  'دسته بندی';
    }

    public function get_icon() {
        return 'wp-active-we-widget eicon-bullet-list';
    }

    public function get_categories() {
        return [ 'WP_ACTIVE_WE' ];
    }

    protected function register_controls() {

        $this->start_controls_section( 'settings', [ 'label' => 'تنظیمات' ] );

        AE_E_UTILS::SELECT_FIELD($this, 'taxonomy', 'تکسونومی', AE_E_FUNCTIONS::getRegisteredTaxonomies(), 'category');
        AE_E_UTILS::SWITCH_FIELD($this, 'show-empty-terms', 'نمایش دسته های خالی؟');
        AE_E_UTILS::SWITCH_FIELD($this, 'show-term-count', 'نمایش تعداد پست های دسته؟');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'gap', 'فاصله بین', 0, 50, null, '.wp-active-we-category-list', 'gap');

        $this->end_controls_section();


        $this->register_controls_styles();
    }

    protected function register_controls_styles() {

        AE_E_UTILS::SECTION_START($this, 'link-style', 'لینک','style');
        AE_E_UTILS::FONT_FIELD($this, 'link-typography', 'تایپوگرافی', '.wp-active-we-category-list a');
        AE_E_UTILS::COLOR_FIELD($this, 'link-color-normal', 'رنگ', '', '.wp-active-we-category-list a', 'color');
        AE_E_UTILS::COLOR_FIELD($this, 'link-color-hover', 'رنگ هاور', '', '.wp-active-we-category-list a:hover', 'color');
        AE_E_UTILS::SECTION_END($this);


        AE_E_UTILS::SECTION_START($this, 'number-style', 'عدد','style', 'show-term-count', 'yes');
        AE_E_UTILS::FONT_FIELD($this, 'number-typography', 'تایپوگرافی', '.wp-active-we-category-list .number');
        AE_E_UTILS::COLOR_FIELD($this, 'number-color-normal', 'رنگ', '', '.wp-active-we-category-list a .number', 'color');
        AE_E_UTILS::COLOR_FIELD($this, 'number-color-hover', 'رنگ هاور', '', '.wp-active-we-category-list a:hover .number', 'color');
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $args  = [
            'taxonomy'   => $settings['taxonomy'],
            'hide_empty' => (bool) $settings['show-empty-terms'],
        ];
        $terms = get_terms($args);

        $show_number = $settings['show-term-count'];

        ?>
        <ul class="wp-active-we-category-list d-grid">
            <?php foreach ($terms as $term) { ?>
                <li>
                    <a href="<?php echo get_category_link($term->term_id); ?>" title="<?php echo $term->name; ?>">
                        <?php
                        echo $term->name;
                        if ($show_number) {
                            echo '<span class="number">(' . $term->count . ')</span>';
                        }
                        ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new WP_ACTIVE_WE_CategoryList() );
