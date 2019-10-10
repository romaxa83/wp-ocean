<?php

namespace backend\modules\referenceBooks\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use backend\modules\filemanager\models\Mediafile;

class TypeTour extends ActiveRecord {

    public static function tableName() {
        return 'type_tour';
    }

    public function rules() : array
    {
        return [
            [['code', 'name', 'description', 'status', 'sync'], 'required'],
            [['media_id'],'integer'],
            [['code','name'], 'string', 'length' => [0, 255]],
            ['status', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false],
            ['sync', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false]
        ];
    }

    public function attributeLabels() : array
    {
        return [
            'id' => 'ID',
            'code' => 'Код',
            'name' => 'Название',
            'description' => 'Описание',
            'media_id' => 'Картинка',
            'status' => 'Статус',
            'sync' => 'Синхронизация'
        ];
    }

    public function getMedia() : ActiveQuery
    {
        return $this->hasOne(Mediafile::className(), ['id' => 'media_id']);
    }

}