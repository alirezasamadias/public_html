(jQuery)(document).ready(function ($) {
    let keyValue = -1;
    let firstTime = 0;
    let objectKeys = {};

    $('#rsmLogin').on('submit', function (e) {
        e.preventDefault()
        rtlShowLoading();
        $.ajax({
            method: 'POST',
            url: rsm.url,
            data: new FormData(this),
            processData: false,
            contentType: false,
        }).done(function (response) {
            let resp = $.parseJSON(response);
            if (resp.success === true) {
                rtlSuccess(resp.data.message).then(function () {
                    window.location.reload()
                })
            } else {
                rtlError(resp.data.message).then(function () {
                    // window.location.reload()
                })
            }
        }).fail(function () {
            rtlError()
        })


    })

    $('.debug-connection').on('click', function (e) {
        e.preventDefault()
        let btn = $(this)
        let text = btn.text();
        let type = btn.data('type')
        btn.prop('disable', true);
        btn.text('در حال تست');

        let data = {
            'action': 'rsmAjaxDebugConnection',
            'nonce': rsm.nonce,
            'tab': 'debug',
            'type': type
        }
        $.ajax({
            method: 'POST',
            url: rsm.url,
            data: data,
            dataType: 'json',

        }).done(function (response) {
            btn.prop('disable', false);
            btn.text(text);
            let message = response.data
            let html = ''
            if (typeof message == 'object' && message !== null) {
                html = checkObject(message);
            } else {
                html = `<div class="dd-div">
                    <div class="dd-value"> ${message}</div>
                </div>`
            }

            $('#' + type + '-msg').html(html)
        }).fail(function () {
            rtlError()
        })


    })

    $('#check-server').on('click', function (e) {
        e.preventDefault()
        let btn = $(this)
        let slug = $('#server-id').val();
        let text = btn.text();
        let option = $('#' + slug)
        btn.prop('disable', true);
        btn.text('در حال تست');

        let data = {
            'action': 'rsmCheckConnection',
            'nonce': rsm.nonce,
            'tab': 'check',
            'slug': slug
        }
        $.ajax({
            method: 'POST',
            url: rsm.url,
            data: data,
            dataType: 'json',

        }).done(function (response) {
            btn.prop('disable', false);
            btn.text(text);
            let title = response.data.message
            let server = response.data.server
            let status = server?.status
            let msg = `نام سرور = ${server?.title} --- پینگ = ${server?.ping} --- وضعیت = ${ status? 'فعال' : 'غیر فعال'}`
            option.text(msg)
            if (status) {
                option.css('background-color', '#fff')
                rtlSuccess(msg, title)
            } else {
                option.css('background-color', '#f79494')
                rtlError(msg)
            }

        }).fail(function () {
            rtlError()
        })


    })


    function checkObject(data) {
        let html = ''
        if (typeof data == 'object' && data !== null) {
            let keys = Object.keys(data)
            objectKeys[firstTime] = keys
            firstTime++;
            $.each(data, function (key, val) {
                if (key == 'changeLog') {
                    return;
                }

                if ($.inArray(key + '', objectKeys[firstTime - 1]) === -1) {
                    if (key !== keyValue && $.inArray(key + '', objectKeys[0]) !== -1) {
                        html += '<div class="dd-div" ><span class="dd-title" >' + key + '</span>'
                    }
                }
                if (key !== keyValue && $.inArray(key + '', objectKeys[firstTime - 1]) !== -1) {
                    html += '<div class="dd-div" ><span class="dd-title" >' + key + '</span>'
                }
                if (typeof val == 'object' && val !== null) {
                    $.each(val, function (key1, value) {
                        if (key1 == 'changeLog') {
                            return;
                        }
                        if (typeof value == 'object' && value !== null) {
                            html += '<span class="dd-key"> [' + key1 + ']=></span>'
                            html += checkObject(value)
                        } else {
                            html += `<div 1><span class="dd-key"> ${key1} => <span class="dd-value">${value}</span></span></div>`;
                        }
                    })
                } else {
                    html += `<div 2><span class="dd-key"> ${key} => <span class="dd-value">${val}</span></span></div>`;
                }
                if ($.inArray(key + '', objectKeys[firstTime - 1]) === -1) {
                    if (key !== keyValue && $.inArray(key + '', objectKeys[0]) !== -1) {
                        keyValue = key
                        html += '</div>'
                    }
                }
                if (key !== keyValue && $.inArray(key + '', objectKeys[firstTime - 1]) !== -1) {
                    keyValue = key
                    html += '</div>'
                }

            })

        }

        return html;
    }

})