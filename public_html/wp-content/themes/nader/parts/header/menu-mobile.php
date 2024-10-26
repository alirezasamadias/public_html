<?php
defined('ABSPATH') || die();

$logo = NADER_IMG_DIR . 'logo.png';
if (!empty($logo = get_field('site-logo', 'options'))) {
    if (is_numeric($logo)) {
        $logo = wp_get_attachment_image_url($logo);
    }
}

$mobile_menu_title = get_field('mobile-menu_title', 'options');
$mobile_menu_subtitle = get_field('mobile-menu_subtitle', 'options');

?>

<div class="mob-header">
    <div class="d-flex align-items-center">
        <div class="nav-brand">
            <a href="<?php echo site_url('/'); ?>" title="<?php echo esc_html($mobile_menu_title); ?>">
                <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_html($mobile_menu_title); ?>">
            </a>
        </div>
        <button class="toggler-menu ms-auto me-2" title="<?php esc_html_e('Change menu', 'nader'); ?>">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</div>

<div class="mobile-menu">
    <div class="menu-header dfx jcc aic mb-3">
        <div class="hero-img dfx aic jcc mb-3">
            <img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo('name'); ?>">
        </div>
        <?php
        if (!empty($mobile_menu_title)) {
            echo '<h3>' . esc_html($mobile_menu_title) . '</h3>';
        }

        if (!empty($mobile_menu_subtitle)) {
            ?>

            <p class="ah-headline clip">
                <span class="ah-words-wrapper">
                    <b class="is-visible"><?php echo esc_html($mobile_menu_subtitle); ?></b>
                </span>
            </p>

        <?php } ?>

        <div class="close-menu cursor-pointer"></div>
    </div>
</div>
<!-- /.mobile-menu -->
