<?php 
namespace qaffee\controllers;
use yii;
use yii\web\Response;

class SiteController extends \helpers\WebController
{
    public $layout = 'index';
    public function getViewPath()
    {
        return Yii::getAlias('providers/interface/views/qaffee/site');
    }

    public function actionIndex()
    {
        $this->view->title = 'Welcome to Qaffee';
        return $this->render('index');
    }

    public function actionAbout()
    {
        $this->view->title = 'About Us';
        return $this->render('about');
    }

    public function actionContact()
    {
        $this->view->title = 'Contact Us';
        return $this->render('contact');
    }
}