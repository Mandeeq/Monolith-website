<?php

use yii\db\Migration;

/**
 * Class m250221_215119_default_cms_migrations
 */
class m250221_215119_default_cms_migrations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        $this->createTable('{{%website}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'domain' => $this->string()->notNull(),
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%pages}}', [
            'id' => $this->primaryKey(),
            //'website_id' => $this->integer(), // Optional, for multi-website support
            'slug' => $this->string()->notNull()->unique(),
            'title' => $this->string()->notNull(),
            'meta_description' => $this->text(),
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%sections}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'order' => $this->integer()->defaultValue(0),
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY ([[page_id]]) REFERENCES {{%pages}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);

        $this->createTable('{{%content_blocks}}', [
            'id' => $this->primaryKey(),
            'section_id' => $this->integer()->notNull(),
            'type' => $this->string()->notNull(), // e.g., text, html, json
            'content' => $this->text()->notNull(),
            'order' => $this->integer()->defaultValue(0),
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY ([[section_id]]) REFERENCES {{%sections}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);


        $this->createTable('{{%media}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer(), // Optional, link to a page
            'section_id' => $this->integer(), // Optional, link to a section
            'file_path' => $this->string()->notNull(),
            'alt_text' => $this->string(),
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY ([[page_id]]) REFERENCES {{%pages}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[section_id]]) REFERENCES {{%sections}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%media}}');
        $this->dropTable('{{%content_blocks}}');
        $this->dropTable('{{%sections}}');
        $this->dropTable('{{%pages}}');
        $this->dropTable('{{%website}}');
    }

    protected function buildFkClause($delete = '', $update = '')
    {
        return implode(' ', ['', $delete, $update]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250221_181807_default_cms_migrations cannot be reverted.\n";

        return false;
    }
    */
}
