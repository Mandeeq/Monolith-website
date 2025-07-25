<?php

namespace dashboard\models;

use Yii;
use dashboard\models\CarMake;
use dashboard\models\CarBrand;
use dashboard\models\CarModel;

/**
 * This is the model class for table "{{%car_stock}}".
 *
 * @property int $id
 * @property int $brand_id
 * @property int $make_id
 * @property int $model_id
 * @property int $total_stock
 * @property int $available_stock
 * @property int $rented_stock
 * @property int $sold_stock
 * @property int $low_stock_threshold
 *
 * @property CarBrand $carBrands
 * @property CarMake $carMakes
 * @property CarModel $carModels
 */
class CarStock extends \helpers\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%car_stock}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sold_stock'], 'default', 'value' => 0],
            [['low_stock_threshold'], 'default', 'value' => 5],
            [['brand_id', 'make_id', 'model_id'], 'required'],
            [['brand_id', 'make_id', 'model_id', 'total_stock', 'available_stock', 'rented_stock', 'sold_stock', 'low_stock_threshold'], 'default', 'value' => null],
            [['brand_id', 'make_id', 'model_id', 'total_stock', 'available_stock', 'rented_stock', 'sold_stock', 'low_stock_threshold'], 'integer'],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarBrand::class, 'targetAttribute' => ['brand_id' => 'id']],
            [['make_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarMake::class, 'targetAttribute' => ['make_id' => 'id']],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarModel::class, 'targetAttribute' => ['model_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'brand_id' => Yii::t('app', 'Brand ID'),
            'make_id' => Yii::t('app', 'Make ID'),
            'model_id' => Yii::t('app', 'Model ID'),
            'total_stock' => Yii::t('app', 'Total Stock'),
            'available_stock' => Yii::t('app', 'Available Stock'),
            'rented_stock' => Yii::t('app', 'Rented Stock'),
            'sold_stock' => Yii::t('app', 'Sold Stock'),
            'low_stock_threshold' => Yii::t('app', 'Low Stock Threshold'),
        ];
    }

    /**
     * Gets query for [[CarBrands]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getCarBrands()
    {
        return $this->hasOne(CarBrand::class, ['id' => 'brand_id']);
    }

    /**
     * Gets query for [[CarMakes]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getCarMakes()
    {
        return $this->hasOne(CarMake::class, ['id' => 'make_id']);
    }

    /**
     * Gets query for [[CarModels]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getCarModels()
    {
        return $this->hasOne(CarModel::class, ['id' => 'model_id']);
    }

    /**
     * {@inheritdoc}
     * @return CarStockQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new CarStockQuery(get_called_class());
    // }

}
