<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_int_passport`.
 */
class m181116_115107_create_user_int_passport_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_int_passport}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'sex' => $this->integer(1),
            'birthday' => $this->date(),
            'series' => $this->string(5),
            'number' => $this->integer(),
            'issued' => $this->string(1000),
            'issued_date' => $this->date(),
            'expired_date' => $this->date(),
            'verify' => $this->boolean()->defaultValue(false),
            'media_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_int_passport}}');
    }
}
