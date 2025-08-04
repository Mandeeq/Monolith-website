<?php

namespace crm\controllers;

use Yii;
use crm\models\SupportTicket;
use crm\models\searches\SupportTicketSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * SupportTicketController implements the CRUD actions for SupportTicket model.
 */
class SupportTicketController extends DashboardController
{
    public $layout = 'main';

    public $permissions = [
        'crm-support-ticket-list' => 'View SupportTicket List',
        'crm-support-ticket-create' => 'Add SupportTicket',
        'crm-support-ticket-update' => 'Edit SupportTicket',
        'crm-support-ticket-delete' => 'Delete SupportTicket',
        'crm-support-ticket-restore' => 'Restore SupportTicket',
    ];
    public function actionIndex()
    {
        Yii::$app->user->can('crm-support-ticket-list');
        $searchModel = new SupportTicketSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('crm-support-ticket-create');
        $model = new SupportTicket();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'SupportTicket created successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionUpdate($id)
    {
        Yii::$app->user->can('crm-support-ticket-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'SupportTicket updated successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionTrash($id)
    {
        $model = $this->findModel($id);
        if ($model->is_deleted) {
            Yii::$app->user->can('crm-support-ticket-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'SupportTicket has been restored');
        } else {
            Yii::$app->user->can('crm-support-ticket-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'SupportTicket has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = SupportTicket::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
