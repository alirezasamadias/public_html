(function ($, elementor) {
    'use strict';


    let NaderCommentsSlider2Scope = function ($scope, $) {

        let NaderCommentsSlider2 = $scope.find('.nader-comments-slider-2')
        if (!NaderCommentsSlider2.length) {
            return
        }

        const slider_settings = NaderCommentsSlider2.data('slider-settings')

        const SLIDER = NaderCommentsSlider2.owlCarousel(slider_settings);

        const next_btn = NaderCommentsSlider2.navNextBtn
        if ($(next_btn).length) {
            $(next_btn).click(function(e) {
                e.preventDefault()
                SLIDER.trigger('next.owl.carousel')
            })
        }

        const prev_btn = NaderCommentsSlider2.navPrevBtn
        if ($(prev_btn).length) {
            $(prev_btn).click(function(e) {
                e.preventDefault()
                SLIDER.trigger('prev.owl.carousel');
            })
        }
    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/NaderCommentsSlider2.default', NaderCommentsSlider2Scope)
    });

}(jQuery, window.elementorFrontend))
