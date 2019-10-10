<?php

namespace backend\modules\user\services;

use backend\modules\user\entities\SmartMailing;
use backend\modules\user\forms\SmartMailingForm;
use backend\modules\user\repository\SmartMailingRepository;

class SmartMailingService
{
    private $smart_repository;

    public function __construct(SmartMailingRepository $smart_rep)
    {
        $this->smart_repository = $smart_rep;
    }

    public function create(SmartMailingForm $form,$user_id):void
    {
        $smart = SmartMailing::create(
            $user_id,
            $form->country_id,
            $form->with,
            $form->to,
            $form->persons
        );

        $this->smart_repository->save($smart);
    }

    public function remove($id):void
    {
        $smart = $this->smart_repository->get($id);
        $this->smart_repository->remove($smart);
    }
}