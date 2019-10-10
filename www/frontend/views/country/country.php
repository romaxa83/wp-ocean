<section class="section-presentation position-relative">
    <div class="search-section search-counties-section d-flex flex-column align-items-center pt-0"
         style="background: url(/img/photos/search_bg.png) center / cover no-repeat;">
        <div class="container mb-auto">
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Главная</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="#">Направления</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Турция</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="filter-form-wrapper w-100 mb-auto">
            <h1 class="filter-form-wrapper--header text-center text-white d-none d-md-block">Лучший отдых в Турции</h1>
            <div class="container">
                <form action="" method="POST">
                    <div class="filter-buttons d-flex justify-content-start align-items-center">
                        <button type="button" class="btn-filter btn-filter-type active" data-type="air">Авиа туры
                        </button>
                        <!--<button type="button" class="btn-filter btn-filter-type" data-type="bus">Автобусные туры</button>-->
                        <input type="text" name="filterType" id="filterTypeInput" class="hidden" value="air">
                    </div>
                    <div class="full-filter">
                        <div class="filter-wrapper d-flex justify-content-start align-items-stretch">
                            <div class="filter-items d-flex justify-content-start align-items-stretch">
                                <div class="filter-items__item filter-items__item_country">
                                    <div class="filter-items__header d-flex justify-content-between align-items-stretch p-0">
                                        <select class="mobile-shadow-select d-md-none">
                                            <option value="">Турция</option>
                                            <option value="val 1">Австрия</option>
                                        </select>
                                        <select class="js-states form-control country-select search-select"
                                                name="countryCode" id="filterCountryInput">
                                            <option value="">Турция</option>
                                            <option value="val 1">Австрия</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="filter-items__item filter-items__item_city">
                                    <div class="filter-items__header d-flex justify-content-between align-items-stretch p-0">
                                        <select class="mobile-shadow-select d-md-none">
                                            <option value="kiev">Киев</option>
                                            <option value="val 1">Херсон</option>
                                        </select>
                                        <select class="js-states form-control custom-select " name="filterCity">
                                            <option value="kiev">Киев</option>
                                            <option value="val 1">Херсон</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="filter-items__item filter-items__item_date">
                                    <div class="filter-items__header d-flex justify-content-between align-items-center">
                                        <div class="date-inputs d-flex justify-content-around justify-content-lg-start align-items-center">
                                            <div class="date-input-wrapper">
                                                <input type="text" name="filterDateStart" id="filterDateFrom" readonly>
                                                <i class="icon icon-calendar"></i>
                                            </div>
                                            <span class="divider">-</span>
                                            <div class="date-input-wrapper">
                                                <input type="text" name="filterDateEnd" id="filterDateTo" readonly>
                                                <i class="icon icon-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-dropdown-wrapper dropdown-menu non-event" id="filterDate"
                                         aria-labelledby="filterDateLink"></div>
                                </div>
                                <div class="filter-items__item filter-items__item_time">
                                    <div class="filter-items__header d-flex justify-content-between align-items-stretch p-0">
                                        <select class="mobile-shadow-select d-md-none">
                                            <option value="val 1">1-2 дня</option>
                                            <option value="val 1">2-3 дней</option>
                                            <option value="val 1">3-4 дней</option>
                                        </select>
                                        <select class="js-states form-control custom-select" name="filterDays">
                                            <option value="val 1">1-2 дня</option>
                                            <option value="val 1">2-3 дней</option>
                                            <option value="val 1">3-4 дней</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="filter-items__item filter-items__item_people">
                                    <div class="filter-items__header d-flex justify-content-between align-items-center"
                                         id="filterPeopleLink"
                                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                         data-drop-header="filterPeople">
                                        <span class="filter-items__title"></span>
                                        <i class="icon icon-add-user"></i>
                                    </div>
                                    <div class="filter-dropdown-wrapper dropdown-menu non-event" id="filterPeople"
                                         aria-labelledby="filterPeopleLink">
                                        <div class="filter-dropdown ">
                                            <div class="filter-inputs-wrapper">
                                                <div class="filter-input">
                                                    <p class="filter-input__label">Взрослых</p>
                                                    <div class="filter-input-wrapper">
                                                        <input type="text" class="dropdown-input digit-input"
                                                               id="adultsCounter" name="adultsCounter" value="2"
                                                               data-min="1"/>
                                                        <span class="input-arrow input-plus"></span>
                                                        <span class="input-arrow input-minus"></span>
                                                    </div>
                                                </div>
                                                <div class="filter-input children-counter-input">
                                                    <p class="filter-input__label">Детей</p>
                                                    <div class="filter-input-wrapper">
                                                        <input type="text" class="dropdown-input digit-input"
                                                               id="childrenCounter" name="childrenCounter" value="0"
                                                               data-min="0"/>
                                                        <span class="input-arrow input-plus"></span>
                                                        <span class="input-arrow input-minus"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="filter-inputs-wrapper children-age-inputs">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn-find btn-regular btn-size-m button-isi submit-filter">
                                Найти
                            </button>
                        </div>

                        <div class="additional-filter-wrapper justify-content-start align-items-start flex-wrap">

                            <div class="additional-filter-left d-flex justify-content-start align-items-start flex-wrap">
                                <div class="filter-checkboxes category-hotels filter-items__item">
                                    <h6 class="filter-checkboxes__title d-none d-lg-block">Категории отелей</h6>

                                    <div class="filter-items__header d-flex d-lg-none justify-content-between align-items-center"
                                         id="filterCatHotelLink"
                                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                         data-drop-header="filterCatHotel">
                                        <span class="filter-items__title">Категории отелей</span>
                                        <i class="filter-caret "></i>
                                    </div>

                                    <div class="all-checkboxes category-hotels-checkboxes filter-dropdown-wrapper dropdown-menu non-event"
                                         id="filterCatHotel"
                                         aria-labelledby="filterCatHotelLink">
                                        <div class="main-checkbox">
                                            <input type="checkbox" name="all_catHotels" id="allCatHotels"/>
                                            <label for="allCatHotels">Все варианты</label>
                                        </div>
                                        <div class="checkboxes-wrapper ">
                                            <div class="checkbox">
                                                <input type="checkbox" name="stars[]" value="5" id="fiveStars"/>
                                                <label for="fiveStars">
                                                    <img src="/img/icons/fiveStars.png" alt="fiveStars"/>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="stars[]" value="4" id="fourStars"/>
                                                <label for="fourStars">
                                                    <img src="/img/icons/fourStars.png" alt="fourStars"/>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="stars[]" value="3" id="threeStars"/>
                                                <label for="threeStars">
                                                    <img src="/img/icons/threeStars.png" alt="threeStars"/>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="stars[]" value="2" id="twoStars"/>
                                                <label for="twoStars">
                                                    <img src="/img/icons/twoStars.png" alt="twoStars"/>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="stars[]" value="1" id="oneStars"/>
                                                <label for="oneStars">
                                                    <img src="/img/icons/oneStars.png" alt="oneStars"/>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="villa" id="villa" value="villa"/>
                                                <label for="villa">Вилла</label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="apartments" id="apartments"
                                                       value="apartments"/>
                                                <label for="apartments">Апартаменты</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter-checkboxes nutrition filter-items__item">
                                    <h6 class="filter-checkboxes__title d-none d-lg-block">Питание</h6>
                                    <div class="filter-items__header d-flex d-lg-none justify-content-between align-items-center"
                                         id="filterNutritionLink"
                                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                         data-drop-header="filterNutrition">
                                        <span class="filter-items__title">Питание</span>
                                        <i class="filter-caret "></i>
                                    </div>
                                    <div class="all-checkboxes filter-dropdown-wrapper dropdown-menu non-event"
                                         id="filterNutrition"
                                         aria-labelledby="filterNutritionLink">
                                        <div class="main-checkbox">
                                            <input type="checkbox" name="all_nutrition" id="allNutrition"/>
                                            <label for="allNutrition">Все варианты</label>
                                        </div>
                                        <div class="checkboxes-wrapper">
                                            <div class="checkbox">
                                                <input type="checkbox" name="food[]" id="uai" value="uai"/>
                                                <label for="uai">UAI <span>ультра все включено</span></label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="food[]" id="ai" value="ai"/>
                                                <label for="ai">AI <span>все включено</span></label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="food[]" id="fb" value="fb"/>
                                                <label for="fb">FB <span>полный пансион</span></label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="food[]" id="hb" value="hb"/>
                                                <label for="hb">HB <span>завтрак и ужин</span></label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="food[]" id="bb" value="bb"/>
                                                <label for="bb">BB <span>завтрак</span></label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" name="food[]" id="ob" value="ob"/>
                                                <label for="ob">OB <span>без питания</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="price-slider-wrapper filter-items__item">
                                    <div class="filter-items__header d-flex d-lg-none justify-content-between align-items-center"
                                         id="filterPriceLink"
                                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                         data-drop-header="filterPrice">
                                        <span class="filter-items__title">Цена</span>
                                        <i class="filter-caret "></i>
                                    </div>
                                    <div class="prices filter-dropdown-wrapper dropdown-menu non-event" id="filterPrice"
                                         aria-labelledby="filterPriceLink">
                                        <div class="price-input price-from">
                                            <span>От:</span>
                                            <input type="text" name="priceMin" placeholder="0" id="price_min"
                                                   data-slider="price" data-input="0" value="0">
                                        </div>
                                        <div class="price-input price-to">
                                            <span>До:</span>
                                            <input type="text" name="priceMax" placeholder="100 000" id="price_max"
                                                   data-slider="price" data-input="1" value="100 000">
                                        </div>
                                        <div class="price-input price-to">
                                            <span>Валюта:</span>
                                            <div class="filter-items__item filter-items__item_currency">
                                                <div class="filter-items__header d-flex justify-content-between align-items-center"
                                                     id="filterCurrencyLink"
                                                     data-drop-header="filterCurrency">
                                                    <span class="filter-items__title">UAH</span>
                                                    <i class="filter-caret "></i>
                                                    <input type="text" name="filterCurrency" class="hidden"
                                                           value="UAH"/>
                                                </div>
                                                <div class="filter-dropdown-wrapper dropdown-menu" id="filterCurrency"
                                                     aria-labelledby="filterCurrencyLink">
                                                    <div class="filter-dropdown">
                                                        <ul class="filter-dropdown-list filter-dropdown-list_main">
                                                            <li class="filter-dropdown-list__item">
                                                                <span class="filter-dropdown-list__link">UAH</span>
                                                            </li>
                                                            <li class="filter-dropdown-list__item">
                                                                <span class="filter-dropdown-list__link">USD</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slider-range">
                                        <div id="slider-price"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="additional-filter-right d-flex justify-content-start align-items-start">
                                <div class="filter-checkboxes category-resorts filter-items__item">
                                    <h6 class="filter-checkboxes__title d-none d-lg-block">Курорты</h6>
                                    <div class="filter-items__header d-flex d-lg-none justify-content-between align-items-center"
                                         id="filterResortsLink"
                                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                         data-drop-header="filterResorts">
                                        <span class="filter-items__title">Курорты</span>
                                        <i class="filter-caret "></i>
                                    </div>
                                    <div class="all-checkboxes filter-dropdown-wrapper dropdown-menu non-event"
                                         id="filterResorts"
                                         aria-labelledby="filterResortsLink">
                                        <div class="main-checkbox">
                                            <input type="checkbox" name="all_resorts" id="allResorts"/>
                                            <label for="allResorts">Все варианты</label>
                                        </div>
                                        <div class="checkboxes-wrapper checkboxes-grey ">
                                            <div class="resort-checkboxes ">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="city[]"
                                                           id="<?php echo 'city-1'; ?>" value="<?php echo 1; ?>"/>
                                                    <label for="<?php echo 'city-1'; ?>">
                                                        <?php echo 'Value 1'; ?> </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="filter-checkboxes category-hotels-titles filter-items__item">
                                    <h6 class="filter-checkboxes__title d-none d-lg-block">Отели</h6>
                                    <div class="filter-items__header d-flex d-lg-none justify-content-between align-items-center"
                                         id="filterHotelsTitlesLink"
                                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                         data-drop-header="filterHotelsTitles">
                                        <span class="filter-items__title">Отели</span>
                                        <i class="filter-caret "></i>
                                    </div>
                                    <div class="all-checkboxes filter-dropdown-wrapper dropdown-menu non-event"
                                         id="filterHotelsTitles"
                                         aria-labelledby="filterHotelsTitlesLink">
                                        <div class="main-checkbox">
                                            <input type="checkbox" name="all_hotels" id="allHotels"/>
                                            <label for="allHotels">Все варианты</label>
                                        </div>
                                        <div class="checkboxes-wrapper  checkboxes-grey ">
                                            <div class="hotel-search">
                                                <input type="text" placeholder="Найти отель" id="filterHotelInput">
                                                <i class="icon icon-search"></i>
                                            </div>
                                            <div class="hotels-checkboxes">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="hotel[]"
                                                           id="<?php echo 'hotel-1'; ?>"
                                                           value="<?php echo 1; ?>"/>
                                                    <label for="<?php echo 'hotel-1'; ?>">
                                                        <?php echo 'Hotel - 1'; ?> </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="additional-filter-bottom">
                                <button type="reset" class="btn-filter-reset real-white"><span
                                            class="d-none d-lg-block"><i
                                                class="icon icon-cross-menu"></i>
                                    Очистить фильтры</span> <span class="d-block d-lg-none">Сбросить</span>
                                </button>
                                <button type="submit"
                                        class="btn-regular btn-size-m submit-filter button-isi visible-991">
                                    <span class="d-none d-lg-block">Найти туры</span>
                                    <span class="d-block d-lg-none">Найти тур</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="additional-filter">
                        <p class="additional-filter__text">
                            Показать дополнительные параметры
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="section section-ocean-recommends">
    <div class="container">
        <div class="section-header header-text-left left-offset-3 line-bottom" id="line-1">
            <div class="row">
                <div class="col-9 offset-md-2 header-title" id="animate1">
                    <h2 class="header-title__title"><span class="header-title__text">5 океан</span>рекомендует</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container container-lg-mw swiper-container recommends-container">
        <div class="row-cards flex-lg-wrap swiper-wrapper">
            <div class="col-md-6 col-lg-6 col-xl-4 swiper-slide pb-3">
                <div class="card card-size-s mb-0 mt-0">
                    <div class="card-header">
                        <a href="https://5okean.com/tour/austria/vena/Austria_Trend_Hotel_Ananas" target="_blank">
                            <div class="card-header--image preloader-inner">
                                <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/00/51/52/515243.jpg"
                                     alt="lalal">

                                <div class="card-header--icons blog-left--menu d-lg-none">
                                    <div class="blog-left-menu__item active">
                                        <span><i class="icon-other icon-flame"></i></span>
                                    </div>
                                </div>

                                <div class="card-header--common">
                                    <div class="card--rating text-white font-montserrat font-size-s">
                                        <span><strong>0.0</strong> оценка</span>
                                    </div>
                                    <div class="card--rating card--rating__testimonials text-white font-montserrat font-size-s">
                                        <span><strong>0</strong> отзывов</span></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="card-body--region d-flex">
                            <a href="https://5okean.com/tour/austria/vena/Austria_Trend_Hotel_Ananas"
                               target="_blank"><span class="text-uppercase">Австрия </span>Вена </a>
                            <i class="icon icon-map"></i>
                        </div>
                        <div class="card-body--hotel d-flex align-items-center">
                            <h5>4* Austria Trend Hotel Ananas</h5>
                        </div>
                        <h6 class="card-body--desc desc-fade">
                            Отель расположен прямо напротив станции метро U1 – Pilgramgasse. В нескольких минутах езды
                            от отеля находятся все основные достопримечательности Вены. </h6>
                    </div>
                    <div class="card-footer">
                        <a href="https://5okean.com/tour/austria/vena/Austria_Trend_Hotel_Ananas" target="_blank"
                           class="btn-regular btn-size-m button-isi">Подробнее</a>
                        <div class="card-footer--prices">
                            <h6 class="full-price">32644.13 ₴</h6>
                            <h2 class="descount-price">
                                <small>от</small>
                                32644.13 ₴
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-4 swiper-slide pb-3">
                <div class="card card-size-s mb-0 mt-0">
                    <div class="card-header">
                        <a href="https://5okean.com/tour/austria/vena/Anatol_Hotel" target="_blank">
                            <div class="card-header--image preloader-inner">
                                <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/00/49/41/494103.jpg"
                                     alt="alals">

                                <div class="card-header--icons blog-left--menu d-lg-none">
                                    <div class="blog-left-menu__item active">
                                        <span><i class="icon-other icon-flame"></i></span>
                                    </div>
                                </div>

                                <div class="card-header--common">
                                    <div class="card--rating text-white font-montserrat font-size-s">
                                        <span><strong>0.0</strong> оценка</span>
                                    </div>
                                    <div class="card--rating card--rating__testimonials text-white font-montserrat font-size-s">
                                        <span><strong>0</strong> отзывов</span></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="card-body--region d-flex">
                            <a href="https://5okean.com/tour/austria/vena/Anatol_Hotel" target="_blank"><span
                                        class="text-uppercase">Австрия </span>Вена </a>
                            <i class="icon icon-map"></i>
                        </div>
                        <div class="card-body--hotel d-flex align-items-center">
                            <h5>4* Anatol Hotel</h5>
                        </div>
                        <h6 class="card-body--desc desc-fade">
                            Отель расположен недалеко от Марияхильферштрассе - самой длинной торговой улицы Вены, и
                            музейного квартала. Отель представляет собой здание с бетонным фасадом, гармонично
                            сочетающееся с окружающей архитектурой. </h6>
                    </div>
                    <div class="card-footer">
                        <a href="https://5okean.com/tour/austria/vena/Anatol_Hotel" target="_blank"
                           class="btn-regular btn-size-m button-isi">Подробнее</a>
                        <div class="card-footer--prices">
                            <h6 class="full-price">32348.18 ₴</h6>
                            <h2 class="descount-price">
                                <small>от</small>
                                32348.18 ₴
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-4 swiper-slide pb-3">
                <div class="card card-size-s mb-0 mt-0">
                    <div class="card-header">
                        <a href="https://5okean.com/tour/austria/vena/Falkensteiner_Hotel_Margareten" target="_blank">
                            <div class="card-header--image preloader-inner">
                                <img src="https://5okean.com/admin/img/logo_no_photo.png" alt="alal"
                                     class="img-not-found">

                                <div class="card-header--icons blog-left--menu d-lg-none">
                                    <div class="blog-left-menu__item active">
                                        <span><i class="icon-other icon-flame"></i></span>
                                    </div>
                                </div>

                                <div class="card-header--common">
                                    <div class="card--rating text-white font-montserrat font-size-s">
                                        <span><strong>0.0</strong> оценка</span>
                                    </div>
                                    <div class="card--rating card--rating__testimonials text-white font-montserrat font-size-s">
                                        <span><strong>0</strong> отзывов</span></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="card-body--region d-flex">
                            <a href="https://5okean.com/tour/austria/vena/Falkensteiner_Hotel_Margareten"
                               target="_blank"><span class="text-uppercase">Австрия </span>Вена </a>
                            <i class="icon icon-map"></i>
                        </div>
                        <div class="card-body--hotel d-flex align-items-center">
                            <h5>4* Falkensteiner Hotel Margareten</h5>
                        </div>
                        <h6 class="card-body--desc desc-fade">
                            Отель находится рядом с центром города, он удобно расположен по отношению к основным
                            железнодорожным вокзалам города - Vienna West Station и Vienna Main Station. Рынок под
                            открытым небом Naschmarkt расположен в 2 остановках на метро, &#8203;&#8203;а Дворец
                            Шенбрунн - в 3 остановках. Отель открыт в сентябре 2013 года. </h6>
                    </div>
                    <div class="card-footer">
                        <a href="https://5okean.com/tour/austria/vena/Falkensteiner_Hotel_Margareten" target="_blank"
                           class="btn-regular btn-size-m button-isi">Подробнее</a>
                        <div class="card-footer--prices">
                            <h6 class="full-price">35233.64 ₴</h6>
                            <h2 class="descount-price">
                                <small>от</small>
                                35233.64 ₴
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-4 swiper-slide pb-3">
                <div class="card card-size-s mb-0 mt-0">
                    <div class="card-header">
                        <a href="https://5okean.com/tour/austria/vena/Austia_Trend_Hotel_Beim_Theresianum"
                           target="_blank">
                            <div class="card-header--image preloader-inner">
                                <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/00/51/26/512623.jpg"
                                     alt="alala">

                                <div class="card-header--icons blog-left--menu d-lg-none">
                                    <div class="blog-left-menu__item active">
                                        <span><i class="icon-other icon-flame"></i></span>
                                    </div>
                                </div>

                                <div class="card-header--common">
                                    <div class="card--rating text-white font-montserrat font-size-s">
                                        <span><strong>0.0</strong> оценка</span>
                                    </div>
                                    <div class="card--rating card--rating__testimonials text-white font-montserrat font-size-s">
                                        <span><strong>0</strong> отзывов</span></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="card-body--region d-flex">
                            <a href="https://5okean.com/tour/austria/vena/Austia_Trend_Hotel_Beim_Theresianum"
                               target="_blank"><span class="text-uppercase">Австрия </span>Вена </a>
                            <i class="icon icon-map"></i>
                        </div>
                        <div class="card-body--hotel d-flex align-items-center">
                            <h5>3* Austia Trend Hotel Beim Theresianum</h5>
                        </div>
                        <h6 class="card-body--desc desc-fade">
                            Отель расположен в центре Вены, рядом с Belvedere Palace. Здание отеля было построено в XIX
                            веке, является памятником архитектуры и охраняется государством. </h6>
                    </div>
                    <div class="card-footer">
                        <a href="https://5okean.com/tour/austria/vena/Austia_Trend_Hotel_Beim_Theresianum"
                           target="_blank" class="btn-regular btn-size-m button-isi">Подробнее</a>
                        <div class="card-footer--prices">
                            <h6 class="full-price">27099.81 ₴</h6>
                            <h2 class="descount-price">
                                <small>от</small>
                                27099.81 ₴
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-4 swiper-slide pb-3">
                <div class="card card-size-s mb-0 mt-0">
                    <div class="card-header">
                        <a href="https://5okean.com/tour/austria/vena/Post_Hotel_Wien" target="_blank">
                            <div class="card-header--image preloader-inner">
                                <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/03/77/93/3779328.jpg"
                                     alt="alala">

                                <div class="card-header--icons blog-left--menu d-lg-none">
                                    <div class="blog-left-menu__item active">
                                        <span><i class="icon-other icon-flame"></i></span>
                                    </div>
                                </div>

                                <div class="card-header--common">
                                    <div class="card--rating text-white font-montserrat font-size-s">
                                        <span><strong>0.0</strong> оценка</span>
                                    </div>
                                    <div class="card--rating card--rating__testimonials text-white font-montserrat font-size-s">
                                        <span><strong>0</strong> отзывов</span></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="card-body--region d-flex">
                            <a href="https://5okean.com/tour/austria/vena/Post_Hotel_Wien" target="_blank"><span
                                        class="text-uppercase">Австрия </span>Вена </a>
                            <i class="icon icon-map"></i>
                        </div>
                        <div class="card-body--hotel d-flex align-items-center">
                            <h5>3* Post Hotel Wien</h5>
                        </div>
                        <h6 class="card-body--desc desc-fade">
                            Отель Post Wien расположен в 10 минутах ходьбы до императорского дворца Хофбург, в 5 минутах
                            ходьбы от собора Святого Стефана и в 2 минутах ходьбы от ближайшей станции метро
                            Schwedenplatz линий U1 и U4. Отель был построен в 1900 в классическом стиле и полностью
                            обновлен в 2009 году. </h6>
                    </div>
                    <div class="card-footer">
                        <a href="https://5okean.com/tour/austria/vena/Post_Hotel_Wien" target="_blank"
                           class="btn-regular btn-size-m button-isi">Подробнее</a>
                        <div class="card-footer--prices">
                            <h6 class="full-price">33753.92 ₴</h6>
                            <h2 class="descount-price">
                                <small>от</small>
                                33753.92 ₴
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-block d-lg-none">
            <div class="swiper-pagination swiper-bottom-blog-pagination pagination-v1 w-100"></div>
        </div>
    </div>
</section>

<section class="section section-ocean-recommends grey-bg">
    <div class="container">
        <div class="section-header header-text-right active line-bottom" id="line-2">
            <div class="row">
                <div class="offset-2 offset-md-4 offset-lg-6 col-11 col-md-8 col-lg-6 header-title active"
                     id="animate2">
                    <h2 class="header-title__title grey-bg"><span class="header-title__text">горящие</span> туры Турции
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container container-lg-mw swiper-container hot-resort-slider">
        <div class="row-cards flex-lg-wrap swiper-wrapper">
            <div class="col-md-6 col-lg-6 col-xl-4 swiper-slide pb-3">
                <div class="card card-size-s mb-0 mt-0">
                    <div class="card-header">
                        <a href="https://5okean.com/tour/austria/vena/Austria_Trend_Hotel_Ananas" target="_blank">
                            <div class="card-header--image preloader-inner">
                                <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/00/51/52/515243.jpg"
                                     alt="alt">

                                <div class="card-header--icons blog-left--menu d-lg-none">
                                    <div class="blog-left-menu__item active">
                                        <span><i class="icon-other icon-flame"></i></span>
                                    </div>
                                </div>

                                <div class="card-header--common">
                                    <div class="card--rating text-white font-montserrat font-size-s">
                                        <span><strong>0.0</strong> оценка</span>
                                    </div>
                                    <div class="card--rating card--rating__testimonials text-white font-montserrat font-size-s">
                                        <span><strong>0</strong> отзывов</span></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="card-body--region d-flex">
                            <a href="https://5okean.com/tour/austria/vena/Austria_Trend_Hotel_Ananas"
                               target="_blank"><span class="text-uppercase">Австрия </span>Вена </a>
                            <i class="icon icon-map"></i>
                        </div>
                        <div class="card-body--hotel d-flex align-items-center">
                            <h5>4* Austria Trend Hotel Ananas</h5>
                        </div>
                        <h6 class="card-body--desc desc-fade">
                            Отель расположен прямо напротив станции метро U1 – Pilgramgasse. В нескольких минутах езды
                            от отеля находятся все основные достопримечательности Вены. </h6>
                    </div>
                    <div class="card-footer">
                        <a href="https://5okean.com/tour/austria/vena/Austria_Trend_Hotel_Ananas" target="_blank"
                           class="btn-regular btn-size-m button-isi">Подробнее</a>
                        <div class="card-footer--prices">
                            <h6 class="full-price">32644.13 ₴</h6>
                            <h2 class="descount-price">
                                <small>от</small>
                                32644.13 ₴
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-4 swiper-slide pb-3">
                <div class="card card-size-s mb-0 mt-0">
                    <div class="card-header">
                        <a href="https://5okean.com/tour/austria/vena/Anatol_Hotel" target="_blank">
                            <div class="card-header--image preloader-inner">
                                <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/00/49/41/494103.jpg"
                                     alt="alt">

                                <div class="card-header--icons blog-left--menu d-lg-none">
                                    <div class="blog-left-menu__item active">
                                        <span><i class="icon-other icon-flame"></i></span>
                                    </div>
                                </div>

                                <div class="card-header--common">
                                    <div class="card--rating text-white font-montserrat font-size-s">
                                        <span><strong>0.0</strong> оценка</span>
                                    </div>
                                    <div class="card--rating card--rating__testimonials text-white font-montserrat font-size-s">
                                        <span><strong>0</strong> отзывов</span></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="card-body--region d-flex">
                            <a href="https://5okean.com/tour/austria/vena/Anatol_Hotel" target="_blank"><span
                                        class="text-uppercase">Австрия </span>Вена </a>
                            <i class="icon icon-map"></i>
                        </div>
                        <div class="card-body--hotel d-flex align-items-center">
                            <h5>4* Anatol Hotel</h5>
                        </div>
                        <h6 class="card-body--desc desc-fade">
                            Отель расположен недалеко от Марияхильферштрассе - самой длинной торговой улицы Вены, и
                            музейного квартала. Отель представляет собой здание с бетонным фасадом, гармонично
                            сочетающееся с окружающей архитектурой. </h6>
                    </div>
                    <div class="card-footer">
                        <a href="https://5okean.com/tour/austria/vena/Anatol_Hotel" target="_blank"
                           class="btn-regular btn-size-m button-isi">Подробнее</a>
                        <div class="card-footer--prices">
                            <h6 class="full-price">32348.18 ₴</h6>
                            <h2 class="descount-price">
                                <small>от</small>
                                32348.18 ₴
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-4 swiper-slide pb-3">
                <div class="card card-size-s mb-0 mt-0">
                    <div class="card-header">
                        <a href="https://5okean.com/tour/austria/vena/Falkensteiner_Hotel_Margareten" target="_blank">
                            <div class="card-header--image preloader-inner">
                                <img src="https://5okean.com/admin/img/logo_no_photo.png" alt="ala"
                                     class="img-not-found">

                                <div class="card-header--icons blog-left--menu d-lg-none">
                                    <div class="blog-left-menu__item active">
                                        <span><i class="icon-other icon-flame"></i></span>
                                    </div>
                                </div>

                                <div class="card-header--common">
                                    <div class="card--rating text-white font-montserrat font-size-s">
                                        <span><strong>0.0</strong> оценка</span>
                                    </div>
                                    <div class="card--rating card--rating__testimonials text-white font-montserrat font-size-s">
                                        <span><strong>0</strong> отзывов</span></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="card-body--region d-flex">
                            <a href="https://5okean.com/tour/austria/vena/Falkensteiner_Hotel_Margareten"
                               target="_blank"><span class="text-uppercase">Австрия </span>Вена </a>
                            <i class="icon icon-map"></i>
                        </div>
                        <div class="card-body--hotel d-flex align-items-center">
                            <h5>4* Falkensteiner Hotel Margareten</h5>
                        </div>
                        <h6 class="card-body--desc desc-fade">
                            Отель находится рядом с центром города, он удобно расположен по отношению к основным
                            железнодорожным вокзалам города - Vienna West Station и Vienna Main Station. Рынок под
                            открытым небом Naschmarkt расположен в 2 остановках на метро, &#8203;&#8203;а Дворец
                            Шенбрунн - в 3 остановках. Отель открыт в сентябре 2013 года. </h6>
                    </div>
                    <div class="card-footer">
                        <a href="https://5okean.com/tour/austria/vena/Falkensteiner_Hotel_Margareten" target="_blank"
                           class="btn-regular btn-size-m button-isi">Подробнее</a>
                        <div class="card-footer--prices">
                            <h6 class="full-price">35233.64 ₴</h6>
                            <h2 class="descount-price">
                                <small>от</small>
                                35233.64 ₴
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-4 swiper-slide pb-3">
                <div class="card card-size-s mb-0 mt-0">
                    <div class="card-header">
                        <a href="https://5okean.com/tour/austria/vena/Austia_Trend_Hotel_Beim_Theresianum"
                           target="_blank">
                            <div class="card-header--image preloader-inner">
                                <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/00/51/26/512623.jpg"
                                     alt="alaas">

                                <div class="card-header--icons blog-left--menu d-lg-none">
                                    <div class="blog-left-menu__item active">
                                        <span><i class="icon-other icon-flame"></i></span>
                                    </div>
                                </div>

                                <div class="card-header--common">
                                    <div class="card--rating text-white font-montserrat font-size-s">
                                        <span><strong>0.0</strong> оценка</span>
                                    </div>
                                    <div class="card--rating card--rating__testimonials text-white font-montserrat font-size-s">
                                        <span><strong>0</strong> отзывов</span></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="card-body--region d-flex">
                            <a href="https://5okean.com/tour/austria/vena/Austia_Trend_Hotel_Beim_Theresianum"
                               target="_blank"><span class="text-uppercase">Австрия </span>Вена </a>
                            <i class="icon icon-map"></i>
                        </div>
                        <div class="card-body--hotel d-flex align-items-center">
                            <h5>3* Austia Trend Hotel Beim Theresianum</h5>
                        </div>
                        <h6 class="card-body--desc desc-fade">
                            Отель расположен в центре Вены, рядом с Belvedere Palace. Здание отеля было построено в XIX
                            веке, является памятником архитектуры и охраняется государством. </h6>
                    </div>
                    <div class="card-footer">
                        <a href="https://5okean.com/tour/austria/vena/Austia_Trend_Hotel_Beim_Theresianum"
                           target="_blank" class="btn-regular btn-size-m button-isi">Подробнее</a>
                        <div class="card-footer--prices">
                            <h6 class="full-price">27099.81 ₴</h6>
                            <h2 class="descount-price">
                                <small>от</small>
                                27099.81 ₴
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-4 swiper-slide pb-3">
                <div class="card card-size-s mb-0 mt-0">
                    <div class="card-header">
                        <a href="https://5okean.com/tour/austria/vena/Post_Hotel_Wien" target="_blank">
                            <div class="card-header--image preloader-inner">
                                <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/03/77/93/3779328.jpg"
                                     alt="lala">

                                <div class="card-header--icons blog-left--menu d-lg-none">
                                    <div class="blog-left-menu__item active">
                                        <span><i class="icon-other icon-flame"></i></span>
                                    </div>
                                </div>

                                <div class="card-header--common">
                                    <div class="card--rating text-white font-montserrat font-size-s">
                                        <span><strong>0.0</strong> оценка</span>
                                    </div>
                                    <div class="card--rating card--rating__testimonials text-white font-montserrat font-size-s">
                                        <span><strong>0</strong> отзывов</span></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="card-body--region d-flex">
                            <a href="https://5okean.com/tour/austria/vena/Post_Hotel_Wien" target="_blank"><span
                                        class="text-uppercase">Австрия </span>Вена </a>
                            <i class="icon icon-map"></i>
                        </div>
                        <div class="card-body--hotel d-flex align-items-center">
                            <h5>3* Post Hotel Wien</h5>
                        </div>
                        <h6 class="card-body--desc desc-fade">
                            Отель Post Wien расположен в 10 минутах ходьбы до императорского дворца Хофбург, в 5 минутах
                            ходьбы от собора Святого Стефана и в 2 минутах ходьбы от ближайшей станции метро
                            Schwedenplatz линий U1 и U4. Отель был построен в 1900 в классическом стиле и полностью
                            обновлен в 2009 году. </h6>
                    </div>
                    <div class="card-footer">
                        <a href="https://5okean.com/tour/austria/vena/Post_Hotel_Wien" target="_blank"
                           class="btn-regular btn-size-m button-isi">Подробнее</a>
                        <div class="card-footer--prices">
                            <h6 class="full-price">33753.92 ₴</h6>
                            <h2 class="descount-price">
                                <small>от</small>
                                33753.92 ₴
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-block d-lg-none">
            <div class="swiper-pagination swiper-bottom-blog-pagination pagination-v2 w-100"></div>
        </div>
    </div>
</section>

<section class="section section-best-resort pb-0">
    <div class="container">
        <div class="section-header header-text-left left-offset-3" id="line-3">
            <div class="row">
                <div class="col-12 offset-md-0 offset-lg-2 header-title active" id="animate3">
                    <h2 class="header-title__title"><span class="header-title__text">лучшие</span>курорты турции</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="swiper-container country-resorts">
        <div class="swiper-wrapper country-resorts--wrapper flex-md-wrap">

            <div class="swiper-slide country-resorts--item">
                <img src="/img/photos/france.png" alt="img">
                <div class="country-resorts--item__info d-flex flex-column justify-content-end">
                    <h2 class="text-white">алания</h2>
                    <p class="text-white">
                        This is Photoshop's version of Lorem Ipsum. Proin gravida
                    </p>
                    <h5 class="text-white">
                        <small>от</small>
                        1 000 $ <span class="font-weight-normal">за одного</span></h5>
                </div>
            </div>

            <div class="swiper-slide country-resorts--item">
                <img src="/img/photos/greece.png" alt="img">
                <div class="country-resorts--item__info d-flex flex-column justify-content-end">
                    <h2 class="text-white">анталия</h2>
                    <p class="text-white">
                        This is Photoshop's version of Lorem Ipsum. Proin gravida
                    </p>
                    <h5 class="text-white">
                        <small>от</small>
                        1 000 $ <span class="font-weight-normal">за одного</span></h5>
                </div>
            </div>

            <div class="swiper-slide country-resorts--item">
                <img src="/img/photos/islands.png" alt="img">
                <div class="country-resorts--item__info d-flex flex-column justify-content-end">
                    <h2 class="text-white">кемер</h2>
                    <p class="text-white">
                        This is Photoshop's version of Lorem Ipsum. Proin gravida
                    </p>
                    <h5 class="text-white">
                        <small>от</small>
                        1 000 $ <span class="font-weight-normal">за одного</span></h5>
                </div>
            </div>

            <div class="swiper-slide country-resorts--item">
                <img src="/img/photos/italy.png" alt="img">
                <div class="country-resorts--item__info d-flex flex-column justify-content-end">
                    <h2 class="text-white">бодрум</h2>
                    <p class="text-white">
                        This is Photoshop's version of Lorem Ipsum. Proin gravida
                    </p>
                    <h5 class="text-white">
                        <small>от</small>
                        1 000 $ <span class="font-weight-normal">за одного</span></h5>
                </div>
            </div>

            <div class="swiper-slide country-resorts--item">
                <img src="/img/photos/turkey.png" alt="img">
                <div class="country-resorts--item__info d-flex flex-column justify-content-end">
                    <h2 class="text-white">мармарис</h2>
                    <p class="text-white">
                        This is Photoshop's version of Lorem Ipsum. Proin gravida
                    </p>
                    <h5 class="text-white">
                        <small>от</small>
                        1 000 $ <span class="font-weight-normal">за одного</span></h5>
                </div>
            </div>

            <div class="swiper-slide country-resorts--item">
                <img src="/img/photos/france.png" alt="img">
                <div class="country-resorts--item__info d-flex flex-column justify-content-end">
                    <h2 class="text-white">алания</h2>
                    <p class="text-white">
                        This is Photoshop's version of Lorem Ipsum. Proin gravida
                    </p>
                    <h5 class="text-white">
                        <small>от</small>
                        1 000 $ <span class="font-weight-normal">за одного</span></h5>
                </div>
            </div>

            <div class="swiper-slide country-resorts--item">
                <img src="/img/photos/france.png" alt="img">
                <div class="country-resorts--item__info d-flex flex-column justify-content-end">
                    <h2 class="text-white">бодрум</h2>
                    <p class="text-white">
                        This is Photoshop's version of Lorem Ipsum. Proin gravida
                    </p>
                    <h5 class="text-white">
                        <small>от</small>
                        1 000 $ <span class="font-weight-normal">за одного</span></h5>
                </div>
            </div>

            <div class="swiper-slide country-resorts--item">
                <img src="/img/photos/greece.png" alt="img">
                <div class="country-resorts--item__info d-flex flex-column justify-content-end">
                    <h2 class="text-white">анталия</h2>
                    <p class="text-white">
                        This is Photoshop's version of Lorem Ipsum. Proin gravida
                    </p>
                    <h5 class="text-white">
                        <small>от</small>
                        1 000 $ <span class="font-weight-normal">за одного</span></h5>
                </div>
            </div>

            <div class="swiper-slide country-resorts--item">
                <img src="/img/photos/islands.png" alt="img">
                <div class="country-resorts--item__info d-flex flex-column justify-content-end">
                    <h2 class="text-white">кемер</h2>
                    <p class="text-white">
                        This is Photoshop's version of Lorem Ipsum. Proin gravida
                    </p>
                    <h5 class="text-white">
                        <small>от</small>
                        1 000 $ <span class="font-weight-normal">за одного</span></h5>
                </div>
            </div>

            <div class="swiper-slide country-resorts--item">
                <img src="/img/photos/italy.png" alt="img">
                <div class="country-resorts--item__info d-flex flex-column justify-content-end">
                    <h2 class="text-white">бодрум</h2>
                    <p class="text-white">
                        This is Photoshop's version of Lorem Ipsum. Proin gravida
                    </p>
                    <h5 class="text-white">
                        <small>от</small>
                        1 000 $ <span class="font-weight-normal">за одного</span></h5>
                </div>
            </div>
        </div>

        <div class="swiper-pagination swiper-bottom-blog-pagination pagination-v3 w-100"></div>
    </div>
</section>

<section class="section section-useful-info grey-bg">
    <div class="container">
        <div class="section-header header-text-left left-offset-3 line-bottom" id="line-4">
            <div class="row">
                <div class="col-9 offset-md-0 offset-lg-2 header-title active" id="animate4">
                    <h2 class="header-title__title grey-bg"><span class="header-title__text">полезная</span> информация
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="useful-information">
            <div class="filter-buttons d-flex flex-wrap flex-column flex-lg-row">
                <button type="button" class="btn-filter active">
                    Виза в Турцию
                </button>
                <button type="button" class="btn-filter">
                    Достопримечательности
                </button>
                <button type="button" class="btn-filter">
                    Погода
                </button>
                <button type="button" class="btn-filter">
                    Кухня
                </button>
                <button type="button" class="btn-filter">
                    Культура
                </button>
                <button type="button" class="btn-filter">
                    Валюта
                </button>
            </div>

            <div class="useful-information-block">
                <div class="current-tour--body active clearfix">
                    <img src="/img/photos/useful_img1.png" alt="image" class="float-left">

                    <p>
                        This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean
                        sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id
                        elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum
                        velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat
                        auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per
                        inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a
                        augue.
                    </p>

                    <h2>This is Photoshop's version</h2>

                    <p>
                        of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis
                        bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit
                        amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio
                        tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit. Class
                        aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                        Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.
                    </p>

                    <p>
                        Sed non neque elit.
                        Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum
                        feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim.
                        Sed non mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora
                        torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu
                        felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi. Proin
                        condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas
                        quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim.
                    </p>

                    <p>
                        Sed non neque elit.
                        Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum
                        feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim.
                        Sed non mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora
                        torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu
                        felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi. Proin
                        condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas
                        quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim.
                    </p>

                    <div class="mt-5 d-block d-md-none">
                        <a href="/" class="btn-regular button-isi btn-size-m m-auto">показать больше</a>
                    </div>
                </div>

                <div class="current-tour--body">
                    Collapse 2
                </div>

                <div class="current-tour--body">
                    Collapse 3
                </div>

                <div class="current-tour--body">
                    Collapse 4
                </div>

                <div class="current-tour--body">
                    Collapse 5
                </div>

                <div class="current-tour--body">
                    Collapse 6
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-tour-application">
    <div class="container">
        <div class="section-header header-text-right w-b-150 header-text_white line-bottom" id="line-5">
            <div class="row">
                <div class="offset-md-4 offset-lg-3 col-12 col-md-8 col-lg-6 header-title active" id="animate5">
                    <h2 class="header-title__title"><span class="header-title__text">отправьте заявку</span>на подбор
                        тура</h2>
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

<section class="section section-ocean-recommends grey-bg">
    <div class="container">
        <div class="section-header header-text-right active line-bottom" id="line-6">
            <div class="row">
                <div class="offset-1 offset-md-4 offset-lg-6 col-11 col-md-8 col-lg-6 header-title active"
                     id="animate6">
                    <h2 class="header-title__title grey-bg"><span class="header-title__text">о Турции</span> в нашем
                        блоге</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container container-lg-mw">
        <div class="swiper-container swiper-blog-container card-swiper-blog-container pt-3">
            <div class="swiper-wrapper swiper-blog--container_wrapper">
                <div class="swiper-slide card-blog-bottom margin-b-30">
                    <div class="card card-size-s card-blog mb-0">
                        <div class="card-header">
                            <div class="card-header--image">
                                <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/02/05/60/2056016.jpg"
                                     alt="lala">
                                <div class="card-header--common">
                                    <div class="card-blog--title text-white font-montserrat font-size-s">
                                        <p>ajsd jasdh jasdh jasd jasd asd</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body--region d-flex">
                                <span class="blog-date">28.02.2019</span>
                                <span class="blog-views"><i class="icon-other icon-eye"></i>2</span>
                            </div>
                            <div class="card-body--desc">
                                <p>Lalas aksdn jasnd jaksndk bashudvg uahsd guasdb absdkj bajdsbhj hasd</p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a class="no-btn" href="#">Подробнее</a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide card-blog-bottom margin-b-30">
                    <div class="card card-size-s card-blog mb-0">
                        <div class="card-header">
                            <div class="card-header--image">
                                <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/02/05/60/2056016.jpg"
                                     alt="lala">
                                <div class="card-header--common">
                                    <div class="card-blog--title text-white font-montserrat font-size-s">
                                        <p>ajns jadndsad asd asd </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body--region d-flex">
                                <span class="blog-date">28.02.2019</span>
                                <span class="blog-views"><i class="icon-other icon-eye"></i>1</span>
                            </div>
                            <div class="card-body--desc">
                                <p>asjdn ajsd ajsd bajsd najsd njasdn ajsnd jasd . asjdn ajsd
                                    ajsd bajsd najsd njasdn ajsnd jasd . asjdn ajsd ajsd bajsd najsd njasdn ajsnd jasd .
                                </p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a class="no-btn" href="">Подробнее</a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide card-blog-bottom margin-b-30">
                    <div class="card card-size-s card-blog mb-0">
                        <div class="card-header">
                            <div class="card-header--image">
                                <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/02/05/60/2056016.jpg"
                                     alt="lala">
                                <div class="card-header--common">
                                    <div class="card-blog--title text-white font-montserrat font-size-s">
                                        <p>New post #1</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body--region d-flex">
                                <span class="blog-date">18.02.2019</span>
                                <span class="blog-views"><i class="icon-other icon-eye"></i>27</span>
                            </div>
                            <div class="card-body--desc">
                                <p>asdb ajsdb asbd jabsd jbasdj basjd . asdb ajsdb asbd jabsd
                                    jbasdj basjd . asdb ajsdb asbd jabsd jbasdj basjd . asdb ajsdb asbd jabsd jba . asdb
                                    ajsdb asbd jabsd jba . asdb ajsdb asbd jabsd jba
                                </p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a class="no-btn" href="">Подробнее</a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide card-blog-bottom margin-b-30">
                    <div class="card card-size-s card-blog mb-0">
                        <div class="card-header">
                            <div class="card-header--image">
                                <img src="https://5okean.com/admin/uploads/2019/02/hotels/00/02/05/60/2056016.jpg"
                                     alt="lala">
                                <div class="card-header--common">
                                    <div class="card-blog--title text-white font-montserrat font-size-s">
                                        <p>ajsd jasdh jasdh jasd jasd asd asd asd asd asd asd mnalskjndf jasbfj hbasfj
                                            asf</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body--region d-flex">
                                <span class="blog-date">28.02.2019</span>
                                <span class="blog-views"><i class="icon-other icon-eye"></i>2</span>
                            </div>
                            <h6 class="card-body--desc"></h6>
                        </div>
                        <div class="card-footer">
                            <a class="no-btn" href="">Подробнее</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="visible-1199">
                <div class="swiper-pagination swiper-bottom-blog-pagination w-100"></div>
            </div>
        </div>
    </div>
</section>

<section class="section section-ocean-recommends">
    <div class="container">
        <div class="section-header header-text-left left-offset-3 line-bottom" id="line-7">
            <div class="row">
                <div class="col-9 offset-md-0 offset-lg-1 header-title active" id="animate7">
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
            <h2>Какой-то заголовок сео-текста</h2>
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