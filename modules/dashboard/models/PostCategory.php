<?php

namespace dashboard\models;

use Yii;

/**
 * This is the model class for table "{{%post_categories}}".
 *
 * @property int $post_id
 * @property int $category_id
 */
class PostCategory extends \helpers\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%post_categories}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'category_id'], 'required'],
            [['post_id', 'category_id'], 'default', 'value' => null],
            [['post_id', 'category_id'], 'integer'],
            [['post_id', 'category_id'], 'unique', 'targetAttribute' => ['post_id', 'category_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => Yii::t('app', 'Post ID'),
            'category_id' => Yii::t('app', 'Category ID'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PostCategoryQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new PostCategoryQuery(get_called_class());
    // }

}
