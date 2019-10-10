<?php

use yii\db\Migration;
use backend\models\Settings;

/**
 * Handles the creation of table `seo_meta`.
 */
class m181112_124523_create_seo_meta_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%seo_meta}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer(),
            'h1' => $this->string(),
            'title' => $this->string(),
            'keywords' => $this->text(),
            'description' => $this->text(),
            'seo_text' => $this->text(),
            'language' => $this->string(5),
            'parent_id' => $this->integer(),
            'alias' => $this->string(50),
        ], $tableOptions);

        $this->createIndex('{{%idx-blog_posts-seo}}','{{%blog_posts}}','seo_id');
        $this->addForeignKey('{{%fk-blog_post-seo}}','{{%blog_posts}}','seo_id','{{%seo_meta}}','id','CASCADE');

        $arr_lang = [
            [
                'status' => 1,
                'lang' => 'Русский',
                'alias' => 'ru',
            ]
        ];
        $settings = new Settings();
        $settings->name = 'set_language';
        $settings->body = serialize($arr_lang);
        $settings->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-blog_post-seo}}', '{{%blog_posts}}');
        $this->dropIndex('{{%idx-blog_posts-seo}}','{{%blog_posts}}');
        $this->dropTable('{{%seo_meta}}');

        $settings = Settings::find()->where(['name' => 'set_language'])->one();
        $settings->delete();
    }
}
