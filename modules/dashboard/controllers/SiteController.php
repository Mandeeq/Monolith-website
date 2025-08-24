<?php

namespace dashboard\controllers;

use Yii;
use yii\web\Response;

class SiteController extends \helpers\DashboardController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['index'],
                'formats' => [
                    'text/html' => Response::FORMAT_HTML,
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionDocs($mod = 'dashboard')
    {
        return $this->render('docs', [
            'mod' => $mod,
        ]);
    }

    public function actionJsonDocs($mod = 'dashboard')
    {
        $roothPath = Yii::getAlias('@webroot/');
        $openapi = \OpenApi\Generator::scan([
            $roothPath . 'modules/' . $mod,
            $roothPath . 'providers/swagger/config',
        ]);

        Yii::$app->response->headers->set('Access-Control-Allow-Origin', '*');
        Yii::$app->response->headers->set('Content-Type', 'application/json');

        $file = $roothPath . 'modules/dashboard/docs/' . $mod . '-openapi-json-resource.json';

        file_put_contents($file, $openapi->toJson());

        return Yii::$app->response->sendFile(
            $file,
            null,
            ['mimeType' => 'application/json', 'inline' => true]
        );
    }
}
