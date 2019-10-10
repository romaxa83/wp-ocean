<?php

namespace backend\modules\dispatch\services;

use backend\modules\dispatch\entities\NewsLetter;
use backend\modules\dispatch\entities\Statistic;
use backend\modules\dispatch\forms\NewsLetterForm;
use backend\modules\dispatch\repository\DispatchJobRepository;
use backend\modules\dispatch\repository\NewsRepository;
use backend\modules\dispatch\repository\StatisticRepository;

class NewsService
{

    private $news_repository;
    private $job_repository;
    /**
     * @var StatisticRepository
     */
    private $statisticRepository;

    public function __construct(
        NewsRepository $news_rep,
        DispatchJobRepository $job_rep,
        StatisticRepository $statisticRepository
    )
    {
        $this->news_repository = $news_rep;
        $this->job_repository = $job_rep;
        $this->statisticRepository = $statisticRepository;
    }

    public function create(NewsLetterForm $form)
    {
        $news = NewsLetter::create(
            $form->subject,
            $form->body,
            $form->send
        );
        $this->news_repository->save($news);
    }

    public function edit(NewsLetterForm $form,$id)
    {
        $news = $this->news_repository->get($id);
        $news->edit(
            $form->subject,
            $form->body,
            $form->send
        );
        $this->news_repository->save($news);
    }

    public function remove($id)
    {
        $news = $this->news_repository->get($id);
        $this->news_repository->remove($news);
    }

    public function startDispatch($subscriber_ids,$letter_id)
    {
        $news = $this->news_repository->get($letter_id);
        $news->status(NewsLetter::START_SEND);
        $statistic = Statistic::create($letter_id,count($subscriber_ids));
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            $this->news_repository->save($news);
            $this->job_repository->saveAll($subscriber_ids,$letter_id);
            $this->statisticRepository->save($statistic);

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}