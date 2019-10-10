<?php

namespace frontend\controllers;

use Yii;
use backend\modules\referenceBooks\models\Hotel;
use backend\modules\filemanager\models\Mediafile;
use backend\modules\referenceBooks\models\TypeFood;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use backend\modules\referenceBooks\models\HotelReview;
use backend\modules\order\models\Order;
use backend\modules\request\models\Request;
use yii\helpers\Url;
use backend\models\Settings;
use kartik\mpdf\Pdf;
use backend\modules\referenceBooks\models\DeptCity;
use backend\modules\referenceBooks\models\Tour;

class TourController extends BaseController {

    public $discount = 0;

    public function actionIndex() {
        $get = Yii::$app->request->get();
        $this->seoRedirect($get['tour']);
        $data_api = Yii::$app->session->get('data_api');
        $data_api['checkIn'] = (isset($get['checkIn'])) ? $get['checkIn'] : $data_api['checkIn'];
        $data_api['checkTo'] = (isset($get['checkTo'])) ? $get['checkTo'] : $data_api['checkTo'];
        $data_api['length'] = (isset($get['length'])) ? $get['length'] : $data_api['length'];
        $data_api['people'] = (isset($get['people'])) ? $get['people'] : $data_api['people'];
        $data_api['deptCity'] = (isset($get['deptCity'])) ? $get['deptCity'] : $data_api['deptCity'];
        if (isset($get['id'])) {
            $hid = Tour::find()->select(['hotel_id'])->where(['id' => $get['id']])->asArray()->one()['hotel_id'];
            $get['to'] = $hid;
        } else {
            $get['to'] = Hotel::find()->select(['hid'])->where(['alias' => $get['tour']])->asArray()->one()['hid'];
        }
        if (!isset($get['to'])) {
            throw new \yii\web\HttpException(404);
        }
        $data_api['to'] = $get['to'];
        $hotel = Hotel::find()->where(['hid' => $get['to']])->with('category')->with('cites')->with('countries')->with('address')->with('hotelService')->with('blogHotelReviews')->asArray()->one();
        if ($get['to'] == NULL || $hotel === NULL || $data_api === NULL) {
            return $this->redirect('/', 301);
        }
        $hotel['gallery'] = Mediafile::find()->select(['url', 'alt'])->where(['id' => Json::decode($hotel['gallery'])])->asArray()->all();
        $hotel['hotelAllService'] = $hotel['hotelService'];
        shuffle($hotel['hotelService']);
        $hotel['hotelService'] = array_slice($hotel['hotelService'], 0, 6);
        $this->renderBreadcrumbs([
            [
                'href' => Url::to('/', TRUE),
                'name' => 'Главная'
            ], [
                'href' => Url::to('/search/' . $hotel['countries']['alias'], TRUE),
                'name' => $hotel['countries']['name']
            ], [
                'href' => Url::to('/search/' . $hotel['countries']['alias'] . '/' . $hotel['cites']['alias'], TRUE),
                'name' => $hotel['cites']['name']
            ], [
                'href' => Url::to(Yii::$app->request->url, TRUE),
                'name' => $hotel['name']
            ]
        ]);
        $special = '';
        $tour = Tour::find()->where(['status' => TRUE, 'hotel_id' => $hotel['hid']])->with([
                    'special' => function (\yii\db\ActiveQuery $query) {
                        $query->andWhere('status = 1')->andFilterWhere(['and',
                            ['<', 'from_datetime', date("Y-m-d H:i:s")],
                            ['>', 'to_datetime', date("Y-m-d H:i:s")]]);
                    },
                ])->asArray()->one();
        if ($tour !== NULL) {
            $special = (isset($tour['special']['name'])) ? $tour['special']['name'] : '';
            if (isset($get['id'])) {
                $data_api = Yii::$app->session->get('data_api');
                $data_api['deptCity'] = $tour['dept_city_id'];
                Yii::$app->session->set('data_api', $data_api);
            }
        }
        $seo = $this->setSeoMeta($hotel['id'], 'hotel');
        if ($seo === NULL) {
            $seo = $this->setTemplateMetaData();
        }

        return $this->render('index', [
                    'get' => $get,
                    'hotel' => $hotel,
                    'data_api' => $data_api,
                    'special' => $special,
                    'seo' => $seo
        ]);
    }

    public function actionGetHotelReview() {
        $id = Yii::$app->request->post('id');
        $reviews = HotelReview::find()->where(['hotel_id' => $id])->asArray()->all();
        $sum = array_sum(ArrayHelper::getColumn($reviews, 'vote'));
        $count = count($reviews);
        $avg = ($count != 0) ? number_format(($sum / $count), 1, '.', '') : 0;
        return Json::encode([
                    'review' => $this->renderPartial('_block_review', ['reviews' => $reviews]),
                    'count' => $count,
                    'format_count' => $count . ' ' . $this->num2word($count, array('отзыв', 'отзыва', 'отзывов')),
                    'avg' => floor($avg),
                    'format_avg' => $avg . ' из 10'
        ]);
    }

    public function actionGetHotelReviewInfo() {
        $id = Yii::$app->request->post('id');
        return Json::encode([
                    'review_info' => $this->renderPartial('_block_review_info', ['hotel_review' => $this->getHotelReview([$id]), 'id' => $id])
        ]);
    }

    public function actionGetInfo() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $hotel = Hotel::find()->where(['id' => $data['id']])->with('category')->with('cites')->with('countries')->with('address')->with('hotelService')->asArray()->one();
            $type_food = ArrayHelper::map(TypeFood::find()->select(['code', 'name'])->asArray()->all(), 'code', 'name');
            if (isset($data['tour_id']) && !empty($data['tour_id'])) {
                $tour = Tour::find()->where(['id' => $data['tour_id'], 'status' => TRUE])->with('food')->with('deptCity')->asArray()->one();
                $hotel['api']['offer'] = 0;
                $hotel['api']['dept'] = $tour['deptCity']['rel'];
                $hotel['api']['price'] = number_format($tour['price'], 2, '.', '');
                $hotel['api']['date_begin'] = Yii::$app->formatter->asDate($tour['date_departure'], 'php:d.m.Y'); // Дата отправления
                $hotel['api']['date_end'] = Yii::$app->formatter->asDate($tour['date_arrival'], 'php:d.m.Y'); // Дата прибытия
                $hotel['api']['length'] = $tour['length'];
                $hotel['api']['food'] = $tour['food']['name'];
                $hotel['api']['room'] = 'Standard Room';
                $hotel['api']['people'] = 2;
                $hotel['api']['children'] = 0;
                $hotel['api']['insurance'] = 'Да';
                $hotel['api']['descount_price'] = number_format($tour['price'], 2, '.', '');
                $hotel['api']['all_room'] = ['Standard Room'];
            } else {
                $data['api']['access_token'] = Yii::$app->params['apiToken'];
                $result = $this->getApiSearchData($data['api']);
                if (isset($result['hotels'])) {
                    $h = $result['hotels'][1][$hotel['hid']];
                    foreach ($result as $k => $v) {
                        $offer = 0;
                        foreach ($h['offers'] as $k => $v) {
                            $hotel['api']['all_room'][] = $v['r'];
                            if (!empty($data['api']['offerId'])) {
                                if ($k == (int) $data['api']['offerId']) {
                                    $offer = $k;
                                    break;
                                }
                            } else {
                                if ($h['p'] == $v['pl']) {
                                    $offer = $k;
                                }
                            }
                        }
                    }
                    unset($data['api']['offerId']);
                    $hotel['api']['offer'] = $offer;
                    $hotel['api']['dept'] = $result['dept']['nameRd'];
                    $hotel['api']['price'] = $h['offers'][$offer]['pl'];
                    $hotel['api']['date_begin'] = Yii::$app->formatter->asDate($h['offers'][$offer]['d'], 'php:d.m.Y');
                    $hotel['api']['date_end'] = (isset($h['offers'][$offer]['dt'])) ? Yii::$app->formatter->asDate($h['offers'][$offer]['dt'], 'php:d.m.Y') : '-';
                    $hotel['api']['length'] = $h['offers'][$offer]['n'];
                    $hotel['api']['food'] = $type_food[$h['offers'][$offer]['f']];
                    $hotel['api']['room'] = $h['offers'][$offer]['r'];
                    $hotel['api']['people'] = $h['offers'][$offer]['a'];
                    $hotel['api']['children'] = $h['offers'][$offer]['h'];
                    $hotel['api']['insurance'] = (array_search('insurance', $h['offers'][$offer]['o']) !== FALSE) ? 'Да' : 'Нет';
                    $hotel['api']['descount_price'] = round(($hotel['api']['price'] - ($hotel['api']['price'] / 100) * $this->discount), 2);
                    $hotel['api']['offers'] = $h['offers'];
                    $hotel['api']['all_room'] = array_unique($hotel['api']['all_room']);
                } else {
                    $hotel['api']['offer'] = 0;
                    $hotel['api']['dept'] = 'Киева';
                    $hotel['api']['price'] = 0;
                    $hotel['api']['date_begin'] = Yii::$app->formatter->asDate($data['api']['checkIn'], 'php:d.m.Y');
                    $hotel['api']['date_end'] = Yii::$app->formatter->asDate($data['api']['checkTo'], 'php:d.m.Y');
                    $hotel['api']['length'] = $data['api']['length'];
                    $hotel['api']['food'] = 'все включено';
                    $hotel['api']['room'] = 'Standard Room';
                    $hotel['api']['people'] = $data['api']['people'];
                    $hotel['api']['children'] = 0;
                    $hotel['api']['insurance'] = 'Да';
                    $hotel['api']['descount_price'] = 0;
                    $hotel['api']['offers'] = [];
                    $hotel['api']['all_room'] = ['Standard Room'];
                }
            }
            $content['block_info'] = $this->renderPartial('_block_info', [
                'hotel' => $hotel,
                'data_api' => $data['api']
            ]);
            $content['block_about_tour'] = $this->renderPartial('_block_about_tour', [
                'hotel' => $hotel
            ]);
            $content['all_room'] = $hotel['api']['all_room'];
            return Json::encode($content);
        }
    }

    function actionSearchOffers() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $data['checkIn'] = Yii::$app->formatter->asDate($data['checkIn'], 'php:Y-m-d');
            $data['checkTo'] = Yii::$app->formatter->asDate($data['checkTo'], 'php:Y-m-d');
            if (isset($data['food'])) {
                $data['food'] = implode(',', $data['food']);
            }
            if (isset($data['room'])) {
                if ($data['room'] == 'Все номера' || empty($data['room'])) {
                    unset($data['room']);
                }
            }
            $data['access_token'] = Yii::$app->params['apiToken'];
            $type_food = ArrayHelper::map(TypeFood::find()->select(['code', 'name'])->asArray()->all(), 'code', 'name');
            $hotel = Hotel::find()->where(['hid' => $data['to']])->with('category')->with('cites')->with('countries')->with('address')->with('hotelService')->asArray()->one();
            $hotel['discount'] = $this->discount;
            $data['length'] += 1;
            $data['lengthTo'] += 1;
            $result = $this->getApiSearchData($data);
            if (empty($result) || !isset($result)) {
                $content['no_data'] = 'Нет данных';
                return Json::encode($content);
            }
            foreach ($result as $k => $v) {
                $hotel['api']['offers'] = [];
                if (isset($result['hotels'][1][$data['to']]['offers'])) {
                    $hotel['api']['offers'] = $result['hotels'][1][$data['to']]['offers'];
                    if (isset($data['room'])) {
                        foreach ($hotel['api']['offers'] as $k => $v) {
                            if ($v['r'] != $data['room']) {
                                unset($hotel['api']['offers'][$k]);
                            }
                        }
                    }
                }
            }
            $data['length'] --;
            $data['lengthTo'] --;
            $content['info'] = '(Для ' . $data['people'] . ' взр., из <span class="deptCity">' . $result['dept']['nameRd'] . '</span>, с <b class="offer-date-in">' .
                    $data['checkIn'] . '</b> по <b class="offer-date-to">' .
                    $data['checkTo'] . '</b>, от <b class="offer-length">' .
                    $data['length'] . '</b> до <b class="offer-length-to">' .
                    $data['lengthTo'] . '</b> ночей)';
            $content['content'] = $this->renderPartial('_block_offers', [
                'hotel' => $hotel,
                'type_food' => $type_food
            ]);
            return Json::encode($content);
        }
    }

    function actionSaveOrder() {
        if (Yii::$app->request->isAjax) {
            $info = [];
            $data = Yii::$app->request->post();
            $order = new Order();
            $order->hotel_id = $data['hotel_id'];
            $order->date = date('Y-m-d H:i:s');
            $order->offer = $data['offer'];
            $order->name = $data['name'];
            $order->phone = preg_replace("/[^0-9]/", '', $data['phone']);
            $order->email = $data['email'];
            $order->comment = $data['comment'];
            $order->price = (double) $data['price'];
            $order->status = 1;
            $order->info = $data['info'];
            $order->ga_key = $this->gaParseCookie();
            $order->reCaptcha = $data['reCaptcha'];
            $info['siteKey'] = Yii::$app->params['reCaptcha']['siteKey'];
            if ($order->validate()) {
                $order->save();
                $info['type'] = 'success';
                $subject = '5ОКЕАН. Поступил новый заказ № ' . $order->id;
                $hotel = Hotel::find()->where(['hid' => $data['hotel_id']])->with('category')->with('cites')->with('countries')->with('address')->asArray()->one();
                $data['info'] = Json::decode($data['info']);
                $body = $this->renderPartial('_email_order', [
                    'data' => $data,
                    'hotel' => $hotel,
                    'link' => $_SERVER['HTTP_REFERER']
                ]);
                //'396140135' - test
                //'-1001415727854' - prod
                Yii::$app->telegram->sendMessage([
                    'chat_id' => '-1001415727854',
                    'text' => $this->renderPartial('_telegram_order', [
                        'subject' => $subject,
                        'data' => $data,
                        'link' => $_SERVER['HTTP_REFERER']
                    ]),
                ]);
                $to = explode(',', preg_replace('/\s+/', '', Json::decode(Settings::find()->where(['name' => 'contact'])->asArray()->one()['body'])[2]['value']));
                Yii::$app->mail->compose()
                        ->setFrom(Yii::$app->params['SMTP_from'])
                        ->setTo($to)
                        ->setSubject($subject)
                        ->setHtmlBody($body)
                        ->send();
            } else {
                $info['type'] = 'error';
                $info['message'] = $order->errors;
            }
            return Json::encode($info);
        }
    }

    function actionSaveRequest() {
        if (Yii::$app->request->isAjax) {
            $info = [];
            $data = Yii::$app->request->post();
            $request = new Request();
            $request->date = date('Y-m-d H:i:s');
            $request->name = $data['name'];
            $request->phone = preg_replace("/[^0-9]/", '', $data['phone']);
            $request->email = $data['email'];
            $data['comment'] = isset($data['comment']) ? $data['comment'] : '';
            $request->comment = $data['comment'];
            $request->status = 1;
            $request->ga_key = $this->gaParseCookie();
            //$request->reCaptcha = $data['reCaptcha'];
            if (isset($data['type'])) {
                $request->type = $data['type'];
                if ($data['type'] != Request::TYPE_DIRECTIONS) {
                    $request->reCaptcha = $data['reCaptcha'];
                } else {
                    $request->scenario = Request::SCENARIO_WITHOUT_CAPTCHA;
                }
            }
            $info['siteKey'] = Yii::$app->params['reCaptcha']['siteKey'];
            if ($request->validate()) {
                $request->save();
                $info['type'] = 'success';
                $subject = '5ОКЕАН. Поступила новая заявка № ' . $request->id;
                $body = $this->renderPartial('_email_request', [
                    'data' => $data,
                    'link' => $_SERVER['HTTP_REFERER']
                ]);
                //'396140135' - test
                //'-1001415727854' - prod
                Yii::$app->telegram->sendMessage([
                    'chat_id' => '-1001415727854',
                    'text' => $this->renderPartial('_telegram_request', [
                        'subject' => $subject,
                        'data' => $data,
                        'link' => $_SERVER['HTTP_REFERER']
                    ])
                ]);
                $to = explode(',', preg_replace('/\s+/', '', Json::decode(Settings::find()->where(['name' => 'contact'])->asArray()->one()['body'])[2]['value']));
                Yii::$app->mail->compose()
                        ->setFrom(Yii::$app->params['SMTP_from'])
                        ->setTo($to)
                        ->setSubject($subject)
                        ->setHtmlBody($body)
                        ->send();
            } else {
                $info['type'] = 'error';
                $info['message'] = $request->errors;
            }
            return Json::encode($info);
        }
    }

    public function actionPromotionalTour() {
        if (Yii::$app->request->isAjax) {
            $hotels = [];
            $rand_hotel = [];
            $post = Yii::$app->request->post();
            $data_api = Yii::$app->session->get('data_api');
            $data_api['deptCity'] = (isset($post['deptCity'])) ? $post['deptCity'] : '';
            $data_api['to'] = $post['cid'];
            $data_api['stars'] = (int)$post['stars'];
            $data_api['checkIn'] = (isset($post['checkIn'])) ? $post['checkIn'] : $data_api['checkIn'];
            $data_api['length'] = (isset($post['length'])) ? $post['length'] : $data_api['length'];
            $data_api['people'] = (isset($post['people'])) ? $post['people'] : $data_api['people'];
            $result = $this->getApiSearchData($data_api);
            foreach ($result as $k => $v) {
                $rand_keys = array_keys($result['hotels'][1]);
                $rand_keys = ArrayHelper::index($rand_keys, function ($element) {
                            return $element;
                        });
                $rand_keys = array_rand($rand_keys, count($rand_keys));
                foreach ($rand_keys as $v1) {
                        $rand_hotel[$v1] = [
                            'id' => $v1,
                            'price' => $result['hotels'][1][$v1]['p'],
                        ];
                }
            }
            $similar_hotels = Hotel::find()->where(['in', 'hid', array_keys($rand_hotel)])->andWhere(['category.name' => $post['stars']])->joinWith('category')->with('cites')->with('countries')->with('address')->asArray()->all();
            $hotel_review = $this->getHotelReview(ArrayHelper::getColumn($similar_hotels, 'id'));
            foreach ($similar_hotels as $k => $v) {
                $similar_hotels[$k]['price'] = $rand_hotel[$v['hid']]['price'];
                $similar_hotels[$k]['media'] = Mediafile::find()->select(['url', 'alt'])->where(['id' => $v['media_id']])->asArray()->one();
                $similar_hotels[$k]['link'] = Url::to(
                                ['/tour/' . $v['countries']['alias'] . '/' . $v['cites']['alias'] . '/' . $v['alias'],
                            'deptCity' => $data_api['deptCity'],
                            'to' => $v['hid'],
                            'checkIn' => $data_api['checkIn'],
                            'length' => $data_api['length'],
                            'people' => $data_api['people']
                                ], TRUE);
            }
            shuffle($similar_hotels);
            return $this->renderPartial('_block_promotional_tours', [
                        'similar_hotels' => $similar_hotels,
                        'hotel_review' => $hotel_review
            ]);
        }
    }

    public function actionPrint() {
        $post = Json::decode(Yii::$app->request->post('info'));
        $hotel = Hotel::find()->with('countries')->with('cites')->with('category')->with('address')->where(['id' => $post['id']])->asArray()->one();
        if ($hotel['gallery'] !== NULL) {
            $hotel['gallery'] = Json::decode($hotel['gallery']);
            $hotel['gallery'] = Mediafile::find()->where(['in', 'id', $hotel['gallery']])->asArray()->all();
        }
        $hotel['review'] = $this->getHotelReview([$hotel['id']]);
        $hotel['info'] = $post['info'];
        $hotel['about'] = $post['about'];
        $hotel['service'] = $post['service'];
        $hotel['full_price'] = $post['full_price'];
        $hotel['discount_price'] = $post['discount_price'];
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('_print_pdf', [
                'hotel' => $hotel
            ]),
            'cssFile' => '@frontend/web/css/print-pdf.css',
            'options' => ['title' => '5 Океан'],
            'methods' => [
                'SetTitle' => $hotel['name'],
                'SetHeader' => ['5 Океан'],
                'SetFooter' => ['{PAGENO}'],
            ],
        ]);
        return $pdf->render();
    }

    private function seoRedirect($alias) {
        if (preg_match('~^\p{Lu}~u', $alias)) {
            $url = explode('?', Yii::$app->request->url);
            $url[0] = mb_strtolower($url[0]);
            $url = implode('?', $url);
            return $this->redirect($url, 301);
        }
    }

    private function setTemplateMetaData() {
        $seo = [];
        $data = Yii::$app->request->get();
        $hotel = Hotel::find()->with('countries')->with('cites')->with('category')->where(['alias' => $data['tour']])->asArray()->one();
        if ($hotel !== NULL) {
            $template = $hotel['name'] . ' ' . $hotel['category']['name'] . ", " . $hotel['cites']['name'] . ", " . $hotel['countries']['name'];
            Yii::$app->view->title = "Туры в отель $template.Купить путевку онлайн";
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => "Купить тур в отель $template по выгодной цене онлайн. "
                . "Заказать путевку на отдых в $template в туркомпании Пятый Океан."
            ]);
            $seo = [
                'h1' => "Туры в отель $template",
                'seo_text' => NULL
            ];
        }
        return $seo;
    }

}
