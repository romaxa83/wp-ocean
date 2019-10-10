<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii2tech\crontab\CronTab;

class CronController extends Controller {

    private function getCronLink() {
        $root = dirname(dirname(__DIR__)) . '/yii';
        return [
//            [
//                'min' => '*/2',
//                'command' => "php ${root} api0/country; php ${root} api0/city; php ${root} api0/type-transport; php ${root} api0/type-tour; php ${root} api0/type-hotel; php ${root} api0/type-food; php ${root} api0/dept-city; php ${root} api0/operator; php ${root} api0/hotel; php ${root} api0/type-service;",
//            ],
            [
                'min' => '*/1',
                'command' => "php ${root} post/publish;",
            ],
            [
                'min' => '*/1',
                'command' => "php ${root} hotel-review/publish;",
            ],
//            [
//                'min' => '*/5',
//                'command' => "php ${root} review/parse;",
//            ],
//            [
//                'min' => '*/1',
//                'command' => "php ${root} dispatch-cron/watch;",
//            ],
//            [
//                'min' => '*/3',
//                'command' => "php ${root} check-hotel-img/parse;",
//            ],
            [
                'min' => '*/7',
                'command' => "php ${root} check-relevance-of-tours/check;",
            ],
//            [
//                'min' => '*/5',
//                'command' => "php ${root} api0/hotel-info;",
//            ],
            [
                'min' => '*/60',
                'command' => "php ${root} yii sitemap;",
            ],
        ];
    }

    public function actionStart() {
        $cronTab = new CronTab();
        $cronTab->headLines = [
            'SHELL=/bin/sh',
            'PATH=/usr/bin:/usr/sbin',
        ];
        $cronTab->setJobs($this->getCronLink());
        $cronTab->apply();
    }

    public function actionStop() {
        $cronTab = new CronTab();
        $cronTab->setJobs($this->getCronLink());
        $cronTab->remove();
    }

}
