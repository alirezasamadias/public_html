jQuery(document).ready(function ($) {
    "use strict"

    if (!$('.ae-wishlist-notification').length) {
        $('body').append('<div class="ae-wishlist-notification"></div>')
    }
    let CAN_REQ = true
    $('.ae-wishlist-form').submit(function (e) {
        e.preventDefault()


        if (!CAN_REQ) {
            return
        }
        CAN_REQ = false

        const form = $(e.target)
        const form_serialized = form.serializeArray()
        const data = {
            action: 'ae_wishlist_process',
        }
        $.each(form_serialized, function (i, v) {
            data[v.name] = v.value;
        })

        $.ajax({
            url: AE_WISHLIST_AJAX_OBJ.ajax_url,
            data: data,
            type: 'POST',
            beforeSend: function () {
                notification(AE_WISHLIST_AJAX_OBJ.msg.processing, false)
            },
            success: function (response) {
                if (response === '' || response === undefined || !response.success) {
                    $('.ae-wishlist-notification').removeClass('active')
                    return
                }

                response = response.data

                if (!response.status) {
                    notification(response)
                    return
                }

                if (form.hasClass('added')) {
                    form.removeClass('added').find('.ae-wishlist-input-type').attr('value', 'add')
                } else {
                    form.addClass('added').find('.ae-wishlist-input-type').attr('value', 'delete')
                }

                notification(response.msg)
            },
            fail: function (err) {
                console.log(err)
            },
        }).done(function () {
            CAN_REQ = true
        })

    })

    $('.ae-wishlist-btn.must-login-btn').click(function () {
        notification(AE_WISHLIST_AJAX_OBJ.msg.must_login)
    })

    function notification(msg, hide = true) {
        const notification = $('.ae-wishlist-notification')
        notification.text(msg)
        notification.addClass('active')
        if (hide) {
            window.setTimeout(function () {
                notification.removeClass('active')
            }, 1500)
        }

    }

})
