$(document).ready(function () {
    $('table tr td:not(input)').on('click', function () {
        var text = $(this).text();
        if ($(this).find('input').length == 0) {
            $(this).empty().append('<input class="form-control" value="' + text + '" />');
        }
    });

    $('.save').on('click', function () {
        var data = [];
        var action = $(this).data('action');
        $(this).parents('.box').find('table tbody tr').each(function (i, o) {
            if ($(o).data('key')) {
                data.push({
                    key: $(o).data('key'),
                    name: $(o).find('td:first-child').text() || $(o).find('td:first-child input').val(),
                    value: $(o).find('td:last-child').text() || $(o).find('td:last-child input').val()
                });
            }
        });
        $.ajax({
            url: host + '/admin/settings/settings/save',
            type: 'POST',
            data: {
                action: action,
                data: data
            },
            success: function () {
                window.location.reload();
            }
        });
    });
});