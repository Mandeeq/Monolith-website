<?php

namespace main\controllers;

use Yii;
use yii\web\Response;

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
        //Yii::$app->session->setFlash('success', 'Link created successfully');
        return $this->render('contact');
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
