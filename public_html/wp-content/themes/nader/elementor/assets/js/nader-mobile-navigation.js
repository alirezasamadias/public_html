(function ($, elementor) {
    'use strict';

    let NaderMobileNavigationScope = function ($scope, $) {

        let NaderMobileNavigation = $scope.find('.nader-mobile-navigation')
        if (!NaderMobileNavigation.length) {
            return
        }

        if (NaderMobileNavigation.length) {
            const mobileMenuDropdownIcon = NaderMobileNavigation.find('.dropdown-icon')
            mobileMenuDropdownIcon.click(function (e) {
                e.preventDefault()
                const _this_icon = $(this)
                if (_this_icon.hasClass('active')) {
                    _this_icon.removeClass('active').parents('a').siblings('.sub-menu').find('.dropdown-icon').removeClass('active')
                    _this_icon.parents('a').siblings('.sub-menu').slideUp().removeClass('active')
                    _this_icon.parents('a').siblings('.sub-menu').find('.sub-menu').slideUp(200).removeClass('active')

                    _this_icon.parents('a').siblings('.mega-menu-box').slideUp(200).removeClass('active')

                } else {
                    _this_icon.addClass('active')
                    _this_icon.parents('a').siblings('.sub-menu').slideDown(200).addClass('active')
                    _this_icon.parents('a').siblings('.mega-menu-box').slideDown(200).addClass('active')
                }
            })
        }

    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/NaderMobileNavigation.default', NaderMobileNavigationScope)
    });

}(jQuery, window.elementorFrontend))
