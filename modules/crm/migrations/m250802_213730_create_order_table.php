<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m250802_213730_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'order_number' => $this->string(50)->notNull()->unique(),
            'customer_id' => $this->integer()->notNull(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0),
            'payment_method' => $this->string(30)->null(),
            'total_amount' => $this->decimal(10, 2)->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'is_deleted' => $this->integer(2)->notNull()->defaultValue(0),
        ]);



        // Add foreign key to customer
        $this->addForeignKey(
            'fk-orders-customer_id',
            '{{%orders}}',
            'customer_id',
            '{{%customer}}',
            'id',
            'CASCADE'
        );

        // Optional FK to product table
        // $this->addForeignKey(
        //     'fk-order_history-product_id',
        //     '{{%order_history}}',
        //     'product_id',
        //     '{{%product}}',
        //     'id',
        //     'SET NULL'
        // );

        $this->createTable('{{%order_items}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'product_name' => $this->string(255)->notNull(),
            'quantity' => $this->integer()->notNull()->defaultValue(1),
            'unit_price' => $this->decimal(10, 2)->notNull(),
            'total_price' => $this->decimal(10, 2)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-order_items-order_id',
            '{{%order_items}}',
            'order_id',
            '{{%orders}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}
