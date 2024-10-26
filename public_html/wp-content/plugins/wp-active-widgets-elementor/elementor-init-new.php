<?php

use Elementor\Plugin;
use Elementor\Controls_Manager;

defined('ABSPATH') || exit;
define('AE_E_PLUGIN_NAME', 'WP_ACTIVE_WE');
define('AE_E_PATH', trailingslashit(plugin_dir_path(__FILE__)));
define('AE_E_IMG_DIR', trailingslashit(plugin_dir_url(__FILE__)) . 'assets/img/');
define('AE_E_JS_DIR', trailingslashit(plugin_dir_url(__FILE__)) . 'assets/js/');
define('AE_E_CSS_DIR', trailingslashit(plugin_dir_url(__FILE__)) . 'assets/css/widgets/');
define('AE_E_FONT_DIR', trailingslashit(plugin_dir_url(__FILE__)) . 'assets/fonts/');
define('AE_E_LIB_DIR', trailingslashit(plugin_dir_url(__FILE__)) . 'assets/library/');


final class WpActiveWidgetsElementor{

    protected static $instance = null;

    public static function get_instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
            self::$instance->init();
        }
        return self::$instance;
    }

    public function init()
    {

        add_action('elementor/init', array($this, 'files_include'), 20);
        add_action('elementor/widgets/register', array($this, 'register_widgets'));
        add_action('elementor/controls/register', array($this, 'register_controls'));
        add_action('elementor/dynamic_tags/register', array($this, 'register_tags'));
        add_action('elementor/elements/categories_registered', array($this, 'add_widget_categories'));
        add_filter('elementor/fonts/additional_fonts', [$this, 'add_fonts']);
        add_filter('elementor/fonts/groups', [$this, 'add_fonts_groups']);

        add_action('elementor/editor/after_enqueue_styles', [$this, 'dashboardStyle']);
        add_action('elementor/frontend/before_enqueue_styles', [$this, 'before_enqueue_elementor_styles']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);

        add_action('wp_ajax_wp_active_we_build_query', [$this, 'ajax_query_builder']);
        add_action('wp_ajax_nopriv_wp_active_we_build_query', [$this, 'ajax_query_builder']);


        add_action( 'wp_ajax_wp_active_we_get_posts_by_query', 'AE_E_FUNCTIONS::getPostsByQuery' );
        add_action( 'wp_ajax_nopriv_wp_active_we_get_posts_by_query', 'AE_E_FUNCTIONS::getPostsByQuery' );

        add_action( 'wp_ajax_wp_active_we_get_posts_title_by_id', 'AE_E_FUNCTIONS::getPostsTitleById' );
        add_action( 'wp_ajax_nopriv_wp_active_we_get_posts_title_by_id', 'AE_E_FUNCTIONS::getPostsTitleById' );

        add_action( 'wp_ajax_wp_active_we_get_taxonomies_title_by_id', 'AE_E_FUNCTIONS::getTaxonomiesTitleById' );
        add_action( 'wp_ajax_nopriv_wp_active_we_get_taxonomies_title_by_id', 'AE_E_FUNCTIONS::getTaxonomiesTitleById' );

        add_action( 'wp_ajax_wp_active_we_get_taxonomies_by_query', 'AE_E_FUNCTIONS::getTaxonomiesByQuery' );
        add_action( 'wp_ajax_nopriv_wp_active_we_get_taxonomies_by_query', 'AE_E_FUNCTIONS::getTaxonomiesByQuery' );
    }


    public function register_widgets()
    {
        // widgets
        require_once('widgets/TitleWithButton1.php');
        require_once('widgets/Title2Image.php');
        require_once('widgets/TitleDoubleText.php');
        require_once('widgets/TitleWithSmoothBG.php');
        require_once('widgets/LinearIconBox.php');
        require_once('widgets/FancyButton.php');
        require_once('widgets/ButtonSwitcher.php');
        require_once('widgets/DoubleFancyButton.php');
        require_once('widgets/IconButton.php');
        require_once('widgets/IconWithText.php');
        require_once('widgets/FantasyDot.php');
        require_once('widgets/SectionSeparator.php');
        require_once('widgets/FantasyLineSeparator.php');
        require_once('widgets/PostsSlider1.php');
        require_once('widgets/PostsSlider2.php');
        require_once('widgets/PostsSlider3.php');
        require_once('widgets/PostsSlider4.php');
        require_once('widgets/PostsMasonry1.php');
        require_once('widgets/PostsMasonry2.php');
        require_once('widgets/PostsGrid1.php');
        require_once('widgets/PostsGrid2.php');
        require_once('widgets/PostsColumn.php');
        require_once('widgets/ProjectsMasonry1.php');
        require_once('widgets/ProjectsGallery2.php');
        require_once('widgets/ProjectsGallery3.php');
        require_once('widgets/ProjectsGallery4.php');
        require_once('widgets/ProjectsGallery5.php');
        require_once('widgets/ProjectsGallery6.php');

        if (function_exists('WC')) {
            require_once('widgets/ProductsGrid.php');
            require_once('widgets/ProductsGrid2.php');
        }

        // if the site has at list 1 menu
        if (wp_get_nav_menus()) {
            require_once('widgets/VerticalMenu.php');
        }
        require_once('widgets/ThumbSlider.php');
        require_once('widgets/InfiniteCssImageSlider.php');
        require_once('widgets/FeaturedBoxes.php');
        require_once('widgets/FeatureListBox.php');
        require_once('widgets/TabsWithImage.php');
        require_once('widgets/Testimonials1.php');
        require_once('widgets/Testimonials2.php');
        require_once('widgets/Testimonials3.php');
        require_once('widgets/Team1.php');
        require_once('widgets/Box3Text.php');
        require_once('widgets/IconBox.php');
        require_once('widgets/Timeline1.php');
        require_once('widgets/Timeline2.php');
        require_once('widgets/CategoryList.php');
        require_once('widgets/PriceBox1.php');
        require_once('widgets/SharePopup.php');
        require_once('widgets/DropdownMenuOneColumn.php');
        require_once('widgets/TeamSlider1.php');
        require_once('widgets/VerticalDivider.php');

        require_once('widgets/Archive1.php');
    }

    public function register_controls(Controls_Manager $controls_manager)
    {
        $controls_manager->register(new Autocomplete());
    }

    public function register_tags($dynamic_tags)
    {
        Plugin::$instance->dynamic_tags->register_group('wp-active-we-dynamic-tags', [
            'title' => 'داینامیک تگ های اختصاصی'
        ]);
        $dynamic_tags->register(new WP_ACTIVE_WE_DT_Comments_Counter());
        $dynamic_tags->register(new WP_ACTIVE_WE_DT_First_Category());
    }

    public function add_widget_categories($elements_manager)
    {
        $elements_manager->add_category('WP_ACTIVE_WE', ['title' => 'ویجت های اختصاصی']);
    }

    public function files_include()
    {
        require_once('includes/functions.php');
        require_once('controls/auto-complete.php');
        require_once('includes/AE_E_UTILS.php');
        require_once('includes/WP_ACTIVE_WE_QueryBuilder.php');
        require_once('includes/WP_ACTIVE_WE_OwlCarousel.php');
        require_once('includes/WP_ACTIVE_WE_QueryFilters.php');

        // dynamic tags
        require_once 'dynamic-tags/CommentsCounter.php';
        require_once 'dynamic-tags/FirstCategory.php';
    }

    public function add_fonts($additional_fonts)
    {
        $additional_fonts['IRANYekan'] = 'WP_ACTIVE_WE';
        $additional_fonts['IranSans'] = 'WP_ACTIVE_WE';
        $additional_fonts['Morabba'] = 'WP_ACTIVE_WE';
        $additional_fonts['Dana'] = 'WP_ACTIVE_WE';
        $additional_fonts['Emkan'] = 'WP_ACTIVE_WE';

        return $additional_fonts;
    }

    public function add_fonts_groups($font_groups)
    {
        $font_groups['WP_ACTIVE_WE'] = 'افزونه اختصاصی وردپرس اکتیو';
        return $font_groups;
    }

    public function dashboardStyle()
    {
        wp_enqueue_style('wp-active-widgets-elementor-editor-style', AE_E_CSS_DIR . '../elementor.css');
    }

    public function before_enqueue_elementor_styles()
    {
        wp_enqueue_style('WP_ACTIVE_WE_FONTS', AE_E_FONT_DIR . 'fonts.css');
    }

    public function enqueue_scripts($hook_suffix)
    {
        // STYLES
        wp_register_style('owl-css', AE_E_LIB_DIR . 'owl-carousel/assets/owl.carousel.min.css');
        wp_register_style('owl-theme-default', AE_E_LIB_DIR . 'owl-carousel/assets/owl.theme.default.min.css');
        wp_enqueue_style('wp-active-we-general-styles', AE_E_CSS_DIR . '../general.css');


        // SCRIPTS
        wp_enqueue_script('wp-active-we-general-scripts', AE_E_JS_DIR . 'general.js', ['jquery'], '2.3.0', true);
        wp_register_script('wp-active-we-intro-animation', AE_E_JS_DIR . 'intro-animation.js', [
            'jquery',
            'wp-active-we-general-scripts'
        ], null, true);
        wp_register_script('owl-js', AE_E_LIB_DIR . 'owl-carousel/owl.carousel.min.js', ['jquery'], '1.0.0', true);
        wp_register_script('wp-active-we-owl-slider', AE_E_JS_DIR . 'owl-slider.js', [
            'jquery',
            'owl-js'
        ], '1.0.0', true);
        wp_register_script('wp-active-we-projects-gallery-filter', AE_E_JS_DIR . 'projects-gallery-filter.js', ['jquery'], '1.0.0', true);
        wp_register_script('wp-active-we-gallery-in-loop', AE_E_JS_DIR . 'gallery-in-loop.js', ['jquery'], '1.0.0', true);


        wp_enqueue_script('wp-active-we-ajax-query-builder', AE_E_JS_DIR . 'ajax-query-builder.js', ['jquery'], null, true);
        wp_localize_script('wp-active-we-ajax-query-builder', 'WP_ACTIVE_WE_AJAX_QUERY_BUILDER_OBJECT', [
            'ajaxUrl'                  => admin_url('admin-ajax.php'),
            'ajax_query_builder_nonce' => wp_create_nonce('wp-active-we-ajax-query-builder')
        ]);
    }

    public function ajax_query_builder()
    {
        check_ajax_referer('wp-active-we-ajax-query-builder', 'nonce');
        $data = [];

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($_POST['args']) || !is_array($_POST['args'])) {
            $data['status'] = false;
            $data['msg'] = __('Invalid query request', 'wp-active-widgets-elementor');
            wp_send_json_error($data);
        }

        $query = new WP_Query($_POST['args']);
        if (!$query->have_posts()) {
            $data['status'] = true;
            $data['query'] = false;
            $data['msg'] = !empty($_POST['args']['no_post_found']) ? $_POST['args']['no_post_found'] : __('No article found!', 'wp-active-widgets-elementor');
        } else {

            $filter = !empty($_POST['postData']['filter']) ? $_POST['postData']['filter'] : false;

            $stack = [];
            $i = 0;
            $counter = isset($_POST['postData']['counter']) ? $_POST['postData']['counter'] : false;
            if (!empty($counter)) {
                $i = (int)$counter['start'];
            }

            while ($query->have_posts()) {
                $query->the_post();
                $id = get_the_ID();
                $first_category = AE_E_FUNCTIONS::getPostFirstCategory($id, $filter['taxonomy']);


                $post = [
                    'id'      => $id,
                    'wid'     => $_POST['postData']['wid'],
                    'title'   => get_the_title(),
                    'link'    => get_the_permalink(),
                    'excerpt' => get_the_excerpt(),
                    'author'  => get_the_author_meta('display_name'),
                    'comment' => get_comments_number_text(),
                    'view'    => (int)get_post_meta(get_the_ID(), 'views', true),
                    'date'    => [
                        'd'    => get_the_date('d'),
                        'M'    => get_the_date('M'),
                        'Y'    => get_the_date('Y'),
                        'd_m'  => get_the_date('d M'),
                        'full' => get_the_date(get_option('date_format')),
                    ]
                ];


                /**
                 * create class of terms, for project filter
                 */
                $classes = [];
                if (!empty($filter['enable'])) {
                    $terms = get_the_terms($id, $filter['taxonomy']);
                    if (!empty($terms)) {
                        foreach ($terms as $term) {
                            $classes[] = $filter['taxonomy'] . '-' . $term->term_id;
                        }
                    }
                }


                /**
                 * post class
                 */
                if (!empty($counter)) {
                    $post['post_class'] = implode(' ', array_merge($classes, get_post_class([
                        esc_attr($_POST['postData']['post_class']),
                        $counter['pseudo'] . $i
                    ])));
                } else {
                    $post['post_class'] = implode(' ', array_merge($classes, get_post_class(esc_attr($_POST['postData']['post_class']))));
                }


                /**
                 * thumbnail
                 */
                if (has_post_thumbnail()) {
                    $post['thumbnail_url_full'] = get_the_post_thumbnail_url($id, 'full');
                    $post['thumbnail'] = get_the_post_thumbnail($id, $_POST['postData']['image_size'], ['class' => $_POST['postData']['image_class']]);
                } else {
                    $post['thumbnail_url_full'] = AE_E_IMG_DIR . 'placeholder-1.svg';
                    $post['thumbnail'] = '<img src="' . AE_E_IMG_DIR . 'placeholder-1.svg' . '" alt="' . get_the_title() . '" class="' . $_POST['postData']['image_class'] . '">';
                }


                /**
                 * first category
                 */
                if ($first_category) {
                    $post['first_category'] = [
                        'name' => $first_category->name,
                        'link' => get_term_link($first_category->term_id)
                    ];
                }


                /**
                 * price
                 */
                if ($_POST['args']['post_type'] === 'product' && function_exists('WC')) {
                    $post['price'] = AE_E_FUNCTIONS::getPrice(wc_get_product($id));
                }


                /**
                 * view
                 */
                if (AE_E_FUNCTIONS::isActiveViews()) {
                    $post['view'] = AE_E_FUNCTIONS::getPostViews();
                }


                /**
                 * gallery in loop
                 */
                if (!empty($_POST['postData']['gallery_in_loop']) && wp_validate_boolean($_POST['postData']['gallery_in_loop']) === true) {
                    $post['gallery_in_loop'] = AE_E_FUNCTIONS::galleryInLoop($id, $_POST['postData']['image_size']);
                }


                /**
                 * custom fields
                 */
                if (!empty($_POST['postData']['custom_fields'])) {
                    $cf_output = $_POST['postData']['custom_fields']['wrapper']['start'];
                    $fields = $_POST['postData']['custom_fields']['items'];
                    foreach ($fields as $field) {
                        $value = get_post_meta($id, $field['key'], true);
                        if (!empty($value)) {
                            $cf_output .= str_replace('{custom_field_value}', $value, $field['template']);
                        }
                    }
                    $cf_output .= $_POST['postData']['custom_fields']['wrapper']['end'];
                    $post['custom_fields'] = $cf_output;
                }


                $stack[] = $post;
                $i++;
            }


            /**
             * Render filters
             */
            if (!empty($filter['enable'])) {
                $filters = AE_E_FUNCTIONS::extractQueryTerms($query, $filter['taxonomy']);
                if (!empty($filters)) {
                    $data['filters'] = $filters;
                }
            }

            $data['status'] = true;
            $data['query'] = true;
            $data['posts'] = $stack;
        }

        wp_reset_postdata();
        wp_send_json_success($data);
    }


}


WpActiveWidgetsElementor::get_instance();

add_filter('elementor/theme/conditions/cache/regenerate/query_args', function($query_args) {
    if (class_exists('SitePress')) {
        $query_args['suppress_filters'] = true;
    }
    return $query_args;
});
