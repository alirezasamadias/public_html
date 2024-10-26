(function ($, elementor) {
    'use strict';

    let NaderLinearProgressScope = function ($scope, $) {

        let NaderLinearProgress = $scope.find('.nader-linear-progress')
        if (!NaderLinearProgress.length) {
            return
        }

        const percentage = NaderLinearProgress.data('value')
        const duration = NaderLinearProgress.data('duration')

        NaderLinearProgress.waypoint(function () {
            NaderLinearProgress.find('.nader-progress-line').animate({
                width: percentage + '%'
            }, duration)
            this.destroy()
        }, {offset: '95%'})

    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/NaderLinearProgress.default', NaderLinearProgressScope)
    });

}(jQuery, window.elementorFrontend))
