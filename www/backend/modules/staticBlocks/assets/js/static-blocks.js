$(document).ready(function(){
    console.log('STATIC_BLOCKS');

    $('.title-translit').liTranslit({
        elAlias: $('.alias-translit')
    });

    $('body').on('change','.change_status',function(){
        var obj = $(this);
        var checked = obj.is(':checked') ? 1 : 0;
        var block = obj.data('block');
        var url = obj.data('url');
        var id = obj.data('id');
        var data = {
            id:id,
            checked:checked,
            block:block
        };
        $.ajax({
            url: url,
            type:'post',
            data:data
        })
    });
});