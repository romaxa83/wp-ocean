<?php

namespace backend\modules\user\forms;

use common\models\User;
use yii\base\Model;

class UserFotoForm extends Model
{

    public $media_id;

    public function __construct(User $user = null,array $config = [])
    {
        if($user){
            $this->media_id = $user->media_id;
        }
        parent::__construct($config);
    }

    public function rules() {
        return [
            [['media_id'], 'number'],
            [['media_id'], 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'media_id' => 'Фото',
        ];
    }
}