<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vacancy_notification}}`.
 */
class m190318_080809_create_vacancy_notification_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%vacancy_notification}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'vacancy' => $this->string()->notNull(),
            'cv_path' => $this->string()->notNull(),
            'comment' => $this->text(),
            'status' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%vacancy_notification}}');
    }
}
