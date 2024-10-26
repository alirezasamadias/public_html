(function ($, elementor) {
    'use strict';

    let NaderCounterScope = function ($scope, $) {

        let NaderCounter = $scope.find('.nader-counter')
        if (!NaderCounter.length) {
            return
        }

        const counter = NaderCounter.find('.counter')
        counter.counterUp({
            delay: 10,
            time: 1500,
        });

    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/NaderCounter.default', NaderCounterScope)
    });

}(jQuery, window.elementorFrontend))
