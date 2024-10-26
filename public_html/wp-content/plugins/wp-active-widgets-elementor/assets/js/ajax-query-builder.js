(function ($, elementor) {
    'use strict';

    let AjaxScope = function ($scope, $) {

        let AjaxContainer = $scope.find('.wp-active-we-ajax-container')
        if (!AjaxContainer.length || AjaxContainer.data('query-args') === '') {
            return
        }

        const Args = AjaxContainer.data('query-args')
        const ResultPlace = AjaxContainer.data('ajax-result-place')
        const AjaxType = AjaxContainer.data('ajax-type')
        let posts = []
        /**
         * status of ajax process
         * statuses => before_start | loading | done
         */
        let Status = AjaxContainer.data('ajax-status')
        let CAN_AJAX_REQ = true


        if (AjaxType == 'scroll') {
            window.addEventListener('scroll', function () {
                let windowHeight = window.innerHeight
                let viewportOffset = AjaxContainer[0].getBoundingClientRect()
                let top = viewportOffset.top

                if (top < windowHeight) {
                    ajaxReq()
                }
            });
        } else if (AjaxType == 'timeout') {
            setTimeout(ajaxReq, 100)
        }

        function ajaxReq() {
            if (CAN_AJAX_REQ === false || Status === 'loading' || Status === 'done') {
                return
            }

            CAN_AJAX_REQ = false

            let data = {
                action: 'wp_active_we_build_query',
                args: Args,
                postData: AjaxContainer.data('widget-data'),
                nonce: WP_ACTIVE_WE_AJAX_QUERY_BUILDER_OBJECT.ajax_query_builder_nonce
            }

            $.ajax({
                url: WP_ACTIVE_WE_AJAX_QUERY_BUILDER_OBJECT.ajaxUrl,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: function () {
                    AjaxContainer.attr('data-ajax-status', 'loading')
                },
                success: function (response) {
                    response = response.data
                    if (response.status && response.query) {

                        for (const i in response.posts) {
                            posts.push(createPost(response.posts[i]))
                        }

                        // if it`s not slider
                        if (!$(ResultPlace).hasClass('slider-container')) {
                            $(ResultPlace).html(posts)
                            $scope.find('.animated-placeholder').removeClass('animated-placeholder')
                            createFilters(response)
                        } else {
                            // if its slider
                            $scope.find('.slider-container').owlCarousel('destroy');
                            $(ResultPlace).html(posts)
                            initSlider($scope.find('.slider-container'))
                        }

                    } else if (response.status && !response.query) {
                        AjaxContainer.addClass('grid-one-col').addClass('wo-post')
                        $(ResultPlace).html('<p class="no-post-found">' + response.msg + '</p>')
                    } else {
                        AjaxContainer.addClass('grid-one-col')
                        $(ResultPlace).html('<p class="invalid-query-request">' + response.msg + '</p>')
                    }

                },
                fail: function (err) {
                    console.log(err)
                },
            }).done(function () {
                AjaxContainer.attr('data-ajax-status', 'done')
            })

        }


        function createPost(data) {
            let STRUCTURE = JSON.parse(AjaxContainer.data('post-structure'))


            STRUCTURE = STRUCTURE.replaceAll('{title}', data.title)
            STRUCTURE = STRUCTURE.replaceAll('{link}', data.link)
            STRUCTURE = STRUCTURE.replaceAll('{wid}', data.wid)
            STRUCTURE = STRUCTURE.replace('{post_class}', data.post_class)
            STRUCTURE = STRUCTURE.replace('{thumbnail}', data.thumbnail)
            STRUCTURE = STRUCTURE.replaceAll('{thumbnail_url_full}', data.thumbnail_url_full)
            STRUCTURE = STRUCTURE.replace('{excerpt}', data.excerpt)
            STRUCTURE = STRUCTURE.replace('{author}', data.author)
            STRUCTURE = STRUCTURE.replace('{comment}', data.comment)
            STRUCTURE = STRUCTURE.replace('{price}', data.price)
            STRUCTURE = STRUCTURE.replace('{view}', data.view)
            STRUCTURE = STRUCTURE.replace('{date_d}', data.date.d)
            STRUCTURE = STRUCTURE.replace('{date_M}', data.date.M)
            STRUCTURE = STRUCTURE.replace('{date_Y}', data.date.Y)
            STRUCTURE = STRUCTURE.replace('{date_d_m}', data.date.d_m)
            STRUCTURE = STRUCTURE.replace('{date_full}', data.date.full)

            /**
             * Gallery in loop
             */
            if (data.gallery_in_loop) {
                STRUCTURE = STRUCTURE.replace('{gallery_in_loop}', data.gallery_in_loop)
            } else {
                STRUCTURE = STRUCTURE.replace('{gallery_in_loop}', '')
            }


            /**
             * Custom fields
             */
            if (data.custom_fields) {
                STRUCTURE = STRUCTURE.replace('{custom_fields}', textParser(data.custom_fields))
            } else {
                STRUCTURE = STRUCTURE.replace('{custom_fields}', '')
            }


            /**
             * Categories
             */
            if (STRUCTURE.indexOf("#cat") != -1 && data.first_category !== undefined) {
                STRUCTURE = STRUCTURE.replace('{cat_link}', data.first_category.link)
                STRUCTURE = STRUCTURE.replaceAll('{cat_title}', data.first_category.name)
                STRUCTURE = STRUCTURE.replaceAll('#cat', '')
                STRUCTURE = STRUCTURE.replaceAll('cat#', '')
            } else if (STRUCTURE.indexOf("#cat") != -1) {
                STRUCTURE = STRUCTURE.split('#cat')
                const first_part = STRUCTURE[0]
                const second_part = STRUCTURE[1].split('cat#')[1]
                STRUCTURE = first_part + second_part
            }

            return STRUCTURE
        }


        function initSlider(SliderContainer) {
            const slider_settings = SliderContainer.data('slider-settings')

            let SLIDER = null
            if (SliderContainer.hasClass('owl-carousel')) {
                SLIDER = SliderContainer.owlCarousel(slider_settings)
            } else {
                SLIDER = SliderContainer.find('.owl-carousel').owlCarousel(slider_settings)
            }

            // navigation
            if (slider_settings.navNextBtn) {
                $(slider_settings.navNextBtn).click(function () {
                    SLIDER.trigger('next.owl.carousel');
                })
            }
            if (slider_settings.navPrevBtn) {
                $(slider_settings.navPrevBtn).click(function () {
                    SLIDER.trigger('prev.owl.carousel');
                })
            }
        }


        function createFilters(response) {
            if (response.filters) {
                const FilterPlace = AjaxContainer.data('ajax-result-place-filter')
                const FilterStructureArray = AjaxContainer.data('ajax-filter-structure')
                const FilterStructureBtn = FilterStructureArray.btn
                let FILTERS_HTML = FilterStructureArray.all


                $.each(response.filters, (obj) => {
                    let filter = Object.entries(response.filters[obj])[0];
                    let item = FilterStructureBtn

                    item = item.replace('{filter_select}', '.' + filter[0])
                    item = item.replace('{filter_class}', filter[0])
                    item = item.replaceAll('{filter_title}', filter[1])

                    FILTERS_HTML += item
                })

                $(FilterPlace).html(FILTERS_HTML)

            } else {
                AjaxContainer.find('.filter-buttons').remove()
            }
        }


        function textParser(text) {
            text = text.replaceAll('&amp;','&')
            text = text.replaceAll('&quot;','"')
            text = text.replaceAll('&gt;','>')
            text = text.replaceAll('&lt;','<')
            return text
        }

    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsGrid1.default', AjaxScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsGrid2.default', AjaxScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsColumn.default', AjaxScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsSlider1.default', AjaxScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsSlider2.default', AjaxScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsSlider3.default', AjaxScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsSlider4.default', AjaxScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_PostsMasonry1.default', AjaxScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProductsGrid.default', AjaxScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProductsGrid2.default', AjaxScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProjectsMasonry1.default', AjaxScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProjectsGallery3.default', AjaxScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProjectsGallery4.default', AjaxScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProjectsGallery5.default', AjaxScope)
        elementorFrontend.hooks.addAction('frontend/element_ready/WP_ACTIVE_WE_ProjectsGallery6.default', AjaxScope)
    });

}(jQuery, window.elementorFrontend))
