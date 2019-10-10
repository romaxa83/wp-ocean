<?php

namespace backend\modules\menuBuilder\migrations;

use yii\db\Migration;

/**
 * Class M190321120529CreateMenuItemTable
 */
class M190321120529CreateMenuItemTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%menu_item}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'menu_id' => $this->integer()->unsigned()->notNull(),
                'parent_id' => $this->integer()->unsigned()->defaultValue(0),
                'type' => $this->string()->notNull(),
                'title' => $this->string()->notNull(),
                'data' => $this->string(),
                'position' => $this->integer()->unsigned()->notNull(),
                'status' => $this->tinyInteger()->defaultValue(0),
            ],
            $tableOptions
        );

        $this->createIndex(
            'idx-parent_position',
            '{{%menu_item}}',
            ['parent_id', 'position']
        );

        $this->createIndex(
            'idx-menu_item-parent_id',
            '{{%menu_item}}',
            'parent_id'
        );

        $this->createIndex(
            'idx-menu_item-menu_id',
            '{{%menu_item}}',
            'menu_id'
        );

        $this->addForeignKey(
            'fk-menu_item-menu_id',
            '{{%menu_item}}',
            'menu_id',
            '{{%menu}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-menu_item-menu_id',
            '{{%menu_item}}'
        );

        $this->dropIndex(
            'idx-menu_item-parent_id',
            '{{%menu_item}}'
        );

        $this->dropIndex(
            'idx-parent_position',
            '{{%menu_item}}'
        );
        $this->dropTable('{{%menu_item}}');
    }
}
