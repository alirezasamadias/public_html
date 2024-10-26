(function ($, elementor) {
    'use strict';

    let ProjectsGalleryScope = function ($scope, $) {

        let ProjectsGallery = $scope.find('.wp-active-we-projects-gallery')
        if (!ProjectsGallery.length) {
            return
        }

        ProjectsGallery.on('click', '.filter-buttons button', function (e) {
            const _this = $(this)
            if (!_this.hasClass('active')) {
                _this.siblings().removeClass('active')
                _this.addClass('active')
                const project_items = _this.parents('.wp-active-we-projects-gallery').find('.project-item')
                project_items.each(function (value) {
                    if ($(project_items[value]).hasClass(_this.data('class-name'))) {
                        ProjectsGallery.find('.projects-inner ' + _this.data('filter')).show('fast')
                    } else {
                        $(project_items[value]).hide('fast')
                    }
                })
            }
        })


    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProjectsGallery2.default', ProjectsGalleryScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProjectsGallery3.default', ProjectsGalleryScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProjectsGallery4.default', ProjectsGalleryScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProjectsGallery5.default', ProjectsGalleryScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProjectsGallery6.default', ProjectsGalleryScope)
    });

}(jQuery, window.elementorFrontend))
