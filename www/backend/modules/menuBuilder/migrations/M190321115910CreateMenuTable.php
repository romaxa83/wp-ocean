<?php

namespace backend\modules\menuBuilder\migrations;

use yii\db\Migration;

/**
 * Class M190321115910CreateMenuTable
 */
class M190321115910CreateMenuTable extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%menu}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'name' => $this->string(25)->notNull(),
                'label' => $this->string()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%menu}}');
    }
}
