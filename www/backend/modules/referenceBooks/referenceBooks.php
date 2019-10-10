<?php

namespace backend\modules\referenceBooks;
use Yii;
use backend\modules\referenceBooks\referenceBooksAsset;
/**
 * referenceBooks module definition class
 */
class referenceBooks extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\referenceBooks\controllers';

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
        $this->setAliases([
            '@reference-books-assets' => __DIR__ . '/assets'
        ]);
        referenceBooksAsset::register(\Yii::$app->view);
    }

}
