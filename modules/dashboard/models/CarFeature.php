<?php

namespace dashboard\models;

use Yii;
use dashboard\models\CarDetail;
use dashboard\models\CarDetailFeature;

/**
 * This is the model class for table "{{%car_features}}".
 *
 * @property int $id
 * @property string $name
 * @property int|null $is_deleted
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CarDetailFeature[] $carDetailFeatures
 * @property CarDetail[] $carDetails
 */
class CarFeature extends \helpers\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%car_features}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_deleted'], 'default', 'value' => 0],
            [['name', 'created_at', 'updated_at'], 'required'],
            [['is_deleted', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
        return $this->hasMany(CarDetailFeature::class, ['feature_id' => 'id']);
    }

    /**
     * Gets query for [[CarDetails]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getCarDetails()
    {
        return $this->hasMany(CarDetail::class, ['id' => 'car_detail_id'])->viaTable('{{%car_detail_features}}', ['feature_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CarFeatureQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new CarFeatureQuery(get_called_class());
    // }

}
