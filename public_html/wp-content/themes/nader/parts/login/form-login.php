<?php defined('ABSPATH') || die(); ?>

<form class="login-form active">
    <div class="form-inner d-flex dir-v w-100">
        <label for="login_un">Username</label>
        <input type="text" id="login_un" class="username input-field" name="username"
               placeholder="<?php _e('Username or Email or Phone number', 'nader'); ?>" required>
        <label for="login_pw">Password</label>
        <input type="password" id="login_pw" class="password input-field" name="password"
               placeholder="<?php _e('Password', 'nader'); ?>" required>
        <?php wp_nonce_field('nader_ajax_login', 'nader_ajax_login_nonce'); ?>
        <div class="buttons d-flex align-items-center">
            <button class="form-button d-flex align-items-center justify-content-center" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18">
                    <path d="M16.0037 9.41421L7.39712 18.0208L5.98291 16.6066L14.5895 8H7.00373V6H18.0037V17H16.0037V9.41421Z"></path>
                </svg>
                <?php _e('Login', 'nader'); ?>
            </button>
            <a href="<?php echo site_url('/wp-login.php?action=lostpassword') ?>" title="<?php _e('Reset password', 'nader'); ?>" class="form-button d-flex align-items-center justify-content-center cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18">
                    <path d="M12 19C12.8284 19 13.5 19.6716 13.5 20.5C13.5 21.3284 12.8284 22 12 22C11.1716 22 10.5 21.3284 10.5 20.5C10.5 19.6716 11.1716 19 12 19ZM12 2C15.3137 2 18 4.68629 18 8C18 10.1646 17.2474 11.2907 15.3259 12.9231C13.3986 14.5604 13 15.2969 13 17H11C11 14.526 11.787 13.3052 14.031 11.3989C15.5479 10.1102 16 9.43374 16 8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8V9H6V8C6 4.68629 8.68629 2 12 2Z"></path>
                </svg>
                <?php _e('Reset password', 'nader'); ?>
            </a>
        </div>
    </div>
</form>
