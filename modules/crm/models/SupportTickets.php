<?php

namespace crm\models;

use Yii;

/**
 * This is the model class for table "support_tickets".
 *
 * @property int $id
 * @property int $customer_id
 * @property string $subject
 * @property string|null $description
 * @property int $is_deleted
 * @property int $status
 * @property string|null $created_at
 *
 * @property Customers $customer
 */
class SupportTickets extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'support_tickets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 10],
            [['customer_id', 'subject'], 'required'],
            [['customer_id', 'is_deleted', 'status'], 'default', 'value' => null],
            [['customer_id', 'is_deleted', 'status'], 'integer'],
            [['description'], 'string'],
            [['created_at'], 'safe'],
            [['subject'], 'string', 'max' => 255],
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
            'subject' => 'Subject',
            'description' => 'Description',
            'is_deleted' => 'Is Deleted',
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
        return $this->hasOne(Customers::class, ['id' => 'customer_id']);
    }

}
