<?php

use yii\db\Migration;

class m250525_145525_score_system extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('subject_category', 'winner_score', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn('subject_category', 'prize_score', $this->integer()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('subject_category', 'winner_score');
        $this->dropColumn('subject_category', 'prize_score');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250525_145525_score_system cannot be reverted.\n";

        return false;
    }
    */
}
