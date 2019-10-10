<?php

namespace console\controllers;

use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii2tech\crontab\CronTab;
use backend\modules\dispatch\helpers\DateHelper;
use backend\modules\dispatch\entities\NewsLetter;
use backend\modules\dispatch\entities\Subscriber;
use backend\modules\dispatch\services\NewsService;
use backend\modules\dispatch\repository\NewsRepository;
use backend\modules\dispatch\repository\StatisticRepository;
use backend\modules\dispatch\repository\DispatchJobRepository;

class DispatchCronController extends Controller
{
    private function getCronLink($letterId) {
        $root = dirname(dirname(__DIR__)) . '/yii';
        return [
            [
                'min' => '*/1',
                'command' => "php ${root} dispatch/start ${letterId};",
            ]
        ];
    }

    public function actionStart($letterId) {
        $cronTab = new CronTab();
        $cronTab->headLines = [
            'SHELL=/bin/sh',
            'PATH=/usr/bin:/usr/sbin',
        ];
        $cronTab->setJobs($this->getCronLink($letterId));
        $cronTab->apply();
    }

    public function actionStop($letterId) {
        $cronTab = new CronTab();
        $cronTab->setJobs($this->getCronLink($letterId));
        $cronTab->remove();
    }

    public function actionWatch()
    {
        if(!NewsLetter::find()->where(['status' => NewsLetter::START_SEND])->exists()){

            /** @var $letter NewsLetter */
            if($letter = NewsLetter::find()
                ->where(['status' => NewsLetter::DRAFT])
                ->andWhere(['<','send',(new DateHelper())->nowTimestamp()])
                ->orderBy(['send' => SORT_DESC])->limit(1)
                ->one())
            {
                $subscriberIds = ArrayHelper::map(Subscriber::find()->where(['status' => Subscriber::STATUS_ON])->asArray()->all(),'id','id');

                $newsService = new NewsService(new NewsRepository(),
                    new DispatchJobRepository(),
                    new StatisticRepository());
                $newsService->startDispatch($subscriberIds,$letter->id);

                $cronTab = new CronTab();
                $cronTab->headLines = [
                    'SHELL=/bin/sh',
                    'PATH=/usr/bin:/usr/sbin',
                ];
                $cronTab->setJobs($this->getCronLink($letter->letter_id));
                $cronTab->apply();
            }
        }
    }
}
