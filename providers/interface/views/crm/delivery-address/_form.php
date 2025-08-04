<?php

use helpers\Html;
use helpers\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var crm\models\DeliveryAddress $model */
/** @var helpers\widgets\ActiveForm $form */
?>

<div class="delivery-address-form">
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);?>
    <div class="row">
        <div class="col-md-12">
          <?= $form->field($model, 'customer_id')->textInput() ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'is_default')->textInput() ?>
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
