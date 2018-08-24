<?php

use yii\db\Migration;

/**
 * Class m180727_094323_projects
 */
class m180727_094323_projects extends Migration
{
    const TABLE_NAME = "projects";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'type' => $this->string()->notNull(),
            'desc' => $this->string()->notNull(),
            'path' => $this->string(1000)->notNull(),
            'branch' => $this->string(1000)->notNull(),
            'target' => $this->string(1000)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            // 'created_by' => $this->integer()->notNull(),
            // 'updated_by' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180727_094323_projects cannot be reverted.\n";

        return false;
    }
    */
}
