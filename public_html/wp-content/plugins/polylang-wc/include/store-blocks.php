<?php
/**
 * @package Polylang-WC
 */

/**
 * A class to handle blocks.
 *
 * @since 1.9.5
 */
class PLLWC_Store_Blocks {

	/**
	 * Setups actions filters.
	 *
	 * @since 1.9.5
	 *
	 * @return void
	 */
	public function init() {
		if ( did_action( 'pll_language_defined' ) ) {
			$this->add_filters();
		} else {
			add_action( 'pll_language_defined', array( $this, 'add_filters' ), 1 );
		}

		// The language is not defined yet in REST.
		if ( Polylang::is_rest_request() ) {
			add_filter( 'locale', array( $this, 'get_locale' ) );
		}
	}

	/**
	 * Setups actions filters once the language is defined.
	 *
	 * @since 1.9.5
	 *
	 * @return void
	 */
	public function add_filters() {
		add_action( 'wp_footer', array( $this, 'filter_dynamic_blocks' ), 0 );

		// Use `render_block_data` to translate only attribute ids rather than content (which contains content such as post titles and links).
		add_filter( 'render_block_data', array( $this, 'filter_reviews_by_product_block_id' ) );
	}

	/**
	 * Adds a script to allow filtering blocks relying on the WC REST API.
	 *
	 * @since 1.3
	 *
	 * @return void
	 */
	public function filter_dynamic_blocks() {
		// Backward compatibility with WC < 6.4.
		$path = '/wc/store/products';

		// Since WC 6.4.
		if ( version_compare( WC()->version, '6.4', '>=' ) ) {
			$path = '/wc/store/v1';
		}
		$script = $this->get_filter_script( $path );

		// Since WC 5.6.
		wp_add_inline_script( 'wc-reviews-block-frontend', $script, 'before' );
		wp_add_inline_script( 'wc-all-products-block-frontend', $script, 'before' );

		// Since WC 6.9.
		wp_add_inline_script( 'wc-checkout-block-frontend', $script, 'before' );

		// Backward compatibility with WC < 7.1.
		wp_add_inline_script( 'wc-attribute-filter-block-frontend', $script, 'before' );

		// Since WC 7.1.
		wp_add_inline_script( 'wc-filter-wrapper-block-frontend', $script, 'before' );
	}

	/**
	 * Get a script to allow filtering blocks relying on the WC REST API.
	 *
	 * @since 1.5.3
	 *
	 * @param string $path The REST API path to filter.
	 * @return string Inline js script to add.
	 */
	protected function get_filter_script( $path ) {
		/** @var string $current_language This cannot be false because the language is defined at this point */
		$current_language = pll_current_language();

		$path = esc_js( $path );
		$lang = esc_js( $current_language );

		return "wp.apiFetch.use(
			function( options, next ) {
				if ( 'undefined' !== options.path && options.path.indexOf( '{$path}' ) >= 0 ) {
					options.path += ( ( options.path.indexOf( '?' ) >= 0 ) ? '&lang={$lang}' : '?lang={$lang}' );
				}
				return next( options );
			}
		);";
	}

	/**
	 * Translates the product ID for the widget block reviews by product.
	 *
	 * @since 1.9
	 *
	 * @param array $parsed_block The block being rendered.
	 * @return array
	 */
	public function filter_reviews_by_product_block_id( $parsed_block ) {
		if ( 'woocommerce/reviews-by-product' !== $parsed_block['blockName'] ) {
			return $parsed_block;
		}

		if ( empty( PLL()->curlang ) || empty( $parsed_block['attrs']['productId'] ) ) {
			return $parsed_block;
		}

		/** @var PLLWC_Product_Language_CPT */
		$data_store = PLLWC_Data_Store::load( 'product_language' );

		$product_language = $data_store->get_language( $parsed_block['attrs']['productId'] );
		if ( PLL()->curlang->slug === $product_language ) {
			return $parsed_block;
		}

		$translated_product_id = $data_store->get( $parsed_block['attrs']['productId'] );
		if ( ! $translated_product_id ) {
			return $parsed_block;
		}

		$parsed_block['attrs']['productId'] = $translated_product_id;

		return $parsed_block;
	}

	/**
	 * Filters the locale when an account is created during checkout (REST request).
	 *
	 * @since 1.9.5
	 *
	 * @param  string $locale The locale ID.
	 * @return string
	 */
	public function get_locale( $locale ) {
		$requested_url = pll_get_requested_url();
		if ( ! is_string( $requested_url ) || ! strpos( $requested_url, '/store/v1/checkout' ) ) {
			return $locale;
		}

		if ( empty( $_GET['lang'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			return $locale;
		}

		$lang = PLL()->model->get_language( sanitize_key( $_GET['lang'] ) ); // phpcs:ignore WordPress.Security.NonceVerification
		if ( empty( $lang ) ) {
			return $locale;
		}

		return $lang->locale;
	}
}
