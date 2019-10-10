<?php

namespace console\controllers;

use backend\modules\dispatch\entities\NewsLetter;
use backend\modules\dispatch\entities\Statistic;
use backend\modules\dispatch\helpers\DateHelper;
use backend\modules\dispatch\services\StatisticService;
use yii\base\Module;
use yii\console\Controller;
use console\models\SendEmail;
use backend\modules\dispatch\entities\DispatchJob;
use yii\helpers\Console;

class DispatchController extends Controller
{
    const COUNT_EMAIL_FOR_SEND = 2;
    const WAIT_BETWEEN_SEND = 1;

    private $statistic_service;

    public function __construct($id, Module $module,
                                StatisticService $statistic_service,
                                array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->statistic_service = $statistic_service;
    }

    /**
     * Начинает информационую рассылку.
     * @package app\commands
     */
    public function actionStart($letterId)
    {
        if(DispatchJob::find()->where(['letter_id' => $letterId])->exists()){

            $result = $this->sendJob($letterId);
            if($result == 'done'){
                $static = Statistic::find()->where(['letter_id' => $letterId])->one();
                $static->end_time = (new DateHelper())->nowTimestamp();
                $static->save();

                $letter = NewsLetter::find()->where(['id' => $letterId])->one();
                $letter->status = NewsLetter::END_SEND;
                $letter->send = (new DateHelper())->nowTimestamp();
                $letter->save();
            }

            $this->stdout('DONE!!!' . PHP_EOL,Console::FG_GREEN);

        } else {

            echo "no" . PHP_EOL;
        }
    }

    private function sendJob($letterId)
    {
        $data = DispatchJob::find()->where(['letter_id' => $letterId])->limit(self::COUNT_EMAIL_FOR_SEND)->all();

        if($data){
            $delId = [];
            foreach ($data as $id => $job){

                SendEmail::send(
                    $job->subscriber->email,
                    $job->letter->subject,
                    $job->letter->body
                );
                $this->updateStatistic($letterId);
                $delId[] = $job->id;
            }

            DispatchJob::deleteAll(['in','id',$delId]);
            sleep(self::WAIT_BETWEEN_SEND);
            return self::sendJob($letterId);
        } else {
            return 'done';
        }
    }

    private function updateStatistic($letterId)
    {
        $static = Statistic::find()->where(['letter_id' => $letterId])->one();
        $static->sended += 1;
        $static->save();
    }

    public function actionBack()
    {
        DispatchJob::deleteAll();
        Statistic::deleteAll();
        $all = NewsLetter::find()->all();
        foreach ($all as $one){
            $one->status = 0;
            $one->save();
        }

        echo "done" . PHP_EOL;
    }
}