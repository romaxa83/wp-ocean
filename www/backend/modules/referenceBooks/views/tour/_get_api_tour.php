<?php

use yii\grid\GridView;
use yii\helpers\Url;
use backend\modules\referenceBooks\models\CustomActionColumn;

$tour_options = '';
for ($i = 0; $i <= 20; $i++) {
    $tour_options .= "<option value=\"$i\">$i</option>";
}

if ($dataProvider->count > 0) {
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '<div class="summary">Страница ' . $page . '.Всего {totalCount} записей</div>',
        'tableOptions' => [
            'class' => 'table middle'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '5%'],
                'value' => function($model) {
                    return $model->id;
                }
            ],
            [
                'attribute' => 'hid',
                'headerOptions' => ['width' => '5%'],
                'value' => function($model) {
                    return $model->hid;
                }
            ],
            [
                'attribute' => 'name',
                'headerOptions' => ['width' => '30%'],
                'value' => function($model) {
                    return $model->name;
                }
            ],
            [
                'attribute' => 'category_id',
                'headerOptions' => ['width' => '5%'],
                'value' => function($model) {
                    return $model->category_id . '*';
                }
            ],
            [
                'attribute' => 'Дата',
                'headerOptions' => ['width' => '5%'],
                'value' => function($model) use ($hotels_info) {
                    return $hotels_info[$model->hid]['date_begin'];
                }
            ],
            [
                'attribute' => 'Питание',
                'headerOptions' => ['width' => '5%'],
                'value' => function($model) use ($hotels_info) {
                    return $hotels_info[$model->hid]['food'];
                }
            ],
            [
                'attribute' => 'Оператор',
                'headerOptions' => ['width' => '5%'],
                'value' => function($model) use ($hotels_info) {
                    return $hotels_info[$model->hid]['operator'];
                }
            ],
            [
                'attribute' => 'Цена (грн)',
                'headerOptions' => ['width' => '5%'],
                'value' => function($model) use ($hotels_info) {
                    return $hotels_info[$model->hid]['price'];
                }
            ],
            [
                'attribute' => 'Топ продаж',
                'headerOptions' => ['width' => '10%'],
                'format' => 'raw',
                'value' => function($model, $key, $index, $grid) use ($tour_options) {
                    return '<select class="form-control main-fasten" name="main">' .
                            $tour_options.
                            '</select>';
                }
            ],
            [
                'attribute' => '5 океан_рекомендует',
                'headerOptions' => ['width' => '10%'],
                'format' => 'raw',
                'value' => function($model, $key, $index, $grid) use ($tour_options) {
                    return '<select class="form-control recommend-fasten" name="recommend">' .
                            $tour_options.
                            '</select>';
                }
            ],
            [
                'attribute' => 'Горящие туры',
                'headerOptions' => ['width' => '10%'],
                'format' => 'raw',
                'value' => function($model, $key, $index, $grid) use ($tour_options) {
                    return '<select class="form-control hot-fasten" name="hot">' .
                            $tour_options.
                            '</select>';
                }
            ],
            [
                'class' => CustomActionColumn::className(),
                'headerOptions' => ['width' => '5%'],
                'template' => '{plus}',
                'buttons' => [
                    'plus' => function ($url, $model) use ($hotels_info) {
                        return '<a href="' . Url::to(['/referenceBooks/add-api-tour', 'id' => $model->hid], TRUE) . '" data-hid="' . $model->hid . '" data-info="' . htmlentities($hotels_info[$model->hid]['offer'], ENT_QUOTES, 'UTF-8') . '" data-id="' . $model->hid . '" class="add-api-tour"><i class="fa fa-plus" aria-hidden="true"></i></a>';
                    },
                ]
            ]
        ]
    ]);
} else {
    echo 'Нет данных';
}
?>
