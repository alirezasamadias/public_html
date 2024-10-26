(function ($) {
    'use strict';

    let GalleryInLoop = function ($scope, $) {
        $scope.on('mouseover mouseout', ".gil-page", function (e) {
            const type = e.type
            const slide = $(this)
            const defaultSlide = $(this).parents('.gil-pages').find('.gil-page').first()
            const image = slide.parents('.project-thumbnail').find('img')

            if (type == 'mouseover') {
                image.attr('src', slide.data('url'))
                image.attr('srcset', slide.data('srcset'))
            } else {
                image.attr('src', defaultSlide.data('src'))
                image.attr('srcset', defaultSlide.data('srcset'))
            }
        })
    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProjectsGallery6.default', GalleryInLoop)
    });

}(jQuery, window.elementorFrontend))
