(function ($, elementor) {
    'use strict';

    let NaderFloatingMenuScope = function ($scope, $) {

        let NaderFloatingMenu = $scope.find('.nader-floating-menu')
        if (!NaderFloatingMenu.length) {
            return
        }

        const LinkItem = NaderFloatingMenu.find('a')

        $(window).scroll(function () {
            LinkItem.each(function () {
                let container = $(this).attr('href');
                if ($(container).length) {
                    let containerOffset = $(container).offset().top;
                    let containerHeight = $(container).outerHeight();
                    let containerBottom = containerOffset + containerHeight;
                    let scrollPosition = $(document).scrollTop();

                    if (scrollPosition < containerBottom - 20 && scrollPosition >= containerOffset - 20) {
                        $(this).parents('li').addClass('active');
                        $(this).find('span').slideDown('fast');
                    } else {
                        $(this).parents('li').removeClass('active');
                        $(this).find('span').slideUp('fast');
                    }
                }
            })
        })

    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/NaderFloatingMenu.default', NaderFloatingMenuScope)
    });

}(jQuery, window.elementorFrontend))
