<?php

namespace backend\modules\vacancyNotification\models;

use himiklab\yii2\recaptcha\ReCaptchaValidator3;
use Yii;

/**
 * This is the model class for table "vacancy_notification".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $vacancy
 * @property string $cv_path
 * @property string $comment
 * @property int $status
 * @property string $created_at
 */
class VacancyNotification extends \yii\db\ActiveRecord
{
    const NEW = 0;
    const ARCHIVE = 1;
    const CANCELED = 2;

    const SCENARIO_WITHOUT_CAPTCHA = 'noCaptcha';

    public $reCaptcha;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacancy_notification';
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['name', 'phone', 'vacancy', 'cv_path', 'comment', 'created_at', 'reCaptcha'],
            self::SCENARIO_WITHOUT_CAPTCHA => ['name', 'phone', 'vacancy', 'cv_path', 'comment', 'created_at'],
        ];
    }

    public static function getCount()
    {
        return self::find()->where(['status' => self::NEW])->count();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'vacancy', 'cv_path'], 'required'],
            [['comment'], 'string'],
            [['created_at'], 'safe'],
            [['name', 'phone', 'vacancy', 'cv_path'], 'string', 'max' => 255],
            [['reCaptcha'], ReCaptchaValidator3::className(), 'secret' => Yii::$app->params['reCaptcha']['secret'], 'threshold' => 0.5, 'action' => 'vacancy_notification'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'vacancy' => 'Вакансия',
            'cv_path' => 'Резюме',
            'comment' => 'Комментарий',
            'status' => 'Статус',
            'created_at' => 'Created At',
        ];
    }
}