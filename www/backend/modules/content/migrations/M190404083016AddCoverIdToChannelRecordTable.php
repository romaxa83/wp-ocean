<?php

namespace backend\modules\content\migrations;

use yii\db\Migration;

/**
 * Class M190404083016AddCoverIdToChannelRecordTable
 */
class M190404083016AddCoverIdToChannelRecordTable extends Migration
{
    public function up()
    {
        $this->addColumn('{{%channel_record}}', 'cover_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('{{%channel_record}}', 'cover_id');
    }
}
