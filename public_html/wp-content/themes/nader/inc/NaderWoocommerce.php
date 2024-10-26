<?php

defined('ABSPATH') || die();

final class NaderWoocommerce{

    public static function init()
    {

        add_filter('loop_shop_per_page', 'NaderWoocommerce::changeArchiveItemsPerPage', 20);

        self::removeBreadcrumb();

        self::pageMainWrapper();

        self::productGallery();

        self::removeProductSummaries();
        self::generateProductSummaries();

        self::addPlusMinusBtnToQuantity();

        add_filter('woocommerce_product_tabs', 'NaderWoocommerce::addProductExcerptTextToTabs', 5);
        add_filter('woocommerce_product_tabs', 'NaderWoocommerce::addIconToTabsTitle', 100);


        self::changeLoopItemTitle();

        self::miniCart();

        self::refactorArchiveHeader();

        self::changeCurrencySymbolByChangeLanguage();

        add_action('wp', 'NaderWoocommerce::disableSidebar');

        self::customTextInsteadEmptyPrice();

    }

    public static function changeArchiveItemsPerPage()
    {
        $col = 9;
        if (ACF_ENABLED) {
            $col = get_field('nader-shop-posts-per-page', 'options');
        }
        return $col;
    }

    public static function removeBreadcrumb()
    {
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
    }

    public static function pageMainWrapper()
    {
        add_action('woocommerce_before_main_content', function() {
            echo '<div class="main container"><div class="row justify-content-center mx-0">';
        }, 1);
        add_action('woocommerce_after_main_content', function() {
            echo '</div></div>';
        }, 50);
    }

    public static function pageSingleWrapper()
    {
        add_action('woocommerce_before_single_product', function() {
            echo '<div class="row justify-content-center">';
        }, 5);
        add_action('woocommerce_after_single_product', function() {
            echo '</div><!--/.row-->';
        }, 50);
    }

    public static function productGallery()
    {
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);

        //        add_action('woocommerce_before_single_product_summary', function () {
        //            get_template_part('parts/product', 'gallery');
        //        }, 20);
    }

    public static function removeProductSummaries()
    {
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
        remove_action('woocommerce_single_product_summary', 'WC_Structured_Data::generate_product_data()', 60);
    }

    public static function generateProductSummaries()
    {
        add_action('woocommerce_single_product_summary', 'NaderWoocommerce::attachProduct_title', 5);
        add_action('woocommerce_single_product_summary', 'NaderWoocommerce::attachProduct_price_rating__btn_actions', 10);
        add_action('woocommerce_single_product_summary', 'NaderWoocommerce::attachProduct_features', 20);
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
    }

    public static function attachProduct_title()
    {
        get_template_part('parts/product/product', 'title');
    }

    public static function attachProduct_price_rating__btn_actions()
    {
        get_template_part('parts/product/product', 'price-rating-btn-actions');
    }

    public static function attachProduct_features()
    {
        get_template_part('parts/product/product', 'features');
    }

    public static function addPlusMinusBtnToQuantity()
    {
        add_action('woocommerce_before_quantity_input_field', function() {
            echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="add cursor-pointer"><path fill="none" d="M0 0h24v24H0z"></path><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path></svg>';
        });
        add_action('woocommerce_after_quantity_input_field', function() {
            echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="sub cursor-pointer"><path fill="none" d="M0 0h24v24H0z"></path><path d="M5 11h14v2H5z"></path></svg>';
        });
    }

    public static function addProductExcerptTextToTabs($tabs)
    {
        if (has_excerpt()) {
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path opacity=".4" d="M7.37 22h9.25a4.87 4.87 0 0 0 4.87-4.87V8.37a4.87 4.87 0 0 0-4.87-4.87H7.37A4.87 4.87 0 0 0 2.5 8.37v8.75c0 2.7 2.18 4.88 4.87 4.88Z"></path><path d="M8.29 6.29c-.42 0-.75-.34-.75-.75V2.75a.749.749 0 1 1 1.5 0v2.78c0 .42-.33.76-.75.76ZM15.71 6.29c-.42 0-.75-.34-.75-.75V2.75a.749.749 0 1 1 1.5 0v2.78c0 .42-.33.76-.75.76ZM14.78 13.71H7.36a.749.749 0 1 1 0-1.5h7.42a.749.749 0 1 1 0 1.5ZM12 17.422H7.36a.749.749 0 1 1 0-1.5H12a.749.749 0 1 1 0 1.5Z"></path></svg>';

            $tabs['nader-product-introduction'] = [
                'title'    => __('Introduction', 'nader'),
                'icon'     => $icon,
                'priority' => 5,
                'callback' => 'woocommerce_template_single_excerpt'
            ];
        }

        return $tabs;
    }

    public static function addIconToTabsTitle($tabs)
    {
        if (!empty($tabs['description'])) {
            $tabs['description']['icon'] = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 5.25H3c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h18c.41 0 .75.34.75.75s-.34.75-.75.75Z"></path><path opacity=".4" d="M21.001 10.25h-9.47c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h9.47c.41 0 .75.34.75.75s-.34.75-.75.75Z"></path><path d="M21 15.25H3c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h18c.41 0 .75.34.75.75s-.34.75-.75.75Z"></path><path opacity=".4" d="M21.001 20.25h-9.47c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h9.47c.41 0 .75.34.75.75s-.34.75-.75.75Z"></path></svg>';
        }

        if (!empty($tabs['additional_information'])) {
            $tabs['additional_information']['icon'] = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path opacity=".4" d="M16.19 2H7.81C4.17 2 2 4.17 2 7.81v8.37C2 19.83 4.17 22 7.81 22h8.37c3.64 0 5.81-2.17 5.81-5.81V7.81C22 4.17 19.83 2 16.19 2Z"></path><path d="M12 10.691c-.72 0-1.31.59-1.31 1.31 0 .72.59 1.31 1.31 1.31.72 0 1.31-.59 1.31-1.31 0-.72-.59-1.31-1.31-1.31ZM7 10.691c-.72 0-1.31.59-1.31 1.31 0 .72.59 1.31 1.31 1.31.72 0 1.31-.59 1.31-1.31 0-.72-.59-1.31-1.31-1.31ZM17 10.691c-.72 0-1.31.59-1.31 1.31 0 .72.59 1.31 1.31 1.31.72 0 1.31-.59 1.31-1.31 0-.72-.59-1.31-1.31-1.31Z"></path></svg>';
        }

        if (!empty($tabs['reviews'])) {
            $tabs['reviews']['icon'] = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path opacity=".4" d="M5.74 16c.11-.49-.09-1.19-.44-1.54l-2.43-2.43c-.76-.76-1.06-1.57-.84-2.27.23-.7.94-1.18 2-1.36l3.12-.52c.45-.08 1-.48 1.21-.89l1.72-3.45C10.58 2.55 11.26 2 12 2s1.42.55 1.92 1.54l1.72 3.45c.13.26.4.51.69.68L5.56 18.44c-.14.14-.38.01-.34-.19L5.74 16Z"></path><path d="M18.7 14.462c-.36.36-.56 1.05-.44 1.54l.69 3.01c.29 1.25.11 2.19-.51 2.64a1.5 1.5 0 0 1-.9.27c-.51 0-1.11-.19-1.77-.58l-2.93-1.74c-.46-.27-1.22-.27-1.68 0l-2.93 1.74c-1.11.65-2.06.76-2.67.31-.23-.17-.4-.4-.51-.7l12.16-12.16c.46-.46 1.11-.67 1.74-.56l1.01.17c1.06.18 1.77.66 2 1.36.22.7-.08 1.51-.84 2.27l-2.42 2.43Z"></path></svg>';
        }

        return $tabs;
    }

    public static function changeLoopItemTitle()
    {
        remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
        add_action('woocommerce_shop_loop_item_title', function() {
            echo '<h3 class="' . esc_attr(apply_filters('woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title')) . '">' . get_the_title() . '<br><br></h3>';
        }, 10);
    }

    public static function changeMyAccountMenuLabels()
    {
        add_filter('woocommerce_account_menu_items', function() {
            return [
                'dashboard'       => __('Dashboard', 'woocommerce'),
                'orders'          => __('Orders', 'woocommerce'),
                'downloads'       => __('Downloads', 'woocommerce'),
                'edit-address'    => _n('Addresses', 'Address', (int)wc_shipping_enabled(), 'woocommerce'),
                'payment-methods' => __('Payment methods', 'woocommerce'),
                'edit-account'    => __('Account details', 'woocommerce'),
                'customer-logout' => __('Logout', 'woocommerce'),
            ];
        });
    }

    public static function miniCart()
    {
        add_action('wp_footer', function() {
            if (ACF_ENABLED && get_field('cart-btn-enable', 'options')) {
                NaderWoocommerce::addMiniCartBtn();
            }
        }, 4);

        add_action('wp_footer', function() {
            NaderWoocommerce::addMiniCartBox();
        }, 30);

        add_filter('woocommerce_add_to_cart_fragments', 'NaderWoocommerce::updateMiniCartCount', 10, 1);
    }

    public static function addMiniCartBtn()
    {
        get_template_part('parts/global/mini-cart', 'btn');
    }

    public static function addMiniCartBox()
    {
        get_template_part('parts/global/mini-cart', 'box');
    }

    public static function updateMiniCartCount($fragments)
    {
        $fragments['span.cart-items-counter.dfx.aic.jcc'] = '<span class="cart-items-counter dfx aic jcc">' . WC()->cart->get_cart_contents_count() . '</span>';

        return $fragments;
    }

    public static function refactorArchiveHeader()
    {
        remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
    }

    public static function changeCurrencySymbolByChangeLanguage()
    {
        add_filter('woocommerce_currency_symbol', function($currency_symbol, $currency) {
            if (!is_rtl()) {
                switch ($currency) {
                    case 'IRR':
                        $currency_symbol = 'IRR';
                        break;
                    case 'IRT':
                        $currency_symbol = 'Toman';
                        break;
                }
            }

            return $currency_symbol;
        }, 10, 2);

    }


    public static function disableSidebar()
    {
        if (ACF_ENABLED && !get_field('sidebar-shop', 'options') && function_exists('is_shop') && is_shop()) {
            remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
        }

        if (is_singular('product')) {
            remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
        }

    }

    public static function customTextInsteadEmptyPrice()
    {
        add_filter('woocommerce_get_price_html', function($price, $product) {
            $temp_price = $price;
            if ($product->get_price() == '' && ACF_ENABLED) {
                $choice = get_field('nader-single-product-without-price-replace', 'options');
                if (!empty($choice)) {
                    $in_archive = get_field('nader-single-product-without-price-replace--in-archive', 'options');

                    if ($choice == 'text') {
                        $price = get_field('nader-single-product-without-price-replace--text', 'options');
                    } elseif ($choice == 'button') {
                        $btn_text = get_field('nader-single-product-without-price-replace--button-title', 'options');
                        $btn_link = get_field('nader-single-product-without-price-replace--button-link', 'options');

                        ob_start();
                        ?>
                        <a href="<?php echo esc_url($btn_link); ?>" title="<?php echo esc_html($btn_text); ?>"
                           class="has-not-price-replacer-btn dfx aic jcc text-center"><?php echo esc_html($btn_text); ?>
                        </a>
                        <?php
                        $price = ob_get_clean();
                    }

                    if (!$in_archive && !is_singular('product')) {
                        $price = $temp_price;
                    }
                }
            } elseif ($product->get_price() == 0 || $product->get_price() == '0' && ACF_ENABLED) {
                $free_txt = get_field('nader-single-product-without-price-replace--free', 'options');
                if (!empty($free_txt)) {
                    $price = '<span class="free-price">' . esc_html($free_txt) . '</span>';
                }
            }

            return $price;
        }, 100, 2);
    }

}

if (class_exists('WooCommerce')) {
    NaderWoocommerce::init();
}
