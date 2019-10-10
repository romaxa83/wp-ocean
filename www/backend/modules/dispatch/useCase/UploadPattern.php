<?php

namespace backend\modules\dispatch\useCase;

use backend\modules\dispatch\entities\Notifications;
use yii\helpers\ArrayHelper;

class UploadPattern
{
    public function start()
    {
        $data = require __DIR__ . '/../data/Pattern.php';
        $patterns = $this->getNewPattern($data);
        $this->save($patterns);

        return count($patterns);
    }

    public function remove()
    {
        if(Notifications::find()->exists()){
            Notifications::deleteAll();

            return 'Все шаблоны удалены.';
        }
        return 'Нет шаблонов для удаления.';
    }

    private function getNewPattern(array $patterns)
    {
        if($notification = Notifications::find()->asArray()->all()){
            $notification = ArrayHelper::map($notification,'alias','alias');
            $new_pattern = [];
            foreach ($patterns as $key => $item) {
                if(!array_key_exists($key,$notification)){
                    $new_pattern[] = $item;
                }
            }
            return $new_pattern;
        }
        return $patterns;
    }

    private function save(array $array)
    {
        \Yii::$app->db->createCommand()->batchInsert(
            '{{%dispatch_notifications}}',['name','alias','text','variables','created_at','updated_at'],
            array_map(function($item){
                return [
                    'name' => $item['name'],
                    'alias' => $item['alias'],
                    'text' => $item['text'],
                    'variables' => $item['var'],
                    'created_at' => time(),
                    'updated_at' => time(),

                ];
            },$array)
        )->execute();
    }
}