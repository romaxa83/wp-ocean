<?php


namespace console\models\sitemap;

use yii\helpers\Url;
use backend\modules\blog\entities\Post;
use demi\sitemap\interfaces\Basic;


class SitemapPost extends Post implements Basic {
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
            // site/index
            [
                'loc' => Url::to(['/site/index']),
                'lastmod' => time(),
                'changefreq' => static::CHANGEFREQ_DAILY,
                'priority' => static::PRIORITY_10,
            ],
            // blog
            [
                'loc' => Url::to(['/blog']),
                'lastmod' => time(),
                'changefreq' => static::CHANGEFREQ_DAILY,
                'priority' => static::PRIORITY_10,
            ],

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
            ->select(['published_at', 'updated_at', 'alias', 'media_id'])
            ->where(['status' => 1])
            ->orderBy(['published_at' => SORT_DESC]);
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLoc($lang = null) {
        // Return absolute url to Post model view page
        return Url::to(["/blog/post/$this->alias"], true);
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLastmod($lang = null) {
        return $this->updated_at;
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
