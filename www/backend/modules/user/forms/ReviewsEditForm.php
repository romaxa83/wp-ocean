<?php

namespace backend\modules\user\forms;

use yii\base\Model;
use backend\modules\user\entities\Reviews;

class ReviewsEditForm extends Model
{
    public $text;

    public function __construct(Reviews $reviews = null, $config = [])
    {
        if($reviews){
            $this->text = $reviews->text;
        }
        parent::__construct($config);
    }

    public function rules() : array
    {
        return [
            [['text'],'required'],
            [['text'],'string'],
        ];
    }
}