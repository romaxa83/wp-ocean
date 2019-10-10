<?php

namespace backend\tests\unit\modules\blog\entities;

use backend\modules\blog\entities\HotelReview;
use backend\modules\referenceBooks\models\Hotel;
use backend\tests\fixtures\HotelFixture;
use backend\tests\fixtures\PostReviewHotelFixture;

class HotelReviewTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /** @var $country Hotel */
    private $hotel;

    /** @var $country HotelReview */
    private $hotelReview;

    /* подгрузка данных в тестовую бд,перед тестами */
    public function _before()
    {
        $this->tester->haveFixtures([
            'hotel' => [
                'class' => HotelFixture::className(),
            ],
            'hotelReview' => [
                'class' => PostReviewHotelFixture::className()
            ]
        ]);

        $this->hotel = $this->tester->grabFixture('hotel', 1);
        $this->hotelReview = $this->tester->grabFixture('hotelReview', 1);
    }

    public function testCreate()
    {
        $date = (new \DateTimeImmutable('now'))->format('d-m-Y H:i');

        $hotelReview = HotelReview::create(
            $hotelId = $this->hotel->id,
            $title = 'Обзор на отель',
            $alias = 'obzor_na_otel',
            $description = 'Описание',
            $content = 'Текст',
            $mediaIds = '[1,2,3]',
            $status = HotelReview::ACTIVE,
            $published = $date
        );

        expect($hotelReview->hotel->name)->equals($this->hotel->name);
        expect($hotelReview->title)->equals($title);
        expect($hotelReview->alias)->equals($alias);
        expect($hotelReview->description)->equals($description);
        expect($hotelReview->content)->equals($content);
        expect($hotelReview->media_ids)->equals($mediaIds);
        expect($hotelReview->status)->equals(HotelReview::ACTIVE);
        expect($hotelReview->published_at)->notEquals($date);
        expect($hotelReview->published_at)->equals((new \DateTimeImmutable($date))->getTimestamp());
        expect($hotelReview->updated_at)->notNull();
        expect($hotelReview->created_at)->notNull();
        expect($hotelReview->views)->equals(0);
        expect($hotelReview->likes)->equals(0);
        expect($hotelReview->links)->equals(0);

        expect($hotelReview->save())->true();

    }

    public function testEditPost()
    {
        $firstHotelId = $this->hotelReview->hotel_id;
        $firstStatus = $this->hotelReview->status;

        $this->hotelReview->edit(
            $hotelId = $this->hotel->id,
            $title = 'edit',
            $alias = 'edit',
            $description ='edit_description',
            $content = 'edit_content',
            $mediaIds = '[22,44,445]',
            $status = HotelReview::INACTIVE,
            $date = (new \DateTimeImmutable('13-11-2019 11:12'))->format('12-12-2019 12:12'));

        expect($this->hotelReview->hotel_id)->notEquals($firstHotelId);
        expect($this->hotelReview->hotel_id)->equals($hotelId);
        expect($this->hotelReview->title)->equals($title);
        expect($this->hotelReview->alias)->equals($alias);
        expect($this->hotelReview->description)->equals($description);
        expect($this->hotelReview->content)->equals($content);
        expect($this->hotelReview->media_ids)->equals($mediaIds);
        expect($this->hotelReview->status)->notEquals($firstStatus);
        expect($this->hotelReview->status)->equals($status);
        expect($this->hotelReview->published_at)->notEquals($date);
        expect($this->hotelReview->published_at)->equals((new \DateTimeImmutable($date))->getTimestamp());
        expect($this->hotelReview->save())->true();
    }

    public function testChangeStatus()
    {
        $this->hotelReview->status(HotelReview::INACTIVE);

        expect($this->hotelReview->status)->equals(HotelReview::INACTIVE);
        expect($this->hotelReview->save())->true();
    }

    public function testAddView()
    {
        $view = $this->hotelReview->views;

        $this->hotelReview->addView();

        expect($this->hotelReview->views)->equals($view + 1);
        expect($this->hotelReview->save())->true();
    }
}