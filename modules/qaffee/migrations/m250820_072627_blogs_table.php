<?php

use yii\db\Migration;

class m250820_072627_blogs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('blogs', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull()->unique(),
            'content' => $this->text()->notNull(),
            'image' => $this->string(),
            'author_id' => $this->integer(),
            'published_at' => $this->dateTime(),
             'status' => $this->string()->notNull()->defaultValue('draft'), // ✅ FIXED
            'created_at' => $this->integer()->notNull(),
                'is_deleted' => $this->integer()->defaultValue(0),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // Author reference (assuming you have a users table)
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250820_072627_blogs_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250820_072627_blogs_table cannot be reverted.\n";

        return false;
    }
    */
}
