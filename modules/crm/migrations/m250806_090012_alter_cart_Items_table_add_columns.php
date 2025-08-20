<?php

use yii\db\Migration;

class m250806_090012_alter_cart_Items_table_add_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
  public function safeUp()
    {
        $this->createTable('{{%cart_items}}', [
            'id' => $this->primaryKey(),
            'cart_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull()->defaultValue(1),
            'price' => $this->decimal(10, 2)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(false),
            'FOREIGN KEY ([[cart_id]]) REFERENCES {{%cart}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[product_id]]) REFERENCES {{%product}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE'
        ]);

        // FK to cart table
        
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250806_090012_alter_cart_Items_table_add_columns cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250806_090012_alter_cart_Items_table_add_columns cannot be reverted.\n";

        return false;
    }
    */
}
