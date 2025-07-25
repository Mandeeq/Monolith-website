<?php

namespace dashboard\models;

use Yii;
use dashboard\models\CarModel;

/**
 * This is the model class for table "{{%car_types}}".
 *
 * @property int $id
 * @property string $name
 * @property int|null $is_deleted
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CarModel[] $carModels
 */
class CarType extends \helpers\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%car_types}}';
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
     * Gets query for [[CarModels]].
     *
     * @return \yii\db\ActiveQuery|CarModelQuery
     */
    public function getCarModels()
    {
        return $this->hasMany(CarModel::class, ['car_type_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CarTypeQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new CarTypeQuery(get_called_class());
    // }

}
