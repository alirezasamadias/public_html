<?php

namespace Elementor;

defined('ABSPATH') || die();

use RP_Utils;

class NaderSingleWishlistBtn extends Widget_Base{

    public function get_name()
    {
        return 'NaderSingleWishlistBtn';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : دکمه افزودن به لیست دلخواه';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-heart';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {
        RP_Utils::SECTION_START($this, 'settings', 'تنظیمات');
        RP_Utils::Separator($this, 'icon-add-head', 'آیکون افزودن');
        RP_Utils::ICON($this, 'add');
        RP_Utils::Separator($this, 'icon-delete-head', 'آیکون حذف کردن');
        RP_Utils::ICON($this, 'delete');
        RP_Utils::SECTION_END($this);


        RP_Utils::SECTION_START($this, 'btn-styles', 'استایل دکمه', 'style');
        RP_Utils::TAB_START($this, 'btn-normal');
        RP_Utils::IconUtilsLight($this, 'normal', '.ae-wishlist-form .ae-wishlist-btn');
        RP_Utils::DynamicStyleControls($this, 'btn-normal', '.ae-wishlist-form .ae-wishlist-btn', [
            'width',
            'height',
            'padding',
            'bg',
            'border',
            'radius',
            'shadow',
        ]);
        RP_Utils::TAB_MIDDLE_($this, 'btn-active', 'فعال');
        $this->add_control('active_icon_color', [
            'label'       => 'رنگ آیکون',
            'label_block' => false,
            'type'        => \Elementor\Controls_Manager::COLOR,
            'selectors'   => [
                '{{WRAPPER}} .ae-wishlist-form.added .ae-wishlist-btn i'   => 'color: {{VALUE}};',
                '{{WRAPPER}} .ae-wishlist-form.added .ae-wishlist-btn svg' => 'fill: {{VALUE}};',
            ]
        ]);
        RP_Utils::DynamicStyleControls($this, 'btn-active', '.ae-wishlist-form.added .ae-wishlist-btn', [
            'padding',
            'bg',
            'border',
            'radius',
            'shadow',
        ]);
        RP_Utils::TAB_END($this);
        RP_Utils::SECTION_END($this);


        RP_Utils::SECTION_START($this, 'notif-styles', 'استایل نوتیفکیشن', 'style');
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'       => 'notif-typography',
            'label'      => 'تایپوگرافی',
            'show_label' => true,
            'selector'   => '.ae-wishlist-notification',
        ]);
        $this->add_control('notif-color', [
            'label'       => 'رنگ متن',
            'label_block' => false,
            'type'        => \Elementor\Controls_Manager::COLOR,
            'selectors'   => [
                '.ae-wishlist-notification' => 'color: {{VALUE}};',
            ]
        ]);
        $this->add_control('notif-background', [
            'label'       => 'بکگراند',
            'label_block' => false,
            'type'        => \Elementor\Controls_Manager::COLOR,
            'selectors'   => [
                '.ae-wishlist-notification' => 'background: {{VALUE}};',
            ]
        ]);
        $this->add_control('notif-border-radius', [
            'label'     => 'خمیدگی',
            'type'      => \Elementor\Controls_Manager::DIMENSIONS,
            'selectors' => [
                '.ae-wishlist-notification' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px',
            ]
        ]);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'       => 'notif-shadow',
            'label'      => 'سایه',
            'show_label' => true,
            'selector'   => '.ae-wishlist-notification',
        ]);

        RP_Utils::SECTION_END($this);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $icon_add_type = $settings['addselected_icon']['value'];
        $icon_delete_type = $settings['deleteselected_icon']['value'];

        if (is_user_logged_in()) {
            $post_id = get_the_ID();

            global $wishlist;
            if ($wishlist->is_post_already_added($post_id)) {
                $user_id = 0;
                if (!empty($_GET['user_id'])) {
                    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $user_id = $_GET['user_id'];
                }
                ?>
                <form method="post" class="ae-wishlist-form added">
                    <?php wp_nonce_field('ae-wishlist-nonce', 'ae-wishlist-nonce') ?>
                    <input type="hidden" name="type" class="ae-wishlist-input-type" value="delete">
                    <input type="hidden" name="post_id" class="ae-wishlist-input-post-id"
                           value="<?php echo esc_html($post_id); ?>">
                    <?php if (!empty($user_id)) { ?>
                        <input type="hidden" name="user_id" value="<?php echo esc_html($user_id); ?>">
                    <?php } ?>
                    <input type="hidden" name="post_type" class="ae-wishlist-input-post-type"
                           value="<?php echo esc_html(get_post_type($post_id)); ?>">
                    <button type="submit" name="ae-wishlist-submit" class="ae-wishlist-btn">
                        <span class="add-icon">
                            <?php
                            if (!empty($icon_add_type)) {
                                RP_Utils::ICON_PRINT($this, $settings, 'add');
                            } else {
                                echo $wishlist::icon_add();
                            }
                            ?>
                        </span>
                        <span class="delete-icon">
                            <?php
                            if (!empty($icon_delete_type)) {
                                RP_Utils::ICON_PRINT($this, $settings, 'delete');
                            } else {
                                echo $wishlist::icon_delete();
                            }
                            ?>
                        </span>
                    </button>
                </form>
                <?php
                return;
            }

            ?>
            <form method="post" class="ae-wishlist-form">
                <?php wp_nonce_field('ae-wishlist-nonce', 'ae-wishlist-nonce') ?>
                <input type="hidden" name="type" class="ae-wishlist-input-type" value="add">
                <input type="hidden" name="post_id" class="ae-wishlist-input-post-id"
                       value="<?php echo esc_html($post_id); ?>">
                <input type="hidden" name="post_type" class="ae-wishlist-input-post-type"
                       value="<?php echo esc_html(get_post_type($post_id)); ?>">
                <button type="submit" name="ae-wishlist-submit" class="ae-wishlist-btn">
                    <span class="add-icon">
                        <?php
                        if (!empty($icon_add_type)) {
                            RP_Utils::ICON_PRINT($this, $settings, 'add');
                        } else {
                            echo $wishlist::icon_add();
                        }
                        ?>
                    </span>
                    <span class="delete-icon">
                        <?php
                        if (!empty($icon_delete_type)) {
                            RP_Utils::ICON_PRINT($this, $settings, 'delete');
                        } else {
                            echo $wishlist::icon_delete();
                        }
                        ?>
                    </span>
                </button>
            </form>
            <?php
        } else {
            global $wishlist;
            ?>
            <span class="ae-wishlist-btn must-login-btn">
            <span class="icon-add">
                <?php
                if (!empty($icon_add_type)) {
                    RP_Utils::ICON_PRINT($this, $settings, 'add');
                } else {
                    echo $wishlist::icon_add();
                }
                ?>
            </span>
        </span>
            <?php
        }
    }
}

Plugin::instance()->widgets_manager->register(new NaderSingleWishlistBtn());
