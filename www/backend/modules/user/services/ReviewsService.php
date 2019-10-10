<?php

namespace backend\modules\user\services;

use backend\modules\user\entities\Reviews;
use backend\modules\user\forms\ReviewsEditForm;
use backend\modules\user\forms\ReviewsForm;
use backend\modules\user\repository\ReviewsRepository;
use backend\modules\user\repository\UserRepository;

class ReviewsService
{

    private $reviews_repository;
    private $user_service;

    public function __construct(
        ReviewsRepository $reviews,
        UserService $user
    )
    {
        $this->reviews_repository = $reviews;
        $this->user_service = $user;
    }

    public function create(ReviewsForm $form) : void
    {
        $reviews = Reviews::create(
            $form->user_id,
            $form->hotel_id,
            $form->text,
            $form->rating,
            $form->from_date,
            $form->to_date
        );

        if($form->media_id){
            $this->user_service->setAvatar($form->user_id,$form->media_id);
        }

        $this->reviews_repository->save($reviews);
    }

    public function edit(ReviewsEditForm $form,$id)
    {
        $reviews = $this->reviews_repository->get($id);
        $reviews->edit($form->text);
        $this->reviews_repository->save($reviews);
    }

    public function changeStatus($id,$check)
    {
        $reviews = $this->reviews_repository->get($id);
        $reviews->status($check);
        $this->reviews_repository->save($reviews);
    }

    public function remove($id):void
    {
        $smart = $this->reviews_repository->get($id);
        $this->reviews_repository->remove($smart);
    }

}