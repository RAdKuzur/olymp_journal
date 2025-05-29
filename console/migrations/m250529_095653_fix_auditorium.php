<?php

use yii\db\Migration;

class m250529_095653_fix_auditorium extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('appearance', 'auditorium', $this->string(64)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('appearance', 'auditorium', $this->integer(11)->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250529_095653_fix_auditorium cannot be reverted.\n";

        return false;
    }
    */
}
