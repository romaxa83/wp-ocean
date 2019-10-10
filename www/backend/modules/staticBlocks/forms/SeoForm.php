<?php

namespace backend\modules\staticBlocks\forms;

use yii\base\Model;
use backend\modules\staticBlocks\entities\Block;

class SeoForm extends Model
{
    public $title;
    public $alias;
    public $description;
    public $position;

    public function __construct(Block $seo = null, $config = [])
    {
        if ($seo) {
            $this->title = $seo->title;
            $this->alias = $seo->alias;
            $this->description = $seo->description;
            $this->position = $seo->position;
        }
        parent::__construct($config);

    }

    public function rules(): array
    {
        return [
            [['title','description','position','alias'], 'required'],
            [['title','description','alias'], 'string'],
            [['position'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'alias' => 'Алиас',
            'description' => 'Контент',
            'position' => 'Позиция',
        ];
    }

    public function countPosition($number)
    {
        $arr = [];
        for($i = 1;$i <= $number;$i++){
            $arr[$i] = $i;
        }
        return $arr;
    }
}