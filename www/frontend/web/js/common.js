var counterDone = false;

$(document).ready(function () {
    var counterLoading = 0;
    var c = 0;
    var counterInterval;
    var counterPageLoading = function () {
        $(".loading-page .loading-page--counter h6").html(c + "%");
        $(".loading-page .loading-page--counter hr").css("width", c + "%");
        counterLoading++;
        c++;
        if (counterLoading == 101) {
            clearInterval(counterInterval);
            $('.loading-page').fadeOut(500);
            $('body').removeClass('fixed-body');
        }
    };

    var isMainPage = $('.content-main-page').length;

    if (isMainPage) {
        counterInterval = setInterval(counterPageLoading, 20);
    }

    // function imgLoaded() {
    //     c += 1;
    //
    //     var perc = ((100 / tot * c) << 0);
    //
    //     $(".loading-page .loading-page--counter h6").html(perc + "%");
    //     $(".loading-page .loading-page--counter hr").css("width", perc + "%");
    //
    //     if(perc === 100) {
    //         $('.loading-page').fadeOut(1200);
    //         $('body').removeClass('fixed-body');
    //     }
    //
    //     // console.log(perc);
    // }

    $('img').each(function () { // selecting all image element on the page

        var img = new Image($(this)); // creating image element

        img.onload = function () { // trigger if the image was loaded
            // console.log($(this).attr('src') + ' - done!');
        };

        img.onerror = function () { // trigger if the image wasn't loaded
            console.log($(this).attr('src') + ' - error!');
        };

        img.onAbort = function () { // trigger if the image load was abort
            console.log($(this).attr('src') + ' - abort!');
        };

        img.src = $(this).attr('src'); // pass src to image object
    });

    $('[data-toggle="tooltip"]').tooltip();

    // MAP
    var filterTrg;
    var clickedTimes = 0;
    $(".btn-filter").click(function (event) {
        $(".btn-filter").removeClass("active");
        $(this).addClass("active");
        var btnIndex = $(this).index();
        var collapseElements = $(".current-tour--body");
        collapseElements.removeClass("active");
        $(collapseElements)
                .eq(btnIndex)
                .addClass("active");

        // show reviews logo
        if ($(this).hasClass('tab-review-init')) {
            $('.tour-reviews-logo').removeClass('d-none');
            $('.reviews-rating.is-total').removeClass('d-none');
        } else {
            $('.tour-reviews-logo').addClass('d-none');
            $('.reviews-rating.is-total').addClass('d-none');
        }

        // show map on click

        if ($("#map").length && btnIndex == 3) {
            clickedTimes++;
            if (clickedTimes == 1) {
                var coordinates = [$("#map-lat").text(), $("#map-lng").text()];
                var address = $("#map-address").text();
                var mymap = L.map("map").setView(coordinates, 12);
                L.tileLayer(
                        "https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiaS13YW5uYS1tYXAiLCJhIjoiY2prbWJldW1tMDVyODNrcWx6eDZrMTgwdiJ9.gEihKYskaAQ_Aravq3M2sw",
                        {
                            attribution:
                                    'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                            maxZoom: 18,
                            id: "mapbox.streets",
                            style: "mapbox://styles/mapbox/streets-v9",
                            accessToken: "pk.eyJ1IjoiaS13YW5uYS1tYXAiLCJhIjoiY2prbWJldW1tMDVyODNrcWx6eDZrMTgwdiJ9.gEihKYskaAQ_Aravq3M2sw"
                        }
                ).addTo(mymap);
                var redIcon = L.icon({
                    iconUrl: "/img/icons/map-marker.png",
                    iconSize: [13, 24]
                });
                L.marker(coordinates, {icon: redIcon})
                        .addTo(mymap)
                        .bindPopup(address)
                        .openPopup();
            }
        }
    });

    // так можно установить новые кукисы или переписать значения у уже существующих:
    if ($.cookie("isWelcomePageVisible") == null) {
        $.cookie("isWelcomePageVisible", "visible", {expires: 360});
    }

    /*
     *   WINDOW RESIZE
     */
    function resizeSalesCards() {
        var width = $(window).width();
        var $container = $(".swiper-container.sales-container");
        var slides = $container.length ? $container.find('.swiper-slide') : [];

        function getMaxHeight(slides) {
            var slidesSizesGrid = $.makeArray(slides).map(function(el) {
                return $(el).find('.card').height();
            });
            var maxHeight = Math.max.apply(null, slidesSizesGrid);

            return maxHeight;
        }

        if (slides.length) {
            if (width < 992) {
                slides.css('height', 'auto');

                $container.css('height', 'auto');

                $container
                    .css('height', getMaxHeight(slides) + 30 + 'px') // Max slide height + vertical paddings
                    .addClass('fixed-height');
            } else if (width >= 1200) {
                // Main slides
                var $firstSlide = slides.first();
                var $secondSlide = $firstSlide.next();

                if ($secondSlide.length) {
                    $firstSlide.css('height', 'auto');
                    $secondSlide.css('height', 'auto');

                    var maxHeight = getMaxHeight([$firstSlide, $secondSlide]);

                    $firstSlide.css('height', maxHeight + 'px');
                    $secondSlide.css('height', maxHeight + 'px');
                }

                // Additinal slides
                slides.filter(':nth-child(3n)').each(function(index, el) {
                    var $currEl = $(el);
                    var $rowEls = $currEl.nextUntil(':nth-child(3n)');

                    if ($rowEls.length) {
                        $rowEls.push($currEl.get(0));
                        $rowEls.css('height', 'auto');
                        $rowEls.css('height', getMaxHeight($rowEls) + 'px');
                    }
                });
            } else if (width >= 992 && $container.hasClass('fixed-height')) {
                $container.css('height', 'auto').removeClass('fixed-height');
            } else if (width >= 992) {
                $container.css('height', 'auto').removeClass('fixed-height');
                slides.filter(':even').each(function(index, el) {
                    var $currEl = $(el);
                    var $nextEl = $currEl.next();

                    if ($nextEl.length) {
                        $currEl.css('height', 'auto');
                        $nextEl.css('height', 'auto');

                        var maxHeight = Math.max($currEl.height(), $nextEl.height());

                        $currEl.css('height', maxHeight + 'px');
                        $nextEl.css('height', maxHeight + 'px');
                    }
                });
            }
        }
    }

    function onWindowResize() {
        var width = $(window).width();

        if ($.cookie("isWelcomePageVisible") == "visible") {
            if (width < 768) {
                $(".welcome-page").fadeIn("slow");
            } else {
                $(".welcome-page").fadeOut("slow");
            }
        }

        resizeSalesCards();
    }

    $(window).resize(onWindowResize);
    onWindowResize();

    //  contact MAP

    if ($("#contact-map").length) {
        var coord = [$("#contact-map").data('latitude'), $("#contact-map").data('longitude')];
        var contactMap = L.map("contact-map").setView(coord, 13);
        L.tileLayer(
                "https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiaS13YW5uYS1tYXAiLCJhIjoiY2prbWJldW1tMDVyODNrcWx6eDZrMTgwdiJ9.gEihKYskaAQ_Aravq3M2sw",
                {
                    attribution:
                            'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    maxZoom: 18,
                    id: "mapbox.streets",
                    style: "mapbox://styles/mapbox/streets-v9",
                    accessToken: "pk.eyJ1IjoiaS13YW5uYS1tYXAiLCJhIjoiY2prbWJldW1tMDVyODNrcWx6eDZrMTgwdiJ9.gEihKYskaAQ_Aravq3M2sw"
                }
        ).addTo(contactMap);
        var oceanIcon = L.icon({
            iconUrl: "/img/icons/iconmappng.png",
            iconSize: [37, 40]
        });
        L.marker(coord, {icon: oceanIcon}).addTo(contactMap);
        contactMap.scrollWheelZoom.disable();
    }

    $(".welcome-page, .loading-page").on('touchmove scroll', function (event) {
        event.preventDefault();
    });

    $(".welcome-page .btn-regular").on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(".welcome-page").fadeOut("fast");
        $("body").removeClass("modal-open");
        $.cookie("isWelcomePageVisible", "hidden", {expires: 360});
    });

    $(".icon-question").on("click", function (e) {
        e.preventDefault();
        // e.stopPropagation();
        // $(".welcome-page").fadeIn("slow");
        // $("body").addClass("modal-open");
        // $(".hamburger-welcome").addClass("is-active");
    });

    $(document).on("click", ".mobile-info-modal", function () {
        var title = $(this).data('title');
        $("#modal-order-tour").find('.modal-title').text(title);
        $('#modal-order-tour').modal('show');
    });

    $(".hamburger-welcome.is-active").on("click", function (e) {
        e.stopPropagation();
        $(".welcome-page").fadeOut("slow");
        $(this).removeClass("is-active");
        $("body").removeClass("modal-open");
        $(".overlay").removeClass("opened");
        $.cookie("isWelcomePageVisible", "hidden", {expires: 360});
    });

    var stuff = {};
    $('.mobile-menu--body').on('touchstart', stuff, function (e) {
        e.data.max = this.scrollHeight - this.offsetHeight;
        e.data.y = e.originalEvent.pageY;
    }).on('touchmove', stuff, function (e) {
        var dy = e.data.y - e.originalEvent.pageY;
        if ((dy < 0 && this.scrollTop < 1) || (dy > 0 && this.scrollTop >= e.data.max)) {
            e.preventDefault();
        }
    });

    $(".hamburger").click(function (e) {
        e.stopPropagation();

        if ($(this).hasClass("hamburger-welcome")) {
        } else {

            // if($(window).scrollTop() <= 150) {
            //     $('body, html').animate({
            //         scrollTop: 0
            //     });
            // }

            $(".hamburger").toggleClass("is-active");
            $(".mobile-menu").toggleClass("opened");

            if ($(".header").hasClass("opened-menu")) {
                var scrollTop = -parseFloat($('body').css('top'));
                $('body').css('top', 0);

                $(".header").removeClass("opened-menu");
                $(".overlay").removeClass("opened");
                $("body").removeClass("fixed-body");

                $('html, body').scrollTop(scrollTop);
            } else {
                var scrollTop = $('html').scrollTop() || $('body').scrollTop();
                $('body').css('top', -scrollTop + 'px');

                $(".header").addClass("opened-menu");
                $(".overlay").addClass("opened");
                $("body").addClass("fixed-body");

            }
        }
    });

    $(".mobile-menu").on("click", function (e) {
        e.stopPropagation();
    });

    $('.overlay').on('click', function (event) {
        $(this).removeClass('opened');
        $("body").find(".mobile-menu").removeClass("opened");
        $(".hamburger").removeClass("is-active");
        $(".header").removeClass("opened-menu");
        $("body").removeClass("fixed-body");

        var scrollTop = -parseFloat($('body').css('top'));
        $('body').css('top', 0);
        $('html, body').scrollTop(scrollTop);
    });


    /*
     *  Swiper initialization for testimonials
     */
    var swiperBlogSwiper = $(".swiper-container.swiper-blog-container")[0];
    var swiperBlogSwiper2 = $(".swiper-container.swiper-blog-container2")[0];
    var testimonialsSwiper = $(".swiper-container.testimonial-container")[0];
    var salesSwiper = $(".swiper-container.sales-container")[0];
    var counterSwiper = $(".swiper-container.counter-container:not(.v2)")[0];
    var aboutSwiperSlider = $(".about-col.swiper-container")[0];
    var popularPlacesSlider = $('.swiper-container.slider-popular-places')[0];
    var waysSlider = $('.swiper-container.ways-slider')[0];
    var recommendSlider = $('.swiper-container.recommends-container')[0];
    var hotResortSlider = $('.swiper-container.hot-resort-slider')[0];
    var countryResortsSlider = $('.swiper-container.country-resorts')[0];

    var countryResortsSliderConfig = {
        slidesPerView: 2,
        speed: 900,
        grabCursor: true,
        watchOverflow: true,
        spaceBetween: 0,
        breakpoints: {
            576: {
                slidesPerView: 1
            }
        },
        pagination: {
            el: ".swiper-pagination.swiper-bottom-blog-pagination.pagination-v3",
            clickable: true
        },
    };

    var waySliderConfig = {
        slidesPerView: 'auto',
        speed: 900,
        spaceBetween: 0,
        grabCursor: true,
        breakpoints: {
            767: {
                slidesPerView: 2,
                spaceBetween: 10
            },
            576: {
                slidesPerView: 'auto'
            }
        }
    };

    var waysSwiperSlidesLen = $('.swiper-container.ways-slider .swiper-slide').length;

    if (waysSwiperSlidesLen > 1) {
        waySliderConfig.pagination = {
            el: ".swiper-pagination.swiper-bottom-blog-pagination",
            clickable: true
        }
    }

    var popularPlacesSliderConfig = {
        slidesPerView: 3,
        speed: 900,
        spaceBetween: 30,
        watchOverflow: true,
        grabCursor: true,
        breakpoints: {
            767: {
                slidesPerView: 2,
                spaceBetween: 10
            },
            576: {
                slidesPerView: 'auto',
                spaceBetween: 15
            }
        }
    };

    var popularPlacesSwiperSlidesLen = $('.swiper-container.slider-popular-places .swiper-slide').length;

    if (popularPlacesSwiperSlidesLen > 1) {
        popularPlacesSliderConfig.pagination = {
            el: ".swiper-pagination.swiper-bottom-blog-pagination",
            clickable: true
        }
    }

    var recommendSliderConfig = {
        speed: 900,
        spaceBetween: 0,
        centeredSlides: false,
        loop: false,
        grabCursor: true,
        watchOverflow: true,
        pagination: {
            el: ".swiper-pagination.swiper-bottom-blog-pagination.pagination-v1",
            clickable: true
        },
        breakpoints: {
            991: {
                slidesPerView: 2
            },
            767: {
                slidesPerView: 'auto',
                spaceBetween: 0
            }
        }
    };

    var hotResortSliderConfig = {
        speed: 900,
        spaceBetween: 0,
        grabCursor: true,
        loop: false,
        watchOverflow: true,
        centeredSlides: false,
        pagination: {
            el: ".swiper-pagination.swiper-bottom-blog-pagination.pagination-v2",
            clickable: true
        },
        breakpoints: {
            991: {
                slidesPerView: 2
            },
            767: {
                slidesPerView: 'auto',
                spaceBetween: 0
            }
        }
    };

    var testimonialsConfig = {
        slidesPerView: 4,
        speed: 900,
        pagination: {
            el: ".swiper-pagination.testimonial-pagination",
            clickable: true
        },
        keyboard: {
            enabled: true
        },
        breakpoints: {
            4500: {
                slidesPerView: 4
            },
            1229: {
                slidesPerView: 3
            },
            991: {
                slidesPerView: 2
            },
            767: {
                slidesPerView: "auto",
                spaceBetween: 26,
                loop: true,
                centeredSlides: true
            }
        }
    };

    var salesThumbsConfig = {
        slidesPerView: "auto",
        // centeredSlides: true,
        loop: false
    };

    var counterSwiperConfig = {
        slidesPerView: "auto",
        centeredSlides: true,
        loop: true
    };

    var swiperBlogSlider = {
        slidesPerView: 3,
        spaceBetween: 30,
        loop: false,
        breakpoints: {
            1199: {
                slidesPerView: "auto",
                spaceBetween: 15
            }
        }
    };

    var aboutSwiperConfig = {
        slidesPerView: "auto",
        speed: 900,
        spaceBetween: 25,
        loop: false,
        centeredSlides: true,
        breakpoints: {
            320: {
                spaceBetween: 10
            }
        }
    };

    testimonialsSwiper = testimonialsSwiper && new Swiper(testimonialsSwiper, testimonialsConfig);

    popularPlacesSlider = popularPlacesSlider && new Swiper('.swiper-container.slider-popular-places', popularPlacesSliderConfig);

    if ($(window).width() < 1200) {
        var swiperBlogSlider1 = Object.assign({}, swiperBlogSlider);
        var swiperBlogSlider2 = Object.assign({}, swiperBlogSlider);

        if ($('.swiper-container.swiper-blog-container .swiper-slide').length > 1) {
            swiperBlogSlider1.pagination = {
                el: ".swiper-pagination.swiper-bottom-blog-pagination",
                clickable: true
            };
        }

        if ($('.swiper-container.swiper-blog-container2 .swiper-slide').length > 1) {
            swiperBlogSlider2.pagination = {
                el: ".swiper-pagination.swiper-bottom-blog-pagination",
                clickable: true
            };
        }

        swiperBlogSwiper = swiperBlogSwiper && new Swiper(".swiper-container.swiper-blog-container", swiperBlogSlider1);
        swiperBlogSwiper2 = swiperBlogSwiper2 && new Swiper(".swiper-container.swiper-blog-container2", swiperBlogSlider2);
    }
    if ($(aboutSwiperSlider).find(".swiper-wrapper").children().length) {
        if ($(window).width() < 992) {
            salesSwiper = salesSwiper && new Swiper(".swiper-container.sales-container", salesThumbsConfig);
            aboutSwiperSlider = aboutSwiperSlider && new Swiper(".about-col.swiper-container", aboutSwiperConfig);
        }
    }

    if ($(window).width() < 992) {
        waysSlider = waysSlider && new Swiper('.swiper-container.ways-slider', waySliderConfig);
        recommendSlider = recommendSlider && new Swiper('.swiper-container.recommends-container', recommendSliderConfig);
        hotResortSlider = hotResortSlider && new Swiper('.swiper-container.hot-resort-slider', hotResortSliderConfig);
        // masonryContainer.masonry('destroy');
    }
    if ($(window).width() < 768) {
        countryResortsSlider = countryResortsSlider && new Swiper('.swiper-container.country-resorts', countryResortsSliderConfig);
    }
    if ($(window).width() < 576) {
        counterSwiper = counterSwiper && new Swiper(counterSwiper, counterSwiperConfig);
    }

    var mqlXl = matchMedia("(min-width: 1200px)");
    var mqlLg = matchMedia("(min-width: 992px)");
    var mqlMd = matchMedia("(min-width: 768px)");
    var mqlSm = matchMedia("(min-width: 576px)");
    mqlXl.addListener(function (mql) {
        if (!mql.matches) {
            swiperBlogSwiper = swiperBlogSwiper && new Swiper(".swiper-container.swiper-blog-container", swiperBlogSlider);
            swiperBlogSwiper2 = swiperBlogSwiper2 && new Swiper(".swiper-container.swiper-blog-container2", swiperBlogSlider);
        } else {
            swiperBlogSwiper && swiperBlogSwiper.destroy();
            swiperBlogSwiper2 && swiperBlogSwiper2.destroy();
        }
    });
    mqlLg.addListener(function (mql) {
        if (!mql.matches) {
            recommendSlider = recommendSlider && new Swiper('.swiper-container.recommends-container', recommendSliderConfig);
            hotResortSlider = hotResortSlider && new Swiper('.swiper-container.hot-resort-slider', hotResortSliderConfig);
            salesSwiper = salesSwiper && new Swiper(".swiper-container.sales-container", salesThumbsConfig);
            aboutSwiperSlider = aboutSwiperSlider && new Swiper(".about-col.swiper-container", aboutSwiperConfig);
            waysSlider = waysSlider && new Swiper('.swiper-container.ways-slider', waySliderConfig);
        } else {
            recommendSlider && recommendSlider.destroy();
            hotResortSlider && hotResortSlider.destroy();
            salesSwiper && salesSwiper.destroy();
            aboutSwiperSlider && aboutSwiperSlider.destroy();
            waysSlider && waysSlider.destroy();
        }
    });
    mqlMd.addListener(function (mql) {
        if (!mql.matches) {
            countryResortsSlider = countryResortsSlider && new Swiper('.swiper-container.country-resorts', countryResortsSliderConfig);
        } else {
            countryResortsSlider && countryResortsSlider.destroy();
        }
        testimonialsSwiper && testimonialsSwiper.destroy();
        testimonialsSwiper = testimonialsSwiper && new Swiper(".swiper-container.testimonial-container", testimonialsConfig);
    });
    mqlSm.addListener(function (mql) {
        if (!mql.matches) {
            counterSwiper = counterSwiper && new Swiper(".swiper-container.counter-container:not(.v2)", counterSwiperConfig);
        } else {
            counterSwiper && counterSwiper.destroy();
        }
    });

    $('.action-scroll-top > div').on('click', function (e) {
        $('body, html').stop().animate({
            scrollTop: 0
        }, "slow");
    });

    /*
     *  Sticky header
     */

    $(window).on("scroll", function (e) {
        var sticky = $("header"),
                scroll = $(window).scrollTop();

        if ($(".counter").length) {
            counter = $(".counter").offset().top - $(window).height() / 1.3;
        } else {
            counter = "";
        }

        if (scroll >= 800) {
            $('.action-scroll-top').show();
            $("body").addClass("sticky-header");
            sticky.addClass("sticky-header");
        } else if (!$('body').hasClass('modal-open')) {
            $('.action-scroll-top').hide();
            $("body").removeClass("sticky-header");
            sticky.removeClass("sticky-header");
        }

        if (scroll >= counter && !counterDone) {
            $(".counter-col--header").numScroll();
            counterDone = true;
        }
    });

    $(window).scroll();

    /*
     *	Counter
     */

    $(".counter-col--header").numScroll();

    //Tour card swiper slider
    var galleryThumbsConfig = {
        direction: "vertical",
        slidesPerView: 3,
        spaceBetween: 4,
        touchRatio: 1,
        allowTouchMove: true,
        mousewheel: true,
        breakpoints: {
            413: {
                direction: "horizontal",
                slidesPerView: "auto"
            }
        }
    };

    var galleryTopConfig = {
        slidesPerView: 1,
        direction: "horizontal",
        allowTouchMove: false
    };

    var galleryThumbs = new Swiper(".gallery-thumbs", galleryThumbsConfig);
    var galleryTop = new Swiper(".gallery-top", galleryTopConfig);

    // gallery thumbs slider

    var prevThumbIndex = 0;
    var galleryThumbsSlidesLength = $(".swiper-container.gallery-thumbs .swiper-slide").length;

    $(".gallery-thumbs .swiper-slide").on("click", function () {
        $(".gallery-thumbs .swiper-slide").removeClass("active");
        $(this).addClass("active");
        var index = parseInt($(this).attr("data-index"));
        if ($(".swiper-container.gallery-thumbs .swiper-wrapper").hasClass("can-swipe")) {
            if (index >= 1 && index < galleryThumbsSlidesLength - 1) {
                if (index > prevThumbIndex) {
                    galleryThumbs.slideNext();
                } else if (index < prevThumbIndex) {
                    galleryThumbs.slidePrev();
                }
            }
        }
        galleryTop.slideTo(index);
        prevThumbIndex = index;
    });

    // Scroll magic animation
    // initialize Scroll Magic controller
    var scrollMagicController = new ScrollMagic.Controller();

    // Init scene for each element, add animation for lines and section headers
    for (var i = 1; i <= $(".section").length; i++) {
        var sectionHeader = $(".section")
                .eq(i)
                .find(".section-header");
        sectionHeader.attr("id", "line-" + i);
        var headerTitle = $(".section")
                .eq(i)
                .find(".header-title");
        headerTitle.attr("id", "animate" + i);
        var cls = "#line-";
        new ScrollMagic.Scene({
            triggerElement: cls + i,
            triggerHook: 0.9
        })
                .setClassToggle("#animate" + i, "active")
                .addTo(scrollMagicController);
        new ScrollMagic.Scene({
            triggerElement: cls + i,
            triggerHook: 0.85
        })
                .setClassToggle(cls + i, "active")
                .addTo(scrollMagicController);
    }

    // btn-animate
    var btnAnimateScene = new ScrollMagic.Scene({
        triggerElement: ".testimonial-pagination",
        triggerHook: 0.9
    })
            .setTween(".btn-animate-testimonial", {
                transform: "translateY(0)",
                opacity: "1"
            })
            .addTo(scrollMagicController);

    // animation for section about
    var triggerCol = ".about-col";
    var triggerColHook = 0.9;

    // new ScrollMagic.Scene({
    //     triggerElement: triggerCol,
    //     triggerHook: triggerColHook
    // })
    //         .setTween(".about-col", {
    //             transform: "translateX(0)",
    //             opacity: "1"
    //         })
    //         .addTo(scrollMagicController);

    // new ScrollMagic.Scene({
    //     triggerElement: triggerCol,
    //     triggerHook: triggerColHook
    // })
    //         .setTween(".hidden-991", {
    //             transform: "translateY(0)",
    //             opacity: "1"
    //         })
    //         .addTo(scrollMagicController);

    // new ScrollMagic.Scene({
    //     triggerElement: ".col-info-animate",
    //     triggerHook: triggerColHook
    // })
    //         .setTween(".col-info-animate", {
    //             transform: "translateY(0)",
    //             opacity: "1"
    //         })
    //         .addTo(scrollMagicController);

    var circleMagicController = new ScrollMagic.Controller();
    var circlesScene = new ScrollMagic.Scene();

    for (var i = 0; i < $(".circle").length; i++) {
        var element = "circle_" + i;
        $(".circle")
                .eq(i)
                .attr("id", element);
        circlesScene = new ScrollMagic.Scene({
            triggerElement: ".section-smart",
            triggerHook: 0.9
        })
                .setClassToggle("#circle_" + i, "with-progress")
                .addTo(circleMagicController);
    }

    // breakpoint
    var cardsScrollMagicController = new ScrollMagic.Controller();
    var cardSizemScene1 = new ScrollMagic.Scene();
    var cardSizemScene2 = new ScrollMagic.Scene();
    var cardSizesScene = new ScrollMagic.Scene();
    var wayAnimateScene1 = new ScrollMagic.Scene();
    var wayAnimateScene2 = new ScrollMagic.Scene();

    var cardsBreakpoint = window.matchMedia("(min-width: 992px)");

    // var cardsEnableAnime = function cardsEnableAnime() {
    //     if (cardsBreakpoint.matches === true) {
    //         cardSizemScene1 = new ScrollMagic.Scene({
    //             // triggerElement: '.row-cards',
    //             triggerElement: ".sales-container .swiper-wrapper",
    //             triggerHook: 1,
    //             duration: 600
    //         })
    //                 .setTween(".col-card-animate-1", {
    //                     transform: "translateX(0)",
    //                     opacity: "1"
    //                 })
    //                 .addTo(cardsScrollMagicController);

    //         cardSizemScene2 = new ScrollMagic.Scene({
    //             // triggerElement: '.row-cards',
    //             triggerElement: ".sales-container .swiper-wrapper",
    //             triggerHook: 1,
    //             duration: 600
    //         })
    //                 .setTween(".col-card-animate-2", {
    //                     transform: "translateX(0)",
    //                     opacity: "1"
    //                 })
    //                 .addTo(cardsScrollMagicController);

    //         cardSizesScene = new ScrollMagic.Scene({
    //             // triggerElement: '.row-cards',
    //             triggerElement: ".sales-container .swiper-wrapper",
    //             triggerHook: 0.35,
    //             duration: 600
    //         })
    //                 .setTween(".card-animate-s", {
    //                     transform: "translateY(0)"
    //                 })
    //                 .addTo(cardsScrollMagicController);

    //         wayAnimateScene1 = new ScrollMagic.Scene({
    //             triggerElement: ".ways-row",
    //             triggerHook: 1,
    //             duration: 1200
    //         })
    //                 .setTween(".way-animate-1", {
    //                     transform: "translateY(-30px)"
    //                 })
    //                 .addTo(scrollMagicController);

    //         wayAnimateScene2 = new ScrollMagic.Scene({
    //             triggerElement: ".ways-row",
    //             triggerHook: 1,
    //             duration: 2000
    //         })
    //                 .setTween(".way-animate-2", {
    //                     transform: "translateY(-25px)"
    //                 })
    //                 .addTo(scrollMagicController);
    //     } else {
    //         cardSizemScene1.destroy(true);
    //         cardSizemScene1 = null;
    //         $(".col-card-animate-1").removeAttr("style");
    //         cardSizemScene2.destroy(true);
    //         cardSizemScene2 = null;
    //         $(".col-card-animate-2").removeAttr("style");

    //         cardSizesScene.destroy(true);
    //         cardSizesScene = null;
    //         $(".card-animate-s").removeAttr("style");

    //         wayAnimateScene1.destroy(true);
    //         wayAnimateScene1 = null;
    //         $(".way-animate-1").removeAttr("style");
    //         wayAnimateScene2.destroy(true);
    //         wayAnimateScene2 = null;
    //         $(".way-animate-2").removeAttr("style");
    //     }
    // };
    // cardsBreakpoint.addListener(cardsEnableAnime);
    // cardsEnableAnime();

    // breakpoint
    // var parallaxController = new ScrollMagic.Controller();
    // var parallax2 = new ScrollMagic.Scene();
    // var parallax3 = new ScrollMagic.Scene();

    // // var parallaxBreakpointFirst = window.matchMedia('(min-width: 1730px)');
    // var parallaxBreakpointFirst = window.matchMedia("(min-width: 992px)");

    // var parallaxBreakpointEnableFirst = function parallaxBreakpointEnableFirst() {
    //     if (parallaxBreakpointFirst.matches === true) {
    //         parallax2 = new ScrollMagic.Scene({
    //             triggerElement: ".section-advantages",
    //             triggerHook: 1,
    //             duration: 2000
    //         })
    //                 .setTween(".advantages", {
    //                     backgroundPositionY: "-165px" // best for screen > 1800px -227px
    //                 })
    //                 .addTo(parallaxController);

    //         parallax3 = new ScrollMagic.Scene({
    //             triggerElement: ".section-testimonials",
    //             triggerHook: 1,
    //             duration: 2000
    //         })
    //                 .setTween(".testimonials", {
    //                     backgroundPositionY: "-185px" // best for screen > 1800px -318px;
    //                 })
    //                 .addTo(parallaxController);
    //     } else if (parallaxBreakpointFirst.matches === false) {
    //         parallax2.destroy(true);
    //         parallax2 = null;
    //         $(parallax2).removeAttr("style");
    //         parallax3.destroy(true);
    //         parallax3 = null;
    //         $(parallax3).removeAttr("style");
    //     }
    // };

    // parallaxBreakpointFirst.addListener(parallaxBreakpointEnableFirst);
    // parallaxBreakpointEnableFirst();

    var showChar = 290;
    var ellipsestext = "...";

    $(".truncate").each(function(index, element) {
        var content = $(".truncate p").text();

        if(content.length > showChar) {
            var cut = content.substring(0, showChar);
            var text = content;
            var html =
                "<div class='truncate-text' style='display: block'>" + cut +
                "<span class='moreellipses'>" + ellipsestext + "&#160;&#160;&#160;<a href='#' class='moreless'>Eще</a></span></div>" +
                "<div class='truncate-text' style='display: none'>" + text + "&#160;&#160;&#160;<a href='#' class='moreless less'>Свернуть</a></div>";
            $(this).html(html);
        }
    });

    var testimonialCharsLimit = 450;
    $('.truncate-v2').each(function (index, element) {
        var text = $(element).text();
        var length = $(element).text().length;
        var cut = $(element).text().substring(0, testimonialCharsLimit);
        var html;

        if(length > testimonialCharsLimit) {
            html = "<div class='truncate-text' style='display:block'>" + cut + "<span class='moreellipses'>" + ellipsestext + "&#160;&#160;&#160;<a href='#' class='moreless v2'>Eще</a></span></div>" +
                "<div class='truncate-text' style='display:none'>" + text + "&#160;&#160;&#160;<a href='#' class='moreless-v2 moreless less'>Свернуть</a></div>";
            $(element).html(html);
        }
    });

    $(".moreless").click(function (e) {
        e.preventDefault();
        var thisEl = $(this);
        var cT = thisEl.closest(".truncate-text");
        var tX = ".truncate-text";

        if (thisEl.hasClass("less")) {
            cT.prev(tX).toggle();
            cT.toggle();
        } else {
            cT.toggle();
            cT.next(tX).toggle();
        }
        return false;
    });

    var videoPlayIcon = $(".about-video img"); // element trigger click
    var trgVideo = $("#video"); // target video
    var target = $(".modal.modal-video"); // target modal
    var source = $('<source type="video/mp4">'); // create element inside video

    function showVideoModal() {
        var link = $(this)
                .parents(".about-video")
                .attr("data-link");
        if (link != "") {
            source.attr("src", link);
            trgVideo.html(source);
            trgVideo.trigger("load");
            setTimeout(function () {
                target.modal('show');
            }, 500);
            target.on("shown.bs.modal", function () {
                trgVideo.trigger("play");
            });
        } else {
            alert("Видео отсутствует!");
        }
    }

    videoPlayIcon.on("click touch", showVideoModal);

    target.on("hidden.bs.modal", function () {
        $("video")[0].pause();
        trgVideo.html(""); // empty video
    });

    $("body").on('click', '.btn-parametr', function () {
        var viewParametr = $(this).data("view");
        $(".btn-parametr i").removeClass("active");
        $(this)
                .children(":not(.active)")
                .addClass("active");
        viewParametr ? $(".result-cards-wrapper").addClass("list-style") : $(".result-cards-wrapper").removeClass("list-style");
    });

    var swiperBlog = new Swiper(".swiper-container.swiper-blog", {
        slidesPerView: 3,
        spaceBetween: 30,
        pagination: {
            el: ".swiper-pagination.swiper-top-blog-pagination",
            clickable: true
        },
        breakpoints: {
            1199: {
                slidesPerView: "auto",
                spaceBetween: 10,
                centeredSlides: true,
                loop: true
            }
        }
    });

    $('input[type="tel"]').each(function(_, el) {
        new Cleave(el, {
            prefix: '+38',
              blocks: [3, 3, 7],
            delimiters: [' (',') '],
            noImmediatePrefix: true,
            numericOnly: true
        });
    });

//    $(".print-me").on("click", function (e) {
//        window.print();
//    });

    var teamSwiper = $(".swiper-container.team-slider")[0];
    var teamSwiperSlidesLen = $(".swiper-container.team-slider .swiper-slide").length;

    var teamSwiperConfig = {
        slidesPerView: 2,
        draggable: true,
        breakpoints: {
            767: {
                slidesPerView: 1
            },
            991: {
                slidesPerView: 2
            }
        }
    };

    if (teamSwiperSlidesLen > 1) {
        teamSwiperConfig.pagination = {
            el: ".swiper-pagination",
            clickable: true
        }
    }

    if ($(window).width() < 992) {
        teamSwiper = teamSwiper && new Swiper(teamSwiper, teamSwiperConfig);
    }

    var mqlLg = matchMedia("(min-width: 992px)");

    mqlLg.addListener(function (mql) {
        if (!mql.matches) {
            teamSwiper = teamSwiper && new Swiper(".swiper-container.team-slider", teamSwiperConfig);
        } else {
            teamSwiper && teamSwiper.destroy();
        }
    });

    $('[data-fancybox="gallery"]').fancybox({
        keyboard: true,
        preventCaptionOverlap: true,
        arrows: true,
        infobar: true,
        smallBtn: "auto",
        toolbar: "auto",
        buttons: [
            "zoom",
            "share",
            "slideShow",
            "fullScreen",
            "download",
            "thumbs",
            "close"
        ],
        idleTime: 3,
        protect: false,
        modal: false,
        image: {
            preload: true
        },
        beforeClose: function (instance) {
            console.info(instance.currIndex);
            galleryTop.slideTo(instance.currIndex, 0);
        }
    });

    $(".card-header--image").on("each", function () {
        $(this).addClass("preloader-inner");
    });

    $("body").on("click", ".btn-regular, .card-header--image.preloader-inner", function () {
        var a = '<div class="preloader"></div>';

        $(this)
                .parents(".card")
                .find(".preloader-inner")
                .append(a);

        setTimeout(function () {
            $(".preloader").remove();
        }, 5000);
    });

    $('body').on('click', '.btn-to-form', function () {
        var trg = $('#form-for-application').offset().top - 60;
        $('body, html').animate({
            scrollTop: trg
        }, 'slow');
    });

    /*
    *   Map init, get popular places on page loads and add it to map pins
    */
   function escapeXml(string) {
        return string.replace(/[<>]/g, function (c) {
            switch (c) {
            case '<': return '\u003c';
            case '>': return '\u003e';
            }
        });
    }

    var graphicMap = $('#w-map');
    var obj = {}; // object with popular places and images
    var popularPlacesArr = []; // array which keeps popular data in 2 symbol format
    var popularPlacesArr1 = [];
    var hiddenPlacesArr = []; // array for countries with hidden pins
    var popularElementBtn = $('.btn-filter-map[data-cat="1"]'); // get popular button
    var popularElementBtn1 = $('.btn-filter-map[data-cat="0"]'); // get all countries button
    if (popularElementBtn.length) {
        var popularArray = $(popularElementBtn).attr('data-countries'); // popular
        var popularArray1 = $(popularElementBtn1).attr('data-countries'); // all
    }
    var activeBtnFilterMap = $('.btn-filter-map.active');

    var europeBtn = $('.btn-filter-map[data-cat="2"]');
    var asiaBtn = $('.btn-filter-map[data-cat="3"]');
    var northAmericaBtn = $('.btn-filter-map[data-cat="4"]');
    var southAmericaBtn = $('.btn-filter-map[data-cat="5"]');
    var australiaBtn = $('.btn-filter-map[data-cat="6"]');

    var europeCountries, asiaCountries, northAmericaCountries, southAmericaCountries, australiaCountries;

    if (europeBtn.length)
        europeCountries = JSON.parse($(europeBtn).attr('data-countries').replace(/'/g, '"'));
    if (asiaBtn.length)
        asiaCountries = JSON.parse($(asiaBtn).attr('data-countries').replace(/'/g, '"'));
    if (northAmericaBtn.length)
        northAmericaCountries = JSON.parse($(northAmericaBtn).attr('data-countries').replace(/'/g, '"'));
    if (southAmericaBtn.length)
        southAmericaCountries = JSON.parse($(southAmericaBtn).attr('data-countries').replace(/'/g, '"'));
    if (australiaBtn.length)
        australiaCountries = JSON.parse($(australiaBtn).attr('data-countries').replace(/'/g, '"'));
    if(popularElementBtn.length) {
        popularArray = JSON.parse(popularArray.replace(/'/g, '"'));
        popularArray1 = JSON.parse(popularArray1.replace(/'/g, '"'));

        for(var prop1 in popularArray1) {
            for (var prop in popularArray) {
                popularPlacesArr.push(popularArray[prop]);
                    obj[popularArray1[prop1].toLowerCase()] = escapeXml('<img class="map-pin" src="../img/map_pin2.png" alt="pin"/>'); // create new property in object
                    if(hiddenPlacesArr.indexOf(popularArray1[prop1]) < 0) {
                        hiddenPlacesArr.push(popularArray1[prop1]);
                    }
                }
        }
    }

    /*
    *   Main event to set values to global variables
    *   getting mouse clicked position
    */

    if (graphicMap.length) {        
        var jqvMapMarkers;
        var countryCodes = [].slice.call(window.countryCodes);
        var $featuredTabBtn = $('#category-buttons .btn-filter[data-cat="1"]');
        var $wmap = $('#w-map');
        var chosenCountry = null;

        $wmap.vectorMap({
            map: 'world_en',
            backgroundColor: '#fff',
            color: '#a896cb',
            hoverColor: '#ff4800',
            selectedColor: '#ff4800',
            scaleColors: ['#b6d6ff', '#005ace'],
            hoverOpacity: null,
            enableZoom: false,
            normalizeFunction: 'linear',
            selectedRegions: null,
            showTooltip: true,
            pins: obj,
            pinMode: 'content',
            multiSelectRegion: false,

            onLoad: function () {
                jqvMapMarkers = $('.jqvmap-pin');
            },

            onRegionClick: function (event, code, region) {
                var targetCountry = countryCodes.find(function(value) {
                    return value.code === code.toUpperCase();
                });

                if (!targetCountry) {
                    chosenCountry = null;
                    return false;
                }

                $('.jqvmap-pin img').css('opacity', 0);

                var $targetTab = $('#category-buttons .btn-filter').filter(function(_, elem) {
                    var $tab = $(elem);
                    var countriesList = $tab.data('countries');
                    var category = $tab.data('cat');
                    var isMatches = countriesList.indexOf(targetCountry.code) > -1;

                    if (isMatches && category > 1) {
                        return true;
                    }

                    return false;
                });

                if ($targetTab.length) {
                    $targetTab.trigger('click');
                } else {
                    $featuredTabBtn.trigger('click');
                }

                $('#jqvmap1_' + targetCountry.code.toLowerCase() + '_pin img').css('opacity', 1);

                chosenCountry = targetCountry;

                return false;
            }
        });

        $wmap.on('click', function(event) {
            if (chosenCountry) {
                var x = (event.pageX - $wmap.offset().left) - 13;
                var y = (event.pageY - $wmap.offset().top) - 25;
                var cc = chosenCountry.code.toLowerCase();

                $('#jqvmap1_' + cc + '_pin').css({ top: y, left: x });
            }
        });

        var btnFilterMapArr = [];
        $('.btn-filter-map').on('click', function () {
            $('.jqvmap-pin img').css('opacity', 0);

            var i, item,
                dataCountries = $(this).attr('data-countries'),
                dataCat = $(this).attr('data-cat');

            // empty array
            btnFilterMapArr = [];

            if (dataCat !== 'all') {
                // convert string to object
                dataCountries = dataCountries.replace(/'/g, '"');
                dataCountries = JSON.parse(dataCountries);

                // add values to array
                for (item in dataCountries) {
                    btnFilterMapArr.push(dataCountries[item]);
                }

                $wmap.vectorMap('deselect', '');

                // select all new values
                for (i = 0; i < btnFilterMapArr.length; i++) {
                    $wmap.vectorMap('select', btnFilterMapArr[i]);
                }
            }
        });

        activeBtnFilterMap.click();
    }

    $('.signup-link').click(function (e) {
        e.preventDefault();
        $('#modal-login').modal('hide');
        setTimeout(function () {
            $('#modal-registration').modal('show');
        }, 500);
    });

    $('.accordeon-item h5').on('click', function () {
        $(this).find('i').toggleClass('active');
        $(this).next().stop().slideToggle('fast');
    });

    var seoWrapper = $('.seo-wrapper');
    var btnWrapper = $('.btn-open-seo');
    if(seoWrapper.outerHeight() <= 170) {
        btnWrapper.hide();
    } else {
        seoWrapper.addClass('collapse');
        btnWrapper.show();
    }
    btnWrapper.click(function () {
        seoWrapper.toggleClass("opened");

        if (seoWrapper.hasClass("opened")) {
            btnWrapper.text("Свернуть");
            seoWrapper.attr('aria-expanded', 'true');
        } else {
            btnWrapper.text("Показать еще");
            setTimeout(function () {
                seoWrapper.attr('aria-expanded', 'false');
            }, 20);
        }
    });
    seoWrapper.parent().removeClass('invisible');
});

function testimonialsChangeEnding() {
    $('.card--rating.card--rating__testimonials').each(function (index, element) {
        var elementText = $(element).find('strong').text();
        var elementTextLength = elementText.length;
        var elementTextLastNumber = elementText.charAt(elementTextLength - 1);
        if ((elementTextLastNumber == 0) || (elementTextLength >= 2 && elementTextLastNumber == 0) || (elementTextLastNumber >= 5 && elementTextLastNumber <= 9 && elementTextLength) || (elementTextLastNumber >= 0 && elementTextLastNumber <= 9 && parseInt(elementText) < 21)) {
            $(element).html('<span><strong>' + elementText + '</strong> отзывов</span>');
        }
        if (elementTextLastNumber == 1) {
            $(element).html('<span><strong>' + elementText + '</strong> отзыв</span>');
        } else {
            if ((elementTextLastNumber >= 2 && elementTextLastNumber <= 4 && parseInt(elementText) < 10) || (elementTextLastNumber >= 2 && elementTextLastNumber <= 4 && parseInt(elementText) > 20)) {
                $(element).html('<span><strong>' + elementText + '</strong> отзыва</span>');
            }
        }
    });
}

testimonialsChangeEnding();


// Create masonry layout  L O L  =)

var gridItems = $('.country-resorts--item');

var generateGridItemsSize = function (length) {
    if (length < 2) {
        gridItems.addClass('w-100');
    }
    if (length <= 2) {
        gridItems.each(function (index, element) {
            $(element).addClass('w-half-50');
        });
    }
    if (length === 3) {
        gridItems.each(function (index, element) {
            if (index === 0)
                $(element).addClass('w-half-50');
        });
    }
    if (length === 5) {
        gridItems.each(function (index, element) {
            if (index === 0)
                $(element).addClass('w-half-50');
            if (index === 4)
                $(element).addClass('w-75');
        });
    }
    if (length === 6) {
        gridItems.each(function (index, element) {
            if (index >= 4 && index < 6) {
                $(element).addClass('w-half-50');
            }
        });
    }
    if (length === 7) {
        gridItems.each(function (index, element) {
            if (index === 4)
                $(element).addClass('w-half-50');
        });
    }
    if (length === 8) {
        gridItems.each(function (index, element) {
            if (index === 2)
                $(element).addClass('w-half-50');
            if (index === 4)
                $(element).addClass('w-half-50');
            if (index === 7)
                $(element).addClass('w-75');
        });
    }
    if (length === 9) {
        gridItems.each(function (index, element) {
            if (index === 4)
                $(element).addClass('w-half-50');
            if (index >= 7)
                $(element).addClass('w-half-50');
        });
    }
    if (length === 10) {
        gridItems.each(function (index, element) {
            if (index === 4)
                $(element).addClass('w-half-50');
            if (index === 9)
                $(element).addClass('w-half-50');
        });
    }
    if (length >= 11) {
        gridItems.each(function (index, element) {
            if (index === 0 && length < 16)
                $(element).addClass('w-half-50');
            if (index === 5)
                $(element).addClass('w-half-50');
            if (index === 7 && length < 16)
                $(element).addClass('w-75');
            if (index === 8 && length > 12)
                $(element).addClass('w-half-50');
            if (index === 12 && length < 14)
                $(element).addClass('w-75');
            if (length === 14) {
                if (index === 12)
                    $(element).addClass('w-half-50');
            }
            if (length === 16) {
                if (index === 14 || index === 15)
                    $(element).addClass('w-half-50');
            }
            if (index === 16)
                $(element).addClass('w-half-50');
        });
    }
};

generateGridItemsSize(gridItems.length);

//-----------------------------------------  Directions page ----------------------------------------------------------
$('document').ready(function () {
    "use strict";
    var pageNumber = 1;

    function cutWaysSliderCities(swiperSlide) {
        var charsCitiesLimit = 106;
        $(swiperSlide).each(function (index, element) {
            var text = $(element).find('.card-body--desc').children('p').text();

            var a = $("<a class='ways-read-more'>Еще</a>");
            var href = $(element).find('.card-body--desc a').attr('href');
            $(a).attr('href', href);

            $(element).find('.card-body--desc a').hide();
            $(element).find('.card-body--desc p').html(text.substring(0, charsCitiesLimit) + '  ');
            $(element).find('.card-body--desc p').append(a);
        });
    }
    cutWaysSliderCities('.slider-popular-places .swiper-slide');
    cutWaysSliderCities('#region-countries .swiper-slide');

    $('#category-buttons button').on('click', function () {
        var categoryButtons = $('#category-buttons');
        var channelId = categoryButtons.data('channel');
        var categoryId = categoryButtons.find('button.active').data('cat');

        $.ajax({
            url: '/direction/countries-by-category',
            type: 'post',
            data: {
                channelId: channelId,
                categoryId: categoryId,
                pageNumber: 1
            },
            success: function (json) {
                var response = $.parseJSON(json);
                $('#region-countries').html(response.cards);

                if (response.pageCount > 1) {
                    $('#load-more').removeClass('hidden');
                } else {
                    $('#load-more').addClass('hidden');
                }
            },
            complete: function () {
                pageNumber = 1;

                cutWaysSliderCities('#region-countries .swiper-slide');
            }
        });
    });

    $('#load-more-button').on('click', function () {
        var categoryButtons = $('#category-buttons');
        var channelId = categoryButtons.data('channel');
        var categoryId = categoryButtons.find('button.active').data('cat');

        $.ajax({
            url: '/direction/countries-by-category',
            type: 'post',
            data: {
                channelId: channelId,
                categoryId: categoryId,
                pageNumber: pageNumber + 1
            },
            success: function (json) {
                var response = $.parseJSON(json);
                $('#region-countries').append(response.cards);

                ++pageNumber;

                if (response.pageCount > pageNumber) {
                    $('#load-more').removeClass('hidden');
                } else {
                    $('#load-more').addClass('hidden');
                }
            }
        });
    });

    $('#request-random-tour input').on('change', function () {
        $(this).validate();
    });

    $('#request-random-tour').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            data: $(this).serialize(),
            beforeSend: function() {
                $('#request-random-tour button').attr('disabled', true);
            },
            complete: function() {
                $('#request-random-tour button').attr('disabled', false);
            },
            success: function (json) {
                var response = $.parseJSON(json);
                if (response.type === 'success') {
                    $('#request-random-tour input').not('input[name=type]').val('');
                    $('#modal-send-request').modal('show');
                } else {
                    for (var input in response.message) {
                        $('input[name=' + input + ']').addClass('error');
                    }
                }
            }
        });
    });

    // Opened modal scroll fix for iOS + ReCaptcha positioning workaround
    var reCaptchaObservers = [];
    var mqlMd = matchMedia("(min-width: 768px)");
    var isIPhoneSm = navigator.userAgent.match(/iPhone|iPad|iPod/i) && $(window).width() === 320;

    function alignReCaptchaBox($el) {
        var $captchaTrigger = $('.modal.show .g-recaptcha');
        var offset = $captchaTrigger.offset();
        var bodyPosTop = -parseInt($('body').css('top')) || 0;
        var elHeight = $el.find('> div:last-child').height();

        $el.css('z-index', '20000000');

        if (mqlMd.matches) {
            var diff = $('.modal.show .modal-dialog').height() > ($(window).height() / 2) ? 30 : 0;
            var boxPosTop = (bodyPosTop + offset.top) - (elHeight / 2) - diff;
            $el.css('top', boxPosTop + 'px');
        } else {
            if (isIPhoneSm) {
                $el.css('transform', 'scale(0.9)');
                elHeight = $el.find('> div:last-child').height();
            }

            var computedBoxCenter = bodyPosTop + (($(window).height() - elHeight) / 2);
            $el.css('top', computedBoxCenter + 'px');
        }
    }

    $('.modal').on('show.bs.modal', function() {
        var scrollTop = $('html').scrollTop() || $('body').scrollTop();
        $('body').css('top', -scrollTop + 'px');

        var $reCaptchaPopups = $('body > div').filter(function(_, el) {
            return !el.classList.length;
        });

        $reCaptchaPopups.each(function(_, el) {
            var styleObserver = new MutationObserver(function(mutations) {
                var isPosAligned = false;

                mutations.forEach(function(mutation) {
                    var $el = $(el);

                    if ($el.is(':visible') && !isPosAligned) {
                        alignReCaptchaBox($el);
                        isPosAligned = true;
                    }
                });
            });

            styleObserver.observe(el, { attributes: true, attributeFilter: ['style'] });
            reCaptchaObservers.push(styleObserver);
        });
    });

    $('.modal').on('hidden.bs.modal', function() {
        var scrollTop = -parseFloat($('body').css('top'));
        $('body').css('top', 0);
        $('html, body').scrollTop(scrollTop);

        reCaptchaObservers.forEach(function(observer) {
            observer.disconnect();
        });
        reCaptchaObservers = [];
    });

    $.extend($.fn, {
        validate: function () {
            if ($(this).val().length < 2) {
                $(this).addClass('error');
                return false;
            } else {
                $(this).removeClass('error');
                return true;
            }
        }

    });
});

// form validation
$('document').ready(function () {
    "use strict"; 

    // form validation
    function checkValidation(event) {
        event.preventDefault();

        const {target} = event;

        if (target.checkValidity() === false) {
            event.stopPropagation();
        }
        
        $(target).addClass('was-validated');
    }


    $("#changePasswordForm").on("submit", (e) => {
        checkValidation(e);
    });

    // view modal
    function onFormSubmit(event) {
        const { currentTarget } = event;

        const isFormValid = currentTarget.checkValidity();

        if (isFormValid) {
            $.fancybox.open({
                src  : '#modal-buy-change-password',
	            type : 'inline',
            });
        }

    };
    
    $("#changePasswordForm").on("submit", (e) => {
        onFormSubmit(e);
    });
});


