jQuery(document).ready(function ($) {

    $(document).on('woocommerce_update_variation_values', function (e) {

        updateAvailableTerms()
        $(e['target']).find('select').each(function () {
            const select = $(this)
            const val = select.find(':selected').val()
            const select_id = select.attr('id')
            if (val.length) {
                $('.' + select_id).find('span[data-term=' + val + ']').addClass('active')
            }
        })


    })

    $('.variations_form span.variation-term').click(function (e) {
        const _this = $(this)
        if (_this.hasClass('disabled')) {
            return;
        }
        const _value = _this.data('term')
        const _this_attribute = _this.parent('.ae-variation-swatches-terms').data('attribute')
        const select = $('select#' + _this_attribute)
        const select_option = select.find('option[value=' + _value + ']')

        if (select_option.length && !_this.hasClass('active')) {
            select.val(_value).change()
            _this.siblings('span.active').removeClass('active')
            _this.addClass('active')
        } else {
            select.val('').change()
            _this.removeClass('active')
        }
    })

    $('.reset_variations').on('click touch', function () {
        $('.ae-variation-swatches-terms span.variation-term').removeClass('disabled').removeClass('active')
    })

    function updateAvailableTerms() {
        $('.ae-variation-swatches-terms').find('span.variation-term').addClass('disabled')
        const all_selects = $('.variations select')
        all_selects.each(function (e) {
            const select_id = $(this).attr('id')
            $(this).find('option').each(function () {
                const option_value = $(this).attr('value')
                if (option_value !== '') {
                    const available_term = $('.ae-variation-swatches-terms.' + select_id).find('span[data-term=' + option_value + ']')
                    available_term.removeClass('disabled')
                }
            })
        })
    }


})
