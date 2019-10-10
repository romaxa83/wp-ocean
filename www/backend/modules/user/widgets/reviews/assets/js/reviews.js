$(document).ready(function () {
    var current_item;


    $(document).mouseup(function (e) {
        if (current_item != null) {
            var current_form = current_item.find('form');
            if (!$(current_form).is(e.target) && $(current_form).has(e.target).length === 0) {
                current_form.remove();
            }
        }
    })
});