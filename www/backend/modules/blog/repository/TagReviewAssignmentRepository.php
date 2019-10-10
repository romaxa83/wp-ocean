<?php

namespace backend\modules\blog\repository;

use backend\modules\blog\entities\TagReviewAssignment;

class TagReviewAssignmentRepository
{
    public function save($tags,$hotel_review_id): void
    {
        \Yii::$app->db->createCommand()->batchInsert(
            'blog_tag_review_assign',['hotel_review_id','tag_id'],
            array_map(function($item) use ($hotel_review_id) {
                return [
                    'hotel_review_id' => $hotel_review_id,
                    'tag_id' => $item,
                ];
            },$tags))->execute();

    }

    public function delete($id): void
    {
        if($this->isTagReviewAssignment($id)){
            TagReviewAssignment::deleteAll(['hotel_review_id' => $id]);
        }
    }

    public function isTagReviewAssignment($hotel_review_id)
    {
        return TagReviewAssignment::find()->andWhere(['hotel_review_id' => $hotel_review_id])->exists();
    }
}