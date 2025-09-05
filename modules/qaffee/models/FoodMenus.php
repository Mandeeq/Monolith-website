<?php

namespace qaffee\models;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use Yii;

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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'food_menus';
    }

    /**
     * {@inheritdoc}
     */
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
               [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            [['image'], 'string', 'max' => 255], 
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

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(MenuCategories::class, ['id' => 'category_id']);
    }

public function uploadImage()
{
    if ($this->imageFile === null) {
        return true; // No file to upload, nothing to do
    }

    $uploadDir = Yii::getAlias('@webroot/uploads/menus/');
    $relativeDir = '/uploads/menus/';
    Yii::error('Upload dir: ' . $uploadDir);

    // Check if the directory exists and create it if not
    if (!is_dir($uploadDir)) {
        try {
            FileHelper::createDirectory($uploadDir, 0775, true);
            // Set permissions after creation (in case umask interferes)
            chmod($uploadDir, 0775);
        } catch (\yii\base\Exception $e) {
            Yii::error('Failed to create upload directory: ' . $e->getMessage());
            return false;
        }
    }

    // Generate a unique filename to prevent overwrites
    $fileName = Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
    $filePath = $uploadDir . $fileName;

    // Save the uploaded file to the new path
    if ($this->imageFile->saveAs($filePath)) {
        // Optionally set file permissions
        chmod($filePath, 0664);
        $this->image = $relativeDir . $fileName;
        Yii::error('Image uploaded successfully: ' . $filePath);
        return true;
    } else {
        Yii::error('Failed to save uploaded image file.');
        return false;
    }
}
//      public function uploadImage()
//     {
//         // if ($this->validate()) {
//         //     if ($this->imageFile) {
//         //         $fileName = Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
//         //         $filePath = Yii::getAlias('@webroot/uploads/menus/') . $fileName;
                
//         //         if ($this->imageFile->saveAs($filePath)) {
//         //             $this->image = '/uploads/menus/' . $fileName;
//         //             return true;
//         //         }
//         //     }
//         // }
//         // return false;
//          // Check if an image file was provided
//         if ($this->imageFile === null) {
//             return true; // No file to upload, nothing to do
//         }

//         // Define the upload path
//         $uploadDir = Yii::getAlias('@webroot/uploads/menus/');
//         $relativeDir = '/uploads/menus/';
//          Yii::error('Upload dir: ' . $uploadDir);
//         // Check if the directory exists and create it if not
//         if (!is_dir($uploadDir)) {
//             try {
//                 FileHelper::createDirectory($uploadDir);
//             } catch (\yii\base\Exception $e) {
//                 // Log the error and return false if directory creation fails
//                 Yii::error('Failed to create upload directory: ' . $e->getMessage());
//                 return false;
//             }
//         }

//         // Generate a unique filename to prevent overwrites
//         $fileName = Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
//         $filePath = $uploadDir . $fileName;

//         // Save the uploaded file to the new path
//         if ($this->imageFile->saveAs($filePath)) {
//             // Update the model's 'image' attribute with the relative path
//             $this->image = $relativeDir . $fileName;
//             return true;
//         } else {
//             // Log the error if the file could not be saved
//             Yii::error('Failed to save uploaded image file.');
//             return false;
//         }
    
// }


}
