<?php

namespace console\models\sitemap;

use backend\modules\referenceBooks\models\Country;
use demi\sitemap\interfaces\Basic;
use yii\helpers\Url;

class SitemapCountryCity extends Country implements Basic {

    public $country_alias;
    public $city_alias;

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
        return static::findBySql('SELECT `country`.`alias` AS `country_alias`, `city`.`alias` AS `city_alias` FROM city INNER JOIN country ON city.country_id = country.cid');
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLoc($lang = null) {
        $this->alias = str_replace(' ', '%20', $this->country_alias . '/' . $this->city_alias);
        // Return absolute url to Country model view page
        return Url::to(["/search/$this->alias"], true);
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLastmod($lang = null) {
        return date('Y-m-d');
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
