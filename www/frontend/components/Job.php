<?php

namespace frontend\components;

use yii\base\Object;
use yii\queue\Job AS iJobs;

class Job extends Object implements iJobs {

    public $post;

    public function execute($queue) {
        dd($this->post);
    }

}
