<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\Settings;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use common\models\Curl;
use backend\modules\referenceBooks\models\HotelReview;
use backend\modules\referenceBooks\models\SeoMeta;

class BaseController extends Controller {

    public function behaviors() {
        if (Yii::$app->request->getUrl() != '/' && substr(Yii::$app->request->getUrl(), -1) == '/') {
            $this->redirect(\yii\helpers\Url::to(substr(Yii::$app->request->getUrl(), 0, -1), TRUE), 301)->send();
        }
        $settings = Settings::find()->where(['in', 'name', ['contact', 'social']])->asArray()->all();
        $settings = ArrayHelper::index($settings, 'name');
        $settings['contact']['body'] = Json::decode($settings['contact']['body']);
        $settings['social']['body'] = Json::decode($settings['social']['body']);
        Yii::$app->view->params['settings'] = $settings;
        $contact = ArrayHelper::index(Yii::$app->view->params['settings']['contact']['body'], 'key');
        $contact['phone']['value'] = explode('/', $contact['phone']['value']);
        Yii::$app->view->params['phone'] = trim($contact['phone']['value'][0]);
        Yii::$app->view->params['phone_mask'] = preg_replace("/[^0-9]/", '', $contact['phone']['value'][0]);
        Yii::$app->view->params['phone_all'] = $contact['phone']['value'];
        Yii::$app->view->params['phone_header'] = $contact['phone_header']['value'];
        Yii::$app->view->params['phone_header_mask'] = preg_replace("/[^0-9]/", '', $contact['phone_header']['value']);
        Yii::$app->view->params['phone_footer'] = $contact['phone_footer']['value'];
        Yii::$app->view->params['phone_footer_mask'] = preg_replace("/[^0-9]/", '', $contact['phone_footer']['value']);
        if (!Yii::$app->session->has('data_api')) {
            $default_data_api = [
                "deptCity" => 1544,
                "to" => 8,
                "checkIn" => date('Y-m-d', strtotime(date('y-m-d') . "+14 days")),
                "checkTo" => date('Y-m-d', strtotime(date('y-m-d') . "+28 days")),
                "length" => 7,
                "people" => 2,
                "page" => 1,
                "access_token" => Yii::$app->params['apiToken']
            ];
            Yii::$app->session->set('data_api', $default_data_api);
        }
        $this->renderMarkForLocalBusiness();
        $this->setCanonical();
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Регистрирует мета теги
     * @param string $title
     * @param string $keywords
     * @param string $description
     */
    protected function registerSeo($title, $keywords = false, $description = false) {
        $this->view->title = $title;

        if ($keywords) {
            \Yii::$app->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $keywords
            ]);
        }

        if ($description) {
            \Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => $description
            ]);
        }
    }

    public function renderBreadcrumbs($breadcrumbs) {
        $element = [];
        foreach ($breadcrumbs as $k => $v) {
            if (isset($breadcrumbs[$k + 1])) {
                $element[] = '<li class="breadcrumb-item"><a href="' . $v['href'] . '">' . $v['name'] . '</a></li>';
            } else {
                $element[] = '<li class="breadcrumb-item active" aria-current="page">' . $v['name'] . '</li>';
            }
        }
        Yii::$app->view->params['breadcrumbs'] = '<ol class="breadcrumb">' . (implode('', $element)) . '</ol>';
        $this->renderMarkForBreadcrumbs($breadcrumbs);
    }

    private function renderMarkForBreadcrumbs($breadcrumbs) {
        $itemListElement = [];
        foreach ($breadcrumbs as $k => $v) {
            $itemListElement[] = [
                "@type" => "ListItem",
                "position" => ($k + 1),
                "item" => [
                    "@id" => $v['href'],
                    "name" => $v['name']
                ]
            ];
        }
        $content = [
            "@context" => "http://schema.org",
            "@type" => "BreadcrumbList",
            "itemListElement" => $itemListElement
        ];
        Yii::$app->view->params['MarkingForBreadcrumbs'] = Json::encode($content);
    }

    private function renderMarkForLocalBusiness() {
        $settings = Settings::find()->where(['name' => 'contact'])->asArray()->one();
        $settings['body'] = Json::decode($settings['body']);
        $settings['body'] = ArrayHelper::index($settings['body'], 'key');
        $content = [
            "@context" => "http://schema.org",
            "@type" => "LocalBusiness",
            "name" => "5 Океан",
            "image" => \yii\helpers\Url::to('/img/logo_white2.png', TRUE),
            "address" => $settings['body']['address']['value'],
            "telephone" => $settings['body']['phone']['value'],
            "priceRange" => "11 571 грн. - 70 326 грн."
        ];
        Yii::$app->view->params['LocalBusiness'] = Json::encode($content);
    }

    public function getHotelReview($hotel_id) {
        $data = [];
        $review = HotelReview::find()->where(['in', 'hotel_id', $hotel_id])->asArray()->all();
        foreach ($review as $v)
            $data['reviews'][$v['hotel_id']][] = $v;
        if (isset($data['reviews'])) {
            foreach ($data['reviews'] as $k => $v) {
                $data[$k]['summ'] = array_sum(ArrayHelper::getColumn($v, 'vote'));
                $data[$k]['count'] = count($v);
                $data[$k]['avg'] = round($data[$k]['summ'] / $data[$k]['count'], 2);
            }
        }
        return $data;
    }

    public function gaParseCookie() {
        if (isset($_COOKIE['_ga'])) {
            list($version, $domainDepth, $cid1, $cid2) = preg_split('[\.]', $_COOKIE["_ga"], 4);
            $contents = array('version' => $version, 'domainDepth' => $domainDepth, 'cid' => $cid1 . '.' . $cid2);
            $cid = $contents['cid'];
        } else {
            $cid = NULL;
        }
        return $cid;
    }

    public function getContact($option) {
        $settings = Settings::find()->where('name = "contact"')->one();
        $contacts = json_decode($settings->body);

        foreach ($contacts as $contact) {
            if ($contact->key == $option) {
                return $contact->value;
            }
        }

        return null;
    }

    public function getApiSearchData($data) {
        $body = [];
        for ($i = 0; $i < 10; $i++) {
            $curl = Curl::curl('GET', '/api/tours/search', $data);
            if ($curl['status'] === 200 && isset($curl['body']['lastResult'])) {
                if ($curl['body']['lastResult'] == true) {
                    $body = $curl['body'];
                    break;
                }
            }
            sleep(1);
        }
        return $body;
    }

    public function num2word($num, $words) {
        $num = $num % 100;
        if ($num > 19) {
            $num = $num % 10;
        }
        switch ($num) {
            case 1: {
                    return($words[0]);
                }
            case 2:
            case 3:
            case 4: {
                    return($words[1]);
                }
            default: {
                    return($words[2]);
                }
        }
    }

    protected function getSplitText($text, $limit = 0, $separator = ' ...') {
        $data = [];
        $temp = '';
        if ($limit > mb_strlen($text)) {
            $data[] = $text;
            return $data;
        }
        $box1 = mb_substr($text, 0, $limit);
        if (!empty($box1)) {
            $box1_exp = explode(' ', $box1);
            $temp = $box1_exp[count($box1_exp) - 1];
            if (!empty($temp)) {
                unset($box1_exp[count($box1_exp) - 1]);
            }
            $data[] = implode(' ', $box1_exp) . $separator;
        }
        $data[] = $temp . mb_substr($text, $limit);
        return $data;
    }

    protected function setCanonical() {
        $href = explode('?', \yii\helpers\Url::to(Yii::$app->request->getUrl(), TRUE));
        Yii::$app->view->registerLinkTag([
            'rel' => 'canonical',
            'href' => \yii\helpers\Url::to($href[0], TRUE)
        ]);
    }

    protected function setSeoMeta($id, $alias) {
        $seo = SeoMeta::find()->where(['page_id' => $id, 'alias' => $alias])->asArray()->one();
        if ($seo !== NULL) {
            Yii::$app->view->title = $seo['title'];
            Yii::$app->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $seo['keywords']
            ]);
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => $seo['description']
            ]);
        }
        return $seo;
    }

    protected function mb_ucfirst($str, $encoding = 'UTF-8') {
        $str = mb_ereg_replace('^[\ ]+', '', $str);
        $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding) .
                mb_substr($str, 1, mb_strlen($str), $encoding);
        return $str;
    }

}
