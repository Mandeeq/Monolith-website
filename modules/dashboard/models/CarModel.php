<?php

namespace dashboard\models;

use Yii;

/**
 * This is the model class for table "{{%car_models}}".
 *
 * @property int $id
 * @property int $car_make_id
 * @property int $car_type_id
 * @property int|null $is_deleted
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CarDetail[] $carDetails
 * @property CarMake $carMakes
 * @property CarStock[] $carStocks
 * @property CarType $carTypes
 */
class CarModel extends \helpers\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%car_models}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_deleted'], 'default', 'value' => 0],
            [['car_make_id', 'car_type_id', 'created_at', 'updated_at'], 'required'],
            [['car_make_id', 'car_type_id', 'is_deleted', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['car_make_id', 'car_type_id', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['car_make_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarMake::class, 'targetAttribute' => ['car_make_id' => 'id']],
            [['car_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarType::class, 'targetAttribute' => ['car_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'car_make_id' => Yii::t('app', 'Car Make ID'),
            'car_type_id' => Yii::t('app', 'Car Type ID'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[CarDetails]].
     *
     * @return \yii\db\ActiveQuery|CarDetailQuery
     */
    public function getCarDetails()
    {
        return $this->hasMany(CarDetail::class, ['car_model_id' => 'id']);
    }

    /**
     * Gets query for [[CarMakes]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getCarMakes()
    {
        return $this->hasOne(CarMake::class, ['id' => 'car_make_id']);
    }

    /**
     * Gets query for [[CarStocks]].
     *
     * @return \yii\db\ActiveQuery|CarStockQuery
     */
    public function getCarStocks()
    {
        return $this->hasMany(CarStock::class, ['model_id' => 'id']);
    }

    /**
     * Gets query for [[CarTypes]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getCarTypes()
    {
        return $this->hasOne(CarType::class, ['id' => 'car_type_id']);
    }

    /**
     * {@inheritdoc}
     * @return CarModelQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new CarModelQuery(get_called_class());
    // }

}
