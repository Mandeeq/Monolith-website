<?php

use yii\db\Migration;

class m250820_072518_menus_table extends Migration
{
    /**
     * {@inheritdoc}
     */
  public function safeUp()
    {
        $this->createTable('menus', [
    'id' => $this->primaryKey(),
    'label' => $this->string()->notNull(), // e.g. Home, About, Menus, Blogs, Contacts
    'url' => $this->string()->notNull(),
    'order' => $this->integer()->defaultValue(0),
    'status' => $this->boolean()->defaultValue(true),
    'created_at' => $this->integer()->notNull(),
    'updated_at' => $this->integer()->notNull(),
]);

       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250820_072518_menus_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250820_072518_menus_table cannot be reverted.\n";

        return false;
    }
    */
}
