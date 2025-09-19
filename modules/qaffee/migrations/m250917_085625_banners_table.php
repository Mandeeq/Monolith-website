<?php

use yii\db\Migration;

class m250917_085625_banners_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%banners}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
                'content' => $this->text(),   // 👈 Add here
            'image' => $this->string(255)->notNull(),
            'link' => $this->string(255),
            'status' => $this->boolean()->defaultValue(true),
                'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250917_085625_banners_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250917_085625_banners_table cannot be reverted.\n";

        return false;
    }
    */
}
