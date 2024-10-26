(function ($, elementor) {
    'use strict';

    let NaderBlock3ImageScope = function ($scope, $) {

        let NaderBlock3Image = $scope.find('.nader-3-image-block')
        if (!NaderBlock3Image.length) {
            return
        }

        const image1 = NaderBlock3Image.find('.parallax-img-1')
        const image2 = NaderBlock3Image.find('.parallax-img-2')
        const image3 = NaderBlock3Image.find('.parallax-img-3')

        if (image1.data('parallax-settings') != '') {
            new simpleParallax(image1[0], image1.data('parallax-settings'));
        }
        if (image2.data('parallax-settings') != '') {
            new simpleParallax(image2[0], image2.data('parallax-settings'));
        }
        if (image3.data('parallax-settings') != '') {
            new simpleParallax(image3[0], image3.data('parallax-settings'));
        }


        const imgBoxBig = NaderBlock3Image.find('.big-img')
        const imgBoxThumb1 = NaderBlock3Image.find('.thumb-1')
        const imgBoxThumb2 = NaderBlock3Image.find('.thumb-2')

        if (imgBoxBig.data('tilt-settings') != '') {
            imgBoxBig.tilt(imgBoxBig.data('tilt-settings'))
        }
        if (imgBoxThumb1.data('tilt-settings') != '') {
            imgBoxThumb1.tilt(imgBoxThumb1.data('tilt-settings'))
        }
        if (imgBoxThumb2.data('tilt-settings') != '') {
            imgBoxThumb2.tilt(imgBoxThumb2.data('tilt-settings'))
        }

        if (imgBoxBig.data('rellax-settings') != '') {
            new Rellax(imgBoxBig[0], imgBoxBig.data('rellax-settings'));
        }
        if (imgBoxThumb1.data('rellax-settings') != '') {
            new Rellax(imgBoxThumb1[0], imgBoxThumb1.data('rellax-settings'));
        }
        if (imgBoxThumb2.data('rellax-settings') != '') {
            new Rellax(imgBoxThumb2[0], imgBoxThumb2.data('rellax-settings'));
        }

    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/Nader3Image.default', NaderBlock3ImageScope)
    });

}(jQuery, window.elementorFrontend))
