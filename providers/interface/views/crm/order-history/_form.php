<?php

use helpers\Html;
use helpers\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var crm\models\OrderHistory $model */
/** @var helpers\widgets\ActiveForm $form */
?>

<div class="order-history-form">
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);?>
    <div class="row">
        <div class="col-md-12">
          <?= $form->field($model, 'customer_id')->textInput() ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'order_number')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'product_id')->textInput() ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'quantity')->textInput() ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'unit_price')->textInput() ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'total_price')->textInput() ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'order_status')->textInput() ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'payment_status')->textInput() ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'ordered_at')->textInput() ?>
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
