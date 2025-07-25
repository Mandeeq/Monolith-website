<?php

namespace dashboard\models;

use Yii;
use dashboard\models\CarDetail;

/**
 * This is the model class for table "{{%car_media}}".
 *
 * @property int $id
 * @property int $car_id
 * @property string $media_type
 * @property string $media_path
 * @property int|null $is_deleted
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CarDetail $carDetails
 */
class CarMedia extends \helpers\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%car_media}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_deleted'], 'default', 'value' => 0],
            [['car_id', 'media_type', 'media_path', 'created_at', 'updated_at'], 'required'],
            [['car_id', 'is_deleted', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['car_id', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['media_type'], 'string', 'max' => 10],
            [['media_path'], 'string', 'max' => 255],
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
            'media_type' => Yii::t('app', 'Media Type'),
            'media_path' => Yii::t('app', 'Media Path'),
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
     * @return CarMediaQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new CarMediaQuery(get_called_class());
    // }

}
