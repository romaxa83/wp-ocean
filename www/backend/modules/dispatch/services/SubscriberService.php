<?php

namespace backend\modules\dispatch\services;

use backend\modules\dispatch\forms\NewsLetterForm;
use backend\modules\dispatch\repository\SubscriberRepository;
use backend\modules\user\repository\UserRepository;

class SubscriberService
{

    private $user_repository;
    private $subscriber_repository;

    public function __construct(
        UserRepository $user_rep,
        SubscriberRepository $subs_rep
    )
    {
        $this->user_repository = $user_rep;
        $this->subscriber_repository = $subs_rep;
    }

    public function changeStatus($id,$status): void
    {
        $subscriber = $this->subscriber_repository->get($id);
        $subscriber->status($status);

        if($user = $subscriber->user){

            $user->dispatchToggle($status);
            $this->user_repository->save($user);
        }

        $this->subscriber_repository->save($subscriber);
    }

    public function remove($id)
    {
        $news = $this->subscriber_repository->get($id);
        $this->subscriber_repository->remove($news);
    }
}