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
                $db->createCommand()->insert('customer', [
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'phone' => $faker->phoneNumber,
                    'created_at' => date('Y-m-d H:i:s'),
                ])->execute();
            }

            echo "✅ Inserted 100 customers.\n";

            // Fetch all customer IDs
            $customerIds = (new \yii\db\Query())->select('id')->from('customer')->column();

            // Seed Orders
            foreach ($customerIds as $customerId) {
                for ($j = 0; $j < 30; $j++) {
                    $db->createCommand()->insert('order', [
                        'customer_id' => $customerId,
                        'product_name' => $faker->word,
                        'amount' => $faker->randomFloat(2, 10, 500),
                        'order_date' => date('Y-m-d H:i:s'),
                    ])->execute();
                }
            }

            echo "✅ Inserted 3000 orders.\n";

            // Seed Support Tickets
            foreach ($customerIds as $customerId) {
                $db->createCommand()->insert('support_ticket', [
                    'customer_id' => $customerId,
                    'subject' => $faker->sentence(6),
                    'description' => $faker->paragraph,
                    'status' => $faker->randomElement(['open', 'pending', 'closed']),
                    'created_at' => date('Y-m-d H:i:s'),
                ])->execute();
            }

            echo "✅ Inserted 100 support tickets.\n";

            // ✅ Seed Order History
            foreach ($customerIds as $customerId) {
                for ($k = 0; $k < 15; $k++) {
                    $quantity = $faker->numberBetween(1, 5);
                    $unitPrice = $faker->randomFloat(2, 50, 1500);

                    $db->createCommand()->insert('order_history', [
                        'customer_id' => $customerId,
                        'order_number' => 'ORD' . strtoupper($faker->bothify('####-???')),
                        'product_name' => $faker->word . ' ' . $faker->randomElement(['Device', 'Tool', 'Item']),
                        'product_id' => null,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total_price' => $quantity * $unitPrice,
                        'order_status' => $faker->numberBetween(0, 4), // match your status constants
                        'payment_status' => $faker->numberBetween(0, 2),
                        'ordered_at' => $faker->dateTimeThisYear->format('Y-m-d H:i:s'),
                        'created_at' => time(),
                        'updated_at' => time(),
                    ])->execute();
                }
            }

            echo "✅ Inserted " . (count($customerIds) * 15) . " order history records.\n";

            $transaction->commit();
            echo "🎉 CRM seeding completed successfully.\n";

        } catch (\Throwable $e) {
            $transaction->rollBack();
            echo "❌ Error during seeding: " . $e->getMessage() . "\n";
        }
    }
}
