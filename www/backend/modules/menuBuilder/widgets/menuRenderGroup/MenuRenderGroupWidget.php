<?php


namespace backend\modules\menuBuilder\widgets\menuRenderGroup;


use Yii;
use yii\base\Widget;

class MenuRenderGroupWidget extends Widget
{
    public $template;
    public $group;
    public $currentUrl;

    public function init()
    {
        parent::init();

        $this->currentUrl = Yii::$app->request->url;
    }

    public function run()
    {
        if($this->group['status'] == 1 && !empty($this->group['children'])) {
            return $this->render($this->template, [
                'group' => $this->group,
                'currentUrl' => $this->currentUrl
            ]);
        }
       return null;
    }
}
