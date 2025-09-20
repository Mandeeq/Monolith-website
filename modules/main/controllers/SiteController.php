<?php

namespace main\controllers;

use Yii;
use yii\web\Response;
use qaffee\models\ContactForm;
class SiteController extends \helpers\WebController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(),  [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['index'],
                'formats' => [
                    'application/json' => Response::FORMAT_HTML,
                ],
            ],
        ]);
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'errors'
            ],
        ];
    }
    public function actionIndex()
    {
        //Yii::$app->session->setFlash('success', 'Link created successfully');
        return $this->render('index');
    }
   
    public function actionAbout()
    {
        //Yii::$app->session->setFlash('success', 'Link created successfully');
        return $this->render('about');
    }

     public function actionMenu()
    {
        //Yii::$app->session->setFlash('success', 'Link created successfully');
        return $this->render('menu');
    }
      public function actionBlog()
    {
        //Yii::$app->session->setFlash('success', 'Link created successfully');
        return $this->render('blog');
    }
    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $mailer = Yii::createObject([
                'class' => 'qaffee\hooks\Mail',
                'viewPath' => '@qaffee/templates/',
            ]);
            if ($mailer->sendContactEmail(
                $model->name,
                $model->email,
                $model->subject,
                $model->message
            )) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us! We will get back to you soon.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message. Please try again.');
            }
            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }
    public function actionTestMail()
{
    $mailer = Yii::createObject([
        'class' => 'qaffee\hooks\Mail',
        'viewPath' => '@qaffee/templates/',
    ]);
    $result = $mailer->sendContactEmail('Test User', 'test@example.com', 'Test Subject', 'This is a test message');
    return $result ? 'Email sent' : 'Email failed';
}
    public function actionDocs($mod = 'dashboard')
    {
        //$this->viewPath = '@swagger';
        return $this->render('docs', [
            'mod' => $mod
        ]);
    }
  
    public function actionJsonDocs($mod = 'dashboard')
    {
        $roothPath = Yii::getAlias('@webroot/');
        $openapi = \OpenApi\Generator::scan(
            [
                $roothPath . 'modules/' . $mod,
                $roothPath . 'providers/swagger/config',
            ]
        );
        Yii::$app->response->headers->set('Access-Control-Allow-Origin', ['*']);
        Yii::$app->response->headers->set('Content-Type', 'application/json');
        $file =  $roothPath . 'modules/dashboard/docs/' . $mod . '-openapi-json-resource.json';
        if (file_exists($file)) {
            unlink($file);
            file_put_contents($file, $openapi->toJson());
        } else {
            file_put_contents($file, $openapi->toJson());
        }
        Yii::$app->response->sendFile($file, false, ['mimeType' => 'json', 'inline' => true]);
        return true;
    }
}
