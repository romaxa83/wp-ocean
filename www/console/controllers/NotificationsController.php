<?php

namespace console\controllers;

use yii\helpers\Console;
use yii\console\Controller;
use console\models\TypePattern;
use backend\modules\dispatch\entities\Notifications;

class NotificationsController extends Controller
{

    /**
     * Заполняет стандартными шаблонами.
     * @package app\commands
     */
    public function actionFill()
    {
        if(Notifications::find()->exists()){
            $this->stdout('Таблица заполнена шаблонами!' . PHP_EOL,Console::FG_GREEN);
            return;
        }

        $pattern = [];
        $type = new TypePattern();
        foreach(get_class_methods($type) as $methods){
            $pattern[] = $type->$methods();
            $this->stdout('Шаблон "'. ($type->$methods())['name'] .'" добавлен' . PHP_EOL,Console::FG_YELLOW);
        }

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
            },$pattern)
        )->execute();

        $this->stdout('Done!' . PHP_EOL,Console::FG_GREEN);
    }

    /**
     * Удаляет все шаблоны.
     * @package app\commands
     */
    public function actionClear()
    {
        \Yii::$app->db->createCommand('DELETE FROM `dispatch_notifications`')->execute();
        $this->stdout('Корзиночка пуста ¯\_(ツ)_/¯' . PHP_EOL,Console::FG_RED);
    }
}