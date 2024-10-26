(function ($) {
    "use strict";

    /**
     * display svg icon for dashboard admin panel
     */
    function renderSvg() {
        let menu_items = $('#nav-menus-frame #menu-to-edit .menu-item')
        menu_items.each(function () {
            const textarea = $(this).find('.acf-field-62e6d586d3745 textarea')
            if (textarea.val()) {
                if (textarea.parent('.acf-input').find('.svg-place').length) {
                    textarea.parent('.acf-input').find('.svg-place').replaceWith('<span class="svg-place" style="width: 48px;height: 48px;display: block;">' + textarea.val() + '</span>')
                } else {
                    textarea.parent('.acf-input').append('<span class="svg-place" style="width: 48px;height: 48px;display: block;">' + textarea.val() + '</span>')
                }
            } else {
                textarea.parent('.acf-input').find('.svg-place').remove()
            }
        })
    }
    renderSvg()

    const add_to_menu_btn = $('.submit-add-to-menu')
    let textarea = $('.acf-field-62e6d586d3745 textarea')

    add_to_menu_btn.click(function () {
        textarea = $('.acf-field-62e6d586d3745 textarea')
        renderSvg()
    })

    textarea.blur(function () {
        textarea = $('.acf-field-62e6d586d3745 textarea')
        renderSvg()
    })


})(jQuery);