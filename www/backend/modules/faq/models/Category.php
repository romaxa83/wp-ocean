<?php

namespace backend\modules\faq\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use backend\modules\filemanager\models\Mediafile;

/**
 * @property integer $id
 * @property string $alias
 * @property string $name
 * @property integer $media_id
 * @property integer $position
 * @property integer $status
 * @property int $created
 * @property int $updated
 *
 */

class Category extends ActiveRecord
{
    const ACTIVE = 1;
    const UNACTIVE = 0;


    public static function tableName()
    {
        return 'faq_category';
    }

    public function rules()
    {
        return [
            [['alias', 'name',], 'required'],
            [['alias','name'], 'string', 'length' => [0, 100]],
            [['status','media_id'],'integer'],
            ['position','integer' , 'min' => 1],
            [['created','updated'],'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alias' => 'Алиас',
            'name' => 'Название',
            'media_id' => 'Иконка',
            'position' => 'Позиция',
            'status' => 'Статус',
            'created' => 'Создан',
            'updated' => 'Обновлен',
        ];
    }

    /**
     * возращает позицию для категории
     * @return array|int|null|ActiveRecord
     */
    public function getLastPosition()
    {
        $lastCount =  self::find()->select('position')->orderBy(['position' => SORT_DESC])->limit(1)->one();
        if($lastCount){
            return (int)$lastCount->position + 1;
        }
        return 1;
    }

    //Relation

    /**
     * @return ActiveQuery
     */
    public function getIcon(): ActiveQuery
    {
        return $this->hasOne(Mediafile::class, ['id' => 'media_id']);
    }

}