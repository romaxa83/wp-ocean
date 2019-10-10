function getDataFilter() {
    var city = [];
    var children = [];
    var category = [];
    var food = [];
    var hotel = [];
//    if ($('.full-filter').data('filter') !== 'default') {
//        $('#filterCatHotel .checkboxes-wrapper input, #filterNutrition .checkboxes-wrapper input, #filterResorts .checkboxes-wrapper input, #filterHotelsTitles .checkboxes-wrapper input').each(function () {
//            if (!$(this).prop('checked'))
//                $(this).click();
//        });
//    }
    $(".full-filter #filterResorts .checkboxes-wrapper input:checked").each(function () {
        city.push($(this).val());
    });
    $('.filter-age-dropdown').each(function () {
        children.push($(this).find('.filter-items__title').text().replace(/[^0-9]/g, ''));
    });
    $('#filterCatHotel .checkboxes-wrapper input[type="checkbox"]:checked').each(function () {
        category.push($(this).val());
    });
    $('#filterNutrition .checkboxes-wrapper input[type="checkbox"]:checked').each(function () {
        food.push($(this).val());
    });
    $('#filterHotelsTitles .checkboxes-wrapper input[type="checkbox"]:checked').each(function () {
        hotel.push($(this).val());
    });
    if ($('.full-filter').data('filter') !== 'default') {
        if (category.length == 0) {
            $('#filterCatHotel .checkboxes-wrapper input[type="checkbox"]').each(function () {
                category.push($(this).val());
            });
        }
        if (food.length == 0) {
            $('#filterNutrition .checkboxes-wrapper input[type="checkbox"]').each(function () {
                food.push($(this).val());
            });
        }
        if (city.length == 0) {
            $(".full-filter #filterResorts .checkboxes-wrapper input").each(function () {
                city.push($(this).val());
            });
        }
        if (hotel.length == 0) {
            $('#filterHotelsTitles .checkboxes-wrapper .checkbox:not(.d-none) input[type="checkbox"]').each(function () {
                hotel.push($(this).val());
            });
        }
    }
    return {
        type: $('.full-filter').data('filter'),
        country: $('.full-filter select[name="countryCode"]').val(),
        dept_city: $('.full-filter select[name="filterCity"]').val(),
        city: city,
        additional: {
            date_from: $('#filterDateFrom').val(),
            date_to: $('#filterDateTo').val(),
            length: $('.filter-items__item_time').find('.select2-selection__rendered').first().text(),
            lengthTo: $('.filter-items__item_time').find('.select2-selection__rendered').last().text(),
            people: $('#adultsCounter').val(),
            children: children.join(','),
            stars: category.join(','),
            food: food.join(','),
            priceMin: $('#price_min').val().replace(/\s/g, ''),
            priceMax: $('#price_max').val().replace(/\s/g, '') || '',
            filterCurrency: $('input[name="filterCurrency"]').val(),
        },
        session: {
            hotel: hotel.join(',')
        }
    };
}
function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
}
;
function gReCaptchaInit(form, siteKey, action) {
    grecaptcha.execute(siteKey, {action: action}).then(function (token) {
        form.find('input[name="reCaptcha"]').val(token);
    });
}
$(document).ready(function () {
    if ($('#filterCountryInput').length && $('#filterCountryInput').val() != "") {
        $('#filterCountryInput').change();
    }

    $('body').on('click', '.btn-parametr', function () {
        var view = $(this).data("view");
        $.ajax({
            url: host + "/search/set-view",
            type: "post",
            data: {view: view}
        });
    });
    //скрипт для уведомления не заполненных поле
    var empty_field = "";
    var phone = $("#usereditform-phone").val();
    if (phone === "") {
        empty_field += "Телефон \n";
    }
    var form_passport = $("#form-passport").find("input");

    form_passport.each(function () {
        if ($(this).val() === "") {
            var id = $(this).attr("id");
            var label = $('[for = "' + id + '"]').text();
            empty_field += label + "\n";
        }
    });

    if (empty_field !== "") {
        $(".cabinet-settings-navbar").append(
                '<span class="badge" title="Заполните поля : \n' +
                empty_field +
                '" style="float:right">' +
                '<span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></span>'
                );
    }

    //чекбокс для рассылки новостей
    $(".check-dispatch").on("change", function () {
        var obj = $(this);
        var data = {
            user_id: obj.data("user-id"),
            check: $(this).is(":checked") ? 1 : 0
        };
        $.ajax({
            url: host + "/cabinet/dispatch/check-dispatch",
            type: "post",
            data: data,
            success: function () {
                location.reload();
            }
        });
    });
    $("#filterCountryInput").on("keyup", function () {
        var country = $(this).val();
        if (country.length >= 3) {
            $.post(host + "/site/get-country", {country: country}, function (data) {
                var html = "";
                var data = JSON.parse(data);
                for (var i in data) {
                    html +=
                            '<li class="filter-dropdown-list__item filter-dropdown-list_main"><span class="filter-dropdown-list__link" data-value="' +
                            i +
                            '">' +
                            data[i] +
                            "</span></li>";
                }
                if (html.length > 0) {
                    $("#filterCountryList")
                            .empty()
                            .append(html);
                }
            });
        }
    });

    function redirectAction() {
        var obj = $(this);
        var xhr = true;
        var value = obj.data("value");
        if (value == '') {
            xhr = false;
            location.reload();
        }
        var action = obj.data("action");
        var data = {
            value: value
        };
        if (xhr) {
            $.ajax({
                url: "/blog/" + action + "-find",
                type: "post",
                data: data
            });
        }
    }
    $(".redirect-action").on("click", redirectAction);
    $(".blog-selects").change(function () {
        var xhr = true;
        var obj = $(this);
        var value = obj.val();
        if (value == '') {
            xhr = false;
            location.reload();
        }
        var action = obj.data("action");
        var data = {
            value: value
        };
        if (xhr) {
            $.ajax({
                url: "/blog/" + action + "-find",
                type: "post",
                data: data
            });
        }
    });

    $("[data-container-css-class]").each(function () {
        var className = $(this).attr("data-container-css-class");
        var container = $(this).next(".select2-container");
        container.addClass(className);
        container.find(".select2-selection").removeClass(className);

        $("select[data-container-css-class]").on("select2:open", function () {
            var obj = $(this);
            var xhr = true;
            $(this).change(function () {
                var value = obj.val();
                if (value == '') {
                    xhr = false;
                    location.reload();
                }
                var action = obj.data("action");
                var data = {
                    value: value
                };
                if (xhr) {
                    // $.ajax({
                    //     url: "/blog/" + action + "-find",
                    //     type: "post",
                    //     data: data
                    // });
                }
            });
        });
    });

    $(".filter-form-wrapper .submit-filter").on("click", function () {
        var obj = $(this);
        var data = getDataFilter();
        if (!data.country) {
            $("#select2-filterCountryInput-container").css("color", "#ff4800");
            return false;
        }
        $.ajax({
            url: host + "/search/filter",
            type: "POST",
            async: false,
            data: data,
            success: function (data) {
                $(obj).parents("form").attr("action", data);
            }
        });
    });
    $(".map-init").on("click", function () {
        $('.tab-map-init').click();
        var trg = $('.tab-map-init').offset().top - 60;
        $('body, html').animate({
            scrollTop: trg
        }, 'slow');
    });

    if ($("#map").length) {
        var coordinates = [$("#map-lat").text(), $("#map-lng").text()];
        if (coordinates[0] == 0 && coordinates[1] == 0) {
            var hotel = $("#map-hotel-name").text();
            $.get(location.protocol + "//nominatim.openstreetmap.org/search?format=json&q=" + hotel, function (data) {
                if (data[0]) {
                    $("#map-lat").text(data[0].lat);
                    $("#map-lng").text(data[0].lon);
                }
            });
        }
    }

    $(document).on('click', '.review-init', function () {
        $('.tab-review-init').click();
        var trg = $('.tab-review-init').offset().top - 60;
        $('body, html').animate({
            scrollTop: trg
        }, 'slow');
    });
//    if ($(".section-tour-info").length) {
//        var id = $(".get-block-offers").data("id");
//        $.ajax({
//            url: host + "/tour/get-block-offers",
//            type: "POST",
//            data: {id: id},
//            beforeSend: function () {
//                $(".loader.offer").removeClass("d-none");
//            },
//            success: function (data) {
//                $(".tour-description")
//                        .empty()
//                        .append(data);
//            },
//            complete: function () {
//                $(".loader.offer").addClass("d-none");
//            }
//        });
//    }


    $("body").on("click", ".more-tour", function () {
        $(".tour-description--item.d-none").each(function (i) {
            if (i < 4) {
                $(this).removeClass("d-none");
            }
        });
        if ($(".tour-description--item.d-none").length == 0) {
            $(".more-tour").addClass("d-none");
        }
    });
    $("body").on("click", ".more-review", function () {
        var reviewOnPage = $(this).data("review-on-page");
        $(".reviewShowHotel.d-none").each(function (i) {
            if (i < parseInt(reviewOnPage)) {
                $(this).removeClass("d-none");
            }
        });
        if ($(".reviewShowHotel.d-none").length == 0) {
            $(".more-review").addClass("d-none");
        }
    });
    $("#search-offers").on("click", function () {
        var food = [];
        var url = $(this).data("url");
        $(".food-input").each(function () {
            if ($(this).is(":checked")) {
                food.push($(this).val());
            }
        });
        var data = {
            deptCity: $(".get-block-offers").data("dept"),
            to: $(".get-block-offers").data("to"),
            checkIn: $('input[name="filterDateStart"]').val(),
            checkTo: $('input[name="filterDateEnd"]').val(),
            room: $('[name="filterHotelRoom"]').val(),
            length: $('[name="filterDaysFrom"]').val(),
            lengthTo: $('[name="filterDaysTo"]').val(),
            people: $(".get-block-offers").data("people"),
            food: food
        };
        $.ajax({
            url: host + url,
            type: 'POST',
            data: data,
            beforeSend: function () {
                $('.tour-description').empty();
                $(".loader.search-offers").removeClass("d-none");
            },
            success: function (data) {
                var data = JSON.parse(data);
                if (typeof data.no_data !== 'undefined') {
                    $(".tour-description").empty().append(data.no_data);
                } else {
                    $('.search-offer-info').html(data.info);
                    $(".tour-description").empty().append(data.content);
                }
            },
            complete: function () {
                $(".loader.search-offers").addClass("d-none");
            }
        });
    });
    $("body").on("click", ".save-order", function () {
        var form = $(this).parents('form');
        var url = $("#form-save-order").attr("action");
        var data = $("#form-save-order").serialize();
        $("#modal-application-tour .error").removeClass("error");
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            success: function (data) {
                var data = JSON.parse(data);
                if (data.type == "error") {
                    for (var i in data.message) {
                        $('#modal-application-tour [name="' + i + '"]').addClass("error");
                    }
                }
                if (data.type == "success") {
                    $("#form-save-order input, textarea").not('input[type="hidden"]').val('');
                    $("#modal-application-tour").modal("hide");
                    $('span[data-target="#modal-send-request"]').click();
                    dataLayer.push({'event': 'zabronirovat_tur' });
                }
                gReCaptchaInit(form, data.siteKey, 'order');
            }
        });
    });

    $("body").on("click", ".save-order-1", function () {
        var url = $("#form-save-order-1").attr("action");
        var data = $("#form-save-order-1").serialize();
        $("#modal-application-tour-1 .error").removeClass("error");
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            success: function (data) {
                $("#form-save-order-1 input, textarea").val('');
                var data = JSON.parse(data);
                if (data.type == "error") {
                    for (var i in data.message) {
                        $('#modal-application-tour-1 [name="' + i + '"]').addClass("error");
                    }
                }
                if (data.type == "success") {
                    $("#modal-application-tour-1").modal("hide");
                    $('span[data-target="#modal-send-request"]').click();
                }
            }
        });
    });

    $(".save-request").on("click", function () {
        var form = $(this).parents('form');
        var url = $("#form-save-request").attr("action");
        var data = $("#form-save-request").serialize();
        $("#modal-order-tour .error").removeClass("error");
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            success: function (data) {
                var data = JSON.parse(data);
                if (data.type == "error") {
                    for (var i in data.message) {
                        $('#modal-order-tour [name="' + i + '"]').addClass("error");
                    }
                }
                if (data.type == "success") {
                    $("#form-save-request input, textarea").not('input[type="hidden"]').val('');
                    $('a[data-target="#modal-order-tour"]').click();
                    $('span[data-target="#modal-send-request"]').click();
                    dataLayer.push({'event': 'podobrat_tur'});
                }
                gReCaptchaInit(form, data.siteKey, 'request');
            }
        });
    });
    $("body").on("click", '.save-request-page', function () {
        var form = $(this).parents('form');
        var url = $("#form-save-request-page").attr("action");
        var data = $("#form-save-request-page").serialize();
        $("#form-save-request-page .error").removeClass("error");
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            success: function (data) {
                var data = JSON.parse(data);
                if (data.type == "error") {
                    for (var i in data.message) {
                        $('#form-save-request-page [name="' + i + '"]').addClass("error");
                    }
                }
                if (data.type == "success") {
                    $("#form-save-request-page input, textarea").not('input[type="hidden"]').val('');
                    $('span[data-target="#modal-send-request"]').click();
                    dataLayer.push({'event': 'contact_form' });
                }
                gReCaptchaInit(form, data.siteKey, 'request');
            }
        });
    });
    $("body").on("click", ".card-more-wrapper.submit-filter", function () {
        var page = $(this).attr("data-page");
        var btn = $(".btn-card-more");
        var $clickedBtn = $(this);
        var data = getDataFilter();
        data.page = page;
        if ($(".btn-card-more").hasClass("disabled")) {
            return false;
        } else {
            $.ajax({
                url: host + "/search/search-result",
                type: "post",
                data: data,
                beforeSend: function () {
                    $clickedBtn.children("span").addClass("d-none");
                    $(".more-loader").addClass("more-loader-animation");
                    $(".btn-card-more").addClass("disabled");
                    if ($clickedBtn.children(".preload.loader").length) {
                        $clickedBtn.children(".preload.loader").removeClass("d-none");
                    }
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.content.length != 0) {
                        $(".btn-card-more").remove();
                        $(".sales-container")
                                .append(data.content)
                                .append(btn);
                        $(".submit-filter").attr("data-page", data.page);
                        testimonialsChangeEnding();
                    } else {
                        $(".btn-card-more").addClass("d-none");
                    }
                },
                complete: function () {
                    $(".btn-card-more").removeClass("disabled");
                    $(".loader").addClass("d-none");
                    $clickedBtn.children("span").removeClass("d-none");
                    $(".more-loader").removeClass("more-loader-animation");
                    if ($clickedBtn.children(".preload.loader").length) {
                        $clickedBtn.children(".preload.loader").addClass("d-none");
                    }
                    testimonialsChangeEnding();
                },
                error: function () {
                    $(".btn-card-more").addClass("d-none");
                }
            });
        }
    });

    // отправка отзыва
    $(".send-review").on("click", function () {
        var xhr = true;
        var user_id = $('input[name = "review-user-id"]').val();
        var hotel_id = $('input[name = "hotel-id"]').val();
        var review_hotel_id = $('input[name = "review-hotel-id"]').val();
        var vote = $("input[type=radio]:checked").val();
        var title = $('input[name = "review-title"]').val();
        var comment = $('textarea[name = "review-comment"]').val();
        var avatar = $(".attach-avatar").text();
        var $filePreloader = $('.lineloader');

        if (title === "") {
            xhr = false;
            $('input[name = "review-title"]').css("border", "1px red solid");
        }

        if (comment === "") {
            xhr = false;
            $('textarea[name = "review-comment"]').css("border", "1px red solid");
        }

        if (typeof vote == "undefined") {
            xhr = false;
            $(".rate-for-review").css("color", "red");
        }

        if (avatar == "Прикрепите Ваше фото") {
            avatar = "";
        }
        var data = {
            vote: vote,
            title: title,
            comment: comment,
            user_id: user_id,
            hotel_id: hotel_id,
            review_hotel_id: review_hotel_id,
            avatar: avatar
        };
        if (xhr) {
            $.ajax({
                type: "post",
                url: host + "/blog/add-review-to-hotel",
                data: data,
                beforeSend: function () {
                    $filePreloader.fadeOut(1000);
                },
                complete: function () {
                    $filePreloader.fadeIn(1000);
                }
            });
        }
    });

    // убираем оповещение о необходимости заполнения
    $('input[name = "review-title"]').on("focus", function () {
        if ($(this).prop("style")) {
            $(this).removeAttr("style");
        }
    });

    $('textarea[name = "review-comment"]').on("focus", function () {
        if ($(this).prop("style")) {
            $(this).removeAttr("style");
        }
    });

    $("input[type=radio]").on("click", function () {
        if ($(".rate-for-review").prop("style")) {
            $(".rate-for-review").removeAttr("style");
        }
    });
    // сохранение аватарки
    // $("input[type = file]").on("change", function (e) {
    //     e.stopPropagation();
    //     e.preventDefault();

    //     var file = $(this).prop("files")[0];

    //     var data = new FormData();

    //     data.append("file", file);

    //     $.ajax({
    //         url: host + "/blog/add-avatar-review",
    //         type: "post",
    //         data: data,
    //         cache: false,
    //         dataType: "json",
    //         processData: false,
    //         contentType: false,
    //         success: function (res) {
    //             if (res.type == "success") {
    //                 $(".attach-avatar").text(res.name);
    //             } else {
    //                 $('input[name = "review-file"]').append('<span class="avatr-error">Ошибка загрузки</span>>');
    //             }
    //         },
    //         error: function (jqXHR, status, errorThrown) {
    //             console.log("ОШИБКА AJAX запроса: " + status, jqXHR);
    //         }
    //     });
    // });

    //фильтраци отзывов по рейтингу
    $(".filter-review").on("click", function () {
        $(".tour-testimonials").each(function () {
            $(this).removeClass("d-none");
        });
        var arr_type = [];
        var obj = $(this);

        $(".filter-review:checked").each(function () {
            arr_type.push($(this).data("type"));
        });

        if (arr_type.length != 0) {
            $(".tour-testimonials").each(function () {
                $(this).addClass("d-none");
            });
            $(".more-review").addClass("d-none");
        } else {
            var countReview = $(".more-review").data("review-on-page");
            var allReview = $(".tour-testimonials");
            allReview.each(function (i) {
                $(this).addClass("d-none");
                if (i <= parseInt(countReview)) {
                    $(this).removeClass("d-none");
                }
            });
            if ($(".more-review").hasClass("d-none")) {
                $(".more-review").removeClass("d-none");
            }
        }

        for (var i = 0; i < arr_type.length; i++) {
            $('[data-type-reviews = "' + arr_type[i] + '"]').each(function () {
                if ($(this).hasClass("d-none")) {
                    $(this).removeClass("d-none");
                }
            });
        }
    });

    if ($(".section-review").length) {
        var ptour = {
            cid: $("#block_promotional_tours").data("cid"),
            stars: $("#block_promotional_tours").data("stars"),
            deptCity: getUrlParameter('deptCity'),
            checkIn: getUrlParameter('checkIn'),
            length: getUrlParameter('length'),
            people: getUrlParameter('people')
        };
        $.ajax({
            url: host + "/tour/promotional-tour",
            type: "POST",
            data: ptour,
            beforeSend: function () {
                $("#block_promotional_tours .loader").removeClass("d-none");
            },
            success: function (data) {
                $("#block_promotional_tours")
                        .empty()
                        .append(data);

                var scrollMagicController = new ScrollMagic.Controller();
                for (var i = 1; i <= $(".section").length; i++) {
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

            },
            complete: function () {
                $("#block_promotional_tours .loader").addClass("d-none");
                testimonialsChangeEnding();
            }
        });
    }

    //запрос для странице обзоры отелей
    if ($(".tour-in-review").length) {
        $.ajax({
            url: host + "/blog/tour-for-review-hotel",
            type: "POST"
                    // beforeSend: function () {
                    //     $('#block_promotional_tours .loader').removeClass('d-none');
                    // },
                    // success: function (data) {
                    //     $('#block_promotional_tours').empty().append(data);
                    //     var scrollMagicController = new ScrollMagic.Controller();
                    //     for (var i = 1; i <= $(".section").length; i++) {
                    //         var cls = "#line-";
                    //         new ScrollMagic.Scene({
                    //             triggerElement: cls + i,
                    //             triggerHook: 0.9
                    //         })
                    //             .setClassToggle("#animate" + i, "active")
                    //             .addTo(scrollMagicController);
                    //         new ScrollMagic.Scene({
                    //             triggerElement: cls + i,
                    //             triggerHook: 0.85
                    //         })
                    //             .setClassToggle(cls + i, "active")
                    //             .addTo(scrollMagicController);
                    //     }
                    // },
                    // complete: function () {
                    //     $('#block_promotional_tours .loader').addClass('d-none');
                    // }
        });
    }

    $(".show-more-post").on("click", function () {
        $.ajax({
            type: "post",
            url: host + "/blog/more-post",
            data: {url: $(this).data("route")}
        });
    });

    $(".show-any-faq").on("click", function () {
        $.ajax({
            type: "post",
            url: host + "/faq/show-any-faq",
            data: {url: $(this).data("route")}
        });
    });

    if ($(".offers-hotel-review").length) {
        $.ajax({
            url: host + "/blog/get-offers",
            type: "post",
            data: {hotel_hid: $(".get-block-offers").data("to")},
            beforeSend: function () {
                $(".loader").removeClass("d-none");
            },
            success: function (data) {
                var block = $(".offers-hotel-review");
                if (data) {
                    block.empty().append(data);
                    var rooms = $(".description-number").data("all-room");
                    var html_select = " ";
                    for (var room in rooms) {
                        html_select += '<option value="' + rooms[room] + '">' + rooms[room] + "</option>";
                    }
                    $('[name = "filterHotelRoom"]')
                            .empty()
                            .append(html_select);
                    $('[name = "filterHotelRoomMobile"]')
                            .empty()
                            .append(html_select);
                } else {
                    block.html("<span>Нет данных</span>");
                }
            },
            complete: function () {
                $(".loader").addClass("d-none");
            }
        });
    }

    $("#modal-application-tour").on("show.bs.modal", function (e) {
        var data = $.parseJSON(e.relatedTarget.dataset.offer);
        var people = $(".get-block-offers").data("people");
        var deptCity = $(".deptCity").text();
        var hotelName = $(".hotelName").text();
        data.deptCity = deptCity;
        data.hotelName = hotelName;
        data.people = people;

        $("#modal-application-tour .offerName").text(hotelName);
        $("#modal-application-tour .offerCountryCity").text(data.country + " / " + data.city);
        $("#modal-application-tour .offerPrice").text(data.price + " ₴");
        $("#modal-application-tour .offerDeptCity").text(deptCity);
        $("#modal-application-tour .offerDateBegin").text(data.dateBegin);
        $("#modal-application-tour .offerRoom").text(data.room);
        $("#modal-application-tour .offerFood").text(data.food);
        $("#modal-application-tour .offerDays").text(data.days);
        $("#modal-application-tour .offerPeople").text(people);
        $('input[name="offer"]')
                .filter('input[name="offer"]')
                .val(data.offerId);
        $('input[name="hotel_id"]').val(data.hotelHid);
        $('input[name="info"]').val(JSON.stringify(data));
        $('input[name="price"]').val(data.price);
        // $('input[type="tel"]').mask("+38 (000) 0000000");
    });
    $('#print_form button[type="submit"]').on("click", function (e) {
        var data = {
            id: parseInt($('.tour-identification--id').first().text().replace(/[^0-9]/gi, '')),
            info: [],
            about: [],
            service: [],
            full_price: $('.tour-right--footer .full-price.print-hidden').first().text().trim(),
            discount_price: $('.tour-right--footer .descount-price.print-hidden').first().text().trim()
        };
        $('.tour-identification--list  ul li').each(function () {
            var value = $(this).html().split('</small>');
            data.info.push({
                key: $(this).find('small').text(),
                value: value[1].trim()
            });
        });
        $('.tour-tab-1 ul li').each(function () {
            data.about.push($(this).text());
        });
        $('.tour-tab-2 ul li').each(function () {
            data.service.push($(this).text());
        });
        $('#print_form input[name="info"]').val(JSON.stringify(data));
    });

    if ($('#tour-result-info').length) {
        $.ajax({
            url: host + "/tour/get-info",
            type: 'POST',
            beforeSend: function () {
                $(".preloader-about-tour-full-price").removeClass("d-none");
            },
            data: {
                id: $('#tour-result-info').data('hotel'),
                tour_id: getUrlParameter('id') || 0,
                api: $('#tour-result-info').data('api')
            },
            success: function (data) {
                var option = [];
                var data = JSON.parse(data);
                $('#tour-result-info').append(data.block_info);
                if (parseInt($('#tour-result-info').find('.descount-price').first().text()) > 0) {
                    $('.tour-price').empty().text($('#tour-result-info').find('.descount-price').first().text());
                    $('.about-tour-full-price').removeClass('d-none');
                }
                $('#block_about_tour').empty().append(data.block_about_tour);
                option.push('<option value="">Все номера</option>');
                for (var i in data.all_room) {
                    option.push('<option value="' + i + '">' + data.all_room[i] + '</option>');
                }
                $('select[name="filterHotelRoom"]').append(option.join(''));
            },
            complete: function () {
                $(".preloader-about-tour-full-price").addClass("d-none");
            }
        });
        $('#search-offers').click();
    }

    $('body').on('click', '.change-date-filter', function () {
        var trg = $('.get-block-offers').offset().top - 80;
        $('body, html').animate({
            scrollTop: trg
        }, 'slow');
        return false;
    });

    if ($('.section-tour-info').length) {
        function initExpandReview() {
            var testimonialCharsLimit = 450;
            var ellipsestext = "...";

            $('.tour-testimonials .truncate-v2').each(function (index, element) {
                var text = $(element).text();
                var length = $(element).text().length;
                var cut = $(element).text().substring(0, testimonialCharsLimit);
                var html;

                if (length > testimonialCharsLimit) {
                    html = "<div class='truncate-text' style='display:block'>" + cut + "<span class='moreellipses'>" + ellipsestext + "&#160;&#160;&#160;<a href='#' class='moreless v2'>Eще</a></span></div>" +
                            "<div class='truncate-text' style='display:none'>" + text + "&#160;&#160;&#160;<a href='#' class='moreless-v2 moreless less'>Свернуть</a></div>";
                    $(element).html(html);
                }
            });

            $(".tour-testimonials .moreless").click(function (e) {
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
        }

        $.ajax({
            url: host + "/tour/get-hotel-review-info",
            type: 'POST',
            beforeSend: function () {
                $(".preloader-block-review-info").removeClass("d-none");
            },
            data: {id: $('#tour-result-info').data('hotel')},
            success: function (data) {
                var data = JSON.parse(data);
                $('.block-review-info').empty().append(data.review_info);
                $('.block-review-info').css('display', '-webkit-inline-box');
            },
            complete: function () {
                $(".preloader-block-review-info").addClass("d-none");
            }
        });
        $.ajax({
            url: host + "/tour/get-hotel-review",
            type: 'POST',
            beforeSend: function () {
                $(".preloader-block-review").removeClass("d-none");
            },
            data: {id: $('#tour-result-info').data('hotel')},
            success: function (data) {
                var data = JSON.parse(data);
                $('.reviews-rating__amount').text(data.format_count);
                $('.reviews-rating__total').text(data.format_avg);
                $('.reviews-rating__pill-wrapper input[value="' + data.avg + '"]').attr('checked', true);
                $('.reviews-rating').parent().removeClass('d-none');
                $('.block-review').empty().append(data.review);
                scrollBarsUpdating();
                initExpandReview();
            },
            complete: function () {
                $(".preloader-block-review").addClass("d-none");
            }
        });
    }

    $(document).click(function (event) {
        if ($(event.target).closest(".filter-form-wrapper form").length)
            return;
        $(".filter-form-wrapper.additional-opened .additional-filter__text").click();
    });

    function nextPage(page) {
        var type = $('#search-result').data('type-page');
        $.ajax({
            url: host + "/tour-page/next-page",
            type: 'POST',
            data: {page: page, type: type},
            beforeSend: function () {
                if ($('.result-cards-wrapper').text().length == 0) {
                    $(".loader").removeClass("d-none");
                }
            },
            success: function (data) {
                var data = JSON.parse(data);
                if (data.count > 0) {
                    $('.results-parametrs').addClass('d-lg-flex');
                } else {
                    $('#search-result').remove();
                }
                $('.btn-card-more').remove();
                $('.result-cards-wrapper').append(data.content);
                if ($('.result-card').length <= data.count) {
                    $('.next-page').attr('data-page', data.page);
                } else {
                    $('.btn-card-more').remove();
                }
            },
            complete: function () {
                $(".loader").addClass("d-none");
            }
        });
    }
    if ($('.heading-search').length > 0) {
        nextPage(0);
    }
    $('body').on('click', '.next-page', function () {
        var page = $(this).data('page');
        nextPage(page);
    });
});

$(document).ready(function () {
    var SwiperFactsReady = false;
    var SwiperVacancy2Ready = false;

    var SwiperVacancyOptions = {
        direction: 'horizontal',
        loop: false,
        slidesPerView: 2,
        spaceBetween: 30,
        watchOverflow: true,
        pagination: {
            el: '.swiper-pagination',
            type: 'bullets',
            clickable: true
        },
        on: {
            init: function () {
                SwiperVacancyReady = true;
            }
        },
        breakpoints: {
            991: {
                slidesPerView: 1,
                spaceBetween: 20
            }
        }
    };
    var SwiperVacancyOptions2 = {
        direction: 'horizontal',
        loop: false,
        init: false,
        slidesPerView: 2,
        spaceBetween: 15,
        watchOverflow: true,
        pagination: {
            el: '.swiper-pagination',
            type: 'bullets',
            clickable: true
        },
        breakpoints: {
            768: {
                slidesPerView: 1,
                spaceBetween: 15
            }
        },
        on: {
            init: function () {
                SwiperVacancy2Ready = true;
            }
        },
    };
    var SwiperFactsOptions = {
        direction: 'horizontal',
        init: false,
        loop: false,
        slidesPerView: 1,
        //spaceBetween: 30,
        watchOverflow: true,
        pagination: {
            el: '.swiper-pagination',
            type: 'bullets',
            clickable: true
        },
        on: {
            init: function () {
                SwiperFactsReady = true;
            }
        }
    };
    var facts = '#facts .swiper-container';
    var vacancy = '#vacancy .swiper-container';
    var vacancy2 = '#vacancy2 .swiper-container';

    var SwiperVacancy = new Swiper(vacancy, SwiperVacancyOptions);
    var SwiperFacts = undefined;
    var SwiperVacancy2 = undefined;

    var $mediaXS = window.matchMedia("(max-width: 575px)");
    var $mediaMD = window.matchMedia("(max-width: 991px)");
    if ($(window).width() < 575) {
        if ($(facts).length) {
            SwiperFacts = new Swiper(facts, SwiperFactsOptions);
            SwiperFacts.init();
        }
    }
    if ($(window).width() < 992) {
        if ($(vacancy2).length) {
            SwiperVacancy2 = new Swiper(vacancy2, SwiperVacancyOptions2);
            SwiperVacancy2.init();
        }
    }
    $(window).resize(function () {
        if ($(facts).length) {
            if ($(window).width() < 575 && SwiperFacts == undefined) {
                SwiperFacts = new Swiper(facts, SwiperFactsOptions);
                SwiperFacts.init();
            } else if ($(window).width() > 575 && SwiperFacts !== undefined) {
                SwiperFacts.destroy();
                SwiperFacts = undefined;
                if (SwiperFacts == undefined)
                    console.log('facts DEAD');
            }
        }

        if ($(vacancy2).length) {
            if ($(window).width() < 992 && SwiperVacancy2 == undefined) {
                SwiperVacancy2 = new Swiper(vacancy2, SwiperVacancyOptions2);
                SwiperVacancy2.init();
            } else if ($(window).width() > 992 && SwiperVacancy2 != undefined) {
                SwiperVacancy2.destroy();
                SwiperVacancy2 = undefined;
                if (SwiperVacancy2 == undefined)
                    SwiperVacancy2Ready = false;
            }
        }

    });


    /* single */

    /* single */

    var vacansy2_single = "#single_vacancy2 .swiper-container";
    var vacansy2_single_swiperConfig = {
        direction: "horizontal",
        loop: false,
        init: true,
        slidesPerView: 2,
        spaceBetween: 30,
        // watchOverflow: true,
        //touch:true,
        breakpoints: {
            767: {
                slidesPerView: 1
            }
        }
    };
    var vacansy2_single_slidesLen = $('#single_vacancy2 .swiper-container').find('.swiper-slide').length;

    if (vacansy2_single_slidesLen > 1) {
        vacansy2_single_swiperConfig.pagination = {
            el: ".swiper-pagination",
            type: "bullets",
            clickable: true
        };
    }

    if (vacansy2_single_slidesLen === 2) {
        $('#single_vacancy2').attr('data-ss-count', vacansy2_single_slidesLen);
    }

    var SwiperSingleVacancy = new Swiper(vacansy2_single, vacansy2_single_swiperConfig);

    $("a").on("click", function (event) {
        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            $("html, body").animate(
                    {
                        scrollTop: $(hash).offset().top
                    },
                    800,
                    function () {
                        window.location.hash = hash;
                    }
            );
        }
    });

    /* VACANCY REQUEST */
    $('#vacancy-form input, #vacancy-form select').on('change', function () {
        var status = $(this).validate();
        if ($(this).attr('type') === 'file' || $(this).attr('name') === 'vacancy') {
            if (status) {
                $(this).parent().removeClass('error');
            } else {
                $(this).parent().addClass('error');
            }
        }
    });

    var defaultCVLabelText = $('#vacancy-form [type="file"] + label span').text();

    $('#vacancy-form [type="file"]').on('change', function (e) {
        var file = $(this).prop("files")[0];
        var filePath = $(this).val();
        var allowedExts = /(\.doc|\.docx|\.pdf|\.odt|\.rtf|\.txt|\.wps|\.pages|\.png|\.jpg)$/i;
        var hasErrors = false;
        var maxFileSize = 2097152;

        if (file) {
            if (!allowedExts.exec(filePath)) {
                alert('Ошибка загрузки! Допустимы расширения файлов: .doc, .docx, .pdf, .odt, .rtf, .txt, .wps, .pages, .png, .jpg');
                hasErrors = true;
            } else {
                hasErrors = false;
            }

            if (file.size > maxFileSize) {
                alert('Ошибка загрузки! Маскимальный размер файла не должен привышать 2MB.');
                hasErrors = true;
            }
        }

        if (hasErrors) {
            $(this).val('').parent()
                    .addClass('error')
                    .find('.uploaded-filename')
                    .text(defaultCVLabelText);
        } else {
            $(this).parent()
                    .removeClass('error')
                    .find('.uploaded-filename')
                    .text(file.name);
        }
    });

    $('#vacancy-form').on('submit', function (e) {
        e.preventDefault();

        var $submitBtn = $(this).find('[type="submit"]');
        $submitBtn.prop('disabled', true);

        $.ajax({
            url: host + '/vacancy/notificator',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                // show preloader before send request
                $('#gg-material-loading').show();
                $('.send-review').attr('disabled', true);
            },
            complete: function () {
                $('.send-review').attr('disabled', false);
                $('#gg-material-loading').hide();
            },
            success: function (response) {
                // hide preloader on request success
                // $('#gg-material-loading').delay(2000).fadeIn('slow');
                response = $.parseJSON(response);
                if (response.status) {
                    $('#modal-join-us').modal('hide');
                    $('#modal-send-request').modal('show');

                    $('#vacancy-form input, #vacancy-form select, #vacancy-form textarea').not('input[name=type]').val('');
                    $('.attach-avatar').text('Прикрепите Ваше резюме');
                } else {
                    for (var input in response.errors) {
                        if (input === 'cv_path' || input === 'vacancy') {
                            $('input[name=' + input + ']').parent().addClass('error');
                            $('select[name=' + input + ']').parent().addClass('error');
                        } else {
                            $('#modal-join-us input[name=' + input + ']').addClass('error');
                            $('#modal-join-us select[name=' + input + ']').addClass('error');
                        }
                    }
                }
            },
            complete: function () {
                $('#gg-material-loading').fadeOut('slow');
                $submitBtn.prop('disabled', false);
            }
        });
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

    /**__FAQ_SEARCH__**/

    function faqSearchAjax(str)
    {
        $.ajax({
            type: 'post',
            url: host + "/faq/middleware",
            data: {search: str}
        });
    }

    // $('#btnSearchQuestion').on('click', function () {
    //     var search = $('[name = "questions_field"]').val();
    //     faqSearchAjax(search);
    // });

    $('.faq-search-form').on('submit', function () {
        var search = $('.faq-search-field').val();
        faqSearchAjax(search);
        return false;
    });

    $('.country-select').select2({
        placeholder: 'Страна'
    });

    $('.room-select').select2({
        placeholder: 'Номер'
    });

    $('.hotelReview-select').select2({
        placeholder: 'Выберите отель'
    });

    /**__SIGNUP_LOGIN_MODALS__**/
    $('.signup-link').on('click', function () {
        $('#modal-login').modal('hide');
    });

    $('.password-reset-request').on('click', function () {
        $('#modal-login').modal('hide');
    });
    // $('#modal-confirm-sign-up').modal('show');
    var url = location.search;
    var urlStr = url.toString();
    if (urlStr.indexOf('modal=reset-password') + 1) {
        var token = urlStr.replace('?modal=reset-password&token=', '');
        $('#modal-reset-password').modal('show');
    }
    if (urlStr.indexOf('modal=confirm') + 1) {
        $('#modal-confirm-sign-up').modal('show');
    }
    if (urlStr.indexOf('modal=confirm-success') + 1) {
        $('#modal-confirm-sign-up-success').modal('show');
    }

    // Country "useful info" block toggle
    $('.btn-expand-info').on('click', function () {
        $(this).prev('.text-content').addClass('is-expanded');
        $(this).addClass('d-none');
    });
});