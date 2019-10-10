<?php

namespace common\models;

use Yii;
use yii\helpers\Json;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use common\service\ProxyService;

class Curl {

    private static $version = 2.4;

    public static function curl($method, $url, $params = []) {
        $client = new Client([
            'base_uri' => Yii::$app->params['apiUrl'],
            'timeout' => 30.0,
            'cookie' => true,
            'proxy' => ProxyService::getProxy()
        ]);
        $params['access_token'] = Yii::$app->params['apiToken'];
        if ($method === 'GET') {
            $body = [
                'query' => $params
            ];
        }
        if ($method === 'POST') {
            $body = [
                'form_params' => $params
            ];
        }
        try {
            $link = str_replace('%2C',',', Yii::$app->params['apiUrl'] . $url . '?' . http_build_query($params));
            for ($i = 0; $i < 10; $i++) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $link);
                curl_setopt($ch, CURLOPT_HEADER, false);
                if (Yii::$app->params['proxy_enable']) {
                    curl_setopt($ch, CURLOPT_PROXY, ProxyService::getProxy());
                }
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                curl_setopt($ch, CURLOPT_USERAGENT, 'PHP');
                $data = curl_exec($ch);
                if ($data === FALSE) {
                    curl_close($ch);
                    continue;
                }
                $data = Json::decode($data);
                curl_close($ch);
                break;
            }
//            $res = $client->request($method, $url, $body);
//            $data = Json::decode($res->getBody());

            if (isset($data['api_version']) && $data['api_version'] != self::$version) {
                return ['status' => 426, 'body' => []];
            }
            if (isset($data['time'])) {
                unset($data['time']);
            }
            if (isset($data['api_version'])) {
                unset($data['api_version']);
            }
            $hash = sha1(Json::encode($data));
            return ['status' => 200, 'hash' => $hash, 'body' => $data];
        } catch (RequestException $e) {
            echo $e->getMessage();
            exit();
            return ['status' => $e->getResponse()->getStatusCode()];
        }
    }

}
