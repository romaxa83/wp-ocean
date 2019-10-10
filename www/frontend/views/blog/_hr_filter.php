<?php
use backend\modules\blog\helpers\DateHelper;
use yii\helpers\Url;

/** @var $hotelReview backend\modules\blog\entities\HotelReview*/
/** @var $dataApi*/
/** @var $tourOffers*/
/** @var $allRoom*/
/** @var $typeFood*/
?>

<div class="container get-block-offers mt-5"
     data-id="<?=$hotelReview->hotel->id?>"
     data-dept="<?= $dataApi['deptCity']?>"
     data-people="<?= $dataApi['people']?>"
     data-to="<?=$hotelReview->hotel->hid?>" >
    <h2 class="tour-header font-size-md">
        Туры в отель
        <?= $hotelReview->hotel->name .' '. $hotelReview->hotel->category->name?>
        <span class="hotelName d-none"><?= $hotelReview->hotel->category->name .' '. $hotelReview->hotel->name?></span>
    </h2>
    <div class="tour-desc d-flex justify-content-between flex-wrap">
        <p class="search-offer-info font-size-xs">
            <?= '(Для '. $dataApi['people']. ' взр. , из <span class="deptCity">'. $dataApi['deptCityRel'] .'</span>, c <b class="offer-date-in">'.
            DateHelper::convertForPoint($dataApi['checkIn']) .'</b> по <b class="offer-date-to">' .
            DateHelper::convertForPoint($dataApi['checkTo']) . '</b> , от <b class="offer-length">' .
            $dataApi['length'] . '</b> до <b class="offer-length-to">' .
            $dataApi['lengthTo'] . '</b> ночей)';
            ?>
        </p>
        <div class="reset-filter">Изменить параметры поиска</div>
    </div>

    <div class="add-filter ">
        <div class="full-filter">
            <div class="filter-wrapper d-flex justify-content-start align-items-stretch">
                <div class="filter-items d-flex justify-content-start align-items-stretch">
                    <div class="filter-items__item filter-items__item_date">
                        <div class="filter-items__header d-flex justify-content-between align-items-center" >
                            <div class="date-inputs d-flex justify-content-around justify-content-lg-start align-items-center">
                                <div class="date-input-wrapper">
                                    <input type="text" name="filterDateStart" id="filterDateFrom" val="1" readonly
                                           data-value="<?= $dataApi['checkIn']; ?>">
                                    <i class="icon icon-calendar"></i>
                                </div>
                                <span class="divider">-</span>
                                <div class="date-input-wrapper">
                                    <input type="text" name="filterDateEnd" id="filterDateTo" val="1" readonly
                                           data-value="<?= $dataApi['checkTo']; ?>">
                                    <i class="icon icon-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="filter-dropdown-wrapper dropdown-menu non-event" id="filterDate" aria-labelledby="filterDateLink">

                        </div>
                    </div>
                    <div class="filter-items__item filter-items__item_country filter-by-room">
                        <?= $this->render('_hr_filter_room',[
                            'allRoom' => $allRoom
                        ])?>
                    </div>
                    <div class="filter-items__item filter-items__item_time">
                        <div class="filter-items__header d-flex justify-content-between align-items-stretch p-0 length-range" id="filterDaysLink" data-range="<?php echo Yii::$app->params['filter_days_range']; ?>">
                            <?php
                            $limitDaysFrom = [1, 21];
                            $limitDaysTo = [1, 21];
                            ?>
                            <select class="mobile-shadow-select mobile-shadow-select--left d-md-none" name="shadowSelectDaysFrom" data-sourcename="filterDaysFrom">
                                <?php for ($i = $limitDaysFrom[0]; $i <= $limitDaysFrom[1]; $i++): ?>
                                    <option <?php echo ($i == $dataApi['length']) ? 'selected="selected"' : '' ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                            <select class="mobile-shadow-select mobile-shadow-select--right d-md-none" name="shadowSelectDaysTo" data-sourcename="filterDaysTo">
                                <?php for ($i = $limitDaysTo[0]; $i <= $limitDaysTo[1]; $i++): ?>
                                    <option <?php echo ($i == $dataApi['lengthTo']) ? 'selected="selected"' : '' ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                            <div class="d-flex justify-content-center align-items-center w-100">
                                <div class="d-flex align-items-center filter-items__header position-relative px-0">
                                    <div class="filter-items__item_time_divider">от</div>
                                    <select class="js-states form-control custom-select d-none js-filter-days-select" name="filterDaysFrom">
                                        <?php for ($i = $limitDaysFrom[0]; $i <= $limitDaysFrom[1]; $i++): ?>
                                            <option <?php echo ($i == $dataApi['length']) ? 'selected="selected"' : '' ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center filter-items__header position-relative px-0">
                                    <div class="filter-items__item_time_divider">до</div>
                                    <select class="js-states form-control custom-select d-none js-filter-days-select" name="filterDaysTo">
                                        <?php for ($i = $limitDaysTo[0]; $i <= $limitDaysTo[1]; $i++): ?>
                                            <option <?php echo ($i == $dataApi['lengthTo']) ? 'selected="selected"' : '' ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="filter-items__item_time_divider">ночей</div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-items__item filter-items__item_country filter-checkboxes p-0">
                        <div class="filter-items__header d-flex justify-content-between align-items-center" id="filterNutritionLink"
                             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-drop-header="filterNutrition">
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
                                <div class="checkbox">
                                    <input type="checkbox" class="food-input" name="food[]" value="uai" id="uai" />
                                    <label for="uai">UAI <span>ультра все включено</span></label>
                                </div>
                                <div class="checkbox">
                                    <input type="checkbox" class="food-input" name="food[]" value="ai" id="ai" />
                                    <label for="ai">AI <span>все включено</span></label>
                                </div>
                                <div class="checkbox">
                                    <input type="checkbox" class="food-input" name="food[]" value="fb" id="fb" />
                                    <label for="fb">FB <span>полный пансион</span></label>
                                </div>
                                <div class="checkbox">
                                    <input type="checkbox" class="food-input" name="food[]" value="hb" id="hb" />
                                    <label for="hb">HB <span>завтрак и ужин</span></label>
                                </div>
                                <div class="checkbox">
                                    <input type="checkbox" class="food-input" name="food[]" value="bb" id="bb" />
                                    <label for="bb">BB <span>завтрак</span></label>
                                </div>
                                <div class="checkbox">
                                    <input type="checkbox" class="food-input" name="food[]" value="ob" id="ob" />
                                    <label for="ob">OB <span>без питания</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" data-url="/blog/hotel-review-offers" id="search-offers" class="btn-find btn-regular btn-size-m button-isi">
                    Найти
                </button>
            </div>
            <div class="search-offers loader d-none"></div>
        </div>
    </div>
    <div class="offers-hotel-review">
        <?= $this->render('_hr_offers',[
            'tourOffers' => $tourOffers,
            'hotel' => $hotelReview->hotel,
            'typeFood' => $typeFood,
            'allRoom' => $allRoom
        ])?>
    </div>
    <?= $this->render('_hr_order_modal',[
        'typeFood' => $typeFood
    ])?>
</div>
