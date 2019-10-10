<?php


namespace console\controllers;


use Yii;
use yii\console\Controller;
use backend\modules\filemanager\models\Mediafile;

class CheckHotelImgIsExistController extends Controller {
    public function actionParse($limit = 10) {

        $hotels_with_incorrect_imgs = [];

        if (Yii::$app->cache->exists('hotel_img_is_exist_offset')) {
            $offset = Yii::$app->cache->get('hotel_img_is_exist_offset');
        } else {
            Yii::$app->cache->set('hotel_img_is_exist_offset', 0);
            $offset = 0;
        }

        $hotels = (new \yii\db\Query())
            ->select(['id', 'gallery'])
            ->from('hotel')
            ->limit($limit)
            ->offset($offset)
            ->all();

        $pattern = '/(?=.*[0-9])/';

        foreach ($hotels as $hotel) {
            $gallery_array = json_decode($hotel['gallery']);

            if (isset($gallery_array[0]) or !empty($gallery_array[0])){
                if (!boolval(preg_match($pattern, $gallery_array[0]))) {
                    $hotels_with_incorrect_imgs[] = $hotel['id'];
                    continue;
                }
            } else {
                $hotels_with_incorrect_imgs[] = $hotel['id'];
                continue;
            }

            foreach ($gallery_array as $mediafile_id){
                $isExist = Mediafile::find()->where(['id' => $mediafile_id])->exists();
                if (!$isExist){
                    $hotels_with_incorrect_imgs[] = $hotel['id'];
                    break;
                }

                $mediafile = (new \yii\db\Query())
                    ->select(['id', 'size', 'url'])
                    ->from('filemanager_mediafile')
                    ->where(['id' => $mediafile_id])
                    ->one();

                if ($mediafile['size'] <= 0) {
                    $hotels_with_incorrect_imgs[] = $hotel['id'];
                    break;
                }

                $file = Yii::getAlias('@backend') . '/web/' . $mediafile['url'];
                if (!file_exists($file)) {
                    $hotels_with_incorrect_imgs[] = $hotel['id'];
                    break;
                }
            }
        }

        if (Yii::$app->cache->exists('hotels_without_imgs')) {
            $old_data = Yii::$app->cache->get('hotels_without_imgs');
            $data = array_merge($old_data, $hotels_with_incorrect_imgs);
            Yii::$app->cache->set('hotels_without_imgs', $data);
        } else {
            Yii::$app->cache->set('hotels_without_imgs', $hotels_with_incorrect_imgs);
        }

        $offset += $limit;
        Yii::$app->cache->set('hotel_img_is_exist_offset', $offset);
    }
}