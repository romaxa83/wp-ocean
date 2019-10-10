<?php

use yii\bootstrap\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;
use yii\web\JsExpression;

$this->title = 'Добавление тура';

$this->params['breadcrumbs'][] = ['label' => 'Справочник туров', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referenceBooks-tour-form">
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(['id' => 'tour-form', 'method' => 'POST']); ?>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Общая информация</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php
                                        echo $form->field($tour, 'date_begin')->textInput(['maxlength' => true])
                                                ->widget(DateTimePicker::className(), [
                                                    'language' => 'ru',
                                                    'options' => ['autocomplete' => 'off', 'readonly' => 'readonly'],
                                                    //'convertFormat' => true,
                                                    'pluginOptions' => [
                                                        'minuteStep' => 1,
                                                        'format' => 'yyyy-mm-dd hh:ii:ss',
                                                        'autoclose' => true,
                                                    ]
                                                ])->label($tour->getAttributeLabel('date_begin'));
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        echo $form->field($tour, 'date_end')->textInput(['maxlength' => true])
                                                ->widget(DateTimePicker::className(), [
                                                    'language' => 'ru',
                                                    'options' => ['autocomplete' => 'off', 'readonly' => 'readonly'],
                                                    //'convertFormat' => true,
                                                    'pluginOptions' => [
                                                        'minuteStep' => 1,
                                                        'format' => 'yyyy-mm-dd hh:ii:ss',
                                                        'autoclose' => true,
                                                    ]
                                                ])->label($tour->getAttributeLabel('date_end'));
                                        ?>
                                    </div>
                                </div>
                                <?php echo $form->field($tour, 'id')->textInput(['readonly' => 'readonly', 'type' => 'hidden'])->label(false); ?>
                                <?php echo $form->field($tour, 'title'); ?>
                                <?php
                                echo $form->field($tour, 'stock_id')->widget(Select2::classname(), [
                                    'data' => $specials,
                                    'options' => ['placeholder' => ''],
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                                <?php
                                echo $form->field($tour, 'operator_id')->widget(Select2::classname(), [
                                    'data' => $operator,
                                    'options' => ['placeholder' => ''],
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                                <?php
                                echo $form->field($tour, 'dept_city_id')->widget(Select2::classname(), [
                                    'data' => $dept_city,
                                    'options' => ['placeholder' => '', 'class' => 'filter-country'],
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                                <?php
                                echo $form->field($tour, 'city_id')->widget(Select2::classname(), [
                                    'data' => $city,
                                    'options' => ['placeholder' => '', 'class' => 'filter-country'],
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                                <?php
                                echo $form->field($tour, 'hotel_id')->widget(Select2::classname(), [
                                    'data' => $hotel,
                                    'options' => ['placeholder' => ''],
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                                <?php
                                echo $form->field($tour, 'type_food_id')->widget(Select2::classname(), [
                                    'data' => $type_food,
                                    'options' => ['placeholder' => ''],
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <?php
                                        echo $form->field($tour, 'date_end_sale')->textInput(['maxlength' => true])
                                                ->widget(DateTimePicker::className(), [
                                                    'language' => 'ru',
                                                    'options' => ['autocomplete' => 'off', 'readonly' => 'readonly'],
                                                    //'convertFormat' => true,
                                                    'pluginOptions' => [
                                                        'minuteStep' => 1,
                                                        'format' => 'yyyy-mm-dd hh:ii:ss',
                                                        'autoclose' => true,
                                                    ]
                                                ])->label($tour->getAttributeLabel('date_end_sale'));
                                        ?>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <?php
                                        echo $form->field($tour, 'date_departure')->textInput(['maxlength' => true])
                                                ->widget(DateTimePicker::className(), [
                                                    'language' => 'ru',
                                                    'options' => ['autocomplete' => 'off', 'readonly' => 'readonly'],
                                                    //'convertFormat' => true,
                                                    'pluginOptions' => [
                                                        'minuteStep' => 1,
                                                        'format' => 'yyyy-mm-dd hh:ii:ss',
                                                        'autoclose' => true,
                                                    ]
                                                ])->label($tour->getAttributeLabel('date_departure'));
                                        ?>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <?php
                                        echo $form->field($tour, 'date_arrival')->textInput(['maxlength' => true])
                                                ->widget(DateTimePicker::className(), [
                                                    'language' => 'ru',
                                                    'options' => ['autocomplete' => 'off', 'readonly' => 'readonly'],
                                                    //'convertFormat' => true,
                                                    'pluginOptions' => [
                                                        'minuteStep' => 1,
                                                        'format' => 'yyyy-mm-dd hh:ii:ss',
                                                        'autoclose' => true,
                                                    ]
                                                ])->label($tour->getAttributeLabel('date_arrival'));
                                        ?>
                                    </div>
                                </div>
                                <?php echo $form->field($tour, 'length')->textInput(['type' => 'number', 'min' => 0]); ?>
                                <?php
                                echo $form->field($tour, 'type_transport_id')->widget(Select2::classname(), [
                                    'data' => $type_transport,
                                    'options' => ['placeholder' => ''],
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <?php echo $form->field($tour, 'price')->textInput(['type' => 'number', 'step' => 0.01, 'min' => 0, 'value' => number_format($tour->price, 2, '.', ''), 'data-value' => number_format($tour->price, 2, '.', ''), 'readonly'=>true]); ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php echo $form->field($tour, 'sale')->textInput(['type' => 'number', 'step' => 1, 'min' => 0, 'max' => 100, 'value' => number_format($tour->sale, 0, '.', '')]); ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php echo $form->field($tour, 'old_price')->textInput(['type' => 'number', 'step' => 0.1, 'min' => 0, 'value' => number_format($tour->old_price, 2, '.', '')]); ?>
                                    </div>
                                </div>
                                <?php
                                echo $form->field($tour, 'currency')->widget(Select2::classname(), [
                                    'data' => ['uah' => 'UAH', 'usd' => 'USD', 'eur' => 'EUR'],
                                    'options' => ['placeholder' => ''],
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <?php
                                        $tour_data = [];
                                        for ($i = 0; $i <= 20; $i++) {
                                            $tour_data[$i] = $i;
                                        }
                                        ?>
                                        <?php
                                        echo $form->field($tour, 'main')->widget(Select2::classname(), [
                                            'data' => $tour_data,
                                            'options' => ['placeholder' => '', 'value' => (($tour->main == NULL) ? 0 : $tour->main)],
                                            'language' => 'ru'
                                        ]);
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        echo $form->field($tour, 'recommend')->widget(Select2::classname(), [
                                            'data' => $tour_data,
                                            'options' => ['placeholder' => '', 'value' => (($tour->recommend == NULL) ? 0 : $tour->recommend)],
                                            'language' => 'ru'
                                        ]);
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        echo $form->field($tour, 'hot')->widget(Select2::classname(), [
                                            'data' => $tour_data,
                                            'options' => ['placeholder' => '', 'value' => (($tour->hot == NULL) ? 0 : $tour->hot)],
                                            'language' => 'ru'
                                        ]);
                                        ?>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <div class="mb-15 mr-15">
                                        <label class="control-label" for="promo_price">Промоцена</label>
                                        <?php
                                        echo Html::checkbox('promo_price', $tour->promo_price, [
                                            'id' => 'promo_price',
                                            'class' => 'tgl tgl-light custome-checkbox',
                                            'value' => $tour->promo_price,
                                            'data-id' => $tour->id,
                                            'data-url' => Url::to(['update-status'])
                                        ]) . Html::label('', 'promo_price', ['class' => 'tgl-btn']);
                                        ?>
                                    </div>
                                    <div class="mb-15 mr-15">
                                        <label class="control-label" for="status">Статус</label>
                                        <?php
                                        echo Html::checkbox('status', $tour->promo_price, [
                                            'id' => 'status',
                                            'class' => 'tgl tgl-light custome-checkbox',
                                            'value' => $tour->status,
                                            'data-id' => $tour->id,
                                            'data-url' => Url::to(['update-status'])
                                        ]) . Html::label('', 'status', ['class' => 'tgl-btn']);
                                        ?>
                                    </div>
                                    <div class="mb-15 mr-15">
                                        <label class="control-label" for="sync">Синхронизация</label>
                                        <?php
                                        echo Html::checkbox('sync', $tour->promo_price, [
                                            'id' => 'sync',
                                            'class' => 'tgl tgl-light custome-checkbox',
                                            'value' => $tour->sync,
                                            'data-id' => $tour->id,
                                            'data-url' => Url::to(['update-status'])
                                        ]) . Html::label('', 'sync', ['class' => 'tgl-btn']);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <?php
                                echo $form->field($tour, 'type_description')->widget(Select2::classname(), [
                                    'data' => [
                                        1 => 'Выводить только API описание',
                                        2 => 'Выводить только свое описание',
                                        3 => 'Выводить оба описания'
                                    ],
                                    'options' => ['placeholder' => ''],
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                                <?php
                                echo $form->field($tour, 'description')->widget(TinyMce::className(), [
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
                                <!-- SEO -->
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="box">
                                            <div class="box-header">
                                                <h3 class="box-title">SEO</h3>
                                            </div>
                                            <div class="box-body">
                                                <div class="box-body">
                                                    <?php echo $form->field($seo, 'h1')->textInput() ?>
                                                    <?php echo $form->field($seo, 'title')->textInput() ?>
                                                    <?php echo $form->field($seo, 'keywords')->textInput() ?>
                                                    <?php echo $form->field($seo, 'description')->textarea(['row' => 3]) ?>
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
                                                    ])
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <a href="<?php echo Url::to(['/referenceBooks/tour']) ?>" class="btn btn-primary">Вернуться к списку</a>
                <?php echo Html::a('Сбросить', ['/referenceBooks/tour/'. Yii::$app->controller->action->id, 'id' => $tour->id], ['class' => 'btn btn-primary']); ?>
                <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
