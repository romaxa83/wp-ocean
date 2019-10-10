<?php

namespace console\models\sitemap;

use backend\modules\referenceBooks\models\Hotel;
use demi\sitemap\interfaces\Basic;
use Yii;
use yii\helpers\Url;

class SitemapHotel extends Hotel implements Basic {

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
                        ->where(['status' => 1])
                        ->with('countries')
                        ->with('cites')
                        ->orderBy(['id' => SORT_DESC]);
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLoc($lang = null) {
        $country = str_replace(' ', '%20', $this->countries['alias']);
        $city = str_replace(' ', '%20', $this->cites['alias']);
        $hotel = str_replace(' ', '%20', $this->alias);
        return Url::to(['/tour/' . $country . '/' . $city . '/' . $hotel], true);
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLastmod($lang = null) {
        return $this->id;
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
