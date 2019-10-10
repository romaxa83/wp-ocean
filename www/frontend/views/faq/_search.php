<?php
use yii\helpers\Url;
?>

<section class="section-presentation section-faq position-relative">
    <div class="search-section search-counties-section d-flex flex-column align-items-center pt-0"
         style="background: url(/img/photos/voprosi_bg.png) center / cover no-repeat;">
        <div class="container mb-auto">
            <div class="row">
                <div class="col-md-12">
                    <?php echo (isset(Yii::$app->view->params['breadcrumbs'])) ? Yii::$app->view->params['breadcrumbs'] : FALSE; ?>
                </div>
            </div>
        </div>

        <div class="w-100 mb-auto">
            <h1 class="filter-form-wrapper--header text-center text-white">Как мы можем Вам помочь?</h1>

            <div class="container">
                <form class="faq-search-form" method="POST">
                    <div class="full-filter faq-filter d-flex flex-wrap">
                        <input
                                type="text"
                                <?= isset($searchInputValue) && !empty($searchInputValue)?'value="'.$searchInputValue.'"':''?>
                                name="questions_field"
                                placeholder="Поиск"
                                class="faq-search-field full-width-input">
                        <button type="submit"
                                id="btnSearchQuestion"
                                class="btn-find btn-regular btn-size-m button-isi submit-filter mb-md-3">Найти</button>
                        <p class="text-white text-center w-100">Здесь Вы можете найти ответы на интересующие Вас вопросы!</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>