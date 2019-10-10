$(document).ready(function () {
    var width = 555, height = 453;
    $('[data-init="facebook"]').on('click', function () {
        window.open(
                'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href),
                'Опубликовать в Facebook', 'width=' + width + ', height=' + height);
    });
    $('[data-init="telegram"]').on('click', function () {
        window.open(
                'https://telegram.me/share/url?url=' + encodeURIComponent(window.location.href) + '&text=' + encodeURIComponent($('h1').text()),
                'Опубликовать в Telegram', 'width=' + width + ', height=' + height);
    });
    $('[data-init="skype"]').on('click', function () {
        window.open(
                'https://web.skype.com/share?flowId=0a49369045c746ad1302510fcefec88d&url=' + encodeURIComponent(window.location.href) + '&source=button&lang=ru&text=' + encodeURIComponent($('h1').text()),
                'Опубликовать в Skype', 'width=' + width + ', height=' + height);
    });
    $('[data-init="viber"]').on('click', function () {
        window.open(
                "https://3p3x.adj.st/?adjust_t=u783g1_kw9yml&adjust_fallback=https%3A%2F%2Fwww.viber.com%2F%3Futm_source%3DPartner%26utm_medium%3DSharebutton%26utm_campaign%3DDefualt&adjust_campaign=Sharebutton&adjust_deeplink=" + encodeURIComponent("viber://forward?text=" + encodeURIComponent($('h1').text() + " " + window.location.href)),
                'Опубликовать в Viber', 'width=' + width + ', height=' + height);
    });
});