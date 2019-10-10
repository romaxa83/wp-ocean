<?php

namespace backend\modules\user\listeners;

use yii\mail\MailerInterface;
use backend\modules\dispatch\repository\NotificationsRepository;

class BaseListener
{
    protected $mailer;
    protected $notifications_repository;

    public function __construct(
        MailerInterface $mailer,
        NotificationsRepository $notifications_rep
    )
    {
        $this->mailer = $mailer;
        $this->notifications_repository = $notifications_rep;
    }
}