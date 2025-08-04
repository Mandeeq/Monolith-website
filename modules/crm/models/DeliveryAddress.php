<?php

namespace crm\models;

use Yii;

/**
 * This is the model class for table "delivery_address".
 *
 * @property int $id
 * @property int $customer_id
 * @property string $label
 * @property string $address
 * @property string $city
 * @property string|null $postal_code
 * @property int $is_default
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Customers $customer
 */
class DeliveryAddress extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'delivery_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['postal_code'], 'default', 'value' => null],
            [['label'], 'default', 'value' => 'Home'],
            [['is_default'], 'default', 'value' => 0],
            [['customer_id', 'address', 'city', 'created_at', 'updated_at'], 'required'],
            [['customer_id', 'is_default', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['customer_id', 'is_default', 'created_at', 'updated_at'], 'integer'],
            [['address'], 'string'],
            [['label'], 'string', 'max' => 50],
            [['city'], 'string', 'max' => 100],
            [['postal_code'], 'string', 'max' => 20],
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
            'customer_id' => 'Customer ID',
            'label' => 'Label',
            'address' => 'Address',
            'city' => 'City',
            'postal_code' => 'Postal Code',
            'is_default' => 'Is Default',
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

}
