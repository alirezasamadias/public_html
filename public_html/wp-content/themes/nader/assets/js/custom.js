(function ($) {
    "use strict";

    let box_overlay = null

    const nader_template = {

        /* ============================================================ */
        /* PRELOADER
        /* ============================================================ */
        preloader: function () {

            if ($('.loader-simple').length) {
                $(".loader-simple").fadeOut();
            }

            if ($('#linear-preloader').length) {
                setTimeout(function () {
                    "use strict";
                    let isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ? true : false;
                    let preloader = $('#linear-preloader');

                    if (!isMobile) {
                        setTimeout(function () {
                            preloader.addClass('preloaded');
                        }, 800);
                        setTimeout(function () {
                            preloader.remove();
                        }, 2000);
                    } else {
                        preloader.remove();
                    }
                }, 500);
            }
        },

        /* ============================================================ */
        /* Jquery Plugins Calling
        /* ============================================================ */
        onePageFunction: function () {

            $('#nav a[href*="#"]:not([href="#"])', '.nader-floating-menu a[href*="#"]:not([href="#"])').on('click', function () {
                if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {
                    let target = $(this.hash)
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']')
                    if (target.length) {
                        $('html,body').animate({
                            scrollTop: target.offset().top,
                        }, 100)
                        return false
                    }
                }
            })

            // Scrollspy
            let sectionIds = $('#nav a[href*="#"]:not([href="#"]), .nader-floating-menu a[href*="#"]:not([href="#"])');

            $(document).scroll(function () {
                sectionIds.each(function () {
                    let container = $(this).attr('href')
                    if ($(container).length) {
                        let containerOffset = $(container).offset().top;
                        let containerHeight = $(container).outerHeight();
                        let containerBottom = containerOffset + containerHeight;
                        let scrollPosition = $(document).scrollTop();

                        if (scrollPosition < containerBottom - 20 && scrollPosition >= containerOffset - 20) {
                            $(this).addClass('active');
                        } else {
                            $(this).removeClass('active');
                        }
                    }
                })
            })
        },

        /* ============================================================ */
        /* Mobile Menu Integration
        /* ============================================================ */
        mobile_menu: function () {
            //Clone Mobile Menu
            function cloneMobileMenu($cloneItem, $mobileLoc) {
                let $combined_menu = $($cloneItem).clone();
                $combined_menu.appendTo($mobileLoc);
            }

            cloneMobileMenu("header .menu", ".mobile-menu");

            $('.mob-header .toggler-menu').click(function () {
                $('.mobile-menu').addClass('is-menu-open')
                box_overlay.addClass('active')
            })

            $('.mobile-menu .menu-header .close-menu,.mobile-menu .menu li a').click(function () {
                $('.mobile-menu').removeClass('is-menu-open')
                box_overlay.removeClass('active')
            })

        },
        /* ============================================================ */
        /* Sticky Menu
        /* ============================================================ */
        sticky_menu: function () {
            const fixed_top = $(".mob-header");
            $(window).on("scroll", function () {
                if ($(this).scrollTop() > 100) {
                    fixed_top.addClass("sticky");
                } else {
                    fixed_top.removeClass("sticky");
                }
            });
        },
        /* ============================================================ */
        /* Scroll Top
        /* ============================================================ */
        scroll_to_top: function () {

            const scroll_top = $("#scroll-to-top")

            $(window).on("scroll", function () {
                if ($(this).scrollTop() > $(this).height()) {
                    scroll_top.addClass("btn-show").removeClass("btn-hide")
                } else {
                    scroll_top.addClass("btn-hide").removeClass("btn-show")
                }
            })


            // scroll to top line
            if (scroll_top.hasClass('scroll-to-top-line')) {
                const scroll_to_top_line = jQuery('#scroll-to-top .scroll-top-fill');
                $(window).on("scroll", function () {
                    const documentHeight = jQuery(document).height();
                    const windowHeight = jQuery(window).height();
                    const winScroll = jQuery(window).scrollTop();
                    const value = (winScroll / (documentHeight - windowHeight)) * 100;
                    scroll_to_top_line.css('height', value + "%");
                })
            }


            scroll_top.click(function () {
                $("html, body").animate(
                    {
                        scrollTop: 0,
                    },
                    "normal"
                );
            });
        },
        /* ============================================================ */
        /* Background Image
        /* ============================================================ */
        background_image: function () {
            $("[data-bg-color], [data-bg-image]").each(function () {
                var $this = $(this);

                if ($this.attr("data-bg-color") !== undefined) {
                    $this.css("background-color", $this.attr("data-bg-color"));
                }
                if ($this.attr("data-bg-image") !== undefined) {
                    $this.css("background-image", "url(" + $this.attr("data-bg-image") + ")");
                    $this.css("background-size", $this.attr("data-bg-size"));
                    $this.css("background-repeat", $this.attr("data-bg-repeat"));
                    $this.css("background-position", $this.attr("data-bg-position"));
                    $this.css("background-blend-mode", $this.attr("data-bg-blend-mode"));
                }
            });
        },
        /* ============================================================ */
        /* Cursor Pointer
        /* ============================================================ */
        mouse_cursor: function () {

            const cursor_outer = $('.cursor_outer')
            const cursor_inner = $('.cursor_inner')
            const body_selector = $('body')

            let mouseX = 0, mouseY = 0;
            let x1p = 0, y1p = 0, x2p = 0, y2p = 0;

            body_selector.mousemove(function (e) {
                mouseX = e.clientX
                mouseY = e.clientY
            })

            setInterval(function () {
                x1p += ((mouseX - x1p) / 6);
                y1p += ((mouseY - y1p) / 6);
                cursor_outer.css({left: x1p + 'px', top: y1p + 'px'});
            }, 6);

            setInterval(function () {
                x2p += ((mouseX - x2p) / 6);
                y2p += ((mouseY - y2p) / 6);
                cursor_inner.css({left: x2p + 'px', top: y2p + 'px'});
            }, 3);

            body_selector.on("mouseenter", "a, div[role=button], span[role=button], button, input[type=submit], .slick-slider .slick-slide, .nader-projects .filter-button li, select, .cursor-pointer", function () {
                cursor_outer.addClass('pointer')
                cursor_inner.addClass('pointer')
            })

            body_selector.on("mouseleave", "a, div[role=button], span[role=button], button, input[type=submit], .slick-slider .slick-slide, .nader-projects .filter-button li, select, .cursor-pointer", function () {
                cursor_outer.removeClass('pointer')
                cursor_inner.removeClass('pointer')
            })

        },
        /* ============================================================ */
        /* Search Box
        /* ============================================================ */
        search_box: function () {
            const search_box = $('.search-box')

            $('.search-opener').click(function () {
                search_box.addClass('active')
                box_overlay.addClass('active')
            })

            $('.search-box .popup-box-closer').click(function () {
                search_box.removeClass('active')
                box_overlay.removeClass('active')
            })

        },
        /* ============================================================ */
        /* Mini Cart
        /* ============================================================ */
        mini_cart: function () {

            const mini_cart_opener = $('.mini-cart-opener')
            const mini_cart_closer = $('.mini-cart-closer')
            const mini_cart_box = $('.nader-mini-cart-box')

            mini_cart_opener.click(function () {
                mini_cart_box.addClass('active')
                box_overlay.addClass('active')
            })

            mini_cart_closer.click(function () {
                mini_cart_box.removeClass('active')
                box_overlay.removeClass('active')
            })
        },
        /* ============================================================ */
        /* Custom Corner Buttons Popup
        /* ============================================================ */
        popup_corner_buttons: function () {
            const popup_opener = $('.corner-button.popup-corner-opener')
            const popup_box = $('.corner-buttons-popup')
            const closer_btn = $('.corner-buttons-popup .popup-box-closer')

            popup_opener.click(function () {
                box_overlay.addClass('active')
                popup_box.addClass('active')
            })

            closer_btn.click(function () {
                box_overlay.removeClass('active')
                popup_box.removeClass('active')
            })

        },
        /* ============================================================ */
        /* Ajax Login/Register Popup
        /* ============================================================ */
        popup_ajax_login: function () {
            const popup_opener = $('.login-opener')
            const popup_box = $('.login-register-popup')
            const closer_btn = $('.login-register-popup .popup-box-closer')

            popup_opener.click(function (e) {
                e.preventDefault()
                box_overlay.addClass('active')
                popup_box.addClass('active')
            })

            closer_btn.click(function () {
                box_overlay.removeClass('active')
                popup_box.removeClass('active')
            })

        },
        /* ============================================================ */
        /* Close Everything by Click on Overlay
        /* ============================================================ */
        overlay_closer: function () {
            box_overlay.click(function () {
                $('.mobile-menu').removeClass('is-menu-open')
                $('.corner-buttons-popup').removeClass('active')
                $('.overlay-box').removeClass('active')
                $('.mobile-menu-2').removeClass('active')
                $('.search-box').removeClass('active')
                $('.nader-mini-cart-box').removeClass('active')
                $('.login-register-popup').removeClass('active')
            })
        },
        /* ============================================================ */
        /* Project & Product Gallery
        /* ============================================================ */
        gallery: function () {
            const right_arrow = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"/></svg>'
            const left_arrow = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M10.828 12l4.95 4.95-1.414 1.414L8 12l6.364-6.364 1.414 1.414z"/></svg>'

            const gallery = $('.fancybox-gallery')
            if (gallery.length) {
                gallery.owlCarousel({
                    rtl: true,
                    items: 1,
                    loop: false,
                    autoplay: false,
                    nav: true,
                    navText: [right_arrow, left_arrow],
                    dots: false,
                })

                Fancybox.bind('[data-fancybox="fancybox-gallery"]', {Thumbs: {type: 'classic'}});
            }
        },
        /* ============================================================ */
        /* Copy Short Link to Clipboard
        /* ============================================================ */
        copy_link: function () {
            const copy_link = $('.nader-share .clipboard')
            copy_link.click(function (e) {
                e.preventDefault()
                const link = $(this).attr('href')
                const notif = $('.ctc-notif')

                /**
                 * There is an error in none secure sites! And "navigator.clipboard.writeText" do not copy the link.
                 * but on ssl sites, it will work correctly.
                 * */
                navigator.clipboard.writeText(link)
                notif.addClass('active')
                setTimeout(() => {
                    notif.removeClass('active')
                }, 2000)
            })
        },
        /* ============================================================ */
        /* Change Single Page Font Size
        /* ============================================================ */
        fz_changer: function () {
            const fz_changer = $('.font-size-changer')
            const fz_changer_target = $(fz_changer.data('font-size-changer-target'))
            const fz_changer_default_size = fz_changer.data('default-font-size')

            fz_changer.find('.fz-increase').click(function () {
                let def_fz = parseInt(fz_changer_target.css("font-size"))
                fz_changer_target.css("font-size", (def_fz + 1) + 'px')
            })
            fz_changer.find('.fz-decrease').click(function () {
                let def_fz = parseInt(fz_changer_target.css("font-size"))
                fz_changer_target.css("font-size", (def_fz - 1) + 'px')
            })
            fz_changer.find('.fz-reset').click(function () {
                fz_changer_target.css("font-size", fz_changer_default_size)
            })
        },
        /* ============================================================ */
        /* Switch Between Single Page Tabs
        /* ============================================================ */
        project_tab_switcher: function () {
            const project_tab_switcher = $('.project-tabs-switcher')
            project_tab_switcher.find('li').click(function () {
                const _this = $(this)
                if (!_this.hasClass('active')) {
                    _this.siblings('li').removeClass('active')
                    _this.addClass('active')

                    project_tab_switcher.siblings('.sc-inner').hide()
                    $(_this.data('target')).show()
                }
            })
        },

        initializ: function () {
            nader_template.preloader();
            nader_template.onePageFunction();
            nader_template.mobile_menu();
            nader_template.sticky_menu();
            nader_template.scroll_to_top();
            nader_template.background_image();
            nader_template.mouse_cursor();
            nader_template.search_box();
            nader_template.mini_cart();
            nader_template.popup_corner_buttons();
            nader_template.popup_ajax_login();
            nader_template.overlay_closer();
            nader_template.gallery();
            nader_template.copy_link();
            nader_template.fz_changer();
            nader_template.project_tab_switcher();
        },
    };

    $(document).ready(function () {
        box_overlay = $('.overlay-box')
        nader_template.initializ();
    });


    $('.login-tabs-head span').click(function () {
        if (!$(this).hasClass('active')) {
            $('.login-tabs-head span').removeClass('active')
            $('.nader-login .login-box').slideUp()
            $(this).addClass('active')
            $($(this).data('target')).slideDown()
        }
    })


    // change product quantity
    $('.quantity .add, .quantity .sub').click(function () {
        const _this = $(this)
        const input_text = $(this).siblings('.input-text.qty')

        const max_q = parseFloat(input_text.attr('max')) ? parseFloat(input_text.attr('max')) : 10000
        const min_q = parseFloat(input_text.attr('min')) ? parseFloat(input_text.attr('min')) : 1
        const step_q = parseFloat(input_text.attr('step')) ? parseFloat(input_text.attr('step')) : 1
        let current_q = parseFloat(input_text.val()) ? parseFloat(input_text.val()) : 1
        const update_cart_btn = $('.button[name=update_cart]')

        if (_this.hasClass('add') && current_q < max_q) {
            current_q += step_q
            if (current_q > max_q) {
                current_q = max_q
            }
            input_text.val(current_q)
            if (update_cart_btn.length) {
                update_cart_btn.prop('disabled', false)
            }
        }
        if (_this.hasClass('sub') && current_q > min_q) {
            current_q -= step_q
            if (current_q < 1) {
                current_q = 1
            }
            input_text.val(current_q)
            if (update_cart_btn.length) {
                update_cart_btn.prop('disabled', false)
            }
        }
    })


})(jQuery);
