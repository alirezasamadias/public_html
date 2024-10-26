<?php defined('ABSPATH') || die(); ?>

<div class="popup-box login-register-popup">

    <div class="popup-box-header d-flex align-items-center justify-content-between">
        <?php get_template_part('parts/login/tabs', 'switcher'); ?>
        <span class="popup-box-closer d-flex align-items-center justify-content-center cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path fill="none" d="M0 0h24v24H0z"/>
                <path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"/>
            </svg>
        </span>
    </div>
    <!--/.popup-box-header-->

    <div class="popup-box-inner-wrapper">

        <?php do_action('nader/popup/login/inner_wrapper/before'); ?>

        <?php
        get_template_part('parts/login/form', 'login');

        if (get_option('users_can_register')) {
            get_template_part('parts/login/form', 'register');
        }
        ?>

        <div class="login-register-result"></div>

        <?php do_action('nader/popup/login/inner_wrapper/after'); ?>

    </div>
    <!--/.popup-box-inner-wrapper-->

</div>
