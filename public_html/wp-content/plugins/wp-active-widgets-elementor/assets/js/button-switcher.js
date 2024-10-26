(function ($, elementor) {
    'use strict';

    let ButtonSwitcherScope = function ($scope, $) {

        let SwitcherContainer = $scope.find('.wp-active-we-button-switcher')
        if (!SwitcherContainer.length) {
            return
        }

        const buttons = SwitcherContainer.find('.btn-switcher')

        // hide others beside the one has the class active
        buttons.each(function () {
            const btn = $(this)
            const btnTarget = btn.data('target')

            if (!btn.hasClass('active')) {
                $(btnTarget).hide()
            }
        })


        buttons.click(function () {
            const btn = $(this)
            if (!btn.hasClass('active')) {

                // hide other buttons target
                buttons.removeClass('active')
                buttons.each(function () {
                    $($(this).data('target')).slideUp()
                })

                // show current button target
                btn.addClass('active')
                $(btn.data('target')).slideDown()

            }
        })
    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ButtonSwitcher.default', ButtonSwitcherScope)
    });

}(jQuery, window.elementorFrontend))
