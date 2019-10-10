<?php

use yii\bootstrap\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\filemanager\widgets\FileInput;
use kartik\select2\Select2;

$this->title = 'Добавление SEO данных';

$this->params['breadcrumbs'][] = ['label' => 'SEO данные', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .select2-container 
    .select2-selection--single 
    .select2-selection__rendered {
        margin-top: 0px;
    }
</style>
<div class="seo-data-form">
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(['id' => 'seo-data-form', 'method' => 'POST']); ?>
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?php
                            echo $form->field($seo_search, 'country_id')->widget(Select2::classname(), [
                                'data' => $country,
                                'options' => ['placeholder' => 'Выбрать страну ...', 'id' => 'select_country_id'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php
                            echo $form->field($seo_search, 'dept_city_id')->widget(Select2::classname(), [
                                'data' => $dept_city,
                                'options' => ['placeholder' => 'Выбрать город вылета ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php
                            echo $form->field($seo_search, 'city_id')->widget(Select2::classname(), [
                                'data' => (isset($city)) ? $city : [],
                                'options' => ['placeholder' => 'Выбрать курорт ...', 'id' => 'select_city_id'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="seo-h1">Заголовок</label>
                                <input type="text" id="seo-h1" class="form-control seo_input" name="Seo[h1]" value="<?php echo (isset($seo_search->seo->h1)) ? $seo_search->seo->h1 : FALSE; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="seo-keywords">Ключевые слова</label>
                                <input type="text" id="seo-keywords" class="form-control seo_input" name="Seo[keywords]" value="<?php echo (isset($seo_search->seo->keywords)) ? $seo_search->seo->keywords : FALSE; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="seo-title">Title</label>
                                <input type="text" id="seo-title" class="form-control seo_input" name="Seo[title]" value="<?php echo (isset($seo_search->seo->title)) ? $seo_search->seo->title : FALSE; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="seo-description">Описание</label>
                                <textarea type="text" id="seo-description" class="form-control seo_input" name="Seo[description]" ><?php echo (isset($seo_search->seo->description)) ? $seo_search->seo->description : FALSE; ?></textarea>
                            </div>
                            <label class="control-label" for="seo-description">SEO Текст</label>
                            <?php
                            echo TinyMce::widget([
                                'name' => 'Seo[text]',
                                'value' => (isset($seo_search->seo->seo_text)) ? $seo_search->seo->seo_text : FALSE,
                                'options' => ['rows' => 6, 'class' => 'field-tiny-mce seo_input'],
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
            </div>
            <div class="form-group">
                <a href="<?php echo Url::to(['/seoSearch/seo-search']) ?>" class="btn btn-primary">Вернуться к списку</a>
                <?php echo Html::a('Сбросить', ['/seoSearch/seo-search/'. Yii::$app->controller->action->id, 'id' => $seo_search->id], ['class' => 'btn btn-primary']); ?>
                <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>