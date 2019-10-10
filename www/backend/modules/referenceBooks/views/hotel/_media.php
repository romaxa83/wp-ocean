<?php

use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<style>
    table.custome-wrap tbody td{
        white-space: pre-line;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => [
                'class' => 'table middle custome-wrap',
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'id',
                    'label' => 'ID',
                    'headerOptions' => ['width' => '3%'],
                    'value' => function($model) {
                        return $model['id'];
                    }
                ],
                [
                    'attribute' => 'url',
                    'label' => 'Медиа',
                    'format' => 'raw',
                    'headerOptions' => ['width' => '5%'],
                    'value' => function($model) {
                        $info = getimagesize(Url::base(TRUE) . $model['url']);
                        return ($info) ? '<img src="' . Url::base(TRUE) . $model['url'] . '" height="35px" width="35px" />' : '<img src="' . Url::base(TRUE) . 'img/file.png' . '" height="35px" width="35px" />';
                    }
                ],
                [
                    'attribute' => 'alt',
                    'headerOptions' => ['width' => '20%'],
                    'value' => function($model) {
                        return $model['alt'];
                    }
                ],
                [
                    'attribute' => 'description',
                    'label' => 'Описание',
                    'headerOptions' => ['width' => '30%'],
                    'value' => function($model) {
                        return $model['description'];
                    }
                ],
                [
                    'attribute' => 'src',
                    'label' => 'Источник',
                    'headerOptions' => ['width' => '20%'],
                    'format' => 'raw',
                    'contentOptions' => ['style' => "white-space: pre-line;"],
                    'value' => function($model) {
                        return Url::base(TRUE) . $model['url'];
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'label' => 'Дата',
                    'headerOptions' => ['width' => '5%'],
                    'value' => function($model) {
                        return Yii::$app->formatter->asDate($model['created_at'], 'dd.MM.yyyy');
                    }
                ],
                [
                    'attribute' => 'filename',
                    'label' => 'Название',
                    'headerOptions' => ['width' => '5%'],
                    'value' => function($model) {
                        return $model['filename'];
                    }
                ],
                [
                    'attribute' => 'type',
                    'label' => 'Тип',
                    'headerOptions' => ['width' => '5%'],
                    'value' => function($model) {
                        return $model['type'];
                    }
                ],
                [
                    'attribute' => 'size',
                    'label' => 'Размер',
                    'headerOptions' => ['width' => '5%'],
                    'value' => function($model) {
                        return $model['size'] . ' КБ';
                    }
                ],
                [
                    'attribute' => 'size',
                    'label' => 'Разрешение',
                    'headerOptions' => ['width' => '5%'],
                    'value' => function($model) {
                        $info = getimagesize(Url::base(TRUE) . $model['url']);
                        return ($info) ? $info[0] . ' X ' . $info[1] : NULL;
                    }
                ],
                [
                    'attribute' => 'media_id',
                    'label' => 'Фото',
                    'format' => 'raw',
                    'headerOptions' => ['width' => '5%'],
                    'value' => function($model) use ($media_id) {
                        return '<input type="radio" name="Hotel[media_id]" value="' . $model['id'] . '" ' . (isset($media_id) && ($model['id'] == $media_id) ? 'checked="checked"' : FALSE) . '/>';
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'headerOptions' => ['width' => '5%'],
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function ($url, $model, $key) {
                            return Html::a(NULL, NULL, ['class' => 'glyphicon glyphicon-trash delete-item-gallery', 'data-id' => $model['id']]);
                        }
                    ],
                ]
            ]
        ]);
        ?>
    </div>
</div>