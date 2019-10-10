<?php

namespace backend\modules\user\widgets\smartMailing;

use backend\modules\user\repository\SmartMailingRepository;
use yii\base\Widget;
use backend\modules\user\forms\SmartMailingForm;

class SmartMailingWidget extends Widget
{
    /*
     * template указывает какая форма будет подгружена
     * варианты :
     */
    public $template;
    public $user_id;
    public $for_admin = false;

    private $smart_repository;

    public function __construct(SmartMailingRepository $smart_rep ,array $config = [])
    {
        parent::__construct($config);
        $this->smart_repository = $smart_rep;
    }

    public function init()
    {
        parent::init();

        \Yii::setAlias('@smartMailing-widget-assets',  \Yii::getAlias('@backend').'/modules/user/widgets/smartMailing/assets');

        SmartMailingWidgetAsset::register(\Yii::$app->view);
    }

    public function run()
    {
        $file = __DIR__ . '/views/' . $this->template . '.php';
        if (!file_exists($file)) {
            return 'Неверно задан параметр $template';
        }
        if($this->template == 'form'){

            return $this->render($this->template,[
                'model' => new SmartMailingForm()
            ]);
        }

        if($this->template == 'all-smart-subscription'){

            return $this->render($this->template,[
                'smarts' => $this->getAllSmartSubscription($this->user_id),
                'admin' => $this->for_admin
            ]);
        }

    }

    private function getAllSmartSubscription($user_id)
    {
        return $this->smart_repository->getAll($user_id);
    }
}
