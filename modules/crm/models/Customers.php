<?php

namespace crm\models;

use Yii;

/**
 * This is the model class for table "customers".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property int $is_deleted
 * @property int $status
 * @property string|null $created_at
 *
 * @property Orders[] $orders
 * @property Reviews[] $reviews
 * @property SupportTickets[] $supportTickets
 * @property DeliveryAddress[] $deliveryAddress
 */
class Customers extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 10],
            [['name', 'email'], 'required'],
            [['is_deleted', 'status'], 'default', 'value' => null],
            [['is_deleted', 'status'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 150],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'is_deleted' => 'Is Deleted',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[SupportTickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupportTickets()
    {
        return $this->hasMany(SupportTickets::class, ['customer_id' => 'id']);
    }

        /**
     * Gets query for [[DeliveryAddress]].
     *
     * @return \yii\db\ActiveQuery
     */

    public function getDeliveryAddresses()
    {
        return $this->hasMany(DeliveryAddress::class, ['customer_id' => 'id']);
    }

    public function getDefaultAddress()
    {
        return $this->hasOne(DeliveryAddress::class, ['customer_id' => 'id'])
            ->andWhere(['is_default' => 1]);
    }
}
