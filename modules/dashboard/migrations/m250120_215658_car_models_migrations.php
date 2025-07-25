<?php

use yii\db\Migration;

/**
 * Class m250120_215658_car_models_migrations
 */
class m250120_215658_car_models_migrations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        $this->createTable('{{%car_brands}}', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string(255)->notNull()->unique(),
            'image' => $this->string(255)->null(), // Stores brand logo/image path
            'is_published' => $this->integer()->notNull()->defaultValue(1), // 1 = Published, 0 = Unpublished
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        /*This table represents broad categories or types of vehicles, such as:
        Sedan
        SUV
        Truck
    */
        $this->createTable('{{%car_types}}', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string(255)->notNull()->unique(),
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);


        $this->createTable('{{%car_makes}}', [
            'id' => $this->bigPrimaryKey(),
            'brand_id' => $this->integer()->notNull(), // Reference to car_brands
            'name' => $this->string()->notNull(), // e.g., Corolla, Camry, X5
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'FOREIGN KEY ([[brand_id]]) REFERENCES {{%car_brands}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);

        $this->createTable('{{%car_models}}', [
            'id' => $this->bigPrimaryKey(),
            'car_make_id' => $this->bigInteger()->notNull(),
            'car_type_id' => $this->bigInteger()->notNull(),
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'FOREIGN KEY ([[car_make_id]]) REFERENCES {{%car_makes}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[car_type_id]]) REFERENCES {{%car_types}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);

        $this->createTable('{{%car_details}}', [
            'id' => $this->bigPrimaryKey(),
            'car_model_id' => $this->bigInteger()->notNull(),
            'trim' => $this->string(), // Describes a car's variant (L, LE, SE, XSE)	A trim is just a variant of a model, not a separate entity.
            'engine_size' => $this->string(), // Engine capacity (e.g., "2.0L Turbo")
            'drivetrain' => $this->string(), // eg FWD, RWD, AWD refers to the system in a vehicle that delivers power from the engine to the wheels. It determines how the vehicle moves and performs on different terrains.
            'doors' => $this->integer(),
            'year' => $this->string()->notNull(),
            'seats' => $this->integer(),
            'fuel_capacity' => $this->integer(),
            'body_style' => $this->string(), // e.g., "4-door sedan", "Compact SUV"
            'transmission' => $this->string(),
            'engine' => $this->string(), //  Engine type (e.g., V6, Inline-4)
            'fuel_type' => $this->string(), // Gasoline, Diesel, Hybrid, Electric
            'mileage' => $this->integer()->defaultValue(0),
            'interior_color' => $this->string(),
            'exterior_color' => $this->string(),
            'vin' => $this->string()->notNull()->unique(), // Vehicle Identification Number eg 1HGCM82633A123456
            'description' => $this->text(),
            'condition' => $this->string(),
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'FOREIGN KEY ([[car_model_id]]) REFERENCES {{%car_models}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);

        $this->createTable('{{%car_features}}', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string(255)->notNull()->unique(), // e.g., Sunroof, Leather Seats, Bluetooth
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%car_detail_features}}', [
            'car_detail_id' => $this->bigInteger()->notNull(),
            'feature_id' => $this->bigInteger()->notNull(),
            'PRIMARY KEY ([[car_detail_id]], [[feature_id]])',
            'FOREIGN KEY ([[car_detail_id]]) REFERENCES {{%car_details}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[feature_id]]) REFERENCES {{%car_features}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);


        $this->createTable('{{%car_media}}', [
            'id' => $this->bigPrimaryKey(),
            'car_id' => $this->bigInteger()->notNull(),
            'media_type' => $this->string(10)->notNull(), // Values: 'image', 'video'
            'media_path' => $this->string()->notNull(), // Stores file path (image/video)
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'FOREIGN KEY ([[car_id]]) REFERENCES {{%car_details}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);


        $this->createTable('{{%car_stock}}', [
            'id' => $this->bigPrimaryKey(),
            'brand_id' => $this->bigInteger()->notNull(), // Foreign key to car_brands
            'make_id' => $this->bigInteger()->notNull(), // Foreign key to car_makes
            'model_id' => $this->bigInteger()->notNull(), // Foreign key to car_models
            'total_stock' => $this->integer()->notNull()->defaultValue(0), // Total available stock
            'available_stock' => $this->integer()->notNull()->defaultValue(0), // Cars not yet sold/rented
            'rented_stock' => $this->integer()->notNull()->defaultValue(0), // Cars currently rented
            'sold_stock' => $this->integer()->notNull()->defaultValue(0), // Cars that have been sold
            'low_stock_threshold' => $this->integer()->notNull()->defaultValue(5), // Threshold for low stock warnings
            'FOREIGN KEY ([[brand_id]]) REFERENCES {{%car_brands}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[make_id]]) REFERENCES {{%car_makes}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[model_id]]) REFERENCES {{%car_models}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);


        $this->createTable('{{%car_rentals}}', [
            'id' => $this->bigPrimaryKey(),
            'car_id' => $this->integer()->notNull(),
            'customer_id' => $this->bigInteger()->notNull(),
            'rent_date' => $this->date()->notNull(),
            'due_date' => $this->date()->notNull(),
            'rental_price' => $this->decimal(10, 2),
            'rental_status' => $this->integer()->notNull(), //"ENUM('active', 'completed', 'cancelled')
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'FOREIGN KEY ([[customer_id]]) REFERENCES {{%users}} ([[user_id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[car_id]]) REFERENCES {{%car_details}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);

        $this->createIndex(
            'idx-rental-customer_id',
            '{{%car_rentals}}',
            'customer_id'
        );

        $this->createTable('{{%car_trade_ins}}', [
            'id' => $this->bigPrimaryKey(),
            'car_id' => $this->integer()->notNull(),
            'customer_id' => $this->integer()->notNull(),
            'appraisal_value' => $this->decimal(10, 2),
            'trade_in_value' => $this->decimal(10, 2),
            'is_approved' => $this->integer()->defaultValue(0),
            'trade_in_status' => $this->integer()->notNull(), // "ENUM('pending', 'accepted', 'rejected'),, default pending
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'FOREIGN KEY ([[car_id]]) REFERENCES {{%car_details}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);

        $this->createIndex(
            'idx-trade_in-car_id',
            '{{%car_trade_ins}}',
            'car_id'
        );

        $this->createTable('{{%sales}}', [
            'id' => $this->bigPrimaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'total_price' => $this->decimal(10, 2)->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(0), // 'pending', 'completed', 'canceled'
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'FOREIGN KEY ([[customer_id]]) REFERENCES {{%users}} ([[user_id]])',
        ], $tableOptions);

        $this->createTable('{{%sales_items}}', [
            'id' => $this->bigPrimaryKey(),
            'sale_id' => $this->integer()->notNull(),
            'car_id' => $this->integer()->notNull(),
            'price_sold' => $this->decimal(10, 2)->notNull(),
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'FOREIGN KEY ([[sale_id]]) REFERENCES {{%sales}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[car_id]]) REFERENCES {{%car_details}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);

        $this->createTable('{{%suppliers}}', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string(255)->notNull(),
            'contact_name' => $this->string(255)->notNull(),
            'contact_email' => $this->string(255)->notNull(),
            'contact_phone' => $this->string(50)->notNull(),
            'address' => $this->text()->notNull(),
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);


        $this->createTable('{{%purchases}}', [
            'id' => $this->bigPrimaryKey(),
            'supplier_id' => $this->bigInteger()->notNull(),
            'total_price' => $this->decimal(10, 2)->notNull(),
            'purchase_date' => $this->date()->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(11), //"ENUM('pending', 'completed', 'cancelled') NOT NULL DEFAULT 'pending'",
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'FOREIGN KEY ([[supplier_id]]) REFERENCES {{%suppliers}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable('{{%purchase_items}}', [
            'id' => $this->bigPrimaryKey(),
            'purchase_id' => $this->bigInteger()->notNull(),
            'car_id' => $this->bigInteger()->notNull(),
            'purchase_price' => $this->decimal(10, 2)->notNull(),
            'quantity' => $this->integer()->notNull()->defaultValue(1),
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'FOREIGN KEY ([[purchase_id]]) REFERENCES {{%purchases}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[car_id]]) REFERENCES {{%car_details}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);



        $this->createTable('{{%transactions}}', [
            'id' => $this->bigPrimaryKey(),
            'customer_id' => $this->bigInteger()->notNull(),
            'transaction_type' => $this->string()->notNull(), // e.g., 'Sale', 'Rental', 'Trade-in'
            'related_id' => $this->integer(), // ID of the related record (e.g., car_id for sale, rental_id for rental)
            'total_amount' => $this->decimal(15, 2)->notNull(),
            'status' => $this->string()->defaultValue('Pending'), // e.g., 'Pending', 'Completed', 'Refunded', 'Failed'
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'FOREIGN KEY ([[customer_id]]) REFERENCES {{%users}} ([[user_id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);


        $this->createTable('{{%payments}}', [
            'id' => $this->bigPrimaryKey(),
            'transaction_id' => $this->integer()->notNull(),
            'payment_method' => $this->string()->notNull(), // e.g., 'Cash', 'Mpesa', 'Bank Transfer', 'Credit Card'
            'amount' => $this->decimal(15, 2)->notNull(),
            'transaction_reference' => $this->string(), // Reference number from payment gateway or other system
            'details' => $this->text(), // Additional details about the payment (e.g., Mpesa transaction ID)
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'FOREIGN KEY ([[transaction_id]]) REFERENCES {{%transactions}} ([[id]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);

        $this->createIndex(
            'idx-payment-transaction_id',
            '{{%payments}}',
            'transaction_id'
        );

        $this->createTable('{{%payment_methods}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique(), // e.g., Cash, Mpesa, Bank
            'is_deleted' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // $this->createTable('{{%system_settings}}', [], $tableOptions);
        // $this->batchInsert('{{%payment_methods}}', ['name'], [
        //     ['Cash'],
        //     ['Mpesa'],
        //     ['Bank Transfer'],
        //     ['Credit Card'],
        // ]);
    }

    protected function buildFkClause($delete = '', $update = '')
    {
        return implode(' ', ['', $delete, $update]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // $this->dropTable('{{%system_settings}}');
        $this->dropTable('{{%payment_methods}}');
        $this->dropIndex('idx-payment-transaction_id', '{{%payments}}');
        $this->dropTable('{{%payments}}');
        $this->dropTable('{{%transactions}}');
        $this->dropIndex('idx-trade_in-car_id', '{{%car_trade_ins}}');
        $this->dropTable('{{%car_trade_ins}}');
        $this->dropIndex('idx-rental-customer_id', '{{%car_rentals}}');
        $this->dropTable('{{%car_rentals}}');
        $this->dropTable('{{%car_images}}');
        $this->dropTable('{{%car_makes}}');
        $this->dropTable('{{%car_details}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250120_215658_car_models_migrations cannot be reverted.\n";

        return false;
    }
    */
}
