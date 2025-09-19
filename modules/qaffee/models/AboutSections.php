<?php

namespace qaffee\models;

use Yii;

/**
 * This is the model class for table "about_sections".
 *
 * @property int $id
 * @property string $title
 * @property string|null $content
 * @property string|null $image
 * @property int|null $order
 * @property int $created_at
 * @property int $updated_at
 */
class AboutSections extends \yii\db\ActiveRecord
{

    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'about_sections';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'image'], 'default', 'value' => null],
            [['order'], 'default', 'value' => 0],
            [['title', 'created_at', 'updated_at'], 'required'],
            [['content'], 'string'],
            [['order', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['order', 'created_at', 'updated_at'], 'integer'],
            [['title', 'image'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 2],

        ];
    }
      public function uploadImage()
{
    if ($this->imageFile) {
        $path = Yii::getAlias('@webroot/uploads/about_section/');
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $fileName = uniqid() . '.' . $this->imageFile->extension;
        $fullPath = $path . $fileName;

        if ($this->imageFile->saveAs($fullPath)) {
            // Save only the relative path/filename in DB
            $this->image = 'uploads/about_section/' . $fileName;
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
            'content' => 'Content',
            'image' => 'Image',
            'order' => 'Order',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
