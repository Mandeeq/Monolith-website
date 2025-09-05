<?php

namespace qaffee\models;

use Yii;

/**
 * This is the model class for table "menu_categories".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $display_order
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property FoodMenus[] $foodMenuses
 */
class MenuCategories extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['display_order'], 'default', 'value' => 0],
            [['name'], 'required'],
            [['description'], 'string'],
            [['display_order', 'created_at', 'updated_at'], 'integer'],
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
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'display_order' => 'Display Order',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[FoodMenuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFoodMenuses()
    {
        return $this->hasMany(FoodMenus::class, ['category_id' => 'id']);
    }

}
