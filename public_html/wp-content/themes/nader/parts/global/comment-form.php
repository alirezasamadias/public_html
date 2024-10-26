<?php

defined('ABSPATH') || die();

$submit_svg_icon = '';
if (is_rtl()) {
    $submit_svg_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M7.828 11H20v2H7.828l5.364 5.364-1.414 1.414L4 12l7.778-7.778 1.414 1.414z"/></svg>';
} else {
    $submit_svg_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg>';
}

$cm_args = [
    'id_form' => 'comment-form',
    'class_form' => 'custom-input',
    'title_reply' => __('Give your opinion', 'nader'),
    'title_reply_before' => '<div class="comment-title"><h4>',
    'title_reply_after' => '</h4></div>',
    'fields' => [
        'author' => '<div class="col-sm-6"><div class="mb-4"><input type="text" name="author" class="form-control" placeholder="' . __('name', 'nader') . ' *"  aria-required="true" required></div></div>',
        'email' => '<div class="col-sm-6"><div class="mb-4"><input type="email" name="email" class="form-control" placeholder="' . __('email', 'nader') . ' *"  aria-required="true" required></div></div>',
        'cookies' => '<div class="col-md-12 cookies"><div class="form-group"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"><label for="wp-comment-cookies-consent">' . __('Save my name, email and website in the browser for when I write a comment again.', 'nader') . '</label></div></div>',
    ],
    'comment_field' => '<div class="row"><div class="col-sm-12"><div class="mb-4"><textarea id="comment" name="comment" aria-required="true" class="form-control" rows="6" placeholder="' . __('The text of your comment', 'nader') . ' *" required></textarea></div></div></div>',
    'submit_field' => '<div class="submit-form">%1$s %2$s</div>',
    'submit_button' => '<button id="%2$s" class="send-comment-btn d-flex align-items-center gap-2 %3$s">%4$s '
        . $submit_svg_icon . '</button>',
    'label_submit' => __('Send Comment', 'nader'),
];

comment_form($cm_args);
