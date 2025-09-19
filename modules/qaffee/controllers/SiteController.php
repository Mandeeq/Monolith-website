<?php 
namespace qaffee\controllers;
use yii;
use yii\web\Response;
use qaffee\models\AboutSections;

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
        // If you expect one "about" section
        $about = AboutSections::find()->orderBy(['order' => SORT_ASC])->one();

        // If you expect multiple sections
        // $about = AboutSections::find()->orderBy(['order' => SORT_ASC])->all();

        return $this->render('about', [
            'about' => $about,
        ]);
    }

    public function actionContact()
    {
        $this->view->title = 'Contact Us';
        return $this->render('contact');
    }
}