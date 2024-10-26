<?php
defined('ABSPATH') || die();

define('PLUGIN_NAME', 'NADER');
define('PLUGIN_NAME_FA', 'نــادر');

class Nader_Elementor_Widgets{

    protected static $instance = null;

    public static function get_instance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    protected function __construct()
    {

        //helper class
        require_once('includes/RP_Utils.php');
        require_once(get_stylesheet_directory() . '/inc/RealPressHelper.php');
        require_once('includes/WP_QUERY_TRAIT.php');
        require_once('includes/OwlCarousel.php');
        require_once('includes/BUTTON_TRAIT.php');
        require_once('includes/IMAGE_EFFECT.php');


        require_once('widgets/NaderTitle.php');
        require_once('widgets/NaderAnimatedTitle.php');
        require_once('widgets/NaderButton.php');
        require_once('widgets/NaderCounter.php');
        require_once('widgets/NaderCircleProgress.php');
        require_once('widgets/NaderLinearProgress.php');
        require_once('widgets/NaderAccordion.php');
        require_once('widgets/NaderTabs.php');
        require_once('widgets/NaderResume.php');
        require_once('widgets/NaderInfoBox.php');
        require_once('widgets/NaderServiceBox.php');
        require_once('widgets/NaderServicesSlider.php');
        require_once('widgets/NaderBlogPosts.php');
        require_once('widgets/NaderBlogPostsSlider.php');
        require_once('widgets/NaderProjects.php');
        require_once('widgets/NaderCommentsSlider.php');
        require_once('widgets/NaderCommentsSlider2.php');
        require_once('widgets/NaderPriceTable.php');
        require_once('widgets/NaderTeamMember.php');
        require_once('widgets/NaderFloatingMenu.php');
        require_once('widgets/Nader3Image.php');
        require_once('widgets/Nader2Image.php');
        require_once('widgets/NaderNavigation.php');
        require_once('widgets/NaderMobileNavigation.php');
        require_once('widgets/NaderBreadcrumb.php');
        require_once('widgets/NaderBanner.php');
        require_once('widgets/NaderSearchOpener.php');


        if (function_exists('WC')) {
            require_once('widgets/NaderMiniCartOpener.php');
        }

        require_once('widgets/single/NaderComments.php');
        require_once('widgets/single/NaderSingleShare.php');
        require_once('widgets/single/NaderSingleTags.php');
        require_once('widgets/single/NaderSingleFontSizeChanger.php');
        require_once('widgets/single/NaderSingleProjectGallery.php');
        require_once('widgets/single/NaderSingleWishlistBtn.php');
        require_once('widgets/single/NaderSingleTeamSocialPages.php');
        require_once('widgets/single/NaderSingleTeamMemberInfo.php');


        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);

        add_action('elementor/editor/after_enqueue_styles', [$this, 'dashboard_style']);

    }

    public function dashboard_style()
    {
        wp_enqueue_style('nader-elementor-editor-style', get_stylesheet_directory_uri() . '/elementor/assets/style.css');
    }

}

function naderCheckElementorLoaded()
{

    if (!function_exists('is_plugin_active')) {
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    if (is_plugin_active('elementor/elementor.php')) {
        function create_custom_categories($elements_manager)
        {
            $elements_manager->add_category(PLUGIN_NAME, ['title' => PLUGIN_NAME_FA]);
        }

        add_action('elementor/elements/categories_registered', 'create_custom_categories');
        add_action('init', 'Nader_Elementor_Widgets::get_instance');
    }

}

naderCheckElementorLoaded();
