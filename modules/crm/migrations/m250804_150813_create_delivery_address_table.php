<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%delivery_address}}`.
 */
class m250804_150813_create_delivery_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%delivery_address}}', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'label' => $this->string(50)->notNull()->defaultValue('Home'),
            'address' => $this->text()->notNull(),
            'city' => $this->string(100)->notNull(),
            'postal_code' => $this->string(20)->null(),
            'is_default' => $this->tinyInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
             'is_deleted' => $this->integer(2)->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'fk-delivery_address-customer_id',
            '{{%delivery_address}}',
            'customer_id',
            '{{%customers}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-delivery_address-customer_id', '{{%delivery_address}}');
        $this->dropTable('{{%delivery_address}}');
    }
}
