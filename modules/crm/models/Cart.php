<?php

namespace crm\models;

use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $status
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $is_deleted
 */
class Cart extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['status'], 'default', 'value' => 'active'],
            [['is_deleted'], 'default', 'value' => 0],
            [['user_id', 'created_at', 'updated_at', 'is_deleted'], 'default', 'value' => null],
            [['user_id', 'created_at', 'updated_at', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'required'],
            [['status'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_deleted' => 'Is Deleted',
        ];
    }

}
