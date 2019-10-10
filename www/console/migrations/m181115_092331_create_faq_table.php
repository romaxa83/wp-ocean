<?php

use yii\db\Migration;

/**
 * Handles the creation of table `faq`.
 */
class m181115_092331_create_faq_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%faq}}', [
            'id' => $this->primaryKey(),
            'question' => $this->string(1000)->notNull(),
            'answer' => $this->text()->notNull(),
            'page_faq' => $this->boolean(),
            'rate_faq' => $this->integer()->defaultValue(0),
            'page_vip' => $this->boolean(),
            'rate_vip' => $this->integer()->defaultValue(0),
            'page_exo' => $this->boolean(),
            'rate_exo' => $this->integer()->defaultValue(0),
            'page_hot' => $this->boolean(),
            'rate_hot' => $this->integer()->defaultValue(0),
            'status' => $this->boolean(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%faq}}');
    }
}
