<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

    <div class="nader-dashboard">

        <div class="dashboard-cards dfx jcsb">

            <div class="total-orders-items item dfx p-4">
                <span class="icon dfx aic jcc">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24"><path d="M16.25 22.5a1.75 1.75 0 1 0 0-3.5 1.75 1.75 0 0 0 0 3.5ZM8.25 22.5a1.75 1.75 0 1 0 0-3.5 1.75 1.75 0 0 0 0 3.5Z"></path><path opacity=".4" d="m4.84 3.94-.2 2.45c-.04.47.33.86.8.86h15.31c.42 0 .77-.32.8-.74.13-1.77-1.22-3.21-2.99-3.21H6.29c-.1-.44-.3-.86-.61-1.21a2.62 2.62 0 0 0-1.91-.84H2c-.41 0-.75.34-.75.75s.34.75.75.75h1.74c.31 0 .6.13.81.35.21.23.31.53.29.84Z"></path><path d="M20.51 8.75H5.17c-.42 0-.76.32-.8.73l-.36 4.35C3.87 15.53 5.21 17 6.92 17h11.12c1.5 0 2.82-1.23 2.93-2.73l.33-4.67a.782.782 0 0 0-.79-.85Z"></path></svg>
                </span>
                <div class="texts">
                    <span><?php echo __( 'Total number of orders:', 'nader' ) ?></span>
                    <b><?php echo esc_html( RealPressHelper::getUserCompletedOrdersCount() ); ?></b>
                </div>
            </div>
            <!--/.total-orders-items-->

            <div class="total-orders-price item dfx p-4">

                <span class="icon dfx aic jcc">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24"><path opacity=".4" d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z"></path><path d="M16.95 17.698c-.19 0-.38-.07-.53-.22a.754.754 0 0 1 0-1.06 6.21 6.21 0 0 0 1.83-4.42c0-1.67-.65-3.24-1.83-4.42a.754.754 0 0 1 0-1.06c.29-.29.77-.29 1.06 0a7.709 7.709 0 0 1 2.27 5.48c0 2.07-.81 4.02-2.27 5.48-.15.15-.34.22-.53.22ZM7.05 17.698c-.19 0-.38-.07-.53-.22a7.709 7.709 0 0 1-2.27-5.48c0-2.07.81-4.02 2.27-5.48.29-.29.77-.29 1.06 0 .29.29.29.77 0 1.06a6.21 6.21 0 0 0-1.83 4.42c0 1.67.65 3.24 1.83 4.42.29.29.29.77 0 1.06-.15.15-.34.22-.53.22ZM13.65 11.78l-.9-.32V9.48h.03c.44 0 .81.4.81.88 0 .41.34.75.75.75s.75-.34.75-.75c0-1.31-1.03-2.38-2.31-2.38h-.03V7.8c0-.41-.34-.75-.75-.75s-.75.34-.75.75v.18h-.23c-1.16 0-2.11.98-2.11 2.17 0 1.05.47 1.72 1.43 2.06l.9.32v1.98h-.03c-.44 0-.81-.4-.81-.88 0-.41-.34-.75-.75-.75s-.75.34-.75.75c0 1.31 1.03 2.38 2.31 2.38h.03v.18c0 .41.34.75.75.75s.75-.34.75-.75v-.18h.23c1.16 0 2.11-.98 2.11-2.17 0-1.05-.46-1.72-1.43-2.06Zm-2.81-.98c-.32-.11-.43-.17-.43-.64 0-.37.27-.67.61-.67h.23v1.46l-.41-.15Zm2.14 3.72h-.23v-1.46l.41.14c.32.11.43.17.43.64-.01.37-.28.68-.61.68Z"></path></svg>
                </span>

                <div class="texts">
                    <span><?php echo __( 'Your total purchase:', 'nader' ) ?></span>
                    <b><?php echo esc_html( RealPressHelper::getUserTotalOrdersCost() ); ?></b>
                </div>
            </div>
            <!--/.total-orders-price-->

            <div class="total-comments item dfx p-4">

                <span class="icon dfx aic jcc">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24"><path opacity=".4" d="M17.98 10.79v4c0 .26-.01.51-.04.75-.23 2.7-1.82 4.04-4.75 4.04h-.4c-.25 0-.49.12-.64.32l-1.2 1.6c-.53.71-1.39.71-1.92 0l-1.2-1.6a.924.924 0 0 0-.64-.32h-.4C3.6 19.58 2 18.79 2 14.79v-4c0-2.93 1.35-4.52 4.04-4.75.24-.03.49-.04.75-.04h6.4c3.19 0 4.79 1.6 4.79 4.79Z"></path><path d="M9.988 14c-.56 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.44 1-1 1ZM13.488 14c-.56 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1ZM6.5 14c-.56 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1Z"></path><path d="M21.98 6.79v4c0 2.94-1.35 4.52-4.04 4.75.03-.24.04-.49.04-.75v-4c0-3.19-1.6-4.79-4.79-4.79h-6.4c-.26 0-.51.01-.75.04C6.27 3.35 7.86 2 10.79 2h6.4c3.19 0 4.79 1.6 4.79 4.79Z"></path></svg>
                </span>

                <div class="texts">
                    <span><?php echo __( 'All comments:', 'nader' ) ?></span>
                    <b><?php echo esc_html( RealPressHelper::getUserCommentsCount( get_current_user_id() ) ); ?></b>
                </div>
            </div>
            <!--/.total-comments-->

        </div>
        <!--/.dashboard-cards-->

		<?php
		$last_orders = RealPressHelper::getUserLatestOrders( get_current_user_id() );
		if ( $last_orders ) {
			?>
            <h3 class="last-orders box-title"><?php _e( 'Your last orders', 'nader' ); ?></h3>
            <div class="user-info-box">
                <table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
                    <thead>
                    <tr>
                        <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number">
                            <span class="nobr"><?php _e( 'Order', 'woocommerce' ); ?></span></th>
                        <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-date">
                            <span class="nobr"><?php _e( 'Date', 'woocommerce' ); ?></span></th>
                        <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status">
                            <span class="nobr"><?php _e( 'Status', 'woocommerce' ); ?></span></th>
                        <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-total">
                            <span class="nobr"><?php _e( 'Total', 'woocommerce' ); ?></span></th>
                        <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-actions">
                            <span class="nobr"><?php _e( 'Actions', 'woocommerce' ); ?></span></th>
                    </tr>
                    </thead>

                    <tbody>
					<?php
					foreach ( $last_orders as $last_order ) {
						$order      = wc_get_order( $last_order );
						$item_count =
							$order->get_item_count() - $order->get_item_count_refunded();
						?>
                        <tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-completed order">

                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number">
                                <a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">#<?php echo $order->get_order_number() ?></a>
                            </td>
                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date">
								<?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?>
                            </td>
                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status">
								<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
                            </td>
                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-total">
								<?php
								/* translators: 1: formatted order total 2: total order items */
								echo wp_kses_post( sprintf( _n( '%1$s for %2$s item',
									'%1$s for %2$s items',
									$item_count,
									'woocommerce' ),
									$order->get_formatted_order_total(),
									$item_count ) );
								?>
                            </td>
                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions">
								<?php
								$actions = wc_get_account_orders_actions( $order );

								if ( ! empty( $actions ) ) {
									foreach ( $actions as $key => $action )
									{ // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
										echo '<a href="' . esc_url( $action['url'] ) .
										     '" class="woocommerce-button button ' .
										     sanitize_html_class( $key ) . '">' .
										     esc_html( $action['name'] ) . '</a>';
									}
								}
								?>
                            </td>
                        </tr>

					<?php } ?>
                    </tbody>
                </table>
            </div>
		<?php }


		$last_comments = RealPressHelper::getUserLatestComments( get_current_user_id(), 5 );
		if ( ! empty( $last_comments ) ) {
			?>
            <h3 class="last-comments box-title"><?php _e( 'Your last comments', 'nader' ); ?></h3>
            <div class="user-info-box last-comments-box">
                <ul>
					<?php foreach ( $last_comments as $cm ) { ?>
                        <li>
							<?php esc_html_e( 'Written In', 'nader' ); ?>:
                            <a href="<?php echo esc_url( get_comment_link( $cm->comment_ID ) ); ?>">
								<?php echo esc_html( get_the_title( $cm->comment_post_ID ) ); ?>
                            </a>
                            <p><?php echo $cm->comment_content; ?></p>
                        </li>
					<?php } ?>
                </ul>
            </div>
		<?php } ?>

    </div>

<?php

/**
 * My Account dashboard.
 *
 * @since 2.6.0
 */
do_action( 'woocommerce_account_dashboard' );

/**
 * Deprecated woocommerce_before_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action( 'woocommerce_before_my_account' );

/**
 * Deprecated woocommerce_after_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
