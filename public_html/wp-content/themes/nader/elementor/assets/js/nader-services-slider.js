(function ($, elementor) {
    'use strict';

    let NaderServicesSliderScope = function ($scope, $) {

        let NaderServicesSlider = $scope.find('.nader-services-slider')
        if (!NaderServicesSlider.length) {
            return
        }

        const slider_settings = NaderServicesSlider.data('slider-settings')

        const SLIDER = NaderServicesSlider.owlCarousel(slider_settings);

        const next_btn = NaderServicesSlider.navNextBtn
        if ($(next_btn).length) {
            $(next_btn).click(function(e) {
                e.preventDefault()
                SLIDER.trigger('next.owl.carousel')
            })
        }

        const prev_btn = NaderServicesSlider.navPrevBtn
        if ($(prev_btn).length) {
            $(prev_btn).click(function(e) {
                e.preventDefault()
                SLIDER.trigger('prev.owl.carousel');
            })
        }
    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/NaderServicesSlider.default', NaderServicesSliderScope)
    });

}(jQuery, window.elementorFrontend))
