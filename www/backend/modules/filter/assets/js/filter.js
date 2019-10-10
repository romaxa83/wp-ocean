var city = {};
var city_default = 0;
var hotel = {};
var hotel_default = 0;
function setJsonDataCity(country_id) {
    var temp = [];
    $('#city_list tbody .city_box').each(function () {
        var checkbox = $(this).find('input[type="checkbox"]');
        var radio = $(this).find('input[type="radio"]');
        if (checkbox.is(':checked')) {
            temp.push(checkbox.data('id'));
        }
        if (radio.is(':checked')) {
            city_default = radio.data('id');
        }
    });
    if (country_id != 0) {
        city[country_id] = temp;
        city.default = city_default;
        $('#city_textarea').text(JSON.stringify(city));
    }
}
function getJsonDataCity(country_id) {
    var text = $('#city_textarea').text();
    if (text) {
        var city = JSON.parse(text);
        return {
            city: city[country_id],
            default: city.default
        };
    }
}
function setJsonDataHotel(country_id, city_id) {
    var temp = [];
    $('#hotel_list tbody .hotel_box').each(function () {
        var checkbox = $(this).find('input[type="checkbox"]');
        var radio = $(this).find('input[type="radio"]');
        if (checkbox.is(':checked')) {
            temp.push(checkbox.data('id'));
        }
        if (radio.is(':checked')) {
            hotel_default = radio.data('id');
        }
    });
    if (country_id != 0 && city_id != 0) {
        if (hotel[country_id] == undefined) {
            hotel[country_id] = {};
        }
        hotel[country_id][city_id] = temp;
        hotel.default = hotel_default;
        $('#hotel_textarea').text(JSON.stringify(hotel));
    }
}
function getJsonDataHotel(country_id, city_id) {
    var text = $('#hotel_textarea').text();
    if (text) {
        if (country_id != 0 && city_id != 0) {
            var hotel_text = JSON.parse(text);
            if (hotel_text[country_id] == undefined) {
                hotel_text[country_id] = {};
                hotel_text[country_id][city_id] = [];
            }
            return {
                hotel: hotel_text[country_id][city_id],
                default: hotel_text.default
            };
        }
    }
}
function getDateTo() {
    var day = parseInt($('#date-day').val());
    var from = $('#date-from').val();
    if (isNaN(day)) {
        day = 0;
        $('#date-day').val(0);
    }
    $.ajax({
        url: host + "/admin/filter/filter/get-date-to",
        type: "POST",
        data: {day: day, from: from},
        success: function (data) {
            $('#date-date-to').val(data);
            $('#date-date-from').val(from);
        }
    });
}
$(document).ready(function () {
//    $('a[href="#tab_2"]').click();
//    $('a[href="#tab_2_4"]').click();

    if ($('#city_textarea').length > 0) {
        city = JSON.parse($('#city_textarea').text());
        city_default = city.default;
    }
    if ($('#hotel_textarea').length > 0) {
        hotel = JSON.parse($('#hotel_textarea').text());
        hotel_default = hotel.default;
    }
    var fixHelperModified = function (e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function (index) {
            $(this).width($originals.eq(index).outerWidth());
        });
        return $helper;
    };
    $('.sortable tbody').sortable({
        placeholder: 'ui-state-highlight',
        axis: "y",
        cursor: "move",
        helper: fixHelperModified,
        update: function (event, ui) {
            if (ui.item.find('[type="radio"]').attr('checked') == 'checked') {
                ui.item.find('[type="radio"]').prop('checked', true);
            }
        }
    }).disableSelection();
    $('.box-check-all').append('<input style="margin-left: 10px;vertical-align: sub;"type="checkbox" class="check-all" title="Выбрать все" />');
    $('body').on('click', '.check-all', function () {
        var obj = $(this).parents('table');
        if ($(this).is(':checked')) {
            obj.find('.custome-checkbox-status').each(function (index, element) {
                $(element).val(1).prop('checked', true);
            });
            obj.find('.position').each(function (index, element) {
                $(element).children().removeClass('disabled');
                $(element).find('input[type="radio"]').prop('disabled', false);
            });
        } else {
            obj.find('.custome-checkbox-status').each(function (index, element) {
                $(element).val(0).prop('checked', false);
            });
            obj.find('.position').each(function (index, element) {
                $(element).find('input[type="radio"]').val(0);
                $(element).children().addClass('disabled');
                $(element).children().removeClass('checked');
            });
        }
    });
    getDateTo();
    $('#date-day').on('blur', function () {
        getDateTo();
    });
    $('#date-from').on('change', function () {
        getDateTo();
    });
    $('#filter-price-to').on('change', function () {
        var from = parseInt($('#filter-price-from').val());
        var to = parseInt($(this).val());
        if (to < from) {
            $(this).attr('value', from).val(from);
        }
    });
    $('#filter-price-from').on('change', function () {
        var from = parseInt($(this).val());
        var to = parseInt($('#filter-price-to').val());
        if (from > to) {
            $('#filter-price-to')
                    .prop('min', parseInt($(this).val()))
                    .attr('value', parseInt($(this).val()))
                    .val($(this).val());
        }
    });
    $('#extra_options').on('click', function () {
        var countries = [];
        $('.country_status:checkbox:checked').each(function () {
            var temp = $(this).attr('id').split("_");
            countries.push(temp[temp.length - 1]);
        });
        $.ajax({
            url: host + "/admin/filter/filter/get-list-country",
            type: "POST",
            data: {country_id: countries},
            success: function (data) {
                var data = JSON.parse(data);

                var newOption1 = [];
                data.forEach(function (o, i) {
                    newOption1.push(new Option(o.name, o.cid, false, false));
                });
                $('#city_country_id').empty().append(newOption1).val(0);

                var newOption2 = [];
                data.forEach(function (o, i) {
                    newOption2.push(new Option(o.name, o.cid, false, false));
                });
                $('#hotel_country_id').empty().append(newOption2).val(0);
            }
        });
    });
    $('#city_country_id').on('change', function () {
        var prev_country_id = ($(this).data('id')) ? $(this).data('id') : 0;
        var country_id = $(this).val();
        $(this).data('id', country_id);
        setJsonDataCity(prev_country_id);
        var city = getJsonDataCity(country_id);
        $.ajax({
            url: host + "/admin/filter/filter/get-data-city",
            type: "POST",
            async: false,
            data: {country_id: country_id, city: city},
            success: function (data) {
                $('#city_list tbody').empty().append(data);
                $('.custom-radio').iCheck({
                    radioClass: 'iradio_minimal-red'
                });
            }
        });
    });
    $('#hotel_country_id').on('change', function () {
        var country_id = $(this).val();
        $('#city_country_id').change();
        $.ajax({
            url: host + "/admin/filter/filter/get-list-city",
            type: "POST",
            data: {city_id: city[country_id]},
            success: function (data) {
                var data = JSON.parse(data);
                var newOption = [];
                data.forEach(function (o, i) {
                    newOption.push(new Option(o.name, o.cid, false, false));
                });
                $('#hotel_city_id').empty().append(newOption).val(0);
                $('#hotel_list tbody').empty();
            }
        });
    });
    $('#hotel_city_id').on('change', function () {
        var prev_country_id = ($('#hotel_country_id').data('id')) ? $('#hotel_country_id').data('id') : 8;
        var prev_city_id = ($(this).data('id')) ? $(this).data('id') : 0;
        var country_id = $('#hotel_country_id').val();
        var city_id = $(this).val();
        $(this).data('id', city_id);
        $('#hotel_country_id').data('id', country_id);
        setJsonDataHotel(prev_country_id, prev_city_id);
        var hotelData = getJsonDataHotel(country_id, city_id);
        $.ajax({
            url: host + "/admin/filter/filter/get-data-hotel",
            type: "POST",
            data: {city_id: city_id, hotel: hotelData},
            success: function (data) {
                $('#hotel_list tbody').empty().append(data);
                $('.custom-radio').iCheck({
                    radioClass: 'iradio_minimal-red'
                });
            }
        });

    });
    $('.custom-radio').on('ifClicked', function () {
        $(this).parents('tbody').find('.iradio_minimal-red').each(function () {
            $(this).removeClass('checked');
            $(this).find('input').removeAttr('checked');
        });
        $(this).attr('checked', 'checked');
    });
    $('.save-filter-btn').on('click', function () {
        $('#city_country_id').change();
        $('#hotel_city_id').change();
        $.ajax({
            url: host + "/admin/filter/filter/render-link",
            type: "POST",
            data: {
                country: $('#filter_country tbody tr input[type="radio"]:checked').val(),
                dept_city: $('#filter_dept_city tbody tr input[type="radio"]:checked').val(),
                city: city_default
            },
            success: function (data) {
                $('#filter-link').val(data);
                $('.save-filter').trigger('click');
            }
        });
    });
    $('body').on('click', '.custome-checkbox-status', function () {
        var tr = $(this).parents('tr');
        if ($(this).is(':checked')) {
            tr.find('input[type="radio"]').prop('disabled', false);
            tr.find('.position').children().removeClass('disabled');
        } else {
            if (tr.find('input[name="City[default]"]').is(':checked')) {
                city_default = 0;
            }
            if (tr.find('input[name="Hotel[default]"]').is(':checked')) {
                hotel_default = 0;
            }
            tr.find('input[type="radio"]').prop('checked', false);
            tr.find('input[type="radio"]').prop('disabled', true);
            tr.find('.position').children().addClass('disabled');
            tr.find('.position').children().removeClass('checked');
        }
    });

    $('input[name="Length[min]"]').on('blur', function () {
        var val = parseInt($(this).val());
        var max = parseInt($('input[name="Length[max]"]').val());
        if (isNaN(val) || val <= 0) {
            $(this).val(1);
        }
        if (val > max) {
            $(this).val(max);
        }
    });

    $('input[name="Length[max]"]').on('blur', function () {
        var val = parseInt($(this).val());
        if (isNaN(val) || val <= 0) {
            $(this).val(1);
        }
        if (val > 21) {
            $(this).val(21);
        }
    });

    $('input[name="Length[min_default]"]').on('blur', function () {
        var val = parseInt($(this).val());
        var max = parseInt($('input[name="Length[max]"]').val());
        var max_default = parseInt($('input[name="Length[max_default]"]').val());
        if (isNaN(val) || val <= 0) {
            $(this).val(1);
        }
        if (val > max) {
            $(this).val(max);
        }
        if (val > max_default) {
            $(this).val(max_default);
        }
    });

    $('input[name="Length[max_default]"]').on('blur', function () {
        var val = parseInt($(this).val());
        var max = parseInt($('input[name="Length[max]"]').val());
        var min_default = parseInt($('input[name="Length[min_default]"]').val());
        if (isNaN(val) || val <= 0) {
            $(this).val(1);
        }
        if (val > max) {
            $(this).val(max);
        }
        if (val < min_default) {
            $('input[name="Length[min_default]"]').val(val);
        }
    });

});
