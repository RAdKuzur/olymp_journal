<?php

use yii\db\Migration;

class m250522_160359_init_olymp_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%school}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(1000)->notNull(),
            'region' => $this->string(1000)->notNull(),
        ], $tableOptions);

        // Subject table
        $this->createTable('{{%subject}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(1000)->notNull(),
        ], $tableOptions);

        // Participant table
        $this->createTable('{{%participant}}', [
            'id' => $this->primaryKey(),
            'surname' => $this->string(256)->notNull(),
            'name' => $this->string(256)->notNull(),
            'patronymic' => $this->string(256),
            'phone_number' => $this->string(64)->notNull(),
            'sex' => $this->integer()->notNull(),
            'birthdate' => $this->date()->notNull(),
            'citizenship' => $this->integer()->notNull(),
            'school_id' => $this->integer()->notNull(),
            'disability' => $this->integer()->notNull(),
            'class' => $this->integer()->notNull(),
        ], $tableOptions);

        // Subject category table
        $this->createTable('{{%subject_category}}', [
            'id' => $this->primaryKey(),
            'subject_id' => $this->integer()->notNull(),
            'category' => $this->integer()->notNull(),
        ], $tableOptions);

        // Application table
        $this->createTable('{{%application}}', [
            'id' => $this->primaryKey(),
            'participant_id' => $this->integer()->notNull(),
            'code' => $this->string(64)->notNull(),
            'subject_category_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // Task table
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'subject_category_id' => $this->integer()->notNull(),
            'number' => $this->integer()->notNull(),
            'max_points' => $this->integer()->notNull(),
        ], $tableOptions);

        // Appearance table
        $this->createTable('{{%appearance}}', [
            'id' => $this->primaryKey(),
            'application_id' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'auditorium' => $this->integer()->notNull(),
        ], $tableOptions);

        // Task application table
        $this->createTable('{{%task_application}}', [
            'id' => $this->primaryKey(),
            'application_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),
            'points' => $this->integer()->notNull(),
        ], $tableOptions);

        // Add foreign keys with RESTRICT
        $this->addForeignKey(
            'fk-participant-school_id',
            '{{%participant}}',
            'school_id',
            '{{%school}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-subject_category-subject_id',
            '{{%subject_category}}',
            'subject_id',
            '{{%subject}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-application-participant_id',
            '{{%application}}',
            'participant_id',
            '{{%participant}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-application-subject_category_id',
            '{{%application}}',
            'subject_category_id',
            '{{%subject_category}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-task-subject_category_id',
            '{{%task}}',
            'subject_category_id',
            '{{%subject_category}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-appearance-application_id',
            '{{%appearance}}',
            'application_id',
            '{{%application}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-task_application-application_id',
            '{{%task_application}}',
            'application_id',
            '{{%application}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-task_application-task_id',
            '{{%task_application}}',
            'task_id',
            '{{%task}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop foreign keys first to avoid errors
        $this->dropForeignKey('fk-task_application-task_id', '{{%task_application}}');
        $this->dropForeignKey('fk-task_application-application_id', '{{%task_application}}');
        $this->dropForeignKey('fk-appearance-application_id', '{{%appearance}}');
        $this->dropForeignKey('fk-task-subject_category_id', '{{%task}}');
        $this->dropForeignKey('fk-application-subject_category_id', '{{%application}}');
        $this->dropForeignKey('fk-application-participant_id', '{{%application}}');
        $this->dropForeignKey('fk-subject_category-subject_id', '{{%subject_category}}');
        $this->dropForeignKey('fk-participant-school_id', '{{%participant}}');

        // Drop tables in reverse order
        $this->dropTable('{{%task_application}}');
        $this->dropTable('{{%appearance}}');
        $this->dropTable('{{%task}}');
        $this->dropTable('{{%application}}');
        $this->dropTable('{{%subject_category}}');
        $this->dropTable('{{%participant}}');
        $this->dropTable('{{%subject}}');
        $this->dropTable('{{%school}}');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250522_160359_init_olymp_tables cannot be reverted.\n";

        return false;
    }
    */
}
