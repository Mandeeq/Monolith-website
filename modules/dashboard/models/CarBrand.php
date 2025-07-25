<?php

namespace dashboard\models;

use Yii;
use dashboard\models\CarMake;
use dashboard\models\CarStock;

/**
 * This is the model class for table "{{%car_brands}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $image
 * @property int $is_published
 * @property int|null $is_deleted
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CarMake[] $carMakes
 * @property CarStock[] $carStocks
 */
class CarBrand extends \helpers\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%car_brands}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image'], 'default', 'value' => null],
            [['is_published'], 'default', 'value' => 1],
            [['is_deleted'], 'default', 'value' => 0],
            [['name', 'created_at', 'updated_at'], 'required'],
            [['is_published', 'is_deleted', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['is_published', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['name', 'image'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'image' => Yii::t('app', 'Image'),
            'is_published' => Yii::t('app', 'Is Published'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[CarMakes]].
     *
     * @return \yii\db\ActiveQuery|CarMakeQuery
     */
    public function getCarMakes()
    {
        return $this->hasMany(CarMake::class, ['brand_id' => 'id']);
    }

    /**
     * Gets query for [[CarStocks]].
     *
     * @return \yii\db\ActiveQuery|CarStockQuery
     */
    public function getCarStocks()
    {
        return $this->hasMany(CarStock::class, ['brand_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CarBrandQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new CarBrandQuery(get_called_class());
    // }
}
