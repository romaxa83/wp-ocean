<?php

namespace console\models;

class StaticData
{
    private $nameSpace = 'console\data\Data';

    private $nameData;

    public function __construct($nameData)
    {
        $this->nameData = $nameData;
    }

    public function fill()
    {
        $pattern = [];
        $class = $this->nameSpace . ucfirst($this->nameData);
        $type = new $class ();
        foreach(get_class_methods($type) as $methods){
            $pattern[] = $type->$methods();
        }

        $this->save($pattern,$this->nameData);

        return [
            'count' => count($pattern),
            'name' => $this->nameData
        ];
    }

    private function save($pattern,$name)
    {
        \Yii::$app->db->createCommand()->batchInsert(
            '{{%static_block}}',['block','alias','title','description','status','position'],
            array_map(function($item) use ($name){
                return [
                    'block' => $name,
                    'alias' => $item['alias'],
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'status' => isset($item['status'])?$item['status']:true,
                    'position' => $item['position'],
                ];
            },$pattern)
        )->execute();
    }
}