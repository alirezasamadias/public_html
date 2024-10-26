<?php
/**
 * @package Polylang-WC
 */

/**
 * Manages the compatibility with Yith WooCommerce Ajax Search.
 * Version tested: 2.2.1.
 *
 * @since 0.9
 */
class PLLWC_Yith_WCAS {

	/**
	 * Constructor.
	 *
	 * @since 0.9
	 */
	public function __construct() {
		// Only versions >= 2.0.0 are supported.
		add_filter( 'ywcas_block_common_localize', array( $this, 'filter_block_localize' ), 99 );
	}

	/**
	 * Filters the site URL in the current language in localization information.
	 *
	 * @since 1.9.5
	 *
	 * @param array $script_localize An array of information about localization.
	 * @return array
	 */
	public function filter_block_localize( $script_localize ) {
		$script_localize['siteURL'] = pll_home_url();
		return $script_localize;
	}
}
