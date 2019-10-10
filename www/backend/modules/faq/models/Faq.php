<?php

namespace backend\modules\faq\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * @property integer $id
 * @property integer $category_id
 * @property string $question
 * @property string $answer
 * @property bool $page_faq
 * @property int $rate_faq
 * @property bool $page_vip
 * @property int $rate_vip
 * @property bool $page_exo
 * @property int $rate_exo
 * @property bool $page_hot
 * @property int $rate_hot
 * @property bool status
 * @property int $created_at
 *
 */

class Faq extends ActiveRecord
{
    const ACTIVE = 1;
    const UNACTIVE = 0;

    const FAQ_ACTIVE = 1;
    const FAQ_UNACTIVE = 0;

    const VIP_ACTIVE = 1;
    const VIP_UNACTIVE = 0;

    const EXO_ACTIVE = 1;
    const EXO_UNACTIVE = 0;

    const HOT_ACTIVE = 1;
    const HOT_UNACTIVE = 0;

    public static function tableName()
    {
        return 'faq';
    }

    public function rules() {
        return [
            [['category_id','question', 'answer',], 'required'],
            ['question', 'string', 'length' => [0, 1000]],
            ['answer', 'string'],
            [['category_id','created_at','rate_faq','rate_exo','rate_vip','rate_hot'],'integer'],
            [['status','page_faq','page_vip','page_exo','page_hot'], 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'question' => 'Вопрос',
            'answer' => 'Ответ',
            'page_faq' => 'Вывод на стр. faq',
            'rate_faq' => 'Рейтинг на стр. faq',
            'page_vip' => 'Вывод на стр. vip-tour',
            'rate_vip' => 'Рейтинг на стр. vip-tour',
            'page_exo' => 'Вывод на стр. exotic-tour',
            'rate_exo' => 'Рейтинг на стр. exotic-tour',
            'page_hot' => 'Вывод на стр. hot-tour',
            'rate_hot' => 'Рейтинг на стр. hot-tour',
            'status' => 'Статус',
            'created_at' => 'Создание',
        ];
    }

    public function getCategoryList()
    {
        return ArrayHelper::map(Category::find()
            ->select(['id','name'])
            ->where(['status' => CATEGORY::ACTIVE])
            ->asArray()->all(),'id','name');
    }

    //Relations

    public function getCategory() : ActiveQuery
    {
        return $this->hasOne(Category::class,['id' => 'category_id']);
    }

}