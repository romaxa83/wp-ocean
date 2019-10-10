<?php

use yii\helpers\Url;
?>
<div class="filter-form-wrapper opened testclassname">
    <div class="container">
        <h2 class="filter-form-wrapper__header d-block d-lg-none">
            Подбери путешествие своей мечты
        </h2>
        <form action="<?php echo Url::to('/search', TRUE); ?>" method="POST">
            <div class="filter-buttons d-flex justify-content-start align-items-center">
                <button type="button" class="btn-filter btn-filter-type active" data-type="air">Авиа туры</button>
                <!-- <button type="button" class="btn-filter btn-filter-type" data-type="bus">Автобусные туры</button>-->
                <input type="text" name="filterType" id="filterTypeInput" class="hidden"  value="air">
            </div>
            <div class="full-filter" data-filter="<?php echo $alias; ?>">
                <div class="filter-wrapper d-flex justify-content-start align-items-stretch">
                    <div class="filter-items d-flex justify-content-start align-items-stretch">
                        <?php if (isset($country['country']) && count($country['country']) > 0) : ?>
                            <div class="filter-items__item filter-items__item_country" data-default-id="<?= $default['countryCode']?>">
                                <div class="filter-items__header d-flex justify-content-between align-items-stretch p-0 position-relative" data-priority="<?php echo $country['priority']; ?>">
                                    <select class="mobile-shadow-select d-md-none" name="shadowSelectCountry">
                                        <?php foreach ($country['country'] as $v): ?>
                                            <option <?php echo ($country['default'] == $v['id']) ? 'selected' : NULL; ?> value="<?php echo $v['alias']; ?>" data-id="<?php echo $v['cid']; ?>"><?php echo $v['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select class="js-states form-control country-select search-select" name="countryCode" id="filterCountryInput">
                                        <?php foreach ($country['country'] as $v): ?>
                                            <option <?php echo ($country['default'] == $v['id']) ? 'selected' : NULL; ?> value="<?php echo $v['alias']; ?>" data-id="<?php echo $v['cid']; ?>"><?php echo $v['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($dept_city['dept_city']) && count($dept_city['dept_city']) > 0) : ?>
                            <div class="filter-items__item filter-items__item_city" data-default-id="<?= $default['filterCity']?>">
                                <div class="filter-items__header d-flex justify-content-between align-items-stretch p-0" >
                                    <select class="mobile-shadow-select d-md-none" name="shadowSelectCity">
                                        <?php foreach ($dept_city['dept_city'] as $v): ?>
                                            <option <?php echo ($dept_city['default'] == $v['id']) ? 'selected' : NULL; ?> value="<?php echo $v['alias']; ?>" data-id="<?php echo $v['cid']; ?>"><?php echo $v['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select class="js-states form-control custom-select " name="filterCity">
                                        <?php foreach ($dept_city['dept_city'] as $v): ?>
                                            <option <?php echo ($dept_city['default'] == $v['id']) ? 'selected' : NULL; ?> value="<?php echo $v['alias']; ?>" data-id="<?php echo $v['cid']; ?>"><?php echo $v['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="filter-items__item filter-items__item_date">
                            <div class="filter-items__header d-flex justify-content-between align-items-center" id="filterDateLink">
                                <div class="date-inputs d-flex justify-content-center align-items-center default-day">
                                    <div class="date-input-wrapper">
                                        <input type="text" name="filterDateStart" id="filterDateFrom" value="<?php echo $date['begin']; ?>" data-default-value="<?= $default['filterDateStart']?>" readonly>
                                        <i class="icon icon-calendar"></i>
                                    </div>
                                    <span class="divider">-</span>
                                    <div class="date-input-wrapper">
                                        <input type="text" name="filterDateEnd" id="filterDateTo" value="<?php echo $date['end']; ?>" data-default-value="<?= $default['filterDateEnd']?>" readonly>
                                        <i class="icon icon-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-dropdown-wrapper dropdown-menu non-event" id="filterDate" aria-labelledby="filterDateLink"></div>
                        </div>
                        <div class="filter-items__item filter-items__item_time">
                            <div class="filter-items__header d-flex justify-content-between align-items-stretch p-0 length-range" data-range="<?php echo $length['range']; ?>">
                                <select class="mobile-shadow-select mobile-shadow-select--left d-md-none" name="shadowSelectDaysFrom" data-sourcename="filterDaysFrom">
                                    <?php for ($i = $length['limit'][0]; $i <= $length['limit'][1]; $i++): ?>
                                        <option <?php echo ($i == $length['length']) ? 'selected="selected"' : '' ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select class="mobile-shadow-select mobile-shadow-select--right d-md-none" name="shadowSelectDaysTo" data-sourcename="filterDaysTo">
                                    <?php for ($i = $length['limit'][0]; $i <= $length['limit'][1]; $i++): ?>
                                        <option <?php echo ($i == $length['lengthTo']) ? 'selected="selected"' : '' ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <div class="d-flex justify-content-center align-items-center w-100">
                                    <div class="d-flex align-items-center filter-items__header position-relative px-0">
                                        <div class="filter-items__item_time_divider">от</div>
                                        <select class="js-states form-control custom-select d-none js-filter-days-select" name="filterDaysFrom" data-default-value="<?= $default['filterDaysFrom']?>">
                                            <?php for ($i = $length['limit'][0]; $i <= $length['limit'][1]; $i++): ?>
                                                <option <?php echo ($i == $length['length']) ? 'selected="selected"' : '' ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="d-flex align-items-center filter-items__header position-relative px-0">
                                        <div class="filter-items__item_time_divider">до</div>
                                        <select class="js-states form-control custom-select d-none js-filter-days-select" name="filterDaysTo" data-default-value="<?= $default['filterDaysTo']?>">
                                            <?php for ($i = $length['limit'][0]; $i <= $length['limit'][1]; $i++): ?>
                                                <option <?php echo ($i == $length['lengthTo']) ? 'selected="selected"' : '' ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="filter-items__item_time_divider">ночей</div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-items__item filter-items__item_people" data-default-id="<?= $default['filterPeople']?>">
                            <div class="filter-items__header d-flex justify-content-between align-items-center" id="filterPeopleLink"
                                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-drop-header="filterPeople" role="button">
                                <span class="filter-items__title"></span>
                                <i class="icon icon-add-user"></i>
                            </div>
                            <div class="filter-dropdown-wrapper dropdown-menu non-event" id="filterPeople" aria-labelledby="filterPeopleLink">
                                <div class="filter-dropdown ">
                                    <div class="filter-inputs-wrapper">
                                        <div class="filter-input">
                                            <p class="filter-input__label">Взрослых</p>
                                            <div class="filter-input-wrapper">
                                                <input type="text" class="dropdown-input digit-input" id="adultsCounter" name="adultsCounter" value="<?php echo $people['default']; ?>" data-min="1" data-default-value="<?= $default['filterPeople']?>" />
                                                <span class="input-arrow input-plus"></span>
                                                <span class="input-arrow input-minus"></span>
                                            </div>
                                        </div>
                                        <div class="filter-input children-counter-input">
                                            <p class="filter-input__label">Детей</p>
                                            <div class="filter-input-wrapper">
                                                <input type="text" class="dropdown-input digit-input" id="childrenCounter" name="childrenCounter" value="<?php echo (isset($data['children']) && $data['children'] != 0) ? count(explode(',', $data['children'])) : 0; ?>" data-min="0" data-children ="<?php echo (isset($data['children'])) ? $data['children'] : ''; ?>" />
                                                <span class="input-arrow input-plus"></span>
                                                <span class="input-arrow input-minus"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-inputs-wrapper children-age-inputs"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn-find btn-regular btn-size-m button-isi submit-filter">Найти</button>
                </div>
                <div class="additional-filter-wrapper justify-content-start align-items-start flex-wrap">
                    <div class="additional-filter-left d-flex justify-content-start align-items-start flex-wrap">
                        <?php if (isset($category['category']) && count($category['category']) > 0): ?>
                            <div class="filter-checkboxes category-hotels filter-items__item" data-default-id="<?= $default['filterCatHotelLink']?>">
                                <h6 class="filter-checkboxes__title d-none d-lg-block">Категории отелей</h6>
                                <div class="filter-items__header d-flex d-lg-none justify-content-between align-items-center" id="filterCatHotelLink"
                                     data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-drop-header="filterCatHotel" role="button">
                                    <span class="filter-items__title">Категории отелей</span>
                                    <i class="filter-caret "></i>
                                </div>
                                <div class="all-checkboxes category-hotels-checkboxes filter-dropdown-wrapper dropdown-menu non-event" id="filterCatHotel"
                                     aria-labelledby="filterCatHotelLink">
                                    <div class="main-checkbox">
                                        <input type="checkbox" name="all_catHotels" id="allCatHotels" />
                                        <label for="allCatHotels">Все варианты</label>
                                    </div>
                                    <div class="checkboxes-wrapper ">
                                        <?php foreach ($category['category'] as $v): ?>
                                            <?php if (array_search($v['name'], ['1*', '2*', '3*', '4*', '5*']) !== FALSE): ?>
                                                <div class="checkbox">
                                                    <input type="checkbox" <?php echo (array_search($v['id'], $category['default']) !== FALSE) ? 'checked' : NULL; ?> name="stars[]" value="<?php echo (int) $v['name']; ?>" id="<?php echo $v['code'] . 'Stars'; ?>" />
                                                    <label for="<?php echo $v['code'] . 'Stars'; ?>">
                                                        <img src="<?php echo '/img/icons/' . $v['code'] . 'Stars.png'; ?>" alt="<?php echo $v['code'] . 'Stars'; ?>" />
                                                    </label>
                                                </div>
                                            <?php else : ?>
                                                <div class="checkbox">
                                                    <input type="checkbox" <?php echo (array_search($v['id'], $category['default']) !== FALSE) ? 'checked' : NULL; ?> name="<?php echo $v['code']; ?>" id="<?php echo $v['code']; ?>" value="<?php echo $v['code']; ?>" />
                                                    <label for="<?php echo $v['code']; ?>"><?php echo $v['name']; ?></label>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($food['food']) && count($food['food']) > 0): ?>
                            <div class="filter-checkboxes nutrition filter-items__item" data-default-id="<?= $default['filterNutrition']?>">
                                <h6 class="filter-checkboxes__title d-none d-lg-block">Питание</h6>
                                <div class="filter-items__header d-flex d-lg-none justify-content-between align-items-center" id="filterNutritionLink"
                                     data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-drop-header="filterNutrition" role="button">
                                    <span class="filter-items__title">Питание</span>
                                    <i class="filter-caret "></i>
                                </div>
                                <div class="all-checkboxes filter-dropdown-wrapper dropdown-menu non-event" id="filterNutrition"
                                     aria-labelledby="filterNutritionLink">
                                    <div class="main-checkbox">
                                        <input type="checkbox" name="all_nutrition" id="allNutrition" />
                                        <label for="allNutrition">Все варианты</label>
                                    </div>
                                    <div class="checkboxes-wrapper">
                                        <?php foreach ($food['food'] as $v): ?>
                                            <div class="checkbox">
                                                <input type="checkbox" name="food[]" <?php echo (array_search($v['id'], $food['default']) !== FALSE) ? 'checked' : NULL; ?> id="<?php echo $v['code']; ?>" value="<?php echo $v['code']; ?>" />
                                                <label for="<?php echo $v['code']; ?>"><?php echo strtoupper($v['code']); ?> <span><?php echo $v['name']; ?></span></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="price-slider-wrapper filter-items__item <?php echo ($price['from'] == 0 && $price['to'] == 0) ? 'd-none' : ''; ?>">
                            <div class="filter-items__header d-flex d-lg-none justify-content-between align-items-center" id="filterPriceLink"
                                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-drop-header="filterPrice" role="button">
                                <span class="filter-items__title">Цена</span>
                                <i class="filter-caret "></i>
                            </div>
                            <div class="prices filter-dropdown-wrapper dropdown-menu non-event" id="filterPrice" aria-labelledby="filterPriceLink">
                                <div class="price-input price-from">
                                    <span>От:</span>
                                    <input type="text" name="priceMin" placeholder="<?php echo $price['from']; ?>" id="price_min" data-slider="price" data-input="0" data-value="<?php echo $price['price_min']; ?>" value="<?php echo $price['price_min']; ?>" data-default-value="<?= $default['priceMin'];?>">
                                </div>
                                <div class="price-input price-to">
                                    <span>До:</span>
                                    <input type="text" name="priceMax" placeholder="<?php echo $price['to']; ?>" id="price_max" data-slider="price" data-input="1" data-value="<?php echo $price['price_max']; ?>" value="<?php echo $price['price_max']; ?>" data-default-value="<?= $default['priceMax'];?>">
                                </div>
                                <div class="price-input price-to">
                                    <span>Валюта:</span>
                                    <div class="filter-items__item filter-items__item_currency">
                                        <!-- removed role button -->
                                        <div class="filter-items__header d-flex justify-content-between align-items-center" id="filterCurrencyLink" data-drop-header="filterCurrency">
                                            <span class="filter-items__title"><?php echo $price['currency']; ?></span>
                                            <i class="filter-caret "></i>
                                            <input type="text" name="filterCurrency" class="hidden" value="<?php echo $price['currency']; ?>" data-default-value="<?= $default['currency'];?>" />
                                        </div>
                                        <div class="filter-dropdown-wrapper dropdown-menu" id="filterCurrency" aria-labelledby="filterCurrencyLink">
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
                        <div class="filter-checkboxes category-resorts filter-items__item <?php echo (is_array($city) && count($city) == 0) ? 'd-none' : ''; ?>" data-default-id="<?= $default['filterResorts']?>">
                            <h6 class="filter-checkboxes__title d-none d-lg-block">Курорты</h6>
                            <div class="filter-items__header d-flex d-lg-none justify-content-between align-items-center" id="filterResortsLink"
                                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-drop-header="filterResorts" role="button">
                                <span class="filter-items__title">Курорты</span>
                                <i class="filter-caret "></i>
                            </div>
                            <div class="all-checkboxes filter-dropdown-wrapper dropdown-menu non-event" id="filterResorts"
                                 aria-labelledby="filterResortsLink">
                                <div class="main-checkbox">
                                    <input type="checkbox" name="all_resorts" id="allResorts" />
                                    <label for="allResorts">Все варианты</label>
                                </div>
                                <div class="checkboxes-wrapper checkboxes-grey ">
                                    <div class="resort-checkboxes">
                                        <?php if (isset($city['city']) && count($city['city']) > 0): ?>
                                            <?php foreach ($city['city'] as $v): ?>
                                                <div class="checkbox" data-id="<?php echo $v['cid']; ?>">
                                                    <input type="checkbox" name="city[]" <?php echo (array_search($v['id'], $city['default']) !== FALSE) ? 'checked' : NULL; ?> id="<?php echo 'city-' . $v['alias']; ?>" value="<?php echo $v['alias']; ?>" />
                                                    <label for="<?php echo 'city-' . $v['alias']; ?>"><?php echo $v['name']; ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-checkboxes category-hotels-titles filter-items__item <?php echo (is_array($hotel) && count($hotel) == 0) ? 'd-none' : ''; ?>" data-default-id="<?= $default['filterHotelsTitles']?>">
                            <h6 class="filter-checkboxes__title d-none d-lg-block">Отели</h6>
                            <div class="filter-items__header d-flex d-lg-none justify-content-between align-items-center" id="filterHotelsTitlesLink"
                                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-drop-header="filterHotelsTitles" role="button">
                                <span class="filter-items__title">Отели</span>
                                <i class="filter-caret "></i>
                            </div>
                            <div class="all-checkboxes filter-dropdown-wrapper dropdown-menu non-event" id="filterHotelsTitles"
                                 aria-labelledby="filterHotelsTitlesLink">
                                <div class="main-checkbox">
                                    <input type="checkbox" name="all_hotels" id="allHotels" />
                                    <label for="allHotels">Все варианты</label>
                                </div>
                                <div class="checkboxes-wrapper  checkboxes-grey ">
                                    <div class="hotel-search">
                                        <input type="text" placeholder="Найти отель" id="filterHotelInput" onkeyup="filterFunction();">
                                        <i class="icon icon-search"></i>
                                    </div>
                                    <div class="hotels-checkboxes" id="hotels-checkboxes-wrapper">
                                        <?php if (isset($hotel['hotel']) && count($hotel['hotel']) > 0): ?>
                                            <?php foreach ($hotel['hotel'] as $v): ?>
                                                <div class="checkbox" data-id="<?php echo $v['country_id']; ?>">
                                                    <input type="checkbox" name="hotel[]" <?php echo (array_search($v['id'], $hotel['default']) !== FALSE) ? 'checked' : NULL; ?> id="<?php echo 'hotel-' . $v['alias']; ?>" value="<?php echo $v['alias']; ?>" />
                                                    <label for="<?php echo 'hotel-' . $v['alias']; ?>"><?php echo $v['name']; ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="additional-filter-bottom">
                        <button type="reset" class="btn-filter-reset m-0">
                            <span class="d-none d-lg-block"><i class="icon icon-cross-menu"></i> Очистить фильтры</span> <span class="d-block d-lg-none">Сбросить</span>
                        </button>
                        <button type="submit" class="btn-regular btn-size-m button-isi submit-filter visible-991">
                            <span class="d-none d-lg-block">Найти туры</span>
                            <span class="d-block d-lg-none">Найти тур</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="additional-filter d-flex flex-wrap justify-content-between pl-4">
                <span class="additional-filter__text mr-4">Показать дополнительные параметры</span>
                <button type="reset" class="reset-filter reset-filter-styled align-items-center mr-4"><i class="icon icon-cross-menu mr-2"></i>Очистить фильтры</button>
            </div>
        </form>
    </div>
</div>
