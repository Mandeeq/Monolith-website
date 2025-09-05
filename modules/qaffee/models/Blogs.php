<?php

namespace qaffee\models;

use Yii;

/**
 * This is the model class for table "blogs".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string|null $image
 * @property int|null $author_id
 * @property string|null $published_at
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 */
class Blogs extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blogs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'author_id', 'published_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 'draft'],
            [['title', 'slug', 'content', 'created_at', 'updated_at'], 'required'],
            [['content'], 'string'],
            [['author_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['author_id', 'created_at', 'updated_at'], 'integer'],
            [['published_at'], 'safe'],
            [['title', 'slug', 'image', 'status'], 'string', 'max' => 255],
            [['slug'], 'unique'],
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
            'slug' => 'Slug',
            'content' => 'Content',
            'image' => 'Image',
            'author_id' => 'Author ID',
            'published_at' => 'Published At',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
