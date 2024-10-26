<?php
defined('ABSPATH') || die();

class WP_ACTIVE_WE_DT_First_Category extends \Elementor\Core\DynamicTags\Tag{

    public function get_name()
    {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title()
    {
        return 'اولین دسته بندی';
    }

    public function get_group()
    {
        return 'wp-active-we-dynamic-tags';
    }

    public function get_categories()
    {
        return [\Elementor\Modules\DynamicTags\Module::URL_CATEGORY, \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY, \Elementor\Modules\DynamicTags\Module::BASE_GROUP];
    }

    protected function register_controls()
    {
        AE_E_UTILS::SELECT_FIELD($this, 'taxonomy', 'تکسونومی', AE_E_FUNCTIONS::getRegisteredTaxonomies(), 'category');
        AE_E_UTILS::SWITCH_FIELD($this, 'link', 'پیوند');
    }

    public function render()
    {

        $settings = $this->get_settings();
        $terms = get_the_terms(get_the_ID(), $settings['taxonomy']);
        if (is_wp_error($terms) || empty($terms)) {
            return '';
        }

        if ('yes' === $settings['link']) {
            $value = '<a href="' . esc_url(get_term_link($terms[0]->term_id)) . '" title="' . $terms[0]->name . '">' . $terms[0]->name . '</a>';
        } else {
            $value = '<span>' . $terms[0]->name . '</span>';
        }

        echo wp_kses_post($value);

    }
}
