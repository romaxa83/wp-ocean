<?php


namespace backend\modules\menuBuilder\controllers;


use backend\modules\content\models\Channel;
use backend\modules\content\models\ChannelRecord;
use backend\modules\content\models\Page;
use backend\modules\filter\models\Filter;
use backend\modules\user\useCase\Access;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class ItemTypeController extends Controller
{
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'get-page',
                            'get-channel',
                            'get-channel-records',
                            'get-link',
                            'get-group',
                            'get-blog',
                            'get-faq',
                            'get-social',
                            'get-filter'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    protected $access;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->access = new Access();
    }

    /**
     * @perm('Получение шаблона элемента "Группа" (редактор меню)')
     *
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionGetGroup()
    {
        $this->access->accessAction();

        return $this->renderPartial('group');
    }

    /**
     * @perm('Получение шаблона элемента "Страница" (редактор меню)')
     *
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionGetPage()
    {
        $this->access->accessAction();

        $pages = Page::find()
            ->with('slugManager')
            ->asArray()
            ->all();

        return $this->renderPartial('page', compact('pages'));
    }

    /**
     * @perm('Получение шаблона элемента "Канал" (редактор меню)')
     *
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionGetChannel()
    {
        $this->access->accessAction();

        $channels = Channel::find()
            ->with('slugManager')
            ->indexBy('id')
            ->asArray()
            ->all();

        return $this->renderPartial('channel', compact('channels'));
    }

    /**
     * @perm('Получение шаблона элемента "Запись канала" (редактор меню)')
     *
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionGetChannelRecords()
    {
        $this->access->accessAction();

        $channel_id = Yii::$app->request->post('channel_id');

        $records = ChannelRecord::find()
            ->where(['channel_id' => $channel_id])
            ->with('slugManager')
            ->asArray()
            ->all();

        return $this->renderPartial('channel-records', compact('records'));
    }

    /**
     * @perm('Получение шаблона элемента "Фильтр" (редактор меню)')
     *
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionGetFilter()
    {
        $this->access->accessAction();

        $filters = Filter::find()->indexBy('alias')->asArray()->all();

        return $this->renderPartial('filter', compact('filters'));
    }

    /**
     * @perm('Получение шаблона элемента "Блог" (редактор меню)')
     *
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionGetBlog()
    {
        $this->access->accessAction();

        return $this->renderPartial('blog');
    }

    /**
     * @perm('Получение шаблона элемента "FAQ" (редактор меню)')
     *
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionGetFaq()
    {
        $this->access->accessAction();

        return $this->renderPartial('faq');
    }

    /**
     * @perm('Получение шаблона элемента "Социальная сеть" (редактор меню)')
     *
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionGetSocial()
    {
        $this->access->accessAction();

        return $this->renderPartial('social');
    }

    /**
     * @perm('Получение шаблона "Ссылка" (редактор меню)')
     *
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionGetLink()
    {
        $this->access->accessAction();

        return $this->renderPartial('link');
    }
}