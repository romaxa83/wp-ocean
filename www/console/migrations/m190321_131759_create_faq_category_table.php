<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%faq_category}}`.
 */
class m190321_131759_create_faq_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%faq_category}}', [
            'id' => $this->primaryKey(),
            'alias' => $this->string(100)->notNull(),
            'name' => $this->string(100)->notNull(),
            'position' => $this->integer(),
            'status' => $this->integer(1)->defaultValue(1),
            'created' => $this->integer()->notNull(),
            'updated' => $this->integer()->notNull(),
        ]);

        $this->addColumn('{{%faq}}', 'category_id', $this->integer()->after('id'));
        $this->createIndex('{{%idx-faq-faq_category}}', '{{%faq}}', 'category_id');
        $this->addForeignKey('{{%fk-faq-faq_category}}', '{{%faq}}', 'category_id', '{{%faq_category}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-faq-faq_category}}', '{{%faq}}');
        $this->dropColumn('{{%faq%}}','category_id');
        $this->dropTable('{{%faq_category}}');
    }
}
