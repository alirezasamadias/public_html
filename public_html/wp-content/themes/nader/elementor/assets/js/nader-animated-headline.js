(function ($, elementor) {
    'use strict';

    let NaderAnimatedTitleScope = function ($scope, $) {

        let NaderAnimatedTitle = $scope.find('.nader-animated-headline')
        if (!NaderAnimatedTitle.length) {
            return
        }

        const delay = NaderAnimatedTitle.data('delay')
        const speed = NaderAnimatedTitle.data('speed')
        let timeout = speed
        let allElements = NaderAnimatedTitle.find('span')
        let windowHeight = window.innerHeight;

        window.addEventListener('scroll', ()=> {
            for (let i = 0; i < allElements.length; i++) {  //  loop through the elements
                let viewportOffset = allElements[i].getBoundingClientRect();  //  returns the size of an element and its position relative to the viewport
                let top = viewportOffset.top + 50;  //  get the offset top
                if (top < windowHeight) {  //  if the top offset is less than the window height
                    setTimeout(function () {
                        $(allElements[i]).addClass('visible')
                    }, delay + (timeout += speed));
                }
            }
        });

    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/NaderAnimatedTitle.default', NaderAnimatedTitleScope)
    });

}(jQuery, window.elementorFrontend))
