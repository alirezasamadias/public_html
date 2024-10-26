<?php
defined('ABSPATH') || die();

Class WP_ACTIVE_WE_DT_Comments_Counter extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return str_replace('Elementor\\', '', __CLASS__);
    }

    public function get_title() {
        return 'شمارنده دیدگاه';
    }

    public function get_group() {
        return 'wp-active-we-dynamic-tags';
    }

    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY, \Elementor\Modules\DynamicTags\Module::BASE_GROUP ];
    }

    public function render() {

        $cmn = get_comments_number();

        if ($cmn == 0) {
            _e('no comments', 'wp-active-we-dynamic-tags');
        } elseif ($cmn == 1) {
            _e('one comment', 'wp-active-we-dynamic-tags');
        } else {
            echo __('comments', 'wp-active-we-dynamic-tags');
        }

    }
}
