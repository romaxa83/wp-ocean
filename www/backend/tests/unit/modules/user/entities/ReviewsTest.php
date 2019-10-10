<?php

namespace backend\tests\unit\modules\user\entities;

use common\models\User;
use backend\tests\fixtures\HotelFixture;
use backend\modules\user\entities\Reviews;
use backend\modules\user\helpers\DateFormat;
use backend\tests\fixtures\user\UserFixture;
use backend\tests\fixtures\user\ReviewFixture;
use backend\modules\referenceBooks\models\Hotel;

class ReviewsTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /**
     * @var $hotel Hotel
     */
    private $hotel;

    /**
     * @var $user User
     */
    private $user;

    /**
     * @var $review Reviews
     */
    private $review;

    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
            ],
            'hotel' => [
                'class' => HotelFixture::className()
            ],
            'review' => [
                'class' => ReviewFixture::className()
            ]
        ]);

        $this->user = $this->tester->grabFixture('user',3);

        $this->hotel = $this->tester->grabFixture('hotel', 0);

        $this->review = $this->tester->grabFixture('review', 0);
    }

    public function testCreateSuccess()
    {
        $review = Reviews::create(
            $this->user->id,
            $this->hotel->id,
            $text = 'test',
            $rating = 3,
            $from_date = '05/12/2000',
            $to_date = '15/12/2000'
        );

        expect($review->user->email)->equals($this->user->email);
        expect($review->hotel->name)->equals($this->hotel->name);
        expect($review->passport->first_name)->equals($this->user->passport->first_name);
        expect($review->from_date)->equals(DateFormat::convertTimestamp($from_date));
        expect($review->from_date)->notEquals($from_date);
        expect($review->to_date)->equals(DateFormat::convertTimestamp($to_date));
        expect($review->to_date)->notEquals($to_date);
        expect($review->text)->equals($text);
        expect($review->rating)->equals($rating);
        expect($review->status)->equals(Reviews::STATUS_DRAFT);
        expect($review->save())->true();
    }

    public function testEdit()
    {
        $oldReview = clone $this->review;
        $this->review->edit($text = 'some_edit_text');

        expect($this->review->text)->notEquals($oldReview);
        expect($this->review->text)->equals($text);
        expect($this->review->updated_at)->notEquals($oldReview->updated_at);
        expect($this->review->save())->true();
    }

    public function testStatus()
    {
        expect($this->review->status)->equals(Reviews::STATUS_ACTIVE);
        $this->review->status(Reviews::STATUS_DRAFT);
        expect($this->review->status)->equals(Reviews::STATUS_DRAFT);
        expect($this->review->save())->true();
    }
}