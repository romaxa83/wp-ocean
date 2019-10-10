<?php

use backend\modules\filter\widgets\filter\FilterWidget;
?>
<div class="search-section pt-0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php echo (isset(Yii::$app->view->params['breadcrumbs'])) ? Yii::$app->view->params['breadcrumbs'] : FALSE; ?>
            </div>
        </div>
    </div>
    <div class="heading-search"><?php echo $page_info['title']; ?></div>
    <?php echo FilterWidget::widget(['alias' => $filter['type'], 'data' => Yii::$app->request->get()]); ?>
</div>
<div id="search-result" data-type-page="<?php echo $type_page; ?>">
    <div class="search-results">
        <div class="container">
            <div class="results-parametrs d-none">
                <div class="btn-parametr btn-cube" data-view="0">
                    <i class="icon-other icon-cubes <?php echo (!Yii::$app->session->has('search_view')) ? 'active' : '' ?><?php echo (Yii::$app->session->has('search_view') && Yii::$app->session->get('search_view') == 0) ? 'active' : '' ?>"></i>
                </div>
                <div class="btn-parametr btn-list" data-view="1">
                    <i class="icon-other icon-list <?php echo (Yii::$app->session->has('search_view') && Yii::$app->session->get('search_view') == 1) ? 'active' : '' ?>"></i>
                </div>
            </div>
            <div class="result-cards-wrapper row sales-container <?php echo (Yii::$app->session->has('search_view') && Yii::$app->session->get('search_view') == 1) ? 'list-style' : '' ?>"></div>
            <div class="loader d-none"></div>
        </div>
    </div>
</div>
<section class="section section-seo grey-bg">
    <div class="container invisible">
        <div class="seo-wrapper" id="collapseExample">
            <?php echo $page_info['pageText']['description']['text']; ?>
        </div>
    </div>
</section>
