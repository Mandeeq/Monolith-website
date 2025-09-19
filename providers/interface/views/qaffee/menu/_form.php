<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use qaffee\models\MenuCategories;

/** @var yii\web\View $this */
/** @var qaffee\models\FoodMenus $model */
/** @var yii\widgets\ActiveForm $form */

// Get the base URL for images
$baseUrl = Yii::$app->request->baseUrl;

// Register CSS
$css = <<<CSS
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background-color: #f5f7fa;
    color: #333;
    line-height: 1.6;
    padding: 20px;
}

.container {
    max-width: 1000px;
    margin: 0 auto;
    background: white;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

/* header {
    background: linear-gradient(135deg, #2c3e50, #4a6491);
    color: white;
    padding: 25px;
    text-align: center;
} */

header h1 {
    margin-bottom: 10px;
    font-size: 28px;
}

header p {
    opacity: 0.9;
}

.form-container {
    padding: 30px;
}

.form-section {
    margin-bottom: 30px;
}

.form-section h2 {
    color: #2c3e50;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #eaecef;
    font-size: 20px;
}

.form-row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -15px 20px;
}

.form-group {
    flex: 1 0 300px;
    padding: 0 15px;
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #2c3e50;
}

.control-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #2c3e50;
}

input, select, textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #dce1e6;
    border-radius: 6px;
    font-size: 16px;
    transition: all 0.3s;
}

input:focus, select:focus, textarea:focus {
    outline: none;
    border-color: #4a6491;
    box-shadow: 0 0 0 3px rgba(74, 100, 145, 0.2);
}

textarea {
    min-height: 120px;
    resize: vertical;
}

.image-upload {
    border: 2px dashed #dce1e6;
    border-radius: 6px;
    padding: 25px;
    text-align: center;
    transition: all 0.3s;
    cursor: pointer;
    position: relative;
}

.image-upload:hover {
    border-color: #4a6491;
}

.image-upload i {
    font-size: 40px;
    color: #7e8c9a;
    margin-bottom: 15px;
}

.image-upload p {
    color: #7e8c9a;
    margin-bottom: 15px;
}

.image-preview-container {
    margin-top: 20px;
    text-align: center;
}

.image-preview {
    max-width: 100%;
    max-height: 200px;
    border-radius: 6px;
    margin-bottom: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.remove-image {
    color: #e74c3c;
    cursor: pointer;
    font-weight: 600;
}

.remove-image:hover {
    text-decoration: underline;
}

.toggle-container {
    display: flex;
    align-items: center;
    margin-top: 25px;
}

.toggle-switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 30px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 34px;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

.toggle-switch input:checked + .toggle-slider {
    background-color: #4CAF50;
}

.toggle-switch input:checked + .toggle-slider:before {
    transform: translateX(30px);
}

.availability-text {
    margin-left: 15px;
    font-weight: 600;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 2px solid #eaecef;
}

button {
    padding: 12px 25px;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-submit {
    background: linear-gradient(135deg, #4CAF50, #2E7D32);
    color: white;
}

.btn-submit:hover {
    background: linear-gradient(135deg, #43A047, #1B5E20);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn-cancel {
    background: #f1f3f6;
    color: #7e8c9a;
}

.btn-cancel:hover {
    background: #e4e7eb;
}

.required {
    color: #e74c3c;
}

.help-block {
    color: #e74c3c;
    font-size: 14px;
    margin-top: 5px;
}

.field-foodmenus-is_available {
    margin-top: 20px;
}

.img-thumbnail {
    max-width: 200px;
    border-radius: 6px;
    margin-top: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.current-image {
    text-align: center;
    margin-top: 15px;
}

.keep-image {
    margin-top: 10px;
    display: flex;
    align-items: center;
}

.keep-image input {
    width: auto;
    margin-right: 8px;
}

@media (max-width: 768px) {
    .form-group {
        flex: 1 0 100%;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    button {
        width: 100%;
    }
}
CSS;

$this->registerCss($css);
?>

<div class="container">
    <header>
        <h1><i class="fas fa-utensils"></i> Hotel Menu Management</h1>
        <p>Add and update menu items for your hotel restaurant</p>
    </header>
    
    <div class="form-container">
        <?php $form = ActiveForm::begin(
            [
            'options' => [
                'enctype' => 'multipart/form-data',
                'data-pjax' => true,
                'id' => 'menu-form'
            ]
        ]); ?>
        
        <div class="form-section">
            <h2>Basic Information</h2>
            <div class="form-row">
                <div class="form-group">
                    <?= $form->field($model, 'name')->textInput([
                        'maxlength' => true, 
                        'placeholder' => 'Enter menu item name',
                        'class' => 'form-control'
                    ]) ?>
                </div>
                
                <div class="form-group">
                    <?= $form->field($model, 'category_id')->dropDownList(
                        ArrayHelper::map(MenuCategories::find()->all(), 'id', 'name'),
                        ['prompt' => 'Select a category', 'class' => 'form-control']
                    ) ?>
                </div>
            </div>
            
            <div class="form-group">
                <?= $form->field($model, 'description')->textarea([
                    'rows' => 6,
                    'placeholder' => 'Describe the menu item...',
                    'class' => 'form-control'
                ]) ?>
            </div>
        </div>
        
        <div class="form-section">
            <h2>Pricing & Availability</h2>
            <div class="form-row">
                <div class="form-group">
                    <?= $form->field($model, 'price')->textInput([
                        'maxlength' => true,
                        'type' => 'number',
                        'min' => 0,
                        'step' => 0.01,
                        'placeholder' => '0.00',
                        'class' => 'form-control'
                    ]) ?>
                </div>
                
                <div class="form-group">
                    <?= $form->field($model, 'display_order')->textInput([
                        'type' => 'number',
                        'min' => 0,
                        'value' => 0,
                        'placeholder' => '0',
                        'class' => 'form-control'
                    ]) ?>
                </div>
                
                <div class="form-group">
                    <label>Availability</label>
                    <div class="toggle-container">
                        <label class="toggle-switch">
                            <input type="checkbox" id="foodmenus-is_available" name="FoodMenus[is_available]" value="1" <?= $model->is_available ? 'checked' : '' ?>>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="availability-text" id="availabilityText"><?= $model->is_available ? 'Available' : 'Not Available' ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-section">
            <h2>Menu Image</h2>
            <div class="form-group">
                <label for="image">Upload Image</label>
                <div class="image-upload" id="imageUploadArea">
                    <?= $form->field($model, 'imageFile')->fileInput([
                        'accept' => 'image/*',
                        'id' => 'foodmenus-imagefile',
                        'class' => 'form-control-file'
                    ])->label(false) ?>
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>Click to upload or drag and drop</p>
                    <span>PNG, JPG, GIF up to 5MB</span>
                </div>
                
                <div class="image-preview-container" id="imagePreview" style="display: none;">
                    <img src="" class="image-preview" id="previewImage">
                    <div class="remove-image" id="removeImage">Remove Image</div>
                </div>
                
                <?php if ($model->image && !$model->isNewRecord): ?>
                    <div class="current-image">
                        <p>Current Image:</p>
                        <?= Html::img($baseUrl . $model->image, [
                            'class' => 'img-thumbnail', 
                            'id' => 'currentImage',
                            'onerror' => "this.style.display='none'"
                        ]) ?>
                        <div class="keep-image">
                            <input type="checkbox" id="keepImage" name="keepImage" checked>
                            <label for="keepImage">Keep current image</label>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="button" class="btn-cancel" onclick="history.back()">Cancel</button>
            <?= Html::submitButton('Save Menu Item', ['class' => 'btn-submit']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
// Toggle availability functionality
const availabilityToggle = document.getElementById('foodmenus-is_available');
const availabilityText = document.getElementById('availabilityText');

if (availabilityToggle) {
    availabilityToggle.addEventListener('change', function() {
        availabilityText.textContent = this.checked ? 'Available' : 'Not Available';
    });
}

// Image upload functionality
const imageUploadArea = document.getElementById('imageUploadArea');
const imageInput = document.getElementById('foodmenus-imagefile');
const imagePreview = document.getElementById('imagePreview');
const previewImage = document.getElementById('previewImage');
const currentImage = document.getElementById('currentImage');
const removeImage = document.getElementById('removeImage');
const keepImageCheckbox = document.getElementById('keepImage');

if (imageUploadArea && imageInput) {
    // Click to upload
    imageUploadArea.addEventListener('click', function(e) {
        // Don't trigger if clicking on the file input itself
        if (e.target !== imageInput) {
            imageInput.click();
        }
    });
    
    // Handle file selection
    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const fileName = file.name;
            
            // Update text
            imageUploadArea.querySelector('span').textContent = 'Selected: ' + fileName;
            
            // Preview image
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                imagePreview.style.display = 'block';
                
                // Hide current image if exists
                if (currentImage) {
                    currentImage.parentElement.style.display = 'none';
                }
                
                // Uncheck keep image checkbox
                if (keepImageCheckbox) {
                    keepImageCheckbox.checked = false;
                }
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Drag and drop for image upload
    imageUploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.borderColor = '#4a6491';
        this.style.backgroundColor = '#f5f7fa';
    });
    
    imageUploadArea.addEventListener('dragleave', function() {
        this.style.borderColor = '#dce1e6';
        this.style.backgroundColor = 'transparent';
    });
    
    imageUploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.borderColor = '#dce1e6';
        this.style.backgroundColor = 'transparent';
        
        if (e.dataTransfer.files.length) {
            imageInput.files = e.dataTransfer.files;
            const fileName = e.dataTransfer.files[0].name;
            imageUploadArea.querySelector('span').textContent = 'Selected: ' + fileName;
            
            // Trigger change event manually
            const event = new Event('change');
            imageInput.dispatchEvent(event);
        }
    });
}

// Remove image functionality
if (removeImage) {
    removeImage.addEventListener('click', function() {
        imageInput.value = '';
        imagePreview.style.display = 'none';
        imageUploadArea.querySelector('span').textContent = 'PNG, JPG, GIF up to 5MB';
        
        // Show current image again if it exists
        if (currentImage) {
            currentImage.parentElement.style.display = 'block';
        }
        
        // Check keep image checkbox
        if (keepImageCheckbox) {
            keepImageCheckbox.checked = true;
        }
    });
}

// Form submission
document.getElementById('menu-form').addEventListener('submit', function(e) {
    // You can add any additional validation here if needed
    console.log('Form submitted');
});
</script>