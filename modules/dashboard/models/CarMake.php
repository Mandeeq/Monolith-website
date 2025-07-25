<?php

namespace dashboard\models;

use Yii;
use dashboard\models\CarStock;

/**
 * This is the model class for table "{{%car_makes}}".
 *
 * @property int $id
 * @property int $brand_id
 * @property string $name
 * @property int|null $is_deleted
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CarBrand $carBrands
 * @property CarModel[] $carModels
 * @property CarStock[] $carStocks
 */
class CarMake extends \helpers\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%car_makes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_deleted'], 'default', 'value' => 0],
            [['brand_id', 'name', 'created_at', 'updated_at'], 'required'],
            [['brand_id', 'is_deleted', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['brand_id', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarBrand::class, 'targetAttribute' => ['brand_id' => 'id']],
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
            'name' => Yii::t('app', 'Name'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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
     * Gets query for [[CarModels]].
     *
     * @return \yii\db\ActiveQuery|CarModelQuery
     */
    public function getCarModels()
    {
        return $this->hasMany(CarModel::class, ['car_make_id' => 'id']);
    }

    /**
     * Gets query for [[CarStocks]].
     *
     * @return \yii\db\ActiveQuery|CarStockQuery
     */
    public function getCarStocks()
    {
        return $this->hasMany(CarStock::class, ['make_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CarMakeQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new CarMakeQuery(get_called_class());
    // }

}
