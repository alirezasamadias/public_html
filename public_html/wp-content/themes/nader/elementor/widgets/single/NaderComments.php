<?php

namespace Elementor;

use RP_Utils;

defined('ABSPATH') || die();

class NaderComments extends Widget_Base
{

    public function get_name()
    {
        return 'NaderComments';
    }

    public function get_title()
    {
        return PLUGIN_NAME_FA . ' : نظرات نوشته';
    }

    public function get_icon()
    {
        return 'nader-widget eicon-comments';
    }

    public function get_categories()
    {
        return [PLUGIN_NAME];
    }

    protected function register_controls()
    {

        RP_Utils::SECTION_START($this, 'cm-general', 'عمومی');
        RP_Utils::TextUtils($this, 'cm-general-text', '.comment-respond');

        RP_Utils::Separator($this, 'cm-general-link', 'لینک');
        RP_Utils::TextUtils($this, 'cm-general-link', '.comment-respond a',true);

        RP_Utils::SECTION_END($this);



        // box list title
        RP_Utils::SECTION_START($this, 'cm-list-box-title', 'عنوان باکس لیست نظرات');
        RP_Utils::TextUtils($this, 'cm-list-box-title', '.comment-list .comment-title h4');
        $comment_title = [
            'background',
            'margin',
            'padding',
            'border',
            'radius',
            'shadow'
        ];
        RP_Utils::DynamicStyleControls($this, 'cm-list-box-title', '.comments-area .comment-title', $comment_title);
        RP_Utils::SECTION_END($this);


        // comment box
        RP_Utils::SECTION_START($this,'cm-box', 'باکس هر کامنت');
        $cm_box = [
            'bg',
            'padding',
            'margin',
            'border',
            'radius',
            'shadow'
        ];
        RP_Utils::DynamicStyleControls($this, 'cm-box', '.comments-area ul li', $cm_box);
        RP_Utils::SECTION_END($this);


        // comment details
        RP_Utils::SECTION_START($this, 'cm-details', 'جزئیات دیدگاه');
        RP_Utils::Separator($this, 'cm-author', 'نویسنده');
        RP_Utils::TextUtils($this, 'cm-author', '.comments-area ul li .author-cm b');

        RP_Utils::Separator($this, 'cm-date-time', 'تاریخ و ساعت');
        RP_Utils::TextUtils($this, 'cm-date-time', '.comments-area ul li h6');

        RP_Utils::Separator($this, 'cm-text', 'متن');
        RP_Utils::TextUtils($this, 'cm-text', '.comments-area ul li p');

        RP_Utils::SECTION_END($this);


        // edit btn
        RP_Utils::SECTION_START($this, 'cm-btn-edit', 'دکمه ویرایش');
        RP_Utils::ButtonUtils($this, 'cm-btn-edit', '.comments-area ul li .author-cm-controls a.comment-edit-link');
        RP_Utils::SECTION_END($this);


        // reply btn
        RP_Utils::SECTION_START($this, 'cm-btn-reply', 'دکمه پاسخ');
        RP_Utils::ButtonUtils($this, 'cm-btn-reply', '.comments-area ul li .author-cm-controls a.comment-reply-link');
        RP_Utils::SECTION_END($this);



        /**
         * Comment Form
         */
        // box form comment title
        RP_Utils::SECTION_START($this, 'cm-form-box-title', 'عنوان باکس فرم');
        RP_Utils::TextUtils($this, 'cm-form-box-title', '.comment-respond .comment-title h4');
        $comment_title = [
            'background',
            'margin',
            'padding',
            'border',
            'radius',
            'shadow'
        ];
        RP_Utils::DynamicStyleControls($this, 'cm-form-box-title', '.comment-respond .comment-title', $comment_title);
        RP_Utils::SECTION_END($this);



        // Comment From Fields
        RP_Utils::SECTION_START($this, 'cm-form-fields', 'فیلدهای فرم');
        RP_Utils::FONT_FIELD($this,'cm-form-fields-font', 'تایپوگرافی', '.comment-respond input, {{WRAPPER}} .comment-respond textarea');
        $comment_fields = [
            'background',
            'padding',
            'border',
            'radius',
            'shadow'
        ];
        RP_Utils::TAB_START($this, 'cm-form-fields');
        RP_Utils::DynamicStyleControls($this, 'cm-form-fields', '.comment-respond input, {{WRAPPER}} .comment-respond textarea', $comment_fields);
        RP_Utils::TAB_MIDDLE($this, 'cm-form-fields', true);
        RP_Utils::DynamicStyleControls($this, 'cm-form-fields-focus', '.comment-respond input:focus, {{WRAPPER}} .comment-respond textarea:focus', $comment_fields);
        RP_Utils::TAB_END($this);
        RP_Utils::SECTION_END($this);



        // Comment From Send Button
        RP_Utils::SECTION_START($this, 'cm-btn-send', 'دکمه ارسال دیدگاه');
        RP_Utils::FONT_FIELD($this, 'cm-btn-send-font', 'فونت', '.send-comment-btn');
        RP_Utils::DIMENSIONS_FIELD($this, 'cm-btn-send_padding', 'فاصله درونی', '.send-comment-btn', 'padding');

        //tab ->start
        RP_Utils::TAB_START($this, 'cm-btn-send');
        RP_Utils::COLOR_FIELD($this, 'cm-btn-send-color-normal', 'رنگ متن', '', '.send-comment-btn', 'color');
        RP_Utils::COLOR_FIELD($this, 'cm-btn-send-icon-color-normal', 'رنگ آیکون', '', '.send-comment-btn svg', 'fill');

        //tab ->middle
        RP_Utils::TAB_MIDDLE($this, 'cm-btn-hover');
        RP_Utils::COLOR_FIELD($this, 'cm-btn-send-color-hover', 'رنگ متن', '', '.send-comment-btn:hover', 'color');
        RP_Utils::COLOR_FIELD($this, 'cm-btn-send-icon-color-hover', 'رنگ آیکون', '', '.send-comment-btn:hover svg', 'fill');

        RP_Utils::TAB_END($this);
        RP_Utils::SECTION_END($this);

    }

    protected function render()
    {
        if (comments_open()) {
            comments_template();
        }
    }
}

Plugin::instance()->widgets_manager->register(new NaderComments());
