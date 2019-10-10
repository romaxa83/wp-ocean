<?php

namespace backend\modules\content\migrations;

use yii\db\Migration;

/**
 * Class M190305123816AddPostId
 */
class M190305123816AddPostId extends Migration
{
    public function up()
    {
        $this->addColumn('{{%slug_manager}}', 'post_id', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%slug_manager}}', 'post_id');
    }
}
