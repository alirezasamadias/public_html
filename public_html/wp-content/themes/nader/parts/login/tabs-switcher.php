<?php defined('ABSPATH') || die(); ?>

<div class="login-tabs-switcher d-flex align-items-center">
    <span class="login-tab-btn d-flex align-items-center cursor-pointer disable-select active" data-target=".login-register-popup .login-form">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
            <path d="M4 15H6V20H18V4H6V9H4V3C4 2.44772 4.44772 2 5 2H19C19.5523 2 20 2.44772 20 3V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V15ZM10 11V8L15 12L10 16V13H2V11H10Z"></path>
        </svg>
        <?php _e('Login', 'nader'); ?>
    </span>

    <?php if (get_option('users_can_register')) { ?>
    <span class="register-tab-btn d-flex align-items-center cursor-pointer disable-select" data-target=".login-register-popup .register-form">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
            <path d="M14 14.252V16.3414C13.3744 16.1203 12.7013 16 12 16C8.68629 16 6 18.6863 6 22H4C4 17.5817 7.58172 14 12 14C12.6906 14 13.3608 14.0875 14 14.252ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11ZM18 17V14H20V17H23V19H20V22H18V19H15V17H18Z"></path>
        </svg>
        <?php _e('Register', 'nader'); ?>
    </span>
    <?php } ?>
</div>
