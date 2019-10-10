<?php

namespace backend\modules\dispatch\services;

use backend\modules\dispatch\entities\NewsLetter;
use backend\modules\dispatch\forms\NewsLetterForm;
use backend\modules\dispatch\repository\DispatchJobRepository;
use backend\modules\dispatch\repository\NewsRepository;
use backend\modules\dispatch\repository\StatisticRepository;

class StatisticService
{

    private $statistic_repository;

    public function __construct(
        StatisticRepository $static_rep
    )
    {
        $this->statistic_repository = $static_rep;
    }

//    public function create
}