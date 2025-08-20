<?php

use helpers\Html;
use helpers\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var crm\models\Reviews $model */
/** @var helpers\widgets\ActiveForm $form */
?>

<div class="reviews-form">
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);?>
    <div class="row">
        <div class="col-md-12">
          <?= $form->field($model, 'customer_id')->textInput() ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'order_id')->textInput() ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'rating')->textInput() ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'review_text')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'status')->textInput() ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'created_at')->textInput() ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'updated_at')->textInput() ?>
        </div>
    </div>
    <div class="block-content block-content-full text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
