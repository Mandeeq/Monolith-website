<?php

namespace qaffee\controllers;

use Yii;
use qaffee\models\ContactMessages;
use qaffee\models\searches\ContactMessagesSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * ContactMessagesController implements the CRUD actions for ContactMessages model.
 */
class Contact_messagesController extends DashboardController
{
    public function getViewPath()
    {
        return Yii::getAlias('@app/providers/interface/views/qaffee/contact_messages');
    }
    public $permissions = [
        'qaffee-contact-messages-list'=>'View ContactMessages List',
        'qaffee-contact-messages-create'=>'Add ContactMessages',
        'qaffee-contact-messages-update'=>'Edit ContactMessages',
        'qaffee-contact-messages-delete'=>'Delete ContactMessages',
        'qaffee-contact-messages-restore'=>'Restore ContactMessages',
        ];
    public function actionIndex()
    {
        // Yii::$app->user->can('qaffee-contact-messages-list');
        $searchModel = new ContactMessagesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
);
    }
    public function actionCreate()
    {
        // Yii::$app->user->can('qaffee-contact-messages-create');
        $model = new ContactMessages();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'ContactMessages created successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }
        if ($this->request->isAjax) {
            return $this->renderAjax('create', ['model' => $model]);
        } else {
          

        return $this->render('create', ['model' => $model]);
        }

    }
    public function actionUpdate($id)
    {
        // Yii::$app->user->can('qaffee-contact-messages-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'ContactMessages updated successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        }
        if ($this->request->isAjax) {
            return $this->renderAjax('update', ['model' => $model]);
        } else {
            return $this->render('update', ['model' => $model]);
        }
      
    }
    public function actionTrash($id)
    {
        $model = $this->findModel($id);
        if ($model->is_deleted) {
            // Yii::$app->user->can('qaffee-contact-messages-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'ContactMessages has been restored');
        } else {
            // Yii::$app->user->can('qaffee-contact-messages-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'ContactMessages has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = ContactMessages::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
