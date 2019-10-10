<?php

namespace backend\tests\unit\modules\blog\entities;

use backend\modules\blog\entities\Category;
use backend\modules\blog\entities\Post;
use backend\modules\filemanager\models\Mediafile;
use backend\modules\referenceBooks\models\Country;
use backend\tests\fixtures\CountryFixture;
use backend\tests\fixtures\MediaFixture;
use backend\tests\fixtures\PostCategoryFixture;
use backend\tests\fixtures\PostFixture;
use backend\tests\fixtures\user\UserFixture;
use common\models\User;

class PostTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /** @var $post Post */
    private $post;

    /** @var $category Category */
    private $category;

    /** @var $country Country */
    private $country;

    /** @var $user User */
    private $user;

    /** @var $media Mediafile */
    private $media;

    /* подгрузка данных в тестовую бд,перед тестами */
    public function _before()
    {
        $this->tester->haveFixtures([
            'post' => [
                'class' => PostFixture::className(),
            ],
            'category' => [
                'class' => PostCategoryFixture::className(),
            ],
            'country' => [
                'class' => CountryFixture::className(),
            ],
            'user' => [
                'class' => UserFixture::className(),
            ],
            'media' => [
                'class' =>MediaFixture::className(),
            ]
        ]);

        $this->post = $this->tester->grabFixture('post', 1);
        $this->category = $this->tester->grabFixture('category', 1);
        $this->country = $this->tester->grabFixture('country', 1);
        $this->user = $this->tester->grabFixture('user', 1);
        $this->media = $this->tester->grabFixture('media', 1);
    }

    public function testCreatePost()
    {
        $date = (new \DateTimeImmutable('now'))->format('d-m-Y H:i');

        $post = Post::create(
            $categoryId = $this->category->id,
            $countryId = $this->country->id,
            $authorId = $this->user->id,
            $title = 'Пост',
            $alias = 'post',
            $description = 'Описание',
            $content = 'Текст',
            $mediaId = $this->media->id,
            $status = POST::ACTIVE,
            $published = $date
        );

        expect($post->category->title)->equals('Европа');
        expect($post->country->name)->equals('Великобритания');
        expect($post->author->email)->equals('aniuta.kisel@gmail.com');
        expect($post->title)->equals('Пост');
        expect($post->alias)->equals('post');
        expect($post->description)->equals('Описание');
        expect($post->content)->equals('Текст');
        expect($post->media->filename)->equals('sofia.jpg');
        expect($post->status)->equals(Post::ACTIVE);
        expect($post->published_at)->notEquals($date);
        expect($post->published_at)->equals((new \DateTimeImmutable($date))->getTimestamp());
        expect($post->updated_at)->notNull();
        expect($post->created_at)->notNull();
        expect($post->views)->equals(0);
        expect($post->likes)->equals(0);
        expect($post->links)->equals(0);
        expect($post->comments)->equals(0);
        expect($post->position)->equals(0);
        expect($post->is_main)->equals(0);

        expect($post->save())->true();

    }

    public function testEditPost()
    {
        $this->post->edit(
            3,
            3,
            'edit',
            'edit',
            'edit_description',
            'edit_content',
            5,
            0,
            $date = (new \DateTimeImmutable('13-11-2019 11:12'))->format('12-12-2019 12:12'));
        expect($this->post->category->title)->equals('Америка');
        expect($this->post->country->name)->equals('Великобритания');
        expect($this->post->title)->equals('edit');
        expect($this->post->alias)->equals('edit');
        expect($this->post->description)->equals('edit_description');
        expect($this->post->content)->equals('edit_content');
        expect($this->post->media->filename)->equals('smith.jpg');
        expect($this->post->status)->equals(0);
        expect($this->post->published_at)->notEquals($date);
        expect($this->post->published_at)->equals((new \DateTimeImmutable($date))->getTimestamp());
        expect($this->post->save())->true();
    }

    public function testChangeStatus()
    {
        $this->post->status(0);

        expect($this->post->status)->equals(0);
        expect($this->post->save())->true();
    }

    public function testMainPage()
    {
        $this->post->mainPage(1,1);

        expect($this->post->is_main)->equals(1);
        expect($this->post->position)->equals(1);
        expect($this->post->save())->true();
    }

    public function testAddView()
    {
        $view = $this->post->views;

        $this->post->addView();

        expect($this->post->views)->equals($view + 1);
        expect($this->post->save())->true();
    }

    public function testSetPosition()
    {
        $this->post->setPosition(4);

        expect($this->post->position)->equals(4);
        expect($this->post->save())->true();
    }

//    public function testStatusDraft()
//    {
//        $date = (new \DateTimeImmutable('now'))->modify('1 day')->getTimestamp();
//
//        $this->post::setStatus(Post::ACTIVE,$date);
//
//        expect($this->post->status)->equals(Post::DRAFT);
//        expect($this->post->save())->true();
//    }

    public function testCheckPositionArray()
    {
        $temp = [];
        $temp[0] = 'Позиция';
        for ($i = 1; $i <= 50; $i++) {
            $temp[$i] = $i;
        }

        expect($this->post->getArrayPosition())->equals($temp);
    }
}