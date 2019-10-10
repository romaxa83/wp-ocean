<?php

namespace backend\modules\staticBlocks\forms;

use yii\base\Model;
use backend\modules\staticBlocks\entities\Block;

class CompanyForm extends Model
{
    public $title;
    public $alias;
    public $description;
    public $position;

    public function __construct(Block $block = null,array $config = [])
    {
        if($block){
            $this->title = $block->title;
            $this->alias = $block->alias;
            $this->description = $block->description;
            $this->position = $block->position;
        }
        parent::__construct($config);
    }

    public function rules() : array
    {
        if($this->alias == 'video'){
            return [
                [['title','description','position'], 'required'],
                [['title','description','position'], 'integer'],
            ];
        }
        return [
            [['description'], 'required'],
            [['description'], 'string'],
        ];
    }

    public function attributeLabels() : array
    {
        if($this->alias == 'video'){
            return [
                'title' => 'Картинка для превью',
                'description' => 'Видео',
                'position' => 'Позиция',
            ];
        }
        return [
            'description' => 'Текст',
        ];
    }

    public function listPosition() : array
    {
        return [
            '1' => '1',
            '2' => '2',
            '3' => '3'
        ];
    }
}