<?php

namespace cms\models;

use Yii;

/**
 * This is the model class for table "{{%website}}".
 *
 * @property int $id
 * @property string $name
 * @property string $domain
 * @property int|null $is_deleted
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Website extends \helpers\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%website}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'domain'], 'required'],
            // [['is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['name', 'domain'], 'string', 'max' => 255],
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
            'domain' => Yii::t('app', 'Domain'),
            // 'is_deleted' => Yii::t('app', 'Is Deleted'),
            // 'created_at' => Yii::t('app', 'Created At'),
            // 'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return WebsiteQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new WebsiteQuery(get_called_class());
    // }
}
