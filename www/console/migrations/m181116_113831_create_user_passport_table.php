<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_passport`.
 */
class m181116_113831_create_user_passport_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_passport}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'patronymic' => $this->string(),
            'birthday' => $this->date(),
            'series' => $this->string(5),
            'number' => $this->integer(),
            'issued' => $this->string(1000),
            'issued_date' => $this->date(),
            'verify' => $this->boolean()->defaultValue(false),
            'media_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_passport}}');
    }
}
