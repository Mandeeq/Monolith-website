<?php

namespace crm\controllers;

use Yii;
use crm\models\SupportTickets;
use crm\models\searches\SupportTicketSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * SupportTicketsController implements the CRUD actions for SupportTickets model.
 */
class SupportTicketsController extends DashboardController
{
    public $permissions = [
        'crm-support-tickets-list'=>'View SupportTickets List',
        'crm-support-tickets-create'=>'Add SupportTickets',
        'crm-support-tickets-update'=>'Edit SupportTickets',
        'crm-support-tickets-delete'=>'Delete SupportTickets',
        'crm-support-tickets-restore'=>'Restore SupportTickets',
        ];
    public function actionIndex()
    {
        // Yii::$app->user->can('crm-support-tickets-list');
        $searchModel = new SupportTicketSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        // Yii::$app->user->can('crm-support-tickets-create');
        $model = new SupportTickets();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'SupportTickets created successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        Yii::$app->user->can('crm-support-tickets-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'SupportTickets updated successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionTrash($id)
    {
        $model = $this->findModel($id);
        if ($model->is_deleted) {
            Yii::$app->user->can('crm-support-tickets-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'SupportTickets has been restored');
        } else {
            Yii::$app->user->can('crm-support-tickets-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'SupportTickets has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = SupportTickets::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
