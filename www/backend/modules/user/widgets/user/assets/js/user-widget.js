$(document).ready(function(){
    console.log('USER_WIDGET');

    // //скрипт для уведомления не заполненных поле
    // var empty_field = '';
    // var phone = $('#usereditform-phone').val();
    // if(phone === ''){
    //     empty_field += 'Телефон \n';
    // }
    // var form_passport = $('#form-passport').find('input');
    //
    // form_passport.each(function(){
    //     if($(this).val() === ''){
    //         var id = $(this).attr('id');
    //         var label = $('[for = "'+ id +'"]').text();
    //         empty_field += label+'\n';
    //     }
    // });
    //
    // if(empty_field !== ''){
    //     $('.cabinet-settings-navbar').append('<span class="badge" title="Заполните поля : \n'+ empty_field +'" style="float:right">' +
    //         '<span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></span>');
    // }
});