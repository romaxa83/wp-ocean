function getCity(country_id) {
    $.ajax({
        url: host + '/admin/seoSearch/seo-search/get-city',
        type: 'POST',
        data: {country_id: country_id},
        success: function (data) {
            $('#select_city_id').empty();
            var data = JSON.parse(data);
            var newOption = [];
            data.forEach(function (o, i) {
                newOption.push(new Option(o.name, o.id, false, false));
            });
            $('#select_city_id').append(newOption).val(0).trigger('change');
        }
    });
}
$(document).ready(function () {
//    if ($('#select_country_id').length){
//        getCity($('#select_country_id').val());
//    }
    $('#select_country_id').on('change', function () {
        var country_id = $(this).val();
        getCity(country_id);
    });
});