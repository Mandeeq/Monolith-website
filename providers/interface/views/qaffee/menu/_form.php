<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use qaffee\models\MenuCategories;

/** @var yii\web\View $this */
/** @var qaffee\models\FoodMenus $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="food-menus-form">

    <?php $form = ActiveForm::begin(['options' =>
     ['enctype' => 'multipart/form-data',
       'data-pjax' => true]]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map(MenuCategories::find()->all(), 'id', 'name'),
        ['prompt' => 'Select a category']
    ) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>
    
    <?php if ($model->image): ?>
        <div class="form-group">
            <?= Html::img($model->image, ['class' => 'img-thumbnail', 'style' => 'width: 200px;']) ?>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'is_available')->checkbox() ?>

    <?= $form->field($model, 'display_order')->textInput(['type' => 'number']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>