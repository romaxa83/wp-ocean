$(document).ready(function(){
    console.log('USER');

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

    $('.password_eye').on('click', function () {
        if ($(this).next().attr('type') == 'password') {
            $(this).next().attr('type', 'text');
            $(this).children('i').attr('class', '');
            $(this).children('i').addClass('fa fa-eye-slash');
        } else {
            $(this).next().attr('type', 'password');
            $(this).children('i').attr('class', '');
            $(this).children('i').addClass('fa fa-eye');
        }
    });


    $('#userform-role').on('change',function(){
        $('.passport-form').hide();
        var role = $(this).val();
        if(role === 'user'){
            $('.passport-form').show()
        }
    });
    if(window.location.href.indexOf('update') > -1){
        $('.passport-form').hide();
        var role = $('#userform-role').val();
        if(role === 'user'){
            $('.passport-form').show()
        }
    }

    $('.permission-all-check').on('change',function () {
        if(this.checked){
            $('.permission-check').each(function(){
                if(!$(this).is(':checked')){
                    $(this).attr('checked',true)
                }
            });
        }else{
            $('.permission-check').each(function(){
                $(this).attr('checked',false)

            });
        }
    });

    $('.role-index').on('click','[name = "role"]',function(){
        if($('.permission-all-check').is(':checked')){
            $('.permission-all-check').prop("checked",false);
        }
        var role = $(this).val();
        var groupName = $('.group-permission').val();
        $.ajax({
            type:'post',
            url:host+'/admin/user/rbac/render-check-permission',
            data:{role:role,groupName:groupName},
            success:function(res){
                $('.allPermissions').empty();
                $('.allPermissions').append(res);
            }
        });
    });

    function error(type){
        var obj = {
            role:'allRoles',
            perm:'allPermissions'
        };

        $('.'+obj[type]+' .error').show(500);
        setTimeout(function(){
            $('.error').hide(500);
        },3000);
    }

    $('.role-index').on('click','.attach-permission',function(){
        var xhr = true;
        var role = $('[name = "role"]:checked').val();
        var group = $('.group-permission').val();
        var permissions = [];
        $('.permission-check').each(function(){
            if($(this).is(':checked')){
                permissions.push($(this).data('perm'));
            }
        });
        if(permissions.length === 0){
            error('perm');
            xhr = false;
        }
        if(role === undefined){
            error('role');
            xhr = false;
        }
        var data = {
            role:role,
            permissions:permissions,
            group:group
        };
        if(xhr){
            $.ajax({
                type:"post",
                url:host+'/admin/user/rbac/attach-permission',
                data:data,
                success:function (res) {
                    $('.allRoles').empty();
                    $('.allRoles').append(res);
                    $('.allRoles .success').append('К роли ('+ role +') прикреплены новые разрешения').show(500);
                    setTimeout(function(){
                        $('.allRoles .success').hide(500);
                        $('.allRoles .success').empty();
                    },3000);
                }
            });
        }
    });

    $('.role-index').on('click','.info-rbac-show',function(){
        $('.info-rbac').show(1000);
        $(this).text('Скрыть справку');
        $(this).removeClass('info-rbac-show').addClass('info-rbac-hide');
    });

    $('.role-index').on('click','.info-rbac-hide',function(){
        $('.info-rbac').hide(1000);
        $(this).text('Справка');
        $(this).removeClass('info-rbac-hide').addClass('info-rbac-show');
    });

    $('.group-permission').on('change',function () {
        if($('.permission-all-check').is(':checked')){
            $('.permission-all-check').prop("checked",false);
        }

        var groupName = $(this).val();
        var role = $('[name = "role"]:checked').val();
        $.ajax({
            type:'post',
            url:host+'/admin/user/rbac/get-group-permissions',
            data:{role:role,groupName:groupName},
            success:function(res){
                $('.allPermissions').empty();
                $('.allPermissions').append(res);
            }
        });
    });

    $('.allRoles').on('click','.remove-role',function () {
        if(confirm('Вы уверены что хотите удалить роль "'+ $(this).attr('data-role-name') +'" ?')){
            $.ajax({
                type:'post',
                url:host+'/admin/user/rbac/remove-role',
                data:{role:$(this).attr('data-role')},
                success:function(res){
                    if(res){
                        $('.allRoles').empty();
                        $('.allRoles').append(res);
                    } else {
                        alert('Нельзя удалить роль к которой привязан пользователь.');
                    }
                }
            });
        }
    });

    function generateSelectForRole(data,className)
    {
        var select = '<select class="form-control '+ className +'">';
        for(var role in data){
            select += '<option value="'+role+'">'+ data[role] +'</option>';
        }
        select += '</select>';
        $('.roles-panel').empty().html(select);
    }

    $('.add-roles').on('click',function(){
        $.ajax({
            type:'post',
            url:host+'/admin/user/rbac/free-roles',
            data:{role:$(this).data('roles'),id:$('.roles-panel').attr('data-id')},
            success:function(res){
                generateSelectForRole($.parseJSON(res),'free-roles');
            }
        })
    });

    $('.remove-roles').on('click',function(){
        $.ajax({
            type:'post',
            url:host+'/admin/user/rbac/attach-roles',
            data:{role:$(this).data('roles'),id:$('.roles-panel').attr('data-id')},
            success:function(res){
                generateSelectForRole($.parseJSON(res),'remove-attach-roles');
            }
        })
    });

    $('.roles-panel').on('click','.free-roles',function(){
        $.ajax({
            type:'post',
            url:host+'/admin/user/rbac/attach-role-for-user',
            data:{role:$(this).val(),id:$('.roles-panel').attr('data-id')}
        });
    });

    $('.roles-panel').on('click','.remove-attach-roles',function(){
        $.ajax({
            type:'post',
            url:host+'/admin/user/rbac/detached-role-for-user',
            data:{role:$(this).val(),id:$('.roles-panel').attr('data-id')}
        });
    });
});