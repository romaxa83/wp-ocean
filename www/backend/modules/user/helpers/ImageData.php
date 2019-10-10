<?php

namespace backend\modules\user\helpers;

class ImageData
{
    public $filename;
    public $type;
    public $size;
    public $url;

    public function __construct($filename,$type,$size,$url)
    {
        $this->filename = $filename;
        $this->type = $type;
        $this->size = $size;
        $this->url = $url;
    }
}