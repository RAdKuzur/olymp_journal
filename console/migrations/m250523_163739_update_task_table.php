<?php

use yii\db\Migration;

class m250523_163739_update_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('task', 'number', $this->string(256)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('task', 'number', $this->integer()->notNull());
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250523_163739_update_task_table cannot be reverted.\n";

        return false;
    }
    */
}
