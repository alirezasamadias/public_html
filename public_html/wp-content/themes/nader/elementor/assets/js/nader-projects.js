(function ($, elementor) {
    'use strict';

    let NaderProjectsScope = function ($scope, $) {

        let NaderProjects = $scope.find('.nader-projects')
        if (!NaderProjects.length) {
            return
        }

        let container = NaderProjects.find('.portfolio-inner')
        container.isotope({
            resizable: true,
            itemSelector: '.portfolio-item',
            layoutMode: 'packery',
            percentPosition: true,
            isOriginLeft: !$(document).hasClass('rtl'),
            masonry: {
                columnWidth: '.portfolio-item',
            },
            hiddenStyle: {
                transform: 'scale(.2) skew(30deg)',
                opacity: 0
            },
            visibleStyle: {
                transform: 'scale(1) skew(0deg)',
                opacity: 1,
            },
            transitionDuration: '.5s',
        })


        const isotopeFilters = $scope.find('.portfolio-wrapper .filter-button');
        isotopeFilters.on('click', 'li', function () {
            $(this).addClass('active').siblings().removeClass('active');

            const filterValue = $(this).attr('data-filter');
            container.isotope({
                filter: filterValue
            });
        });

    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/NaderProjects.default', NaderProjectsScope)
    });

}(jQuery, window.elementorFrontend))
