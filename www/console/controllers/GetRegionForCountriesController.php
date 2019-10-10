<?php


namespace console\controllers;

use backend\modules\referenceBooks\models\Country;
use backend\modules\referenceBooks\models\Region;
use GuzzleHttp\Exception\RequestException;
use Yii;
use yii\console\Controller;

class GetRegionForCountriesController extends Controller {
    public function actionParse($limit = 10) {

        if (Yii::$app->cache->exists('get_region_for_countries_offset')) {
            $offset = Yii::$app->cache->get('get_region_for_countries_offset');
        }
        else {
            Yii::$app->cache->set('get_region_for_countries_offset', 0);
            $offset = 0;
        }

        $countries = (new \yii\db\Query())
            ->select(['id', 'alpha_3_code', 'region_id'])
            ->from('country')
            ->limit($limit)
            ->offset($offset)
            ->all();

        foreach ($countries as $country) {
            if (isset($country['alpha_3_code']) or !empty($country['alpha_3_code'])) {
                if (!isset($country['region_id']) or empty($country['region_id'])) {
                    $data = $this->curl($country['alpha_3_code']);

                    $c_model = Country::find()->where(['alpha_3_code' => $country['alpha_3_code']])->one();

                    $region = $data['region'];

                    if ($region === 'Americas') {
                        $region = $this->splitAmericas($data['subregion']);
                    }

                    if (!isset($region)){
                        continue;
                    }

                    $r_model = Region::find()->where(['name' => $region])->one();


                    if (!isset($r_model)) {
                        continue;
                    }

                    Yii::$app->db->createCommand()->update(
                        'country',
                        ['region_id' => $r_model['id']],
                        "id = {$c_model['id']}")->execute();
                }
            }
        }

        $offset += $limit;
        Yii::$app->cache->set('get_region_for_countries_offset', $offset);
    }

    private function curl($alpha_3_code) {
        try {
            for ($i = 0; $i < 10; $i++) {
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, "https://restcountries.eu/rest/v2/alpha/{$alpha_3_code}");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $data = curl_exec($ch);

                if ($data === FALSE) {
                    curl_close($ch);
                    continue;
                }

                $data = json_decode($data, true);
                curl_close($ch);
                break;
            }
            return $data;

        } catch (RequestException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    private function splitAmericas($subregion) {
        $SOUTH = 'South America';
        $NORTH = 'North America';

        if ($subregion === $SOUTH) {
            return $subregion;
        }
        elseif ($subregion === $NORTH) {
            return $subregion;
        }
        elseif ($subregion === 'Caribbean') {
            return $NORTH;
        }
        elseif ($subregion === 'Central America') {
            return $NORTH;
        }
        elseif ($subregion === 'Northern America') {
            return $NORTH;
        }
        else return null;
    }
}