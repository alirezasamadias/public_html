<?php

defined( 'ABSPATH' ) || die();

$contact_btn = get_field( 'menu-bottom-contact-enable', 'options' );

if ( $contact_btn ) {
	?>
    <div class="contact-btn">
        <a href="<?php echo esc_url( get_field( 'menu-bottom-contact-link',
			'options' ) ); ?>" class="stretched-link">
            <span>
                <?php echo esc_html( get_field( 'menu-bottom-contact-title', 'options' ) ); ?>
            </span>
        </a>
    </div>
	<?php
}
