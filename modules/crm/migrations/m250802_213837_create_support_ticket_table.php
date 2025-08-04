<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%support_ticket}}`.
 */
class m250802_213837_create_support_ticket_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('support_ticket', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'subject' => $this->string()->notNull(),
            'description' => $this->text(),
            'is_deleted' => $this->integer(2)->notNull()->defaultValue(0),
            'status' => $this->integer(3)->notNull()->defaultValue(10),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-support-customer_id',
            'support_ticket',
            'customer_id',
            'customer',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%support_ticket}}');
    }
}
