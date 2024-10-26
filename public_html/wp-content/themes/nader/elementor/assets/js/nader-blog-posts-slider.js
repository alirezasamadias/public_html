(function ($, elementor) {
    'use strict';

    let NaderBlogPostsSliderScope = function ($scope, $) {

        let NaderBlogPostsSlider = $scope.find('.nader-blog-posts-slider')
        if (!NaderBlogPostsSlider.length) {
            return
        }

        const slider_settings = NaderBlogPostsSlider.data('slider-settings')
        const SLIDER = NaderBlogPostsSlider.owlCarousel(slider_settings);

        const next_btn = NaderBlogPostsSlider.navNextBtn
        if ($(next_btn).length) {
            $(next_btn).click(function(e) {
                e.preventDefault()
                SLIDER.trigger('next.owl.carousel')
            })
        }

        const prev_btn = NaderBlogPostsSlider.navPrevBtn
        if ($(prev_btn).length) {
            $(prev_btn).click(function(e) {
                e.preventDefault()
                SLIDER.trigger('prev.owl.carousel');
            })
        }
    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/NaderBlogPostsSlider.default', NaderBlogPostsSliderScope)
    });

}(jQuery, window.elementorFrontend))
