<?php

use yii\db\Migration;

/**
 * Class m180730_071239_package
 */
class m180730_071239_package extends Migration
{
    const TABLE_NAME = "package";
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
            'project'=> $this->string()->notNull(),
            'branch'=> $this->string()->notNull(),
            'target'=> $this->string()->notNull(),
            'tags'=> $this->string()->notNull(),
            'status'=>$this->integer(3)->defaultValue(0)->notNull(),
            'created_at' => $this->integer()->notNull(),
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
        echo "m180730_071239_package cannot be reverted.\n";

        return false;
    }
    */
}
