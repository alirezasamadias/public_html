<?php
namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_InfiniteCssImageSlider extends Widget_Base{

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-infinite-css-slider', AE_E_CSS_DIR . 'infinite-css-slider.css');
        return ['wp-active-we-infinite-css-slider'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'اسلایدر تصویر بینهایت';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-slider-push';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);
        $slides = new \Elementor\Repeater();
        AE_E_UTILS::IMAGE($slides, 'image', 'تصویر');
        AE_E_UTILS::TXT_FIELD($slides, 'title', 'عنوان', '', true);
        $this->add_control('slides', [
            'label'       => 'اسلایدها',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $slides->get_controls(),
            'title_field' => '{{{ title }}}',
        ]);
        AE_E_UTILS::IMAGE_SIZE($this, 'infinite-css-slider', 'thumbnail');

        AE_E_UTILS::NUMBER_FIELD($this, 'height', 'ارتفاع', 50, 300, 1, 150);
        AE_E_UTILS::NUMBER_FIELD($this, 'width', 'عرض', 50, 300, 1, 150);
        AE_E_UTILS::NUMBER_FIELD($this, 'animation-duration', 'مدت انیمیشن', 1, 30, 1, 10);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $slides = $settings['slides'];
        if (empty($slides)) {
            return;
        }
        $height = $settings['height'];
        $width = $settings['width'];
        $image_size = $settings['infinite-css-slider_size'];
        $animation_duration = $settings['animation-duration'];
        ?>
        <div class="wp-active-we-infinite-css-slider w100" style="
                --ae-infinite-css-slider-width:<?php echo esc_html($width); ?>px;
                --ae-infinite-css-slider-height:<?php echo esc_html($height); ?>px;
                --ae-infinite-css-slider-quantity: <?php echo esc_html(count($slides)); ?>;
                ">
            <div class="infinite-css-slider-list dfx w100">
                <?php
                $counter = 1;
                foreach ($slides as $slide) {
                    $image_id = $slide['image']['id'];
                    if (empty($image_id)) {
                        continue;
                    }
                    $image_url = wp_get_attachment_image_url($image_id, $image_size);
                    $title = $slide['title'];
                    ?>
                    <div class="slider-item" style="
                            --ae-infinite-css-slider-position:<?php echo $counter; ?>;
                            animation-duration: <?php echo esc_html($animation_duration); ?>s;
                            animation-delay: calc(( <?php echo esc_html($animation_duration); ?>s / var(--ae-infinite-css-slider-quantity)) * (var(--ae-infinite-css-slider-position) - 1) - <?php echo esc_html($animation_duration); ?>s);
                            ">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_html($title); ?>" class="w100">
                    </div>
                    <?php
                    $counter++;
                }
                ?>
            </div>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_InfiniteCssImageSlider());
