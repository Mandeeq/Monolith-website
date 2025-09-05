<?php

namespace qaffee\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "food_menus".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property string|null $image
 * @property int $category_id
 * @property int|null $is_available
 * @property int|null $display_order
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property MenuCategories $category
 */
class FoodMenus extends \yii\db\ActiveRecord
{
    public $imageFile;

    public static function tableName()
    {
        return 'food_menus';
    }

    public function rules()
    {
        return [
            [['description', 'image', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['is_available'], 'default', 'value' => 1],
            [['display_order'], 'default', 'value' => 0],
            [['name', 'price', 'category_id'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['category_id', 'is_available', 'display_order', 'created_at', 'updated_at'], 'integer'],
            [['name', 'image'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuCategories::class, 'targetAttribute' => ['category_id' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'image' => 'Image',
            'category_id' => 'Category ID',
            'is_available' => 'Is Available',
            'display_order' => 'Display Order',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'imageFile' => 'Upload Image'
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(MenuCategories::class, ['id' => 'category_id']);
    }

  public function uploadImage()
{
    Yii::error('Starting uploadImage() function.', 'upload-debug');

    if ($this->imageFile === null) {
        Yii::error('Image file is null. Returning true.', 'upload-debug');
        return true;
    }

    $uploadPath = Yii::getAlias('@webroot/uploads/menus/');
    $relativeDir = '/uploads/menus/';
    // Log 2: Check the resolved directory path
    Yii::error('Resolved path: ' . $uploadPath, 'upload-debug');

    if (!is_dir($uploadPath)) {
        Yii::error('Directory does not exist. Attempting to create.', 'upload-debug');
        if (!mkdir($uploadPath, 0775, true) && !is_dir($uploadPath)) {
            // Log 3: Check if the folder creation failed
            Yii::error('Directory creation failed!', 'upload-debug');
            return false;
        }
        Yii::error('Directory created successfully.', 'upload-debug');
    }
    
    $fileName = Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
    $filePath = $uploadPath . $fileName;

    if ($this->imageFile->saveAs($filePath)) {
        $this->image = $relativeDir . $fileName;
        // Log 4: Confirm file save success
        Yii::error('File saved successfully to: ' . $filePath, 'upload-debug');
        return true;
    }

    // Log 5: Check if the final save failed
    Yii::error('File saveAs() method returned false.', 'upload-debug');
    return false;
}
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_at = time();
            }
            $this->updated_at = time();
            
            if (!$insert && $this->isAttributeChanged('image')) {
                $this->deleteOldImage();
            }
            return true;
        }
        return false;
    }
    
    public function afterDelete()
    {
        parent::afterDelete();
        $this->deleteOldImage();
    }

    protected function deleteOldImage()
    {
        $imagePath = $this->getOldAttribute('image');
        if ($imagePath && file_exists(Yii::getAlias('@webroot') . $imagePath)) {
            unlink(Yii::getAlias('@webroot') . $imagePath);
        }
    }
}