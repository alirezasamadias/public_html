<?php

defined('ABSPATH') || die();

final class NaderUtils{

    public static function init()
    {
        if (!ACF_ENABLED) {
            return;
        }

        add_action('admin_enqueue_scripts', 'NaderUtils::changeAdminMenuIconsColor');

        add_action('init', 'NaderUtils::registerMenusLocation');
        add_action('init', 'NaderUtils::projectCustomPostType');
        add_action('init', 'NaderUtils::projectCustomTaxonomy');
        add_action('init', 'NaderUtils::teamCustomPostType');


        add_action('after_setup_theme', 'NaderUtils::themeSetup');
        add_action('widgets_init', 'NaderUtils::initSidebars');
        add_filter('acf/load_field/name=select-menu', 'NaderUtils::addMenusToChoicesACF', 10, 1);
        add_action('wp_head', 'NaderUtils::printDynamicColor', 20);


        add_action('wp_body_open', 'NaderUtils::loader', 10);

        self::stick_box_to_corner();

        add_action('wp_footer', 'NaderUtils::overlayBox', 20);
        add_action('wp_footer', 'NaderUtils::searchBox', 30);
        add_action('wp_footer', 'NaderUtils::mouseCursor', 40);

        add_filter('excerpt_more', 'NaderUtils::refactorExcerptMore');

        self::ajaxLoginRegister();

        add_action('wp_footer', 'NaderUtils::copiedNotification', 100);

        add_filter('litespeed_esi_nonces', 'NaderUtils::addNoncesToLSC');

        add_action('switch_theme', 'NaderUtils::removeNaderVersionFromDB');


        add_action('comment_form_before_fields', 'NaderUtils::addCommentFormBeforeFields');
        add_action('comment_form_after_fields', 'NaderUtils::addCommentFormAfterFields');

        RealPressHelper::acfAllowSvgForMenu();
        RealPressHelper::allowSvgUploading();
        RealPressHelper::fixDateForPolylang();
        RealPressHelper::add_F_I_ColumnToDashboard(['post', 'project', 'team']);

    }

    public static function stick_box_to_corner()
    {
        add_action('wp_footer', function() {
            echo '<div class="stuck-to-down">';
        }, 2);
        add_action('wp_footer', 'NaderUtils::searchBtn', 6);
        add_action('wp_footer', function() {
            get_template_part('parts/global/scroll-to-top-btn');
        }, 7);
        add_action('wp_footer', function() {
            echo '</div>';
        }, 8);

        add_action('acf/init', function() {
            if (get_field('corner-btns-display-style', 'options') !== 'popup') {
                add_action('wp_footer', function() {
                    get_template_part('parts/global/corner-buttons-float');
                }, 5);
            }
            if (get_field('corner-btns-display-style', 'options') === 'popup') {
                add_action('wp_footer', function() {
                    get_template_part('parts/global/corner-buttons-popup', 'opener-btn');
                }, 5);
                add_action('wp_footer', function() {
                    get_template_part('parts/global/corner-buttons-popup');
                }, 50);
            }
        });

    }

    public static function changeAdminMenuIconsColor()
    {
        wp_enqueue_style('nader_admin_color', get_template_directory_uri() . '/assets/css/nader-admin-color.css', false, '1.0.0');
    }

    public static function themeSetup()
    {
        add_theme_support('title-tag');

        add_theme_support('post-thumbnails');
        add_image_size('nader-project-gallery-thumbnail', 300, 400);

        add_theme_support('responsive-embeds');
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'script',
            'style'
        ]);

        add_theme_support('woocommerce');
    }

    public static function initSidebars()
    {
        register_sidebar(array(
            'name'          => 'سایدبار پیشفرض',
            'id'            => 'default_sidebar',
            'before_widget' => '',
            'after_widget'  => "",
        ));
        register_sidebar(array(
            'name'          => 'سایدبار برگه',
            'id'            => 'page_sidebar',
            'before_widget' => '',
            'after_widget'  => "",
        ));
        register_sidebar(array(
            'name'          => 'سایدبار پروژه',
            'id'            => 'project_sidebar',
            'before_widget' => '',
            'after_widget'  => "",
        ));
        register_sidebar(array(
            'name'          => 'سایدبار کارمند',
            'id'            => 'team_sidebar',
            'before_widget' => '',
            'after_widget'  => "",
        ));
        register_sidebar(array(
            'name'          => 'سایدبار آرشیو',
            'id'            => 'archive_sidebar',
            'before_widget' => '',
            'after_widget'  => "",
        ));
        register_sidebar(array(
            'name'          => 'سایدبار فروشگاه',
            'id'            => 'shop_sidebar',
            'before_widget' => '',
            'after_widget'  => "",
        ));
        register_sidebar(array(
            'name'          => 'سایدبار محصول',
            'id'            => 'shop_product',
            'before_widget' => '',
            'after_widget'  => "",
        ));
    }

    public static function registerMenusLocation()
    {
        register_nav_menus([
            'menu_index'   => 'فهرست صفحه اصلی',
            'menu_page'    => 'فهرست برگه',
            'menu_single'  => 'فهرست مطلب',
            'menu_project' => 'فهرست پروژه',
            'menu_team'    => 'فهرست کارمند',
            'menu_product' => 'فهرست محصول',
            'menu_regular' => 'فهرست دیگر صفحات',
        ]);
    }

    public static function projectCustomPostType()
    {
        // Set UI labels for Custom Post Type
        $labels = [
            'name'               => __('Projects', 'nader'),
            'singular_name'      => __('Project', 'nader'),
            'menu_name'          => __('Projects', 'nader'),
            'parent_item_colon'  => __('Project', 'nader'),
            'all_items'          => __('All projects', 'nader'),
            'view_item'          => __('View projects', 'nader'),
            'add_new_item'       => __('Add project', 'nader'),
            'add_new'            => __('Add project', 'nader'),
            'edit_item'          => __('Edit project', 'nader'),
            'update_item'        => __('Update project', 'nader'),
            'search_items'       => __('Search project', 'nader'),
            'not_found'          => __('Not found', 'nader'),
            'not_found_in_trash' => __('Not found in trash', 'nader'),
        ];

        // Set other options for Custom Post Type
        $args = [
            'label'               => __('Projects', 'nader'),
            'description'         => __('View & add project', 'nader'),
            'labels'              => $labels,
            'supports'            => ['title', 'editor', 'thumbnail', 'comments', 'custom-fields',],
            'hierarchical'        => false,
            'show_in_rest'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'rewrite'             => ['slug' => 'project'],
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'menu_icon'           => 'dashicons-schedule',
            'taxonomies'          => ['project_cat', 'project_tag'],
            'capability_type'     => 'page',
            'menu_position'       => 8
        ];

        register_post_type('project', $args);
    }

    public static function projectCustomTaxonomy()
    {
        $labels = [
            'name'          => __('project categories', 'nader'),
            'singular_name' => __('project category', 'nader'),
            'search_items'  => 'جستجوی Projects',
            'all_items'     => __('project categories', 'nader'),
            'edit_item'     => 'ویرایش دسته بندی',
            'update_item'   => 'به روزرسانی دسته بندی',
            'add_new_item'  => 'افزودن دسته بندی',
            'new_item_name' => 'افزودن دسته بندی',
            'menu_name'     => 'دسته ها',
        ];
        $settings = [
            'hierarchical'       => true,
            'labels'             => $labels,
            'show_ui'            => true,
            'query_var'          => true,
            'show_in_rest'       => true, // for show in gutenberg sidebar in post
            'show_in_menu'       => true,
            'show_in_nav_menus'  => true,
            'show_in_quick_edit' => true,
            'show_admin_column'  => true,
            'rewrite'            => ['slug' => 'project_cat'],
        ];
        register_taxonomy('project_cat', ['project'], $settings);


        $labels = [
            'name'          => __('project tags', 'nader'),
            'singular_name' => __('project tag', 'nader'),
            'search_items'  => 'جستجوی Projects',
            'all_items'     => __('project tags', 'nader'),
            'edit_item'     => 'ویرایش برچسب',
            'update_item'   => 'به روزرسانی برچسب',
            'add_new_item'  => 'افزودن برچسب',
            'new_item_name' => 'افزودن برچسب',
            'menu_name'     => 'برچسب ها',
        ];
        $settings = [
            'hierarchical'       => false,
            'labels'             => $labels,
            'show_ui'            => true,
            'query_var'          => true,
            'show_in_rest'       => true, // for show in gutenberg sidebar in post
            'show_in_menu'       => true,
            'show_in_nav_menus'  => true,
            'show_in_quick_edit' => true,
            'show_admin_column'  => true,
            'rewrite'            => ['slug' => 'project_tag'],
        ];
        register_taxonomy('project_tag', ['project'], $settings);
    }

    public static function teamCustomPostType()
    {
        // Set UI labels for Custom Post Type
        $labels = [
            'name'               => __('Teams', 'nader'),
            'singular_name'      => __('Team', 'nader'),
            'menu_name'          => __('Teams', 'nader'),
            'parent_item_colon'  => __('Team', 'nader'),
            'all_items'          => __('All teams', 'nader'),
            'view_item'          => __('View team', 'nader'),
            'add_new_item'       => __('Add team', 'nader'),
            'add_new'            => __('Add team', 'nader'),
            'edit_item'          => __('Edit team', 'nader'),
            'update_item'        => __('Update team', 'nader'),
            'search_items'       => __('Search team', 'nader'),
            'not_found'          => __('Not found', 'nader'),
            'not_found_in_trash' => __('Not found in trash', 'nader'),
        ];

        // Set other options for Custom Post Type
        $args = [
            'label'               => __('Teams', 'nader'),
            'description'         => __('View & add team', 'nader'),
            'labels'              => $labels,
            'supports'            => ['title', 'editor', 'thumbnail', 'custom-fields',],
            'hierarchical'        => false,
            'show_in_rest'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'rewrite'             => ['slug' => 'team'],
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'menu_icon'           => 'dashicons-businessperson',
            'capability_type'     => 'page',
            'menu_position'       => 9
        ];

        register_post_type('team', $args);
    }

    public static function addMenusToChoicesACF($field)
    {
        $field['choices'] = RealPressHelper::getMenus();

        return $field;
    }

    public static function iconAddToCart($icon = 1)
    {
        $output = '';

        switch ($icon) {
            case 1:
                $output = '<svg xmlns="http://www.w3.org/2000/svg" width="18.096" height="18.054" viewBox="0 0 18.096 18.054">
					  <g id="shopping-cart-svgrepo-com_1_" data-name="shopping-cart-svgrepo-com (1)" transform="translate(0 -0.561)">
					    <g id="Group_4" data-name="Group 4" transform="translate(0 0.561)">
					      <path id="Path_9" data-name="Path 9" d="M17.326.561H14.021a.785.785,0,0,0-.73.538l-3.073,9.72H3.649L1.807,5.4H8.722a.77.77,0,0,0,0-1.54H.767a.745.745,0,0,0-.73.962l2.343,6.99a.792.792,0,0,0,.73.5h7.645a.717.717,0,0,0,.73-.5l3.073-9.72h2.767a.766.766,0,1,0,0-1.533Z" transform="translate(0 -0.561)"/>
					      <path id="Path_10" data-name="Path 10" d="M38.981,357.161a2.458,2.458,0,1,0,2.458,2.458A2.474,2.474,0,0,0,38.981,357.161Zm.921,2.494a.922.922,0,1,1-.921-.962A.9.9,0,0,1,39.9,359.655Z" transform="translate(-35.177 -344.022)"/>
					      <path id="Path_11" data-name="Path 11" d="M201.581,357.161a2.458,2.458,0,1,0,2.458,2.458A2.474,2.474,0,0,0,201.581,357.161Zm.925,2.494a.922.922,0,1,1-.921-.962A.9.9,0,0,1,202.505,359.655Z" transform="translate(-191.786 -344.022)"/>
					    </g>
					  </g>
					</svg>';
                break;
            case 2:
                $output = '<svg xmlns="http://www.w3.org/2000/svg" width="18.043" height="18.045" viewBox="0 0 18.043 18.045">
							  <g id="shopping-basket-svgrepo-com" transform="translate(-11.025 -11)">
							    <g id="Group_3" data-name="Group 3" transform="translate(11.025 11)">
							      <path id="Path_5" data-name="Path 5" d="M28.506,17.9a1.924,1.924,0,0,0-1.514-.766H25.663c-.125-3.41-2.6-6.139-5.616-6.139s-5.491,2.729-5.616,6.139H13.1a1.924,1.924,0,0,0-1.514.766,2.735,2.735,0,0,0-.49,2.309l1.595,7.027a2.16,2.16,0,0,0,2,1.8h10.7a2.156,2.156,0,0,0,2-1.8L29,20.214a2.735,2.735,0,0,0-.49-2.309Zm-8.459-5.4c2.195,0,3.992,2.055,4.11,4.636h-8.22C16.055,14.561,17.852,12.5,20.047,12.5Zm7.483,7.376-1.595,7.03c-.081.361-.313.633-.538.633H14.7c-.225,0-.457-.273-.538-.633l-1.595-7.03c-.085-.372-.136-1.237.538-1.237H26.992c.725,0,.622.865.538,1.237Z" transform="translate(-11.025 -11)"/>
							      <path id="Path_6" data-name="Path 6" d="M135.051,259.1a.75.75,0,0,0-.751.751v4.7a.751.751,0,0,0,1.5,0v-4.7A.75.75,0,0,0,135.051,259.1Z" transform="translate(-129.76 -249.963)"/>
							      <path id="Path_7" data-name="Path 7" d="M233.951,259.1a.75.75,0,0,0-.751.751v4.7a.751.751,0,0,0,1.5,0v-4.7A.754.754,0,0,0,233.951,259.1Z" transform="translate(-225.018 -249.963)"/>
							      <path id="Path_8" data-name="Path 8" d="M332.751,259.1a.75.75,0,0,0-.751.751v4.7a.751.751,0,0,0,1.5,0v-4.7A.752.752,0,0,0,332.751,259.1Z" transform="translate(-320.18 -249.963)"/>
							    </g>
							  </g>
							</svg>';
                break;
        }

        return $output;
    }

    public static function selectNavMenu()
    {
        $nav_menu_args = [
            'menu_class'     => 'list-unstyled',
            'menu_id'        => 'nav',
            'container'      => 'ul',
            'walker'         => new NaderMenuWalker(),
            'theme_location' => 'menu_regular'
        ];


        if (!empty(get_post_meta(get_the_ID(), 'select-menu', true))) {
            $nav_menu_args['menu'] = get_post_meta(get_the_ID(), 'select-menu', true);
            $nav_menu_args['theme_location'] = null;
        } elseif (is_singular('post')) {
            $nav_menu_args['theme_location'] = 'menu_single';
        } elseif (is_singular('page') && !is_front_page()) {
            $nav_menu_args['theme_location'] = 'menu_page';
        } elseif (is_singular('project')) {
            $nav_menu_args['theme_location'] = 'menu_project';
        } elseif (is_singular('team')) {
            $nav_menu_args['theme_location'] = 'menu_team';
        } elseif (is_singular('product')) {
            $nav_menu_args['theme_location'] = 'menu_product';
        } elseif (is_home() || is_front_page()) {
            $nav_menu_args['theme_location'] = 'menu_index';
        }

        // ensure menu location is set
        if (empty($nav_menu_args['menu']) && empty($nav_menu_args['theme_location'])) {
            $nav_menu_args['theme_location'] = 'menu_regular';
        }

        return $nav_menu_args;
    }

    public static function breadcrumb()
    {
        ?>
        <div class="nader-breadcrumb dfx wrap aic py-2 px-3 <?php echo is_singular('page') ? 'mb-3' : 'mb-5'; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path opacity=".4"
                      d="M20.621 8.45c-1.05-4.62-5.08-6.7-8.62-6.7h-.01c-3.53 0-7.57 2.07-8.62 6.69-1.17 5.16 1.99 9.53 4.85 12.28a5.436 5.436 0 0 0 3.78 1.53c1.36 0 2.72-.51 3.77-1.53 2.86-2.75 6.02-7.11 4.85-12.27Z"></path>
                <path d="M12.002 13.46a3.15 3.15 0 1 0 0-6.3 3.15 3.15 0 0 0 0 6.3Z"></path>
            </svg>
            <?php get_template_part('parts/global/breadcrumb'); ?>
        </div>
        <?php
    }

    public static function loader()
    {
        get_template_part('parts/global/loader');
    }

    public static function overlayBox()
    {
        echo '<div class="overlay-box"></div>';
    }

    public static function mouseCursor()
    {
        $mouse_cursor = apply_filters('nader_mouse_cursor_enable', get_field('mouse-cursor-enable', 'options'));
        if ($mouse_cursor) {
            echo '<span class="mouse-cursor cursor_outer"></span><span class="mouse-cursor cursor_inner"></span>';
        }
    }

    public static function searchBtn()
    {
        if (!ACF_ENABLED) {
            return;
        }

        $enable = get_field('search-btn-enable', 'options');
        if (!$enable) {
            return;
        }
        get_template_part('parts/search/search', 'btn');
    }

    public static function searchBox()
    {
        get_template_part('parts/search/search');
    }

    public static function refactorExcerptMore($more)
    {
        return '...';
    }

    public static function printDynamicColor()
    {
        require_once 'NaderColors.php';
    }

    public static function postThumbnail($size = 'medium_large')
    {
        if (has_post_thumbnail()) {
            the_post_thumbnail($size);
        } else {
            echo '<img src="' . NADER_IMG_DIR . 'default-thumb.jpg' . '" alt="' . get_the_title() . '">';
        }
    }

    public static function ajaxLoginRegister()
    {
        add_action('acf/init', function() {

            if (is_user_logged_in()) {
                return;
            }

            // corner button
            if (get_field('ajax-login-enable', 'options') && get_field('ajax-login-btn-enable', 'options')) {
                add_action('wp_footer', function() {
                    get_template_part('parts/login/login', 'btn');
                }, 6);
            }

            // popup & functionality
            if (get_field('ajax-login-enable', 'options')) {
                require_once NADER_PATH . 'parts/login/function.php';
            }
        });
    }

    public static function copiedNotification()
    {
        echo '<p class="ctc-notif">' . __('Copied to clipboard', 'nader') . '</p>';
    }

    /**
     * @param $nonces
     * @return array
     * Fix ajax conflict with litespeed cache
     */
    public static function addNoncesToLSC($nonces)
    {
        $nader_nonces = ['nader_ajax_register_nonce', 'nader_ajax_login_nonce'];
        return array_merge($nonces, $nader_nonces);
    }

    public static function addCommentFormBeforeFields()
    {
        echo '<div class="row">';
    }

    public static function addCommentFormAfterFields()
    {
        echo '</div>';
    }

}

NaderUtils::init();
