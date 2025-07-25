<?php

namespace cms\models;

use Yii;

/**
 * This is the model class for table "{{%content_blocks}}".
 *
 * @property int $id
 * @property int $section_id
 * @property string $type
 * @property string $content
 * @property int|null $order
 * @property int|null $is_deleted
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Section $section
 */
class ContentBlocks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%content_blocks}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['section_id', 'type', 'content'], 'required'],
            [['section_id', 'order', 'is_deleted', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['section_id', 'order', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['type'], 'string', 'max' => 255],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::class, 'targetAttribute' => ['section_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'section_id' => Yii::t('app', 'Section ID'),
            'type' => Yii::t('app', 'Type'),
            'content' => Yii::t('app', 'Content'),
            'order' => Yii::t('app', 'Order'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Section]].
     *
     * @return \yii\db\ActiveQuery|SectionQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::class, ['id' => 'section_id']);
    }

    /**
     * {@inheritdoc}
     * @return ContentBlocksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContentBlocksQuery(get_called_class());
    }
}
