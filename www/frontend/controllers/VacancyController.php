<?php


namespace frontend\controllers;


use backend\models\Settings;
use backend\modules\content\models\Channel;
use backend\modules\content\models\ChannelRecord;
use backend\modules\vacancyNotification\models\VacancyNotification;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class VacancyController extends BaseController
{
    public function actionIndex($template)
    {
        $pageInfo = $this->getPageInfo();

        $vacancies = $this->getVacancies($pageInfo['id']);
        Yii::$app->view->params['vacancies'] = $vacancies;

        $this->setBreadcrumbs($pageInfo);

        $h1 = $this->getPartsOfTitle($pageInfo['channelContent']['h1']['content']);
        $sectionTitle3 = $this->getPartsOfTitle($pageInfo['channelContent']['section_title_3']['content']);
        $sectionTitle4 = $this->getPartsOfTitle($pageInfo['channelContent']['section_title_4']['content']);

        $seoData = $pageInfo['seoData'];

        return $this->render($template, [
            'h1' => $h1,
            'content' => $pageInfo['channelContent'],
            'sectionTitle3' => $sectionTitle3,
            'sectionTitle4' => $sectionTitle4,
            'vacancies' => $vacancies,
            'seoData' => $seoData
        ]);
    }

    public function actionView($template, $post_id)
    {
        $dir_path = Yii::getAlias('@backend') . '/web/uploads/cv';
        if(!is_dir($dir_path)) {
            mkdir($dir_path, 0777, true);
        }
        $channelRecordInfo = $this->getChannelRecordInfo($post_id);
        //dd($channelRecordInfo);
        if(is_null($channelRecordInfo) || $channelRecordInfo['status'] != 1) {
            throw new NotFoundHttpException ();
        }

        $this->setRecordBreadcrumbs($channelRecordInfo);

        $seoData = $channelRecordInfo['seoData'];

        $h1 = $this->getPartsOfTitle($channelRecordInfo['channelRecordContent']['title']['content']);
        $sectionTitle = $this->getPartsOfTitle($channelRecordInfo['channelRecordContent']['section_title_2']['content']);

        $vacancies = $this->getVacancies($channelRecordInfo['channel']['id'], $post_id);
        Yii::$app->view->params['vacancies'] = $this->getVacancies($channelRecordInfo['channel']['id']);
        Yii::$app->view->params['vacancy'] = $channelRecordInfo['channelRecordContent']['title']['content'];


        return $this->render($template, [
            'h1' => $h1,
            'description_part_1' => $channelRecordInfo['channelRecordContent']['description_part_1']['content'],
            'description_part_2' => $channelRecordInfo['channelRecordContent']['description_part_2']['content'],
            'subtitle_1' => $channelRecordInfo['channelRecordContent']['subtitle_1']['content'],
            'block_1' => $channelRecordInfo['channelRecordContent']['block_1']['content'],
            'subtitle_2' => $channelRecordInfo['channelRecordContent']['subtitle_2']['content'],
            'block_2' => $channelRecordInfo['channelRecordContent']['block_2']['content'],
            'subtitle_3' => $channelRecordInfo['channelRecordContent']['subtitle_3']['content'],
            'block_3' => $channelRecordInfo['channelRecordContent']['block_3']['content'],
            'subtitle_4' => $channelRecordInfo['channelRecordContent']['subtitle_4']['content'],
            'block_4' => $channelRecordInfo['channelRecordContent']['block_4']['content'],
            'experience' => $channelRecordInfo['channelRecordContent']['experience']['content'],
            'sectionTitle' => $sectionTitle,
            'vacancies' => $vacancies,
            'seoData' => $seoData
        ]);
    }

    public function actionNotificator()
    {
        $json = array();
        $applicator = new VacancyNotification();

        $applicatorInfo = Yii::$app->request->post();
        $cv = UploadedFile::getInstanceByName('cv_path');
        if($cv) {
            $dir_path = Yii::getAlias('@backend') . '/web/uploads/cv';
            if(!is_dir($dir_path)) {
                mkdir($dir_path, 0777, true);
            }
            $path = "{$dir_path}/{$cv->name}";
            $cv->saveAs($path);
            $applicatorInfo['cv_path'] = "uploads/cv/{$cv->name}";
            $full_path = "{$dir_path}/{$cv->name}";
        }

        $applicator->attributes = $applicatorInfo;

        if($applicator->validate() && $applicator->save()) {
            $template = '5ОКЕАН. Поступила заявка на вакансию ' . $applicator->vacancy;

            $message = '<h1>Заявка на вакансию "' . $applicator->vacancy . '"</h1>' .
                '<div>Имя: ' . $applicator->name . '</div>' .
                '<div>Телефон: ' . $applicator->phone . '</div>' .
                '<div>Комментарий: ' . $applicator->comment . '</div>';

            $message2 = "Заявка на вакансию {$applicator->vacancy}. " . PHP_EOL .
                "Имя: {$applicator->name}, " . PHP_EOL .
                "Телефон: {$applicator->phone}, " . PHP_EOL .
                "Комментарий: {$applicator->comment}.";

            Yii::$app->telegram->sendMessage([
                'chat_id' => '-1001415727854',
                'text' => $message2,
            ]);

            $test = Yii::$app->telegram->sendDocument([
                'chat_id' => '-1001415727854',
                'caption' => $template,
                'document' => $full_path
            ]);

            $email = explode(',',$this->getContact('email'));

            $emails = array_map(function($email) {
                return trim($email);
            }, $email);
            Yii::$app->mail->compose()
                ->setFrom(Yii::$app->params['SMTP_from'])
                ->setTo($emails)
                ->setSubject($template)
                ->setHtmlBody($message)
                ->attach(Yii::getAlias("@backend/web/{$applicator->cv_path}"))
                ->send();
            $json['status'] = true;
        } else {
            $json['status'] = false;
            $json['errors'] = $applicator->errors;
        }

        return json_encode($json);
    }

    protected function getPageInfo()
    {
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

    protected function setBreadcrumbs($pageInfo)
    {
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

    protected function setRecordBreadcrumbs($pageInfo)
    {
        $this->renderBreadcrumbs([
            [
                'href' => Url::to('/', TRUE),
                'name' => 'Главная'
            ],
            [
                'href' => Url::to(['vacancy/index', 'template' => 'vacancy-index'], true),
                'name' => $pageInfo['channel']['channelContent']['h1']['content']
            ],
            [
                'href' => Url::to(Yii::$app->request->url, TRUE),
                'name' => $pageInfo['channelRecordContent']['title']['content']
            ]
        ]);
    }

    protected function getPartsOfTitle($title)
    {
        $words = explode(' ', $title);
        $divided_title = array(
            'row_1' => $words[0],
            'row_2' => implode(' ', array_slice($words, 1))
        );

        return $divided_title;
    }

    protected function getVacancies($channel_id, $except_id = null)
    {
        $query = ChannelRecord::find()
            ->where([
                'and',
                [
                    'channel_id' => $channel_id,
                    'status' => 1,
                ]
            ])
            ->with([
                'channelRecordContent' => function(ActiveQuery $query) {
                    $query->indexBy('name');
                }
            ])
            ->asArray();

        if($except_id) {
            $query->andWhere(['!=', 'id', $except_id]);
        }

        $vacancies = $query->all();

        return $vacancies;
    }

    /**
     * @param $post_id
     * @return array|\yii\db\ActiveRecord|null
     */
    protected function getChannelRecordInfo($post_id)
    {
        $channelRecord = ChannelRecord::find()
            ->where(['id' => $post_id])
            ->with([
                'seoData',
                'channel',
                'channelRecordContent' => function (ActiveQuery $query) {
                    $query->indexBy('name');
                }
            ])
            ->asArray()
            ->one();
        return $channelRecord;
    }
}