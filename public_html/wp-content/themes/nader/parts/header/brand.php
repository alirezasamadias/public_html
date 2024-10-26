<?php

defined( 'ABSPATH' ) || die();

$logo = NADER_IMG_DIR . 'logo.png';
if ( ! empty( $logo = get_field( 'site-logo', 'options' ) ) ) {
    if (is_numeric($logo)) {
        $logo = wp_get_attachment_image_url($logo);
    }
}
?>

<div class="nav-brand">
    <a href="<?php echo site_url( '/' ); ?>" title="<?php bloginfo( 'name' ); ?>">
        <img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>">
    </a>
</div>
