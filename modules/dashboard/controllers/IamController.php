<?php

namespace dashboard\controllers;

use Yii;
use auth\models\static\Login;
use auth\models\static\Register;
use auth\models\static\PasswordReset;
use auth\models\static\PasswordResetRequest;
use auth\models\User;

class IamController extends \helpers\DashboardController
{
	public function actionLogin()
	{
		$this->layout = 'auth2';
		$model = new Login();
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack(['/dashboard']);
		}

		$model->password = '';
		return $this->render('login', [
			'model' => $model,
		]);
	}

	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}


	public function actionRegister()
	{
		$this->layout = 'auth2';
		$model = new Register();

		if (Yii::$app->request->isPost) {
			if ($model->load(Yii::$app->request->post())) {
				if ($model->save()) {
					Yii::$app->session->setFlash('success', 'Account created successfully. Please check your email to verify your account.');
					return $this->redirect(['iam/login']);
				}
			}
		}
		return $this->render('register', [
			'model' => $model
		]);
	}


	public function actionForgotPassword()
	{
		$this->layout = 'auth2';
		$model = new PasswordResetRequest();
		$dataRequest = Yii::$app->request->post();

		if ($model->load($dataRequest) && $model->validate()) {
			if ($model->sendEmail()) {
				Yii::$app->session->setFlash('success', 'Password reset link has been sent to your email');
				return $this->redirect(['iam/login']);
			} else {
				Yii::$app->session->setFlash('success', 'Unable to send password reset email. Please try again later.');
			}
		}

		return $this->render('forgot_password', [
			'model' => $model
		]);
	}



	// public function actionResetPassword($token)
	// {
	// 	$this->layout = 'auth';

	// 	if (!$token) {
	// 		Yii::$app->session->setFlash('error', 'Invalid password reset link, missing password reset token');
	// 		return $this->render('password_reset', ['model' => new PasswordReset()]);
	// 	}

	// 	$validationResult = $this->validateAndFetchUserByToken($token);
	// 	$model = new PasswordReset();

	// 	if (isset($validationResult['error'])) {
	// 		Yii::$app->session->setFlash('error', $validationResult['error']);
	// 		return $this->render('password_reset', ['model' => new PasswordReset()]);
	// 	}


	// 	if ($model->load(Yii::$app->request->post()) && $model->resetPassword()) {
	// 		Yii::$app->session->setFlash('success', 'Password updated successfully');
	// 		return $this->redirect(['iam/login']);
	// 	}

	// 	return $this->render('password_reset', ['model' => $model]);
	// }
	public function actionResetPassword($token)
	{
		$this->layout = 'auth';

		if (!$token) {
			Yii::$app->session->setFlash('error', 'Invalid password reset link, missing password reset token');
			return $this->render('password_reset', ['model' => new PasswordReset()]);
		}

		$validationResult = $this->validateAndFetchUserByToken($token);

		if (isset($validationResult['error'])) {
			Yii::$app->session->setFlash('error', $validationResult['error']);
			return $this->render('password_reset', ['model' => new PasswordReset()]);
		}

		$user = $validationResult['user'];
		$tokenModel = $validationResult['token'];

		// Pass user and token to the model
		$model = new PasswordReset($user, $tokenModel);

		if ($model->load(Yii::$app->request->post()) && $model->resetPassword()) {
			Yii::$app->session->setFlash('success', 'Password updated successfully');
			return $this->redirect(['iam/login']);
		}

		return $this->render('password_reset', ['model' => $model]);
	}



	public function actionEmailVerification($token)
	{
		// return $token;

		$token = \auth\models\Tokens::findOne(['token' => $token]);

		if ($token === null) {
			Yii::$app->session->setFlash('error', 'Invalid or expired verification token.');
			return $this->redirect(['iam/login']);
		}


		$user = User::findOne(['user_id' => $token->user_id]);

		$user->status = User::STATUS_ACTIVE;
		// $user->verification_token = null;
		$user->save(false);

		$token->token = '';
		$token->save(false);

		Yii::$app->session->setFlash('success', 'Your email has been verified! You can now log in.');
		return $this->redirect(['iam/login']);
	}


	public function actionMe()
	{
		$user = Yii::$app->user->identity;
		if (!$user) {
			return $this->errorResponse(['errorMassage' => ['You must be logged in to view your profile']]);
		}

		if (Yii::$app->request->isPut) {
			$profile = $user->profile;
			$dataRequest = Yii::$app->request->getBodyParams();

			if ($profile->load($dataRequest, '')) {
				if (!$profile->validate()) {
					return $this->errorResponse($profile->getErrors());
				}

				if ($profile->save(false)) {
					return $this->payloadResponse(['message' => 'Profile updated successfully', 'profile' => $profile], ['statusCode' => 200]);
				} else {
					return $this->errorResponse(['errorMassage' => ['Failed to update profile']]);
				}
			} else {
				return $this->errorResponse(['errorMassage' => ['Failed to load profile data']]);
			}
		}

		return $this->payloadResponse($user->profile, ['statusCode' => 201]);
	}

	private function validateAndFetchUserByToken($token)
	{
		if (!$token) {
			return ['error' => 'Password reset token cannot be blank.'];
		}

		$get_token = \auth\models\Tokens::findOne([
			'token' => $token,
			'token_type' => 'password_reset_token'
		]);

		if (!$get_token || !$this->isPasswordResetTokenValid($token)) {
			return ['error' => 'Invalid or expired password reset token.'];
		}

		$user = User::findOne([
			'user_id' => $get_token->user_id,
			'status' => User::STATUS_ACTIVE
		]);

		if (!$user) {
			return ['error' => 'User associated with this token was not found or is inactive.'];
		}

		return [
			'user' => $user,
			'token' => $get_token
		];
	}

	public function isPasswordResetTokenValid($token)
	{
		$timestamp = (int) substr($token, strrpos($token, '_') + 1);
		$expire = Yii::$app->params['user.passwordResetTokenExpire'];
		return $timestamp + $expire >= time();
	}
}
