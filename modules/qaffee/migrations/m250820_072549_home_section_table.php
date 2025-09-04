<?php

use yii\db\Migration;

class m250820_072549_home_section_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    
    public function safeUp()
    {
        $this->createTable('home_sections', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'content' => $this->text(),
            'image' => $this->string(),
            'order' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250820_072549_home_section_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250820_072549_home_section_table cannot be reverted.\n";

        return false;
    }
    */
}
