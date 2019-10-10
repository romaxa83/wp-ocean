<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use dosamigos\tinymce\TinyMce;
use kartik\select2\Select2;
use yii\grid\GridView;
use backend\modules\filemanager\widgets\FileInput;

$this->title = 'Добавление отеля';

$this->params['breadcrumbs'][] = ['label' => 'Справочник отелей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referenceBooks-hotel-form">
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(['id' => 'hotel-form', 'method' => 'POST']); ?>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Общая информация</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Услуги</a></li>
                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Медиа</a></li>
                    <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">Адрес и описание</a></li>
                    <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false">Отзывы</a></li>
                    <li class=""><a href="#tab_6" data-toggle="tab" aria-expanded="false">SEO</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="Hotel[id]" value="<?php echo $hotel->id; ?>" />
                                <?php echo $form->field($hotel, 'name'); ?>
                                <?php echo $form->field($hotel, 'alias'); ?>
                                <?php
                                echo $form->field($hotel, 'country_id')->widget(Select2::classname(), [
                                    'data' => $country,
                                    'options' => ['placeholder' => 'Выбрать страну ...'],
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                                <?php
                                echo $form->field($hotel, 'city_id')->widget(Select2::classname(), [
                                    'data' => [],
                                    'options' => ['placeholder' => 'Выбрать город ...', 'data-id' => $hotel->city_id],
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                                echo $form->field($hotel, 'category_id')->widget(Select2::classname(), [
                                    'data' => $category,
                                    'options' => ['placeholder' => 'Выбрать категорию ...'],
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                                <?php
                                echo $form->field($hotel, 'type_id')->widget(Select2::classname(), [
                                    'data' => $type_hotel,
                                    'options' => ['placeholder' => 'Выбрать тип ...'],
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                                <?php
                                echo $form->field($hotel, 'view_id')->widget(Select2::classname(), [
                                    'data' => $type_tour,
                                    'options' => ['placeholder' => 'Выбрать вид ...'],
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                                <div style="display: flex;">
                                    <div class="box-custome-checkbox">
                                        <?php
                                        echo Html::label($hotel->getAttributeLabel('status'), 'status', ['class' => 'tgl-btn']) . Html::checkbox('Hotel[status]', $hotel->status, [
                                            'id' => 'status',
                                            'class' => 'tgl tgl-light custome-checkbox',
                                            'value' => ($hotel->status) ? $hotel->status : 0,
                                        ]) . Html::label('', 'status', ['class' => 'tgl-btn']);
                                        ?>
                                    </div>
                                    <div class="box-custome-checkbox">
                                        <?php
                                        echo Html::label($hotel->getAttributeLabel('sync'), 'sync', ['class' => 'tgl-btn']) . Html::checkbox('Hotel[sync]', $hotel->sync, [
                                            'id' => 'sync',
                                            'class' => 'tgl tgl-light custome-checkbox',
                                            'value' => ($hotel->sync) ? $hotel->sync : 0,
                                        ]) . Html::label('', 'sync', ['class' => 'tgl-btn']);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <?php if ($service_data): ?>
                            <div class="row add-service mb-15">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                    <?php
                                    echo Select2::widget([
                                        'id' => 'service-type',
                                        'name' => 'type',
                                        'data' => $service_type,
                                        'options' => ['placeholder' => 'Выбрать тип ...'],
                                        'language' => 'ru',
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ]
                                    ]);
                                    ?>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                    <?php
                                    echo Select2::widget([
                                        'id' => 'service-name',
                                        'name' => 'name',
                                        'data' => [],
                                        'options' => ['placeholder' => 'Выбрать имя ...'],
                                        'language' => 'ru',
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ]
                                    ]);
                                    ?>
                                </div>
                                <div class="col-xs-12 col-md-6 col-lg-6 type-service">
                                    <?php
                                    echo Html::checkbox('service-include', 0, [
                                        'id' => 'service-include',
                                        'class' => 'tgl tgl-light custome-checkbox',
                                        'value' => 0,
                                    ]) . Html::label('', 'service-include', ['class' => 'tgl-btn', 'title' => 'Включено в стоимость']);
                                    ?>
                                    <div class="form-group field-service-price">
                                        <input type="number" min="0" id="service-price" class="form-control" name="service-price" placeholder="Цена">
                                    </div>
                                    <button type="button" class="btn btn-primary" id="add-service">Добавить сервис</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box-group" id="accordion">
                                        <?php foreach ($service_data as $k => $v): ?>
                                            <div class="panel box box-primary">
                                                <div class="box-header with-border">
                                                    <h4 class="box-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="<?php echo '#' . $k; ?>" class="collapsed">
                                                            <?php echo '(' . $v->count . ') ' . $k; ?>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="<?php echo $k; ?>" class="panel-collapse collapse">
                                                    <div class="box-body">
                                                        <?php
                                                        echo GridView::widget([
                                                            'dataProvider' => $v,
                                                            'tableOptions' => [
                                                                'class' => 'table middle'
                                                            ],
                                                            'columns' => [
                                                                ['class' => 'yii\grid\SerialColumn'],
                                                                [
                                                                    'attribute' => 'service.id',
                                                                    'label' => 'ID',
                                                                    'headerOptions' => ['width' => '5%', 'class' => 'field-id'],
                                                                    'value' => function($model) {
                                                                        return $model['service']['id'];
                                                                    }
                                                                ],
                                                                [
                                                                    'attribute' => 'service.name',
                                                                    'label' => 'Название',
                                                                    'headerOptions' => ['width' => '70%'],
                                                                    'value' => function($model) {
                                                                        return $model['service']['name'];
                                                                    }
                                                                ],
                                                                [
                                                                    'attribute' => 'type',
                                                                    'label' => 'Тип',
                                                                    'format' => 'raw',
                                                                    'headerOptions' => ['width' => '15%'],
                                                                    'value' => function($model) {
                                                                        return Html::checkbox('type', $model['type'], [
                                                                                    'id' => 'status_' . $model['service']['id'],
                                                                                    'class' => 'tgl tgl-light custome-checkbox',
                                                                                    'value' => $model['type'],
                                                                                    'data-id' => $model['service']['id'],
                                                                                    'data-url' => Url::to(['update-type'])
                                                                                ]) . Html::label('', 'status_' . $model['service']['id'], ['class' => 'tgl-btn']);
                                                                    }
                                                                ],
                                                                [
                                                                    'attribute' => 'price',
                                                                    'label' => 'Цена',
                                                                    'headerOptions' => ['width' => '10%'],
                                                                    'value' => function($model) {
                                                                        return number_format($model['price'], 2, '.', '');
                                                                    }
                                                                ],
                                                                [
                                                                    'class' => 'yii\grid\ActionColumn',
                                                                    'headerOptions' => ['width' => '5%'],
                                                                    'template' => '{delete}',
                                                                    'buttons' => [
                                                                        'delete' => function ($url, $model) {
                                                                            return '<a title="Удалить" class="delete-service" data-id="' . $model['service']['id'] . '"><span class="glyphicon glyphicon-trash"></span></a>';
                                                                        }
                                                                    ]
                                                                ]
                                                            ]
                                                        ]);
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <textarea id="hotel_service_data" class="hidden" name="Hotel[hotel_service_data]" data-id="<?php echo $hotel->id ?>" data-hid="<?php echo $hotel->hid ?>"><?php echo $service_data_json; ?></textarea>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane" id="tab_3">
                        <?php
                        echo FileInput::widget([
                            'name' => 'mediafile',
                            'buttonTag' => 'button',
                            'buttonName' => 'Добавить медиа',
                            'buttonOptions' => ['class' => 'btn btn-primary mb-15'],
                            'options' => ['class' => 'form-control', 'type' => 'hidden'],
                            'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                            'thumb' => 'original',
                            'imageContainer' => '.img',
                            'pasteData' => FileInput::DATA_ID,
                            'callbackBeforeInsert' => 'function(e, data) {
                                setContentView(data.id);
                                renderContentView();
                            }'
                        ]);
                        ?>
                        <input type="hidden" id="gallery-data" name="Hotel[gallery_data]" value="<?php echo ($hotel->gallery) ? $hotel->gallery : '[]'; ?>"/>
                        <div id="media-content" class="table-flexible"></div>
                    </div>
                    <div class="tab-pane" id="tab_4">

                        <div class="row">
                            <div class="col-md-6">
                                <?php echo $form->field($address, 'address'); ?>
                                <?php echo $form->field($address, 'phone'); ?>
                                <?php echo $form->field($address, 'email'); ?>
                                <?php echo $form->field($address, 'site'); ?>
                                <?php
                                echo $form->field($address, 'location')->widget(Select2::classname(), [
                                    'data' => [
                                        1 => 'в центре города',
                                        2 => 'в черте города',
                                        3 => 'вне черты города'
                                    ],
                                    'options' => ['placeholder' => 'Выбрать положение ...'],
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                                <?php
                                echo $form->field($address, 'general_description')->widget(TinyMce::className(), [
                                    'options' => ['rows' => 6, 'class' => 'field-tiny-mce'],
                                    'language' => 'ru',
                                    'clientOptions' => [
                                        'plugins' => [
                                            "advlist autolink lists link charmap print preview anchor",
                                            "searchreplace visualblocks code fullscreen",
                                            "insertdatetime media table contextmenu paste"
                                        ],
                                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                                    ]
                                ]);
                                ?>
                                <?php
                                echo $form->field($address, 'location_description')->widget(TinyMce::className(), [
                                    'options' => ['rows' => 6, 'class' => 'field-tiny-mce'],
                                    'language' => 'ru',
                                    'clientOptions' => [
                                        'plugins' => [
                                            "advlist autolink lists link charmap print preview anchor",
                                            "searchreplace visualblocks code fullscreen",
                                            "insertdatetime media table contextmenu paste"
                                        ],
                                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                                    ]
                                ]);
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php echo $form->field($address, 'data_source'); ?>
                                <?php echo $form->field($address, 'lat'); ?>
                                <?php echo $form->field($address, 'lng'); ?>
                                <?php echo $form->field($address, 'zoom'); ?>
                                <?php
                                echo $form->field($address, 'beach_type')->widget(Select2::classname(), [
                                    'data' => [
                                        1 => 'нет данных',
                                        2 => 'галечный',
                                        3 => 'песчаный'
                                    ],
                                    'options' => ['placeholder' => 'Выбрать тип пляжа ...'],
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                                <?php
                                echo $form->field($address, 'beach_description')->widget(TinyMce::className(), [
                                    'options' => ['rows' => 6, 'class' => 'field-tiny-mce'],
                                    'language' => 'ru',
                                    'clientOptions' => [
                                        'plugins' => [
                                            "advlist autolink lists link charmap print preview anchor",
                                            "searchreplace visualblocks code fullscreen",
                                            "insertdatetime media table contextmenu paste"
                                        ],
                                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                                    ]
                                ]);
                                ?>
                                <?php
                                echo $form->field($address, 'food_description')->widget(TinyMce::className(), [
                                    'options' => ['rows' => 6, 'class' => 'field-tiny-mce'],
                                    'language' => 'ru',
                                    'clientOptions' => [
                                        'plugins' => [
                                            "advlist autolink lists link charmap print preview anchor",
                                            "searchreplace visualblocks code fullscreen",
                                            "insertdatetime media table contextmenu paste"
                                        ],
                                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                                    ]
                                ]);
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $form->field($address, 'distance_sea'); ?>
                                <?php
                                echo $form->field($address, 'location_animals')->widget(Select2::classname(), [
                                    'data' => [
                                        1 => 'нет данных',
                                        2 => 'да',
                                        3 => 'нет'
                                    ],
                                    'options' => ['placeholder' => 'Выбрать тип пляжа ...'],
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                                <?php
                                echo $form->field($address, 'additional_information')->widget(TinyMce::className(), [
                                    'options' => ['rows' => 6, 'class' => 'field-tiny-mce'],
                                    'language' => 'ru',
                                    'clientOptions' => [
                                        'plugins' => [
                                            "advlist autolink lists link charmap print preview anchor",
                                            "searchreplace visualblocks code fullscreen",
                                            "insertdatetime media table contextmenu paste"
                                        ],
                                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                                    ]
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_5">
                        <div class="row">
                            <div class="col-md-3">
                                <?php
                                echo GridView::widget([
                                    'dataProvider' => $rating,
                                    'tableOptions' => [
                                        'class' => 'table'
                                    ],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],
                                        [
                                            'attribute' => 'name',
                                            'label' => 'Название',
                                            'headerOptions' => ['width' => '80%'],
                                            'value' => function($model) {
                                                return $model['name'];
                                            }
                                        ],
                                        [
                                            'attribute' => 'vote',
                                            'label' => 'Значение',
                                            'headerOptions' => ['width' => '20%'],
                                            'value' => function($model) {
                                                return number_format($model['vote'], 2, '.', '');
                                            }
                                        ]
                                    ]
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_6">
                        <?php echo $form->field($seo, 'h1')->textInput(); ?>
                        <?php echo $form->field($seo, 'title')->textInput(); ?>
                        <?php echo $form->field($seo, 'keywords')->textInput(); ?>
                        <?php echo $form->field($seo, 'description')->textarea(['row' => 3]); ?>
                        <?php
                        echo $form->field($seo, 'seo_text')->widget(TinyMce::className(), [
                            'options' => ['rows' => 6, 'class' => 'field-tiny-mce'],
                            'language' => 'ru',
                            'clientOptions' => [
                                'plugins' => [
                                    "advlist autolink lists link charmap print preview anchor",
                                    "searchreplace visualblocks code fullscreen",
                                    "insertdatetime media table contextmenu paste"
                                ],
                                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                            ]
                        ]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <a href="<?php echo Url::to(['/referenceBooks/hotel']) ?>" class="btn btn-primary">Вернуться к списку</a>
                <a href="<?php echo Url::to(['/referenceBooks/hotel/update', 'id' => $hotel->id]) ?>" class="btn btn-primary">Сбросить</a>
                <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
