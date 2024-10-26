(function ($, elementor) {
    'use strict';

    let IntroAnimationScope = function ($scope, $) {
        const container = $scope.find('.active-animation')
        if (!container.length) {
            return
        }

        const target = container.data('animation-target')
        const offset = container.data('animation-offset')
        $(target).addClass('item-has-intro-animation')

        let windowHeight = window.innerHeight;

        window.addEventListener('scroll', function (e) {
            for (let i = 0; i <  $(target).length; i++) {  //  loop through the elements
                let viewportOffset = $(target)[i].getBoundingClientRect();  //  returns the size of an element and its position relative to the viewport
                let top = viewportOffset.top + offset;  //  get the offset top
                if (top < windowHeight) {  //  if the top offset is less than the window height
                    $($(target)[i]).addClass('show');  //  add the class
                }
            }
        })
    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProductsGrid.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProductsGrid2.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_IconBox.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_FeaturedBoxes.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_FeatureListBox.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsMasonry1.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsMasonry2.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsGrid1.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsGrid2.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsGrid3.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProjectsMasonry1.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProjectsGallery2.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProjectsGallery3.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProjectsGallery4.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProjectsGallery5.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProjectsGallery6.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsSlider1.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsSlider2.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsSlider3.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsSlider4.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ThumbSlider.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_Team1.default', IntroAnimationScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_TeamSlider1.default', IntroAnimationScope)
    });

}(jQuery, window.elementorFrontend))
