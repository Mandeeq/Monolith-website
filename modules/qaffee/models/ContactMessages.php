<?php

namespace qaffee\models;

use Yii;

/**
 * This is the model class for table "contact_messages".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $subject
 * @property string $message
 * @property int $created_at
 */
class ContactMessages extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact_messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject'], 'default', 'value' => null],
            [['name', 'email', 'message', 'created_at'], 'required'],
            [['message'], 'string'],
            [['created_at'], 'default', 'value' => null],
            [['created_at'], 'integer'],
            [['name', 'email', 'subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'subject' => 'Subject',
            'message' => 'Message',
            'created_at' => 'Created At',
        ];
    }

}
