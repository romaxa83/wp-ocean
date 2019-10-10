<?php

use yii\db\Migration;

/**
 * Class m190504_104432_added_fields_recommend_hot_to_tour
 */
class m190504_104432_added_fields_recommend_hot_to_tour extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('{{%tour}}', 'recommend', $this->integer());
        $this->addColumn('{{%tour}}', 'hot', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn('{{%tour}}', 'recommend');
        $this->dropColumn('{{%tour}}', 'hot');
    }

}
