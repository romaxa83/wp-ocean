<?php

namespace backend\modules\user\repository;

use backend\modules\user\entities\PassportAssignment;

class PassportAssignmentRepository
{
    public function getAllId($user_id)
    {
        return array_map(function ($item){
            return $item['passport_int_id'];
        },PassportAssignment::find()
            ->select('passport_int_id')
            ->where(['user_id' => $user_id])
            ->asArray()->all());
    }

    public function save($passports,$user_id): void
    {
        \Yii::$app->db->createCommand()->batchInsert(
            'user_passport_assignments',['user_id','passport_int_id'],
            array_map(function($item) use ($user_id) {
                return [
                    'user_id' => $user_id,
                    'passport_int_id' => $item,
                ];
            },$passports))->execute();

    }
}