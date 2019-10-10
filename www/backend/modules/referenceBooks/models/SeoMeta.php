<?php

namespace backend\modules\referenceBooks\models;

use yii\db\ActiveRecord;

class SeoMeta extends ActiveRecord {

    public static function tableName() {
        return 'seo_meta';
    }

    public function rules() {
        return [
            [['page_id', 'parent_id'], 'integer'],
            [['h1', 'title', 'keywords', 'description', 'language'], 'string', 'length' => [0, 255]]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'page_id' => 'ID страницы',
            'h1' => 'H1',
            'title' => 'Заголовок',
            'keywords' => 'Ключевые слова',
            'description' => 'Описание',
            'seo_text' => 'Текст',
            'language' => 'Язык',
            'parent_id' => 'ID родителя',
            'alias' => 'Тип'
        ];
    }

}
