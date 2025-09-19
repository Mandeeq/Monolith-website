<?php

use yii\db\Migration;

class m250820_072641_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
  public function safeUp()
    {
        $this->createTable('contact_messages', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'subject' => $this->string(),
            'message' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
                'is_deleted' => $this->integer()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250820_072641_contacts_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250820_072641_contacts_table cannot be reverted.\n";

        return false;
    }
    */
}
