<?php

namespace crm\controllers;

use Yii;
use crm\models\OrderHistory;
use crm\models\searches\OrderHistorySearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * OrderHistoryController implements the CRUD actions for OrderHistory model.
 */
class OrderHistoryController extends DashboardController
{
    public $layout = 'main';
    public $permissions = [
        'crm-order-history-list' => 'View OrderHistory List',
        'crm-order-history-create' => 'Add OrderHistory',
        'crm-order-history-update' => 'Edit OrderHistory',
        'crm-order-history-delete' => 'Delete OrderHistory',
        'crm-order-history-restore' => 'Restore OrderHistory',
    ];
    public function actionIndex()
    {
        // Yii::$app->user->can('crm-order-history-list');
        $searchModel = new OrderHistorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('crm-order-history-create');
        $model = new OrderHistory();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'OrderHistory created successfully');
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
        Yii::$app->user->can('crm-order-history-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'OrderHistory updated successfully');
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
            Yii::$app->user->can('crm-order-history-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'OrderHistory has been restored');
        } else {
            Yii::$app->user->can('crm-order-history-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'OrderHistory has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = OrderHistory::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
