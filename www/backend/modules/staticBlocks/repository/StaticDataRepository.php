<?php

namespace backend\modules\staticBlocks\repository;

use backend\modules\staticBlocks\entities\Block;

class StaticDataRepository
{
    public function get($id): Block
    {
        if (!$block = Block::findOne($id)) {
            throw new \DomainException('Данные отсутствуют.');
        }
        return $block;
    }

    public function getByPosition($position,$block)
    {
        return Block::find()->where(['block' => $block])->andWhere(['position' => $position])->one();
    }

    public function getLastPosition($block)
    {
        if($pos = Block::find()->where(['block' => $block])->limit(1)->orderBy(['position' => SORT_DESC])->one()){
            return $pos->position;
        }
        return 0;
    }

    public function getCount($block)
    {
        return Block::find()->where(['block' => $block])->count();
    }

    public function save(Block $data)
    {
        if (!$data->save()) {
            throw new \RuntimeException('Ошибка сохранения статических данных.');
        }
    }

    public function saveStatusBlock($block_name,$status)
    {
        \Yii::$app->db->createCommand('UPDATE static_block SET status_block='.$status.' WHERE block="'.$block_name.'"')->execute();
    }

    public function getData($block)
    {
        return Block::find()
            ->where(['block' => $block])
            ->andWhere(['status_block' => Block::STATUS_BLOCK_ACTIVE])
            ->andWhere(['status' => Block::STATUS_ACTIVE])
            ->orderBy(['position' => SORT_ASC])
            ->all();
    }
}