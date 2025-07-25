<?php

namespace dashboard\models;

use Yii;
use dashboard\models\CarDetail;
use dashboard\models\CarFeature;

/**
 * This is the model class for table "{{%car_detail_features}}".
 *
 * @property int $car_detail_id
 * @property int $feature_id
 *
 * @property CarDetail $carDetails
 * @property CarFeature $carFeatures
 */
class CarDetailFeature extends \helpers\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%car_detail_features}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['car_detail_id', 'feature_id'], 'required'],
            [['car_detail_id', 'feature_id'], 'default', 'value' => null],
            [['car_detail_id', 'feature_id'], 'integer'],
            [['car_detail_id', 'feature_id'], 'unique', 'targetAttribute' => ['car_detail_id', 'feature_id']],
            [['car_detail_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarDetail::class, 'targetAttribute' => ['car_detail_id' => 'id']],
            [['feature_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarFeature::class, 'targetAttribute' => ['feature_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'car_detail_id' => Yii::t('app', 'Car Detail ID'),
            'feature_id' => Yii::t('app', 'Feature ID'),
        ];
    }

    /**
     * Gets query for [[CarDetails]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getCarDetails()
    {
        return $this->hasOne(CarDetail::class, ['id' => 'car_detail_id']);
    }

    /**
     * Gets query for [[CarFeatures]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getCarFeatures()
    {
        return $this->hasOne(CarFeature::class, ['id' => 'feature_id']);
    }

    /**
     * {@inheritdoc}
     * @return CarDetailFeatureQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new CarDetailFeatureQuery(get_called_class());
    // }

}
