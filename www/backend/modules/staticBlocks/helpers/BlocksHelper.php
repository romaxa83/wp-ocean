<?php

namespace backend\modules\staticBlocks\helpers;

use backend\modules\staticBlocks\entities\Block;
use yii\helpers\Html;
use yii\helpers\Url;

class BlocksHelper
{
    private $blocks;

    public function __construct($blocks = null)
    {
        if($blocks != null){
            $this->blocks = $blocks;
        }
    }

    //рендерит кнопку вкл/выкл блока
    public function btnToggleBlock($name_block)
    {
        return Html::a($this->isBlocks()?'Выкл. блок':'Вкл. блок',
            Url::toRoute(['/staticBlocks/static-blocks/toggle-block']),
            [
                'class' => $this->isBlocks()?'btn btn-danger':'btn btn-primary',
                'data-confirm' => $this->isBlocks()
                    ? 'Вы уверены, что хотите отключить данный блок?'
                    : 'Вы уверены, что хотите включить данный блок?',
                'data-method' => 'POST',
                'data-params' => [
                    'block' => $name_block,
                    'status_block' => $this->isBlocks() ? false : true,
                ]
            ]);
    }

    public function renderVideo(Block $model):string
    {
        return '<video width="300" height="200" controls="controls">
                  <source src="'. Url::base() . $model->video->url .'">
                </video>';
    }

    public function renderImage(Block $model):string
    {
        return '<img src="'. Url::base() . $model->preview->url .'" width="300" height="200">';
    }

    public function checkToggleSection($model):string
    {
        $options = [
            'id' => 'cp_'. $model->id .'_' . $model->block,
            'class' => 'tgl tgl-light publish-toggle status-toggle change_status',
            'data-id' => $model->id,
            'data-block' => $model->block,
            'data-url' => \yii\helpers\Url::to(['/staticBlocks/static-blocks/toggle-status'])
        ];

        return Html::beginTag('div').
            Html::checkbox($model->block, $model->status, $options).
            Html::label('', 'cp_' . $model->id .'_' . $model->block, ['class' => 'tgl-btn']).
            Html::endTag('div');
    }

    private function isBlocks()
    {
        return isset($this->blocks) && !empty($this->blocks);
    }
}