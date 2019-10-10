<?php

namespace backend\modules\settings;

use yii\base\Module;

class Settings extends Module {

    public $controllerNamespace = 'backend\modules\settings\controllers';

    public function init() {
        parent::init();
        $this->setAliases([
            '@settings-assets' => __DIR__ . '/assets'
        ]);
    }

}
