<?php

namespace backend\tests\unit\modules\blog;

use common\models\User;
use backend\modules\blog\entities\Tag;
use backend\tests\fixtures\TagFixture;
use backend\tests\fixtures\PostFixture;
use backend\modules\blog\entities\Post;
use backend\modules\seo\models\SeoMeta;
use backend\tests\fixtures\MediaFixture;
use backend\modules\blog\forms\PostForm;
use backend\tests\fixtures\CountryFixture;
use backend\modules\blog\entities\Category;
use backend\tests\fixtures\user\UserFixture;
use backend\modules\blog\services\PostService;
use backend\tests\fixtures\PostCategoryFixture;
use backend\modules\blog\entities\TagAssignment;
use backend\modules\filemanager\models\Mediafile;
use backend\modules\blog\repository\TagRepository;
use backend\modules\referenceBooks\models\Country;
use backend\modules\blog\repository\MetaRepository;
use backend\modules\blog\repository\PostRepository;
use backend\modules\blog\repository\CategoryRepository;
use backend\modules\blog\repository\TagAssignmentsRepository;

class PostServiceTest extends \Codeception\Test\Unit
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

    /** @var $tag Tag */
    private $tag;
    /**
     * @var PostService
     */
    private $postService;


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
                'class' => MediaFixture::className(),
            ],
            'tag' => [
                'class' => TagFixture::className(),
            ]
        ]);

        $this->post = $this->tester->grabFixture('post', 1);
        $this->category = $this->tester->grabFixture('category', 1);
        $this->country = $this->tester->grabFixture('country', 1);
        $this->user = $this->tester->grabFixture('user', 1);
        $this->media = $this->tester->grabFixture('media', 1);
        $this->tag = $this->tester->grabFixture('tag', 1);

        $this->postService = new PostService(
            new PostRepository(new CategoryRepository(),new TagRepository()),
            new CategoryRepository(),
            new TagRepository(),
            new TagAssignmentsRepository(),
            new MetaRepository()
        );
    }

    public function _after()
    {
        SeoMeta::deleteAll();
        Tag::deleteAll();
        TagAssignment::deleteAll();
    }

    public function testCreate()
    {
        $date = (new \DateTimeImmutable('now'))->format('d-m-Y H:i');
        $data = [
            'PostForm' => [
                'title' => 'Пост',
                'alias' => 'post',
                'category_id' => $this->category->id,
                'country_id' => $this->country->id,
                'published_at' => $date,
                'media_id' => $this->media->id,
                'content' => 'Текст',
                'description' => 'Описание',
                'status' => POST::ACTIVE
            ],
            'TagsForm' => [
                'existing' => [
                    '0' => 'first',
                    '1' => 'second'
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

        $form = new PostForm();
        $this->assertTrue($form->load($data));
        $this->assertTrue($form->validate());

        $post = $this->postService->create($form);

        expect($post->save())->true();
        //проверка seo
        expect($post->seo->page_id)->equals($post->id);
        expect($post->seo->alias)->equals('post');
        expect($post->seo->h1)->equals($data['MetaForm']['h1']);
        expect($post->seo->title)->equals($data['MetaForm']['title']);
        expect($post->seo->keywords)->equals($data['MetaForm']['keywords']);
        expect($post->seo->description)->equals($data['MetaForm']['description']);
        expect($post->seo->seo_text)->equals($data['MetaForm']['seo_text']);
        expect($post->seo->save())->true();
        // проверка тегов
        expect($post->tags[0]['title'])->equals($data['TagsForm']['existing'][0]);
        expect($post->tags[1]['title'])->equals($data['TagsForm']['existing'][1]);
    }

    public function testEdit()
    {
        $oldPost = $this->post;
        $date = (new \DateTimeImmutable('now'))->format('d-m-Y H:i');
        $data = [
            'PostForm' => [
                'title' => 'Edit',
                'alias' => 'edit',
                'category_id' => 3,
                'country_id' => 3,
                'published_at' => $date,
                'media_id' => 2,
                'content' => 'edit',
                'description' => 'edit',
                'status' => POST::ACTIVE
            ],
            'TagsForm' => [
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

        $form = new PostForm();
        $this->assertTrue($form->load($data));
        $this->assertTrue($form->validate());

        $post = $this->postService->edit($oldPost->id,$form);

        expect($post->save())->true();

        expect($post->title)->notEquals($oldPost->title);
        expect($post->alias)->notEquals($oldPost->alias);
        expect($post->content)->notEquals($oldPost->content);
        expect($post->description)->notEquals($oldPost->description);
        expect($post->country_id)->notEquals($oldPost->country_id);
        expect($post->category_id)->notEquals($oldPost->category_id);

        expect($post->seo->page_id)->equals($post->id);
        expect($post->seo->alias)->equals('post');
        expect($post->seo->h1)->equals($data['MetaForm']['h1']);
        expect($post->seo->title)->equals($data['MetaForm']['title']);
        expect($post->seo->keywords)->equals($data['MetaForm']['keywords']);
        expect($post->seo->description)->equals($data['MetaForm']['description']);
        expect($post->seo->seo_text)->equals($data['MetaForm']['seo_text']);
        expect($post->seo->save())->true();
        // проверка тегов
        expect($post->tags[0]['title'])->equals($data['TagsForm']['existing'][0]);
        expect($post->tags[1]['title'])->equals($data['TagsForm']['existing'][1]);
    }
}