(function ($, elementor) {
    'use strict';

    let NaderTabsScope = function ($scope, $) {

        let NaderTabs = $scope.find('.nader-tabs')
        if (!NaderTabs.length) {
            return
        }

        const TabItemHeader = NaderTabs.find('.nader-tabs-header .nader-tabs-item-title')
        const TabItemContent = NaderTabs.find('.nader-tabs-body .nader-tabs-item-content')

        TabItemHeader.click(function () {
            if (!$(this).hasClass('active')) {
                TabItemHeader.removeClass('active')
                TabItemContent.removeClass('active show')

                $(this).addClass('active')
                const target_content = $($(this).data('tab-target'))
                target_content.addClass('active')

                setTimeout(function(){target_content.addClass('show')}, 150);
            }
        })

    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/NaderTabs.default', NaderTabsScope)
    });

}(jQuery, window.elementorFrontend))
