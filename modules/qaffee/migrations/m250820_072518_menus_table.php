<?php

use yii\db\Migration;

class m250820_072518_menus_table extends Migration
{
    public function safeUp()
    {
         $this->createTable('menu_categories', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'description' => $this->text(),
            'display_order' => $this->integer()->defaultValue(0),
             'is_deleted' => $this->integer()->defaultValue(0),
           'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

      $this->batchInsert('menu_categories', ['name', 'display_order', 'created_at', 'updated_at'], [
            ['Breakfast', 1, time(), time()],
            ['Lunch', 2, time(), time()],
            ['Dinner', 3, time(), time()],
            ['Drinks & Beverages', 4, time(), time()],
            ['Desserts', 5, time(), time()],
            ['Specials', 6, time(), time()],
        ]);
          $this->createTable('food_menus', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'price' => $this->decimal(8, 2)->notNull(),
            'image' => $this->string(),
            'category_id' => $this->integer()->notNull(), 
            'is_available' => $this->boolean()->defaultValue(true),
            'display_order' => $this->integer()->defaultValue(0),
             'is_deleted' => $this->integer()->defaultValue(0),
             'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY (category_id) REFERENCES {{%menu_categories}} ([[id]])'.
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);


       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250820_072518_menus_table cannot be reverted.\n";
       $this->dropTable('menu_categories');
        $this->dropTable('food_menus');
        return false;
    }

   protected function buildFkClause($delete = '', $update = '')
    {
        return implode(' ', ['', $delete, $update]);
    }
}
