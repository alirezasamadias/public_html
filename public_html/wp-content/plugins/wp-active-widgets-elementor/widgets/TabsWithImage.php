<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_TabsWithImage extends Widget_Base{

    public function get_script_depends()
    {
        wp_register_script('AE_E_TabsWithImage', AE_E_JS_DIR . 'tabs-with-image.js', ['jquery'], '1.0.0', true);
        return ['jquery', 'AE_E_TabsWithImage'];
    }

    public function get_style_depends()
    {
        wp_register_style('AE_E_TabsWithImage', AE_E_CSS_DIR . 'tabs-with-image.css');
        return ['AE_E_TabsWithImage'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'تب با تصویر کناری';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-tabs';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        $tabs = new \Elementor\Repeater();
        AE_E_UTILS::ICON($tabs, 'tab_icon');
        AE_E_UTILS::TXT_FIELD($tabs, 'btn-title', 'عنوان دکمه', 'عنوان', true);
        AE_E_UTILS::TXT_FIELD($tabs, 'title', 'عنوان', 'عنوان ویژگی', true);
        AE_E_UTILS::TXT_FIELD($tabs, 'subtitle', 'زیرعنوان', 'این یک زیرعنوان است', true);
        AE_E_UTILS::TEXTAREA($tabs, 'text', 'متن', '', true);
        AE_E_UTILS::IMAGE($tabs, 'img', 'تصویر');
        AE_E_UTILS::IMAGE_SIZE($tabs, 'img');
        $this->add_control('tabs-items', [
                'label'       => 'تب ها',
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $tabs->get_controls(),
                'title_field' => '{{{ title }}}',
            ]);

        AE_E_UTILS::H_ALIGNMENT($this,'buttons-alignment','.tab-controls');
        $this->add_responsive_control('tab-content-image-width', [
                'label'       => 'اندازه باکس تصویر',
                'type'        => Controls_Manager::SLIDER,
                'label_block' => true,
                'size_units'  => ['%', 'px'],
                'range'       => [
                    '%'  => [
                        'min' => 20,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 200,
                        'max' => 1000
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .wp-active-we-tabs-with-image .tab-contents .tab-content .img-box'     => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wp-active-we-tabs-with-image .tab-contents .tab-content .content-box' => 'width: calc(100% - {{SIZE}}{{UNIT}});',
                ],
            ]);

        $this->end_controls_section();

        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {

        AE_E_UTILS::SECTION_START($this, 'tab-btn-styles', 'دکمه ها', 'style');

        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'btn-width', 'عرض', 0, 300, null, '.tab-controls button', 'width');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'btn-height', 'ارتفاع', 0, 300, null, '.tab-controls button', 'height');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'tab-controls-gap', 'فاصله بین دکمه ها', 0, 100, null, '.tab-controls', 'gap');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'tab-btn-icon-gap', 'فاصله بین آیکون و متن', 0, 50, null, '.tab-controls button', 'gap');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'tab-controls-mb', 'فاصله از پایین', -100, 100, null, '.tab-controls', 'margin-bottom');
        AE_E_UTILS::FONT_FIELD($this, 'tab-btn-typography', 'تایپوگرافی', '.tab-controls button');

        AE_E_UTILS::TAB_START($this, 'tab-btn-normal');
        AE_E_UTILS::COLOR_FIELD($this, 'tab-btn-color-normal', 'رنگ', '', '.tab-controls button', 'color');
        AE_E_UTILS::DynamicStyleControls($this, 'tab-btn-normal', '.tab-controls button', [
            'padding',
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::Separator($this, 'tab-btn-icon-normal', 'آیکون');
        AE_E_UTILS::IconUtilsLight($this, 'tab-btn-icon-normal', '.tab-controls button .tab-btn-icon');
        AE_E_UTILS::TAB_MIDDLE_($this, 'tab-btn-active', 'حالت فعال');
        AE_E_UTILS::COLOR_FIELD($this, 'tab-btn-color-active', 'رنگ', '', '.tab-controls button.active', 'color');
        AE_E_UTILS::DynamicStyleControls($this, 'tab-btn-active', '.tab-controls button.active', [
            'padding',
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::Separator($this, 'tab-btn-icon-active', 'آیکون');
        AE_E_UTILS::IconUtilsLight($this, 'tab-btn-icon-active', '.tab-controls button.active .tab-btn-icon');
        AE_E_UTILS::TAB_END($this);

        AE_E_UTILS::SECTION_END($this);


        // box styles
        AE_E_UTILS::SECTION_START($this, 'tab-content-box-styles', 'باکس', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'tab-content-box-height', 'ارتفاع', 100, 500, null, '.tab-content', 'height');
//        AE_E_UTILS::SWITCH_FIELD();
//        AE_E_UTILS::NUMBER_FIELD_STYLE($this, 'tab-content-box-z-index','z-index','.tab-contents','z-index');
        AE_E_UTILS::DynamicStyleControls($this, 'tab-content-box-styles', '.tab-content', [
            'padding',
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::SECTION_END($this);


        // image style
        AE_E_UTILS::SECTION_START($this, 'tab-content-image-styles', 'تصویر', 'style');
        AE_E_UTILS::DynamicStyleControls($this, 'tab-content-image-styles', '.tab-content .img-box', [
            'padding',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::SECTION_END($this);


        // content style
        AE_E_UTILS::SECTION_START($this, 'tab-content-texts-styles', 'محتوا', 'style');
        $target = '.wp-active-we-tabs-with-image .tab-contents .tab-content .content-box ';
        AE_E_UTILS::Separator($this, 'tab-content-texts-box', 'باکس محتوا');
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'tab-content-texts-box-padding', 'فاصله داخلی', '.wp-active-we-tabs-with-image .tab-contents .tab-content .content-box', 'padding');

        AE_E_UTILS::Separator($this, 'tab-content-texts-title', 'عنوان');
        AE_E_UTILS::TextUtils($this, 'tab-content-texts-title', $target . '.content-title');

        AE_E_UTILS::Separator($this, 'tab-content-texts-subtitle', 'زیرعنوان');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'tab-content-texts-subtitle-mt', 'فاصله', 0, 50, null, $target . '.content-subtitle', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'tab-content-texts-subtitle', $target . '.content-subtitle');

        AE_E_UTILS::Separator($this, 'tab-content-texts-p', 'توضیح');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'tab-content-texts-p-mt', 'فاصله', 0, 50, null, $target . '.content-p', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'tab-content-texts-p', $target . '.content-p');
        AE_E_UTILS::TEXT_ALIGNMENT($this, 'tab-content-texts-p-alignment', $target . '.content-p');
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();

        $tabs = $settings['tabs-items'];

        ?>
        <div class="wp-active-we-tabs-with-image">

            <div class="tab-controls dfx jcc wrap">
                <?php
                $counter = 0;
                foreach ($tabs as $tab) {
                    ?>
                    <button class="dfx dir-v aic jcc ae-gap-15" title="<?php echo $tab['btn-title']; ?>"
                            data-target=".tb-<?php echo $id; ?>-<?php echo $counter; ?>">
                        <?php AE_E_UTILS::ICON_PRINT($this, $tab, 'tab_icon', 'tab-btn-icon'); ?>
                        <?php echo $tab['btn-title']; ?>
                    </button>
                    <?php
                    $counter++;
                }
                ?>
            </div>

            <div class="tab-contents">
                <?php
                $counter = 0;
                foreach ($tabs as $tab) {
                    ?>

                    <div class="tab-content ais tb-<?php echo $id; ?>-<?php echo $counter; ?>">

                        <div class="img-box">
                            <?php Group_Control_Image_Size::print_attachment_image_html($tab, 'img', 'img'); ?>
                        </div>

                        <div class="content-box">
                            <?php AE_E_UTILS::TxtHtmlGenerator($this, $tab, 'title', 'h3', 'content-title', $counter); ?>
                            <?php AE_E_UTILS::TxtHtmlGenerator($this, $tab, 'subtitle', 'span', 'content-subtitle', $counter); ?>
                            <?php AE_E_UTILS::TxtHtmlGenerator($this, $tab, 'text', 'p', 'content-p', $counter); ?>
                        </div>

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

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_TabsWithImage());
