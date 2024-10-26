(function ($, elementor) {
    'use strict';

    let TabsWithImageScope = function ($scope, $) {

        let TabsWithImage = $scope.find('.wp-active-we-tabs-with-image')
        if (!TabsWithImage.length) {
            return
        }

        const TabsControls = TabsWithImage.find('.tab-controls button')
        const TabsContents = TabsWithImage.find('.tab-contents .tab-content')

        TabsControls.first().addClass('active')
        TabsContents.first().addClass('active')

        TabsControls.click(function () {
            const _this = $(this)
            if (!_this.hasClass('active')) {
                TabsControls.removeClass('active')
                _this.addClass('active')

                TabsContents.removeClass('active')
                $(_this.data('target')).addClass('active')
            }
        })

    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_TabsWithImage.default', TabsWithImageScope)
    });

}(jQuery, window.elementorFrontend))
