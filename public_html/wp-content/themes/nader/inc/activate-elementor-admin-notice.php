<?php

defined( 'ABSPATH' ) || die();

/**
 * Show in WP Dashboard notice about the elementor is not activated.
 *
 * @return void
 */
if ( ! did_action( 'elementor/loaded' ) ) {
	add_action( 'admin_notices', function () {
		// Leave to Elementor Pro to manage this.
		if ( function_exists( 'elementor_pro_load_plugin' ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file &&
		     'update' === $screen->id ) {
			return;
		}

		if ( 'true' === get_user_meta( get_current_user_id(), '_nader_install_notice', true ) ) {
			return;
		}

		$plugin = 'elementor/elementor.php';

		$installed_plugins = get_plugins();

		$is_elementor_installed = isset( $installed_plugins[ $plugin ] );

		if ( $is_elementor_installed ) {
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			$message = 'برای کار با قالب نادر به المنتور نیاز دارید. لطفا المنتور رو نصب کنید.';

			$button_text = __( 'Activate Elementor', 'nader' );
			$button_link = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin .
			                             '&amp;plugin_status=all&amp;paged=1&amp;s',
				'activate-plugin_' . $plugin );
		}
		else {
			if ( ! current_user_can( 'install_plugins' ) ) {
				return;
			}

			$message = 'برای کار با قالب نادر به المنتور نیاز دارید. لطفا المنتور رو نصب کنید.';

			$button_text = __( 'Install Elementor', 'nader' );
			$button_link =
				wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ),
					'install-plugin_elementor' );
		}

		?>
        <style>
            .notice.nader-notice {
                border-left-color : #9b0a46 !important;
                padding           : 20px;
            }

            .rtl .notice.nader-notice {
                border-right-color : #9b0a46 !important;
            }

            .notice.nader-notice .nader-notice-inner {
                display : table;
                width   : 100%;
            }

            .notice.nader-notice .nader-notice-inner .nader-notice-icon,
            .notice.nader-notice .nader-notice-inner .nader-notice-content,
            .notice.nader-notice .nader-notice-inner .nader-install-now {
                display        : table-cell;
                vertical-align : middle;
            }

            .notice.nader-notice .nader-notice-icon {
                color     : #9b0a46;
                font-size : 50px;
                width     : 50px;
            }

            .notice.nader-notice .nader-notice-content {
                padding : 0 20px;
            }

            .notice.nader-notice p {
                padding : 0;
                margin  : 0;
            }

            .notice.nader-notice h3 {
                margin : 0 0 5px;
            }

            .notice.nader-notice .nader-install-now {
                text-align : center;
            }

            .notice.nader-notice .nader-install-now .nader-install-button {
                padding        : 5px 30px;
                height         : auto;
                line-height    : 20px;
                text-transform : capitalize;
            }

            .notice.nader-notice .nader-install-now .nader-install-button i {
                padding-right : 5px;
            }

            .rtl .notice.nader-notice .nader-install-now .nader-install-button i {
                padding-right : 0;
                padding-left  : 5px;
            }

            .notice.nader-notice .nader-install-now .nader-install-button:active {
                transform : translateY(1px);
            }

            @media (max-width : 767px) {
                .notice.nader-notice {
                    padding : 10px;
                }

                .notice.nader-notice .nader-notice-inner {
                    display : block;
                }

                .notice.nader-notice .nader-notice-inner .nader-notice-content {
                    display : block;
                    padding : 0;
                }

                .notice.nader-notice .nader-notice-inner .nader-notice-icon,
                .notice.nader-notice .nader-notice-inner .nader-install-now {
                    display : none;
                }
            }
        </style>
        <script>jQuery(function ($) {
                $('div.notice.nader-install-elementor').on('click', 'button.notice-dismiss', function (event) {
                    event.preventDefault();

                    $.post(ajaxurl, {
                        action: 'nader_set_admin_notice_viewed'
                    });
                });
            });
        </script>
        <div class="notice updated is-dismissible nader-notice nader-install-elementor">
            <div class="nader-notice-inner">
                <div class="nader-notice-icon">
                    <img src="<?php echo esc_url( get_template_directory_uri() .
					                              '/assets/images/elementor-logo.png' ); ?>"
                         alt="Elementor Logo"/>
                </div>

                <div class="nader-notice-content">
                    <h3><?php esc_html_e( 'با تشکر از شما بخاطر نصب قالب نادر!', 'nader' ); ?></h3>
                    <p>
                    <p><?php echo esc_html( $message ); ?></p>
                    </p>
                </div>

                <div class="nader-install-now">
                    <a class="button button-primary nader-install-button"
                       href="<?php echo esc_attr( $button_link ); ?>"><i
                                class="dashicons dashicons-download"></i><?php echo esc_html( $button_text ); ?>
                    </a>
                </div>
            </div>
        </div>
		<?php
	} );
}


/**
 * Set Admin Notice Viewed.
 *
 * @return void
 */
add_action( 'wp_ajax_nader_set_admin_notice_viewed', function () {
	update_user_meta( get_current_user_id(), '_nader_install_notice', 'true' );
	die;
} );

