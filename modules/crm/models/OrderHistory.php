<?php

namespace crm\models;

use Yii;

/**
 * This is the model class for table "order_history".
 *
 * @property int $id
 * @property int $customer_id
 * @property string $order_number
 * @property int|null $product_id
 * @property string $product_name
 * @property int $quantity
 * @property float $unit_price
 * @property float $total_price
 * @property int $order_status
 * @property int $payment_status
 * @property string $ordered_at
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Customer $customer
 */
class OrderHistory extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id'], 'default', 'value' => null],
            [['quantity'], 'default', 'value' => 1],
            [['payment_status'], 'default', 'value' => 0],
            [['customer_id', 'order_number', 'product_name', 'unit_price', 'total_price', 'ordered_at', 'created_at', 'updated_at'], 'required'],
            [['customer_id', 'product_id', 'quantity', 'order_status', 'payment_status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['customer_id', 'product_id', 'quantity', 'order_status', 'payment_status', 'created_at', 'updated_at'], 'integer'],
            [['unit_price', 'total_price'], 'number'],
            [['ordered_at'], 'safe'],
            [['order_number'], 'string', 'max' => 50],
            [['product_name'], 'string', 'max' => 255],
            [['order_number'], 'unique'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'order_number' => 'Order Number',
            'product_id' => 'Product ID',
            'product_name' => 'Product Name',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'total_price' => 'Total Price',
            'order_status' => 'Order Status',
            'payment_status' => 'Payment Status',
            'ordered_at' => 'Ordered At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

}
