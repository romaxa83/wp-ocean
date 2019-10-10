<?php

namespace backend\modules\user\helpers;

class ImageFromNetwork
{
    public $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function parse()
    {
        $info = $this->parseUrl($this->url);
        copy($this->url,$this->getFolder() . $info['basename']);

        $filename = $info['basename'];
        $type = mime_content_type($this->getFolder() . $info['basename']);
        $size = filesize($this->getFolder() . $info['basename']);
        $url = (explode('/web',$this->getFolder()))[1] . $info['basename'];

        return new ImageData($filename,$type,$size,$url);
    }

    /* возвращает полный путь к папке для загрузки фото (если ее нет,то создает) */
    private function getFolder() : string
    {
        $year = date('Y', time());
        $month = date('m', time());
        $path = \Yii::getAlias('@backend') . "/web/uploads/$year/$month/avatars/";
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
            chmod($path,0777);
        }

        return $path;
    }

    private function parseUrl($url)
    {
        if(strpos($url,'?')){

            $arr = explode('?',$url);
            return pathinfo($arr[0]);
        }
        return pathinfo($url);
    }
}