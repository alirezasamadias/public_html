(function ($) {
    "use strict";
    $(document).ready(function () {
        const forms = $('.login-register-popup form')
        const tabs_switcher = $('.login-tabs-switcher span')
        const result_place = $('.login-register-popup .login-register-result')
        const inputs = $('.login-register-popup .input-field')

        inputs.attr("oninvalid", "this.setCustomValidity('" + NADER_LOGIN_AJAX.msg.fill_field + "')")
        inputs.attr("oninput", "this.setCustomValidity('')")

        tabs_switcher.click(function () {
            const _this = $(this)
            if (!_this.hasClass('active')) {
                tabs_switcher.removeClass('active')
                _this.addClass('active')

                result_place.html('')

                forms.hide()
                $(_this.data('target')).show()
            }
        })

        // login
        const login_form = $('.login-register-popup form.login-form')
        let CAN_LOGIN_REQ = true
        login_form.submit(function (e) {
            e.preventDefault()

            if (CAN_LOGIN_REQ) {
                CAN_LOGIN_REQ = false
                const serialized_data = $(e.target).serializeArray()
                serialized_data.push({
                    name: 'action',
                    value: 'nader_ajax_login'
                })

                if (serialized_data[0].value && serialized_data[1].value) {
                    $.ajax({
                        url: NADER_LOGIN_AJAX.admin_ajax_url,
                        type: 'POST',
                        dataType: 'json',
                        data: serialized_data,
                        beforeSend: displayError('<p>' + NADER_LOGIN_AJAX.msg.process_data + '</p>'),
                        success: function (response) {
                            displayError(response.data.msg)

                            if (response.data.status) {
                                location.reload()
                            }
                        },
                        fail: function (err) {
                            console.log(err)
                        },
                    }).done(function () {
                        CAN_LOGIN_REQ = true
                    })
                }

            }
        })


        // register
        const register_form = $('.login-register-popup form.register-form')
        let CAN_REGISTER_REQ = true
        register_form.submit(function (e) {
            e.preventDefault()
            if (CAN_REGISTER_REQ) {
                CAN_REGISTER_REQ = false
                const serialized_data = $(e.target).serializeArray()
                serialized_data.push({
                    name: 'action',
                    value: 'nader_ajax_register'
                })

                if (serialized_data[0].value && serialized_data[1].value) {
                    $.ajax({
                        url: NADER_LOGIN_AJAX.admin_ajax_url,
                        type: 'POST',
                        dataType: 'json',
                        data: serialized_data,
                        beforeSend: displayError('<p>' + NADER_LOGIN_AJAX.msg.process_data + '</p>'),
                        success: function (response) {
                            displayError(response.data.msg)
                            if (response.data.status) {
                                location.reload()
                            }
                        },
                        fail: function (err) {
                            console.log(err)
                        },
                    }).done(function () {
                        CAN_REGISTER_REQ = true
                    })
                }
            }
        })


        function displayError($msg) {
            result_place.html('<p>' + $msg + '</p>')
        }

    })
})(jQuery);
