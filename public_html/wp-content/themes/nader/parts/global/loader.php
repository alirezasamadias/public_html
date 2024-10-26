<?php

defined( 'ABSPATH' ) || die();

$loader = get_field( 'loader-enable', 'options' );
if ( $loader ) {
	$loader_type = apply_filters( 'nader_loader_type', get_field( 'loader-type', 'options' ) );

	if ( $loader_type === 'simple' ) {
		?>
        <div class="preloader loader-simple">
            <div class="preloader-inner">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
		<?php
	}

	if ( $loader_type === 'linear' ) {
		?>
        <div id="linear-preloader">
            <div class="loader_line"></div>
        </div>
		<?php
	}
}

