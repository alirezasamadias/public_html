<?php defined('ABSPATH') || die(); ?>

<form class="register-form">
    <div class="form-inner d-flex dir-v w-100">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="input-field username" placeholder="<?php _e('Username', 'nader'); ?>"
               required>
        <label for="email">Email</label>
        <input type="email" name="email" id="email"  class="input-field email" placeholder="<?php _e('Email', 'nader'); ?>"
               required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="input-field password"
               placeholder="<?php _e('Password', 'nader'); ?>"
               required>
        <label for="name">Name</label>
        <input type="text" name="name" class="input-field name" id="name" placeholder="<?php _e('Name', 'nader'); ?>"
               required>
        <label for="family">Family</label>
        <input type="text" name="family" class="input-field family" id="family" placeholder="<?php _e('Family', 'nader'); ?>"
               required>
        <div class="buttons d-flex align-items-center">
            <button class="form-button d-flex align-items-center justify-content-center" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18">
                    <path d="M16.0037 9.41421L7.39712 18.0208L5.98291 16.6066L14.5895 8H7.00373V6H18.0037V17H16.0037V9.41421Z"></path>
                </svg>
                <?php _e('Register', 'nader'); ?>
            </button>
        </div>
        <?php wp_nonce_field('nader_ajax_register', 'nader_ajax_register_nonce'); ?>
    </div>
</form>

