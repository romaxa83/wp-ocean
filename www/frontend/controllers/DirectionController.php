<?php

namespace frontend\controllers;

use backend\modules\blog\entities\Post;
use backend\modules\content\models\Channel;
use backend\modules\content\models\ChannelCategory;
use backend\modules\content\models\ChannelRecord;
use backend\modules\filemanager\models\Mediafile;
use backend\modules\referenceBooks\models\Country;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use backend\modules\referenceBooks\models\Tour;
use yii\helpers\ArrayHelper;
use backend\modules\referenceBooks\models\TypeFood;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;

class DirectionController extends BaseController {

    const COUNTRIES_PER_PAGE = 9;

    public function actionIndex($template) {
        $pageInfo = $this->getPageInfo();

        $this->setBreadcrumbs($pageInfo);

        $data['seoData'] = $pageInfo['seoData'];

        $data['h1'] = $this->getPartsOfTitle($pageInfo['channelContent']['h1']['content']);
        $data['sectionTitle2'] = $this->getPartsOfTitle($pageInfo['channelContent']['section_title_2']['content'], 2);
        $data['sectionTitle3'] = $this->getPartsOfTitle($pageInfo['channelContent']['section_title_3']['content']);
        $data['sectionContent3'] = $pageInfo['channelContent']['section_content_3']['content'];
        $data['sectionTitle4'] = $this->getPartsOfTitle($pageInfo['channelContent']['section_title_4']['content']);

        $data['channelId'] = $pageInfo['id'];

        $data['cards'] = $this->getCountriesPreview($pageInfo['id'], self::COUNTRIES_PER_PAGE);

        $data['categories'] = ChannelCategory::getActiveCategories($pageInfo['id']);

        $popularCategory = $pageInfo['channelContent']['popular_category']['content'];
        $data['popularCountries'] = $this->getCountriesPreview($pageInfo['id'], 9, 1, $popularCategory);
        $data['countryCodes'] = Json::encode([]);
        if (isset($data['cards']['cards'])){
            $cCodes = [];
            foreach ($data['cards']['cards'] AS $item) {
                $cCodes[$item['countryCodes']['code']] = $item['countryCodes'];
            }
            $data['countryCodes'] = ArrayHelper::index(Country::find()->select(['alpha_2_code AS code', 'alias'])->where(['not', ['alpha_2_code' => null]])->asArray()->all(), 'code');
            $data['countryCodes'] = Json::encode(array_values(array_merge($data['countryCodes'], $cCodes)));
        }
        return $this->render('index', $data);
    }

    public function actionView($template, $post_id) {
        $channelRecordInfo = $this->getChannelRecordInfo($post_id);

        if(is_null($channelRecordInfo) || $channelRecordInfo['status'] != 1) {
            throw new NotFoundHttpException ();
        }

        $this->setRecordBreadcrumbs($channelRecordInfo);

        $countryApiId = $channelRecordInfo['channelRecordContent']['api_country_id']['content'];

        Yii::$app->session->set('current_country_id',$countryApiId);

        $data['blogRecords'] = Post::find()
                ->where([
                    'and',
                    ['country_id' => $countryApiId],
                    ['status' => 1]
                ])
                ->asArray()
                ->all();

        $data['seoData'] = $channelRecordInfo['seoData'];

        $background = Mediafile::getFileById($channelRecordInfo['channelRecordContent']['background']['content']);
        $data['filterBackground'] = isset($background['url']) ? $background['url'] : '';

        $data['h1'] = $channelRecordInfo['channelRecordContent']['h1']['content'];
        $data['sectionTitle1'] = $this->getPartsOfTitle($channelRecordInfo['channelRecordsCommonField']['section_title_1']['content'], 2);
        $data['hotToursTitle'] = $this->getPartsOfTitle($channelRecordInfo['channelRecordContent']['hot_tours_title']['content']);
        $data['bestResortsTitle'] = $this->getPartsOfTitle($channelRecordInfo['channelRecordContent']['best_resorts_title']['content']);
        $data['tabInformationTitle'] = $this->getPartsOfTitle($channelRecordInfo['channelRecordsCommonField']['tab_information_title']['content']);
        $data['formTitle'] = $this->getPartsOfTitle($channelRecordInfo['channelRecordsCommonField']['form_title']['content'], 2);
        $data['blogTitle'] = $this->getPartsOfTitle($channelRecordInfo['channelRecordContent']['information_in_blog']['content'], 2);
        $data['seoTextTitle'] = $this->getPartsOfTitle($channelRecordInfo['channelRecordContent']['seo_text_title']['content']);
        $data['seoText'] = $channelRecordInfo['channelRecordContent']['seo_text']['content'];
        $data['tabInformation'] = unserialize($channelRecordInfo['channelRecordContent']['tab_information']['content']);
        $data['resorts'] = unserialize($channelRecordInfo['channelRecordContent']['resorts']['content']);
        $data['recommend_tour'] = $this->getTourByType('recommend', $countryApiId);
        $data['hot_tour'] = $this->getTourByType('hot', $countryApiId);
        return $this->render('country', $data);
    }

    private function getTourByType($type, $country_id) {
        $type_food = ArrayHelper::map(TypeFood::find()->asArray()->all(), 'id', 'name');
        $country_id = Country::find()->select(['cid'])->where(['id' => $country_id])->asArray()->one()['cid'];
        $tour = Tour::find()->where(['!=', $type, 0])->andWhere(['status' => '1'])
            ->with('hotel')
            ->with('deptCity')
            ->with('hotel.category')
            ->with('hotel.cites')
            ->with('hotel.countries')
            ->with('hotel.address')
            ->orderBy([$type => SORT_ASC])->asArray()->all();
        foreach ($tour as $k => $v) {
            if (!($v['hotel']["cites"]["country_id"] === $country_id)) {
                unset($tour[$k]);
            }
        }
        foreach ($tour as $key => $item) {
            $media = Mediafile::find()->select(['url', 'alt'])->where(['id' => $item['hotel']['media_id']])->asArray()->one();
            if (!isset($media['url'])) {
                $media = [
                    'url' => 'img/logo_no_photo.png',
                    'alt' => '',
                ];
            }
            $tour[$key]['hotel']['media'] = $media;
            $tour[$key]['description'] = 'город отправления ' .
                    $tour[$key]['deptCity']['name'] . ' ' .
                    Yii::$app->formatter->asDate($tour[$key]['date_begin'], 'php:d.m.Y') . ', ' .
                    $tour[$key]['length'] . ' ' . $this->num2word($tour[$key]['length'], array('ночь', 'ночи', 'ночей')) .
                    ', питание ' . $type_food[$tour[$key]['type_food_id']] .
                    ', цена указана за 2 человека';
            $tour[$key]['link'] = Url::to([
                        '/tour/' . $tour[$key]['hotel']['countries']['alias'] . '/' .
                        $tour[$key]['hotel']['cites']['alias'] . '/' .
                        $tour[$key]['hotel']['alias'],
                        'id' => $tour[$key]['id'],
                        'date_begin' => Yii::$app->formatter->asDate($tour[$key]['date_begin'], 'php:Y-m-d'),
                        'date_end' => Yii::$app->formatter->asDate($tour[$key]['date_end'], 'php:Y-m-d')
                            ], TRUE);
            //$tour[$key]['review'] = $this->getHotelReview([$item['hotel']['id']]);
        }
        return $tour;
    }

    public function actionCountriesByCategory() {
        $params = Yii::$app->request->post();

        $cards = $this->getCountriesPreview($params['channelId'], self::COUNTRIES_PER_PAGE, $params['pageNumber'], $params['categoryId']);

        if (!empty($cards['cards'])) {
            $countries = $this->renderPartial('countries-by-category', compact('cards'));
        } else {
            $countries = $this->renderPartial('no-countries');
        }

        $result = array(
            'cards' => $countries,
            'pageCount' => $cards['pageCount']
        );

        return json_encode($result);
    }

    protected function getPageInfo() {
        $id = Yii::$app->request->get('id');

        $pageInfo = Channel::find()
                ->where(['route_id' => $id])
                ->with([
                    'seoData',
                    'channelContent' => function(ActiveQuery $query) {
                        $query->indexBy('name');
                    }
                ])
                ->asArray()
                ->one();

        return $pageInfo;
    }

    protected function getChannelRecordInfo($post_id) {
        $channelRecord = ChannelRecord::find()
                ->where(['id' => $post_id])
                ->with([
                    'seoData',
                    'channelRecordsCommonField',
                    'channel',
                    'channelRecordContent' => function (ActiveQuery $query) {
                        $query->indexBy('name');
                    }
                ])
                ->asArray()
                ->one();
        return $channelRecord;
    }

    protected function getCountriesPreview($channelId, $limit = 9, $page = 1, $categoryId = null) {
        $countriesCount = $this->countCountriesForCategory($channelId, $categoryId);

        if ($countriesCount == 0)
            return ['pageCount' => 0];

        $query = ChannelRecord::find()
                ->where([
                    'and',
                    ['channel_record.channel_id' => $channelId],
                    ['channel_record.status' => 1]
                ])
                ->with([
                    'slugManager',
                    'channelRecordContent' => function(ActiveQuery $query) {
                        $query->indexBy('name');
                    }
                ])
                ->limit($limit)
                ->offset($limit * ((int) $page - 1))
                ->asArray();

        if ($categoryId && $categoryId != 'all' && $categoryId != 0) {
            $query->joinWith(['channelCategories cat'], true, 'INNER JOIN')
                    ->andWhere(['cat.id' => $categoryId]);
        }

        $pages = $query->all();

        $countriesId = array();
        $countryInfo = array();

        foreach ($pages as $page) {
            $countryId = $page['channelRecordContent']['api_country_id']['content'];
            $countriesId[$countryId] = $countryId;
            $countryInfo[$countryId] = array(
                'cover_id' => $page['cover_id'],
                'url' => Url::to(['direction/view', 'template' => 'direction', 'post_id' => $page['id']], true),
                'country_slug' => $page['slugManager']['slug']
            );
        }

        $cards = Country::find()
                ->where(['in', 'id', $countriesId])
                ->with(['city'])
                ->asArray()
                ->indexBy('id')
                ->all();

        $countryCards = array();
        foreach ($cards as $key => $card) {
            $cities = implode(', ', array_map(function($city) {
                        return $city['name'];
                    }, array_slice($card['city'], 0, 18)));
            $card['cities'] = $cities;
            $countryInfo[$key]['countryCodes'] = ['code' => $card['alpha_2_code'], 'alias' => $countryInfo[$key]['country_slug']];
            $countryCards[] = array_merge($card, $countryInfo[$key]);
        }

        return array(
            'cards' => $countryCards,
            'pageCount' => $countriesCount / $limit,
        );
    }

    protected function setBreadcrumbs($pageInfo) {
        $this->renderBreadcrumbs([
            [
                'href' => Url::to('/', TRUE),
                'name' => 'Главная'
            ],
            [
                'href' => Url::to(Yii::$app->request->url, TRUE),
                'name' => $pageInfo['channelContent']['h1']['content']
            ]
        ]);
    }

    protected function setRecordBreadcrumbs($information) {
        $this->renderBreadcrumbs([
            [
                'href' => Url::to('/', TRUE),
                'name' => 'Главная'
            ],
            [
                'href' => Url::to(['direction/index', 'template' => 'directions'], true),
                'name' => $information['channel']['channelContent']['h1']['content']
            ],
            [
                'href' => Url::to(Yii::$app->request->url, TRUE),
                'name' => $information['channelRecordContent']['h1']['content']
            ]
        ]);
    }

    protected function getPartsOfTitle($title, $firstLine = 1) {
        $words = explode(' ', $title);
        $divided_title = array(
            'row_1' => implode(' ', array_slice($words, 0, $firstLine)),
            'row_2' => implode(' ', array_slice($words, $firstLine))
        );

        return $divided_title;
    }

    /**
     * @param $channelId
     * @param $categoryId
     * @return int|string
     */
    protected function countCountriesForCategory($channelId, $categoryId) {
        $countriesCountQuery = ChannelRecord::find()
                ->where(['channel_record.channel_id' => $channelId])
                ->with([
            'slugManager',
            'channelRecordContent' => function (ActiveQuery $query) {
                $query->indexBy('name');
            }
        ]);

        if ($categoryId && $categoryId != 'all') {
            $countriesCountQuery->joinWith(['channelCategories cat'], true, 'INNER JOIN')
                    ->andWhere(['cat.id' => $categoryId]);
        }

        $countriesCount = $countriesCountQuery->count();
        return $countriesCount;
    }

}
