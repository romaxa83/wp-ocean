<?php

use yii\db\Migration;

/**
 * Class m190227_085933_change_column_in_page_text
 */
class m190227_085933_change_column_in_page_text extends Migration
{
    public function up()
    {
        $this->alterColumn('page_text', 'text', $this->text());
    }

    public function down()
    {
        echo "m190227_085933_change_column_in_page_text cannot be reverted.\n";

        return false;
    }
}
