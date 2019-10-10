<?php

namespace backend\modules\referenceBooks\models;

use yii\db\ActiveRecord;
use backend\modules\referenceBooks\models\Hotel;

class Rating extends ActiveRecord {

    public static function tableName() {
        return 'rating';
    }

    public function rules() {
        return [
            [['hotel_id', 'rid', 'name', 'vote', 'count', 'status', 'sync'], 'required'],
            [['rid', 'hotel_id', 'count'], 'integer'],
            ['vote', 'float'],
            ['name', 'string', 'length' => [0, 255]],
            [['status', 'sync'], 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'hotel_id' => 'Отель',
            'rid' => 'ID рейтинг (API)',
            'name' => 'Название',
            'vote' => 'Оценка',
            'count' => 'Кол-во',
            'status' => 'Статус',
            'sync' => 'Синхронизация'
        ];
    }

}
