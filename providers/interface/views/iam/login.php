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
            <h1>Login</h1>
            <p class="account-subtitle">Access to your Account</p>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
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
                <div class="pass-group">
                    <?= $form->field($model, 'password')
                        ->passwordInput(['class' => 'form-control pass-input', 'placeholder' => 'Password', 'style' => 'font-size: 1.2rem',])
                        ->label(false) ?>
                    <span class="fas fa-eye toggle-password"></span>
                </div>
            </div>

            <div class="input-block mb-3">
                <div class="row">
                    <div class="col-6">
                        <?= Html::beginTag('div', ['class' => 'form-check custom-checkbox']) ?>
                        <?= Html::checkbox('rememberMe', false, ['class' => 'form-check-input', 'id' => 'cb1', 'style' => 'height: 1.2rem; width: 1.2rem']) ?>
                        <?= Html::label('Remember me', 'cb1', ['class' => 'custom-control-label', 'style' => 'font-size: 1.2rem']) ?>
                        <?= Html::endTag('div') ?>
                    </div>
                    <div class="col-6 text-end">
                        <?= Html::a('Forgot Password ?', \yii\helpers\Url::to(['iam/forgot-password'], true), ['class' => 'forgot-link']) ?>

                    </div>
                </div>
            </div>
            <?= Html::submitButton(
                '<i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i> Login',
                [
                    'class' => 'btn btn-lg w-100 text-center',
                    'style' => 'background: #FA2837;',
                    'type' => 'submit'
                ]
            ) ?>
            <div class="text-center dont-have">
                Don't have an account yet?
                <?= Html::a('Register', ['iam/register']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>