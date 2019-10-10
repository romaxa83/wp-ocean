$('#tour-city_id').on('change', function () {
    var city_id = $(this).val();
    $.ajax({
        url: host + "/admin/referenceBooks/tour/get-list-hotel",
        type: "POST",
        data: {city_id: city_id},
        success: function (data) {
            var data = JSON.parse(data);
            var newOption = [];
            data.forEach(function (o, i) {
                newOption.push(new Option(o.name, o.hid, false, false));
            });
            $('#tour-hotel_id').empty().append(newOption).val(0);
        }
    });
});

$('.change-position').on('change', function () {
    var $self = $(this);
    var data = {
        id: $(this).data('id'),
        value: $(this).val(),
        field: $(this).attr('name')
    };
    $('td[data-attr="' + $(this).parent().data('attr') + '"] select').each(function () {
        if ($(this).val() === $self.val() && !$(this).is($self)) {
            $(this).val(0);
        }
    });
    $.ajax({
        url: host + "/admin/referenceBooks/tour/change-position",
        type: "POST",
        data: data
    });
});

$('#delete-checked-tour').on('click', function () {
    var data = [];
    $('td[data-attr="delete"]').each(function (e) {
        $(this).find('input[type=checkbox]:checked').each(function () {
            data.push($(this).val());
        });
    });
    if (data.length != 0){
        $.ajax({
            url: host + "/admin/referenceBooks/tour/delete-checked-tour",
            type: "POST",
            data: {list: data},
            success: function (data) {
                document.location.reload();
            }
        });
    } else {
        alert('Выберите туры для удаления')
    }
});

function tableFontSizeChanger() {
    $('.table').css("font-size", Number($('#font-size-changer').val()));
    $('.table select').css("font-size", Number($('#font-size-changer').val()));
    $('.table input').css("font-size", Number($('#font-size-changer').val()));
}

function calculateNewPrice() {
    var newPrice = document.getElementById("tour-price");
    var oldPrice = document.getElementById("tour-old_price");
    var sale = document.getElementById("tour-sale");
    if (Number(sale.value) === 0) {
        newPrice.value = oldPrice.value;
    } else {
        newPrice.value = oldPrice.value - (oldPrice.value * sale.value / 100);
    }
}

$(document).ready(function () {
    if (document.getElementById("tour-price")) {
        var oldPrice = document.getElementById("tour-old_price");
        var sale = document.getElementById("tour-sale");
        oldPrice.addEventListener("change", _.debounce(calculateNewPrice, 500));
        sale.addEventListener("change", _.debounce(calculateNewPrice, 500));
    }
});
