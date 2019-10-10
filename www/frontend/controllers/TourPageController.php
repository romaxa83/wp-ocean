<?php

namespace frontend\controllers;

use Yii;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\helpers\Json;
use backend\modules\content\models\Page;
use backend\modules\referenceBooks\models\Tour;
use backend\modules\referenceBooks\models\TypeFood;
use backend\modules\filemanager\models\Mediafile;
use yii\helpers\ArrayHelper;
use backend\modules\filter\models\Filter;

class TourPageController extends BaseController {

    public $limit = 11;

    public function actionIndex() {
        $id = Yii::$app->request->get('id');
        $template = ['exotic_page', 'hot_page', 'sale_page'];
        $page_info = Page::find()
                ->where(['slug_id' => $id])
                ->asArray()
                ->with([
                    'pageMetas',
                    'pageText' => function(ActiveQuery $query) {
                        $query->indexBy('name');
                    }
                ])
                ->one();
        if ($page_info['status'] == 0) {
            throw new \yii\web\HttpException(404);
        }
        if (array_search($page_info['pageText']['data_type']['text'], $template) === FALSE) {
            die('Не верно задан тип данных');
        }
        Yii::$app->view->title = $page_info['pageMetas']['title'];
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $page_info['pageMetas']['keywords']
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $page_info['pageMetas']['description']
        ]);
        $this->renderBreadcrumbs([
            ['href' => Url::to('/', TRUE), 'name' => 'Главная'],
            ['href' => Url::to(Yii::$app->request->url, TRUE), 'name' => $page_info['title']]
        ]);
        $tours = $this->getToursByType($page_info['pageText']['data_type']['text']);
        $filter['type'] = Filter::find()->select(['alias'])->where(['link' => $page_info['pageText']['filter']['text']])->asArray()->one()['alias'];
        $filter['link'] = $page_info['pageText']['filter']['text'];
        return $this->render('index', [
                    'page_info' => $page_info,
                    'tours' => $tours,
                    'type_page' => $page_info['pageText']['data_type']['text'],
                    'filter' => $filter
        ]);
    }

    public function actionNextPage() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $tours = $this->getToursByType($data['type'], $data['page']);
            return Json::encode([
                        'content' => $this->renderPartial('_block_hotels', [
                            'tours' => $tours
                        ]),
                        'page' => ($data['page'] + 1),
                        'count' => Tour::find()->where(['!=', $data['type'], 0])->andWhere(['status' => '1'])->count()
            ]);
        }
    }

    private function getToursByType($type, $offset = 0) {
        $type_food = ArrayHelper::map(TypeFood::find()->asArray()->all(), 'id', 'name');
        $tour = Tour::find()->where(['!=', $type, 0])->andWhere(['status' => '1'])
                        ->with('hotel')
                        ->with('deptCity')
                        ->with('hotel.category')
                        ->with('hotel.cites')
                        ->with('hotel.countries')
                        ->with('hotel.address')
                        ->with('hotel.hotelService')
                        ->orderBy([$type => SORT_ASC])->asArray()->limit($this->limit)->offset((($offset > 0) ? $offset *= $this->limit : $offset))->orderBy(['id' => SORT_DESC])->all();
        foreach ($tour as $key => $item) {
            $media = Mediafile::find()->select(['url', 'alt'])->where(['id' => $item['hotel']['media_id']])->asArray()->one();
            if (!isset($media['url'])) {
                $media = ['url' => 'img/logo_no_photo.png', 'alt' => ''];
            }
            if (is_array($item['hotel']['hotelService'])) {
                shuffle($item['hotel']['hotelService']);
                $tour[$key]['hotelService'] = array_slice($item['hotel']['hotelService'], 0, 6);
            }
            $tour[$key]['hotel']['media'] = $media;
            $tour[$key]['description'] = 'город отправления ' .
                    $tour[$key]['deptCity']['name'] . ' ' .
                    Yii::$app->formatter->asDate($tour[$key]['date_departure'], 'php:d.m.Y') . ', ' .
                    $tour[$key]['length'] . ' ' . $this->num2word($tour[$key]['length'], array('ночь', 'ночи', 'ночей')) .
                    ', питание ' . $type_food[$tour[$key]['type_food_id']] .
                    ', цена указана за 2 человека';
            $tour[$key]['description_list'] = [
                ['key' => 'перелет', 'value' => 'Из ' . $tour[$key]['deptCity']['name']],
                ['key' => 'дата вылета', 'value' => Yii::$app->formatter->asDate($tour[$key]['date_departure'], 'php:d.m.Y')],
                ['key' => 'ночей в туре', 'value' => $tour[$key]['length'] . ' ' . $this->num2word($tour[$key]['length'], array('ночь', 'ночи', 'ночей'))],
                ['key' => 'проживание', 'value' => 'Standard Room'],
                ['key' => 'трансфер', 'value' => 'А/п - отель - а/п'],
                ['key' => 'туристы', 'value' => '2 взр.']
            ];
            $tour[$key]['link'] = Url::to([
                        '/tour/' . $tour[$key]['hotel']['countries']['alias'] . '/' .
                        $tour[$key]['hotel']['cites']['alias'] . '/' .
                        $tour[$key]['hotel']['alias'],
                        'id' => $tour[$key]['id'],
                        'date_begin' => Yii::$app->formatter->asDate($tour[$key]['date_begin'], 'php:Y-m-d'),
                        'date_end' => Yii::$app->formatter->asDate($tour[$key]['date_end'], 'php:Y-m-d')
                            ], TRUE);
        }
        return $tour;
    }

}
