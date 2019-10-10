<?php

use yii\db\Migration;

/**
 * Class m190724_114927_change_admin_password
 */
class m190724_114927_change_admin_password extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('UPDATE user SET password_hash=\'' . Yii::$app->security->generatePasswordHash('UJz5hlj4CYgpce') . '\' WHERE username = \'admin\';');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
