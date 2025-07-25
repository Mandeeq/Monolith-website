<?php

use helpers\Html;
use helpers\widgets\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */

$basePath = Yii::$app->request->baseUrl . '/providers/interface/assets/site/';

?>

<div class="main-wrapper login-body">
    <div class="login-wrapper">
        <div class="container">

            <?= Html::img($basePath . 'logo_pic.png', [
                'class' => 'img-fluid logo-dark mb-2 logo-color',
                'style' => 'width: 170px !important; height: 170px !important; border-radius: 50% !important;',
                'alt' => 'Logo'
            ]) ?>
            <div class="loginbox">
                <div class="login-right">
                    <div class="login-right-wrap">
                        <h1>Forgot Password?</h1>
                        <p class="account-subtitle">Enter your email to get a password reset link</p>

                        <!-- Form -->
                        <?php $form = ActiveForm::begin(['id' => 'pfr-form']); ?>
                        <div class="input-block mb-3">
                            <label class="form-control-label">Email Address</label>
                            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control', 'placeholder' => 'Username or Email'])->label(false) ?>
                        </div>
                        <div class="input-block mb-0">
                            <?= Html::submitButton('Reset Password', ['class' => 'btn btn-lg btn-danger w-100']) ?>

                        </div>
                        <?php ActiveForm::end(); ?>

                        <div class="text-center dont-have">Remember your password? <a href="<?= Url::to('login') ?>">Login</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>