<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

do_action('woocommerce_before_customer_login_form'); ?>

<div class="nader-login" id="customer_login">

    <?php get_template_part('parts/header/brand'); ?>

    <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

    <div class="login-tabs-head dfx aic jcc gap-3">
        <span class="dfx aic jcc gap-2 cursor-pointer active" data-target=".nader-login .login-tab">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
               <path fill="none" d="M0 0h24v24H0z"></path>
               <path d="M4 15h2v5h12V4H6v5H4V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6zm6-4V8l5 4-5 4v-3H2v-2h8z"></path>
           </svg>
            <?php _e('Login', 'nader'); ?>
        </span>
        <span class="dfx aic jcc gap-2 cursor-pointer" data-target=".nader-login .register-tab">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
               <path fill="none" d="M0 0h24v24H0z"></path>
               <path d="M11 11V7h2v4h4v2h-4v4h-2v-4H7v-2h4zm1 11C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"></path>
           </svg>
            <?php _e('Register', 'nader'); ?>
        </span>
    </div>

    <div class="login-tab login-box">

        <?php endif; ?>

        <?php if ('yes' !== get_option('woocommerce_enable_myaccount_registration')) { ?>
            <h2><?php esc_html_e('Login', 'woocommerce'); ?></h2>
        <?php } ?>

        <form class="woocommerce-form woocommerce-form-login login" method="post">

            <?php do_action('woocommerce_login_form_start'); ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="username"><?php esc_html_e('Username or email address', 'woocommerce'); ?>&nbsp;<span
                            class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                       name="username" id="username" autocomplete="username"
                       value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
            </p>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span
                            class="required">*</span></label>
                <input class="woocommerce-Input woocommerce-Input--text input-text" type="password"
                       name="password" id="password" autocomplete="current-password"/>
            </p>

            <?php do_action('woocommerce_login_form'); ?>

            <p class="form-row">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox"
                           name="rememberme" type="checkbox" id="rememberme" value="forever"/>
                    <span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
                </label>
                <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                <button type="submit"
                        class="woocommerce-button button woocommerce-form-login__submit<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"
                        name="login"
                        value="<?php esc_attr_e('Log in', 'woocommerce'); ?>"><?php esc_html_e('Log in', 'woocommerce'); ?></button>
            </p>
            <p class="woocommerce-LostPassword lost_password">
                <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
            </p>

            <?php do_action('woocommerce_login_form_end'); ?>

        </form>

        <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

    </div>

    <div class="register-tab login-box">

        <form method="post"
              class="woocommerce-form woocommerce-form-register register" <?php do_action('woocommerce_register_form_tag'); ?> >

            <?php do_action('woocommerce_register_form_start'); ?>

            <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_username"><?php esc_html_e('Username', 'woocommerce'); ?>
                        &nbsp;<span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                           name="username" id="reg_username" autocomplete="username"
                           value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                </p>

            <?php endif; ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_email"><?php esc_html_e('Email address', 'woocommerce'); ?>
                    &nbsp;<span class="required">*</span></label>
                <input type="email" class="woocommerce-Input woocommerce-Input--text input-text"
                       name="email" id="reg_email" autocomplete="email"
                       value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
            </p>

            <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_password"><?php esc_html_e('Password', 'woocommerce'); ?>
                        &nbsp;<span class="required">*</span></label>
                    <input type="password"
                           class="woocommerce-Input woocommerce-Input--text input-text"
                           name="password" id="reg_password" autocomplete="new-password"/>
                </p>

            <?php else : ?>

                <p><?php esc_html_e('A link to set a new password will be sent to your email address.', 'woocommerce'); ?></p>

            <?php endif; ?>

            <?php do_action('woocommerce_register_form'); ?>

            <p class="woocommerce-form-row form-row">
                <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                <button type="submit"
                        class="woocommerce-Button woocommerce-button button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?> woocommerce-form-register__submit"
                        name="register"
                        value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
            </p>

            <?php do_action('woocommerce_register_form_end'); ?>

        </form>

    </div>

</div>
<?php endif; ?>

<?php do_action('woocommerce_after_customer_login_form'); ?>
