<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%review}}`.
 */
class m250804_112416_create_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reviews}}', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'product_name' => $this->string(255)->notNull(),
            'order_id' => $this->integer()->null(),
            'rating' => $this->tinyInteger()->notNull()->check('rating BETWEEN 1 AND 5'),
            'review_text' => $this->text()->null(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0), // pending
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
             'is_deleted' => $this->integer(2)->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'fk-review-customer_id',
            '{{%reviews}}',
            'customer_id',
            '{{%customers}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-review-order_id',
            '{{%reviews}}',
            'order_id',
            '{{%orders}}',
            'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
public function safeDown()
{
    $this->dropForeignKey('fk-review-customer_id', '{{%reviews}}');
    $this->dropForeignKey('fk-review-order_id', '{{%reviews}}');
    $this->dropTable('{{%reviews}}');
}
}
