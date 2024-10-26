(function ($) {
    "use strict";
    $(document).ready(function () {

        let CAN_AJAX_REQ = true
        const search_form = $('.search-box form')
        const search_field = search_form.find('.search-field')
        const advanced_settings_btn = $('.search-box .advanced-settings-btn')
        const advanced_settings_box = $('.search-box .search-advanced-settings-row')
        const loading = $('.search-box .loading')
        const search_btn = $('.search-box .search-submit')

        loading.hide()

        advanced_settings_btn.click(function () {
            if (advanced_settings_btn.hasClass('active')) {
                advanced_settings_btn.removeClass('active')
                advanced_settings_box.slideUp().removeClass('active')
            } else {
                advanced_settings_btn.addClass('active')
                advanced_settings_box.slideDown().addClass('active')
            }
        })

        const post_types = $('.search-box .search-advanced-settings-row .post_type')
        post_types.click(function () {
            search_form.submit()
        })

        const keywords = $('.search-box .searched-keywords-row span')
        keywords.click(function () {
            if (!CAN_AJAX_REQ) {
                return;
            }
            search_field.val($(this).text())
            search_form.submit()
        })

        search_form.on('submit', function (e) {
            e.preventDefault()

            if (!CAN_AJAX_REQ) {
                return;
            }

            CAN_AJAX_REQ = false

            if (search_field.val().length < 2) {
                CAN_AJAX_REQ = true
                return
            }

            let search_data = {}
            search_data.nonce = NADER_SEARCH_AJAX.security_nonce
            search_data.s = $(this).find('.search-field').val()
            search_data.action = "nader_search_ajax"
            search_data.post_type = $(this).find('.post_type:checked').val()

            $.ajax({
                url: NADER_SEARCH_AJAX.admin_ajax_url,
                type: 'POST',
                data: search_data,
                dataType: 'text',
                beforeSend: function () {
                    loading.show()
                    search_btn.hide()
                },
                success: function (response) {
                    $('.search-box .search-result').html(response)
                },
                fail: function (err) {
                    console.log(err)
                },
            }).done (function () {
                loading.hide()
                search_btn.show()
                CAN_AJAX_REQ = true
            })
        })
    })
})(jQuery);