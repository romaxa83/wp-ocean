var counterDone = false;

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    // MAP

    var filterTrg;
    var clickedTimes = 0;
    $('.btn-filter').click(function () {
        $('.btn-filter').removeClass('active');
        $(this).addClass('active');
        var btnIndex = $(this).index();
        var collapseElements = $('.current-tour--body');
        collapseElements.removeClass('active');
        $(collapseElements)
                .eq(btnIndex)
                .addClass('active');

        // show map on click

        if ($('#map').length && btnIndex == 3) {
            clickedTimes++;
            if (clickedTimes == 1) {
                var coordinates = [$('#map-lat').text(), $('#map-lng').text()];
                var address = $('#map-address').text();
                var mymap = L.map('map').setView(coordinates, 12);
                L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiaS13YW5uYS1tYXAiLCJhIjoiY2prbWJldW1tMDVyODNrcWx6eDZrMTgwdiJ9.gEihKYskaAQ_Aravq3M2sw',
                        {
                            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                            maxZoom: 18,
                            id: 'mapbox.streets',
                            style: 'mapbox://styles/mapbox/streets-v9',
                            accessToken: 'pk.eyJ1IjoiaS13YW5uYS1tYXAiLCJhIjoiY2prbWJldW1tMDVyODNrcWx6eDZrMTgwdiJ9.gEihKYskaAQ_Aravq3M2sw'
                        }
                ).addTo(mymap);
                var redIcon = L.icon({
                    iconUrl: '/img/icons/map-marker.png',
                    iconSize: [13, 24]
                });
                L.marker(coordinates, {icon: redIcon}).addTo(mymap).bindPopup(address).openPopup();
            }
        }
    });

    /*
     *  hamburger effect
     */

    $('.hamburger').click(function(e) {
        e.stopPropagation();
        $(this).toggleClass('is-active');
        // $('html, body').toggleClass('no-overflow');
        $('.mobile-menu').toggleClass('opened');
        if ($('.header').hasClass('opened-menu')) {
            $('.header').removeClass('opened-menu');
            $('.overlay').removeClass('opened');
            $('body').removeClass('fixed-body');
        } else {
            $('.header').addClass('opened-menu');
            $('.overlay').addClass('opened');
            $('body').addClass('fixed-body');
        }
        $(window).on('click', removeWindowMenu);
    });

    $('.mobile-menu').on('click touch', function(e) {
        e.stopPropagation();
    });

    function removeWindowMenu() {
        $('body')
            .find('.mobile-menu')
            .removeClass('opened');
        // $('html, body').removeClass('no-overflow');
        $('.hamburger').removeClass('is-active');
        if ($('.header').hasClass('opened-menu')) {
            $('.header').removeClass('opened-menu');
            $('.overlay').removeClass('opened');
        } else {
            $('.header').addClass('opened-menu');
            $('.overlay').addClass('opened');
        }

        $(window).off('click', removeWindowMenu);
    }

    $('.overlay').click(function() {
        $('body').removeClass('fixed-body');
    });


    /*
     *  Swiper initialization for testimonials
     */
    var searcFormSwiper = null;
    var testimonialsSwiper = null;
    var salesSwiper = null;
    var counterSwiper = null;
    var testimonialsConfig = {
        slidesPerView: 4,
        speed: 900,
        pagination: {
            el: '.swiper-pagination.testimonial-pagination',
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
                slidesPerView: 'auto',
                spaceBetween: 26,
                loop: true,
                centeredSlides: true
            }
        }
    };

    //sales card swiper slider
    var salesThumbsConfig = {
        slidesPerView: 'auto',
        // spaceBetween: 10,
        // allowTouchMove: true,
        centeredSlides: true,
        loop: true
                // breakpoints: {
                // 	413: {
                // 		direction: 'horizontal',
                // 		slidesPerView: 'auto'
                // 	}
                // }
    };

    //counter swiper slider
    var counterSwiperConfig = {
        slidesPerView: 'auto',
        centeredSlides: true,
        loop: true
                // breakpoints: {
                // 	413: {
                // 		direction: 'horizontal',
                // 		slidesPerView: 'auto'
                // 	}
                // }
    };

    testimonialsSwiper = new Swiper(
            '.swiper-container.testimonial-container',
            testimonialsConfig
            );

    if ($(window).width() < 992) {
        salesSwiper = new Swiper(
                '.swiper-container.sales-container',
                salesThumbsConfig
                );
    }
    if ($(window).width() < 576) {
        counterSwiper = new Swiper(
                '.swiper-container.counter-container',
                counterSwiperConfig
                );
    }

    var mqlLg = matchMedia('(min-width: 992px)');
    var mqlMd = matchMedia('(min-width: 768px)');
    var mqlSm = matchMedia('(min-width: 576px)');
    mqlLg.addListener(function (mql) {
        if (!mql.matches) {
            salesSwiper = new Swiper(
                    '.swiper-container.sales-container',
                    salesThumbsConfig
                    );
        } else {
            salesSwiper.destroy();
        }
    });
    mqlMd.addListener(function (mql) {
        testimonialsSwiper.destroy();
        testimonialsSwiper = new Swiper(
                '.swiper-container.testimonial-container',
                testimonialsConfig
                );
    });
    mqlSm.addListener(function (mql) {
        if (!mql.matches) {
            counterSwiper = new Swiper(
                    '.swiper-container.counter-container',
                    counterSwiperConfig
                    );
        } else {
            counterSwiper.destroy();
        }
    });

    /*
     *  Sticky header
     */

    $(window).on('scroll', function (e) {
        var sticky = $('header'),
                scroll = $(window).scrollTop();

        if ($('.counter').length) {
            counter = $('.counter').offset().top - $(window).height() / 1.3;
        } else {
            counter = '';
        }

        if (scroll >= 800) {
            $('body').addClass('sticky-header');
            sticky.addClass('sticky-header');
        } else {
            $('body').removeClass('sticky-header');
            sticky.removeClass('sticky-header');
        }

        if (scroll >= counter && !counterDone) {
            $('.counter-col--header').numScroll();
            counterDone = true;
        }
    });

    /*
     *	Counter
     */

    $('.counter-col--header').numScroll();

    //Tour card swiper slider
    var galleryThumbsConfig = {
        direction: 'vertical',
        slidesPerView: 3,
        spaceBetween: 4,
        touchRatio: 0.2,
        slideToClickedSlide: true,
        allowTouchMove: true,
        centeredSlides: true,
        breakpoints: {
            413: {
                direction: 'horizontal',
                slidesPerView: 'auto'
            }
        }
    };

    var galleryTopConfig = {
        slidesPerView: 1,
        allowTouchMove: false
    };

    var galleryThumbs = new Swiper('.gallery-thumbs', galleryThumbsConfig);
    var galleryTop = new Swiper('.gallery-top', galleryTopConfig);

    $('.gallery-thumbs .swiper-slide').on('click', function() {
        $('.gallery-thumbs .swiper-slide').removeClass('active');
        $(this).addClass('active');
        var index = parseInt($(this).attr('data-index')) - 1;
        var dataSrc = $(this).attr('data-src');
        var dataAlt = $(this).attr('alt');
        var target = $('.swiper-container.gallery-top .swiper-slide img');
        $(target).attr('src', dataSrc).attr('alt', dataAlt);
    });

    var allPhoto = $('.swiper-container.gallery-thumbs .all-photo');
    var allPhotoToggler = false;

    function showAllPhotos(e) {
        e.preventDefault();
        allPhoto.hide();
        $(
                '.swiper-container.gallery-top .swiper-slide, .swiper-container.gallery-thumbs .swiper-slide'
                ).removeClass('d-none');
        allPhotoToggler = !allPhotoToggler;
        galleryThumbs = new Swiper('.gallery-thumbs', galleryThumbsConfig);
    }
    allPhoto.click(showAllPhotos);

    /*
     *	Breakpoint min-width 992px
     */

    var breakpoint = window.matchMedia('(min-width: 992px)');
    var aboutSwiperSlider = void 0;

    var showSwiperSlider = function showSwiperSlider() {
        if (breakpoint.matches === true) {
            if (aboutSwiperSlider !== undefined) {
                aboutSwiperSlider.destroy(true, true);
            }
            return;
        } else if (breakpoint.matches === false) {
            return enableAboutSwiper();
        }
    };

    var enableAboutSwiper = function enableAboutSwiper() {
        aboutSwiperSlider = new Swiper('.about-col.swiper-container', {
            slidesPerView: 'auto',
            speed: 900,
            spaceBetween: 25,
            loop: true,
            centeredSlides: true,
            breakpoints: {
                320: {
                    spaceBetween: 10,
                }
            }
        });
    };

    breakpoint.addListener(showSwiperSlider);
    showSwiperSlider();

    // Scroll magic animation
    // initialize Scroll Magic controller
    var scrollMagicController = new ScrollMagic.Controller();

    // Init scene for each element, add animation for lines and section headers
    for (var i = 1; i <= $('.section').length; i++) {
        var cls = '#line-';
        new ScrollMagic.Scene({
            triggerElement: cls + i,
            triggerHook: 0.9
        })
                .setClassToggle('#animate' + i, 'active')
                .addTo(scrollMagicController);
        new ScrollMagic.Scene({
            triggerElement: cls + i,
            triggerHook: 0.85
        })
                .setClassToggle(cls + i, 'active')
                .addTo(scrollMagicController);
    }

    // btn-animate
    var btnAnimateScene = new ScrollMagic.Scene({
        triggerElement: '.testimonial-pagination',
        triggerHook: 0.9
    })
            .setTween('.btn-animate-testimonial', {
                transform: 'translateY(0)',
                opacity: '1'
            })
            .addTo(scrollMagicController);

    // animation for section about
    var triggerCol = '.about-col';
    var triggerColHook = 0.9;

    new ScrollMagic.Scene({
        triggerElement: triggerCol,
        triggerHook: triggerColHook
    })
            .setTween('.about-col', {
                transform: 'translateX(0)',
                opacity: '1'
            })
            .addTo(scrollMagicController);

    new ScrollMagic.Scene({
        triggerElement: triggerCol,
        triggerHook: triggerColHook
    })
            .setTween('.hidden-991', {
                transform: 'translateY(0)',
                opacity: '1'
            })
            .addTo(scrollMagicController);

    new ScrollMagic.Scene({
        triggerElement: '.col-info-animate',
        triggerHook: triggerColHook
    })
            .setTween('.col-info-animate', {
                transform: 'translateY(0)',
                opacity: '1'
            })
            .addTo(scrollMagicController);

    var circleMagicController = new ScrollMagic.Controller();
    var circlesScene = new ScrollMagic.Scene();

    for(var i = 0; i < $('.circle').length; i++) {
        var element = 'circle_' + i;
        $('.circle').eq(i).attr('id', element);
        circlesScene = new ScrollMagic.Scene({
            triggerElement: '.section-smart',
            triggerHook: 0.9
        })
            .setClassToggle('#circle_' + i, 'with-progress')
            .addTo(circleMagicController);
    }

    // breakpoint
    var cardsScrollMagicController = new ScrollMagic.Controller();
    var cardSizemScene1 = new ScrollMagic.Scene();
    var cardSizemScene2 = new ScrollMagic.Scene();
    var cardSizesScene = new ScrollMagic.Scene();
    var wayAnimateScene1 = new ScrollMagic.Scene();
    var wayAnimateScene2 = new ScrollMagic.Scene();

    var cardsBreakpoint = window.matchMedia('(min-width: 992px)');

    var cardsEnableAnime = function cardsEnableAnime() {
        if (cardsBreakpoint.matches === true) {
            cardSizemScene1 = new ScrollMagic.Scene({
                // triggerElement: '.row-cards',
                triggerElement: '.sales-container .swiper-wrapper',
                triggerHook: 1,
                duration: 600
            })
                    .setTween('.col-card-animate-1', {
                        transform: 'translateX(0)',
                        opacity: '1'
                    })
                    .addTo(cardsScrollMagicController);

            cardSizemScene2 = new ScrollMagic.Scene({
                // triggerElement: '.row-cards',
                triggerElement: '.sales-container .swiper-wrapper',
                triggerHook: 1,
                duration: 600
            })
                    .setTween('.col-card-animate-2', {
                        transform: 'translateX(0)',
                        opacity: '1'
                    })
                    .addTo(cardsScrollMagicController);

            cardSizesScene = new ScrollMagic.Scene({
                // triggerElement: '.row-cards',
                triggerElement: '.sales-container .swiper-wrapper',
                triggerHook: 0.35,
                duration: 600
            })
                    .setTween('.card-animate-s', {
                        transform: 'translateY(0)'
                    })
                    .addTo(cardsScrollMagicController);

            wayAnimateScene1 = new ScrollMagic.Scene({
                triggerElement: '.ways-row',
                triggerHook: 1,
                duration: 1200
            })
                    .setTween('.way-animate-1', {
                        transform: 'translateY(-30px)'
                    })
                    .addTo(scrollMagicController);

            wayAnimateScene2 = new ScrollMagic.Scene({
                triggerElement: '.ways-row',
                triggerHook: 1,
                duration: 2000
            })
                    .setTween('.way-animate-2', {
                        transform: 'translateY(-25px)'
                    })
                    .addTo(scrollMagicController);
        } else {
            cardSizemScene1.destroy(true);
            cardSizemScene1 = null;
            $('.col-card-animate-1').removeAttr('style');
            cardSizemScene2.destroy(true);
            cardSizemScene2 = null;
            $('.col-card-animate-2').removeAttr('style');

            cardSizesScene.destroy(true);
            cardSizesScene = null;
            $('.card-animate-s').removeAttr('style');

            wayAnimateScene1.destroy(true);
            wayAnimateScene1 = null;
            $('.way-animate-1').removeAttr('style');
            wayAnimateScene2.destroy(true);
            wayAnimateScene2 = null;
            $('.way-animate-2').removeAttr('style');
        }
    };
    cardsBreakpoint.addListener(cardsEnableAnime);
    cardsEnableAnime();

    // breakpoint
    var parallaxController = new ScrollMagic.Controller();
    var parallax1 = new ScrollMagic.Scene();
    var parallax2 = new ScrollMagic.Scene();
    var parallax3 = new ScrollMagic.Scene();

    // var parallaxBreakpointFirst = window.matchMedia('(min-width: 1730px)');
    var parallaxBreakpointFirst = window.matchMedia('(min-width: 992px)');

    var parallaxBreakpointEnableFirst = function parallaxBreakpointEnableFirst() {
        if (parallaxBreakpointFirst.matches === true) {
            parallax1 = new ScrollMagic.Scene({
                triggerElement: '.section-counter',
                triggerHook: 1,
                duration: 2000
            })
                    .setTween('.counter', {
                        backgroundPositionY: '-80px' // best for screen > 1800px -209px
                    })
                    .addTo(parallaxController);

            parallax2 = new ScrollMagic.Scene({
                triggerElement: '.section-advantages',
                triggerHook: 1,
                duration: 2000
            })
                    .setTween('.advantages', {
                        backgroundPositionY: '-165px' // best for screen > 1800px -227px
                    })
                    .addTo(parallaxController);

            parallax3 = new ScrollMagic.Scene({
                triggerElement: '.section-testimonials',
                triggerHook: 1,
                duration: 2000
            })
                    .setTween('.testimonials', {
                        backgroundPositionY: '-185px' // best for screen > 1800px -318px;
                    })
                    .addTo(parallaxController);
        } else if (parallaxBreakpointFirst.matches === false) {
            parallax1.destroy(true);
            parallax1 = null;
            $(parallax1).removeAttr('style');
            parallax2.destroy(true);
            parallax2 = null;
            $(parallax2).removeAttr('style');
            parallax3.destroy(true);
            parallax3 = null;
            $(parallax3).removeAttr('style');
        }
    };

    parallaxBreakpointFirst.addListener(parallaxBreakpointEnableFirst);
    parallaxBreakpointEnableFirst();

    var showChar = 380;
    var ellipsestext = '...';

    $('.truncate').each(function() {
        var content = $(this).html();
        if (content.length > showChar) {
            $('.moreless').show();
            var c = content.substr(0, showChar);
            var h = content;
            var html =
                '<div class="truncate-text" style="display:block">' +
                c +
                '<span class="moreellipses">' +
                ellipsestext +
                '&nbsp;&nbsp;<a href="#" class="moreless">Eще</a></span></div><div class="truncate-text" style="display:none">' +
                h +
                '</div>';

            $(this).html(html);
        }
    });

    $('.moreless').click(function (e) {
        e.preventDefault();
        var thisEl = $(this);
        var cT = thisEl.closest('.truncate-text');
        var tX = '.truncate-text';

        if (thisEl.hasClass('less')) {
            cT.prev(tX).toggle();
            cT.fadeToggle();
        } else {
            cT.toggle();
            cT.next(tX).fadeToggle();
        }
        return false;
    });

    $('.btn-open-seo').click(function() {
        var hiddenContent = $('.hidden-content'),
            hiddenContentBtn = $(this),
            parentSeo = $('.seo-wrapper');
        parentSeo.toggleClass('opened');
        hiddenContent.toggleClass('opened').slideToggle();
        hiddenContent.hasClass('opened')
            ? hiddenContentBtn.text('Свернуть')
            : hiddenContentBtn.text('Показать еще');
    });

    var videoPlayIcon = $('.about-video img'); // element trigger click
    var trgVideo = $('#video'); // target video
    var target = $('.modal.modal-video'); // target modal
    var source = $('<source type="video/mp4">'); // create element inside video

    function showVideoModal() {
        var link = $(this)
                .parents('.about-video')
                .attr('data-link');
        if (link != '') {
            target.modal('show');
            target.on('shown.bs.modal', function () {
                source.attr('src', link);
                trgVideo.html(source);
                trgVideo.trigger('load');
                trgVideo.trigger('play');
            });
        } else {
            alert('Видео отсутствует!');
        }
    }

    videoPlayIcon.on('click touch', showVideoModal);

    target.on('hidden.bs.modal', function () {
        trgVideo.html(''); // empty video
    });

    $('input[type=tel]').mask('+00 (000) 000 00 00');
});
