<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cart}}`.
 */
class m250805_113125_create_cart_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cart}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(), // Null for guests
            'status' => $this->string(20)->defaultValue('active'), // active, ordered, abandoned
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'is_deleted' => $this->integer(2)->defaultValue(0), // Soft delete
            'quantity' => $this->integer()->defaultValue(0), // Total quantity of items in cart
            'total_price' => $this->decimal(10, 2)->defaultValue(0.00), // Total price of items in cart
                     
        ]);

        // Add foreign key to user table
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cart}}');
    }
}
