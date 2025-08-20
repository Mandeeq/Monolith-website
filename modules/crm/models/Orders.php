<?php

namespace crm\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string $order_number
 * @property int $customer_id
 * @property int $status
 * @property string|null $payment_method
 * @property float $total_amount
 * @property int $created_at
 * @property int $updated_at
 * @property int $is_deleted
 *
 * @property Customers $customer
 * @property OrderItems[] $orderItems
 * @property Reviews[] $reviews
 */
class Orders extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment_method'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['order_number', 'customer_id', 'created_at', 'updated_at'], 'required'],
            [['customer_id', 'status', 'created_at', 'updated_at', 'is_deleted'], 'default', 'value' => null],
            [['customer_id', 'status', 'created_at', 'updated_at', 'is_deleted'], 'integer'],
            [['total_amount'], 'number'],
            [['order_number'], 'string', 'max' => 50],
            [['payment_method'], 'string', 'max' => 30],
            [['order_number'], 'unique'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customers::class, 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_number' => 'Order Number',
            'customer_id' => 'Customer ID',
            'status' => 'Status',
            'payment_method' => 'Payment Method',
            'total_amount' => 'Total Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customers::class, ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['order_id' => 'id']);
    }

}
