<?php

use helpers\Html;
use helpers\widgets\ActiveForm;

/** @var yii\web\View $this */

$basePath = Yii::$app->request->baseUrl . '/providers/interface/assets/site/';

?>

<?= Html::a(Html::img($basePath . 'logo_pic.png', [
    'class' => 'img-fluid logo-dark mb-2 logo-color',
    'style' => 'width: 170px !important; height: 170px !important; border-radius: 50% !important;',
    'alt' => 'Logo'
]), ['/frontend/site']) ?>

<div class="loginbox">
    <div class="login-right">
        <div class="login-right-wrap">
            <h1>Sign Up</h1>
            <p class="account-subtitle">Access to your Account</p>
            <?php $form = ActiveForm::begin(['id' => 'register-form', 'action' => ['register'], 'method' => 'post', 'enableClientValidation' => true,]); ?>
            <div class="input-block mb-3">
                <?= $form->field($model, 'username')
                    ->textInput([
                        'autofocus' => true,
                        'class' => 'form-control',
                        'style' => 'font-size: 1.2rem',
                        'placeholder' => 'Username'
                    ])
                    ->label(false) ?>
            </div>
            <div class="input-block mb-3">
                <?= $form->field($model, 'email_address')
                    ->textInput([
                        'autofocus' => true,
                        'class' => 'form-control',
                        'style' => 'font-size: 1.2rem',
                        'placeholder' => 'Email'
                    ])
                    ->label(false) ?>
            </div>
            <div class="input-block mb-3">
                <?= $form->field($model, 'mobile_number')
                    ->textInput([
                        'autofocus' => true,
                        'class' => 'form-control',
                        'style' => 'font-size: 1.2rem',
                        'placeholder' => 'Mobile number'
                    ])
                    ->label(false) ?>
            </div>
            <div class="input-block mb-3">
                <div class="pass-group">
                    <?= $form->field($model, 'password')
                        ->passwordInput(['class' => 'form-control pass-input', 'placeholder' => 'Password', 'style' => 'font-size: 1.2rem',])
                        ->label(false) ?>
                    <span class="fas fa-eye toggle-password"></span>
                </div>
            </div>
            <div class="input-block mb-3">
                <div class="pass-group">
                    <?= $form->field($model, 'confirm_password')
                        ->passwordInput(['class' => 'form-control pass-input', 'placeholder' => 'Comfirm Password', 'style' => 'font-size: 1.2rem',])
                        ->label(false) ?>
                    <span class="fas fa-eye toggle-password"></span>
                </div>
            </div>


            <?= Html::submitButton(
                'Sign In',
                [
                    'class' => 'btn btn-lg w-100 text-center',
                    'style' => 'background: #FA2837;',
                    'type' => 'submit'
                ]
            ) ?>
            <div class="text-center dont-have">
                Already have an account ?
                <?= Html::a('Login', ['login']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$js = <<<JS
document.getElementById('register-form').addEventListener('submit', function(e) {
    console.log('Form submitted!'); // Check browser console
});
JS;
$this->registerJs($js);
?>