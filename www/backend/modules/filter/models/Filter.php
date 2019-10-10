<?php

namespace backend\modules\filter\models;

use Yii;
use yii\db\ActiveRecord;
use backend\modules\referenceBooks\models\City;

class Filter extends ActiveRecord {

    public static function tableName() {
        return 'filter';
    }

    public function rules() {
        return [
            [['alias', 'name', 'country', 'dept_city', 'date', 'length', 'people', 'category', 'food', 'price', 'status'], 'required'],
            ['link', 'required', 'message' => 'Необходимо заполнить вкладки «Страна прибытия», «Города отправления». '],
            ['link', 'unique', 'message' => 'Поле ссылка должно быть уникальным. '],
            ['link', 'validateLink'],
            ['alias', 'match',
                'pattern' => '/^[A-Za-z0-9-]+$/',
                'message' => 'Поле может содержать только латинские буквы и цифры.'],
            ['alias', 'unique', 'message' => 'Поле тип должно быть уникальным. '],
            [['alias', 'name'], 'string', 'length' => [0, 255]],
            ['status', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false]
        ];
    }

    public function validateLink($attr) {
        $exp = explode('-', $this->link);
        $data['country'] = (isset($exp[0])) ? $exp[0] : NULL;
        $exp = explode('/', $exp[1]);
        $data['city'] = (isset($exp[1])) ? $exp[1] : NULL;
        $city = City::find()->where(['alias' => $data['city']])->with('country')->one();
        if (isset($city->country['alias']) && isset($data['country'])) {
            if ($city->country['alias'] != $data['country']) {
                $this->addError($attr, 'Город не соответстыует стране');
            }
        }
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'alias' => 'Тип',
            'link' => 'Ссылка',
            'name' => 'Имя',
            'status' => 'Статус'
        ];
    }

}
