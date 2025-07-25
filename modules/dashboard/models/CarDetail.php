<?php

namespace dashboard\models;

use Yii;

/**
 * This is the model class for table "{{%car_details}}".
 *
 * @property int $id
 * @property int $car_model_id
 * @property string|null $trim
 * @property string|null $engine_size
 * @property string|null $drivetrain
 * @property int|null $doors
 * @property string $year
 * @property int|null $seats
 * @property int|null $fuel_capacity
 * @property string|null $body_style
 * @property string|null $transmission
 * @property string|null $engine
 * @property string|null $fuel_type
 * @property int|null $mileage
 * @property string|null $interior_color
 * @property string|null $exterior_color
 * @property string $vin
 * @property string|null $description
 * @property string|null $condition
 * @property int|null $is_deleted
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CarDetailFeature[] $carDetailFeatures
 * @property CarMedia[] $carMedia
 * @property CarModel $carModels
 * @property CarRental[] $carRentals
 * @property CarTradeIn[] $carTradeIns
 * @property CarFeature[] $features
 * @property PurchaseItem[] $purchaseItems
 * @property SalesItem[] $salesItems
 */
class CarDetail extends \helpers\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%car_details}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trim', 'engine_size', 'drivetrain', 'doors', 'seats', 'fuel_capacity', 'body_style', 'transmission', 'engine', 'fuel_type', 'interior_color', 'exterior_color', 'description', 'condition'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['car_model_id', 'year', 'vin', 'created_at', 'updated_at'], 'required'],
            [['car_model_id', 'doors', 'seats', 'fuel_capacity', 'mileage', 'is_deleted', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['car_model_id', 'doors', 'seats', 'fuel_capacity', 'mileage', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['trim', 'engine_size', 'drivetrain', 'year', 'body_style', 'transmission', 'engine', 'fuel_type', 'interior_color', 'exterior_color', 'vin', 'condition'], 'string', 'max' => 255],
            [['vin'], 'unique'],
            [['car_model_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarModel::class, 'targetAttribute' => ['car_model_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'car_model_id' => Yii::t('app', 'Car Model ID'),
            'trim' => Yii::t('app', 'Trim'),
            'engine_size' => Yii::t('app', 'Engine Size'),
            'drivetrain' => Yii::t('app', 'Drivetrain'),
            'doors' => Yii::t('app', 'Doors'),
            'year' => Yii::t('app', 'Year'),
            'seats' => Yii::t('app', 'Seats'),
            'fuel_capacity' => Yii::t('app', 'Fuel Capacity'),
            'body_style' => Yii::t('app', 'Body Style'),
            'transmission' => Yii::t('app', 'Transmission'),
            'engine' => Yii::t('app', 'Engine'),
            'fuel_type' => Yii::t('app', 'Fuel Type'),
            'mileage' => Yii::t('app', 'Mileage'),
            'interior_color' => Yii::t('app', 'Interior Color'),
            'exterior_color' => Yii::t('app', 'Exterior Color'),
            'vin' => Yii::t('app', 'Vin'),
            'description' => Yii::t('app', 'Description'),
            'condition' => Yii::t('app', 'Condition'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[CarDetailFeatures]].
     *
     * @return \yii\db\ActiveQuery|CarDetailFeatureQuery
     */
    public function getCarDetailFeatures()
    {
        return $this->hasMany(CarDetailFeature::class, ['car_detail_id' => 'id']);
    }

    /**
     * Gets query for [[CarMedia]].
     *
     * @return \yii\db\ActiveQuery|CarMediaQuery
     */
    public function getCarMedia()
    {
        return $this->hasMany(CarMedia::class, ['car_id' => 'id']);
    }

    /**
     * Gets query for [[CarModels]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getCarModels()
    {
        return $this->hasOne(CarModel::class, ['id' => 'car_model_id']);
    }

    /**
     * Gets query for [[CarRentals]].
     *
     * @return \yii\db\ActiveQuery|CarRentalQuery
     */
    public function getCarRentals()
    {
        return $this->hasMany(CarRental::class, ['car_id' => 'id']);
    }

    /**
     * Gets query for [[CarTradeIns]].
     *
     * @return \yii\db\ActiveQuery|CarTradeInQuery
     */
    public function getCarTradeIns()
    {
        return $this->hasMany(CarTradeIn::class, ['car_id' => 'id']);
    }

    /**
     * Gets query for [[Features]].
     *
     * @return \yii\db\ActiveQuery|CarFeatureQuery
     */
    public function getFeatures()
    {
        return $this->hasMany(CarFeature::class, ['id' => 'feature_id'])->viaTable('{{%car_detail_features}}', ['car_detail_id' => 'id']);
    }

    /**
     * Gets query for [[PurchaseItems]].
     *
     * @return \yii\db\ActiveQuery|PurchaseItemQuery
     */
    // public function getPurchaseItems()
    // {
    //     return $this->hasMany(PurchaseItem::class, ['car_id' => 'id']);
    // }

    /**
     * Gets query for [[SalesItems]].
     *
     * @return \yii\db\ActiveQuery|SalesItemQuery
    //  */
    // public function getSalesItems()
    // {
    //     return $this->hasMany(SalesItem::class, ['car_id' => 'id']);
    // }

    /**
     * {@inheritdoc}
     * @return CarDetailQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new CarDetailQuery(get_called_class());
    // }

}
