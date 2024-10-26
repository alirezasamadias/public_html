<?php
defined('ABSPATH') || exit;

class AeCommentFormAjax{

    public function __construct()
    {

        add_action('wp_enqueue_scripts', [$this, 'enqueue']);

        add_action('wp_ajax_ae_comment_form_ajax', [$this, 'ajax']);
        add_action('wp_ajax_nopriv_ae_comment_form_ajax', [$this, 'ajax']);
        add_action('wp_ajax_ae_comment_form_ajax_list', [$this, 'comments_list']);
        add_action('wp_ajax_nopriv_ae_comment_form_ajax_list', [$this, 'comments_list']);

    }

    public function enqueue()
    {
        wp_enqueue_style('ae-comment-form-ajax', trailingslashit(get_stylesheet_directory_uri()) . 'parts/comment-form-ajax/assets/style.min.css');
        wp_enqueue_script('ae-comment-form-ajax', trailingslashit(get_stylesheet_directory_uri()) . 'parts/comment-form-ajax/assets/script.js', ['jquery'], null, true);
        wp_localize_script('ae-comment-form-ajax', 'aeCommentFormAjaxOBJ', [
            'ajaxUrl'                  => admin_url('admin-ajax.php'),
            'nonce'                    => wp_create_nonce('ae_comment_form_ajax'),
            'msg_processing'           => apply_filters('ae_comment_form_ajax_processing_message', __('Please wait...','nader')),
            'msg_duplicate'            => apply_filters('ae_comment_form_ajax_duplicate_message', __('Duplicate comment error!','nader')),
            'msg_error_server_respond' => apply_filters('ae_comment_form_ajax_error_server_respond', __('Error: Server doesn\'t respond.','nader')),
            'msg_error_500'            => apply_filters('ae_comment_form_ajax_error_500', __('Error while adding comment','nader')),
            'msg_empty_textarea'       => apply_filters('ae_comment_form_ajax_empty_textarea', __('Please write something','nader')),
            'msg_replay'               => apply_filters('ae_comment_form_ajax_replay', __('Reply to this comment','nader')),
            'comments_section'         => '#comments.comments-area',
            'respond_section'          => '#comments .comment-respond',
            'form'                     => '#comment-form',
            'replay_btn'               => '.comment-reply-link',
            'cancel_btn'               => '<span class="cancel-replay">'.__('Cancel','nader').'</span>',
        ]);
    }


    public function ajax()
    {
        $commentPublic = wp_handle_comment_submission(wp_unslash($_POST));
        if (is_wp_error($commentPublic)) {
            $error_data = intval($commentPublic->get_error_data());
            if (!empty($error_data)) {
                wp_send_json_error([
                    'message' => apply_filters('ae_comment_form_ajax_error_message', $error_data)
                ]);
            } else {
                wp_send_json_error([
                    'message' => apply_filters('ae_comment_form_ajax_error_message_unknown', __('Unknown error','nader'))
                ]);
            }
        }

        $user = wp_get_current_user();
        do_action('set_comment_cookies', $commentPublic, $user);

        wp_send_json_success([
            'message' => apply_filters('ae_comment_form_ajax_success_message', __('Your comment has been sent.','nader')),
        ]);

    }

    public function comments_list()
    {

        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'ae_comment_form_ajax')) {
            wp_send_json_error([
                'message' => __('Failed security check.','nader'),
            ]);
        }

        $p_id = absint($_POST['post_id']);
        if (empty($p_id) || !is_numeric($p_id)) {
            wp_send_json_error([
                'message' => __('Invalid post ID.','nader'),
            ]);
        }
        $p_id = absint($p_id);

        ob_start();
        query_posts(array('p' => $p_id));
        if (have_posts()) {
            the_post();

            ?>
            <div class="comment-list">
                <div class="comment-title">
                    <?php echo apply_filters('nader_comments_list_title', '<h4>' . sprintf(__('%d Comments', 'nader'), get_comments_number()) . '</h4>'); ?>
                </div>
                <?php

                echo '<ul>';
                comments_template('/comment-form-ajax/comment-list.php');
                echo '</ul>';
                ?>
            </div>
            <?php

        }
        $comments = ob_get_clean();
        wp_reset_query();


        wp_send_json_success([
            'comments' => $comments,
        ]);
    }


}

$comments_form_ajax = new AeCommentFormAjax();

