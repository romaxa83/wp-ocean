$(document).ready(function(){
    console.log('FAQ');

    $('.title-translit').liTranslit({
        elAlias: $('.alias-translit')
    });

    $('body').on('change','.change_status',function(){
        var obj = $(this);
        var checked = obj.is(':checked') ? 1 : 0;
        var type = obj.data('type');
        var url = obj.data('url');
        var id = obj.data('id');
        var data = {
            id:id,
            checked:checked,
            type:type
        };
        $.ajax({
            url: url,
            type:'post',
            data:data
        })
    });

    $('.rate-faq').on('blur',function(){
        var obj = $(this);
        var data = {
            value:obj.val(),
            page:obj.data('page'),
            id:obj.data('id')
        };
        $.ajax({
            url: host + '/admin/faq/faq/change-rate',
            type:'post',
            data:data
        });
    });
});