<?php

namespace backend\modules\blog\services;

use backend\modules\blog\helpers\MessageHelper;
use backend\modules\referenceBooks\models\HotelReview as Review;
use backend\modules\blog\entities\Tag;
use backend\modules\blog\entities\Meta;
use backend\modules\blog\forms\PostForm;
use backend\modules\blog\entities\HotelReview;
use backend\modules\blog\forms\HotelReviewForm;
use backend\modules\blog\helpers\ImageHelper;
use backend\modules\blog\repository\TagRepository;
use backend\modules\blog\repository\MetaRepository;
use backend\modules\blog\repository\CategoryRepository;
use backend\modules\blog\repository\HotelReviewRepository;
use backend\modules\blog\repository\TagAssignmentsRepository;
use backend\modules\blog\repository\TagReviewAssignmentRepository;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use yii\db\Exception;
use yii\helpers\Html;

class HotelReviewService
{
    private $category_repository;
    private $tag_repository;
    private $tag_rel_repository;
    private $meta_repository;
    /**
     * @var HotelReviewRepository
     */
    private $hotelReviewRepository;

    public function __construct(HotelReviewRepository $hotelReviewRepository,
                                CategoryRepository $categories,
                                TagRepository $tags,
                                TagReviewAssignmentRepository $tags_rel,
                                MetaRepository $meta)
    {
        $this->category_repository = $categories;
        $this->tag_repository = $tags;
        $this->tag_rel_repository = $tags_rel;
        $this->meta_repository = $meta;
        $this->hotelReviewRepository = $hotelReviewRepository;

        $this->message = new MessageHelper();
    }

    public function create(HotelReviewForm $form) : HotelReview
    {
        $hotelReview = HotelReview::create(
            $form->hotel_id,
            $form->title,
            $form->alias,
            $form->description,
            $form->content,
            $form->hide_media,
            $form->status,
            $form->published_at);

        //обернуто в транзакцию
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->hotelReviewRepository->save($hotelReview);

            $this->saveTags($form->tagsReview->existing,$hotelReview->id);

            $this->meta_repository->save($meta = $this->createSeo($form->meta,$hotelReview->id,'review_hotel'));

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $hotelReview;
    }

    public function edit($id, HotelReviewForm $form): HotelReview
    {
        $post = $this->hotelReviewRepository->get($id);
        $seo = $this->meta_repository->get($id,'review_hotel');
        $post->edit(
            $form->hotel_id,
            $form->title,
            $form->alias,
            $form->description,
            $form->content,
            ImageHelper::parseMediaIds($form->hide_media) == ''?$form->media_ids:$form->hide_media,
            $form->status,
            $form->published_at);

        $seo->edit(
            $form->meta->h1,
            $form->meta->title,
            $form->meta->keywords,
            $form->meta->description,
            $form->meta->seo_text);

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->hotelReviewRepository->save($post);

            $this->tag_rel_repository->delete($id);

            $this->saveTags($form->tagsReview->existing,$post->id);

            $this->meta_repository->save($seo);

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $post;
    }

    public function changeStatus($id, $status): void
    {
        $hotelReview = $this->hotelReviewRepository->get($id);
        $hotelReview->status($status);
        $this->hotelReviewRepository->save($hotelReview);
    }

    public function removeMediaId($post_data) : void
    {
        $hotelReview = $this->hotelReviewRepository->get($post_data['hotel_review_id']);
        $hotelReview->removeMediaId($post_data['media_id']);
        $this->hotelReviewRepository->save($hotelReview);
    }

    public function remove($id) : void
    {
        $hotelReview = $this->hotelReviewRepository->get($id);
        $this->hotelReviewRepository->delete($hotelReview);
        $this->tag_rel_repository->delete($id);
        $this->meta_repository->delete($id,'hotel_review');
    }

    public function addView($id):HotelReview
    {
        $hotelReview = $this->hotelReviewRepository->get($id);
        $hotelReview->addView();
        $this->hotelReviewRepository->save($hotelReview);

        return $hotelReview;
    }

    public function addImgToGallery($post_data)
    {
        if(array_key_exists('url',$post_data) && !empty($post_data['url'])){
            $hotelReviewId = explode('=',parse_url($post_data['url'])['query'])[1];
            $hotelReview = $this->hotelReviewRepository->get($hotelReviewId);

            $exist_media = ImageHelper::parseMediaIds($hotelReview->media_ids);
            if(in_array($post_data['id'],$exist_media)){
                return $this->message->errorHotelReview(2);
            }
            array_push($exist_media,$post_data['id']);

            $hotelReview->addMedia($exist_media);
            $this->hotelReviewRepository->save($hotelReview);

            return $this->message->successPost(1,'str','Данное видео добавленно в галерею');
        }

        return $this->message->errorHotelReview(1);
    }

    public function addIdBySlug($slug)
    {
        return $this->hotelReviewRepository->getIdBySlug($slug);
    }


    /**
     * @param $tags_existing
     * @param $post_id
     */
    private function saveTags($tags_existing, $post_id): void
    {
        $tags = [];
        foreach ($tags_existing as $tag_name) {
            $tag = $this->tag_repository->findByName($tag_name);
            if(!$tag){
                $tag = Tag::create($tag_name,Tag::generateAlias($tag_name));
                $this->tag_repository->save($tag);
            }
            $tags [] = $tag->id;
        }

        $this->tag_rel_repository->save($tags,$post_id);
    }

    /**
     * @param $form
     * @param $post_id
     * @return Meta
     */
    private function createSeo($form, $hotel_review_id,$alias)
    {
        return Meta::create(
            $hotel_review_id,
            $form->h1,
            $form->title,
            $form->keywords,
            $form->description,
            $form->seo_text,
            $alias);
    }
}