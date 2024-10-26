(function ($, elementor) {
    'use strict';

    let SliderContainerScope = function ($scope, $) {

        let SliderContainer = $scope.find('.slider-container')
        if (!SliderContainer.length) {
            return
        }

        // destroy slider if there is no post
        if (SliderContainer.hasClass('wo-post')) {
            SliderContainer.removeClass('owl-carousel')
            SliderContainer.find('owl-carousel').removeClass('owl-carousel')
            return;
        }

        const slider_settings = SliderContainer.data('slider-settings')

        let SLIDER = null
        if (SliderContainer.hasClass('owl-carousel')) {
            SLIDER = SliderContainer.owlCarousel(slider_settings)
        } else {
            SLIDER = SliderContainer.find('.owl-carousel').owlCarousel(slider_settings)
        }

        // navigation
        if (slider_settings.navNextBtn) {
            $(slider_settings.navNextBtn).click(function () {
                SLIDER.trigger('next.owl.carousel');
            })
        }
        if (slider_settings.navPrevBtn) {
            $(slider_settings.navPrevBtn).click(function () {
                SLIDER.trigger('prev.owl.carousel');
            })
        }

    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_Testimonials1.default', SliderContainerScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_Testimonials2.default', SliderContainerScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_Testimonials3.default', SliderContainerScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ThumbSlider.default', SliderContainerScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsSlider1.default', SliderContainerScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsSlider2.default', SliderContainerScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsSlider3.default', SliderContainerScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsSlider4.default', SliderContainerScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_TeamSlider1.default', SliderContainerScope)
    });

}(jQuery, window.elementorFrontend))
