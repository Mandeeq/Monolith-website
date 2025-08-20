<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m250806_045900_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
   public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(), // internal PK for relations
            // 'product_id' => $this->string(50)->notNull()->unique(), // custom public ID
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'price' => $this->decimal(10, 2)->notNull(),
            'stock' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(false),
        ]);

        // Index for searching products by name
        $this->createIndex(
            'idx_product_name',
            '{{%product}}',
            'name'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products}}');
    }
}
