<?php

use helpers\Html;
use helpers\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var crm\models\Cart $model */
/** @var helpers\widgets\ActiveForm $form */
?>

<div class="cart-form">
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);?>
    <div class="row">
        <div class="col-md-12">
          <?= $form->field($model, 'user_id')->textInput() ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'created_at')->textInput() ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'updated_at')->textInput() ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'is_deleted')->textInput() ?>
        </div>
    </div>
    <div class="block-content block-content-full text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
