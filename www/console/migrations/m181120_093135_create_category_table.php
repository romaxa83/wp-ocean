<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m181120_093135_create_category_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'name' => $this->string(),
            'status' => $this->boolean()
        ]);
        Yii::$app->db->createCommand()->batchInsert('category', ['code', 'name', 'status'], [
            ['one', '1*', TRUE],
            ['two', '2*', TRUE],
            ['three', '3*', TRUE],
            ['four', '4*', TRUE],
            ['five', '5*', TRUE]
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('category');
    }

}
