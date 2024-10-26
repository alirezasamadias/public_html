<?php
defined('ABSPATH') || die();

Class ViunaTagStarter extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title() {
        return '';
    }

    public function get_group() {
        return 'viuna-dynamic-tags';
    }

    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::URL_CATEGORY, \Elementor\Modules\DynamicTags\Module::BASE_GROUP ];
    }

    protected function register_controls()
    {

    }

    public function render() {

    }
}
