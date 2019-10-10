$('document').ready(function () {
    "use strict";

    // Configuration of menu item

    $('#select-type').on('click', function() {
        var url = $('#item-type').val();

        if(url != '') {
            $.ajax({
                url: url,
                type: 'post',
                success: function(response) {
                    $('#item-form').html(response);
                    $('#add-item').prop('disabled', true);
                }
            });
        }
    });

    $('#item-configurator').on('change', '#link, #group-title', function() {
        $('#add-item').prop('disabled', false);
    });

    $('#item-configurator').on('change', '.content-selector', function() {
        var option = $(this).find('option:selected');

        $('#title').val(option.text());
        $('#content-route').val(option.data('route'));
        $('#content-template').val(option.data('template'));
        $('#content-slug').val(option.data('slug'));
        if($('#content-parent_id').length) {
            $('#content-parent_id').val(option.data('parent_id'));
        }
        if($('#content-post_id').length) {
            $('#content-post_id').val(option.data('post_id'));
        }

        $('#step-2').removeClass('hidden');
        $('#add-item').prop('disabled', false);
    });

    $('#item-configurator').on('change', 'input[name=channelGroup]', function() {
        var option = $(this).val();

        if(option == 'records') {
            var url = $('#item-configurator').find('input[name=channel-records-action]').val();
            var channel_id = $('#item-configurator').find('#channel-main').val();

            $.ajax({
                url: url,
                type: 'post',
                data: {
                    channel_id: channel_id
                },
                success: function(response) {
                    $('#data').html(response);
                }
            });
        } else {
            var channel = $('#item-configurator').find('#channel-main').find('option:selected');
            $('.channel-record-item').remove();

            $('#title').val(channel.text());
            $('#content-route').val(channel.data('route'));
            $('#content-template').val(channel.data('template'));
            $('#content-slug').val(channel.data('slug'));
            $('#content-parent_id').remove();
            $('#content-post_id').remove();
        }
    });

    $('#add-item').on('click', function () {
        var data = $('#item-configurator input, #item-configurator select').serializeArray();
        var menuItem = {data : {}};
        $(data ).each(function(index, obj){
            if(obj.name.match(/[^[\]]+(?=])/)) {
                var childElName = obj.name.match(/[^[\]]+(?=])/)[0];
                menuItem.data[childElName] = obj.value;
            } else {
                menuItem[obj.name] = obj.value;
            }
        });

        var switcherId = 'switcher-' + ($('#menu').find('li').length + 1 );

        var template = '<li data-menu_id="' + menuItem.menu_id + '" ' +
            'data-type="' + menuItem.type + '" data-data=\'' + JSON.stringify(menuItem.data) + '\' data-status="0" data-id="0" data-parent_id="0">\n' +
            '    <div class="item">\n' +
            '        <span class="title-container">\n' +
            '            <i class="fa fa-fw fa-arrows icon-move"></i>\n' +
            '            <span class="title">' + menuItem.title + '</span>\n' +
            '        </span>\n' +
            '        <div class="btn-group pull-right">\n ' +
            '           <div class="switcher">' +
            '               <input type="checkbox" id="' + switcherId + '" name="is_enabled" data-toggle="toggle">' +
            '           </div>' +
            '           <button type="button" class="btn btn-default edit-menu-item" title="Редактировать"><i class="fa fa-edit"></i></button>\n' +
            '           <button type="button" class="btn btn-default delete-menu-item" title="Удалить"><i class="fa fa-trash-o"></i></button>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="input-group input-group-sm title-edit hidden">\n' +
            '        <input type="text" name="title-edit" class="form-control">\n' +
            '        <span class="input-group-btn">\n' +
            '          <button type="button" class="btn btn-success btn-flat change-title"><i class="fa fa-check"></i></button>\n' +
            '        </span>\n' +
            '    </div>\n';

        if(menuItem.type == 'group') {
            template += '<ol class="sub-menu"></ol>';
        }

        template += '</li>';

        $('#menu').append(template);
        $('#menu').find("#" + switcherId).bootstrapToggle({"on":"Вкл","off":"Выкл","onstyle":"success","offstyle":"danger"});
    });

    // Menu editor

    var group = $("ol.sortable").sortable({
        handle: 'i.icon-move',
        group: 'sortable',
        delay: 500,
        serialize: function ($parent, $children, parentIsContainer) {
            $parent.data('position', $parent.index() + 1);
            $parent.data('title', $parent.find('.title').first().text());
            var result = $.extend({}, $parent.data());

            if(parentIsContainer)
                return $children;
            else if ($children[0]){
                result.children = $children;
            }

            delete result.subContainers;
            delete result.sortable;

            return result;
        },
        onDrop: function ($item, container, _super) {
            var id = container.el.parents('li').data('id');
            id = typeof (id) == 'undefined' ? 0 : id;

            $item.data('parent_id', id);

            _super($item, container);
        }
    });

    $('#menu').on('change', 'input[name=is_enabled]', function() {
        var item = $(this).parents('li').first();
        var value = $(this).prop('checked') ? 1 : 0;
        item.data('status', value);
    });

    $('#menu').on('click', '.edit-menu-item', function() {
        var item = $(this).parents('li').first();
        var edit_input = item.find('.title-edit').first();
        edit_input.toggleClass('hidden');
        if(! edit_input.hasClass('hidden')) {
            edit_input.find('input[name=title-edit]').val(item.find('.title').first().text());
        }
    });

    $('#menu').on('click', '.change-title', function() {
        var input_group = $(this).parents('.title-edit');
        var input = input_group.find('input');
        var title = $(this).parents('li').first().find('.title').first();

        title.text(input.val());
        input_group.addClass('hidden');
    });

    var itemsForDelete = [];

    $('#menu').on('click', '.delete-menu-item', function() {
        if(confirm('Элемент меню будет удален')) {
            var item = $(this).parents('li').first();

            itemsForDelete.push(item.data('id'));
            item.remove();
        }
    });

    $('#save-menu').on('click', function() {
        var data = group.sortable("serialize").get();
        var jsonString = JSON.stringify(data, null, ' ');
        console.log(jsonString);

        $.ajax({
            url: $('input[name=menu-action]').val(),
            type: 'post',
            data: {
                items: jsonString,
                itemsForDelete: itemsForDelete
            },
            success: function (response) {
                var data = $.parseJSON(response);
                if(data.success) {
                    location.href = location.href;
                }
            }
        });
    });

    $('#item-type').on('change', function() {
        $('#item-form').html('');
    });
});
