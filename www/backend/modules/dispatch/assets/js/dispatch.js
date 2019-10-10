$(document).ready(function(){
    console.log('DISPATCH');
    var xhr = true;

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
        console.log(data);
        $.ajax({
            url: url,
            type:'post',
            data:data
        })
    });

    //отправка письма
    $('body').on('click','.send-letter',function(){
        var id = $(this).data('id-letter');
        $.ajax({
            url:host + '/admin/dispatch/news-letter/choose-subscribers',
            type: 'post',
            data:{'id':id},
            success:function(res){
                $('[data-key = "'+ id +'"]').after(res);
                $('[data-id-letter = "'+ id +'"]')
                    .removeClass('send-letter')
                    .removeClass('fa-telegram')
                    .addClass('hide-all-email')
                    .addClass('fa-eye-slash');
            }
        });
    });

    $('body').on('click','.hide-all-email',function(){
        var letter_id = $(this).data('id-letter');
        $('[data-table-for = "'+ letter_id +'"]').hide();
        $(this)
            .removeClass('hide-all-email')
            .removeClass('fa-eye-slash')
            .addClass('fa-telegram')
            .addClass('send-letter');
    });

    $('body').on('click','.check-all-email',function(){
        var letter_id = $(this).data('letter-id');
        var check = $(this).is(':checked');
        var all_checkbox = $('[data-id-letter-checkbox = "'+ letter_id +'"]');
        all_checkbox.each(function(){
            $(this).prop('checked',check)
        });
    });
    //отправка писем по выбраным email
    $('body').on('click','.real-send',function(){
        var letter_id = $(this).data('letter-id');
        var arr = [];
        var all_checkbox = $('[data-id-letter-checkbox = "'+ letter_id +'"]');
        all_checkbox.each(function(){
            if($(this).is(':checked')){
                arr.push($(this).data('id-subscriber'));
            }
        });
        var data = {
            letter_id:letter_id,
            arr_subscribers:arr
        }
        if(arr == ''){
            xhr = false;
            alert('Выберите адреса для рассылки')
        }
        if(xhr){
            $.ajax({
                url:host + '/admin/dispatch/news-letter/send-emails',
                type:'post',
                data:data,
                success:function(){
                    $('.tr-more-info').empty();
                    $.ajax({
                        url:host + '/admin/dispatch/news-letter/start-dispatch',
                        type:'post',
                        data:{letter_id:letter_id},
                        success:function(res){
                            $('.progress-cell-'+letter_id).empty();
                            $('.progress-cell-'+letter_id).append(res);
                            $('.progress-status-cell-'+letter_id).empty();
                            $('.progress-status-cell-'+letter_id).append('<span class="label label-info">Рассылка стартовала</span>');
                            progressDispatch(letter_id);
                        }
                    });
                }
            });
        }
    });

    if($('div').is('.progress-for-dispatch-letter')){
        letterId = $('.progress').attr('data-letter-id');
        progressDispatch(letterId);
    }

    function progressDispatch(letter_id){
            $.ajax({
                url:host + '/admin/dispatch/news-letter/progress-dispatch',
                type:'post',
                data:{letter_id:letter_id},
                success:function(res){
                    if(res){
                        $('.progress-cell-'+letter_id).empty();
                        $('.progress-cell-'+letter_id).append(res);
                        setTimeout(function(){
                            progressDispatch(letter_id);
                        }, 2000);
                    } else {
                        location.reload();
                    }
                }
            })
    }
});