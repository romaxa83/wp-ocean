<?php

namespace console\controllers;

use backend\modules\filemanager\models\Mediafile;
use backend\modules\referenceBooks\models\Hotel;
use Yii;
use yii\console\Controller;
use yii\db\Query;
use yii\imagine\Image;
use yii\helpers\Json;

class SetWaterMarkController extends Controller {

    public function actionStart($hotel_limit = 10, $newly = false) {
        if (Yii::$app->cache->exists('hotel_water_mark_offset') && !$newly) {
            $offset = Yii::$app->cache->get('hotel_water_mark_offset');
        }
        else {
            Yii::$app->cache->set('hotel_water_mark_offset', 0);
            $offset = 0;
        }

        if ($offset > Hotel::find()->count()) {
            Yii::$app->cache->set('hotel_water_mark_offset', 0);
            echo 'Records in the database ended, offset value on cache was cleaned' . PHP_EOL;
            exit();
        }

        $hotels = (new Query())
            ->select(['gallery'])
            ->from('hotel')
            ->limit($hotel_limit)
            ->offset($offset)
            ->all();


        foreach ($hotels as $hotel) {
            $gallery_array = json_decode($hotel['gallery']);

            $media = Mediafile::find()->select(['url'])->where(['id' => $gallery_array])->asArray()->all();

            foreach ($media as $m) {
                $file = Yii::getAlias('@backend') . '/web/' . $m['url'];

                $new_filename = self::getOrigin($file);

                if (!file_exists($file)) {
                    continue;
                } else {
                    $str_exec = 'jpeginfo -c ' . $file;
                    $result = exec($str_exec);
                    if(strpos($result, 'ERROR')) {
                        continue;
                    }
                    if (!file_exists($new_filename)) {
                        if (!copy($file, $new_filename)) {
                            echo "Could not copy $file" . PHP_EOL;
                        }
                    } else {
                        continue;
                    }
                }

                $mark = Yii::getAlias('@frontend') . '/web/img/watermark.png';
                $image = Yii::getAlias('@backend') . '/web/' . $m['url'];
                $mark_size = getimagesize($mark);
                $image_size = getimagesize($image);
                $newImage = Image::watermark($image, $mark, [($image_size[0] - $mark_size[0] - 10), 10]);
                $newImage->save($image);
            }
        }

        $offset += $hotel_limit;
        Yii::$app->cache->set('hotel_water_mark_offset', $offset);
        Yii::$app->telegram->sendMessage([
            'chat_id' => '396140135',
            'text' => 'set-water-mark: ' . Json::encode([
                'offset' => $offset,
            ]) . ': Метод обработан за ' . sprintf('%0.5f', Yii::getLogger()->getElapsedTime()) . 'с.',
        ]);
    }

    public static function getOrigin($file) {
        $path_list = explode(DIRECTORY_SEPARATOR, $file);
        $last = $path_list[count($path_list) - 1];

        $last_list = explode('.', $last);
        $filename = $last_list[count($last_list) - 2];
        $last_list[count($last_list) - 2] = $filename . '-origin';
        $last = implode('.', $last_list);

        $path_list[count($path_list) - 1] = $last;
        return implode(DIRECTORY_SEPARATOR, $path_list);
    }
}
