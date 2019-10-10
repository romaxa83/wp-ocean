<?php

namespace backend\modules\dispatch\services;

use backend\modules\dispatch\forms\NotificationsForm;
use backend\modules\dispatch\repository\NotificationsRepository;

class NotificationsService
{

    private $notifications_repository;

    public function __construct(
        NotificationsRepository $notification_rep
    )
    {
        $this->notifications_repository = $notification_rep;
    }



    public function edit($id,NotificationsForm $form) : void
    {
        $notification = $this->notifications_repository->get($id);
        $notification->edit($form->text,$form->name);
        $this->notifications_repository->save($notification);
    }

    public function changeStatus($id,$status): void
    {
        $notification = $this->notifications_repository->get($id);
        $notification->status($status);
        $this->notifications_repository->save($notification);
    }
}