<?php 
namespace qaffee\controllers;
use yii;
use yii\web\Response;
use qaffee\models\AboutSections;
use qaffee\models\ContactForm;
use qaffee\hooks\Mail;

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
}