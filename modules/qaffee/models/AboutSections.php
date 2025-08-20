<?php

namespace qaffee\models;

use Yii;

/**
 * This is the model class for table "about_sections".
 *
 * @property int $id
 * @property string $title
 * @property string|null $content
 * @property string|null $image
 * @property int|null $order
 * @property int $created_at
 * @property int $updated_at
 */
class AboutSections extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'about_sections';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'image'], 'default', 'value' => null],
            [['order'], 'default', 'value' => 0],
            [['title', 'created_at', 'updated_at'], 'required'],
            [['content'], 'string'],
            [['order', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['order', 'created_at', 'updated_at'], 'integer'],
            [['title', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'image' => 'Image',
            'order' => 'Order',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
