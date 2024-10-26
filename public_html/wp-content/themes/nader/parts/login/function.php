<?php
defined('ABSPATH') || die();

final class NaderAjaxLogin
{

    public static function init()
    {
        add_action('wp_enqueue_scripts', 'NaderAjaxLogin::enqueue');
        add_action('wp_footer', 'NaderAjaxLogin::template', 30);

        add_action('wp_ajax_nopriv_nader_ajax_login', 'NaderAjaxLogin::login');
        if (get_option('users_can_register')) {
            add_action('wp_ajax_nopriv_nader_ajax_register', 'NaderAjaxLogin::register');
        }

//        add_filter('google_invre_language_code_filter', 'NaderAjaxLogin::changeRecaptchaLanguage');
    }

    public static function enqueue()
    {
        $redirect_url = get_field('ajax-login-redirect', 'options');
        if (empty($redirect_url)) {
            $redirect_url = get_site_url();
        }

        wp_enqueue_style('nader-ajax-login', NADER_DIR . 'parts/login/login-register.css');
        wp_enqueue_script('nader-ajax-login', NADER_DIR . 'parts/login/login-register.js', ['jquery'], null, true);
        wp_localize_script('nader-ajax-login', 'NADER_LOGIN_AJAX', [
                'admin_ajax_url' => admin_url('admin-ajax.php'),
                'redirect_path'  => $redirect_url,
                'msg'            => [
                    'empty_u_p'      => __('Username or password is empty!', 'nader'),
                    'process_data'   => __('Processing data...', 'nader'),
                    'long_u_p'       => __('Username or password length is too long', 'nader'),
                    'all_fields_req' => __('Fill in all the fields', 'nader'),
                    'fill_field'     => __('Fill this field', 'nader')
                ]
            ]
        );
    }

    public static function template()
    {
        get_template_part('parts/login/template');
    }

    public static function login()
    {
        check_ajax_referer('nader_ajax_login', 'nader_ajax_login_nonce');

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $login_array = [];

        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        if (empty($username) || empty($password)) {
            wp_send_json_error([
                'status' => false,
                'msg'    => '<p>' . __('Username or Password is empty!', 'nader') . '</p>'
            ]);
        } elseif (strlen($username) > 60 || strlen($password) > 60) {
            wp_send_json_error([
                'status' => false,
                'msg'    => '<p>' . __('Username or password length is too long', 'nader') . '</p>'
            ]);
        }

        $login_array['user_login']    = sanitize_user($username);
        $login_array['user_password'] = trim($password);
        $login_array['remember']      = true;

        self::auth($login_array);

        wp_send_json_success([
            'status' => true,
            'msg'    => '<p>' . __('You have successfully logged in, transferring to account...', 'nader') . '</p>'
        ]);
    }

    public static function register()
    {
        check_ajax_referer('nader_ajax_register', 'nader_ajax_register_nonce');

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $username = isset($_POST['username']) ? sanitize_user($_POST['username']) : null;
        $email    = isset($_POST['email']) ? sanitize_email($_POST['email']) : null;
        $password = isset($_POST['password']) ? trim($_POST['password']) : null;
        $name     = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : null;
        $family   = isset($_POST['family']) ? sanitize_text_field($_POST['family']) : null;

        if (empty($username) || empty($email) || empty($password)) {
            wp_send_json_error([
                'status' => false,
                'msg'    => '<p>' . __('Fill in all the fields', 'nader') . '</p>'
            ]);
        }

        $info['user_login']    = $username;
        $info['user_email']    = $email;
        $info['user_pass']     = $password;
        $info['first_name']    = $name;
        $info['last_name']     = $family;
        $info['user_nicename'] = $info['user_nickname'] = $name . ' ' . $family;

        $res = wp_insert_user($info);

        if (!is_wp_error($res)) {
            $login_array['user_login']    = $username;
            $login_array['user_password'] = $password;
            $login_array['remember']      = true;

            self::auth($login_array);

            wp_send_json_success([
                'status' => true,
                'msg'    => '<p>' . __('Your registration was successful. Transferring...', 'nader') . '</p>'
            ]);

        } else {
            wp_send_json_error([
                'status' => false,
                'msg'    => '<p>' . implode('<br/>', $res->get_error_messages()) . '</p>'
            ]);
        }
    }

    public static function auth($data)
    {
        $user_login = wp_signon($data);
        if (is_wp_error($user_login)) {
            wp_send_json_error([
                'status' => false,
                'msg'    => '<p>' . implode('<br/>', $user_login->get_error_messages()) . '</p>'
            ]);
        } else {
            wp_clear_auth_cookie();
            wp_set_current_user($user_login->ID);
            wp_set_auth_cookie($user_login->ID);
            do_action('wp_login', $user_login->ID, $user_login);
        }
    }

    public static function changeRecaptchaLanguage($language_code)
    {
        $lang = get_bloginfo("language");
        if (in_array(strtolower($lang), ['fa-ir', 'fa-af'])) {
            $language_code = 'fa';
        }
        if ($lang == 'ar') {
            $language_code = 'ar';
        }
        return $language_code;
    }

}

NaderAjaxLogin::init();
