<?php

namespace qaffee\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "banners".
 *
 * @property int $id
 * @property string $title
 * @property string $image
 * @property string|null $link
 * @property bool|null $status
 * @property int|null $is_deleted
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Banners extends \yii\db\ActiveRecord
{
    /** @var UploadedFile */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banners';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['link', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['is_deleted'], 'default', 'value' => 0],

            // Required fields
            [['title'], 'required'],

            // DB field types
            [['status'], 'boolean'],
            [['is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['title', 'image', 'link'], 'string', 'max' => 255],

            // Upload validation
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    /**
     * Handles file upload and sets $this->image
     */
  public function uploadImage()
{
    if ($this->imageFile) {
        $path = Yii::getAlias('@webroot/uploads/banners/');
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $fileName = uniqid() . '.' . $this->imageFile->extension;
        $fullPath = $path . $fileName;

        if ($this->imageFile->saveAs($fullPath)) {
            // Save only the relative path/filename in DB
            $this->image = 'uploads/banners/' . $fileName;
            return true;
        }
        return false;
    }
    return true; // allow save if no new image uploaded
}

    /**
     * Automatically set created_at and updated_at
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $time = time();
            if ($this->isNewRecord) {
                $this->created_at = $time;
            }
            $this->updated_at = $time;
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'image' => 'Image',
            'link' => 'Link',
            'status' => 'Status',
            'is_deleted' => 'Is Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'imageFile' => 'Upload Image',
        ];
    }
}
