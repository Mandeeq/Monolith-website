<?php

namespace cms\models;

use Yii;
use cms\models\PageSections;

/**
 * This is the model class for table "{{%pages}}".
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string|null $meta_description
 * @property int|null $is_deleted
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Media[] $media
 * @property Section[] $sections
 */
class Pages extends \helpers\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pages}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'title'], 'required'],
            [['meta_description'], 'string'],
            // [['is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['slug', 'title'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'slug' => Yii::t('app', 'Slug'),
            'title' => Yii::t('app', 'Title'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Media]].
     *
     * @return \yii\db\ActiveQuery|MediaQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::class, ['page_id' => 'id']);
    }

    /**
     * Gets query for [[Sections]].
     *
     * @return \yii\db\ActiveQuery|SectionQuery
     */
    public function getSections()
    {
        return $this->hasMany(PageSections::class, ['page_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PagesQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new PagesQuery(get_called_class());
    // }
}
