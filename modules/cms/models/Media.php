<?php

namespace cms\models;

use Yii;
use cms\models\PageSections;
use cms\models\Pages;

/**
 * This is the model class for table "{{%media}}".
 *
 * @property int $id
 * @property int|null $page_id
 * @property int|null $section_id
 * @property string $file_path
 * @property string|null $alt_text
 * @property int|null $is_deleted
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Page $page
 * @property Section $section
 */
class Media extends \helpers\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%media}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_id', 'section_id'], 'default', 'value' => null],
            [['page_id', 'section_id'], 'integer'],
            [['file_path'], 'required'],
            [['file_path', 'alt_text'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pages::class, 'targetAttribute' => ['page_id' => 'id']],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => PageSections::class, 'targetAttribute' => ['section_id' => 'id']],
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
            'section_id' => Yii::t('app', 'Section ID'),
            'file_path' => Yii::t('app', 'File Path'),
            'alt_text' => Yii::t('app', 'Alt Text'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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
     * Gets query for [[Section]].
     *
     * @return \yii\db\ActiveQuery|SectionQuery
     */
    public function getSection()
    {
        return $this->hasOne(PageSections::class, ['id' => 'section_id']);
    }

    /**
     * {@inheritdoc}
     * @return MediaQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new MediaQuery(get_called_class());
    // }
}
