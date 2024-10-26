(function ($, elementor) {
    'use strict';

    let NaderAccordionScope = function ($scope, $) {

        let NaderAccordion = $scope.find('.nader-accordion')
        if (!NaderAccordion.length) {
            return
        }

        const toggle_settings = NaderAccordion.data('toggle-setting')
        const AccordionItems = NaderAccordion.find('.nader-accordion-item')

        AccordionItems.find('.nader-accordion-header').click(function () {

            if ($(this).parents('.nader-accordion-item').hasClass('active')) {

                $(this).parents('.nader-accordion-item').removeClass('active')
                $(this).siblings('.nader-accordion-content').slideUp('fast')

            } else {

                $(this).parents('.nader-accordion-item').addClass('active')
                $(this).siblings('.nader-accordion-content').slideDown('fast')

                if (toggle_settings) {
                    $(this).parents('.nader-accordion-item').siblings('.nader-accordion-item').removeClass('active').find('.nader-accordion-content').slideUp('fast')
                }

            }

        })


    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/NaderAccordion.default', NaderAccordionScope)
    });

}(jQuery, window.elementorFrontend))
