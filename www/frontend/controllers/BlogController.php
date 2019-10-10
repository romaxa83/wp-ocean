<?php

namespace frontend\controllers;

use backend\modules\blog\entities\HotelReview;
use backend\modules\blog\entities\Post;
use backend\modules\blog\helpers\DateHelper;
use backend\modules\blog\helpers\ImageHelper;
use backend\modules\referenceBooks\models\DeptCity;
use common\models\Curl;
use frontend\helpers\BreadcrumbHelper;
use frontend\helpers\TitleHelper;
use yii\base\Module;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Json;
use frontend\service\TourService;
use backend\modules\blog\services\PostService;
use backend\modules\blog\services\ReviewService;
use backend\modules\blog\repository\TagRepository;
use backend\modules\blog\repository\PostRepository;
use backend\modules\blog\services\HotelReviewService;
use backend\modules\blog\services\UploadAvatarService;
use backend\modules\blog\repository\CategoryRepository;
use backend\modules\blog\repository\HotelReadRepository;
use backend\modules\blog\repository\CountryReadRepository;
use yii\web\NotFoundHttpException;

class BlogController extends BaseController
{
    /**
     * @var PostRepository
     */
    private $postRepository;
    /**
     * @var TagRepository
     */
    private $tagRepository;
    /**
     * @var CountryReadRepository
     */
    private $countryReadRepository;
    /**
     * @var HotelReadRepository
     */
    private $hotelReadRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var PostService
     */
    private $postService;
    /**
     * @var HotelReviewService
     */
    private $hotelReviewService;
    /**
     * @var UploadAvatarService
     */
    private $uploadAvatarService;
    /**
     * @var ReviewService
     */
    private $reviewService;
    /**
     * @var TourService
     */
    private $tourService;

    private $titleHelper;

    public function __construct($id, Module $module,
                                CategoryRepository $categoryRepository,
                                TourService $tourService,
                                PostRepository $postRepository,
                                PostService $postService,
                                HotelReviewService $hotelReviewService,
                                ReviewService $reviewService,
                                TagRepository $tagRepository,
                                CountryReadRepository $countryReadRepository,
                                HotelReadRepository $hotelReadRepository,
                                UploadAvatarService $uploadAvatarService,
                                array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;
        $this->countryReadRepository = $countryReadRepository;
        $this->hotelReadRepository = $hotelReadRepository;
        $this->categoryRepository = $categoryRepository;
        $this->postService = $postService;
        $this->hotelReviewService = $hotelReviewService;
        $this->uploadAvatarService = $uploadAvatarService;
        $this->reviewService = $reviewService;
        $this->tourService = $tourService;
        $this->titleHelper = new TitleHelper();
    }


    public function actionIndex($limit = null)
    {
        $default_limit = $this->getLimit($limit);

        $this->renderBreadcrumbs($this->generateBreadcrumbs());

        return $this->render('index',[
            'categories' => $this->categoryRepository->getAll(),
            'posts' => $this->postRepository->getAll($default_limit),
            'all_posts_count' => $this->postRepository->getAllCount(),
            'tags' => $this->tagRepository->getAll(),
            'countries' => $this->countryReadRepository->getCountryAttachPosts(),
            'hotels' => $this->hotelReadRepository->getExistsReview(),
            'route' => $this->generateRouteBtn('/blog',$default_limit),
        ]);
    }

    public function actionCategory($slug,$limit = null)
    {
        $default_limit = $this->getLimit($limit);

        $all_categories = $this->categoryRepository->getAll();
        $category_name = '';
        if($all_categories){
            $category_name = (ArrayHelper::index($this->categoryRepository->getAll(),'alias')[$slug])->title;
        }

        $this->renderBreadcrumbs($this->generateBreadcrumbs([
            [
                'href' => Url::to('/blog/category/'.$slug, TRUE),
                'name' => $category_name
            ]
        ]));

        return $this->render('index',[
            'categories' => $all_categories,
            'posts' => $this->postRepository->getAllByCategoryAlias($slug,$default_limit),
            'all_posts_count' => $this->postRepository->getAllByCategoryAliasCount($slug),
            'tags' => $this->tagRepository->getAll(),
            'countries' => $this->countryReadRepository->getCountryAttachPosts(),
            'hotels' => $this->hotelReadRepository->getExistsReview(),
            'category_alias' => $slug,
            'route' => $this->generateRouteBtn('/blog/category/'.$slug,$default_limit),
            'title' => $this->titleHelper->getBlogTitle('category',$category_name)
        ]);
    }

    public function actionTag($slug,$limit = null)
    {
        $default_limit = $this->getLimit($limit);

        $this->renderBreadcrumbs($this->generateBreadcrumbs());

        return $this->render('index',[
            'categories' => $this->categoryRepository->getAll(),
            'posts' => $this->postRepository->getAllByTagAlias($slug,$default_limit),
            'all_posts_count' => $this->postRepository->getAllByTagAliasCount($slug),
            'tags' => $this->tagRepository->getAll(),
            'countries' => $this->countryReadRepository->getCountryAttachPosts(),
            'hotels' => $this->hotelReadRepository->getExistsReview(),
            'tag_alias' => $slug,
            'route' => $this->generateRouteBtn('/blog/tag/'.$slug,$default_limit)
        ]);
    }

    public function actionCountry($slug,$limit = null)
    {
        $default_limit = $this->getLimit($limit);
        $data = $this->countryReadRepository->getCountryIdByAlias($slug);
        if(!$data){
            throw new NotFoundHttpException('Not found.');
        }

        $id = $data->id;

        $this->renderBreadcrumbs($this->generateBreadcrumbs([
            [
                'href' => Url::to('/blog/country/'.$slug, TRUE),
                'name' => $this->titleHelper->getBlogTitle('country',$data->name)
            ]
        ]));

        return $this->render('index',[
            'categories' => $this->categoryRepository->getAll(),
            'posts' => $this->postRepository->getAllByCountry($id,$default_limit),
            'all_posts_count' => $this->postRepository->getAllByCountryCount($id),
            'tags' => $this->tagRepository->getAll(),
            'countries' => $this->countryReadRepository->getCountryAttachPosts(),
            'hotels' => $this->hotelReadRepository->getExistsReview(),
            'country_id' => $id,
            'route' => $this->generateRouteBtn('/blog/country/'.$slug,$default_limit),
            'title' => $this->titleHelper->getBlogTitle('country',$data->name),
            'checkCountry' => $data->name
        ]);
    }

    public function actionHotel($slug,$limit = null)
    {
        $default_limit = $this->getLimit($limit);

        $data = $this->hotelReadRepository->getHotelIdByAlias($slug);
        if(!$data){
            throw new NotFoundHttpException('Not found.');
        }

        $id = $data->id;

        $this->renderBreadcrumbs($this->generateBreadcrumbs([
            [
                'href' => Url::to('/blog/hotel/'.$slug, TRUE),
                'name' => $this->titleHelper->getBlogTitle('hotel',$data->name)
            ]
        ]));

        return $this->render('index',[
            'categories' => $this->categoryRepository->getAll(),
            'posts' => $this->hotelReadRepository->getAllByHotel($id,$default_limit),
            'all_posts_count' => $this->hotelReadRepository->getAllByHotelCount($id),
            'tags' => $this->tagRepository->getAll(),
            'countries' => $this->countryReadRepository->getCountryAttachPosts(),
            'hotels' => $this->hotelReadRepository->getExistsReview(),
            'hotel_id' => $id,
            'route' => $this->generateRouteBtn('blog/hotel/'.$slug,$default_limit),
            'title' => $this->titleHelper->getBlogTitle('hotel',$data->name),
            'checkHotel' => $data->name
        ]);
    }

    public function actionCountryFind()
    {
        $post = \Yii::$app->request->post();

        return $this->redirect(Url::toRoute(['blog/country/'.$post['value']]),301);
    }

    public function actionHotelFind()
    {
        $post = \Yii::$app->request->post();

        return $this->redirect(Url::toRoute(['blog/hotel/'. $post['value']]),301);
    }

    public function actionPost($slug)
    {
        $id = $this->postRepository->getPostIdBySlug($slug);

        $post = $this->postService->addView($id);
        $similar_posts = $this->postService->getSimilarPosts($post->country_id,$post->category_id,$id,4);

        $seo = $post->getSeo()->where(['alias' => 'post'])->one();
        $this->registerSeo($seo->title?:$post->title, $seo->keywords, $seo->description);
        $this->generatePostSchemaForSeo($post,$seo);

        if ($post->category['alias'] === 'novosti') {
            \Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex, follow'
            ]);
        }

        if($referrer = (new BreadcrumbHelper())->parseForBlog(\Yii::$app->request->referrer)){

            $this->renderBreadcrumbs($this->generateBreadcrumbs([
                [
                    'href' => $referrer['url'],
                    'name' => $referrer['title']
                ],
                [
                    'href' => Url::to('/blog/post/'.$slug, TRUE),
                    'name' => $post->title
                ]
            ]));
        } else {
            $this->renderBreadcrumbs($this->generateBreadcrumbs([
                [
                    'href' => Url::to('/blog/post/'.$slug, TRUE),
                    'name' => $post->title
                ]
            ]));
        }

        return $this->render('post',[
            'post' => $post,
            'similar_posts' => $similar_posts
        ]);
    }

    public function actionHotelReview($slug)
    {
        $id = $this->hotelReviewService->addIdBySlug($slug);

        $this->hotelReviewService->addView($id);

        $hotelReview = $this->hotelReadRepository->getHotelReviewForFrontend($id);

        $tourHotel = $this->tourService->getRandomTourForCountry(
            $hotelReview->hotel->country_id,
            $hotelReview->hotel->hid,
            3);
        $typeFood = $this->hotelReadRepository->getTypeFood();

        $data_api = $this->tourService->initDataApi($hotelReview->hotel->hid);
        $deptCity = DeptCity::find()->select(['rel'])->where(['cid' => $data_api['deptCity']])->asArray()->one();
        $data_api['deptCityRel'] = $deptCity['rel'];

        $this->registerSeo($hotelReview->seo->title?:$hotelReview->title,
            $hotelReview->seo->keywords,
            $hotelReview->seo->description);
        $this->generatePostSchemaForSeo($hotelReview,$hotelReview->seo);

        if($referrer = (new BreadcrumbHelper())->parseForBlog(\Yii::$app->request->referrer)){
            $this->renderBreadcrumbs($this->generateBreadcrumbs([
                [
                    'href' => $referrer['url'],
                    'name' => $referrer['title']
                ],
                [
                    'href' => Url::to('/blog/post/'.$slug, TRUE),
                    'name' => $hotelReview->title
                ]
            ]));
        } else {
            $this->renderBreadcrumbs($this->generateBreadcrumbs([
                [
                    'href' => Url::to('/blog/post/'.$slug, TRUE),
                    'name' => $hotelReview->title
                ]
            ]));
        }

        return $this->render('hotel-review',[
            'hotelReview' => $hotelReview,
            'tourHotel' => $tourHotel,
            'tourOffers' => [],
            'dataApi' => $data_api,
            'allRoom' => [],
            'typeFood' => $typeFood
        ]);
    }

    public function actionGetOffers()
    {
        if(\Yii::$app->request->isAjax){
            $post = \Yii::$app->request->post('hotel_hid');
            $data_api = $this->tourService->initDataApi($post);
            $hotel = $this->hotelReadRepository->getHotelByHid($post);
            $typeFood = $this->hotelReadRepository->getTypeFood();
            $tourOffers = [];
            $allRoom = [];
            $data_api['length'] += 1;
            $data_api['lengthTo'] += 1;
            for($i = 0; $i < 10; $i++){
                $curl = Curl::curl('GET', '/api/tours/search', $data_api);

                if($curl['status'] === 200 && isset($curl['body']['lastResult'])){
                    if($curl['body']['lastResult'] == true){
                        if(isset($curl['body']['hotels'][1])){
                            if (isset($curl['body']['hotels'][1][$post])) {

                                $offers = $curl['body']['hotels'][1][$post]['offers'];
                                $data_api['deptCity'] = $curl['body']['dept']['nameRd'];
                                $tourOffers = array_map(function($item){
                                    return [
                                        'price' => $item['pl'],
                                        'room' => $item['r'],
                                        'food' => $item['f'],
                                        'days' => $item['n'],
                                        'date' => $item['d'],
                                        'insurance' => (array_search('insurance', $item['o']) !== FALSE) ? 'Да' : 'Нет'
                                    ];
                                },$offers);
                                //получаем все имеюшиеся комнаты
                                $allRoom = array_unique(array_column($tourOffers,'room'));
                            }
                        }
                    }
                }
                sleep(1);
            }

            if($tourOffers){
                return $this->renderPartial('_hr_offers', [
                    'tourOffers' => $tourOffers,
                    'hotel' => $hotel,
                    'typeFood' => $typeFood,
                    'allRoom' => $allRoom
                ]);
            }
            return false;
        }
    }

    public function actionHotelReviewOffers()
    {
        if(\Yii::$app->request->isAjax){

            $typeFood = $this->hotelReadRepository->getTypeFood();
            $data = \Yii::$app->request->post();
            $hotel = $this->hotelReadRepository->getHotelByHid($data['to']);
            $deptCity = DeptCity::find()->select(['rel'])->where(['cid' => $data['deptCity']])->asArray()->one();
            $data['checkIn'] = DateHelper::convertForApi($data['checkIn']);
            $data['checkTo'] = DateHelper::convertForApi($data['checkTo']);

            if (isset($data['food'])) {
                $data['food'] = implode(',', $data['food']);
            }

            if (isset($data['room'])) {
                if ($data['room'] == 'Все номера' || empty($data['room'])) {
                    unset($data['room']);
                }
            }
            $data['length'] += 1;
            $data['lengthTo'] += 1;
            $data['access_token'] = \Yii::$app->params['apiToken'];
            $tourOffers = [];
            $allRoom = [];

            for ($i = 0; $i < 10; $i++) {
                $curl = Curl::curl('GET', '/api/tours/search', $data);

                if ($curl['status'] === 200) {
                    if (isset($curl['body']['lastResult']) &&  $curl['body']['lastResult'] == true) {
                        if(isset($curl['body']['hotels'][1][$data['to']])){

                            $offers = $curl['body']['hotels'][1][$data['to']]['offers'];
                            $tourOffers = array_map(function($item){
                                return [
                                    'price' => $item['pl'],
                                    'room' => $item['r'],
                                    'food' => $item['f'],
                                    'days' => $item['n'],
                                    'date' => $item['d'],
                                    'insurance' => (array_search('insurance', $item['o']) !== FALSE) ? 'Да' : 'Нет'
                                ];
                            },$offers);

                            $allRoom = array_unique(array_column($tourOffers,'room'));
                            //удаляем предложений не подходящие по комнате
                            if(isset($data['room'])){
                                foreach ($tourOffers as $id => $offer) {
                                    if ($offer['room'] != $data['room']) {
                                        unset($tourOffers[$id]);
                                    }
                                }
                            }
                        }
                    }
                }
                sleep(1);
            }

            $data['length']--;
            $data['lengthTo']--;
            $content['info'] = '(Для ' . $data['people'] . ' взр., из <span class="deptCity">' . $deptCity['rel'] . '</span>, с <b class="offer-date-in">' .
                \Yii::$app->formatter->asDate($data['checkIn'], 'php: d.m.Y') . '</b> по <b class="offer-date-to">' .
                \Yii::$app->formatter->asDate($data['checkTo'], 'php: d.m.Y') . '</b>, от <b class="offer-length">' .
                $data['length'] . '</b> до <b class="offer-length-to">' .
                $data['lengthTo'] . '</b> ночей)';

            $content['content'] = $this->renderPartial('_hr_offers', [
                'tourOffers' => $tourOffers,
                'hotel' => $hotel,
                'typeFood' => $typeFood,
                'allRoom' => $allRoom
            ]);
            return Json::encode($content);
        }
    }

    public function actionAddReviewToHotel()
    {
        $post = \Yii::$app->request->post();
        try {
            $this->reviewService->createReview($post);

        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['blog/hotel-review','id' => $post['review_hotel_id']],301);
    }

    public function actionAddAvatarReview()
    {
        $data = $this->uploadAvatarService->setAvatar($_FILES);

        return JSON::encode($data);
    }

    public function actionMorePost()
    {
        $post = \Yii::$app->request->post();

        return $this->redirect([$post['url']],301);
    }

    private function getLimit($limit)
    {
        $default_limit = \Yii::$app->params['posts_on_page'];
        if($limit){
            $default_limit = $limit;
        }

        return $default_limit;
    }

    private function generateBreadcrumbs(array $array = null) : array
    {
        $base = [
            [
                'href' => Url::to('/', TRUE),
                'name' => 'Главная'
            ],
            [
                'href' => Url::to('/blog', TRUE),
                'name' => 'Блог'
            ]
        ];
        if($array){
            foreach ($array as $item){
//                debug($item);
                $base[] = $item;
            }
        }
        return $base;
    }

    //url для подтягивании дополнительных постов
    private function generateRouteBtn($url,$limit)
    {
        return Url::toRoute([
            $url,
            'limit' => (int)$limit + (int)\Yii::$app->params['posts_download_page'],
            '#' => 'post_'.$limit
        ]);
    }

    private function generatePostSchemaForSeo($post,$seo)
    {
        $data = [
            'head' => $post->title,
            'genre' => "journey",
            'keywords' => $seo->keywords,
            'description' => $post->description,
            'logoUrl' => Url::base(true) . '/img/logo_white2.png',
            'url' => Url::base(true) . '/blog/post/'.$post->alias,
            'datePublished' => date('Y-m-d',$post->published_at),
            'dateCreated' => date('Y-m-d',$post->created_at),
            'dateModified' => date('Y-m-d',$post->updated_at)
        ];

        if($post instanceof Post){
            $data['imgUrl'] = $post->media_id !== null
                ? Url::base(true). '/admin' . $post->media->url
                : Url::base(true). '/admin/img/not-images.png';
            $data['url'] = Url::base(true) . '/blog/post/'.$post->alias;
        }
        if($post instanceof HotelReview){
            ImageHelper::parseMediaIds($post->media_ids);
            $data['imgUrl'] = Url::base(true). '/admin' .
                ImageHelper::getImageUrlById(ImageHelper::parseMediaIds($post->media_ids)[0]);
            $data['url'] = Url::base(true) . '/blog/hotel-review/'.$post->alias;
        }

        $schema = [
            "@context" => "http://schema.org",
            "@type" => "Article",
            "headline" => $data['head'],
            "image" => $data['imgUrl'],
            "author" => "Admin",
            "genre" => $data['genre'],
            "keywords" => $data['keywords'],
            "publisher" => [
                "@type" => "Organization",
                "name" => "5 океан",
                "logo" => [
                    "@type" => "http://schema.org/ImageObject",
                    "url" => $data['logoUrl']
                ]
            ],
            "url" => $data['url'],
            "datePublished" => $data['datePublished'],
            "dateCreated" => $data['dateCreated'],
            "dateModified" => $data['dateModified'],
            "description" => $data['description'],
            "mainEntityOfPage" => "Post",
        ];

        \Yii::$app->view->params['SchemaPost'] = Json::encode($schema);
    }
}
