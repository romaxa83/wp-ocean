<?php

namespace backend\widgets\langwidget;

use backend\models\Settings;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use backend\widgets\langwidget\LangWidgetAsset;
use yii\helpers\StringHelper;

class LangWidget extends Widget {

    public $model;
    public $fields;

    public function init() {
        parent::init();
        Yii::setAlias('@langwidget-assets', __DIR__ . '/assets');
        LangWidgetAsset::register(Yii::$app->view);
    }

    public function run() {
        $class = StringHelper::basename($this->model->className());
        $this->model->languageData = $this->getLanguageData($this->model->languageData);
        //$this->model->languageData = ['Language' => $this->model->languageData];
        return $this->render('langs-tab', [
            'class' => $class,
            'model' => $this->model,
            'fields' => $this->fields,
            'languages' => self::getActiveLanguageData(['lang', 'alias'])
        ]);
    }

    private function getLanguageData($data) {
        if ($data === NULL)
            $data = [];
        $class = StringHelper::basename($this->model->className());
        $data = ($post = Yii::$app->request->post()) ? $post[$class]['Language'] : ArrayHelper::index($data, 'language');
        return ['Language' => $data];
    }

    static function getActiveLanguageData($param) {
        $data = [];
        $languages = Settings::find()->select('body')->where(['name' => 'set_language'])->asArray()->one();
        if ($languages != NULL) {
            $body = unserialize($languages['body']);
            foreach ($body as $k => $v) {
                if ($v['status'] == 1) {
                    foreach ($param as $item) {
                        $data[$k][$item] = $v[$item];
                    }
                }
            }
        }
        return $data;
    }

    static function validate($model) {
        $rules = $model->rules();
        $class = strtolower(StringHelper::basename($model->className()));
        $data = Yii::$app->request->post()[StringHelper::basename($model->className())]['Language'];
        foreach ($data as $k => $v) {
            foreach ($v as $k0 => $v0) {
                foreach ($rules as $rule) {
                    $action = $rule[1];
                    $attr = $class . '-' . $k0 . '-' . $k;
                    if (is_array($rule[0]) && (array_search($k0, $rule[0]) !== FALSE))
                        if (method_exists(self::className(), $action))
                            self::$action($model, $attr, $v0, $k0);
                    if (!is_array($rule[0]) && ($rule[0] == $k0))
                        if (method_exists(self::className(), $action))
                            self::$action($model, $attr, $v0, $k0);
                }
            }
        }
        return !$model->hasErrors();
    }

    private static function number($model, $attr, $value, $name) {
        if (!is_numeric($value)) {
            $name = $model->getAttributeLabel($name);
            $model->addError($attr, 'Значение «' . $name . '» должно быть числом.');
        }
    }

    private static function required($model, $attr, $value, $name) {
        if (empty($value)) {
            $name = $model->getAttributeLabel($name);
            $model->addError($attr, 'Необходимо заполнить «' . $name . '»');
        }
    }

    private static function unique($model, $attr, $value, $name) {
        $class_name = $model->className();
        $data = $class_name::find()->where(['alias' => $value])->one();
        if (isset($data)) {
            $name = $model->getAttributeLabel($name);
            $model->addError($attr, 'Поле «' . $name . '» должно быть уникальным');
        }
    }

}
