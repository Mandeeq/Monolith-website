<?php

namespace qaffee\models;

use Yii;

/**
 * This is the model class for table "menu_items".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property string|null $category
 * @property string|null $image
 * @property int $created_at
 * @property int $updated_at
 */
class Menu_items extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'category', 'image'], 'default', 'value' => null],
            [['name', 'price', 'created_at', 'updated_at'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'category', 'image'], 'string', 'max' => 255],
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
            'description' => 'Description',
            'price' => 'Price',
            'category' => 'Category',
            'image' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
