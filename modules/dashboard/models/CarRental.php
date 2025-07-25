<?php

namespace dashboard\models;

use Yii;
use auth\models\User;

/**
 * This is the model class for table "{{%car_rentals}}".
 *
 * @property int $id
 * @property int $car_id
 * @property int $customer_id
 * @property string $rent_date
 * @property string $due_date
 * @property float|null $rental_price
 * @property int $rental_status
 * @property int|null $is_deleted
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CarDetail $carDetails
 * @property User $users
 */
class CarRental extends \helpers\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%car_rentals}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rental_price'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['car_id', 'customer_id', 'rent_date', 'due_date', 'rental_status', 'created_at', 'updated_at'], 'required'],
            [['car_id', 'customer_id', 'rental_status', 'is_deleted', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['car_id', 'customer_id', 'rental_status', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['rent_date', 'due_date'], 'safe'],
            [['rental_price'], 'number'],
            [['car_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarDetail::class, 'targetAttribute' => ['car_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['customer_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'car_id' => Yii::t('app', 'Car ID'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'rent_date' => Yii::t('app', 'Rent Date'),
            'due_date' => Yii::t('app', 'Due Date'),
            'rental_price' => Yii::t('app', 'Rental Price'),
            'rental_status' => Yii::t('app', 'Rental Status'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[CarDetails]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getCarDetails()
    {
        return $this->hasOne(CarDetail::class, ['id' => 'car_id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUsers()
    {
        return $this->hasOne(User::class, ['user_id' => 'customer_id']);
    }

    /**
     * {@inheritdoc}
     * @return CarRentalQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new CarRentalQuery(get_called_class());
    // }

}
