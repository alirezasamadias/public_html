<?php
defined('ABSPATH') || die();


/**
 * Enqueue Script & Pages
 *
 * @return void
 */
function nader_enqueue_scripts()
{

    // STYLES
    wp_register_style('nader-owl-css', NADER_CSS_DIR . 'owl.carousel.min.css');
    wp_register_style('fancybox-gallery', NADER_CSS_DIR . 'fancybox.min.css');
    if (is_singular(['product', 'project'])) {
        wp_enqueue_style('nader-owl-css');
        wp_enqueue_style('fancybox-gallery');
    }

    if (is_singular()) {
        wp_enqueue_style('nader-single-post', get_stylesheet_directory_uri() . '/assets/scss/single.css');
    }
    if (is_singular('project')) {
        wp_enqueue_style('nader-single-project', get_stylesheet_directory_uri() . '/assets/scss/project.css');
    }

    wp_enqueue_style('nader-loop', get_stylesheet_directory_uri() . '/assets/scss/loop.css');

    if (RealPressHelper::isActiveWC()) {
        wp_enqueue_style('nader-woo-styles', NADER_CSS_DIR . '/woo.min.css');
        wp_enqueue_style('nader-login-style', get_stylesheet_directory_uri() . '/assets/scss/login.css');
        wp_enqueue_style('nader-woo-scss-styles', get_stylesheet_directory_uri() . '/assets/scss/woocommerce.css');

        if (is_singular('product')) {
            wp_enqueue_style('nader-single-product', get_stylesheet_directory_uri() . '/assets/scss/product.css');
        }

        if (function_exists('woosc_init')) {
            wp_enqueue_style('nader-compare', get_stylesheet_directory_uri() . '/assets/scss/compare.css');
        }
    }


    wp_enqueue_style('nader-popup-box', get_stylesheet_directory_uri() . '/assets/scss/popup-box.css');

    wp_enqueue_style('nader-styles', get_stylesheet_directory_uri() . '/style.min.css');


    //  SCRIPTS
    wp_enqueue_script('jquery');
    wp_register_script('nader-waypoints', NADER_JS_DIR . 'waypoints.min.js', ['jquery'], 1, true);
    wp_register_script('nader-owl-carousel', NADER_JS_DIR . 'owl.carousel.min.js', ['jquery'], 1, true);
    wp_register_script('fancybox-gallery', NADER_JS_DIR . 'fancybox.umd.js', [], 1, true);
    wp_register_script('nader-simple-parallax', NADER_JS_DIR . 'simpleParallax.min.js', ['jquery'], 1, true);
    wp_register_script('nader-rellax', NADER_JS_DIR . 'rellax.min.js', ['jquery'], 1, true);
    wp_register_script('nader-tilt', NADER_JS_DIR . 'tilt.jquery.min.js', ['jquery'], 1, true);

    if (is_singular(['product', 'project'])) {
        wp_enqueue_script('nader-owl-carousel');
        wp_enqueue_script('fancybox-gallery');
    }

    wp_enqueue_script('nader-simple-bar', NADER_JS_DIR . 'simplebar.min.js', ['jquery'], 1, true);
    wp_enqueue_script('nader-custom', NADER_JS_DIR . 'custom.js', ['jquery', 'nader-simple-bar',], 1, true);
}

add_action('wp_enqueue_scripts', 'nader_enqueue_scripts');

add_action('admin_enqueue_scripts', function() {
    wp_enqueue_style('nader-admin-styles', get_stylesheet_directory_uri() . '/assets/scss/admin.css');
    wp_enqueue_script('nader-admin-scripts',NADER_JS_DIR . 'admin.js', ['jquery'], 1, true);
});

function remove_jquery_migrate($scripts)
{
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, ['jquery-migrate']);
        }
    }
}

add_action('wp_default_scripts', 'remove_jquery_migrate');


/**
 * Add font for default WordPress login page
 */
add_action('login_enqueue_scripts', function() {
    wp_enqueue_style('nader-iran-sans-font', trailingslashit(get_stylesheet_directory_uri() . '/assets/font/') . 'irsans.css');
    ?>
    <style>
        .login label,
        .login #backtoblog a, .login #nav a,
        .wp-core-ui .button,
        .wp-core-ui .button.button-large,
        .wp-core-ui .button.button-small,
        a.preview,
        input#publish,
        input#save-post,
        #language-switcher label,
        #language-switcher select,
        .login form .input,
        .login form input[type=checkbox],
        .login input[type=text] {
            font-family: 'iranSans';
        }

        .login label {
            margin-bottom: 5px !important;
        }

        .forgetmenot {
            width: 100%;
        }

        .submit {
            display: flex;
            width: 100%;
            margin-top: 40px !important;
        }

        #wp-submit {
            width: 100%;
        }
    </style>
    <?php
});

