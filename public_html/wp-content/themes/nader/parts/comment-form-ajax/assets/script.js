(function ($) {
    'use strict';
    $(document).ready(function () {

        let CAN_AJX = true
        const cloned_form = $(aeCommentFormAjaxOBJ.respond_section).clone()
        const cloned_form_respond = $(aeCommentFormAjaxOBJ.respond_section).clone()
        const form = aeCommentFormAjaxOBJ.form
        if (!$('.ae-comment-form-ajax-notification').length) {
            $('body').append('<div class="ae-comment-form-ajax-notification"></div>')
        }
        const notif_box = $('.ae-comment-form-ajax-notification')

        $(document).on('submit', form, function (e) {
            e.preventDefault();

            // disable sending on empty textarea
            if (!$(form).find('textarea').val()) {
                notif_box.addClass('error').removeClass('success')
                notification(aeCommentFormAjaxOBJ.msg_empty_textarea, true)
                return
            }

            if (!CAN_AJX) {
                return
            }
            CAN_AJX = false

            $.ajax({
                url: aeCommentFormAjaxOBJ.ajaxUrl,
                type: 'POST',
                data: $(this).serialize() + '&action=ae_comment_form_ajax',
                beforeSend: function () {
                    notif_box.removeClass('success').removeClass('error')
                    notification(aeCommentFormAjaxOBJ.msg_processing, false)
                },
                success: function (response) {
                    CAN_AJX = true
                    if (!response.success) {
                        notif_box.removeClass('success').addClass('error')
                        if (response.data.message == '409') {
                            notification(aeCommentFormAjaxOBJ.msg_duplicate)
                        } else {
                            notification(response.data.message)
                        }
                    }
                    else {
                        notif_box.removeClass('error').addClass('success')
                        notification(response.data.message)
                        reload_comments_section()
                    }
                    CAN_AJX = true
                },
                error: function (request, status, error) {
                    notif_box.removeClass('success').addClass('error')
                    if (status == 500) {
                        notification(aeCommentFormAjaxOBJ.msg_error_500)
                    } else if (status == 'timeout') {
                        notification(aeCommentFormAjaxOBJ.msg_error_server_respond)
                    } else {
                        notification('ERROR :(')
                    }
                    CAN_AJX = true
                }
            }).done(function () {
                CAN_AJX = true
                $(form)[0].reset()
            })

        })
        $(document).on('click touch', aeCommentFormAjaxOBJ.replay_btn, function (e) {
            e.preventDefault();
            $(aeCommentFormAjaxOBJ.respond_section).remove()
            const parent_comment = $(this).parents('li').first()
            cloned_form_respond.find('#comment_parent').val(parent_comment.data('comment-id'))
            cloned_form_respond.find('.comment-title h4').html(aeCommentFormAjaxOBJ.msg_replay).append(aeCommentFormAjaxOBJ.cancel_btn)
            parent_comment.append(cloned_form_respond)
        })
        $(document).on('click touch', '.comment-respond .cancel-replay', function (e){
            $(aeCommentFormAjaxOBJ.comments_section).find('li #respond').remove()
            $(aeCommentFormAjaxOBJ.comments_section).append(cloned_form)
        })

        function reload_comments_section() {

            $.ajax({
                url: aeCommentFormAjaxOBJ.ajaxUrl, type: 'POST', data: {
                    action: 'ae_comment_form_ajax_list',
                    post_id: $(form).find('#comment_post_ID').attr('value'),
                    nonce: aeCommentFormAjaxOBJ.nonce
                }, beforeSend: function () {
                }, success: function (response) {
                    if (response.success) {
                        $(aeCommentFormAjaxOBJ.comments_section).html(response.data.comments)
                        $(aeCommentFormAjaxOBJ.comments_section).append(cloned_form)
                    }
                }
            })
        }

        function notification(msg, hide = true) {
            const notification = $('.ae-comment-form-ajax-notification')
            notification.text(msg)
            notification.addClass('active')
            if (hide) {
                window.setTimeout(function () {
                    notification.removeClass('active')
                }, 1500)
            }

        }

    })
})(jQuery);
