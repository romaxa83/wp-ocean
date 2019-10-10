<?php

namespace frontend\controllers;

use backend\modules\content\models\ContentOptions;
use backend\modules\content\models\Page;
use backend\modules\user\forms\ReviewsForm;
use backend\modules\user\helpers\ImageFromNetwork;
use backend\modules\user\type\FbType;
use Psr\Log\InvalidArgumentException;
use Yii;
use yii\base\Module;
use common\models\User;
use common\models\Auth;
use yii\db\ActiveQuery;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\LoginForm;
use common\models\SignupForm;
use yii\filters\AccessControl;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use frontend\models\ResetPasswordForm;
use frontend\models\PasswordResetRequestForm;
use backend\modules\user\services\UserService;
use backend\modules\user\services\ReviewsService;
use backend\modules\user\services\PassportService;
use backend\modules\user\repository\AuthRepository;
use backend\modules\user\dispatchers\EventDispatcher;
use backend\modules\user\services\IntPassportService;
use backend\modules\user\repository\PassportRepository;
use backend\modules\referenceBooks\models\Country;
use backend\modules\referenceBooks\models\DeptCity;
use backend\modules\referenceBooks\models\City;
use backend\modules\referenceBooks\models\Hotel;
use common\models\Curl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use backend\modules\referenceBooks\models\Tour;
use backend\modules\referenceBooks\models\HotelReview;
use backend\modules\filemanager\models\Mediafile;
use yii\helpers\Url;
use backend\modules\filter\models\Filter;
use backend\modules\referenceBooks\models\TypeFood;

/**
 * Site controller
 */
class SiteController extends BaseController {

    private $user_service;
    private $passport_service;
    private $int_passport_service;
    private $passport_repository;
    private $auth_repository;
    private $dispatcher;
    private $reviews_service;

    public function __construct($id, Module $module, UserService $user, PassportService $passport_service, PassportRepository $passport, AuthRepository $auth_rep, IntPassportService $int_passport, EventDispatcher $dispatcher, ReviewsService $reviews, array $config = []) {
        parent::__construct($id, $module, $config);
        $this->user_service = $user;
        $this->passport_service = $passport_service;
        $this->int_passport_service = $int_passport;
        $this->passport_repository = $passport;
        $this->auth_repository = $auth_rep;
        $this->dispatcher = $dispatcher;
        $this->reviews_service = $reviews;
    }

    public function beforeAction($action) {
        if ($action->id == 'create-int-passport') {
            \Yii::$app->controller->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
//    public function behaviors() {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['logout', 'signup'],
//                'rules' => [
//                    [
//                        'actions' => ['signup'],
//                        'allow' => true,
//                        'roles' => ['?'],
//                    ],
//                    [
//                        'actions' => ['logout'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
//        ];
//    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $page_id = ContentOptions::getOption('main_page_id');
        $pageInfo = $this->getPageInfo($page_id);
        $pageData = ArrayHelper::index(Page::find()->select(['id', 'slug_id'])->with('slugManager')->asArray()->all(), 'id');
        $filter = Filter::find()->where(['status' => TRUE])->asArray()->all();
        $filter = ArrayHelper::index($filter, 'alias');
        Yii::$app->session->set('filter_alias', 'default');
        $country_priority = Country::find()->select(['alias', 'name'])->where(['in', 'name', Yii::$app->params['priority']])->orderBy(['id' => SORT_DESC])->asArray()->all();
        $country_priority = ArrayHelper::map($country_priority, 'alias', 'name');
        $country_all = Country::find()->select(['alias', 'name'])->where(['not in', 'name', Yii::$app->params['priority']])->asArray()->all();
        $country_all = ArrayHelper::map($country_all, 'alias', 'name');
        $country = $country_priority + $country_all;
        $dept_city = DeptCity::find()->select(['alias', 'name'])->where(['status' => 1])->orderBy(['name' => SORT_ASC])->asArray()->all();
        $dept_city = ArrayHelper::map($dept_city, 'alias', 'name');
        $type_food = ArrayHelper::map(TypeFood::find()->asArray()->all(), 'id', 'name');
        $city = City::find()->select(['cid', 'name'])->where(['name' => Yii::$app->params['city']['turkey']])->orderBy(['name' => SORT_ASC])->asArray()->all();
        $city = ArrayHelper::map($city, 'cid', 'name');
        $hotel = Hotel::find()->select(['hid', 'name'])->where(['status' => 1, 'country_id' => 115])->orderBy(['name' => SORT_ASC])->asArray()->all();
        $hotel = ArrayHelper::map($hotel, 'hid', 'name');
        $top_tour = Tour::find()->where(['!=', 'main', 0])->andWhere(['status' => '1'])
            ->with('hotel')->with('deptCity')->with('hotel.category')
            ->with('hotel.cites')->with('hotel.countries')->with('hotel.address')
            ->with('hotel.hotelService')->with([
                'special' => function (\yii\db\ActiveQuery $query) {
                    $query->andWhere('status = 1')->andFilterWhere(['and',
                        ['<', 'from_datetime', date("Y-m-d H:i:s")],
                        ['>', 'to_datetime', date("Y-m-d H:i:s")]]);
                },
            ])->limit(5)->orderBy(['main' => SORT_ASC])->asArray()->all();
        $hotel_review = $this->getHotelReview(ArrayHelper::getColumn($top_tour, 'hotel.id'));
        foreach ($top_tour as $key => $item) {
            $top_tour[$key]['hotel']['mainService'] = [];
            foreach ($item['hotel']['hotelService'] as $k => $v) {
                $top_tour[$key]['hotel']['mainService'][] = $item['hotel']['hotelService'][$k];
            }
            $media = Mediafile::find()->select(['url', 'alt'])->where(['id' => $item['hotel']['media_id']])->asArray()->one();
            if (!isset($media['url'])) {
                $media = [
                    'url' => 'img/logo_no_photo.png',
                    'alt' => '',
                ];
            }
            $top_tour[$key]['hotel']['media'] = $media;
            shuffle($top_tour[$key]['hotel']['mainService']);
            $top_tour[$key]['hotel']['mainService'] = array_slice($top_tour[$key]['hotel']['mainService'], 0, 6);
            $top_tour[$key]['description'] = 'город отправления ' .
                    $top_tour[$key]['deptCity']['name'] . ' ' .
                    Yii::$app->formatter->asDate($top_tour[$key]['date_end'], 'php:d.m.Y') . ', ' .
                    $top_tour[$key]['length'] . ' ' . $this->num2word($top_tour[$key]['length'], array('ночь', 'ночи', 'ночей')) .
                    ', питание ' . $type_food[$top_tour[$key]['type_food_id']] .
                    ', цена указана за 2 человека';
            $top_tour[$key]['link'] = Url::to([
                        '/tour/' . $top_tour[$key]['hotel']['countries']['alias'] . '/' .
                        $top_tour[$key]['hotel']['cites']['alias'] . '/' .
                        $top_tour[$key]['hotel']['alias'],
                        'id' => $top_tour[$key]['id'],
                        'date_begin' => Yii::$app->formatter->asDate($top_tour[$key]['date_begin'], 'php:Y-m-d'),
                        'date_end' => Yii::$app->formatter->asDate($top_tour[$key]['date_end'], 'php:Y-m-d')
                            ], TRUE);
        }
        return $this->render('index', [
                    'city' => $city,
                    'hotel' => $hotel,
                    'dept_city' => $dept_city,
                    'country' => $country,
                    'top_tour' => $top_tour,
                    'hotel_review' => $hotel_review,
                    'seoData' => $pageInfo['pageMetas'],
                    'content' => $pageInfo['pageText'],
                    'pageData' => $pageData,
                    'filter' => $filter
        ]);
    }

    /* регистрация */
    public function actionSignup() {
        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->user_service->createByRegistration($form);
                $this->dispatcher->dispatchAll($user->releaseEvents());
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
    }

    /* потверждение регистрации */
    public function actionConfirmSignUp($token)
    {
        try {
            $user = $this->user_service->confirmSignUp($token);
            if(!$user){
                return $this->redirect(Url::to(['/']),301);
            }
            $this->dispatcher->dispatchAll($user->releaseEvents());
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        Yii::$app->user->login($user);
        return $this->redirect(Url::to(['/','modal' => 'confirm-success']),301);
    }

    /* ajax валидация для регистрации */
    public function actionValidateAjaxSignup() {
        $model = new SignupForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    /* регистрация через соц.сети */
    public function onAuthSuccess($client) {
        $attributes = $client->getUserAttributes();

        if (isset($attributes['picture'])) {
            $image_data = (new ImageFromNetwork($attributes['picture']))->parse();
        }

        /* @var $auth Auth */
        $auth = $this->auth_repository->get($client->getId(), $attributes['id']);

        if (Yii::$app->user->isGuest) {
            if ($auth) { // авторизация
                $user = $auth->user;
                Yii::$app->user->login($user);
            } else { // регистрация
                if ($this->isEmail($attributes['email']) && $user = User::findByEmail($attributes['email'])) {
                    //пользователь есть в бд,но не аутентифицирован через этот сервис
                    $this->user_service->addAuthNetwork($user->id, $client->getId(), $attributes['id']);
                    Yii::$app->user->login($user);
                    return $this->redirect('index');
                } else {
                    if ($client->getId() == 'google') {
                        //регистрация пользователя через google-акаунт
                        $user = $this->user_service->authGoogle($attributes, $image_data);
                        $this->dispatcher->dispatchAll($user->releaseEvents());
                        Yii::$app->user->login($user);

                        return $this->redirect(Url::to('/', true));
//                        return $this->redirect('/cabinet/settings');
                    }
                    if ($client->getId() == 'facebook') {
                        //регистрация пользователя через facebook-акаунт
                        if(!isset($attributes['email']) || empty($attributes['email'])){
                            throw new InvalidArgumentException('Facebook don\'t give email.');
                        }
                        $user = $this->user_service->authFacebook(
                                new FbType($attributes['name'], $attributes['email'], $attributes['id'])
                        );
                        $this->dispatcher->dispatchAll($user->releaseEvents());
                        Yii::$app->user->login($user);

                        return $this->redirect(Url::to('/', true));
                    }
                    //добавить другие виды регистрации
                }
            }
        } else { // Пользователь уже зарегистрирован
            if (!$auth) { // добавляем внешний сервис аутентификации
                $this->user_service->addAuthNetwork(Yii::$app->user->id, $client->getId(), $attributes['id']);
            }
        }
    }

    /* логин пользователя */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if ($this->isAdmin($model->email)) {
                Yii::$app->user->logout();
                return $this->redirect('/');
            }
            return $this->goBack();
        } else {
            $model->password = '';
        }
    }

    /* ajax валидация для логина */
    public function actionValidateAjaxLogin() {
        $model = new LoginForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    /* логаут */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    public function actionCreateIntPassport() {
        $post = Yii::$app->request->post();
        try {
            $this->int_passport_service->create($post, Yii::$app->user->identity->id);

            Yii::$app->session->setFlash('success', 'Паспортный данные сохранены.');
//            return $this->refresh();
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }
    }

    /* ajax валидация для зброса пароля */

    public function actionValidateAjaxRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {

            return $this->goHome();
        }
    }

    public function actionReviews() {
        $form = new ReviewsForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->reviews_service->create($form);
                Yii::$app->session->setFlash('success', 'Ваш отзыв отправлен на модерацию');
                return $this->redirect(['reviews']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('reviews');
    }

    private function isEmail($email) {
        return (isset($email) && !empty($email));
    }

    public function actionGetCountry() {
        $get = Yii::$app->request->get();
        $country = Country::find()->select(['cid', 'name'])->where(['like', 'name', $get['q']])->andWhere(['status' => 1])->asArray()->all();
        $country = ArrayHelper::map($country, 'cid', 'name');
        $data = [];
        foreach ($country as $k => $v) {
            $data[] = [
                'id' => $k,
                'text' => $v
            ];
        }
        return Json::encode($data);
    }

    public function actionGetHotel() {
        $post = Yii::$app->request->post();
        $hotel = Hotel::find()->select(['hid', 'name'])->where(['like', 'name', $post['hotel']])->andWhere(['status' => 1])->asArray()->all();
        $hotel = ArrayHelper::map($hotel, 'hid', 'name');
        return Json::encode($hotel);
    }

    public function actionGetData() {
        if (Yii::$app->request->isAjax) {
            $city_list = [];
            $hotel_list = [];
            $city_active = '';
            $hotel_active = '';
            $city_alias = Yii::$app->request->post('value');
            $filter = Filter::find()->where(['alias' => Yii::$app->session->has('filter_alias') ? Yii::$app->session->get('filter_alias') : 'default'])->asArray()->one();
            $filter['city'] = Json::decode($filter['city']);
            $filter['hotel'] = Json::decode($filter['hotel']);
            $country = Country::find()->select(['id', 'cid'])->where(['alias' => $city_alias])->asArray()->one();
            $city = City::find()->select(['id', 'cid', 'alias', 'name'])->where(['status' => TRUE, 'country_id' => $country['cid']])->asArray()->all();
            $city = ArrayHelper::index($city, 'id');
            if (isset($filter['city'][$country['cid']])) {
                foreach ($filter['city'][$country['cid']] as $v) {
                    $city_list[$city[$v]['alias']] = [
                        $city[$v]['cid'],
                        $city[$v]['name']
                    ];
                    if (isset($filter['city']['default']) && $filter['city']['default'] == $city[$v]['id']) {
                        $city_active = $city[$v]['alias'];
                    }
                }
            }
            $hotel = Hotel::find()->select(['id', 'city_id', 'alias', 'name', 'category_id'])->where(['status' => TRUE, 'country_id' => $country['cid']])->with('category')->asArray()->all();
            $hotel = ArrayHelper::index($hotel, 'id');
            if (isset($filter['hotel'][$country['cid']])) {
                foreach ($filter['hotel'][$country['cid']] as $v) {
                    foreach ($v as $v1) {
                        if (isset($hotel[$v1]['alias'])){
                            $hotel_list[$hotel[$v1]['alias']] = [
                                $hotel[$v1]['city_id'],
                                $hotel[$v1]['name'],
                                $hotel[$v1]['category']['id']
                            ];
                        }
                        if (isset($filter['hotel']['default']) && $filter['hotel']['default'] == $hotel[$v1]['id']) {
                            $hotel_active = $hotel[$v1]['alias'];
                        }
                    }
                }
            }
            return Json::encode([
                        'city' => $city_list,
                        'city_active' => (Yii::$app->session->has('filterСities')) ? Yii::$app->session->get('filterСities') : $city_active,
                        'hotel' => $hotel_list,
                        'hotel_active' => (Yii::$app->session->has('filterHotels')) ? Yii::$app->session->get('filterHotels') : $hotel_active
            ]);
        }
    }

    protected function getPageInfo($page_id) {
        $pageInfo = Page::find()
                ->where(['id' => $page_id])
                ->with([
                    'pageMetas',
                    'pageText' => function (ActiveQuery $query) {
                        $query->indexBy('name');
                    }
                ])
                ->asArray()
                ->one();

        return $pageInfo;
    }

    private function isAdmin($email) {
        /** @var $user User */
        $user = User::findByEmail($email);
        return ($user->username !== null && $user->username) ? true : false;
    }

}
