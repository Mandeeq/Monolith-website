<?php

namespace cms\models;

use Yii;
use cms\models\Pages;
use cms\models\ContentBlocks;

/**
 * This is the model class for table "{{%sections}}".
 *
 * @property int $id
 * @property int $page_id
 * @property string $name
 * @property int|null $order
 * @property int|null $is_deleted
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property ContentBlock[] $contentBlocks
 * @property Media[] $media
 * @property Page $page
 */
class PageSections extends \helpers\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sections}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_id', 'name'], 'required'],
            // [['page_id', 'order', 'is_deleted', 'created_at', 'updated_at'], 'default', 'value' => null],
            // [['page_id', 'order', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pages::class, 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'page_id' => Yii::t('app', 'Page ID'),
            'name' => Yii::t('app', 'Name'),
            'order' => Yii::t('app', 'Order'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[ContentBlocks]].
     *
     * @return \yii\db\ActiveQuery|ContentBlockQuery
     */
    public function getContentBlocks()
    {
        return $this->hasMany(ContentBlocks::class, ['section_id' => 'id']);
    }

    /**
     * Gets query for [[Media]].
     *
     * @return \yii\db\ActiveQuery|MediaQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::class, ['section_id' => 'id']);
    }

    /**
     * Gets query for [[Page]].
     *
     * @return \yii\db\ActiveQuery|PageQuery
     */
    public function getPage()
    {
        return $this->hasOne(Pages::class, ['id' => 'page_id']);
    }

    /**
     * {@inheritdoc}
     * @return PageSectionsQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new PageSectionsQuery(get_called_class());
    // }
}
