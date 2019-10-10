
function setMediaIds(id){

    var data = jQuery.parseJSON($("#hotelreviewform-hide_media").val());
    data.push(id);
    $("#hotelreviewform-hide_media").val(JSON.stringify(data));


}
function getMediaIds(data){
    var ids = $("#hotelreviewform-hide_media").val();
    data.id = ids;
    console.log(ids);
}


function addImageToGallery(id,url) {
    $.ajax({
        type:'post',
        url: host + '/admin/blog/hotel-review/add-img-to-gallery',
        data:{id:id,url:url}
    })
}

$(document).ready(function(){
   console.log('BLOG');

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

    $('.post-index').on('change','.position_in_main',function(){
        var obj = $(this);
        var value = obj.val();
        var url = obj.data('url');
        var post_id = obj.data('post-id');
        var data = {
            position:value,
            post_id:post_id
        };
        $.ajax({
            url: url,
            type:'post',
            data:data
        })
    });

    $('#hotelreviewform-media_ids-btn').on('click',function () {
        $("#hotelreviewform-hide_media").val('[]');
    });

    $('.remove-media-review').on('click',function (){
        var obj = $(this);
        var data = {
            media_id:obj.data('media-id'),
            hotel_review_id:obj.data('post-id')
        };
        $.ajax({
            url: obj.data('url'),
            type:'post',
            data:data
        })
    });
});
