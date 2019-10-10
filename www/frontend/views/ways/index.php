<?php

use yii\helpers\Url;

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="http://ocean.loc.ua/">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">Направления</li>
            </ol>
        </div>
    </div>
</div>

<section class="section section-ways-map">
    <div class="container">
        <div class="section-header header-text-left left-offset-6" id="line-1">
            <div class="row">
                <div class="col-9 offset-md-0 offset-lg-5 header-title active" id="animate1">
                    <h2 class="header-title__title"><span class="header-title__text">наши</span>направления</h2>
                </div>
            </div>
        </div>

        <div id="w-map" class="d-none d-lg-block"></div>
    </div>
</section>

<section class="section section-ways-cards pb-0">
    <div class="container">
        <div class="ways-map">
            <div class="d-flex ways-btns-wrapper flex-wrap flex-lg-nowrap justify-content-center justify-content-lg-center">
                <button class="btn-filter btn-filter-type btn-size-xl">Все</button>
                <button class="btn-filter btn-filter-type btn-size-xl">Популярные</button>
                <button class="btn-filter btn-filter-type btn-size-xl active" data-select-map="eu">Европа</button>
                <button class="btn-filter btn-filter-type btn-size-xl">Азия</button>
                <button class="btn-filter btn-filter-type btn-size-xl">Африка</button>
                <button class="btn-filter btn-filter-type btn-size-xl">Сев. Америка</button>
                <button class="btn-filter btn-filter-type btn-size-xl">Юж. Америка</button>
                <button class="btn-filter btn-filter-type btn-size-xl">Австралия</button>
            </div>
        </div>
    </div>

    <div class="grey-bg pb-150px">
        <div class="container container-lg-mw">
            <div class="swiper-container ways-slider">
                <div class="swiper-wrapper flex-lg-wrap">
                    <div class="col-xs-12 col-md-4 col-lg-4 swiper-slide">
                        <div class="card card-size-s mb-0">
                            <div class="card-header">
                                <a href="#">
                                    <div class="card-header--image preloader-inner">
                                        <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/02/05/60/2056016.jpg"
                                             alt="image">
                                    </div>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="card-body--region d-flex">
                                    <a href="#">
                                        <span class="text-uppercase">Австрия</span>
                                    </a>
                                </div>
                                <div class="card-body--desc">
                                    <p>
                                        Бад Гаштайн, Цель ам Зее, Инсбрук,
                                        Ишгль, Капрун, Майрхофен, Зельден,
                                        Заальбах, Зальцбург
                                        <a href="#" class="ways-read-more">Еще</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-4 col-lg-4 swiper-slide">
                        <div class="card card-size-s mb-0">
                            <div class="card-header">
                                <a href="#">
                                    <div class="card-header--image preloader-inner">
                                        <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/03/83/53/3835388.jpg"
                                             alt="image">
                                    </div>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="card-body--region d-flex">
                                    <a href="#">
                                        <span class="text-uppercase">Австрия</span>
                                    </a>
                                </div>
                                <div class="card-body--desc">
                                    <p>
                                        Бад Гаштайн, Цель ам Зее, Инсбрук,
                                        Ишгль, Капрун, Майрхофен, Зельден,
                                        Заальбах, Зальцбург
                                        <a href="#" class="ways-read-more">Еще</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-4 col-lg-4 swiper-slide">
                        <div class="card card-size-s mb-0">
                            <div class="card-header">
                                <a href="#">
                                    <div class="card-header--image preloader-inner">
                                        <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/03/78/81/3788156.jpg"
                                             alt="image">
                                    </div>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="card-body--region d-flex">
                                    <a href="#">
                                        <span class="text-uppercase">Австрия</span>
                                    </a>
                                </div>
                                <div class="card-body--desc">
                                    <p>
                                        Бад Гаштайн, Цель ам Зее, Инсбрук,
                                        Ишгль, Капрун, Майрхофен, Зельден,
                                        Заальбах, Зальцбург
                                        <a href="#" class="ways-read-more">Еще</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-4 col-lg-4 swiper-slide">
                        <div class="card card-size-s mb-0">
                            <div class="card-header">
                                <a href="#">
                                    <div class="card-header--image preloader-inner">
                                        <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/03/78/81/3788156.jpg"
                                             alt="image">
                                    </div>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="card-body--region d-flex">
                                    <a href="#">
                                        <span class="text-uppercase">Австрия</span>
                                    </a>
                                </div>
                                <div class="card-body--desc">
                                    <p>
                                        Бад Гаштайн, Цель ам Зее, Инсбрук,
                                        Ишгль, Капрун, Майрхофен, Зельден,
                                        Заальбах, Зальцбург
                                        <a href="#" class="ways-read-more">Еще</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-4 col-lg-4 swiper-slide">
                        <div class="card card-size-s mb-0">
                            <div class="card-header">
                                <a href="#">
                                    <div class="card-header--image preloader-inner">
                                        <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/02/05/60/2056016.jpg"
                                             alt="image">
                                    </div>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="card-body--region d-flex">
                                    <a href="#">
                                        <span class="text-uppercase">Австрия</span>
                                    </a>
                                </div>
                                <div class="card-body--desc">
                                    <p>
                                        Бад Гаштайн, Цель ам Зее, Инсбрук,
                                        Ишгль, Капрун, Майрхофен, Зельден,
                                        Заальбах, Зальцбург
                                        <a href="#" class="ways-read-more">Еще</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-4 col-lg-4 swiper-slide">
                        <div class="card card-size-s mb-0">
                            <div class="card-header">
                                <a href="#">
                                    <div class="card-header--image preloader-inner">
                                        <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/03/83/53/3835388.jpg"
                                             alt="image">
                                    </div>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="card-body--region d-flex">
                                    <a href="#">
                                        <span class="text-uppercase">Австрия</span>
                                    </a>
                                </div>
                                <div class="card-body--desc">
                                    <p>
                                        Бад Гаштайн, Цель ам Зее, Инсбрук,
                                        Ишгль, Капрун, Майрхофен, Зельден,
                                        Заальбах, Зальцбург
                                        <a href="#" class="ways-read-more">Еще</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-4 col-lg-4 swiper-slide">
                        <div class="card card-size-s mb-0">
                            <div class="card-header">
                                <a href="#">
                                    <div class="card-header--image preloader-inner">
                                        <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/03/78/81/3788156.jpg"
                                             alt="image">
                                    </div>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="card-body--region d-flex">
                                    <a href="#">
                                        <span class="text-uppercase">Австрия</span>
                                    </a>
                                </div>
                                <div class="card-body--desc">
                                    <p>
                                        Бад Гаштайн, Цель ам Зее, Инсбрук,
                                        Ишгль, Капрун, Майрхофен, Зельден,
                                        Заальбах, Зальцбург
                                        <a href="#" class="ways-read-more">Еще</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-4 col-lg-4 swiper-slide">
                        <div class="card card-size-s mb-0">
                            <div class="card-header">
                                <a href="#">
                                    <div class="card-header--image preloader-inner">
                                        <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/03/78/81/3788156.jpg" alt="image">
                                    </div>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="card-body--region d-flex">
                                    <a href="#">
                                        <span class="text-uppercase">Австрия</span>
                                    </a>
                                </div>
                                <div class="card-body--desc">
                                    <p>
                                        Бад Гаштайн, Цель ам Зее, Инсбрук,
                                        Ишгль, Капрун, Майрхофен, Зельден,
                                        Заальбах, Зальцбург
                                        <a href="#" class="ways-read-more">Еще</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-block d-lg-none">
                    <div class="swiper-pagination swiper-bottom-blog-pagination w-100"></div>
                </div>
            </div>
            <div class="col-md-12 d-none d-lg-block">
                <button class="btn btn-regular btn-shadow button-isi btn-size-l ml-auto mr-auto">больше стран</button>
            </div>
        </div>
    </div>
</section>

<section class="section section-tour-application">
    <div class="container">
        <div class="section-header header-text-right w-b-150 header-text_white line-bottom" id="line-4">
            <div class="row">
                <div class="offset-md-4 offset-lg-3 col-12 col-md-8 col-lg-6 header-title active" id="animate4">
                    <h2 class="header-title__title"><span class="header-title__text">отправьте заявку</span>на подбор тура</h2>
                </div>
            </div>
        </div>

        <div class="tour-application--form">
            <form action="/" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group-white col-md-12 d-flex flex-wrap justify-content-between">
                        <div class="form-group required-input">
                            <input type="text" placeholder="Ваше имя" name="lala">
                        </div>
                        <div class="form-group required-input">
                            <input type="tel" placeholder="Ваш телефон" name="lala1">
                        </div>
                        <div class="form-group required-input">
                            <input type="email" placeholder="Ваш e-mail" name="lala2">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-regular btn-size-m button-isi">отправить</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="section section-seo">
    <div class="container">
        <div class="section-header header-text-left left-offset-3" id="line-2">
            <div class="row">
                <div class="col-9 offset-md-0 offset-lg-1 header-title active" id="animate2">
                    <h2 class="header-title__title"><span class="header-title__text">Заголовок</span>сео-текста</h2>
                </div>
            </div>
        </div>

        <div class="ways-seo-wrapper">
            <p>
                This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean
                sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis
                sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a
                odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit. Class aptent
                taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo.
                Nullam ac urna eu felis dapibus condimentum sit amet a augue.
            </p>
            <ol>
                <li>This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean
                    sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.
                    Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec
                    tellus a odio tincidunt auctor a ornare odio.
                </li>
                <li>This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean
                    sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.
                </li>
                <li>This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean
                    sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.
                    Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec
                    tellus a odio tincidunt auctor a ornare odio.
                </li>
            </ol>
            <h1>Какой-то заголовок сео-текста</h1>
            <p>
                This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean
                sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis
                sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a
                odio tincidunt auctor a ornare odio.
            </p>
            <ul>
                <li>This is Photoshop's version of Lorem Ipsum.</li>
                <li>This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor</li>
                <li>This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean
                    sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.
                </li>
            </ul>
        </div>
    </div>
</section>

<section class="section section-popular-places grey-bg">
    <div class="container">
        <div class="section-header header-text-right line-bottom" id="line-3">
            <div class="row">
                <div class="offset-1 offset-md-4 offset-lg-6 col-11 col-md-8 col-lg-6 header-title active" id="animate3">
                    <h2 class="header-title__title"><span class="header-title__text">популярные</span> места отдыха</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container container-lg-mw">
        <div class="swiper-container slider-popular-places">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="card card-size-s mb-0">
                        <div class="card-header">
                            <a href="#">
                                <div class="card-header--image preloader-inner">
                                    <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/02/05/60/2056016.jpg"
                                         alt="image">
                                </div>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="card-body--region d-flex">
                                <a href="#">
                                    <span class="text-uppercase">Австрия</span>
                                </a>
                            </div>
                            <div class="card-body--desc">
                                <p>
                                    Бад Гаштайн, Цель ам Зее, Инсбрук,
                                    Ишгль, Капрун, Майрхофен, Зельден,
                                    Заальбах, Зальцбург
                                    <a href="#" class="ways-read-more">Еще</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="card card-size-s mb-0">
                        <div class="card-header">
                            <a href="#">
                                <div class="card-header--image preloader-inner">
                                    <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/02/05/60/2056016.jpg"
                                         alt="image">
                                </div>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="card-body--region d-flex">
                                <a href="#">
                                    <span class="text-uppercase">Австрия</span>
                                </a>
                            </div>
                            <div class="card-body--desc">
                                <p>
                                    Бад Гаштайн, Цель ам Зее, Инсбрук,
                                    Ишгль, Капрун, Майрхофен, Зельден,
                                    Заальбах, Зальцбург
                                    <a href="#" class="ways-read-more">Еще</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="card card-size-s mb-0">
                        <div class="card-header">
                            <a href="#">
                                <div class="card-header--image preloader-inner">
                                    <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/02/05/60/2056016.jpg"
                                         alt="image">
                                </div>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="card-body--region d-flex">
                                <a href="#">
                                    <span class="text-uppercase">Австрия</span>
                                </a>
                            </div>
                            <div class="card-body--desc">
                                <p>
                                    Бад Гаштайн, Цель ам Зее, Инсбрук,
                                    Ишгль, Капрун, Майрхофен, Зельден,
                                    Заальбах, Зальцбург
                                    <a href="#" class="ways-read-more">Еще</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="card card-size-s mb-0">
                        <div class="card-header">
                            <a href="#">
                                <div class="card-header--image preloader-inner">
                                    <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/02/05/60/2056016.jpg"
                                         alt="image">
                                </div>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="card-body--region d-flex">
                                <a href="#">
                                    <span class="text-uppercase">Австрия</span>
                                </a>
                            </div>
                            <div class="card-body--desc">
                                <p>
                                    Бад Гаштайн, Цель ам Зее, Инсбрук,
                                    Ишгль, Капрун, Майрхофен, Зельден,
                                    Заальбах, Зальцбург
                                    <a href="#" class="ways-read-more">Еще</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="card card-size-s mb-0">
                        <div class="card-header">
                            <a href="#">
                                <div class="card-header--image preloader-inner">
                                    <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/02/05/60/2056016.jpg"
                                         alt="image">
                                </div>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="card-body--region d-flex">
                                <a href="#">
                                    <span class="text-uppercase">Австрия</span>
                                </a>
                            </div>
                            <div class="card-body--desc">
                                <p>
                                    Бад Гаштайн, Цель ам Зее, Инсбрук,
                                    Ишгль, Капрун, Майрхофен, Зельден,
                                    Заальбах, Зальцбург
                                    <a href="#" class="ways-read-more">Еще</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="card card-size-s mb-0">
                        <div class="card-header">
                            <a href="#">
                                <div class="card-header--image preloader-inner">
                                    <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/02/05/60/2056016.jpg"
                                         alt="image">
                                </div>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="card-body--region d-flex">
                                <a href="#">
                                    <span class="text-uppercase">Австрия</span>
                                </a>
                            </div>
                            <div class="card-body--desc">
                                <p>
                                    Бад Гаштайн, Цель ам Зее, Инсбрук,
                                    Ишгль, Капрун, Майрхофен, Зельден,
                                    Заальбах, Зальцбург
                                    <a href="#" class="ways-read-more">Еще</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination swiper-bottom-blog-pagination w-100"></div>
        </div>
    </div>
</section>