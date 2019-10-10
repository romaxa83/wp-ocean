<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'css/jquery-ui.min.css',
        '//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css', // daterange picker
        '//use.fontawesome.com/releases/v5.5.0/css/all.css',
        'css/fonts.min.css',
        '//cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.min.css', // swiper min css
        'css/hamburgers.min.css',
        'css/perfect-scrollbar.css',
        'css/seo.min.css',
        '//cdnjs.cloudflare.com/ajax/libs/leaflet/1.5.1/leaflet.css', // leaflet css
        '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css',
        '//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css',
        '//cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jqvmap.min.css',
        'css/main.min.css',
        'css/vacancy.css',
        'css/cabinet.css'
    ];
    public $js = [
        '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.1/js/select2.min.js',
        'js/jquery-ui.min.js',
        '//cdn.jsdelivr.net/momentjs/latest/moment.min.js',
        '//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js', // daterange picker min js
        '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', // popper js
        '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', // bootstrap min js
        '//cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.min.js', // swiper min js
        'js/jquery.numscroll.js',
        '//cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.4.0/perfect-scrollbar.min.js', // perfect scrollbar
        '//cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js', // Tween max js
        '//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.6/ScrollMagic.min.js', // scroll magic
        'js/animation.gsap.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/gsap/latest/plugins/ScrollToPlugin.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js',
        '//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jquery.vmap.min.js', // jquery vector map
        '//cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/maps/jquery.vmap.world.js',
        'js/search-filter.js',
        '//cdnjs.cloudflare.com/ajax/libs/leaflet/1.5.1/leaflet.js', // leaflet
        '//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js', // jquery cookie
        '//cdnjs.cloudflare.com/ajax/libs/cleave.js/1.5.3/cleave.min.js', // mask plugin
        '//cdnjs.cloudflare.com/ajax/libs/animejs/2.2.0/anime.min.js',
        'js/jquery.mask.min.js',
        'js/social.js',
        'js/common.js',
        'js/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];

}
