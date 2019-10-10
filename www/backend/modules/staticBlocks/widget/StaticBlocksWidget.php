<?php

namespace backend\modules\staticBlocks\widget;

use backend\modules\staticBlocks\repository\StaticDataRepository;
use yii\base\Widget;

class StaticBlocksWidget extends Widget
{
    public $template;

    private $data;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $view = $this->template;

        switch ($this->template) {
            case 'advantage':
                $this->data = (new StaticDataRepository())->getData('advantage');
                break;

            case 'smart':
                $this->data = (new StaticDataRepository())->getData('smart');
                break;

            case 'counter':
                $this->data = (new StaticDataRepository())->getData('counter');
                break;

            case 'company':
                $this->data = (new StaticDataRepository())->getData('company');
                break;

            case 'seo':
                $this->data = (new StaticDataRepository())->getData('seo');
                break;

            default:
                throw new \DomainException('Неверно указан template,либо его не существует');
        }

        return $this->render($view,[
            'data' => $this->data
        ]);
    }
}