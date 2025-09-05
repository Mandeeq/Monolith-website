<?php

use helpers\Html;
use helpers\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var qaffee\models\MenuCategories $model */
/** @var helpers\widgets\ActiveForm $form */
?>

<div class="menu-categories-form">
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);?>
    <div class="row">
        <div class="col-md-12">
          <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'display_order')->textInput(['type' => 'number']) ?>
        </div>
   
    </div>
    <div class="block-content block-content-full text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
