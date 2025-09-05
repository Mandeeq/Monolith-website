<?php

namespace qaffee\models;

use Yii;

/**
 * This is the model class for table "home_sections".
 *
 * @property int $id
 * @property string $title
 * @property string|null $content
 * @property string|null $image
 * @property int|null $order
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class HomeSections extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'home_sections';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'image'], 'default', 'value' => null],
            [['order'], 'default', 'value' => 0],
            [['title'], 'required'],
            [['content'], 'string'],
            [['order'], 'default', 'value' => null],
            [['order'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
