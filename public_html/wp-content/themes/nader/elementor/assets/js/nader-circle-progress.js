(function ($, elementor) {
    'use strict';

    let NaderCircleProgressScope = function ($scope, $) {

        let NaderCircleProgress = $scope.find('.nader-circle-progress')
        if (!NaderCircleProgress.length) {
            return
        }

        /* ============================================================ */
        /* Circle Progressbar
        /* ============================================================ */
        function AnimateNaderCircleProgress() {
            let elementPos = NaderCircleProgress.offset().top;
            let topOfWindow = $(window).scrollTop();
            let percent = NaderCircleProgress.find(".circle").attr("data-percent");
            let fill = NaderCircleProgress.find(".circle").attr("data-xfill");
            let emptyFill = NaderCircleProgress.find(".circle").attr("data-xemptyFill");
            let thickness = NaderCircleProgress.find(".circle").attr("data-xthickness");
            let animate = NaderCircleProgress.data("animate");
            if (elementPos < topOfWindow + $(window).height() - 30 && !animate) {
                NaderCircleProgress.data("animate", true);
                NaderCircleProgress.find(".circle").circleProgress({
                    startAngle: -Math.PI / 2,
                    value: percent / 100,
                    thickness: thickness,
                    size: 300,
                    lineCap: "round",
                    emptyFill: emptyFill,
                    fill: {
                        color: fill,
                    },
                })
                    .on(
                        "circle-animation-progress",
                        function (event, progress, stepValue) {
                            NaderCircleProgress
                                .parent()
                                .find("span")
                                .text((stepValue * 100).toFixed(0));
                        }
                    ).stop();
            }

        }
        // Show animated elements
        AnimateNaderCircleProgress();
        $(window).scroll(AnimateNaderCircleProgress);

    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/NaderCircleProgress.default', NaderCircleProgressScope)
    });

}(jQuery, window.elementorFrontend))
