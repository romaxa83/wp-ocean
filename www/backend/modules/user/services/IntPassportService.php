<?php

namespace backend\modules\user\services;

use backend\modules\user\entities\IntPassport;
use backend\modules\user\forms\IntPassportForm;
use backend\modules\user\repository\IntPassportRepository;
use backend\modules\user\repository\PassportAssignmentRepository;

class IntPassportService
{

    private $passport_repository;
    private $passport_assignment_repository;

    public function __construct(
        IntPassportRepository $passport,
        PassportAssignmentRepository $passport_ass
    )
    {
        $this->passport_repository = $passport;
        $this->passport_assignment_repository = $passport_ass;
    }

    public function create($form,$user_id)
    {

        $passport_ids = [];

        foreach ($form['IntPassportForm'] as $one){

            $passport = IntPassport::create(
                $one['first_name'],
                $one['last_name'],
                $one['sex'],
                $one['birthday'],
                $one['series'],
                $one['number'],
                $one['issued'],
                $one['issued_date'],
                $one['expired_date'],
                isVerifyIntPassport()?$one['media_id']:null
            );

            $this->passport_repository->save($passport);
            $passport_ids[] = $passport->id;
        }

        $this->passport_assignment_repository->save($passport_ids,$user_id);
    }

    public function edit(IntPassportForm $form,$passport_id) : void
    {
        $passport = $this->passport_repository->get($passport_id);
        $passport->edit(
            $form->first_name,
            $form->last_name,
            $form->sex,
            $form->birthday,
            $form->series,
            $form->number,
            $form->issued,
            $form->issued_date,
            $form->expired_date
        );
        $this->passport_repository->save($passport);
    }

    public function verify($passport_id,$verify)
    {
        $passport = $this->passport_repository->get($passport_id);
        $status = $verify == 0 ? true : false;
        $passport->verify($status);
        $this->passport_repository->save($passport);
    }

    public function rejectScan($passport_id) : IntPassport
    {
        $passport = $this->passport_repository->get($passport_id);
        $passport->rejectScan();
        $this->passport_repository->save($passport);

        return $passport;
    }

    public function remove($passport_id)
    {
        $passport = $this->passport_repository->get($passport_id);
        $this->passport_repository->remove($passport);
    }
}