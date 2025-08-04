<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use Faker\Factory;
use yii\db\Expression;

class SeedCrmController extends Controller
{
    public function actionIndex()
    {
        $faker = Factory::create();

        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            // Seed Customers
            for ($i = 0; $i < 100; $i++) {
                $db->createCommand()->insert('customers', [
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'phone' => $faker->phoneNumber,
                    'created_at' => date('Y-m-d H:i:s'),
                ])->execute();
            }

            echo "✅ Inserted 100 customers.\n";

            // Fetch all customer IDs
            $customerIds = (new \yii\db\Query())->select('id')->from('customers')->column();

            // Seed Orders
            $orderCount = 0;

            foreach ($customerIds as $customerId) {
                for ($j = 0; $j < 30; $j++) {
                    $orderNumber = 'ORD' . strtoupper($faker->bothify('####-???'));
                    $createdAt = time();

                    // Step 1: Insert Order
                    $db->createCommand()->insert('orders', [
                        'order_number' => $orderNumber,
                        'customer_id' => $customerId,
                        'status' => $faker->numberBetween(0, 3), // e.g., 0=pending, 1=processing, etc.
                        'payment_method' => $faker->randomElement(['mpesa', 'paypal', 'credit_card']),
                        'total_amount' => 0, // placeholder, update later
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                        'is_deleted' => 0,
                    ])->execute();

                    $orderId = $db->getLastInsertID();
                    $totalAmount = 0;

                    // Step 2: Generate Order Items
                    $itemCount = $faker->numberBetween(1, 5);
                    for ($k = 0; $k < $itemCount; $k++) {
                        $quantity = $faker->numberBetween(1, 3);
                        $unitPrice = $faker->randomFloat(2, 100, 2000);
                        $totalPrice = $unitPrice * $quantity;

                        $db->createCommand()->insert('order_items', [
                            'order_id' => $orderId,
                            'product_name' => $faker->words(2, true),
                            'quantity' => $quantity,
                            'unit_price' => $unitPrice,
                            'total_price' => $totalPrice,
                        ])->execute();

                        $totalAmount += $totalPrice;
                    }

                    // Step 3: Update total in orders
                    $db->createCommand()->update('orders', [
                        'total_amount' => $totalAmount,
                    ], ['id' => $orderId])->execute();

                    $orderCount++;
                }
            }

            echo "✅ Inserted {$orderCount} orders with items.\n";


            echo "✅ Inserted 3000 orders.\n";

            // Seed Support Tickets
            foreach ($customerIds as $customerId) {
                $db->createCommand()->insert('support_tickets', [
                    'customer_id' => $customerId,
                    'subject' => $faker->sentence(6),
                    'description' => $faker->paragraph,
                    'status' => $faker->randomElement(['open', 'pending', 'closed']),
                    'created_at' => date('Y-m-d H:i:s'),
                ])->execute();
            }

            echo "✅ Inserted 100 support tickets.\n";

            $orderIds = (new \yii\db\Query())->select('id')->from('orders')->column();

            foreach ($customerIds as $customerId) {
                for ($r = 0; $r < 10; $r++) {
                    $db->createCommand()->insert('reviews', [
                        'customer_id' => $customerId,
                        'product_name' => $faker->word,
                        'order_id' => $faker->optional()->randomElement($orderIds),
                        'rating' => $faker->numberBetween(1, 5),
                        'review_text' => $faker->sentence(10),
                        'status' => $faker->numberBetween(0, 2),
                        'created_at' => time(),
                        'updated_at' => time(),
                    ])->execute();
                }
            }

            echo "✅ Inserted 100 reviews.\n";

            foreach ($customerIds as $customerId) {
                $addressCount = $faker->numberBetween(1, 3);
                $defaultAssigned = false;

                for ($a = 0; $a < $addressCount; $a++) {
                    $isDefault = (!$defaultAssigned || $a == $addressCount - 1) ? 1 : 0;
                    $defaultAssigned = true;

                    $db->createCommand()->insert('delivery_address', [
                        'customer_id' => $customerId,
                        'label' => $faker->randomElement(['Home', 'Office', 'Other']),
                        'address' => $faker->address,
                        'city' => $faker->city,
                        'postal_code' => $faker->postcode,
                        'is_default' => $isDefault,
                        'created_at' => time(),
                        'updated_at' => time(),
                    ])->execute();
                }
            }

            echo "✅ Seeded delivery addresses for all customers.\n";


            $transaction->commit();
            echo "🎉 CRM seeding completed successfully.\n";
        } catch (\Throwable $e) {
            $transaction->rollBack();
            echo "❌ Error during seeding: " . $e->getMessage() . "\n";
        }
    }
}
