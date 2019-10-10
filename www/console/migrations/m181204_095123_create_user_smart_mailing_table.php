<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_smart_mailing`.
 */
class m181204_095123_create_user_smart_mailing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_smart_mailing}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'country_id' => $this->integer()->notNull(),
            'with' => $this->date()->notNull(),
            'to' => $this->date()->notNull(),
            'persons' => $this->integer()->notNull(),
            'status' => $this->integer(1)->notNull()->defaultValue(0),
            'type_send' => $this->integer(1)->notNull()->defaultValue(0),
        ]);

        $this->createIndex('{{%idx-user-smart_mailing}}', '{{%user_smart_mailing}}', 'user_id');
        $this->createIndex('{{%idx-country-smart_mailing}}', '{{%user_smart_mailing}}', 'country_id');

        $this->addForeignKey('{{%fk-country-smart_mailing}}', '{{%user_smart_mailing}}', 'country_id', '{{%country}}', 'id');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-country-smart_mailing}}','{{%user_smart_mailing}}');

        $this->dropTable('{{%user_smart_mailing}}');
    }
}
