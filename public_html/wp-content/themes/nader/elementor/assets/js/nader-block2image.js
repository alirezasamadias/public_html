(function ($, elementor) {
    'use strict';

    let NaderBlock2ImageScope = function ($scope, $) {

        let NaderBlock2Image = $scope.find('.nader-2-image-block')
        if (!NaderBlock2Image.length) {
            return
        }

        const image1box = NaderBlock2Image.find('.image-box-1')
        const image2box = NaderBlock2Image.find('.image-box-2')

        // Tilt Effect
        if (image1box.data('tilt-settings') != '') {
            image1box.tilt(image1box.data('tilt-settings'))
        }
        if (image2box.data('tilt-settings') != '') {
            image2box.tilt(image2box.data('tilt-settings'))
        }

        // Rellax -> Out Parallax
        if (image1box.data('rellax-settings') != '') {
            new Rellax(image1box[0], image1box.data('rellax-settings'));
        }
        if (image2box.data('rellax-settings') != '') {
            new Rellax(image2box[0], image2box.data('rellax-settings'));
        }

    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/Nader2Image.default', NaderBlock2ImageScope)
    });

}(jQuery, window.elementorFrontend))
