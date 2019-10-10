<?php

use yii\db\Migration;

/**
 * Class m190314_082734_add_role_to_rbac
 */
class m190314_082734_add_role_to_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $roleAdmin = Yii::$app->authManager->createRole('admin');
        $roleAdmin->description = 'Администратор';
        Yii::$app->authManager->add($roleAdmin);
        Yii::$app->authManager->assign($roleAdmin, 1);

        $roleUser = Yii::$app->authManager->createRole('user');
        $roleUser->description = 'Пользователь';
        Yii::$app->authManager->add($roleUser);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->authManager->revokeAll(1);

        $roleAdmin = Yii::$app->authManager->getRole('admin');
        Yii::$app->authManager->remove($roleAdmin);

        $roleUser = Yii::$app->authManager->getRole('user');
        Yii::$app->authManager->remove($roleUser);
    }

}
