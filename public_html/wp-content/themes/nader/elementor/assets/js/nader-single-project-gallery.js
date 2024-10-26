(function ($, elementor) {
    'use strict';

    let NaderSingleProjectGalleryScope = function ($scope, $) {

        let NaderSingleProjectGallery = $scope.find('.nader-single-project-gallery')
        if (!NaderSingleProjectGallery.length) {
            return
        }

        if (NaderSingleProjectGallery.hasClass('owl-carousel')) {

            const slider_settings = NaderSingleProjectGallery.data('slider')
            let SLIDER = NaderSingleProjectGallery.owlCarousel(slider_settings)

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

            Fancybox.bind('[data-fancybox="fancybox-gallery"]', {Thumbs: {type: 'classic'}});

        }

    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/NaderSingleProjectGallery.default', NaderSingleProjectGalleryScope)
    });

}(jQuery, window.elementorFrontend))
