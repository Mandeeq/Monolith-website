<?php

namespace crm\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int $customer_id
 * @property string $product_name
 * @property int|null $order_id
 * @property int $rating
 * @property string|null $review_text
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Customers $customer
 * @property Orders $order
 */
class Reviews extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'review_text'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['customer_id', 'product_name', 'rating', 'created_at', 'updated_at'], 'required'],
            [['customer_id', 'order_id', 'rating', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['customer_id', 'order_id', 'rating', 'status', 'created_at', 'updated_at'], 'integer'],
            [['review_text'], 'string'],
            [['product_name'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customers::class, 'targetAttribute' => ['customer_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::class, 'targetAttribute' => ['order_id' => 'id']],
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
            'product_name' => 'Product Name',
            'order_id' => 'Order ID',
            'rating' => 'Rating',
            'review_text' => 'Review Text',
            'status' => 'Status',
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
        return $this->hasOne(Customers::class, ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::class, ['id' => 'order_id']);
    }

}
