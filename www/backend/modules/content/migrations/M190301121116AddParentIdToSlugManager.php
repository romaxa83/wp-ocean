<?php

namespace backend\modules\content\migrations;

use yii\db\Migration;

/**
 * Class M190301121116AddParentIdToSlugManager
 */
class M190301121116AddParentIdToSlugManager extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%slug_manager}}', 'parent_id', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%slug_manager}}', 'parent_id');
    }
}
