<?php

namespace backend\modules\user\services;

use backend\modules\user\entities\Passport;
use backend\modules\user\forms\PassportForm;
use backend\modules\user\repository\PassportRepository;

class PassportService
{

    private $passport_repository;

    public function __construct(PassportRepository $passport)
    {
        $this->passport_repository = $passport;
    }

    public function editPassport(PassportForm $form,$id):void
    {
        $passport = $this->passport_repository->get($id);
        $passport->edit(
            $form->first_name,
            $form->last_name,
            $form->patronymic,
            $this->isData($form->birthday),
            $form->series,
            $form->number,
            $form->issued,
            $this->isData($form->issued_date),
            isVerifyPassport()?$form->media_id:null
        );

        $this->passport_repository->save($passport);
    }

    public function verify($passport_id,$verify) : Passport
    {
        $passport = $this->passport_repository->get($passport_id);
        $status = $verify == 0 ? true : false;
        $passport->verify($status);
        $this->passport_repository->save($passport);

        return $passport;
    }

    public function rejectScan($passport_id) : Passport
    {
        $passport = $this->passport_repository->get($passport_id);
        $passport->rejectScan();
        $this->passport_repository->save($passport);

        return $passport;
    }

    //проверяет данные
    private function isData($data)
    {
        return (isset($data) && !(empty($data)) && $data !== null)?$data:0;
    }
}