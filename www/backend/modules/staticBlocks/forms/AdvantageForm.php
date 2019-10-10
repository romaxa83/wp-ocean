<?php

namespace backend\modules\staticBlocks\forms;

use yii\base\Model;
use backend\modules\staticBlocks\entities\Block;

class AdvantageForm extends Model
{
    public $title;
    public $alias;
    public $description;
    public $position;

    public function __construct(Block $block = null,array $config = [])
    {
        if($block){
            $this->title = $block->title;
            $this->description = $block->description;
            $this->position = $block->position;
        }
        parent::__construct($config);
    }

    public function rules() : array
    {
        return [
            [['title','description','position'], 'required'],
            [['title','alias','description'], 'string'],
            [['position'], 'integer']
        ];
    }

    public function attributeLabels() : array
    {
        return [
            'title' => 'Иконка',
            'description' => 'Описание',
            'position' => 'Позиция',
        ];
    }

    public function listPosition() : array
    {
        return [
          '1' => '1',
          '2' => '2',
          '3' => '3',
          '4' => '4'
        ];
    }
}