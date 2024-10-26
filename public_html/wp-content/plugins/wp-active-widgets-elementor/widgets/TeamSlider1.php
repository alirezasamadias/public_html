<?php

namespace Elementor;

defined('ABSPATH') || die();

use AE_E_UTILS;
use WP_Query;
use WP_ACTIVE_WE_QueryBuilder;
use WP_ACTIVE_WE_OwlCarousel;
use AE_E_FUNCTIONS;

class WP_ACTIVE_WE_TeamSlider1 extends Widget_Base{

    use WP_ACTIVE_WE_QueryBuilder;
    use WP_ACTIVE_WE_OwlCarousel;

    public function get_script_depends()
    {
        return ['jquery', 'owl-js', 'wp-active-we-owl-slider', 'wp-active-we-intro-animation'];
    }

    public function get_style_depends()
    {
        wp_register_style('wp-active-we-team-slider-1', AE_E_CSS_DIR . 'team-slider-1.css');
        return ['owl-css', 'owl-theme-default', 'wp-active-we-team-slider-1'];
    }

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'اسلایدر کارمندان 1';
    }

    public function get_icon()
    {
        return 'wp-active-we-widget eicon-person';
    }

    public function get_categories()
    {
        return ['WP_ACTIVE_WE'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('settings', ['label' => 'تنظیمات']);
        AE_E_UTILS::NOTICE($this, 'query-notice', 'لطفا در بخش تنظیمات کوئری، نوع نوشته را بر روی کارمندان قرار دهید.');
        $this->add_group_control(Group_Control_Image_Size::get_type(), [
            'name'      => 'image-dimensions',
            // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
            'default'   => 'medium_large',
            'separator' => 'none',
            'exclude'   => ['custom']
        ]);

        AE_E_UTILS::SWITCH_FIELD($this, 'intro-animation', 'انیمیشن ورود');

        AE_E_UTILS::SWITCH_FIELD($this, 'position', 'جایگاه');
        AE_E_UTILS::SWITCH_FIELD($this, 'expertise', 'تخصص');
        AE_E_UTILS::SWITCH_FIELD($this, 'socials', 'شبکه های اجتماعی');
        AE_E_UTILS::NOTICE($this, 'socials-notice', 'فقط تا 5 مورد اول نمایش داده میشود!', 'socials', 'yes');

        $this->end_controls_section();


        // Query Settings
        $this->QuerySettings();

        // Slider Settings
        $this->OwlSettings();

        $this->register_controls_styles();

        $this->QueryNotHavePostsStyle();

    }

    protected function register_controls_styles()
    {

        // BOX
        AE_E_UTILS::SECTION_START($this, 'box', 'باکس', 'style');
        AE_E_UTILS::BoxUtils($this, 'box', '.post-item');
        AE_E_UTILS::SECTION_END($this);


        // IMAGE
        AE_E_UTILS::SECTION_START($this, 'image', 'تصویر', 'style');
        AE_E_UTILS::SameWithHeight($this, 'image-wh', '.member-avatar img', 50, 300, null);
        AE_E_UTILS::DIMENSIONS_FIELD($this, 'image-radius', 'خمیدگی', '.member-avatar img', 'border-radius');
        AE_E_UTILS::SHADOW_FIELD($this, 'image-shadow', 'سایه', '.member-avatar img');
        AE_E_UTILS::SECTION_END($this);


        // TEXTS
        AE_E_UTILS::SECTION_START($this, 'texts', 'متن ها', 'style');

        AE_E_UTILS::Separator($this, 'member-name', 'نام');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'member-name-distance', 'فاصله از بالا', 0, 50, null, '.member-name', 'margin-top');
        AE_E_UTILS::TextUtils($this, 'member-name', '.member-name');

        AE_E_UTILS::Separator($this, 'member-position', 'جایگاه', 'position', 'yes');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'member-position-distance', 'فاصله از بالا', 0, 50, null, '.member-position', 'margin-top', 'position', 'yes');
        AE_E_UTILS::TextUtils($this, 'member-position', '.member-position', false, false, 'position', 'yes');

        AE_E_UTILS::Separator($this, 'member-expertise', 'تخصص', 'expertise', 'yes');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'member-expertise-distance', 'فاصله از بالا', 0, 50, null, '.member-expertise', 'margin-top', 'expertise', 'yes');
        AE_E_UTILS::TextUtils($this, 'member-expertise', '.member-expertise', false, false, 'expertise', 'yes');

        AE_E_UTILS::SECTION_END($this);


        // SOCIALS
        AE_E_UTILS::SECTION_START($this, 'member-socials', 'شبک های اجتماعی', 'style', 'socials', 'yes');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'socials-distance', 'فاصله از بالا', 0, 50, null, '.member-socials', 'margin-top');
        AE_E_UTILS::IconUtils($this, 'socials', '.member-socials a');
        AE_E_UTILS::SECTION_END($this);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $query = null;
        $query_args = $this->QueryArgBuilder();
        $query = new WP_Query($query_args);

        if (!$query->have_posts()) {
            $this->add_render_attribute('team-slider-1', 'class', 'wo-post');
        }

        $slider_settings = $this->RenderOwlSettings();
        $this->add_render_attribute('team-slider-1', 'class', 'wp-active-we-team-slider-1 team-posts slider-container owl-carousel');
        $this->add_render_attribute('team-slider-1', 'data-slider-settings', json_encode($slider_settings));
        if ($settings['intro-animation'] === 'yes') {
            $this->add_render_attribute('team-slider-1', 'class', 'active-animation');
            $this->add_render_attribute('team-slider-1', 'data-animation-target', '.elementor-element-' . $this->get_id() . ' .post-item');
            $this->add_render_attribute('team-slider-1', 'data-animation-offset', '100');
        }

        ?>
        <div <?php $this->print_render_attribute_string('team-slider-1'); ?>>
            <?php $this->printQuery($settings, $query); ?>
        </div>
        <?php
    }


    protected function printQuery($settings, $query)
    {

        $display_position = $settings['position'];
        $display_expertise = $settings['expertise'];
        $display_socials = $settings['socials'];
        $thumb_size = $settings['image-dimensions_size'];

        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $link = get_the_permalink();
            $title = get_the_title();

            $position = get_post_meta($post_id, 'position', true);
            $expertise = get_post_meta($post_id, 'expertise', true);
            ?>

            <div class="team-item-wrapper">
                <div <?php post_class('post-item dfx dir-v aic jcc'); ?>>

                    <div class="thumb-holder">
                        <a href="<?php echo esc_url($link); ?>" title="<?php esc_html_e($title); ?>"
                           class="member-avatar dfx aic jcc">
                            <?php the_post_thumbnail($thumb_size); ?>
                        </a>
                    </div>

                    <a href="<?php echo esc_url($link); ?>" title="<?php esc_html_e($title); ?>"
                       class="member-name dfx aic jcc w-100">
                        <?php esc_html_e($title); ?>
                    </a>
                    <?php if (!empty($display_position) && !empty($position)) { ?>
                        <span class="member-position dfx aic jcc w-100">
                        <?php esc_html_e($position); ?>
                    </span>
                    <?php } ?>
                    <?php if (!empty($display_expertise) && !empty($expertise)) { ?>
                        <span class="member-expertise dfx aic jcc w-100">
                        <?php esc_html_e($expertise); ?>
                    </span>
                    <?php } ?>

                    <?php if (!empty($display_socials)) {
                        $this->socials($post_id);
                    } ?>
                </div>
            </div>

            <?php
        } // END WHILE

        if (!$query->have_posts()) {
            $this->QueryNotHavePostsMessage();
        }

        wp_reset_postdata();
    }

    protected function socials($post_id)
    {
        $facebook = get_post_meta($post_id, 'facebook', true);
        $linkedin = get_post_meta($post_id, 'linkedin', true);
        $instagram = get_post_meta($post_id, 'instagram', true);
        $twitter = get_post_meta($post_id, 'twitter', true);
        $github = get_post_meta($post_id, 'github', true);
        $gitlab = get_post_meta($post_id, 'gitlab', true);
        $pinterest = get_post_meta($post_id, 'pinterest', true);
        $dribble = get_post_meta($post_id, 'dribbble', true);

        if (!empty([
            $facebook,
            $linkedin,
            $instagram,
            $twitter,
            $github,
            $gitlab,
            $pinterest,
            $dribble
        ])) {
            ?>
            <ul class="member-socials dfx aic jcc wrap w-100 ae-gap-10">
                <?php if (!empty($facebook)) { ?>
                    <li>
                        <a href="<?php esc_html_e($facebook); ?>"
                           title="<?php _e('facebook', 'wp-active-widgets-elementor'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M13 9H17.5L17 11H13V20H11V11H7V9H11V7.12777C11 5.34473 11.1857 4.69816 11.5343 4.04631C11.8829 3.39446 12.3945 2.88288 13.0463 2.53427C13.6982 2.18565 14.3447 2 16.1278 2C16.6498 2 17.1072 2.05 17.5 2.15V4H16.1278C14.8041 4 14.401 4.07784 13.9895 4.29789C13.6862 4.46011 13.4601 4.68619 13.2979 4.98951C13.0778 5.40096 13 5.80407 13 7.12777V9Z"></path>
                            </svg>
                        </a>
                    </li>
                <?php } ?>
                <?php if (!empty($linkedin)) { ?>
                    <li>
                        <a href="<?php esc_html_e($linkedin); ?>"
                           title="<?php _e('linkedin', 'wp-active-widgets-elementor'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.001 9.55005C12.9181 8.61327 14.1121 8 15.501 8C18.5385 8 21.001 10.4624 21.001 13.5V21H19.001V13.5C19.001 11.567 17.434 10 15.501 10C13.568 10 12.001 11.567 12.001 13.5V21H10.001V8.5H12.001V9.55005ZM5.00098 6.5C4.17255 6.5 3.50098 5.82843 3.50098 5C3.50098 4.17157 4.17255 3.5 5.00098 3.5C5.8294 3.5 6.50098 4.17157 6.50098 5C6.50098 5.82843 5.8294 6.5 5.00098 6.5ZM4.00098 8.5H6.00098V21H4.00098V8.5Z"></path>
                            </svg>
                        </a>
                    </li>
                <?php } ?>
                <?php if (!empty($instagram)) { ?>
                    <li>
                        <a href="<?php esc_html_e($instagram); ?>"
                           title="<?php _e('instagram', 'wp-active-widgets-elementor'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.001 9C10.3436 9 9.00098 10.3431 9.00098 12C9.00098 13.6573 10.3441 15 12.001 15C13.6583 15 15.001 13.6569 15.001 12C15.001 10.3427 13.6579 9 12.001 9ZM12.001 7C14.7614 7 17.001 9.2371 17.001 12C17.001 14.7605 14.7639 17 12.001 17C9.24051 17 7.00098 14.7629 7.00098 12C7.00098 9.23953 9.23808 7 12.001 7ZM18.501 6.74915C18.501 7.43926 17.9402 7.99917 17.251 7.99917C16.5609 7.99917 16.001 7.4384 16.001 6.74915C16.001 6.0599 16.5617 5.5 17.251 5.5C17.9393 5.49913 18.501 6.0599 18.501 6.74915ZM12.001 4C9.5265 4 9.12318 4.00655 7.97227 4.0578C7.18815 4.09461 6.66253 4.20007 6.17416 4.38967C5.74016 4.55799 5.42709 4.75898 5.09352 5.09255C4.75867 5.4274 4.55804 5.73963 4.3904 6.17383C4.20036 6.66332 4.09493 7.18811 4.05878 7.97115C4.00703 9.0752 4.00098 9.46105 4.00098 12C4.00098 14.4745 4.00753 14.8778 4.05877 16.0286C4.0956 16.8124 4.2012 17.3388 4.39034 17.826C4.5591 18.2606 4.7605 18.5744 5.09246 18.9064C5.42863 19.2421 5.74179 19.4434 6.17187 19.6094C6.66619 19.8005 7.19148 19.9061 7.97212 19.9422C9.07618 19.9939 9.46203 20 12.001 20C14.4755 20 14.8788 19.9934 16.0296 19.9422C16.8117 19.9055 17.3385 19.7996 17.827 19.6106C18.2604 19.4423 18.5752 19.2402 18.9074 18.9085C19.2436 18.5718 19.4445 18.2594 19.6107 17.8283C19.8013 17.3358 19.9071 16.8098 19.9432 16.0289C19.9949 14.9248 20.001 14.5389 20.001 12C20.001 9.52552 19.9944 9.12221 19.9432 7.97137C19.9064 7.18906 19.8005 6.66149 19.6113 6.17318C19.4434 5.74038 19.2417 5.42635 18.9084 5.09255C18.573 4.75715 18.2616 4.55693 17.8271 4.38942C17.338 4.19954 16.8124 4.09396 16.0298 4.05781C14.9258 4.00605 14.5399 4 12.001 4ZM12.001 2C14.7176 2 15.0568 2.01 16.1235 2.06C17.1876 2.10917 17.9135 2.2775 18.551 2.525C19.2101 2.77917 19.7668 3.1225 20.3226 3.67833C20.8776 4.23417 21.221 4.7925 21.476 5.45C21.7226 6.08667 21.891 6.81333 21.941 7.8775C21.9885 8.94417 22.001 9.28333 22.001 12C22.001 14.7167 21.991 15.0558 21.941 16.1225C21.8918 17.1867 21.7226 17.9125 21.476 18.55C21.2218 19.2092 20.8776 19.7658 20.3226 20.3217C19.7668 20.8767 19.2076 21.22 18.551 21.475C17.9135 21.7217 17.1876 21.89 16.1235 21.94C15.0568 21.9875 14.7176 22 12.001 22C9.28431 22 8.94514 21.99 7.87848 21.94C6.81431 21.8908 6.08931 21.7217 5.45098 21.475C4.79264 21.2208 4.23514 20.8767 3.67931 20.3217C3.12348 19.7658 2.78098 19.2067 2.52598 18.55C2.27848 17.9125 2.11098 17.1867 2.06098 16.1225C2.01348 15.0558 2.00098 14.7167 2.00098 12C2.00098 9.28333 2.01098 8.94417 2.06098 7.8775C2.11014 6.8125 2.27848 6.0875 2.52598 5.45C2.78014 4.79167 3.12348 4.23417 3.67931 3.67833C4.23514 3.1225 4.79348 2.78 5.45098 2.525C6.08848 2.2775 6.81348 2.11 7.87848 2.06C8.94514 2.0125 9.28431 2 12.001 2Z"></path>
                            </svg>
                        </a>
                    </li>
                <?php } ?>
                <?php if (!empty($twitter)) { ?>
                    <li>
                        <a href="<?php esc_html_e($twitter); ?>"
                           title="<?php _e('twitter', 'wp-active-widgets-elementor'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M15.3499 5.55005C13.7681 5.55005 12.4786 6.81809 12.4504 8.39658L12.4223 9.97162C12.4164 10.3029 12.143 10.5667 11.8117 10.5608C11.7881 10.5604 11.7646 10.5586 11.7413 10.5554L10.1805 10.3426C8.12699 10.0625 6.15883 9.11736 4.27072 7.54411C3.67275 10.8538 4.84 13.1472 7.65342 14.916L9.40041 16.0142C9.68095 16.1906 9.7654 16.561 9.58903 16.8415C9.54861 16.9058 9.49636 16.9619 9.43504 17.0067L7.84338 18.1696C8.78973 18.229 9.68938 18.1875 10.435 18.0387C15.1526 17.0973 18.2897 13.547 18.2897 7.69109C18.2897 7.213 17.2774 5.55005 15.3499 5.55005ZM10.4507 8.3609C10.4983 5.69584 12.6735 3.55005 15.3499 3.55005C16.7132 3.55005 17.9465 4.10683 18.8348 5.0054C19.5462 5.00005 20.1514 5.17991 21.5035 4.35967C21.1693 6.00005 21.0034 6.71201 20.2897 7.69109C20.2897 15.3326 15.5926 19.0489 10.8264 20C7.5587 20.6522 2.80646 19.5815 1.44531 18.1587C2.13874 18.1054 4.95928 17.802 6.58895 16.6092C5.20994 15.6987 -0.278631 12.4681 3.32772 3.78642C5.02119 5.76307 6.73797 7.10855 8.47807 7.82286C9.63548 8.29798 9.91978 8.2885 10.4507 8.3609Z"></path>
                            </svg>
                        </a>
                    </li>
                <?php } ?>
                <?php if (!empty($github)) { ?>
                    <li>
                        <a href="<?php esc_html_e($github); ?>"
                           title="<?php _e('github', 'wp-active-widgets-elementor'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M5.88401 18.6533C5.58404 18.4526 5.32587 18.1975 5.0239 17.8369C4.91473 17.7065 4.47283 17.1524 4.55811 17.2583C4.09533 16.6833 3.80296 16.417 3.50156 16.3089C2.9817 16.1225 2.7114 15.5499 2.89784 15.0301C3.08428 14.5102 3.65685 14.2399 4.17672 14.4263C4.92936 14.6963 5.43847 15.1611 6.12425 16.0143C6.03025 15.8974 6.46364 16.441 6.55731 16.5529C6.74784 16.7804 6.88732 16.9182 6.99629 16.9911C7.20118 17.1283 7.58451 17.1874 8.14709 17.1311C8.17065 16.7489 8.24136 16.3783 8.34919 16.0358C5.38097 15.3104 3.70116 13.3952 3.70116 9.63971C3.70116 8.40085 4.0704 7.28393 4.75917 6.3478C4.5415 5.45392 4.57433 4.37284 5.06092 3.15636C5.1725 2.87739 5.40361 2.66338 5.69031 2.57352C5.77242 2.54973 5.81791 2.53915 5.89878 2.52673C6.70167 2.40343 7.83573 2.69705 9.31449 3.62336C10.181 3.41879 11.0885 3.315 12.0012 3.315C12.9129 3.315 13.8196 3.4186 14.6854 3.62277C16.1619 2.69 17.2986 2.39649 18.1072 2.52651C18.1919 2.54013 18.2645 2.55783 18.3249 2.57766C18.6059 2.66991 18.8316 2.88179 18.9414 3.15636C19.4279 4.37256 19.4608 5.45344 19.2433 6.3472C19.9342 7.28337 20.3012 8.39208 20.3012 9.63971C20.3012 13.3968 18.627 15.3048 15.6588 16.032C15.7837 16.447 15.8496 16.9105 15.8496 17.4121C15.8496 18.0765 15.8471 18.711 15.8424 19.4225C15.8412 19.6127 15.8397 19.8159 15.8375 20.1281C16.2129 20.2109 16.5229 20.5077 16.6031 20.9089C16.7114 21.4504 16.3602 21.9773 15.8186 22.0856C14.6794 22.3134 13.8353 21.5538 13.8353 20.5611C13.8353 20.4708 13.836 20.3417 13.8375 20.1145C13.8398 19.8015 13.8412 19.599 13.8425 19.4094C13.8471 18.7019 13.8496 18.0716 13.8496 17.4121C13.8496 16.7148 13.6664 16.2602 13.4237 16.051C12.7627 15.4812 13.0977 14.3973 13.965 14.2999C16.9314 13.9666 18.3012 12.8177 18.3012 9.63971C18.3012 8.68508 17.9893 7.89571 17.3881 7.23559C17.1301 6.95233 17.0567 6.54659 17.199 6.19087C17.3647 5.77663 17.4354 5.23384 17.2941 4.57702L17.2847 4.57968C16.7928 4.71886 16.1744 5.0198 15.4261 5.5285C15.182 5.69438 14.8772 5.74401 14.5932 5.66413C13.7729 5.43343 12.8913 5.315 12.0012 5.315C11.111 5.315 10.2294 5.43343 9.40916 5.66413C9.12662 5.74359 8.82344 5.69492 8.57997 5.53101C7.8274 5.02439 7.2056 4.72379 6.71079 4.58376C6.56735 5.23696 6.63814 5.77782 6.80336 6.19087C6.94565 6.54659 6.87219 6.95233 6.61423 7.23559C6.01715 7.8912 5.70116 8.69376 5.70116 9.63971C5.70116 12.8116 7.07225 13.9683 10.023 14.2999C10.8883 14.3971 11.2246 15.4769 10.5675 16.0482C10.3751 16.2156 10.1384 16.7802 10.1384 17.4121V20.5611C10.1384 21.5474 9.30356 22.2869 8.17878 22.09C7.63476 21.9948 7.27093 21.4766 7.36613 20.9326C7.43827 20.5204 7.75331 20.2116 8.13841 20.1276V19.1381C7.22829 19.1994 6.47656 19.0498 5.88401 18.6533Z"></path>
                            </svg>
                        </a>
                    </li>
                <?php } ?>
                <?php if (!empty($gitlab)) { ?>
                    <li>
                        <a href="<?php esc_html_e($gitlab); ?>"
                           title="<?php _e('gitlab', 'wp-active-widgets-elementor'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M5.54429 2.67305C5.81644 2.49995 6.13587 2.41612 6.45799 2.43329C6.78102 2.4505 7.09056 2.56841 7.34318 2.77049L7.34405 2.77119C7.59044 2.96879 7.76998 3.2372 7.85866 3.5399L9.30537 7.96754H14.6944L16.1411 3.5399C16.2298 3.23722 16.4093 2.96879 16.6557 2.77116L16.6604 2.76745C16.9128 2.56777 17.2209 2.45133 17.5424 2.43423C17.8638 2.41712 18.1826 2.50023 18.4547 2.67197L18.4571 2.67347C18.7307 2.84735 18.9427 3.10328 19.0624 3.40486L19.0664 3.41491L21.5393 9.86622C21.9619 10.9712 22.0136 12.1836 21.6865 13.3205C21.3594 14.4574 20.6715 15.457 19.7263 16.1685L12.9955 21.2331L12.9945 21.2338C12.7066 21.4513 12.3554 21.5692 11.9943 21.5692C11.6332 21.5692 11.2819 21.4513 10.9939 21.2337L4.26254 16.1683C3.32063 15.4562 2.63541 14.4574 2.30989 13.3224C1.98437 12.1873 2.03616 10.9772 2.45747 9.8741L4.93724 3.40497C5.0571 3.10297 5.26966 2.84673 5.54429 2.67305ZM6.35534 4.73567L4.16029 10.4639C3.87993 11.2013 3.82298 12.0676 4.04049 12.8261C4.25704 13.5811 4.71123 14.2461 5.33544 14.7225L11.9943 19.7329L18.6484 14.7265C19.2789 14.2502 19.7379 13.5822 19.9563 12.8227C20.1751 12.0624 20.1148 11.1847 19.8328 10.4455L17.6444 4.73558L16.0001 9.76791H7.9996L6.35534 4.73567Z"></path>
                            </svg>
                        </a>
                    </li>
                <?php } ?>
                <?php if (!empty($pinterest)) { ?>
                    <li>
                        <a href="<?php esc_html_e($pinterest); ?>"
                           title="<?php _e('pinterest', 'wp-active-widgets-elementor'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8.49161 19.1912C8.51535 18.8546 8.56306 18.5199 8.63456 18.1897C8.69754 17.8951 8.88867 17.0596 9.16872 15.8498L9.17581 15.8191C9.29895 15.2872 9.43089 14.7192 9.56283 14.1525C9.64199 13.8124 9.70356 13.5484 9.74438 13.4602C9.55012 13.0123 9.45298 12.5263 9.45969 12.0373C9.45969 10.6999 10.2157 9.66359 11.1958 9.6636C11.5555 9.65809 11.8996 9.81388 12.1383 10.09C12.3764 10.3655 12.4863 10.7335 12.4404 11.086C12.4404 11.5385 12.3548 11.8844 11.9865 13.1212C11.9158 13.3587 11.8674 13.5254 11.8215 13.692C11.7696 13.8799 11.7261 14.0503 11.6887 14.2136C11.5928 14.6003 11.6811 15.011 11.9262 15.3195C12.1707 15.6272 12.5421 15.7966 12.9319 15.7762C14.4242 15.7762 15.5321 13.7911 15.5321 11.2277C15.5321 9.25804 14.2412 7.95424 12.1 7.95416C11.0224 7.91127 9.97466 8.32523 9.20095 9.09986C8.42664 9.87508 7.99452 10.9437 8.00559 12.0614C7.98214 12.6633 8.17064 13.2536 8.51804 13.7053C8.69915 13.8441 8.76869 14.0885 8.69262 14.2941C8.65157 14.4632 8.55259 14.8473 8.51649 14.9755C8.49464 15.1032 8.41497 15.2131 8.30126 15.2715C8.18678 15.3303 8.05172 15.3297 7.94618 15.2737C6.78507 14.7954 6.14967 13.4963 6.14967 11.8349C6.14967 8.84907 8.64129 6.2497 12.3417 6.2497C15.4772 6.2497 17.8231 8.57864 17.8231 11.3896C17.8231 14.922 15.8911 17.4942 13.1337 17.4942C12.3393 17.5202 11.5838 17.162 11.087 16.535L11.044 16.712C10.9499 17.0992 10.9028 17.2928 10.8368 17.5638L10.8349 17.5715C10.6887 18.1717 10.5867 18.5885 10.5471 18.7452C10.4412 19.0998 10.307 19.448 10.1471 19.7841C10.7421 19.9253 11.3628 20 12.001 20C16.4193 20 20.001 16.4183 20.001 12C20.001 7.58172 16.4193 4 12.001 4C7.5827 4 4.00098 7.58172 4.00098 12C4.00098 15.1594 5.83244 17.8911 8.49161 19.1912ZM12.001 22C6.47813 22 2.00098 17.5228 2.00098 12C2.00098 6.47715 6.47813 2 12.001 2C17.5238 2 22.001 6.47715 22.001 12C22.001 17.5228 17.5238 22 12.001 22Z"></path>
                            </svg>
                        </a>
                    </li>
                <?php } ?>
                <?php if (!empty($dribble)) { ?>
                    <li>
                        <a href="<?php esc_html_e($dribble); ?>"
                           title="<?php _e('dribble', 'wp-active-widgets-elementor'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19.9887 11.5716C19.9029 9.94513 19.3313 8.44745 18.4163 7.22097C18.1749 7.48407 17.8785 7.7698 17.4957 8.09159C16.5881 8.85458 15.4887 9.54307 14.1834 10.101C14.3498 10.4506 14.5029 10.7899 14.6376 11.1098L14.6388 11.1125C14.6652 11.1742 14.6879 11.2306 14.7321 11.3418C14.7379 11.3562 14.7433 11.3697 14.7485 11.3825C16.2621 11.2122 17.8576 11.2749 19.4049 11.4845C19.6106 11.5123 19.805 11.5415 19.9887 11.5716ZM10.6044 4.1213C10.7783 4.36621 10.9602 4.62859 11.1803 4.95378C11.7929 5.8589 12.396 6.81391 12.9604 7.79507C13.0749 7.99416 13.187 8.19289 13.2964 8.39112C14.5193 7.90993 15.5296 7.30281 16.3438 6.62486C16.6731 6.35063 16.9383 6.093 17.1403 5.86972C15.7501 4.70277 13.9571 4 12 4C11.524 4 11.0576 4.04158 10.6044 4.1213ZM4.25266 9.99755C4.83145 9.98452 5.48467 9.94941 6.29303 9.87518C7.90024 9.72758 9.54141 9.46249 11.1549 9.05274C10.5719 8.03721 9.93888 7.02331 9.29452 6.05378C8.98479 5.58775 8.68357 5.14992 8.45484 4.82642C6.39541 5.84613 4.83794 7.72658 4.25266 9.99755ZM5.78366 17.036C6.17111 16.4693 6.68061 15.8314 7.35797 15.1374C8.81199 13.6478 10.5286 12.4878 12.5139 11.8473C12.5417 11.8391 12.5604 11.8336 12.576 11.829C12.411 11.4651 12.2562 11.1405 12.1003 10.8342C10.2643 11.3687 8.3303 11.703 6.40279 11.8762C5.46319 11.9606 4.62005 11.9981 4 12.0044C4.00102 13.9112 4.66915 15.662 5.78366 17.036ZM15.0045 19.4166C14.9001 18.8745 14.7669 18.2706 14.5899 17.574C14.2689 16.3112 13.8668 15.012 13.373 13.7078C11.3712 14.4343 9.77574 15.4974 8.54309 16.7649C7.94904 17.3757 7.51244 17.9537 7.22642 18.4203C8.55892 19.4127 10.2109 20 12 20C13.0626 20 14.0769 19.7928 15.0045 19.4166ZM16.8778 18.3414C18.4073 17.1632 19.4985 15.444 19.8652 13.4703C19.5253 13.3865 19.094 13.3005 18.6196 13.2346C17.5756 13.0897 16.5014 13.0655 15.4409 13.2018C15.8933 14.4764 16.2642 15.7332 16.5608 16.9361C16.6903 17.4614 16.7958 17.9358 16.8778 18.3414ZM12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22Z"></path>
                            </svg>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <?php
        }

    }
}

Plugin::instance()->widgets_manager->register(new WP_ACTIVE_WE_TeamSlider1());
