<?php

namespace dashboard\models;

use Yii;
use dashboard\models\CarDetail;

/**
 * This is the model class for table "{{%car_trade_ins}}".
 *
 * @property int $id
 * @property int $car_id
 * @property int $customer_id
 * @property float|null $appraisal_value
 * @property float|null $trade_in_value
 * @property int|null $is_approved
 * @property int $trade_in_status
 * @property int|null $is_deleted
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CarDetail $carDetails
 */
class CarTradeIn extends \helpers\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%car_trade_ins}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['appraisal_value', 'trade_in_value'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['car_id', 'customer_id', 'trade_in_status', 'created_at', 'updated_at'], 'required'],
            [['car_id', 'customer_id', 'is_approved', 'trade_in_status', 'is_deleted', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['car_id', 'customer_id', 'is_approved', 'trade_in_status', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['appraisal_value', 'trade_in_value'], 'number'],
            [['car_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarDetail::class, 'targetAttribute' => ['car_id' => 'id']],
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
            'appraisal_value' => Yii::t('app', 'Appraisal Value'),
            'trade_in_value' => Yii::t('app', 'Trade In Value'),
            'is_approved' => Yii::t('app', 'Is Approved'),
            'trade_in_status' => Yii::t('app', 'Trade In Status'),
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
     * {@inheritdoc}
     * @return CarTradeInQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new CarTradeInQuery(get_called_class());
    // }

}
