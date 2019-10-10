<?php


namespace console\models\sitemap;

use backend\modules\content\models\Page;
use backend\modules\content\models\SlugManager;
use Yii;
use yii\helpers\Url;
use demi\sitemap\interfaces\Basic;


class SitemapPage extends Page implements Basic {
    /**
     * Handle materials by selecting batch of elements.
     * Increase this value and got more handling speed but more memory usage.
     *
     * @var int
     */
    public $sitemapBatchSize = 10;
    /**
     * List of available site languages
     *
     * @var array [langId => langCode]
     */
    public $sitemapLanguages = [
        'en',
    ];
    /**
     * If TRUE - Yii::$app->language will be switched for each sitemapLanguages and restored after.
     *
     * @var bool
     */
    public $sitemapSwithLanguages = true;

    /* BEGIN OF Basic INTERFACE */

    /**
     * @inheritdoc
     */
    public function getSitemapItems($lang = null) {
        // Add to sitemap.xml links to regular pages
        return [
            // ... you can add more regular pages if needed, but I recommend
            // separate pages related only for current model class
        ];
    }

    /**
     * @inheritdoc
     */
    public function getSitemapItemsQuery($lang = null) {

        // Base select query for current model
        return static::find()
            ->select(['creation_date', 'modification_date', 'slug_id'])
            ->where(['status' => 1])
            ->orderBy(['creation_date' => SORT_DESC]);
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLoc($lang = null) {
        $slug = SlugManager::find()->select(['slug'])->where(['id' => $this->slug_id])->asArray()->one()['slug'];
        // Return absolute url to Tour model view page
        return Url::to(["/$slug"], true);
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLastmod($lang = null) {
        return $this->modification_date;
    }

    /**
     * @inheritdoc
     */
    public function getSitemapChangefreq($lang = null) {
        return static::CHANGEFREQ_MONTHLY;
    }

    /**
     * @inheritdoc
     */
    public function getSitemapPriority($lang = null) {
        return static::PRIORITY_8;
    }

    /* END OF Basic INTERFACE */
}

