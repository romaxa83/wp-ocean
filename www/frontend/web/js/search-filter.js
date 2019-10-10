var protocol = location.protocol;
var slashes = protocol.concat("//");
var port = location.port;
var path = $("body").data("url");
var host = port ? slashes.concat(window.location.hostname) + ":" + port : slashes.concat(window.location.hostname);

var scrollBarsUpdating = null;

$(document).ready(function () {
    var $priceMin = $('input[name="priceMin"]');
    var $priceMax = $('input[name="priceMax"]');

    var filter_min_price = $priceMin.data('value') || $priceMin.data('defaultValue') || 0;
    var filter_max_price = $priceMax.data('value') || $priceMax.data('defaultValue') || 0;
    var filter_min_price_value = $priceMin.val() || 0;
    var filter_max_price_value = $priceMax.val() || 0;

    /*
     *   Search country select, on open add perfect scrollbar
     */

    var searchSelectScrollbar;
    var ksk = {
        wheelPropagation: false,
        minScrollbarLength: 20,
        wheelSpeed: 1
    };

    $(".search-select").select2({dropdownAutoWidth: true})
            .on("select2:open", function () {
                var obj = $(this).attr('id');

                var $select = $(this).get(0);
                $(this).closest(".filter-items__header").append($(".select2-container").last()[0]);

                setTimeout(function () {
                    if (typeof searchSelectScrollbar === 'undefined') {
                        searchSelectScrollbar = new PerfectScrollbar('.select2-results__options', ksk);
                    } else {
                        searchSelectScrollbar.update();
                    }
                }, 250);
                $(".select2-results__options").each(function () {
                    setTimeout(function () {
                        if (obj == 'filterCountryInput')
                            $('.select2-container--default .select2-results__option:nth-child(-n+' + (parseInt($('#filterCountryInput').parent().data('priority')) - 1) + ')').css('background-color', '#ddd');

                        if (typeof searchSelectScrollbar === 'undefined') {
                            searchSelectScrollbar = new PerfectScrollbar('.select2-results__options', ksk);
                        } else {
                            searchSelectScrollbar.update();
                        }
                    }, 250);
                });
            });

    /*
     *   Mobile select
     */

    $(".mobile-shadow-select").change(function () {
        var sourcename = $(this).attr("data-sourcename");
        if (sourcename) {
            $('select[name="' + sourcename + '"]').val($(this).val()).trigger("change");
        } else {
            $(this).siblings("select").val($(this).val()).trigger("change");
        }
    });

    /*
     *   Custom select - select cities
     */

    var customTimeSelect = $(".custom-select").select2({
        minimumResultsForSearch: Infinity,
        dropdownAutoWidth: true
    });

    function initCustomSelectScrollbar($select) {
        $(".select2-results__options").each(function () {
            if (typeof $select.__psScroll__ === 'undefined') {
                $select.__psScroll__ = new PerfectScrollbar($(this)[0], {
                    wheelPropagation: true,
                    scrollingThreshold: "100",
                    wheelSpeed: 1
                });
            }

            $select.__psScroll__.update();
        });
    }

    customTimeSelect.on("select2:open", function () {
        var $select = $(this).get(0);
        $(this).closest(".filter-items__header").append($(".select2-container").last()[0]);
        setTimeout(initCustomSelectScrollbar.bind(this, $select), 0);
    });

    var fromMax = 0;
    var toMax = 0;

    $('select[name="filterDaysFrom"]').on('change', function () {
        var val = parseInt($(this).val());
        var range = parseInt($('.length-range').data('range'));
        toMax = val + range;
        var filterDaysTo = parseInt($('select[name="filterDaysTo"]').val());
        if (filterDaysTo < val) {
            $('select[name="filterDaysTo"]').val(val).trigger('change');
        }
        if (val < fromMax) {
            $('select[name="filterDaysTo"]').val(toMax).trigger('change');
        }
    });

    $('select[name="filterDaysTo"]').on('change', function () {
        var val = parseInt($(this).val());
        var range = parseInt($('.length-range').data('range'));
        fromMax = val - range;
        var filterDaysFrom = parseInt($('select[name="filterDaysFrom"]').val());
        if (val < filterDaysFrom) {
            $(this).val(filterDaysFrom).trigger('change');
        }
        if (filterDaysFrom < fromMax) {
            $('select[name="filterDaysFrom"]').val(fromMax).trigger('change');
            return true;
        }
        if (toMax != 0 && val > toMax) {
            $(this).val(toMax).trigger('change');
        }
    });

    /*
     *   Init PS for next elements: ->
     */

    var containerCountry = $("#filterCountry")[0];
    var containerCity = $("#filterCity")[0];
    var containerPeople = $("#filterPeople")[0];
    var containerHotelRooms = $("#filterHotelRoom")[0];
    var containerResorts = $(".resort-checkboxes")[0];
    var containerHotels = $(".hotels-checkboxes")[0];
    var containerCatHotels = $(".category-hotels-checkboxes")[0];
    var containerDays = $("#filterDays")[0];
    var tourTestimonialsContainer = $(".row.row-tour-testimonials")[0];

    var ps_filterCountry =
            containerCountry &&
            new PerfectScrollbar(containerCountry, {
                scrollingThreshold: "100",
                wheelPropagation: false
            });
    var ps_filterCity =
            containerCity &&
            new PerfectScrollbar(containerCity, {
                scrollingThreshold: "100",
                wheelPropagation: false
            });
    var ps_filterHotelRooms =
            containerHotelRooms &&
            new PerfectScrollbar(containerHotelRooms, {
                scrollingThreshold: "100",
                wheelPropagation: false
            });
    var ps_filterPeople =
            containerPeople &&
            new PerfectScrollbar(containerPeople, {
                scrollingThreshold: "100",
                wheelPropagation: false
            });
    var ps_filterResorts =
            containerResorts &&
            new PerfectScrollbar(containerResorts, {
                scrollingThreshold: "100",
                wheelPropagation: false
            });
    var ps_filterHotels =
            containerHotels &&
            new PerfectScrollbar(containerHotels, {
                scrollingThreshold: "100",
                wheelPropagation: false
            });
    var ps_filterCatHotels =
            containerCatHotels &&
            new PerfectScrollbar(containerCatHotels, {
                scrollingThreshold: "100",
                wheelPropagation: false
            });
    var ps_filterDays =
            containerDays &&
            new PerfectScrollbar(containerDays, {
                scrollingThreshold: "100",
                wheelPropagation: false
            });
    var ps_tourTestimonials = "";
    ps_tourTestimonials =
            tourTestimonialsContainer &&
            new PerfectScrollbar(".row.row-tour-testimonials", {
                scrollingThreshold: "100",
                minScrollbarLength: 20
            });
    ps_tourTestimonials && ps_tourTestimonials.update();

    var ps_childScollArray = [];
    ps_filterCountry && ps_filterCountry.update();
    ps_filterCity && ps_filterCity.update();
    ps_filterHotelRooms && ps_filterHotelRooms.update();
    ps_filterResorts && ps_filterResorts.update();
    ps_filterHotels && ps_filterHotels.update();
    ps_filterCatHotels && ps_filterCatHotels.update();
    ps_filterDays && ps_filterDays.update();
    var $additionalText = $(".additional-filter__text"),
            additionalTextClosed = "Скрыть дополнительные параметры",
            additionalTextOpened = "Показать дополнительные параметры";

    /*
     * filter form dropdowns
     */

    scrollBarsUpdating = function scrollBarsUpdating() {
        setTimeout(function () {
            ps_filterCountry && ps_filterCountry.update();
            ps_filterCity && ps_filterCity.update();
            ps_filterResorts && ps_filterResorts.update();
            ps_filterHotelRooms && ps_filterHotelRooms.update();
            ps_filterHotels && ps_filterHotels.update();
            ps_filterPeople && ps_filterPeople.update();
            ps_filterCatHotels && ps_filterCatHotels.update();
            ps_filterDays && ps_filterDays.update();
            ps_tourTestimonials && ps_tourTestimonials.update();
        }, 10);
    }

    $('body').on('input', '.filter-items__item_country .select2-search__field', function () {
        $(".select2-results__options").each(function () {
            const ps123 = new PerfectScrollbar($(this)[0]);
            setTimeout(function () {
                ps123.update();
            }, 0);
        });
    });

    $(".btn-filter").click(function () {
        scrollBarsUpdating();
    });

    function filterChecking() {
        if ($(window).width() < 768) {
            return;
        }

        // check if the filter is empty
        var notEmptyInputs = 0;
        $(".filter-items__item_country .filter-items__header select").each(function (e) {
            if ($(this).val() != "") {
                notEmptyInputs++;
            }
        });

        if (notEmptyInputs === 0) {
            // $(".section-search").addClass("animation-on");
            $(".filter-form-wrapper").removeClass("opened");
        } else {
            // $(".section-search").removeClass("animation-on");
            $(".filter-form-wrapper").addClass("opened");
        }
    }

    // var dateToday = $("#filterDateFrom").data("value") ? new Date($("#filterDateFrom").data("value")) : new Date();
    var dateToday = new Date();
    var tempDateToday = new Date(dateToday);
    var tempEndDate;
    var endPickedDate;

    tempEndDate = tempDateToday.setDate(tempDateToday.getDate() + 14);
    endPickedDate = tempDateToday.setDate(tempDateToday.getDate() + 14);
    tempEndDate = new Date(tempEndDate);
    endPickedDate = new Date(endPickedDate);

    $(".btn-filter-reset, .reset-filter, .reset-filter-styled").on("click", function (event) {
        event.preventDefault();

        // Category field
        var defaultCategoryId = $('.category-hotels.filter-items__item').data('defaultId');
        $('.category-hotels input[type="checkbox"]:checked').click();
        $('.category-hotels .checkboxes-wrapper input[type="checkbox"]:checked').each(function () {
            $(this).click();
        });

        if (defaultCategoryId) {
            var $targetCategory = $('.category-hotels .checkboxes-wrapper input').eq(defaultCategoryId - 1);
            $targetCategory.click();
        }

        // Nutrition field
        if ($('#filterNutrition').length) {
            $('#filterNutrition input[type="checkbox"]:checked').click();
            $('#filterNutrition .checkboxes-wrapper input[type="checkbox"]:checked').each(function () {
                $(this).click();
            });

            var defaultNutritionId = $('.nutrition.filter-items__item').data('defaultId');

            if (defaultNutritionId) {
                var $targetNutrition = $('#' + defaultNutritionId);
                $targetNutrition.click();
            }
        }
        setTimeout(filterChecking, 200);
        $(".filter-age-dropdown").remove();
        
        var $adultsCounter = $('.filter-items__item_people [name="adultsCounter"]');
        var $childrenCounter = $('.filter-items__item_people [name="childrenCounter"]');
        var adultsDefaultValue = $adultsCounter.data('defaultValue');

        $(".filter-items__item_people .filter-items__title").text(adultsDefaultValue + " взр.");
        $adultsCounter.val(adultsDefaultValue);
        $childrenCounter.val(0);

        // Price field
        var $priceMin = $('#price_min');
        var $priceMax = $('#price_max');

        var priceMinValue = $priceMin.data('defaultValue');
        var priceMaxValue = $priceMax.data('defaultValue');

        var $slider = $("#slider-price");
        $slider.slider("values", 0, priceMinValue);
        $slider.slider("values", 1, priceMaxValue);

        $priceMin.val(priceMinValue);
        $priceMax.val(priceMaxValue);

        // Currency field
        var $currency = $('.filter-items__item_currency [name="filterCurrency"]');
        var defaultCurrencyValue = $currency.data('defaultValue');
        var $targetCurrency = $(".filter-items__item_currency .filter-dropdown-list__item .filter-dropdown-list__link")
            .filter(function(_, elem) {
                return $(elem).text() === defaultCurrencyValue;
            });

        $targetCurrency.click();

        // Nights field
        setTimeout(function () {
            $(".filter-items__item_time select").each(function(_, elem) {
                var $elem = $(elem);
                $elem.val($elem.data('defaultValue')).trigger("change");
            });
        }, 0);

        // Country field
        var defaultCountryId = $('.filter-items__item_country').data('defaultId');

        $(".filter-items__item_country .country-select").each(function () {
            $(this).find('option:selected').removeAttr('selected');

            var $options = $(this).find('option');
           
            for (var i = 0; i < $options.length; i++) {
                var $currOption = $($options[i]);
                var countryId = $currOption.data('id');

                if (countryId === defaultCountryId) {
                    $(this).val($currOption.prop('value'));
                    break;
                }
            }

            $(this).trigger("change");
       });

        // City field
        var defaultCityId = $(".filter-items__item_city").data('defaultId');
        var defaultCityValue = $('select[name="filterCity"] option[data-id="' + defaultCityId + '"]').prop('value');

        if (defaultCityValue) {
            $(".filter-items__item_city .custom-select").val(defaultCityValue).trigger("change");
        }

        // Date field
        var $filterDateFrom = $('#filterDateFrom');
        var $filterDateTo = $('#filterDateTo');

        $([$filterDateFrom, $filterDateTo]).daterangepicker(daterangepickerconfig, datarangepickercb);

        $filterDateFrom.val($filterDateFrom.data('defaultValue'));
        $filterDateTo.val($filterDateTo.data('defaultValue'));

        // Resorts Field
        var $filterResorts = $('.category-resorts.filter-items__item');
        var defaultResortId = $filterResorts.data('defaultId');

        if (defaultResortId) {
            var $defaultResort = $('#' + defaultResortId);
            $defaultResort.prop('checked', true);
        }

        // Hotel field
        $('.hotels-checkboxes input[type="checkbox"]:checked').click();
        $('.hotels-checkboxes .checkboxes-wrapper input[type="checkbox"]:checked').each(function () {
            $(this).click();
        });

        setTimeout(function() {
            var defaultHotelId = $('.category-hotels-titles.filter-items__item').data('defaultId');
            
            if (defaultHotelId) {
                var $defaultHotel = $('#' + defaultHotelId);
                $defaultHotel.click();
            }
        }, 1500);
    });

    $(".btn-filter-type").click(function () {
        var filterType = $(this).data("type");
        $("#filterTypeInput").val(filterType);
    });

    $(".filter-items__header").click(function () {
        scrollBarsUpdating();

        $(".filter-form-wrapper").addClass("opened");

        $(this).toggleClass("opened");

        var dropDownData = $(this).data("drop-header");
        var dropDown = $("#" + dropDownData + "");
        if (dropDown.hasClass("opened")) {
            dropDown.removeClass("opened");
        } else {
            dropDown.addClass("opened");
        }
        $(window).on("mousedown", windowRemoveEvent);
    });

    $(".filter-dropdown").on("click", ".filter-items__header", function () {
        var state = $(this).hasClass("opened");
        $(".filter-form-wrapper").addClass("opened");

        // hide all opened dropdowns if they are visible
        $(".dropdown-input.filter-items__header").removeClass("opened");
        $(".dropdown-small.filter-dropdown-wrapper").removeClass("opened");

        // toggle class on clicked element
        $(this).toggleClass("opened", !state);
        $(this)
                .next()
                .toggleClass("opened", !state);

        var dropDownData = $(this).data("drop-header");
        var dropDown = $("#" + dropDownData + "");

        $(window).on("mousedown", windowRemoveEvent);

        if ($(".filter-age-dropdown").length > 0) {
            ps_childScollArray.forEach(function (elementOfScrollBar) {
                elementOfScrollBar.update();
            });

            scrollBarsUpdating();
        }
    });

    function windowRemoveEvent(e) {
        if (!$(e.target).closest(".full-filter").length) {
            filterChecking();
            $(".filter-items__header").removeClass("opened");
            $(window).off("mousedown", windowRemoveEvent);
            $(".ui-datepicker").hide();
            $(".search-image__item-img img").addClass("filter-blur");
        }
    }

    /*
     *   Function as I understand works on click children element when choosing child's age
     */

    $(".filter-dropdown").on("click", ".filter-dropdown-list__link", function () {
        var linkText = $(this).text();
        var dropDownId = $(this).parents(".filter-dropdown-wrapper").attr("id");
        var parentHeader = $('.filter-items__header[data-drop-header="' + dropDownId + '"]');
        var hiddenInput = $('input[name="' + dropDownId + '"]');

        $('.filter-items__header[data-drop-header="' + dropDownId + '"] .filter-items__title').text(linkText);

        hiddenInput.val(linkText);
        $('.filter-items__header[data-drop-header="' + dropDownId + '"]').removeClass("opened");
        $("#" + dropDownId + "").removeClass("opened");

        filterChecking();
    });

    $(".js-states.form-control").on("change", function () {
        filterChecking();
    });

    $('.filter-items__item_currency').on('click', '.filter-dropdown-list__link', function () {
        $('input[name="filterCurrency"]').attr('value', $(this).text());
    });

    $("#filterCountryInput").on("change", function () {
        var value = $(this).val();
        var linkText = $(this).text();
        var dropDownId = $(this)
                .parents(".filter-dropdown-wrapper")
                .attr("id");
        var parentHeader = $('.filter-items__header[data-drop-header="' + dropDownId + '"]');
        var hiddenInput = $('input[name="' + dropDownId + '"]');
        $.post(host + "/site/get-data", {value: value}, function (data) {
            var data = JSON.parse(data);
            var resort = "";
            var hotels = "";
            if (data.city_active == '') {
                if (window.location.href.split('/')[5]) {
                    data.city_active = window.location.href.split('/')[5].split('?')[0].split(':');
                }
            } else {
                data.city_active = data.city_active.split(',');
            }
            data.hotel_active = data.hotel_active.split(',');
            for (var i in data.city) {
                resort +=
                        '<div class="checkbox" data-id="' + data.city[i][0] + '"><input type="checkbox" name="city[]" ' + (($.inArray(i, data.city_active) !== -1) ? 'checked' : '') + ' id="city-' +
                        i +
                        '" value="' +
                        i +
                        '"><label for="city-' +
                        i +
                        '"> ' +
                        data.city[i][1] +
                        " </label></div>";
            }
            for (var i in data.hotel) {
                hotels +=
                        '<div class="checkbox" data-id="' + data.hotel[i][0] + '" data-cat="' + data.hotel[i][2] + '"><input type="checkbox" name="hotel[]" ' + (($.inArray(i, data.hotel_active) !== -1) ? 'checked' : '') + ' id="hotel-' +
                        i +
                        '" value="' +
                        i +
                        '"><label for="hotel-' +
                        i +
                        '"> ' +
                        data.hotel[i][1] +
                        " </label></div>";
            }
            if (resort.length == 0) {
                resort = "Нет данных";
            }
            if (hotels.length == 0) {
                hotels = "Нет данных";
            }
            $(".resort-checkboxes")
                    .empty()
                    .append(resort);
            $(".hotels-checkboxes")
                    .empty()
                    .append(hotels);
            $('.filter-items__header[data-drop-header="' + dropDownId + '"] .filter-items__title').text(linkText);
            hiddenInput.val(linkText);
            $('.filter-items__header[data-drop-header="' + dropDownId + '"]').removeClass("opened");
            $("#" + dropDownId + "").removeClass("opened");
            filterChecking();
            scrollBarsUpdating();

                // preloader animation
            if ($("*").is(".loader-plane__path #way")) {
                var animePath = anime.path(".loader-plane__path #way");

                var planeTimeline = anime.timeline({
                    easing: 'linear',
                    duration: 5000,
                    loop: true,
                });

                planeTimeline.add({
                    targets: '.loader-plane__item',
                    translateX: animePath('x'),
                    translateY: animePath('y'),
                    rotate: animePath('angle'),
                }).add({
                    targets: '.loader-plane__path #rect',
                    translateX: [-250, 1969],
                    duration: 5635,
                    offset: 0,
                });

                var iconsAnimation = anime.timeline({
                    easing: "linear",
                    duration: 500,
                    loop: true,
                });

                iconsAnimation.add({
                    targets: '.loader-plane__cloud-left',
                    opacity: 1,
                    offset: 600
                }).add({
                    targets: '.loader-plane__cloud-mountains',
                    opacity: 1,
                }).add({
                    targets: '.loader-plane__cloud-left',
                    opacity: 0.4,
                }).add({
                    targets: '.loader-plane__cloud-centre',
                    opacity: 1,
                }).add({
                    targets: '.loader-plane__cloud-mountains',
                    opacity: 0.4,
                }).add({
                    targets: '.loader-plane__cloud-palms',
                    opacity: 1,
                }).add({
                    targets: '.loader-plane__cloud-centre',
                    opacity: 0.4,
                }).add({
                    targets: '.loader-plane__cloud-right',
                    opacity: 1,
                }).add({
                    targets: '.loader-plane__cloud-palms',
                    opacity: 0.4,
                }).add({
                    targets: '.loader-plane__cloud-right',
                    opacity: 0.4,
                });


                if (window.matchMedia("(max-width: 767px)").matches) {
                    var wrapperAnimate = anime.timeline({
                        easing: 'linear',
                        duration: 5000,
                        loop: true,
                    });

                    wrapperAnimate.add({
                        targets: '.loader-plane__wrapper',
                        translateX: -1968,
                        delay: 600
                    }).add({
                        targets: '.loader-plane__wrapper',
                        opacity: 0,
                        duration: 300,
                        offset: '-=1500'
                    });
                }
            }
            // preloader animation end


            if ($('#search-result').length && $('#search-result').text().length == 0) {
                var data = getDataFilter();
                $.ajax({
                    url: host + "/search/search-result",
                    type: "POST",
                    data: data,
                    beforeSend: function () {
                        $(".loader").removeClass("d-none");
                        planeTimeline.play();
                        iconsAnimation.play();

                        if (window.matchMedia("(max-width: 767px)").matches) {
                            wrapperAnimate.play();
                        }
                    },
                    success: function (data) {
                        $('#search-result').empty().append(data);
                        if ($('#search-result').find('.not-found').length) {
                            $('.request-widget').removeClass('d-none');
                        }
                        testimonialsChangeEnding();
                    },
                    complete: function () {
                        $(".loader").addClass("d-none");

                        planeTimeline.pause();
                        iconsAnimation.pause();

                        if (window.matchMedia("(max-width: 767px)").matches) {
                            wrapperAnimate.pause();
                        }
                    }
                });
            }
        });
    });

    /*
     *   Filter hotel search input
     */

    $("#filterHotelInput").on("keyup", function () {
        scrollBarsUpdating();
    });

    /*
     *    digit input arrows
     */

    peopleMessage();

    $(".input-plus").on("click", function () {
        var myInput = $(this).parent().find("input"),
                myInputValue = myInput.val();
        myInputValue++;
        myInput.val(myInputValue);

        if ($(this).closest(".children-counter-input").length > 0) {
            addNewChild(myInputValue);
        }

        peopleMessage();
    });
    $(".input-minus").on("click", function () {
        var myInput = $(this)
                .parent()
                .find("input"),
                myInputValue = myInput.val();
        minValue = myInput.data("min");

        if (myInputValue <= minValue) {
            return;
        } else {
            myInputValue--;
        }

        myInput.val(myInputValue);
        if ($(this).closest(".children-counter-input").length > 0) {
            removeChildFromFilter();
        }
        peopleMessage();
    });

    function peopleMessage() {
        var adultsInput = $("#adultsCounter").val(),
                childrenInput = $("#childrenCounter").val(),
                message = "";

        if (childrenInput != 0) {
            message = adultsInput + " взр. " + childrenInput + " дет.";
        } else {
            message = adultsInput + " взр. ";
        }

        $("#filterPeopleLink .filter-items__title").text(message);
    }

    $(".dropdown-input.digit-input").on("change", peopleMessage);

    $(".non-event").click(function (e) {
        e.stopPropagation();
    });

    function stopClick(e) {
        e.stopPropagation();
        e.preventDefault();
        $(".filter-items__item").off("click", ".filter-dropdown-wrapper", stopClick);
    }

    $(".filter-items__item").on("click", ".filter-dropdown-wrapper.ps--scrolling-y", stopClick);

    $(".filter-age-dropdown .filter-input-wrapper").on("click", function () {
        $(this).toggleClass("opened");
        var dropDownData = $(this).data("drop-header");
        var dropDown = $("#" + dropDownData + "");
        if (dropDown.hasClass("opened")) {
            dropDown.removeClass("opened").hide();
        } else {
            dropDown.addClass("opened").show();
        }
        $(window).on("mousedown", windowRemoveEvent);
        ps_filterCountry.update();
        setTimeout(function () {
            psDropDown.update();
        }, 0);
    });

    function addNewChild(childCounter) {
        var child =
                '<div class="filter-input filter-age-dropdown" id="filterChild_' +
                childCounter +
                '"> ' +
                '<p class="filter-input__label">Возраст</p>' +
                '<div class="filter-input-wrapper " >' +
                '<div class="dropdown-input  filter-items__header" data-drop-header="filterChildItem_' +
                childCounter +
                '">' +
                '<span class="filter-items__title">10 лет</span>' +
                '<span class="input-arrow input-minus"></span>' +
                '<input type="text" value="до 10 лет" name="filterChildItem_' +
                childCounter +
                '" class="hidden">' +
                "</div>" +
                '<div class="dropdown-small filter-dropdown-wrapper" id="filterChildItem_' +
                childCounter +
                '">' +
                '<ul class="filter-dropdown-list filter-dropdown-list_main">' +
                '<li class="filter-dropdown-list__item">' +
                '<span class="filter-dropdown-list__link">до 2 лет</span>' +
                "</li>" +
                '<li class="filter-dropdown-list__item">' +
                '<span class="filter-dropdown-list__link">3 года</span>' +
                "</li>" +
                '<li class="filter-dropdown-list__item">' +
                '<span class="filter-dropdown-list__link">4 года</span>' +
                "</li>" +
                '<li class="filter-dropdown-list__item">' +
                '<span class="filter-dropdown-list__link">5 лет</span>' +
                "</li>" +
                '<li class="filter-dropdown-list__item">' +
                '<span class="filter-dropdown-list__link">6 лет</span>' +
                "</li>" +
                '<li class="filter-dropdown-list__item">' +
                '<span class="filter-dropdown-list__link">7 лет</span>' +
                "</li>" +
                '<li class="filter-dropdown-list__item">' +
                '<span class="filter-dropdown-list__link">8 лет</span>' +
                "</li>" +
                '<li class="filter-dropdown-list__item">' +
                '<span class="filter-dropdown-list__link">9 лет</span>' +
                "</li>" +
                '<li class="filter-dropdown-list__item">' +
                '	<span class="filter-dropdown-list__link">10 лет</span>' +
                "</li>" +
                "</ul>" +
                "</div>" +
                "</div>" +
                "</div>";

        $(".children-age-inputs").append(child);
        var thisChild = $("#filterChildItem_" + childCounter);
        var thisChildScrollBar = new PerfectScrollbar(thisChild[0]);
        ps_childScollArray.push(thisChildScrollBar);

        scrollBarsUpdating();
    }

    var getDataChildrenAttr;
    var dataChildrenArray = $('input[name="childrenCounter"]');
    if (dataChildrenArray.length) {
        getDataChildrenAttr = $(dataChildrenArray).attr('data-children').split(',');

        if (getDataChildrenAttr.length > 0) {
            if (!isNaN(parseInt(getDataChildrenAttr[0]))) {
                $(getDataChildrenAttr).each(function (index, elem) {
                    addNewChild(index);
                });

                var filterChildItemsArr = $('.filter-inputs-wrapper.children-age-inputs .filter-input.filter-age-dropdown');
                $(filterChildItemsArr).each(function (ind, elem) {
                    $(elem).find('.filter-dropdown-list__item').eq(getDataChildrenAttr[ind] - 2).children().click();
                });
            }
        }
    }

    function removeChildFromFilter() {
        var childrenCounter = $(".filter-age-dropdown").length - 1;
        var lastChild = $(".filter-age-dropdown")[childrenCounter];

        if (lastChild) {
            $(".filter-age-dropdown").last().remove();
        }
    }

    $("#childrenCounter").keyup(function () {
        var childrenCounter = $(this).val();

        $(".filter-age-dropdown").remove();
        if (childrenCounter != "") {
            for (var i = 1; i <= childrenCounter; i++) {
                addNewChild(i);
            }
        }
    });

    /*
     * digit input
     */

    $("input.digit-input").keyup(function () {
        $(this).val(
                $(this)
                .val()
                .replace(/[^\d]/, "")
                );
    });

    $('.divider').on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        return false;
    });

    if ($("#filterDateTo").data("value")) {
        tempEndDate = new Date($("#filterDateTo").data("value"));
    }

    if ($('.content.content-main-page').length) {
        var $filterDateFrom = $('.content.content-main-page').find("#filterDateFrom");
        var $filterDateTo = $('.content.content-main-page').find("#filterDateTo");

        $filterDateFrom.val($filterDateFrom.data('defaultValue'));
        $filterDateTo.val($filterDateTo.data('defaultValue'));
    }
    if ($('.add-filter').length) {
        var $filterDateFrom = $("#filterDateFrom");
        var $filterDateTo = $("#filterDateTo");

        var from = moment($filterDateFrom.data('value')).format('DD.MM.YYYY');
        var to = moment($filterDateTo.data('value')).format('DD.MM.YYYY');

        $filterDateFrom.val(from);
        $filterDateTo.val(to);
    }

    $(".filter-items__item_date .filter-items__title").text($("input[name=filterDateStart]").val() + " - " + $("input[name=filterDateEnd]").val());

    /*
     *   datepicker
     */

    var daterangepickerconfig = {
        locale: {
            firstDay: 1,
            format: 'DD.MM.YYYY',
            applyLabel: "Применить",
            cancelLabel: "Отмена",
            fromLabel: "От",
            toLabel: "До",
            daysOfWeek: [
                "Вс",
                "Пн",
                "Вт",
                "Ср",
                "Чт",
                "Пт",
                "Сб"
            ],
            monthNames: [
                "Январь",
                "Февраль",
                "Март",
                "Апрель",
                "Май",
                "Июнь",
                "Июль",
                "Август",
                "Сентябрь",
                "Октябрь",
                "Ноябрь",
                "Декабрь"
            ],
        },

        minDate: dateToday,

        startDate: $("#filterDateFrom").val(),
        endDate: $("#filterDateTo").val(),

        parentEl: '.filter-items__item_date',
        autoApply: true,
        autoUpdateInput: false,
        maxSpan: {
            days: 14
        }
    };

    function datarangepickercb(start, end, period) {
        // Lets update the fields manually this event fires on selection of range
        var selectedStartDate = start.format('DD.MM.YYYY'); // selected start
        var selectedEndDate = end.format('DD.MM.YYYY'); // selected end

        $checkinInput = $('#filterDateFrom');
        $checkoutInput = $('#filterDateTo');

        // Updating Fields with selected dates
        $checkinInput.val(selectedStartDate);
        $checkoutInput.val(selectedEndDate);

        // Setting the Selection of dates on calender on CHECKOUT FIELD (To get this it must be binded by Ids not Calss)
        var checkOutPicker = $checkoutInput.data('daterangepicker');
        checkOutPicker.setStartDate(selectedStartDate);
        checkOutPicker.setEndDate(selectedEndDate);

        // Setting the Selection of dates on calender on CHECKIN FIELD (To get this it must be binded by Ids not Calss)
        var checkInPicker = $checkinInput.data('daterangepicker');
        checkInPicker.setStartDate(selectedStartDate);
        checkInPicker.setEndDate(selectedEndDate);
    }

    $('#filterDateFrom, #filterDateTo').daterangepicker(daterangepickerconfig, datarangepickercb);

    function formatDate(date) {
        var d = new Date(date),
                month = "" + (d.getMonth() + 1),
                day = "" + d.getDate(),
                year = d.getFullYear();
        dayOfWeek = "";
        if (month.length < 2)
            month = "0" + month;
        if (day.length < 2)
            day = "0" + day;

        return [day, month, year].join(".");
    }

    /*
     * checkboxes
     */

    function checkBoxToggling(boxArray, state) {
        boxArray.each(function (index) {
            var $elem = $(boxArray[index]);
            $elem.prop("checked", state);
        });
    }

    $(".main-checkbox input").change(function () {
        var checkBoxState = $(this).is(":checked");
        var parentsInputsArray = $(this)
                .closest(".filter-checkboxes")
                .find(".checkbox input");
        checkBoxToggling(parentsInputsArray, checkBoxState);
    });

    $("#slider-price").slider({
        range: true,
        min: 0,
        max: 100000,
        values: [filter_min_price, filter_max_price],
        slide: function (event, ui) {
            $("#price_min").val(ui.values[0].toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, "$1 "));
            $("#price_max").val(ui.values[1].toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, "$1 "));
        },
        change: function (event, ui) {
            // console.log('changed');
            $("#price_min").val(ui.values[0].toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, "$1 "));
            $("#price_max").val(ui.values[1].toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, "$1 "));
        }
    });

    $("#price_min").val($("#slider-price").slider("values", 0));
    $("#price_max").val($("#slider-price").slider("values", 1));

    $(".price-input input").keyup(function () {
        this.value = this.value.replace(/[^\d]/, "");
    });
    $(".price-input input").change(function () {
        var this_s = $(this).data("slider");
        var this_i = $(this).data("input");
        var this_v = $(this).val();
        $("#slider-" + this_s + "").slider("values", this_i, this_v);
    });

    /*
     * Additional filter openning
     */

    function closingBigForm(e) {
        if (!$(e.target).closest(".filter-form-wrapper form").length) {
            // filterChecking();
            $(window).off("mousedown", closingBigForm);
            $(".filter-form-wrapper").removeClass("additional-opened");
            $(".search-images-wrapper").removeClass("additional-filter-opened");
            $(".additional-filter-wrapper").removeClass("opened");
            $(".section-search").addClass("animation-on");
            $(".additional-filter__text").text(additionalTextOpened);
            $('.reset-filter-styled').show();
        }
    }

    $additionalText.on("click", function () {
        if ($(".additional-filter-wrapper").is(":visible")) {
            $(".filter-form-wrapper").removeClass("additional-opened");
            $(".additional-filter-wrapper").removeClass("opened");
            $(".additional-filter__text").text(additionalTextOpened);
            $(".section-search").addClass("animation-on");
            $(".full-filter, .search-images-wrapper").removeClass("additional-filter-opened");
            $('.reset-filter-styled').show();
        } else {
            $(".filter-form-wrapper").addClass("additional-opened");
            $(".additional-filter-wrapper").addClass("opened");
            $(".section-search").removeClass("animation-on");
            $(".full-filter, .search-images-wrapper").addClass("additional-filter-opened");
            $(this).text(additionalTextClosed);

            $('.reset-filter-styled').hide();
            // $(window).on("mousedown", closingBigForm);

            ps_filterResorts.update();
            ps_filterHotels.update();
        }
    });

    /*
     * Autocomplete field
     */

    var dataListArraySpan = $("#filterCountry .filter-dropdown-list__link"),
            dataListLi = $("#filterCountry .filter-dropdown-list__item"),
            dataList = [],
            commonDataListArraySpan = $(".autocomplete-list .filter-dropdown-list__link"),
            commonDataLi = $(".autocomplete-list .filter-dropdown-list__item");

    function getAutoCompleteItems(dataArray) {
        dataArray.each(function (index) {
            dataList.push($(dataArray[index]).text());
        });
    }

    getAutoCompleteItems(dataListArraySpan);

    $("#filterCountryInput").keyup(function () {
        var inputValue = document.getElementById("filterCountryInput");
        if (!$("#filterCountry").hasClass("show")) {
            $("#filterCountry").addClass("show");
            $(".filter-items__item_country").addClass("show");
        }
        autocomplete(inputValue, dataList);
    });

    // $(".autocompleteInput").keyup(function() {
    // 	var inputValue = document.getElementById("filterHotelInput");
    // 	if (!$("#filterHotel").hasClass("show")) {
    // 		$("#filterHotel").addClass("show");
    // 		$(".filter-items__item_country").addClass("show");
    // 	}
    // 	autocomplete(inputValue, dataList);
    // });

    // .focus(function(e) {
    // 	e.preventDefault();
    // 	// $('.filter-items__item_country').addClass('show');
    // 	// $('#filterCountry').addClass('show');
    // })
    // .blur(function() {
    // 	setTimeout(function() {
    // 		// $('.filter-items__item_country').removeClass('show');
    // 		$('#filterCountry').removeClass('show');
    // 	}, 100);
    // });

    function autocomplete(inp, arr) {
        inp.addEventListener("input", function (e) {
            var a,
                    b,
                    i,
                    val = this.value,
                    tempArray = [];
            a = document.getElementById("filterCountryList");
            for (i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    b = document.createElement("li");
                    b.setAttribute("class", "filter-dropdown-list__item");
                    b.innerHTML = '<span class="filter-dropdown-list__link">' + arr[i] + "</span>";
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    tempArray.push(b);
                    b.addEventListener("click", function (e) {
                        inp.value = this.getElementsByTagName("input")[0].value;
                        closeAllLists();
                    });
                }
            }
            a.innerHTML = "";

            if (tempArray.length === 0 || $("#filterCountryInput").val() == "") {
                for (i = 0; i < dataListLi.length; i++) {
                    a.appendChild(dataListLi[i]);
                }
                ps_filterCountry.update();
            } else {
                for (i = 0; i < tempArray.length; i++) {
                    a.appendChild(tempArray[i]);
                }
                ps_filterCountry.update();
            }
        });

        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
             except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }
        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
    }

    $(".btn-filter-type").click(function () {
        var filterType = $(this).data("type");
        $("#filterTypeInput").val(filterType);
    });

    $(".filter-dropdown-wrapper").on("click", ".filter-dropdown-list__link", function (e) {
        var thisAttr = $(this).attr("data-value");
        var thisParentId = $(this)
                .parents(".filter-dropdown-wrapper")
                .attr("id");

        if (typeof thisAttr !== typeof undefined && thisAttr !== false) {
            if (thisParentId == "filterCountry") {
                var dataValue = $(this).data("value");
                $("#filterCountryCodeInput").val(dataValue);
            } else {
                var dataValue = $(this).data("value");
                setTimeout(function () {
                    $('input[name="' + thisParentId + '"]').val(dataValue);
                }, 10);
            }
        }
    });

    $(".filter-dropdown-list__link").click(function () {
        var thisAttr = $(this).attr("data-value");
        var thisParentId = $(this)
                .parents(".filter-dropdown-wrapper")
                .attr("id");

        if (typeof thisAttr !== typeof undefined && thisAttr !== false) {
            if (thisParentId == "filterCountry") {
                var dataValue = $(this).data("value");
                $("#filterCountryCodeInput").val(dataValue);
            } else {
                var dataValue = $(this).data("value");
                setTimeout(function () {
                    $('input[name="' + thisParentId + '"]').val(dataValue);
                }, 10);
            }
        }
    });
    $('#filterResorts, #filterCatHotel').on('change', 'input', function () {
        var checked = [], category = [];
        $('#filterResorts input').each(function () {
            if ($(this).is(':checked')) {
                checked.push($(this).parents('.checkbox').data('id'));
            }
        });
        $('#filterCatHotel input').each(function () {
            if ($(this).is(':checked')) {
                category.push(parseInt($(this).val()));
            }
        });
        $('#filterHotelsTitles input').each(function () {
            if (category.length !== 0 && checked.length === 0) {
                if ($.inArray($(this).parent().data('cat'), category) !== -1) {
                    $(this).parents('.checkbox').removeClass('d-none');
                } else {
                    $(this).parents('.checkbox').addClass('d-none');
                    $(this).prop('checked', false);
                }
            } else if (category.length === 0 && checked.length !== 0) {
                if ($.inArray($(this).parent().data('id'), checked) !== -1) {
                    $(this).parents('.checkbox').removeClass('d-none');
                } else {
                    $(this).parents('.checkbox').addClass('d-none');
                    $(this).prop('checked', false);
                }
            } else if (category.length !== 0 && checked.length !== 0) {
                if ($.inArray($(this).parent().data('cat'), category) !== -1 && $.inArray($(this).parent().data('id'), checked) !== -1) {
                    $(this).parents('.checkbox').removeClass('d-none');
                } else {
                    $(this).parents('.checkbox').addClass('d-none');
                    $(this).prop('checked', false);
                }
            } else {
                $(this).parents('.checkbox').removeClass('d-none');
            }
        });
        scrollBarsUpdating();
    });
});

function filterFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("filterHotelInput");
    filter = input.value.toUpperCase();
    div = document.getElementById("hotels-checkboxes-wrapper");
    a = div.getElementsByTagName("label");
    for (i = 0; i < a.length; i++) {
        txtValue = a[i].textContent || a[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
        }
    }
}
