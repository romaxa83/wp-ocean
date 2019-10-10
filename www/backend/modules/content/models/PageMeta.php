<?php

namespace backend\modules\content\models;

use Yii;

/**
 * This is the model class for table "page_meta".
 *
 * @property int $id
 * @property int $page_id
 * @property string $title
 * @property string $description
 * @property string $keywords
 *
 * @property Page $page
 */
class PageMeta extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'page_meta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['title', 'description'], 'required'],
            [['page_id'], 'integer'],
            [['title', 'description', 'keywords'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'title' => 'Title',
            'description' => 'Description',
            'keywords' => 'Keywords',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage() {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

}
