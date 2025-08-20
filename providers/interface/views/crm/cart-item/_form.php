<?php

use helpers\Html;
use helpers\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var crm\models\CartItems $model */
/** @var helpers\widgets\ActiveForm $form */
$carts = ArrayHelper::map(\crm\models\Cart::find()->all(), 'id', 'id'); // Assuming Cart model has a 'status' attribute for display
?>

<div class="cart-items-form">
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);?>
    <div class="row">
        <div class="col-md-12">
          <?= $form->field($model, 'cart_id')->dropDownList($carts, ['prompt' => 'Select Cart']) ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'product_id')->textInput() ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'quantity')->textInput() ?>
        </div>
        <div class="col-md-12">
          <?= $form->field($model, 'price')->textInput() ?>
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
