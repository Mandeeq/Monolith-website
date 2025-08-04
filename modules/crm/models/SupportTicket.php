<?php

namespace crm\models;

use Yii;

/**
 * This is the model class for table "support_ticket".
 *
 * @property int $id
 * @property int $customer_id
 * @property string $subject
 * @property string|null $description
 * @property string|null $status
 * @property string|null $created_at
 *
 * @property Customer $customer
 */
class SupportTicket extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'support_ticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 'open'],
            [['customer_id', 'subject'], 'required'],
            [['customer_id'], 'default', 'value' => null],
            [['customer_id'], 'integer'],
            [['description'], 'string'],
            [['created_at'], 'safe'],
            [['subject', 'status'], 'string', 'max' => 255],
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
            'subject' => 'Subject',
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
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
