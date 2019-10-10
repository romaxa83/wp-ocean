function filemanagerTinyMCE(callback, value, meta) {
    var inputId = tinymce.activeEditor.settings.id,
            modal = $('[data-btn-id="' + inputId + '-btn"]'),
            iframe = $('<iframe src="' + modal.attr("data-frame-src")
                    + '" id="' + modal.attr("data-frame-id") + '" frameborder="0" role="filemanager-frame"></iframe>');

    iframe.on("load", function () {
        var modal = $(this).parents('[role="filemanager-modal"]'),
                input = $("#" + modal.attr("data-input-id"));

        $(this).contents().find(".dashboard").on("click", "#insert-btn", function (e) {
            e.preventDefault();

            var data = getFormData($(this).parents("#control-form"));

            input.trigger("fileInsert", [data]);

            callback(data.url, {alt: data.alt});
            modal.modal("hide");
        });
    });

    modal.find(".modal-body").html(iframe);
    modal.modal("show");
}

function getFormData(form) {
    var formArray = form.serializeArray(),
            modelMap = {
                'Mediafile[alt]': 'alt',
                'Mediafile[description]': 'description',
                url: 'url',
                id: 'id'
            },
            data = [];

    for (var i = 0; formArray.length > i; i++) {
        if (modelMap[formArray[i].name]) {
            data[modelMap[formArray[i].name]] = formArray[i].value;
        }
    }

    return data;
}

$(document).ready(function () {
    function frameHandler(e) {
        var modal = $(this).parents('[role="filemanager-modal"]'),
                imageContainer = $(modal.attr("data-image-container")),
                pasteData = modal.attr("data-paste-data"),
                input = $("#" + modal.attr("data-input-id"));
        var obj = $(this).contents().find("#multiple-file");
        $(this).contents().find(".dashboard").on("click", "#insert-btn", function (e) {
            e.preventDefault();
            var data = [];
            $(obj[0].children).each(function (i, obj) {
                data.push({
                    alt: $(this).data('alt'),
                    description: $(this).data('description'),
                    id: $(this).data('id'),
                    url: $(this).data('url')
                });
            });
            data.forEach(function (obj, i) {
                input.trigger("fileInsert", [obj]);
                if (imageContainer) {
                    imageContainer.html('<img src="' + obj.url + '" alt="' + obj.alt + '">');
                }
                input.val(obj[pasteData]);
            });
            modal.modal("hide");
        });
    }

    $('body').on("click", '[role="filemanager-launch"]', function (e) {
        e.preventDefault();

        var modal = $('[data-btn-id="' + $(this).attr("id") + '"]'),
            iframe = $('<iframe src="' + modal.attr("data-frame-src")
                + '" id="' + modal.attr("data-frame-id") + '" frameborder="0" role="filemanager-frame"></iframe>');

        iframe.on("load", frameHandler);
        modal.find(".modal-body").html(iframe);
        modal.modal("show");
    });

    $('body').on("click", '[role="clear-input"]', function (e) {
        e.preventDefault();

        $("#" + $(this).attr("data-clear-element-id")).val("");
        $($(this).attr("data-image-container")).empty();
    });
});