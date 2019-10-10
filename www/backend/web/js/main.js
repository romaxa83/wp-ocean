var protocol = location.protocol;
var slashes = protocol.concat("//");
var port = location.port;
var path = $('body').data('url');
var host = (port) ? slashes.concat(window.location.hostname) + ':' + port : slashes.concat(window.location.hostname);

$(document).ready(function () {
    $('.custom-checkbox, .custom-radio').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });
    $('.custome-checkbox').on('click', function () {
        var obj = $(this);
        var val = parseInt(obj.val());
        val = (val === 1) ? 0 : 1;
        obj.attr('value', val);
        if (obj.data('url'))
            $.post(obj.data('url'), {id: obj.data('id'), value: val, name: obj.attr('name')});
    });
    
    $('button[type="reset"]').on('click', function(){
        $(".select2-hidden-accessible").select2("val", 0);
    });

    $('.more-info-order').on('click',function(){
        xhr = true;
        var url = $(this).data('url');
        var id = $(this).data('id');
        var next = $('[data-key = "'+ id +'"]').next();
        if(next.hasClass('tr-more-info')){
            xhr = false;
            next.remove();
        }
        if(xhr){
            $.ajax({
                url:url,
                type:'post',
                success:function(res){
                    $('[data-key = "'+ id +'"]').after(res);
                }
            });
        }
    });
});