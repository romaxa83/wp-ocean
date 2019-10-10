
function renderContentView() {
    var data = $('#gallery-data').val();
    $.ajax({
        type: 'POST',
        url: host + '/admin/referenceBooks/hotel/render-content-view',
        data: {
            hotel: data,
            media_id: $('input[name="Hotel[id]"]').val()
        },
        success: function (data) {
            $('#media-content').empty().append(data);
        },
        async: false
    });
}
function setContentView(id) {
    var data = JSON.parse($("#gallery-data").val());
    data.push(id);
    $("#gallery-data").val(JSON.stringify(data));
}
function setHotelService(data) {
    $('#hotel_service_data').text(JSON.stringify(data));
}
function getHotelService() {
    return JSON.parse($('#hotel_service_data').text());
}
function addHotelService(data) {
    var hotel_service = getHotelService();
    hotel_service['insert'].push({
        hotel_id: $('#hotel_service_data').data('id'),
        hid: parseInt($('#hotel_service_data').data('hid')),
        service_id: data.id,
        type: data.include,
        price: data.price
    });
    setHotelService(hotel_service);
}
function removeHotelService(data) {
    var hotel_service = getHotelService();
    hotel_service['delete'].push(data);
    setHotelService(hotel_service);
}
function getCountryList() {
    console.log(1);
}
$(document).ready(function () {
    if ($('#hotel-form #media-content').length > 0) {
        renderContentView();
    }
    $('.referenceBooks-country-form #country-name').liTranslit({
        elAlias: $('.referenceBooks-country-form #country-alias')
    });
    if (window.location.href.indexOf("create") > -1) {
        $('.referenceBooks-hotel-form #hotel-name').liTranslit({
            elAlias: $('.referenceBooks-hotel-form #hotel-alias')
        });
    }

    $('.control-page').blur(function () {
        var obj = $(this);
        var page = parseInt(obj.val());
        $.post(obj.data('href'), {page: page});
    });

    $('form').on('afterValidate', function () {
        if ($('.has-error').length > 0) {
            var id = $('.has-error').first().parents('.tab-pane').attr('id');
            $('a[href="#' + id + '"]').click();
        }
    });

    var fixHelperModified = function (e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function (index) {
            $(this).width($originals.eq(index).outerWidth());
        });
        return $helper;
    };

    $('#sortable tbody').sortable({
        placeholder: 'ui-state-highlight',
        axis: "y",
        cursor: "move",
        helper: fixHelperModified,
        update: function (event, ui) {
            var url = $('#sortable').data('url');
            var data = $(this).sortable('serialize');
            $.post(url, data);
        }
    }).disableSelection();

    $('#entertainment-form #entertainment-country_id').on('change', function () {
        var id = $(this).val();
        $.post(host + '/admin/referenceBooks/entertainment/get-city', {id: id}, function (data) {
            var data = JSON.parse(data);
            $('#entertainment-city_id').empty().removeAttr('disabled');
            var newOption = [];
            data.forEach(function (o, i) {
                newOption.push(new Option(o.name, o.cid, false, false));
            });
            $('#entertainment-city_id').append(newOption).trigger('change');
        });
    });

    if ($('#entertainment-form #entertainment-country_id').length > 0) {
        var value = $('#entertainment-form #entertainment-country_id').val();
        $('#entertainment-form #entertainment-country_id').change();
    }

    $('#hotel-form #hotel-country_id').on('change', function () {
        var id = $(this).val();
        $.post(host + '/admin/referenceBooks/entertainment/get-city', {id: id}, function (data) {
            var data = JSON.parse(data);
            $('#hotel-city_id').empty().removeAttr('disabled');
            var newOption = [];
            data.forEach(function (o, i) {
                newOption.push(new Option(o.name, o.cid, false, false));
            });
            var city = $('#hotel-city_id').append(newOption);
            ($('#hotel-city_id').data('id')) ? city.val($('#hotel-city_id').data('id')) : city.val(null);
            city.trigger('change');
        });
    });

    if ($('#hotel-form #hotel-country_id').length > 0) {
        if ($('#hotel-form #hotel-country_id').val()) {
            $('#hotel-form #hotel-country_id').change();
        }
    }

    $('#hotel-form #service-type').on('change', function () {
        var id = $(this).val();
        $.post(host + '/admin/referenceBooks/hotel/get-services-name', {id: id}, function (data) {
            var data = JSON.parse(data);
            $('#service-name').empty().removeAttr('disabled');
            var newOption = [];
            data.forEach(function (o, i) {
                newOption.push(new Option(o.name, o.id, false, false));
            });
            $('#service-name').append(newOption).trigger('change');
        });
    });

//    if ($('#hotel-form #hotel-country_id').length > 0) {
//        if ($('#hotel-form #hotel-country_id').val()) {
//            $('#hotel-form #hotel-country_id').change();
//        }
//    }

    $('#add-service').on('click', function () {
        var flag = true;
        var type = $('#service-type').select2('data');
        var name = $('#service-name').select2('data');
        var data = {
            id: name[0].id,
            type: type[0].id,
            name: name[0].text,
            include: $('#service-include').val(),
            price: $('#service-price').val()
        };
        var a = $('#hotel-form a[href="#' + data.type + '"]');
        if (a.attr('class'))
            a.click();
        a.parents('.panel').find('td.field-id').each(function (i, o) {
            if (parseInt($(o).text()) == data.id) {
                flag = false;
            }
        });
        if (flag) {
            a.parents('.panel').find('table .empty').parents('tr').remove();
            a.parents('.panel').find('table tbody').append('<tr>\n\
            <td>#</td><td class="field-id">' + data.id + '</td>\n\
            <td>' + data.name + '</td>\n\
            <td><input type="checkbox" id="service-include-' + data.id + '" class="tgl tgl-light custome-checkbox" name="service-include-' + data.id + '" value="' + data.include + '" ' + ((data.include == 1) ? 'checked' : '') + '>\n\
            <label class="tgl-btn" title="Включено в стоимость" for="service-include-' + data.id + '"></label></td>\n\
            <td class="service-price-edit">' + data.price + '</td><td>\n\
            <a title="Удалить" class="delete-service" data-id="' + data.id + '"><span class="glyphicon glyphicon-trash"></span></a>\n\
            </td></tr>');
            addHotelService(data);
        }
    });
    $('body').on('click', '.service-price-edit', function () {
        var value = parseFloat($(this).text());
        if (!isNaN(value))
            $(this).empty().append('<input class="form-control" type="number" min="0" value="' + value + '" />');
    });
    $('body').on('blur', '.service-price-edit', function () {
        var value = parseFloat($(this).find('input').val());
        $(this).empty().text(value);
    });
    $('body').on('click', '.delete-service', function () {
        removeHotelService($(this).data('id'));
        $(this).parents('tr').remove();
    });


    if ($('.gallery-box-content').length) {
        $('#sortable').sortable({
            placeholder: '',
            containment: $('.gallery-box-content'),
            update: function (event, ui) {
                var gallery = getGalleryJSON();
                setGalleryJSON(gallery);
                $.ajax({
                    type: 'POST',
                    url: host + '/admin/product/product/update-position',
                    data: {'gallery': gallery}
                });
            }
        }).disableSelection();
    }
    $('body').on('click', '.gallery-box-item-delete', function () {
        $(this).parents('.gallery-box-item').remove();
        var gallery = getGalleryJSON();
        setGalleryJSON(gallery);
        return false;
    });

    $('body').on('click', '.delete-item-gallery', function () {
        var id = $(this).data('id');

        var data = JSON.parse($('#gallery-data').val());
        data.splice(data.indexOf(id), 1);
        $("#gallery-data").val(JSON.stringify(data));

        $(this).parents('tr').remove();
        return false;
    });

    $('.referenceBooks-tour-index #filter-to').change(function () {
        var val = $(this).val();
        $('.box-to').removeClass('show').addClass('hide');
        console.log($('.filter-city'));
        $('.filter-' + val).parents('.box-to').removeClass('hide').addClass('show');
    });

    $('.referenceBooks-tour-index .search-form').on('click', function () {
        var data = $(this).parents('form');
        var page = ($(this).attr('data-page')) ? $(this).attr('data-page') : 1;
        $.ajax({
            type: 'POST',
            url: host + '/admin/referenceBooks/tour/get-api-tour',
            data: data.serialize() + '&page=' + page,
            beforeSend: function () {
                $('.tour-api-error-box').empty();
                $('.referenceBooks-tour-index .loader').removeClass('hide');
                $('.search-form.page').addClass('hide');
            },
            success: function (data) {
                var data = JSON.parse(data);
                if (data.type == 'error') {
                    $('.tour-api-error-box').append(data.data);
                    $('.search-form.page').addClass('hide');
                }
                if (data.type == 'success') {
                    if (data.page == 1) {
                        $('#tour-api').empty();
                    }
                    $('#tour-api').append(data.data);
                    if (data.count > 0) {
                        $('.search-form.page').attr('data-page', data.next_page).removeClass('hide');
                    } else {
                        $('.search-form.page').addClass('hide');
                    }
                }
                $('.referenceBooks-tour-index .loader').addClass('hide');
            }
        });
    });
    $('.referenceBooks-tour-index').on('click', '.add-api-tour', function () {
        var obj = $(this);
        var id = obj.data('id');
        var hid = obj.data('hid');
        var info = JSON.stringify(obj.data('info'));
        var main = $(this).parents('tr').find('select[name="main"]').val();
        var recommend = $(this).parents('tr').find('select[name="recommend"]').val();
        var hot = $(this).parents('tr').find('select[name="hot"]').val();
        var data = $('form').serialize();
        data += '&id=' + id + '&main=' + main + '&info=' + info + '&recommend=' + recommend + '&hot=' + hot + '&hid=' + hid;
        $.ajax({
            type: 'POST',
            url: host + '/admin/referenceBooks/tour/add-api-tour',
            data: data,
            success: function (data) {
                obj.empty();
            }
        });
        return false;
    });
    $('.referenceBooks-tour-index').on('change', '.main-fasten', function () {
        var $self = $(this);
        $('.main-fasten').each(function () {
            if ($(this).val() === $self.val() && !$(this).is($self)) {
                $(this).val(0);
            }
        });
    });

    $('.referenceBooks-tour-index').on('change', '.recommend-fasten', function () {
        var $self = $(this);
        $('.recommend-fasten').each(function () {
            if ($(this).val() === $self.val() && !$(this).is($self)) {
                $(this).val(0);
            }
        });
    });

    $('.referenceBooks-tour-index').on('change', '.hot-fasten', function () {
        var $self = $(this);
        $('.hot-fasten').each(function () {
            if ($(this).val() === $self.val() && !$(this).is($self)) {
                $(this).val(0);
            }
        });
    });

//    $('#tour-price').on('change, blur', function () {
//        var price = parseFloat($('#tour-price').val());
//        var old_price = parseFloat($('#tour-old_price').val());
//        var price = 100 - ((price/old_price) * 100);
//        $('#tour-sale').val(price.toFixed(2));
//    });
//
//    $('#tour-sale').on('change, blur', function () {
//        var price = parseFloat($('#tour-price').data('value'));
//        var tour_sale = parseInt($('#tour-sale').val());
//        var price = price - (price * tour_sale) / 100;
//        $('#tour-old_price').val(price.toFixed(2));
//    });

    var $tourTable = $('#tour-table');
    var fixedColsSelector = 'th:first-child, td:first-child, th:last-child, td:last-child';

    $tourTable.find(fixedColsSelector).each(function(_, el) {
        var $el = $(el);
        var height = 0;

        if ($el.next().length) {
            height = $el.next().height();
        } else {
            height = $el.prev().height();
        }

        if (!document.documentElement.classList.contains('is-ff')) {
            $el.height(height + 1);
        } else {
            $el.height(height);
        }
    });

    $tourTable.css({ opacity: 1, position: 'initial' });
});
