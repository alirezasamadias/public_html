(function ($) {
    'use strict';

    let OpenWithClickScope = function ($scope, $) {
        const openWithClick = $('.open-with-click')
        if (openWithClick.length > 0) {
            openWithClick.each(function () {
                $(this).on('click', $(this).data('handler'), function (e) {
                    const isActive = $(this).parents('.open-with-click').hasClass('active')
                    if (!isActive) {
                        $(this).parents('.open-with-click').addClass('active')
                        return
                    }
                    $(this).parents('.open-with-click').removeClass('active')
                })
            })
        }
    }


    let TimelineScope = function ($scope, $) {

        let Timeline = $scope.find('.wp-active-we-timeline-2')
        if (!Timeline.length) {
            return
        }
        const line = Timeline.find('.timeline-2-line')

        setHeight()

        function setHeight() {
            let h = Math.round(Timeline.height() - Timeline.find('.timeline-2-item').last().height())
            line.height(h)
        }

        $(window).resize(function () {
            setHeight()
        })

    }


    let ShareButtonScope = function ($scope, $) {
        const overlay = '.wp-active-we-overlay.popup-modal'
        if (!$(overlay).length) {
            $('body').append('<div class="wp-active-we-overlay popup-modal"></div>')
        }

        const button_opener = $scope.find('.wp-active-we-share-btn')
        const button_closer = $scope.find('.btn_closer')
        const share_box = $scope.find('.wp-active-we-share-btn-popup')
        const copy_link = $scope.find('.copy-link-box')
        button_opener.click(function () {
            openShareModal()
        })
        button_closer.click(function () {
            closeShareModal()
        })
        $(overlay).click(function () {
            closeShareModal()
        })
        copy_link.click(function () {
            const x = navigator.clipboard.writeText($(this).data('link'))
            alert($(this).data('copied-text'))
        })

        function openShareModal() {
            $(overlay).addClass('active')
            share_box.addClass('active')
        }

        function closeShareModal() {
            $(overlay).removeClass('active')
            share_box.removeClass('active')
        }

    }


    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_DropdownMenuOneColumn.default', OpenWithClickScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_Timeline2.default', TimelineScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_SharePopup.default', ShareButtonScope)
    });

}(jQuery, window.elementorFrontend))
