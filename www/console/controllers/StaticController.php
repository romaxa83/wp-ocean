<?php

namespace console\controllers;

use yii\helpers\Console;
use yii\console\Controller;
use console\models\StaticData;
use backend\modules\staticBlocks\entities\Block;

/**
 * Данные для статических блоков.
 */
class StaticController extends Controller
{

    private $array_data = ['advantage','smart','counter','company'];
    /**
     * Заполняет данные для статических блоков.
     * @package app\commands
     */
    public function actionFill()
    {
        if(Block::find()->exists()){
            $this->stdout('Таблица заполнена данными!' . PHP_EOL,Console::FG_GREEN);
            return;
        }
        //заполнение данными для статических блоков
        array_map(function($data){
            $info = (new StaticData($data))->fill();
            $this->renderInfo($info);
        },$this->array_data);
    }

    /**
     * Удаляет данные для статических блоков.
     * @package app\commands
     */
    public function actionClear()
    {
        $count = Block::find()->count();

        \Yii::$app->db->createCommand('DELETE FROM `static_block`')->execute();

        $this->stdout('|',Console::FG_RED);
        for($i = 0;$i < (int)$count;$i++){
            usleep(150000);
            $this->stdout('=',Console::FG_RED);
        }
        $this->stdout('> Удалено ('. $count .') записей ¯\_(ツ)_/¯' . PHP_EOL,Console::FG_RED);
    }

    private function renderInfo($info)
    {
        $this->stdout('Данные по ' . $info['name'] . ' добавляються ',Console::FG_GREEN);
        for($i=0;$i<$info['count'];$i++){
            usleep(150000);


        }
        sleep(1);
        $this->stdout('> ',Console::FG_GREEN);
        $this->stdout(' Добавленно ('. $info['count'] .') записей' . PHP_EOL,Console::FG_YELLOW);
    }
}