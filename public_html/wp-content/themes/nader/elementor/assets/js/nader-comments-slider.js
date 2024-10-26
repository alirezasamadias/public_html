(function ($, elementor) {
    'use strict';

    let NaderCommentsSliderScope = function ($scope, $) {

        let NaderCommentsSlider = $scope.find('.nader-comments-slider')
        if (!NaderCommentsSlider.length) {
            return
        }

        const feedbackCarousel = NaderCommentsSlider.find(".feedbackCarousel")
        const feedbackNav = NaderCommentsSlider.find(".feedbackNav")
        feedbackCarousel.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: feedbackNav,
            rtl: $(document).find('body').hasClass('rtl')
        });
        feedbackNav.slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: feedbackCarousel,
            dots: false,
            focusOnSelect: true,
            arrows: false,
            centerMode: true,
            centerPadding: "0",
            rtl: $(document).find('body').hasClass('rtl')
        });


    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/NaderCommentsSlider.default', NaderCommentsSliderScope)
    });

}(jQuery, window.elementorFrontend))
