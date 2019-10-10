<?php

namespace backend\tests\unit\modules\blog;

use backend\modules\blog\entities\Category;
use backend\modules\blog\entities\HotelReview;
use backend\modules\blog\entities\Post;
use backend\modules\blog\entities\Tag;
use backend\modules\blog\entities\TagAssignment;
use backend\modules\blog\entities\TagReviewAssignment;
use backend\modules\blog\forms\HotelReviewForm;
use backend\modules\blog\forms\PostForm;
use backend\modules\blog\repository\CategoryRepository;
use backend\modules\blog\repository\HotelReviewRepository;
use backend\modules\blog\repository\MetaRepository;
use backend\modules\blog\repository\PostRepository;
use backend\modules\blog\repository\TagAssignmentsRepository;
use backend\modules\blog\repository\TagRepository;
use backend\modules\blog\repository\TagReviewAssignmentRepository;
use backend\modules\blog\services\HotelReviewService;
use backend\modules\blog\services\PostService;
use backend\modules\filemanager\models\Mediafile;
use backend\modules\referenceBooks\models\Country;
use backend\modules\referenceBooks\models\Hotel;
use backend\modules\seo\models\SeoMeta;
use backend\tests\fixtures\CountryFixture;
use backend\tests\fixtures\HotelFixture;
use backend\tests\fixtures\MediaFixture;
use backend\tests\fixtures\PostCategoryFixture;
use backend\tests\fixtures\PostFixture;
use backend\tests\fixtures\PostReviewHotelFixture;
use backend\tests\fixtures\TagFixture;
use backend\tests\fixtures\UserFixture;
use common\models\User;

class HotelReviewServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /** @var $country Hotel */
    private $hotel;

    /** @var $country HotelReview */
    private $hotelReview;

    /**
     * @var HotelReviewService
     */
    private $hotelReviewService;


    /* подгрузка данных в тестовую бд,перед тестами */
    public function _before()
    {
        $this->tester->haveFixtures([
            'hotel' => [
                'class' => HotelFixture::className(),
            ],
            'hotelReview' => [
                'class' => PostReviewHotelFixture::className(),
            ]
        ]);

        $this->hotel = $this->tester->grabFixture('hotel', 1);
        $this->hotelReview = $this->tester->grabFixture('hotelReview', 1);

        $this->hotelReviewService = new HotelReviewService(
            new HotelReviewRepository(),
            new CategoryRepository(),
            new TagRepository(),
            new TagReviewAssignmentRepository(),
            new MetaRepository()
        );
    }

    public function _after()
    {
        SeoMeta::deleteAll();
        Tag::deleteAll();
        TagReviewAssignment::deleteAll();
    }

    public function testCreate()
    {
        $date = (new \DateTimeImmutable('now'))->format('d-m-Y H:i');
        $data = [
            'HotelReviewForm' => [
                'title' => 'Обзор отеля',
                'alias' => 'obzor_otel',
                'hotel_id' => $this->hotel->id,
                'published_at' => $date,
                'media_ids' => '[11,23,54]',
                'hide_media' => '[11,23,54]',
                'content' => 'Текст обзора отеля',
                'description' => 'Описание обзора отеля',
                'status' => HotelReview::ACTIVE
            ],
            'TagsReviewForm' => [
                'existing' => [
                    '0' => 'plaza',
                    '1' => 'rer',
                    '2' => 'oops'
                ]
            ],
            'MetaForm' => [
                'h1' => 'seo_h1',
                'title' => 'seo_title',
                'keywords' => 'seo_keywords',
                'description' => 'seo_description',
                'seo_text' => 'seo_text',
            ]
        ];

        $form = new HotelReviewForm();
        $this->assertTrue($form->load($data));
        $this->assertTrue($form->validate());

        $hotelReview = $this->hotelReviewService->create($form);

        expect($hotelReview->save())->true();
        //проверка seo
        expect($hotelReview->seo->page_id)->equals($hotelReview->id);
        expect($hotelReview->seo->alias)->equals('review_hotel');
        expect($hotelReview->seo->h1)->equals($data['MetaForm']['h1']);
        expect($hotelReview->seo->title)->equals($data['MetaForm']['title']);
        expect($hotelReview->seo->keywords)->equals($data['MetaForm']['keywords']);
        expect($hotelReview->seo->description)->equals($data['MetaForm']['description']);
        expect($hotelReview->seo->seo_text)->equals($data['MetaForm']['seo_text']);
        expect($hotelReview->seo->save())->true();
        // проверка тегов
        expect($hotelReview->tags[0]['title'])->equals($data['TagsReviewForm']['existing'][0]);
        expect($hotelReview->tags[1]['title'])->equals($data['TagsReviewForm']['existing'][1]);
        expect($hotelReview->tags[2]['title'])->equals($data['TagsReviewForm']['existing'][2]);
    }

    public function testEdit()
    {
        $oldHotelReview = clone $this->hotelReview;
        $date = (new \DateTimeImmutable('now'))->format('d-m-Y H:i');
        $data = [
            'HotelReviewForm' => [
                'title' => 'Edit',
                'alias' => 'edit',
                'hotel_id' => 2,
                'published_at' => $date,
                'media_id' => 2,
                'content' => 'edit',
                'description' => 'edit',
                'status' => HotelReview::ACTIVE
            ],
            'TagsReviewForm' => [
                'existing' => [
                    '0' => 'edit_1',
                    '1' => 'edit_2'
                ]
            ],
            'MetaForm' => [
                'h1' => 'edit_seo_h1',
                'title' => 'edit_title',
                'keywords' => 'edit_keywords',
                'description' => 'edit_description',
                'seo_text' => 'edit_seo_text',
            ]
        ];

        $form = new HotelReviewForm();
        $this->assertTrue($form->load($data));
        $this->assertTrue($form->validate());

        $this->hotelReviewService->edit($this->hotelReview->id,$form);
        expect($this->hotelReview->save())->true();

        expect($this->hotelReview->seo->save())->true();
//        dd($this->hotelReview->seo);
        // проверка тегов
        expect($this->hotelReview->tags[0]['title'])->equals($data['TagsReviewForm']['existing'][0]);
        expect($this->hotelReview->tags[1]['title'])->equals($data['TagsReviewForm']['existing'][1]);
    }
}
