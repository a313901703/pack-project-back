<?php
//namespace app\migrations;

use yii\db\Migration;

/**
 * Class m180726_100918_event_rule
 */
class m180726_100918_event_rule extends Migration
{
    const TABLE_NAME = "event_rules";
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
            'street' => $this->integer()->notNull()->defaultValue(0),
            'grid_center' => $this->integer()->defaultValue(0),
            'filter' => $this->text(),
            'id_filter' => $this->string(1000),
            'event_type' => $this->string(100)->notNull()->defaultValue(''),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'status' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
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
        echo "m180726_100918_event_rule cannot be reverted.\n";

        return false;
    }
    */
}
