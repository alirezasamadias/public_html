<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;

class WP_ACTIVE_WE_SharePopup extends Widget_Base{

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-share-popup', AE_E_CSS_DIR . 'share-popup.min.css');
        return ['wp-active-we-share-popup'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'انتشار در شبکه های اجتماعی';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-share';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        AE_E_UTILS::SECTION_START($this, 'settings', 'تنظیمات');
        AE_E_UTILS::ICON($this, 'share', 'fas fa-share-alt');
        AE_E_UTILS::TXT_FIELD($this, 'share-box-title', 'عنوان باکس', 'انتشار در شبکه های اجتماعی', true);
        AE_E_UTILS::SWITCH_FIELD($this, 'enable-facebook', 'facebook', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'enable-twitter', 'twitter', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'enable-linkedin', 'linkedin', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'enable-whatsapp', 'whatsapp', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'enable-telegram', 'telegram', 'yes');
        AE_E_UTILS::SWITCH_FIELD($this, 'enable-copy-link', 'کپی لینک', 'yes');
        AE_E_UTILS::TXT_FIELD($this, 'copied-text', 'متن کپی شد', 'کپی شد!', true, 'enable-copy-link', 'yes');
        AE_E_UTILS::SECTION_END($this);

        $this->register_controls_styles();
    }

    protected function register_controls_styles()
    {
        AE_E_UTILS::SECTION_START($this, 'btn-opener-style', 'دکمه باز کننده', 'style');
        AE_E_UTILS::IconUtils($this, 'share', '.wp-active-we-share-btn');
        AE_E_UTILS::SECTION_END($this);


        AE_E_UTILS::SECTION_START($this, 'box', 'باکس', 'style');
        AE_E_UTILS::BoxUtils($this, 'box', '.wp-active-we-share-btn-popup');
        AE_E_UTILS::SECTION_END($this);


        AE_E_UTILS::SECTION_START($this, 'box-header', 'هدر باکس', 'style');
        AE_E_UTILS::TextUtils($this, 'box-title', '.box-title');
        AE_E_UTILS::IconUtilsLight($this, 'icon-closer', '.btn_closer', ' آیکون بستن', true);
        AE_E_UTILS::SECTION_END($this);


        AE_E_UTILS::SECTION_START($this, 'box-icons', 'آیکون ها', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'box-body-mt', 'فاصله کل از بالا', 0, 100, null, '.box-body', 'margin-top');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'socials-icons-gap', 'فاصله بین', 0, 50, null, '.box-body ul', 'gap');
        AE_E_UTILS::IconUtils($this, 'socials-icons', '.box-body ul li a');
        AE_E_UTILS::SECTION_END($this);


        AE_E_UTILS::SECTION_START($this, 'box-footer', 'باکس کپی', 'style');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'box-footer-mt', 'فاصله از بالا', 0, 50, null, '.box-footer', 'margin-top');
        AE_E_UTILS::IconUtilsLight($this, 'copy-icon', 'copy-icon', ' آیکون');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'copy-link-height', 'ارتفاع', 0, 50, null, '.copy-link-box', 'height');
        AE_E_UTILS::FONT_FIELD($this, 'copy-typography', 'تایپوگرافی', '.copy-link-box .text');
        AE_E_UTILS::COLOR_FIELD($this,'copy-typography-color-normal', 'رنگ عادی','','.copy-link-box .text','color');
        AE_E_UTILS::COLOR_FIELD($this,'copy-typography-color-hover', 'رنگ هاور','','.copy-link-box:hover .text','color');
        AE_E_UTILS::TAB_START($this, 'copy-link-box');
        AE_E_UTILS::DynamicStyleControls($this, 'copy-link-box-normal', '.copy-link-box', [
            'padding',
            'background',
            'border',
            'radius',
            'shadow',
        ]);
        AE_E_UTILS::TAB_MIDDLE($this, 'copy-link-box');
        AE_E_UTILS::DynamicStyleControls($this, 'copy-link-box-hover', '.copy-link-box:hover', [
            'padding',
            'background',
            'border',
            'radius',
            'shadow',
        ]);
        AE_E_UTILS::TAB_END($this);

        AE_E_UTILS::SECTION_END($this);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $copy = $settings['enable-copy-link'];
        $permalink = esc_url(get_the_permalink());

        $closer_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                <path opacity=".4" d="M16.19 2H7.81C4.17 2 2 4.17 2 7.81v8.37C2 19.83 4.17 22 7.81 22h8.37c3.64 0 5.81-2.17 5.81-5.81V7.81C22 4.17 19.83 2 16.19 2Z"></path>
                <path d="m13.06 12 2.3-2.3c.29-.29.29-.77 0-1.06a.754.754 0 0 0-1.06 0l-2.3 2.3-2.3-2.3a.754.754 0 0 0-1.06 0c-.29.29-.29.77 0 1.06l2.3 2.3-2.3 2.3c-.29.29-.29.77 0 1.06.15.15.34.22.53.22s.38-.07.53-.22l2.3-2.3 2.3 2.3c.15.15.34.22.53.22s.38-.07.53-.22c.29-.29.29-.77 0-1.06l-2.3-2.3Z"></path>
            </svg>';

        AE_E_UTILS::ICON_PRINT($this, $settings, 'share', 'wp-active-we-share-btn cursor-pointer');
        ?>
        <div class="wp-active-we-share-btn-popup popup-modal">
            <div class="box-header dfx wrap aic jcsb">
                <?php AE_E_UTILS::TxtHtmlGenerator($this, $settings, 'share-box-title', 'span', 'box-title'); ?>
                <span class="btn_closer cursor-pointer">
                    <?php echo $closer_icon; ?>
                </span>
            </div>
            <div class="box-body">
                <?php $this->social_buttons($permalink); ?>
            </div>
            <?php if (!empty($copy) && $copy == 'yes') { ?>
                <div class="box-footer"><?php $this->copy_link_field($permalink); ?></div>
            <?php } ?>
        </div>
        <?php
    }

    private function social_buttons($permalink)
    {
        $settings = $this->get_settings_for_display();
        $facebook = $settings['enable-facebook'];
        $twitter = $settings['enable-twitter'];
        $linkedin = $settings['enable-linkedin'];
        $whatsapp = $settings['enable-whatsapp'];
        $telegram = $settings['enable-telegram'];

        ?>
        <ul class="dfx wrap aic jcc">
            <?php if (!empty($facebook)) { ?>
                <li>
                    <a href="https://www.facebook.com/sharer.php?u=<?php echo $permalink; ?>" target="_blank"
                       title="<?php esc_html_e('Share on Facebook', 'nader'); ?>"
                       class="dfx aic jcc">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z"/>
                            <path d="M14 19h5V5H5v14h7v-5h-2v-2h2v-1.654c0-1.337.14-1.822.4-2.311A2.726 2.726 0 0 1 13.536 6.9c.382-.205.857-.328 1.687-.381.329-.021.755.005 1.278.08v1.9H16c-.917 0-1.296.043-1.522.164a.727.727 0 0 0-.314.314c-.12.226-.164.45-.164 1.368V12h2.5l-.5 2h-2v5zM4 3h16a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/>
                        </svg>
                    </a>
                </li>
            <?php }
            if (!empty($twitter)) { ?>
                <li>
                    <a href="https://twitter.com/intent/tweet?text=<?php echo $permalink; ?>" target="_blank"
                       title="<?php esc_html_e('Share on Twitter', 'nader'); ?>"
                       class="dfx aic jcc">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z"/>
                            <path d="M15.3 5.55a2.9 2.9 0 0 0-2.9 2.847l-.028 1.575a.6.6 0 0 1-.68.583l-1.561-.212c-2.054-.28-4.022-1.226-5.91-2.799-.598 3.31.57 5.603 3.383 7.372l1.747 1.098a.6.6 0 0 1 .034.993L7.793 18.17c.947.059 1.846.017 2.592-.131 4.718-.942 7.855-4.492 7.855-10.348 0-.478-1.012-2.141-2.94-2.141zm-4.9 2.81a4.9 4.9 0 0 1 8.385-3.355c.711-.005 1.316.175 2.669-.645-.335 1.64-.5 2.352-1.214 3.331 0 7.642-4.697 11.358-9.463 12.309-3.268.652-8.02-.419-9.382-1.841.694-.054 3.514-.357 5.144-1.55C5.16 15.7-.329 12.47 3.278 3.786c1.693 1.977 3.41 3.323 5.15 4.037 1.158.475 1.442.465 1.973.538z"/>
                        </svg>
                    </a>
                </li>
            <?php }
            if (!empty($linkedin)) { ?>
                <li>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $permalink; ?>"
                       target="_blank"
                       title="<?php esc_html_e('Share on LinkedIn', 'nader'); ?>"
                       class="dfx aic jcc">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z"/>
                            <path d="M4 3h16a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm1 2v14h14V5H5zm2.5 4a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm-1 1h2v7.5h-2V10zm5.5.43c.584-.565 1.266-.93 2-.93 2.071 0 3.5 1.679 3.5 3.75v4.25h-2v-4.25a1.75 1.75 0 0 0-3.5 0v4.25h-2V10h2v.43z"/>
                        </svg>
                    </a>
                </li>
            <?php }
            if (!empty($whatsapp)) { ?>
                <li>
                    <a href="https://api.whatsapp.com/send?text=*<?php the_title(); ?>*<?php echo $permalink; ?>"
                       target="_blank"
                       title="<?php esc_html_e('Share on Whatsapp', 'nader'); ?>"
                       class="dfx aic jcc">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z"/>
                            <path d="M7.253 18.494l.724.423A7.953 7.953 0 0 0 12 20a8 8 0 1 0-8-8c0 1.436.377 2.813 1.084 4.024l.422.724-.653 2.401 2.4-.655zM2.004 22l1.352-4.968A9.954 9.954 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.954 9.954 0 0 1-5.03-1.355L2.004 22zM8.391 7.308c.134-.01.269-.01.403-.004.054.004.108.01.162.016.159.018.334.115.393.249.298.676.588 1.357.868 2.04.062.152.025.347-.093.537a4.38 4.38 0 0 1-.263.372c-.113.145-.356.411-.356.411s-.099.118-.061.265c.014.056.06.137.102.205l.059.095c.256.427.6.86 1.02 1.268.12.116.237.235.363.346.468.413.998.75 1.57 1l.005.002c.085.037.128.057.252.11.062.026.126.049.191.066a.35.35 0 0 0 .367-.13c.724-.877.79-.934.796-.934v.002a.482.482 0 0 1 .378-.127c.06.004.121.015.177.04.531.243 1.4.622 1.4.622l.582.261c.098.047.187.158.19.265.004.067.01.175-.013.373-.032.259-.11.57-.188.733a1.155 1.155 0 0 1-.21.302 2.378 2.378 0 0 1-.33.288 3.71 3.71 0 0 1-.125.09 5.024 5.024 0 0 1-.383.22 1.99 1.99 0 0 1-.833.23c-.185.01-.37.024-.556.014-.008 0-.568-.087-.568-.087a9.448 9.448 0 0 1-3.84-2.046c-.226-.199-.435-.413-.649-.626-.89-.885-1.562-1.84-1.97-2.742A3.47 3.47 0 0 1 6.9 9.62a2.729 2.729 0 0 1 .564-1.68c.073-.094.142-.192.261-.305.127-.12.207-.184.294-.228a.961.961 0 0 1 .371-.1z"/>
                        </svg>
                    </a>
                </li>
            <?php }
            if (!empty($telegram)) { ?>
                <li>
                    <a href="https://telegram.me/share/url?url=<?php echo $permalink; ?>&text=<?php the_title(); ?>"
                       target="_blank"
                       title="<?php esc_html_e('Share on Telegram', 'nader'); ?>"
                       class="dfx aic jcc">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z"/>
                            <path d="M1.923 9.37c-.51-.205-.504-.51.034-.689l19.086-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.475.553-.717.07L11 13 1.923 9.37zm4.89-.2l5.636 2.255 3.04 6.082 3.546-12.41L6.812 9.17z"/>
                        </svg>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <?php
    }

    private function copy_link_field($permalink)
    {
        $copied_text = $this->get_settings_for_display('copied-text');
        $copy_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16 12.9v4.2c0 3.5-1.4 4.9-4.9 4.9H6.9C3.4 22 2 20.6 2 17.1v-4.2C2 9.4 3.4 8 6.9 8h4.2c3.5 0 4.9 1.4 4.9 4.9Z"></path><path opacity="0.4" d="M17.1 2h-4.2C9.817 2 8.37 3.094 8.07 5.739c-.064.553.395 1.011.952 1.011H11.1c4.2 0 6.15 1.95 6.15 6.15v2.078c0 .557.457 1.015 1.01.952C20.907 15.63 22 14.183 22 11.1V6.9C22 3.4 20.6 2 17.1 2Z"></path></svg>';
        ?>
        <div class="copy-link-box dfx aic jcsb cursor-pointer text-nowrap overflow-hidden disable-select"
             data-link="<?php echo $permalink; ?>"
             data-copied-text="<?php echo !empty($copied_text) ? esc_html($copied_text) : ''; ?>">
            <span class="text"><?php echo $permalink; ?></span>
            <span class="copy-icon dfx aic jcc"><?php echo $copy_icon; ?></span>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_SharePopup());
